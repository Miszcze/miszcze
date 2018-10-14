<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Constant;
use AppBundle\Entity\Pracownicy;
use AppBundle\Entity\Uzytkownicy;
use AppBundle\Entity\Wiadomosci;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller{
    
    /**
     * @Route("/", name="homepage")
     */
    public function homepageAction(){

	if(AdminController::technicalBreak($this)) return $this->redirectToRoute('technical_break');
	UserController::countMessage($this);
	return $this->render('user/homepage.html.twig');
    }
    
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request){
	$entityManager=$this->getDoctrine()->getManager();
	$error=null;

	if($request->isMethod('post')){
	    $user=$entityManager->createQuery(
		    "SELECT u ".
		    "FROM AppBundle\Entity\Uzytkownicy u ".
		    "WHERE u.login='".$_POST['form']['login']."'"
		)
		->getResult();

	    if(!empty($user)){
		$passwordUser=$entityManager->createQuery(
			"SELECT h ".
			"FROM AppBundle\Entity\Hasla h ".
			"WHERE h.uzytkownik=".$user[0]->getId()
		    )
		    ->getResult();

		$saltConst=$entityManager->getRepository(Constant::class)->findOneBy(['name'=>'salt']);
		$hashConst=$entityManager->getRepository(Constant::class)->findOneBy(['name'=>'hash']);
		
		$formPassword=hash(
			$hashConst->getValue(),
			$passwordUser[0]->getSol().$_POST['form']['haslo'].
			$saltConst->getValue().$user[0]->getSol()
		    );
		
		if($formPassword==$passwordUser[0]->getHaslo()){
		    $session=$this->get('session');
		    $session->set('user',['user'=>$user[0]]);
		    
		    $admin=$entityManager->createQuery(
			"SELECT p ".
			"FROM AppBundle\Entity\Pracownicy p ".
			"WHERE p.uzytkownik=".$user[0]->getId()." AND p.role like '%dyrektor%'" 
		    )
		    ->getResult();
		    
		    if(!empty($admin)) $session->set('admin',['defined'=>true]);
		    
		    return $this->redirectToRoute('homepage');
		}
	    }

	    $error='błędny login lub hasło';
	}

	$form=$this->createFormBuilder()
	    ->setMethod('POST')
	    ->add('login',TextType::class)
	    ->add('haslo',PasswordType::class)
	    ->add('submit',SubmitType::class)
	    ->getForm();

	return $this->render('user/index.html.twig',[
		'form'=>$form->createView(),
		'error'=>$error
	]);
    }
        
    /**
     * @Route("/wyloguj", name="logout")
     */
    public function logoutAction(){
	$this->get('session')->remove('user');
	$this->get('session')->remove('admin');

	return $this->redirectToRoute('login');
    }
    
    /**
     * @Route("/messages/{id}", name="messages", defaults={"id"="0"})
     */
    public function messagesAction(Request $request,$id){
	UserController::countMessage($this);
	$entityManager=$this->getDoctrine()->getManager();
	$users=$entityManager->getRepository(Uzytkownicy::class)->findAll();
	
	$form=$this->createFormBuilder()
	    ->setMethod('POST')
	    ->add('tytul',TextType::class)
	    ->add('tresc',TextareaType::class)
	    ->add('zalacznik',FileType::class,['required'=>false])
	    ->add('submit',SubmitType::class)
	    ->getForm();

	if($request->isMethod('post')){
	    $form->handleRequest($request);
	   
	    $userSender=$entityManager
		->getRepository(Uzytkownicy::class)
		->find($this->get('session')->get('user')['user']->getId());
	    $userRecipient=$entityManager
		->getRepository(Uzytkownicy::class)
		->find($id);
	    
	    $messege=new Wiadomosci();
	    $messege->setTytul($form->get('tytul')->getData());
	    $messege->setTresc($form->get('tresc')->getData());
	    $messege->setNadawca($userSender);
	    $messege->setOdbiorca($userRecipient);
	    $messege->setStatusNadawcy(0);
	    $messege->setStatusOdbiorcy(0);
	    $messege->setOdczytana(0);
	    
	    if(!empty($form['zalacznik']->getData())){
		$directory=$this->get('kernel')->getRootDir().'/../web/upload/';
		$file=$form['zalacznik']->getData();
		$extension=$file->guessExtension();
		$fileNumber=1;
		while(file_exists($directory."file".$fileNumber.".".$extension)) 
		    $fileNumber++;
		$file->move($directory,$directory."file".$fileNumber.".".$extension);
		$messege->setZalacznik("file".$fileNumber.".".$extension);
	    }
	    
	    $entityManager->persist($messege);
	    $entityManager->flush();
	    
	    return $this->redirectToRoute('messages',['id'=>$id]);
	}
	
	$sessionUserId=$this->get('session')->get('user')['user']->getId();
	
	if($id==0)
	    $messages=$entityManager->createQuery(
		"SELECT w ".
		"FROM AppBundle\Entity\Wiadomosci w ".
		"JOIN AppBundle\Entity\Uzytkownicy u ".
		"WITH w.nadawca=u.id OR w.odbiorca=u.id ".
		"WHERE w.odbiorca=".$sessionUserId." AND w.odczytana=0"
		)
		->getResult();
	else
	    $messages=$entityManager->createQuery(
		"SELECT w ".
		"FROM AppBundle\Entity\Wiadomosci w ".
		"JOIN AppBundle\Entity\Uzytkownicy u ".
		"WITH w.nadawca=u.id OR w.odbiorca=u.id ".
		"WHERE ".
		"	(w.nadawca=".$sessionUserId." AND w.odbiorca=".$id." AND w.statusNadawcy=0) OR ".
		"	(w.odbiorca=".$sessionUserId." AND w.nadawca=".$id." AND w.statusOdbiorcy=0)"
		)
		->getResult();
	
	return $this->render('user/messages.html.twig',[
		'form'=>$form->createView(),
		'users'=>$users,
		'messages'=>$messages
	]);
    }
    
    /**
     * @Route("/message/{id}/{delete}/{idRoute}", name="message", 
     * defaults={"id"="0","delete"="0","idRoute"="0"})
     */
    public function messageAction($id,$delete,$idRoute){
	UserController::countMessage($this);
	$entityManager=$this->getDoctrine()->getManager();
	
	$sessionUserId=$this->get('session')->get('user')['user']->getId();
	
	if($delete==true){
	    $entityManager->createQuery(
	        "UPDATE AppBundle\Entity\Wiadomosci w ".
	        "SET w.statusNadawcy=1 ".
		"WHERE w.id=".$id." AND w.nadawca=".
		"   (SELECT u.id FROM AppBundle\Entity\Uzytkownicy u ".
		"   WHERE u.id=".$sessionUserId.")"
	    )
	    ->getResult();
	    
	    $entityManager->createQuery(
	        "UPDATE AppBundle\Entity\Wiadomosci w ".
	        "SET w.statusOdbiorcy=1 ".
		"WHERE w.id=".$id." AND w.odbiorca=".
		"   (SELECT u.id FROM AppBundle\Entity\Uzytkownicy u ".
		"   WHERE u.id=".$sessionUserId.")"
	    )
	    ->getResult();
	    
	    return $this->redirectToRoute('messages',['id'=>$idRoute]);
	}
	
	$entityManager->createQuery(
	        "UPDATE AppBundle\Entity\Wiadomosci w ".
	        "SET w.odczytana=1 ".
		"WHERE w.id=".$id
	    )
	    ->getResult();
	$message=$entityManager->getRepository(Wiadomosci::class)->find($id);
	
	if($message->getNadawca()->getId()==$sessionUserId || $message->getOdbiorca()->getId()==$sessionUserId)
	    return $this->render('user/message.html.twig',['message'=>$message]);
	else 
	    return $this->redirectToRoute('messages');
    }
    
    /**
     * @Route("/download/{file}/", name="download", defaults={"file"="0"})
     */
    public function downloadAction($file){
        return $this->file($this->get('kernel')->getRootDir().'/../web/upload/'.$file);
    }
    
    public function countMessage($controller){
	$entityManager=$controller->getDoctrine()->getManager();
	
	$sessionUserId=$controller->get('session')->get('user');
	if(isset($sessionUserId))
	    $sessionUserId=$controller->get('session')->get('user')['user']->getId();
	else 
	    $sessionUserId=0;
	
	$messages=$entityManager->createQuery(
	        "SELECT count(w.id) countMessages ".
		"FROM AppBundle\Entity\Wiadomosci w ".
		"JOIN AppBundle\Entity\Uzytkownicy u ".
		"WITH w.odbiorca=u.id ".
		"WHERE w.odbiorca=".$sessionUserId." AND w.odczytana=0"
	    )
	    ->getResult();
	
	if($messages[0]['countMessages']>0)
	    $controller->get('twig')->addGlobal('newMessages',$messages[0]['countMessages']);
    }
}
