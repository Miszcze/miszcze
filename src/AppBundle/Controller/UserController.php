<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Constant;
use AppBundle\Entity\Uzytkownicy;
use AppBundle\Entity\Wiadomosci;
use AppBundle\Utils\Message;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller{
    
    public function __construct(EntityManagerInterface $em){
	(new Message($em))->count();
    }
    
    /**
     * @Route("/", name="homepage")
     */
    public function homepageAction(){
	//sprawdzanie przerwy techicznej
	if(AdminController::technicalBreak($this)) return $this->redirectToRoute('technical_break',[],302);
	
	//tworzenie kominikatu info
	if($this->get('session')->has('info')){
	    $this->get('twig')->addGlobal('info',$this->get('session')->get('info'));
	    $this->get('session')->remove('info');
	}
	
	//utworzenie kominikatu danger
	if($this->get('session')->has('danger')){
	    $this->get('twig')->addGlobal('danger',$this->get('session')->get('danger'));
	    $this->get('session')->remove('danger');
	}
	
	return $this->render('user/homepage.html.twig');
    }
    
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request){
	$entityManager=$this->getDoctrine()->getManager();
	
	//sprawdzanie przerwy techicznej
	if(AdminController::technicalBreak($this)) return $this->redirectToRoute('technical_break',[],302);
	
	//tworzenie kominikatu info
	if($this->get('session')->has('info')){
	    $this->get('twig')->addGlobal('info',$this->get('session')->get('info'));
	    $this->get('session')->remove('info');
	}
	
	//utworzenie kominikatu danger
	if($this->get('session')->has('danger')){
	    $this->get('twig')->addGlobal('danger',$this->get('session')->get('danger'));
	    $this->get('session')->remove('danger');
	}

	//logowanie
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
		    //ustawienie w sesji użytkownika
		    $session=$this->get('session');
		    $session->set('user',['user'=>$user[0]]);
		    
		    $teacher=$entityManager->createQuery(
			"SELECT p ".
			"FROM AppBundle\Entity\Pracownicy p ".
			"WHERE p.uzytkownik=".$user[0]->getId()." AND p.role like '%nauczyciel%'" 
		    )
		    ->getResult();
		    
		    $classTeacher=$entityManager->createQuery(
			"SELECT p ".
			"FROM AppBundle\Entity\Pracownicy p ".
			"WHERE p.uzytkownik=".$user[0]->getId()." AND p.role like '%wychowawca%'" 
		    )
		    ->getResult();
		    
		    $admin=$entityManager->createQuery(
			"SELECT p ".
			"FROM AppBundle\Entity\Pracownicy p ".
			"WHERE p.uzytkownik=".$user[0]->getId()." AND p.role like '%dyrektor%'" 
		    )
		    ->getResult();
		    
		    //ustawienie w sesji ról użytkownika
		    if(!empty($admin)) $session->set('admin',true);
		    if(!empty($teacher)) $session->set('teacher',true);
		    if(!empty($classTeacher)) $session->set('classTeacher',true);
		     
		    $this->get('session')->set('info','Zalogowano.');
		    
		    return $this->redirectToRoute('homepage');
		}
	    }

	    $this->get('session')->set('danger','Błędny login lub hasło.');
	}

	$form=$this->createFormBuilder()
	    ->setMethod('POST')
	    ->add('login',TextType::class)
	    ->add('haslo',PasswordType::class)
	    ->add('submit',SubmitType::class)
	    ->getForm();

	return $this->render('user/index.html.twig',[
	    'form'=>$form->createView()
	]);
    }
        
    /**
     * @Route("/wyloguj", name="logout")
     */
    public function logoutAction(){
	//usuwanie sesji użytkownika
	$this->get('session')->remove('user');
	$this->get('session')->remove('student');
	$this->get('session')->remove('admin');
	$this->get('session')->remove('teacher');
	$this->get('session')->remove('classTeacher');
	
	$this->get('session')->set('info','Wylogowano.');

	return $this->redirectToRoute('login',[],201);
    }
    
    /**
     * @Route("/wiadomosci/{id}", name="messages", defaults={"id"="0"})
     */
    public function messagesAction(Request $request,$id){
	$entityManager=$this->getDoctrine()->getManager();
	
	//sprawdzanie przerwy techicznej
	if(AdminController::technicalBreak($this)) return $this->redirectToRoute('technical_break',[],302);
	
	//tworzenie kominikatu info
	if($this->get('session')->has('info')){
	    $this->get('twig')->addGlobal('info',$this->get('session')->get('info'));
	    $this->get('session')->remove('info');
	}
	
	//utworzenie kominikatu danger
	if($this->get('session')->has('danger')){
	    $this->get('twig')->addGlobal('danger',$this->get('session')->get('danger'));
	    $this->get('session')->remove('danger');
	}
	
	$users=$entityManager->getRepository(Uzytkownicy::class)->findAll();
	
	$form=$this->createFormBuilder()
	    ->setMethod('POST')
	    ->add('tytul',TextType::class)
	    ->add('tresc',TextareaType::class)
	    ->add('zalacznik',FileType::class,['required'=>false])
	    ->add('submit',SubmitType::class)
	    ->getForm();

	//wysyłanie wiadomości
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
	    
	    //upload załącznika
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
	    
	    $this->get('session')->set('info','Wysłano wiadomość.');
	    
	    return $this->redirectToRoute('messages',['id'=>$id],201);
	}
	
	$sessionUserId=$this->get('session')->get('user')['user']->getId();
	
	if($id==0)
	    $messages=$entityManager->createQuery(
		"SELECT w ".
		"FROM AppBundle\Entity\Wiadomosci w ".
		"JOIN AppBundle\Entity\Uzytkownicy u ".
		"WITH w.nadawca=u.id OR w.odbiorca=u.id ".
		"WHERE w.odbiorca=".$sessionUserId." AND w.odczytana=0 AND w.statusOdbiorcy=0" 
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
     * @Route("/wiadomosc/{id}/{delete}/{idRoute}", name="message", 
     * defaults={"id"="0","delete"="0","idRoute"="0"})
     */
    public function messageAction($id,$delete,$idRoute){
	$entityManager=$this->getDoctrine()->getManager();
	
	//sprawdzanie przerwy techicznej
	if(AdminController::technicalBreak($this)) return $this->redirectToRoute('technical_break',[],302);
	
	//tworzenie kominikatu info
	if($this->get('session')->has('info')){
	    $this->get('twig')->addGlobal('info',$this->get('session')->get('info'));
	    $this->get('session')->remove('info');
	}
	
	//utworzenie kominikatu danger
	if($this->get('session')->has('danger')){
	    $this->get('twig')->addGlobal('danger',$this->get('session')->get('danger'));
	    $this->get('session')->remove('danger');
	}
	
	$sessionUserId=$this->get('session')->get('user')['user']->getId();
	
	//usuwanie wiadomości
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
	    
	    $this->get('session')->set('info','Usunięto wiadomość.');
	    
	    return $this->redirectToRoute('messages',['id'=>$idRoute],201);
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
	    return $this->redirectToRoute('messages',[],302);
    }
    
    /**
     * @Route("/download/{file}/", name="download", defaults={"file"="0"})
     */
    public function downloadAction($file){
        return $this->file($this->get('kernel')->getRootDir().'/../web/upload/'.$file);
    }
}
