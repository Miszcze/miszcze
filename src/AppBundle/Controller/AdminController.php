<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Constant;
use AppBundle\Entity\GodzLek;
use AppBundle\Entity\Hasla;
use AppBundle\Entity\Klasy;
use AppBundle\Entity\Opiekunowie;
use AppBundle\Entity\Pracownicy;
use AppBundle\Entity\Przedmioty;
use AppBundle\Entity\Sale;
use AppBundle\Entity\SlownikPrzedmiotow;
use AppBundle\Entity\Terminarz;
use AppBundle\Entity\Uczniowie;
use AppBundle\Entity\Uzytkownicy;
use AppBundle\Utils\GenerateString;
use AppBundle\Utils\Message;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class AdminController extends Controller{
    
    public function __construct(EntityManagerInterface $em){
	//liczenie wiadomości do widoków
	(new Message($em))->count();
    }

    /**
     * @Route("/uzytkownicy/{formType}/{id}/{delete}", name="admin_users", 
     * defaults={"formType"="pracownik","id"="0","delete"="0"})
     */
    public function usersAction(Request $request,$formType,$id,$delete){
	$entityManager=$this->getDoctrine()->getManager();
	
	//sprawdzanie przerwy techicznej
	if(AdminController::technicalBreak($this)) return $this->redirectToRoute('technical_break',[],302);
	
	//sprawdzawdzanie czy użytkownik to admin
	if(!$this->get('session')->has('admin')){
	    $this->get('session')->set('danger','Nie jesteś adminem.');
	    return $this->redirectToRoute('homepage',[],302);
	}
	
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
	
	$errors=null;

	//tablice do formularzy
	$choicesRole=[
	    'nauczyciel'=>'nauczyciel',
	    'dyrektor'=>'dyrektor',
	    'sekretariat'=>'sekretariat',
	    'wychowawca'=>'wychowawca'
	];
	
	if($id==0) $disabledTyp=false;
	else $disabledTyp=true;

	//formularz uczeń
	if($formType=='uczen'){
	    $formValue=null;
	    if($id!=0){
		$formValue=$entityManager->createQuery(
		    "SELECT ".
		    "	u.typ,u.mail,uc.imie,uc.imie2,uc.nazwisko,uc.dataUrodzenia,uc.pesel,".
		    "	uc.miejscowosc,uc.ulica,uc.nrDomu,uc.poczta,uc.kontakt,uc.kodPocztowy ".
		    "FROM AppBundle\Entity\Uczniowie uc ".
		    "JOIN AppBundle\Entity\Uzytkownicy u ".
		    "WITH uc.uzytkownik=u.id ".
		    "WHERE u.status=0 AND uc.status=0 AND u.id='".$id."'"
		)
		->getResult();
		if(!empty($formValue)) $formValue=$formValue[0];
	    } 
	    
	    $form=$this->createFormBuilder($formValue)
		->setMethod('POST')
		->add('mail',EmailType::class)
		->add('imie',TextType::class)
		->add('imie2',TextType::class,['required'=>false])
		->add('nazwisko',TextType::class)
		->add('dataUrodzenia',DateType::class,['widget'=>'single_text'])
		->add('pesel',IntegerType::class)
		->add('miejscowosc',TextType::class)
		->add('ulica',TextType::class)
		->add('nrDomu',IntegerType::class)
		->add('kodPocztowy',TextType::class)
		->add('poczta',TextType::class)
		->add('kontakt',TextareaType::class,['required'=>false])
		->add('submit',SubmitType::class)
		->getForm();
	//formularz opiekun
	}else if($formType=='opiekun'){
	    $formValue=null;
	    if($id!=0){
		$formValue=$entityManager->createQuery(
		    "SELECT u.typ,u.mail,o.imie,o.nazwisko,o.kontakt ".
		    "FROM AppBundle\Entity\Opiekunowie o ".
		    "JOIN AppBundle\Entity\Uzytkownicy u ".
		    "WITH o.uzytkownik=u.id ".
		    "WHERE u.status=0 AND o.status=0 AND u.id='".$id."'"
		)
		->getResult();
		
		if(!empty($formValue)) $formValue=$formValue[0];
	    } 
	    
	    $students=$entityManager
		->getRepository(Uczniowie::class)
		->findBy(['opiekun'=>null]);
		
	    foreach($students as $value)
		$choicesStudent[$value->getImie().' '.$value->getNazwisko()]=$value->getId();
	    
	    $form=$this->createFormBuilder($formValue)
		->setMethod('POST')
		->add('mail',EmailType::class)
		->add('imie',TextType::class)
		->add('nazwisko',TextType::class)
		->add('uczen',ChoiceType::class,['choices'=>@$choicesStudent])
		->add('kontakt',TextareaType::class)
		->add('submit',SubmitType::class)
		->getForm();
	//formularz pracownik
	}else{
	    $formValue=null;
	    if($id!=0){
		$formValue=$entityManager->createQuery(
		    "SELECT u.typ,u.mail,p.imie,p.nazwisko,p.role,p.kontakt ".
		    "FROM AppBundle\Entity\Pracownicy p ".
		    "JOIN AppBundle\Entity\Uzytkownicy u ".
		    "WITH p.uzytkownik=u.id ".
		    "WHERE u.status=0 AND p.status=0 AND u.id='".$id."'"
		)
		->getResult();
		
		if(!empty($formValue)) $formValue=$formValue[0];
	    }
	    
	    $form=$this->createFormBuilder($formValue)
		->setMethod('POST')
		->add('mail',EmailType::class)
		->add('imie',TextType::class)
		->add('nazwisko',TextType::class)
		->add('role',ChoiceType::class,['choices'=>$choicesRole,'multiple'=>true])
		->add('kontakt',TextareaType::class,['required'=>false])
		->add('submit',SubmitType::class)
		->getForm();
	}
	
	$form->handleRequest($request);
	
	//dodawanie ucznia
	if($request->isMethod('post') && $formType=='uczen' && $id==0){
	    $errors='';
	
	    //sprawdzanie czy mail istnieje
	    $mail=$entityManager
		->getRepository(Uzytkownicy::class)
		->findOneBy(['mail'=>$form->get('mail')->getData()]);
	    
	    if(!empty($mail))
		$errors.='Mail: '.$form->get('mail')->getData().' już istnieje. ';
	    
	    //sprawdzanie czy pesel istnieje
	    $pesel=$entityManager
		->getRepository(Uczniowie::class)
		->findOneBy(['pesel'=>$form->get('pesel')->getData()]);
	    
	    if(!empty($pesel))
		$errors.='Pesel: '.$form->get('pesel')->getData().' już istnieje. ';
	    
	    if(!empty($errors)){
		$this->get('session')->set('danger',$errors);
	    }else{	    
		$createLogin='U'.$form->get('dataUrodzenia')->getData()->format('y')
		    .substr($form->get('imie')->getData(),0,2)
		    .substr($form->get('nazwisko')->getData(),0,2);

		//sprawdzanie czy login istnieje
		$nr='';
		while(1){
		    $checkLogin=$entityManager
			->getRepository(Uzytkownicy::class)
			->findOneBy(['login'=>$createLogin.$nr]);

		    if(empty($checkLogin)){
			$createLogin=$createLogin.$nr;
			break;
		    }
		    else $nr++;
		}
	    
		$saltUser=new GenerateString(5);
		$user=new Uzytkownicy();
		$user->setLogin($createLogin);
		$user->setSol($saltUser->getGenerateString());
		$user->setTyp('uczen');
		$user->setMail($form->get('mail')->getData());
		$user->setStatus(0);

		$student=new Uczniowie();
		$student->setImie($form->get('imie')->getData());
		$student->setImie2($form->get('imie2')->getData());
		$student->setNazwisko($form->get('nazwisko')->getData());
		$student->setDataUrodzenia(
		    new DateTime($form->get('dataUrodzenia')->getData()->format('Y-m-d'))
		);
		$student->setPesel($form->get('pesel')->getData());
		$student->setMiejscowosc($form->get('miejscowosc')->getData());
		$student->setUlica($form->get('ulica')->getData());
		$student->setNrDomu($form->get('nrDomu')->getData());
		$student->setKodPocztowy($form->get('kodPocztowy')->getData());
		$student->setPoczta($form->get('poczta')->getData());
		$student->setKontakt($form->get('kontakt')->getData());
		$student->setStatus(0);
		$student->setUzytkownik($user);
		
		$createNumerLegitymacji=$form->get('dataUrodzenia')->getData()->format('Ym');
		//sprawdzanie czy numer legitymacji istnieje
		$nr=0;
		while(1){
		    $checkNumerLegitymacji=$entityManager
			->getRepository(Uczniowie::class)
			->findOneBy(['numerLegitymacji'=>$createNumerLegitymacji.$nr]);

		    if(empty($checkNumerLegitymacji)) break;
		    else $nr++;
		}
		$student->setNumerLegitymacji($createNumerLegitymacji.$nr);

		$saltConst=$entityManager->getRepository(Constant::class)->findOneBy(['name'=>'salt']);
		$hashConst=$entityManager->getRepository(Constant::class)->findOneBy(['name'=>'hash']);
		$password=new Hasla();
		$saltPassword=new GenerateString(3);
		$password->setUzytkownik($user);
		$password->setSol($saltPassword->getGenerateString());
		$password->setHaslo(
		    hash(
			$hashConst->getValue(),
			$password->getSol().$createLogin.
			$saltConst->getValue().$user->getSol()
		    )
		);
		$password->setData(new DateTime);
		$password->setProby(0);

		$entityManager->persist($user);
		$entityManager->persist($password);
		$entityManager->persist($student);
		$entityManager->flush();
		
		$this->get('session')->set('info','Dodano ucznia.');
		
		return $this->redirectToRoute('admin_users',[],201);
	    }
	}else if($request->isMethod('post') && $formType=='opiekun' && $id==0){
	    $createLogin='O'.substr($form->get('imie')->getData(),0,3)
			    .substr($form->get('nazwisko')->getData(),0,3);

	    //sprawdzanie czy login istnieje
	    $nr='';
	    while(1){
		$checkLogin=$entityManager
		    ->getRepository(Uzytkownicy::class)
		    ->findOneBy(['login'=>$createLogin.$nr]);

		if(empty($checkLogin)){
		    $createLogin=$createLogin.$nr;
		    break;
		}
		else $nr++;
	    }
		
	    $saltUser=new GenerateString(5);
	    $user=new Uzytkownicy();
	    $user->setLogin($createLogin);
	    $user->setSol($saltUser->getGenerateString());
	    $user->setTyp('opiekun');
	    $user->setMail($form->get('mail')->getData());
	    $user->setStatus(0);
	    
	    $guardian=new Opiekunowie();
	    $guardian->setImie($form->get('imie')->getData());
	    $guardian->setNazwisko($form->get('nazwisko')->getData());
	    $guardian->setKontakt($form->get('kontakt')->getData());
	    $guardian->setStatus(0);
	    $guardian->setUzytkownik($user);
	    
	    $saltConst=$entityManager->getRepository(Constant::class)->findOneBy(['name'=>'salt']);
	    $hashConst=$entityManager->getRepository(Constant::class)->findOneBy(['name'=>'hash']);
	    $password=new Hasla();
	    $salt=new GenerateString(3);
	    $password->setUzytkownik($user);
	    $password->setSol($salt->getGenerateString());
	    $password->setHaslo(
		hash(
		    $hashConst->getValue(),
		    $password->getSol().$createLogin.
		    $saltConst->getValue().$user->getSol()
		)
	    );
	    $password->setData(new DateTime);
	    $password->setProby(0);
	    
	    $student=$entityManager
		->getRepository(Uczniowie::class)
		->find($form->get('uczen')->getData());
	    
	    $student->setOpiekun($guardian);
	    
	    $entityManager->persist($user);
	    $entityManager->persist($password);
	    $entityManager->persist($guardian);
	    $entityManager->persist($student);
	    $entityManager->flush();
	    
	    $this->get('session')->set('info','Dodano opiekuna.');
	    
	    return $this->redirectToRoute('admin_users',[],201);
	}else if($request->isMethod('post') && $formType=='pracownik' && $id==0){
	    $createLogin='P'.substr($form->get('imie')->getData(),0,3)
			    .substr($form->get('nazwisko')->getData(),0,3);

	    //sprawdzanie czy login istnieje
	    $nr='';
	    while(1){
		$checkLogin=$entityManager
		    ->getRepository(Uzytkownicy::class)
		    ->findOneBy(['login'=>$createLogin.$nr]);

		if(empty($checkLogin)){
		    $createLogin=$createLogin.$nr;
		    break;
		}
		else $nr++;
	    }
	    
	    $saltUser=new GenerateString(5);
	    $user=new Uzytkownicy();
	    $user->setLogin($createLogin);
	    $user->setSol($saltUser->getGenerateString());
	    $user->setTyp('pracownik');
	    $user->setMail($form->get('mail')->getData());
	    $user->setStatus(0);
	    
	    $saltConst=$entityManager->getRepository(Constant::class)->findOneBy(['name'=>'salt']);
	    $hashConst=$entityManager->getRepository(Constant::class)->findOneBy(['name'=>'hash']);
	    $employee=new Pracownicy();
	    $employee->setImie($form->get('imie')->getData());
	    $employee->setNazwisko($form->get('nazwisko')->getData());
	    $employee->setKontakt($form->get('kontakt')->getData());
	    $employee->setRole($form->get('role')->getData());
	    $employee->setStatus(0);
	    $employee->setUzytkownik($user);
	    
	    $password=new Hasla();
	    $saltPassword=new GenerateString(3);
	    $password->setUzytkownik($user);
	    $password->setSol($saltPassword->getGenerateString());
	    $password->setHaslo(
		hash(
		    $hashConst->getValue(),
		    $password->getSol().$createLogin.
		    $saltConst->getValue().$user->getSol()
		)
	    );
	    $password->setData(new DateTime);
	    $password->setProby(0);
	    
	    $entityManager->persist($user);
	    $entityManager->persist($password);
	    $entityManager->persist($employee);
	    $entityManager->flush();
	    
	    $this->get('session')->set('info','Dodano pracownika.');
	    
	    return $this->redirectToRoute('admin_users',[],201);
	}
	
	//edytowanie ucznia
	if($request->isMethod('post') && $formType=='uczen' && $id!=0 && $delete==0){
	    $entityManager->createQuery(
	        "UPDATE AppBundle\Entity\Uzytkownicy u ".
	        "SET u.mail='".$form->get('mail')->getData()."' ".
		"WHERE u.id=".$id
	    )
	    ->getResult();
	    
	    $entityManager->createQuery(
	        "UPDATE AppBundle\Entity\Uczniowie uc ".
	        "SET ".
	        "   uc.imie='".$form->get('imie')->getData()."', ".
	        "   uc.imie2='".$form->get('imie2')->getData()."', ".
	        "   uc.nazwisko='".$form->get('nazwisko')->getData()."', ".
	        "   uc.dataUrodzenia='".$form->get('dataUrodzenia')->getData()->format('Y-m-d')."', ".
		"   uc.pesel='".$form->get('pesel')->getData()."', ".
		"   uc.miejscowosc='".$form->get('miejscowosc')->getData()."', ".
		"   uc.ulica='".$form->get('ulica')->getData()."', ".
		"   uc.nrDomu='".$form->get('nrDomu')->getData()."', ".
		"   uc.kodPocztowy='".$form->get('kodPocztowy')->getData()."', ".
		"   uc.poczta='".$form->get('poczta')->getData()."', ".
		"   uc.kontakt='".$form->get('kontakt')->getData()."' ".
		"WHERE uc.uzytkownik IN ".
		"   (SELECT u.id FROM AppBundle\Entity\Uzytkownicy u ".
		"   WHERE u.id=".$id.")"
	    )
	    ->getResult();
	    
	    $this->get('session')->set('info','Zedytowano ucznia.');
	    
	    return $this->redirectToRoute('admin_users',[],201);
	//edytowanie opiekuna
	}else if($request->isMethod('post') && $formType=='opiekun' && $id!=0 && $delete==0){
	    $entityManager->createQuery(
	        "UPDATE AppBundle\Entity\Uzytkownicy u ".
	        "SET u.mail='".$form->get('mail')->getData()."' ".
		"WHERE u.id=".$id
	    )
	    ->getResult();
	    
	    $entityManager->createQuery(
	        "UPDATE AppBundle\Entity\Opiekunowie o ".
	        "SET ".
	        "   o.imie='".$form->get('imie')->getData()."', ".
	        "   o.nazwisko='".$form->get('nazwisko')->getData()."', ".
	        "   o.kontakt='".$form->get('kontakt')->getData()."' ".
		"WHERE o.uzytkownik IN ".
		"   (SELECT u.id FROM AppBundle\Entity\Uzytkownicy u ".
		"   WHERE u.id=".$id.")"
	    )
	    ->getResult();
	    
	    $o=$entityManager->getRepository(Opiekunowie::class)->findOneBy(['uzytkownik'=>$id]);
	    
	    $entityManager->createQuery(
	        "UPDATE AppBundle\Entity\Uczniowie u ".
	        "SET u.opiekun='".$o->getId()."' ".
		"WHERE u.id='".$form->get('uczen')->getData()."'"
	    )
	    ->getResult();
	    
	    $this->get('session')->set('info','Zedytowano opiekuna.');
	    
	    return $this->redirectToRoute('admin_users',[],201);
	//edytowanie pracownika
	}else if($request->isMethod('post') && $formType=='pracownik' && $id!=0 && $delete==0){
	    $entityManager->createQuery(
	        "UPDATE AppBundle\Entity\Uzytkownicy u ".
	        "SET u.mail='".$form->get('mail')->getData()."' ".
		"WHERE u.id=".$id
	    )
	    ->getResult();
	    
	$role='';    
	foreach($form->get('role')->getData() as $value)
	    $role.=$value.",";
	$role=substr($role,0,-1);
	    
	    $entityManager->createQuery(
	        "UPDATE AppBundle\Entity\Pracownicy p ".
	        "SET ".
	        "   p.imie='".$form->get('imie')->getData()."', ".
	        "   p.nazwisko='".$form->get('nazwisko')->getData()."', ".
	        "   p.kontakt='".$form->get('kontakt')->getData()."', ".
	        "   p.role='".$role."' ".
		"WHERE p.uzytkownik IN ".
		"   (SELECT u.id FROM AppBundle\Entity\Uzytkownicy u ".
		"   WHERE u.id=".$id.")"
	    )
	    ->getResult();
	    
	    $this->get('session')->set('info','Zedytowano pracownika.');
	    
	    return $this->redirectToRoute('admin_users',[],201);
	}
	
	//usuwanie ucznia
	if($formType=='uczen' && $id!=0 && $delete==1){
	    $entityManager->createQuery(
	        "UPDATE AppBundle\Entity\Uzytkownicy u ".
	        "SET u.status=1 ".
		"WHERE u.id=".$id
	    )
	    ->getResult();
	    
	    $entityManager->createQuery(
	        "UPDATE AppBundle\Entity\Uczniowie u ".
	        "SET u.status=1 ".
		"WHERE u.id=".$id
	    )
	    ->getResult();
	    
	    $this->get('session')->set('info','Usunięto ucznia.');
	    
	    return $this->redirectToRoute('admin_users',[],201);
	//usuwanie opiekuna
	}else if($formType=='opiekun' && $id!=0 && $delete==1){
	    $entityManager->createQuery(
	        "UPDATE AppBundle\Entity\Uzytkownicy u ".
	        "SET u.status=1 ".
		"WHERE u.id=".$id
	    )
	    ->getResult();
	    
	    $entityManager->createQuery(
	        "UPDATE AppBundle\Entity\Opiekunowie o ".
	        "SET o.status=1 ".
		"WHERE o.id=".$id
	    )
	    ->getResult();
	    
	    $this->get('session')->set('info','Usunięto opiekuna.');
	    
	    return $this->redirectToRoute('admin_users',[],201);
	//usuwanie pracownika
	}if($formType=='pracownik' && $id!=0 && $delete==1){
	    $entityManager->createQuery(
	        "UPDATE AppBundle\Entity\Uzytkownicy u ".
	        "SET u.status=1 ".
		"WHERE u.id=".$id
	    )
	    ->getResult();
	    
	    $entityManager->createQuery(
	        "UPDATE AppBundle\Entity\Uczniowie p ".
	        "SET p.status=1 ".
		"WHERE p.id=".$id
	    )
	    ->getResult();
	    
	    $this->get('session')->set('info','Usunięto pracownika.');
	    
	    return $this->redirectToRoute('admin_users',[],201);
	}
	
	//dane do wyświetlenia
	$users=$entityManager->createQuery(
	    "SELECT u ".
	    "FROM AppBundle\Entity\Uzytkownicy u ".
	    "WHERE u.status=0"
	)
	->getResult();

	return $this->render('admin/users.html.twig',[
		'form'=>$form->createView(),
		'users'=>$users,
		'errors'=>$errors
	]);
    }
    
    /**
     * @Route("/klasy/{id}/{delete}", name="admin_classes", defaults={"id"="0","delete"="0"})
     */
    public function classesAction(Request $request,$id,$delete){
	$entityManager=$this->getDoctrine()->getManager();
	
	//sprawdzanie przerwy techicznej
	if(AdminController::technicalBreak($this)) return $this->redirectToRoute('technical_break',[],302);
	
	//sprawdzawdzanie czy użytkownik to admin
	if(!$this->get('session')->has('admin')){
	    $this->get('session')->set('danger','Nie jesteś adminem.');
	    return $this->redirectToRoute('homepage',[],302);
	}
	
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
	
	$classes=$this->getDoctrine()->getRepository(Klasy::class)->findBy(['status'=>0]);
	
	$formValue=null;
	$choicesTeacher=null;
	$teacherValue=null;
	$formValueDate=null;
	
	$teachers=$entityManager->createQuery(
	    "SELECT p ".
	    "FROM AppBundle\Entity\Pracownicy p ".
	    "WHERE p.status=0 AND p.role LIKE '%wychowawca%'"
	)
	->getResult();
	
	for($i=0;$i<count($teachers);$i++)
	$choicesTeacher[$teachers[$i]->getImie()]=$teachers[$i]->getId();
	
	//dane do formularza
	if($id!=0){
	    $formValue=$this->getDoctrine()->getRepository(Klasy::class)->find($id);
	    $formValueDate=new DateTime($formValue->getRocznik().'-01-01');

	    $teacher=$entityManager->createQuery(
		"SELECT p ".
		"FROM AppBundle\Entity\Pracownicy p ".
		"JOIN AppBundle\Entity\Klasy k ".
		"WITH k.wychowawca=p.id ".
		"WHERE k.id=".$id
	    )
	    ->getResult();
	    
	    $teacherValue=$teacher[0]->getId();
	}
	
	//formularz
	$form=$this->createFormBuilder($formValue)
	    ->setMethod('POST')
	    ->add('poziom',IntegerType::class)
	    ->add('klasa',TextType::class)
	    ->add('rocznik',DateType::class,[
		'data'=>$formValueDate,
		'widget'=>'single_text',
		'format'=>'yyyy',
		'attr'=>['placeholder'=>'rrrr']
	    ])
	    ->add('wychowawca',ChoiceType::class,[
		'choices'=>$choicesTeacher,'data'=>$teacherValue
	    ])
	    ->add('submit',SubmitType::class)
	    ->getForm();
	
	//dodawanie
	if($request->isMethod('post') && $id==0){
	    $form->handleRequest($request);
	    
	    $teacher=$this
		->getDoctrine()
		->getRepository(Pracownicy::class)
		->find($form->get('wychowawca')->getData());
	    
	    $class=new Klasy();
	    $class->setPoziom($form->get('poziom')->getData());
	    $class->setKlasa($form->get('klasa')->getData());
	    $class->setRocznik($form->get('rocznik')->getData()->format('Y'));
	    $class->setStatus(0);
	    $class->setWychowawca($teacher);
	    
	    $entityManager->persist($class);
	    $entityManager->flush();
	    
	    $this->get('session')->set('info','Dodano klasę.');
	    
	    return $this->redirectToRoute('admin_classes',[],201);
	//edytowanie 
	}else if($request->isMethod('post') && $id!=0){
	    $entityManager->createQuery(
	        "UPDATE AppBundle\Entity\Klasy k ".
	        "SET ".
		"   k.poziom='".$_POST['form']['poziom']."', ".
		"   k.klasa='".$_POST['form']['klasa']."', ".
		"   k.rocznik='".$_POST['form']['rocznik']."', ".
		"   k.wychowawca='".$_POST['form']['wychowawca']."' ".
		"WHERE k.id=".$id
	    )
	    ->getResult();
	    
	    $this->get('session')->set('info','Zedytowano klasę.');
	    
	    return $this->redirectToRoute('admin_classes',[],201);
	//usuwanie
	}else if($delete==1 && $id!=0){
	    $entityManager->createQuery(
	        "UPDATE AppBundle\Entity\Klasy k ".
	        "SET k.status=1 ".
		"WHERE k.id=".$id
	    )
	    ->getResult();
	    
	    $this->get('session')->set('info','Usunięto klasę.');
	    
	    return $this->redirectToRoute('admin_classes',[],201);
	}

	return $this->render('admin/classes.html.twig',[
	    'form'=>$form->createView(),
	    'classes'=>$classes
	]);
    }
    
    /**
     * @Route("/klasa/{numberClass}/{class}/{id}/{delete}", name="admin_class", 
     * defaults={"numberClass"="0","class"="0","id"="0","delete"="0"})
     */
    public function classAction(Request $request,$numberClass,$class,$id,$delete){
	$entityManager=$this->getDoctrine()->getManager();
	
	//sprawdzanie przerwy techicznej
	if(AdminController::technicalBreak($this)) return $this->redirectToRoute('technical_break',[],302);
	
	//sprawdzawdzanie czy użytkownik to admin
	if(!$this->get('session')->has('admin')){
	    $this->get('session')->set('danger','Nie jesteś adminem.');
	    return $this->redirectToRoute('homepage',[],302);
	}
	
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
	
	$classes=$entityManager->getRepository(Klasy::class)->findBy(['status'=>0]);
	
	if($class!=(string)0 && $numberClass!=0){
	    $class=$entityManager
		->getRepository(Klasy::class)
		->findOneBy(['poziom'=>$numberClass,'klasa'=>$class]);
	    
	    $students=$entityManager
		->getRepository(Uczniowie::class)
		->findBy(['klasa'=>$class->getId()]);
	}
	
	$noClassStudents=$this->getDoctrine()->getRepository(Uczniowie::class)->findBy(['klasa'=>null]);
	foreach($noClassStudents as $value)
	    $choicesStudents[$value->getImie().' '.$value->getNazwisko()]=$value->getId();
	
	$form=$this->createFormBuilder()
	    ->setMethod('POST')
	    ->add('uczen',ChoiceType::class,['choices'=>@$choicesStudents])
	    ->add('submit',SubmitType::class)
	    ->getForm();
	
	if($request->isMethod('post')){
	    $form->handleRequest($request);
	    
	    $entityManager->createQuery(
	        "UPDATE AppBundle\Entity\Uczniowie u ".
	        "SET u.klasa=".$class->getId()." ".
		"WHERE u.id='".$form->get('uczen')->getData()."'"
	    )
	    ->getResult();
	    
	    $this->get('session')->set('info','Dodano ucznia do klasy.');
	    
	    return $this->redirectToRoute('admin_class',[
		'numberClass'=>$class->getPoziom(),
		'class'=>$class->getKlasa()
	    ],201);
	}else if($id!=0 && $delete!=0){
	    $entityManager->createQuery(
	        "UPDATE AppBundle\Entity\Uczniowie u ".
	        "SET u.klasa=null ".
		"WHERE u.id=".$id
	    )
	    ->getResult();
	    
	    $this->get('session')->set('info','Usunięto ucznia z klasy.');
	    
	    return $this->redirectToRoute('admin_class',[
		'numberClass'=>$class->getPoziom(),
		'class'=>$class->getKlasa()
	    ],201);
	}
	
	return $this->render('admin/class.html.twig',[
	    'form'=>$form->createView(),
	    'classes'=>$classes,
	    'class'=>$class,
	    'students'=>@$students
	]);
    }
    
    /**
     * @Route("/przedmioty/{form}/{id}/{delete}", name="admin_subjects", 
     * defaults={"form"="slownikPrzedmiotow","id"="0","delete"="0"})
     */
    public function subjectsAction(Request $request,$form,$id,$delete){
	$entityManager=$this->getDoctrine()->getManager();
	
	//sprawdzanie przerwy techicznej
	if(AdminController::technicalBreak($this)) return $this->redirectToRoute('technical_break',[],302);
	
	//sprawdzawdzanie czy użytkownik to admin
	if(!$this->get('session')->has('admin')){
	    $this->get('session')->set('danger','Nie jesteś adminem.');
	    return $this->redirectToRoute('homepage',[],302);
	}
	
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
	
	$librarySubjects=$this->getDoctrine()->getRepository(SlownikPrzedmiotow::class)->findAll();
	$subjects=$this->getDoctrine()->getRepository(Przedmioty::class)->findBy(['status'=>0]);
	$teachers=$this->getDoctrine()->getRepository(Pracownicy::class)->findAll();
	$formValueLibrarySubjects=null;
	$formValueSubjects=null;
	
	foreach($librarySubjects as $value)
	    $choicesSubjects[$value->getNazwa()]=$value->getId();
	
	foreach($teachers as $value)
	    $choicesTeachers[$value->getImie().' '.$value->getNazwisko()]=$value->getId();
	
	//formularze
	if($id!=0 && $form=='slownikPrzedmiotow')
	    $formValueLibrarySubjects=$this
		->getDoctrine()
		->getRepository(SlownikPrzedmiotow::class)
		->find($id);
	else if($id!=0 && $form=='przedmioty'){
	    $valueSubjects=$this
		->getDoctrine()
		->getRepository(Przedmioty::class)
		->find($id);
	    $formValueSubjects['prowadzacy']=$valueSubjects->getProwadzacy()->getId();
	    $formValueSubjects['przedmiot']=$valueSubjects->getPrzedmiot()->getId();
	}
	
	$formLibrarySubjects=$this->createFormBuilder($formValueLibrarySubjects)
	    ->setMethod('POST')
	    ->add('nazwa',TextType::class)
	    ->add('opis',TextareaType::class,['required'=>false])
	    ->add('submitLibrarySubjects',SubmitType::class)
	    ->getForm();

	$formSubjects=$this->createFormBuilder()
	    ->setMethod('POST')
	    ->add('prowadzacy',ChoiceType::class,[
		'choices'=>$choicesTeachers,'data'=>$formValueSubjects['prowadzacy']
	    ])
	    ->add('przedmiot',ChoiceType::class,[
		'choices'=>@$choicesSubjects,'data'=>$formValueSubjects['przedmiot']
	    ])
	    ->add('submitSubjects',SubmitType::class)
	    ->getForm();
	
	//dodawanie
	if(isset($_POST['form']['submitLibrarySubjects']) && $id==0){
	    $formLibrarySubjects->handleRequest($request);
	    
	    $subject=new SlownikPrzedmiotow();
	    $subject->setNazwa($formLibrarySubjects->get('nazwa')->getData());
	    $subject->setOpis($formLibrarySubjects->get('opis')->getData());
	    
	    $entityManager->persist($subject);
	    $entityManager->flush();
	    
	    $this->get('session')->set('info','Dodano nazwę przedmiotu.');
	    
	    return $this->redirectToRoute('admin_subjects',[],201);
	}else if(isset($_POST['form']['submitSubjects']) && $id==0){
	    $formSubjects->handleRequest($request);
	    
	    $teacher=$this
		->getDoctrine()
		->getRepository(Pracownicy::class)
		->find($formSubjects->get('prowadzacy')->getData());
	    
	    $subject=$this
		->getDoctrine()
		->getRepository(SlownikPrzedmiotow::class)
		->find($formSubjects->get('przedmiot')->getData());
	    
	    $objSubject=new Przedmioty();
	    $objSubject->setProwadzacy($teacher);
	    $objSubject->setPrzedmiot($subject);
	    $objSubject->setStatus(0);
	    
	    $entityManager->persist($objSubject);
	    $entityManager->flush();
	    
	    $this->get('session')->set('info','Przepisano nauczyciela do przedmiotu.');
	    
	    return $this->redirectToRoute('admin_subjects',[],201);
	//edytowanie
	}else if(isset($_POST['form']['submitLibrarySubjects']) && $id!=0){
	    $formLibrarySubjects->handleRequest($request);
	     
	    $entityManager->createQuery(
	        "UPDATE AppBundle\Entity\SlownikPrzedmiotow s ".
	        "SET ".
		"   s.nazwa='".$formLibrarySubjects->get('nazwa')->getData()."', ".
		"   s.opis='".$formLibrarySubjects->get('opis')->getData()."' ".
		"WHERE s.id=".$id
	    )
	    ->getResult();
	    
	    $this->get('session')->set('info','Zedytowano nazwę przedmiotu.');
	    
	    return $this->redirectToRoute('admin_subjects',[],201);
	}else if(isset($_POST['form']['submitSubjects']) && $id!=0){
	    $formSubjects->handleRequest($request);
	    
	    $entityManager->createQuery(
	        "UPDATE AppBundle\Entity\Przedmioty p ".
	        "SET ".
		"   p.prowadzacy='".$formSubjects->get('prowadzacy')->getData()."', ".
		"   p.przedmiot='".$formSubjects->get('przedmiot')->getData()."' ".
		"WHERE p.id=".$id
	    )
	    ->getResult();
	    
	    $this->get('session')->set('info','Zedytowano przedmiot.');
	    
	    return $this->redirectToRoute('admin_subjects',[],201);
	//usuwanie
	}else if($delete==1 && $form=='slownikPrzedmiotow' && $id!=0){
	    $entityManager->createQuery(
	        "DELETE AppBundle\Entity\SlownikPrzedmiotow p ".
		"WHERE p.id=".$id
	    )
	    ->getResult();
	    
	    $this->get('session')->set('info','Usunięto nazwę przedmiotu.');
	    
	    return $this->redirectToRoute('admin_subjects',[],201);
	}else if($delete==1 && $form=='przedmioty' && $id!=0){
	    $entityManager->createQuery(
	        "UPDATE AppBundle\Entity\Przedmioty p ".
	        "SET p.status=1 ".
		"WHERE p.id=".$id
	    )
	    ->getResult();
	    
	    $this->get('session')->set('info','Usunięto przedmiot.');
	    
	    return $this->redirectToRoute('admin_subjects',[],201);
	}
	
	return $this->render('admin/subjects.html.twig',[
	    'formLibrarySubjects'=>$formLibrarySubjects->createView(),
	    'formSubjects'=>$formSubjects->createView(),
	    'librarySubjects'=>$librarySubjects,
	    'subjects'=>$subjects,
	]);
    }
    
    /**
     * @Route("/godziny_lekcyjne/{id}/{delete}", name="admin_lesson_hours", 
     * defaults={"id"="0","delete"="0"})
     */
    public function lessonHoursAction(Request $request,$id,$delete){
	$entityManager=$this->getDoctrine()->getManager();
	
	//sprawdzanie przerwy techicznej
	if(AdminController::technicalBreak($this)) return $this->redirectToRoute('technical_break',[],302);
	
	//sprawdzawdzanie czy użytkownik to admin
	if(!$this->get('session')->has('admin')){
	    $this->get('session')->set('danger','Nie jesteś adminem.');
	    return $this->redirectToRoute('homepage',[],302);
	}
	
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
	
	$lessonHours=$this->getDoctrine()->getRepository(GodzLek::class)->findAll();
	$formValue=null;
	
	//formularz
	if($id!=0) $formValue=$this->getDoctrine()->getRepository(GodzLek::class)->find($id);
	    
	$form=$this->createFormBuilder($formValue)
	    ->setMethod('POST')
	    ->add('poczatek',TimeType::class,['widget'=>'single_text'])
	    ->add('submit',SubmitType::class)
	    ->getForm();
	
	//dodawanie
	if($request->isMethod('post') && $id==0){
	    $form->handleRequest($request);
	    
	    $lessonHours=new GodzLek();
	    $lessonHours->setPoczatek($form->get('poczatek')->getData());
	    
	    $entityManager->persist($lessonHours);
	    $entityManager->flush();
	    
	    $this->get('session')->set('info','Dodano godzinę lekcyjną.');
	    
	    return $this->redirectToRoute('admin_lesson_hours',[],201);
	//edytowanie
	}else if($request->isMethod('post') && $id!=0){
	    $form->handleRequest($request);
	    $lessonHours=$entityManager->getRepository(GodzLek::class)->find($id);
	    $lessonHours->setPoczatek($form->get('poczatek')->getData());
	    $entityManager->persist($lessonHours);
	    $entityManager->flush();
	    
	    $this->get('session')->set('info','Zedytowano godzinę lekcyjną.');
	    
	    return $this->redirectToRoute('admin_lesson_hours',[],201);
	//usuwanie
	}else if($delete==1 && $id!=0){
	    $entityManager->createQuery(
	        "DELETE AppBundle\Entity\GodzLek g ".
		"WHERE g.id=".$id
	    )
	    ->getResult();
	    
	    $this->get('session')->set('info','Usunięto godzinę lekcyjną.');
	    
	    return $this->redirectToRoute('admin_lesson_hours',[],201);
	}
	    
	return $this->render('admin/lesson_hours.html.twig',[
	    'form'=>$form->createView(),
	    'lessonHours'=>$lessonHours
	]);
    }
    
    /**
     * @Route("/sale/{id}/{delete}", name="admin_rooms", 
     * defaults={"id"="0","delete"="0"})
     */
    public function roomsAction(Request $request,$id,$delete){
	$entityManager=$this->getDoctrine()->getManager();
	
	//sprawdzanie przerwy techicznej
	if(AdminController::technicalBreak($this)) return $this->redirectToRoute('technical_break',[],302);
	
	//sprawdzawdzanie czy użytkownik to admin
	if(!$this->get('session')->has('admin')){
	    $this->get('session')->set('danger','Nie jesteś adminem.');
	    return $this->redirectToRoute('homepage',[],302);
	}
	
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
	
	$rooms=$this->getDoctrine()->getRepository(Sale::class)->findAll();
	$formValue=null;
	
	//formularz
	if($id!=0) $formValue=$this->getDoctrine()->getRepository(Sale::class)->find($id);
	    
	$form=$this->createFormBuilder($formValue)
	    ->setMethod('POST')
	    ->add('nrSali',TextType::class)
	    ->add('opis',TextType::class,['required'=>false])
	    ->add('submit',SubmitType::class)
	    ->getForm();
	
	//dodawanie
	if($request->isMethod('post') && $id==0){
	    $form->handleRequest($request);
	    
	    $room=new Sale();
	    $room->setNrSali($form->get('nrSali')->getData());
	    $room->setOpis($form->get('opis')->getData());
	    
	    $entityManager->persist($room);
	    $entityManager->flush();
	    
	    $this->get('session')->set('info','Dodano salę lekcyjną.');
	    
	    return $this->redirectToRoute('admin_rooms',[],201);
	//edytowanie
	}if($request->isMethod('post') && $id!=0){
	    $form->handleRequest($request);
	    
	    $entityManager->createQuery(
	        "UPDATE AppBundle\Entity\Sale s ".
	        "SET ".
		"   s.nrSali='".$form->get('nrSali')->getData()."', ".
		"   s.opis='".$form->get('opis')->getData()."' ".
		"WHERE s.id=".$id
	    )
	    ->getResult();
	    
	    $this->get('session')->set('info','Zedytowano salę lekcyjną.');
	    
	    return $this->redirectToRoute('admin_rooms',[],201);
	//usuwanie
	}else if($delete==1 && $id!=0){
	    $entityManager->createQuery(
	        "DELETE AppBundle\Entity\Sale s ".
		"WHERE s.id=".$id
	    )
	    ->getResult();
	    
	    $this->get('session')->set('info','Usunięto salę lekcyjną.');
	    
	    return $this->redirectToRoute('admin_rooms',[],201);
	}
	
	return $this->render('admin/rooms.html.twig',[
	    'form'=>$form->createView(),
	    'rooms'=>$rooms
	]);
    }
    
    /**
     * @Route("/terminarz/{numberClass}/{class}/{id}/{delete}", name="admin_time_table", 
     * defaults={"numberClass"="0","class"="0","id"="0","delete"="0"})
     */
    public function timeTableAction(Request $request,$numberClass,$class,$id,$delete){
	$entityManager=$this->getDoctrine()->getManager();
	
	//sprawdzanie przerwy techicznej
	if(AdminController::technicalBreak($this)) return $this->redirectToRoute('technical_break',[],302);
	
	//sprawdzawdzanie czy użytkownik to admin
	if(!$this->get('session')->has('admin')){
	    $this->get('session')->set('danger','Nie jesteś adminem.');
	    return $this->redirectToRoute('homepage',[],302);
	}
	
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
	
	$timeTable=$this->getDoctrine()->getRepository(Terminarz::class)->findAll();
	$formValue=null;
	$roomValue=null;
	$hourValue=null;
	$subjectValue=null;
	$classValue=null;
	
	$rooms=$this->getDoctrine()->getRepository(Sale::class)->findAll();
	foreach($rooms as $value)
	    $choicesRooms[$value->getNrSali()]=$value->getId();
	
	$lessonHours=$this->getDoctrine()->getRepository(GodzLek::class)->findAll();
	foreach($lessonHours as $value)
	    $choicesLessonHours[$value->getPoczatek()->format('H:i')]=$value->getId();
	
	$choicesDaysOfTheWeek=[
	    'Poniedziałek'=>'poniedzialek',
	    'Wtorek'=>'wtorek',
	    'Środa'=>'sroda',
	    'Czwartek'=>'czwartek',
	    'Piątek'=>'piatek',
	    'Sobota'=>'sobota'
	];
	
	$subjects=$this->getDoctrine()->getRepository(Przedmioty::class)->findAll();
	foreach($subjects as $value)
	    $choicesSubjects[
		$value->getPrzedmiot()->getNazwa().' '.$value->getProwadzacy()->getImie().' '.
		$value->getProwadzacy()->getNazwisko()
	    ]=$value->getId();
	
	$classes=$this->getDoctrine()->getRepository(Klasy::class)->findAll();
	foreach($classes as $value)
	    $choicesClasses[$value->getPoziom().$value->getKlasa()]=$value->getId();
	
	$choicesType=[
	    'Plan'=>'plan',
	    'Sprawdzian'=>'sprawdzian'
	];

	//dane do wyświetlenia
	if($class!=(string)0 && $numberClass!=0){
	    $class=$this
		->getDoctrine()
		->getRepository(Klasy::class)
		->findOneBy(['poziom'=>$numberClass,'klasa'=>$class]);
	
	    $arrayWeek=['poniedzialek','wtorek','sroda','czwartek','piatek','sobota'];
	    for($j=0;$j<count($arrayWeek);$j++)
	    for($i=0;$i<count($lessonHours);$i++)
	    $lessons[$i][$arrayWeek[$j]]=$this
		->getDoctrine()
		->getRepository(Terminarz::class)
		->findOneBy([
		    'dzienTygodnia'=>$arrayWeek[$j],
		    'godzina'=>$lessonHours[$i]->getId(),
		    'klasa'=>$class->getId()
		]);
	}
	
	//formularz
	if($id!=0){
	    $formValue=$this->getDoctrine()->getRepository(Terminarz::class)->find($id);
	    
	    $room=$entityManager->createQuery(
		"SELECT s ".
		"FROM AppBundle\Entity\Sale s ".
		"JOIN AppBundle\Entity\Terminarz t ".
		"WITH s.id=t.sala ".
		"WHERE t.id=".$id
	    )
	    ->getResult();
	    $roomValue=$room[0]->getId();
	    
	    $hour=$entityManager->createQuery(
		"SELECT g ".
		"FROM AppBundle\Entity\GodzLek g ".
		"JOIN AppBundle\Entity\Terminarz t ".
		"WITH g.id=t.godzina ".
		"WHERE t.id=".$id
	    )
	    ->getResult();
	    $hourValue=$hour[0]->getId();
	    
	    $subject=$entityManager->createQuery(
		"SELECT p ".
		"FROM AppBundle\Entity\Przedmioty p ".
		"JOIN AppBundle\Entity\Terminarz t ".
		"WITH p.id=t.ktoCo ".
		"WHERE t.id=".$id
	    )
	    ->getResult();
	    $subjectValue=$subject[0]->getId();
	    
	    $class=$entityManager->createQuery(
		"SELECT k ".
		"FROM AppBundle\Entity\Klasy k ".
		"JOIN AppBundle\Entity\Terminarz t ".
		"WITH k.id=t.klasa ".
		"WHERE t.id=".$id
	    )
	    ->getResult();
	    $classValue=$class[0]->getId();
	}
	
	$form=$this->createFormBuilder($formValue)
	    ->setMethod('POST')
	    ->add('sala',ChoiceType::class,['choices'=>@$choicesRooms,'data'=>$roomValue])
	    ->add('godzina',ChoiceType::class,['choices'=>@$choicesLessonHours,'data'=>$hourValue])
	    ->add('dzienTygodnia',ChoiceType::class,['choices'=>$choicesDaysOfTheWeek])
	    ->add('ktoCo',ChoiceType::class,['choices'=>@$choicesSubjects,'data'=>$subjectValue])
	    ->add('klasa',ChoiceType::class,['choices'=>@$choicesClasses,'data'=>$classValue])
	    ->add('typ',ChoiceType::class,['choices'=>$choicesType])
	    ->add('poczatek',DateType::class,['widget'=>'single_text'])
	    ->add('koniec',DateType::class,['widget'=>'single_text'])
	    ->add('opis',TextType::class,['required'=>false])
	    ->add('submit',SubmitType::class)
	    ->getForm();
	
	//walidacja
	if($request->isMethod('post') && $form->get('poczatek')->getData()>=$form->get('koniec')->getData()){
	    $this->get('session')->set('danger','Koniec daty nie może być wcześniejszy od początku.');
	    
	    return $this->redirectToRoute('admin_time_table',["numberClass"=>$numberClass,"class"=>$class],201);
	//dodawanie terminu
	}else if($request->isMethod('post') && $id==0){
	    $form->handleRequest($request);	
	    
	    $term=new Terminarz();
	    $term->setSala(
		$this->getDoctrine()
		->getRepository(Sale::class)
		->find($form->get('sala')->getData())
	    );
	    $term->setGodzina(
		$this->getDoctrine()
		->getRepository(GodzLek::class)
		->find($form->get('godzina')->getData())
	    );
	    $term->setDzienTygodnia($form->get('dzienTygodnia')->getData());
	    $term->setKtoCo(
		$this->getDoctrine()
		->getRepository(Przedmioty::class)
		->find($form->get('ktoCo')->getData())
	    );
	    $term->setKlasa(
		$this->getDoctrine()
		->getRepository(Klasy::class)
		->find($form->get('klasa')->getData())
	    );
	    $term->setTyp($form->get('typ')->getData());
	    $term->setPoczatek($form->get('poczatek')->getData());
	    $term->setKoniec($form->get('koniec')->getData());
	    $term->setOpis($form->get('opis')->getData());
	    
	    $entityManager->persist($term);
	    $entityManager->flush();
	    
	    $this->get('session')->set('info','Dodano nowy termin do bazy.');
	    
	    return $this->redirectToRoute('admin_time_table',["numberClass"=>$numberClass,"class"=>$class],201);
	//edytowanie terminu
	}else if($request->isMethod('post') && $id!=0){
	    $entityManager->createQuery(
	        "UPDATE AppBundle\Entity\Terminarz t ".
	        "SET ".
		"   t.sala='".$_POST['form']['sala']."', ".
		"   t.godzina='".$_POST['form']['godzina']."', ".
		"   t.dzienTygodnia='".$_POST['form']['dzienTygodnia']."', ".
		"   t.ktoCo='".$_POST['form']['ktoCo']."', ".
		"   t.klasa='".$_POST['form']['klasa']."', ".
		"   t.typ='".$_POST['form']['typ']."', ".
		"   t.poczatek='".$_POST['form']['poczatek']."', ".
		"   t.koniec='".$_POST['form']['koniec']."', ".
		"   t.opis='".$_POST['form']['opis']."' ".
		"WHERE t.id=".$id
	    )
	    ->getResult();
	    
	    $this->get('session')->set('info','Zedytowano termin.');
	    
	    return $this->redirectToRoute('admin_time_table',["numberClass"=>$numberClass,"class"=>$_POST['form']['klasa']],201);
	//usuwanie terminu
	}else if($delete==1 && $id!=0){
	    $entityManager->createQuery(
	        "DELETE AppBundle\Entity\Terminarz t ".
		"WHERE t.id=".$id
	    )
	    ->getResult();
	    
	    $this->get('session')->set('info','Usunięto termin.');
	    
	    return $this->redirectToRoute('admin_time_table',[],201);
	}
	
	return $this->render('admin/time_table.html.twig',[
	    'form'=>$form->createView(),
	    'timeTable'=>$timeTable,
	    'lessonHours'=>$lessonHours,
	    'lessons'=>@$lessons,
	    'classes'=>$classes
	]);
    }
    
    /**
     * @Route("/ustawienia", name="admin_settings")
     */
    public function settings(Request $request){
	//sprawdzanie przerwy techicznej
	if(AdminController::technicalBreak($this)) return $this->redirectToRoute('technical_break',[],302);
	
	//sprawdzawdzanie czy użytkownik to admin
	if(!$this->get('session')->has('admin')){
	    $this->get('session')->set('danger','Nie jesteś adminem.');
	    return $this->redirectToRoute('homepage',[],302);
	}
	
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
	
	$dir=$this->get('kernel')->getRootDir().'/../web/backup/';
	$files=array_diff(scandir($dir),[".",".."]);
	foreach($files as $file) $arrayFiles[$file]=$file;
	$entityManager=$this->getDoctrine()->getManager();
	$arrayTechnicalBreak['nie']=0;
	$arrayTechnicalBreak['tak']=1;
	
	$technicalBreak=$this
	    ->getDoctrine()
	    ->getRepository(Constant::class)
	    ->findOneBy(['name'=>'technical_break']);
	
	$formDatabase=$this->createFormBuilder()
		->setMethod('POST')
		->add('database',ChoiceType::class,['choices'=>$arrayFiles],['label'=>'Baza'])
		->add('submitDatabase',SubmitType::class,['label'=>'Zmień'])
		->getForm();
	
	$formTechnicalBreak=$this->createFormBuilder()
		->setMethod('POST')
		->add('technicalBreak',ChoiceType::class,[
		    'choices'=>$arrayTechnicalBreak,
		    'label'=>'Przerwa techniczna'
		])
		->add('submitTechnicalBreak',SubmitType::class,['label'=>'Ustaw'])
		->getForm();
	
	//zmiana bazy danych
	if($request->isMethod('post') && isset($_POST['form']['submitDatabase'])){
	    $formDatabase->handleRequest($request);
	    AdminController::database_import($formDatabase->get('database')->getData());
	    
	    $this->get('session')->set('info','Zmieniono bazę danych.');
	    
	    return $this->redirectToRoute('admin_settings',[],201);
	}
	//ustawianie przerwy technicznej
	if($request->isMethod('post') && isset($_POST['form']['submitTechnicalBreak'])){
	    $formTechnicalBreak->handleRequest($request);
	    $entityManager->createQuery(
	        "UPDATE AppBundle\Entity\Constant c ".
	        "SET c.value='".$formTechnicalBreak->get('technicalBreak')->getData()."' ".
		"WHERE c.name='technical_break'"
	    )
	    ->getResult();
	    
	    $this->get('session')->set('info','Zmieniono stan przerwy technicznej.');
	    
	    return $this->redirectToRoute('admin_settings',[],201);
	}
	
	return $this->render('admin/settings.html.twig',[
	    'formDatabase'=>$formDatabase->createView(),
	    'formTechnicalBreak'=>$formTechnicalBreak->createView(),
	    'technicalBreak'=>$technicalBreak->getValue()
	]);
    }
    
    /**
     * @Route("/database", name="database")
     */
    public function database(){
	if(AdminController::technicalBreak($this)) return $this->redirectToRoute('technical_break',[],302);
	AdminController::database_export();
	$this->get('session')->set('info','Utworzono kopie bazy danych.');
	return $this->redirectToRoute('admin_settings',[],201);
    }
    
    //export bazy
    private function database_export($name=false){
	//set_time_limit(3000);
	if($name===false) $name=$this->getParameter('database_name');
	$conn=$this->getDoctrine()->getConnection();
	$queryTables=$conn->fetchAll('SHOW TABLES');
	
	foreach($queryTables as $row) foreach($row as $table) $tables[]=$table; 
	$content=
	    "/*!40030 SET NAMES UTF8 */;\r\n".
	    "/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n".
	    "/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n".
	    "/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n".
	    "/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;\r\n".
	    "/*!40103 SET TIME_ZONE='+00:00' */;\r\n".
	    "/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;\r\n".
	    "/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;\r\n".
	    "/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;\r\n".
	    "/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;\r\n";
	foreach($tables as $table){
	    if(empty($table)) continue;
	    $result=$conn->fetchAll('SELECT * FROM `'.$table.'`');
	    if(!empty($result[0])) $fields_amount=count($result[0]); else $fields_amount=0;
	    if(!empty($result)) $rows_num=count($result); else $rows_num=0;

	    $TableMLine=$conn->fetchAll('SHOW CREATE TABLE '.$table);
	    $content.="\n\nDROP TABLE IF EXISTS `".$table."`;\n";
	    $content.="".$TableMLine[0]["Create Table"].";\n";
	    
	    if(!empty($result)){
		$content.="\nINSERT INTO ".$table." VALUES";
		foreach($result as $row){$length=count($result[0]);break;}
		for($i=0;$i<count($result);$i++){
		    $content.="\n("; 
		    $j=0;
		    foreach($result[$i] as $row){
			$j++;
			if($j==$length) $content.="'".$row."'";
			else $content.="'".$row."',";
		    }
		    $content.="),"; 
		}
		$content=substr_replace($content,";",-1);
		$content.="\n\n";
	    }
	}
	$content.=
	    "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 ".
	    "SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 ".
	    "SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
	
	
	$path=$this->get('kernel')->getRootDir().'/../web/backup/';
	$fileNumber=1;
	while(file_exists($path.$name."_".date("Y-m-d").'_file'.$fileNumber.".sql"))$fileNumber++;
	$fp=fopen($path.$name."_".date("Y-m-d").'_file'.$fileNumber.".sql","w");
	fputs($fp,$content);
	fclose($fp);
    }
    
    //import bazy
    private function database_import($filename){
	$con=$this->getDoctrine()->getConnection();	
	$path=$this->get('kernel')->getRootDir().'/../web/backup/';
	$sql='';
	$lines=file($path.$filename);
	foreach($lines as $line){
	    if(substr($line,0,2)=='--'||$line=='') continue;
	    $sql.=$line;
	}
	$con->prepare($sql)->execute();
    }
    
    //sprawdzanie przerwy technicznej
    public function technicalBreak($controller){
	$technicalBreak=$controller
	    ->getDoctrine()
	    ->getRepository(Constant::class)
	    ->findOneBy(['name'=>'technical_break']);
	
	if(empty($technicalBreak) || $technicalBreak->getValue()==1) return true;
	else return false;
    }
    
    /**
     * @Route("/przerwa_techniczna", name="technical_break")
     */
    public function renderTechnicalBreak(){
	return $this->render('admin/technical_break.html.twig');
    }
}