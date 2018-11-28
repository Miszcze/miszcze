<?php

namespace AppBundle\Controller;

use AppBundle\Entity\GodzLek;
use AppBundle\Entity\Klasy;
use AppBundle\Entity\Obecnosci;
use AppBundle\Entity\Ocenianie;
use AppBundle\Entity\Oceny;
use AppBundle\Entity\Pracownicy;
use AppBundle\Entity\Przedmioty;
use AppBundle\Entity\Terminarz;
use AppBundle\Entity\Uczniowie;
use AppBundle\Entity\Uwagi;
use AppBundle\Form\RateTeacherType;
use AppBundle\Form\SelectPresenceType;
use AppBundle\Utils\Message;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/uczen")
 */
class StudentController extends Controller{
    
    public function __construct(EntityManagerInterface $em){
	//liczenie wiadomości do widoków
	(new Message($em))->count();
    }

    /**
     * @Route("/oceny", name="student_rate")
     */
    public function studentRateAction(Request $request){
	$em=$this->getDoctrine()->getManager();
	
	//sprawdzanie przerwy techicznej
	if(AdminController::technicalBreak($this)) return $this->redirectToRoute('technical_break',[],302);
		
	//sprawdzawdzanie czy użytkownik to uczeń
	if(!$this->get('session')->has('student')){
	    $this->get('session')->set('danger','Nie jesteś uczniem.');
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
	
	//formularz
	$subjects=$em->getRepository(Przedmioty::class)->findAll();
	foreach($subjects as $value)
	    $choiceSubjects[$value->getPrzedmiot()->getNazwa()]=$value->getId();
	
	$form=$this->createFormBuilder()
	    ->setMethod('GET')
	    ->add('przedmiot',ChoiceType::class,['choices'=>$choiceSubjects])
	    ->add('submit',SubmitType::class)
	    ->getForm();
	
	//pobranie sesji ucznia
	$sessionStudentId=$this->get('session')->get('user')['user']->getId();
	$student=$em
	    ->getRepository(Uczniowie::class)
	    ->findOneBy(['uzytkownik'=>$sessionStudentId]);
	
	//pobranie filtra (zmienne $_GET)
	$get=$request->query->get('form');
	
	//oceny do wyświetlenia
	$ratings=$em
	    ->getRepository(Oceny::class)
	    ->findBy(['uczen'=>$student,'przedmiot'=>$get['przedmiot']]);
	
	return $this->render('student/rate.html.twig',[
	    'form'=>$form->createView(),
	    'ratings'=>$ratings
	]);
    }
    
    /**
     * @Route("/obecnosci", name="student_presence")
     */
    public function studentPresence(Request $request){
	$em=$this->getDoctrine()->getManager();
	
	//sprawdzanie przerwy techicznej
	if(AdminController::technicalBreak($this)) return $this->redirectToRoute('technical_break',[],302);
			
	//sprawdzawdzanie czy użytkownik to uczeń
	if(!$this->get('session')->has('student')){
	    $this->get('session')->set('danger','Nie jesteś uczniem.');
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
	
	//formularz
	$form=$this->createForm(SelectPresenceType::class);
	
	//pobranie sesji ucznia
	$sessionStudentId=$this->get('session')->get('user')['user']->getId();
	$student=$em
	    ->getRepository(Uczniowie::class)
	    ->findOneBy(['uzytkownik'=>$sessionStudentId]);
	
	//pobranie filtra (zmienne $_GET)
	$get=$request->query->get('select_presence');
	
	//obecności do wyświetlenia
	$presence=$em
	    ->getRepository(Obecnosci::class)
	    ->selectPresenceWhereStudent($student->getId(),$get['dzien']);
	
	return $this->render('student/presence.html.twig',[
	    'form'=>$form->createView(),
	    'presences'=>$presence
	]);
    }
    
    /**
     * @Route("/plan-zajec", name="student_time_table")
     */
    public function studentTimeTable(Request $request){
	$em=$this->getDoctrine()->getManager();
	
	//sprawdzanie przerwy techicznej
	if(AdminController::technicalBreak($this)) return $this->redirectToRoute('technical_break',[],302);
			
	//sprawdzawdzanie czy użytkownik to uczeń
	if(!$this->get('session')->has('student')){
	    $this->get('session')->set('danger','Nie jesteś uczniem.');
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
	
	//pobranie sesji ucznia
	$sessionStudentId=$this->get('session')->get('user')['user']->getId();
	$student=$em
	    ->getRepository(Uczniowie::class)
	    ->findOneBy(['uzytkownik'=>$sessionStudentId]);

	//tworzenie planu zajęć
	$lessonHours=$this->getDoctrine()->getRepository(GodzLek::class)->findAll();
	$class=$this
	    ->getDoctrine()
	    ->getRepository(Klasy::class)
	    ->find($student->getKlasa());

	$arrayWeek=['poniedzialek','wtorek','sroda','czwartek','piatek','sobota'];
	for($j=0;$j<count($arrayWeek);$j++)
	for($i=0;$i<count($lessonHours);$i++)
	$lessons[$i][$arrayWeek[$j]]=$em
	    ->getRepository(Terminarz::class)
	    ->findOneBy([
		'dzienTygodnia'=>$arrayWeek[$j],
		'godzina'=>$lessonHours[$i]->getId(),
		'klasa'=>$class->getId()
	    ]);
	
	return $this->render('student/time_table.html.twig',[
	    'lessonHours'=>$lessonHours,
	    'lessons'=>$lessons
	]);
    }
    
    /**
     * @Route("/uwagi", name="student_school_note")
     */
    public function schoolNoteAction(Request $request){
	$em=$this->getDoctrine()->getManager();
	
	//sprawdzanie przerwy techicznej
	if(AdminController::technicalBreak($this)) return $this->redirectToRoute('technical_break',[],302);
			
	//sprawdzawdzanie czy użytkownik to uczeń
	if(!$this->get('session')->has('student')){
	    $this->get('session')->set('danger','Nie jesteś uczniem.');
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
	
	//pobranie sesji ucznia
	$sessionStudentId=$this->get('session')->get('user')['user']->getId();
	$student=$em
	    ->getRepository(Uczniowie::class)
	    ->findOneBy(['uzytkownik'=>$sessionStudentId]);
	
	$schoolNote=$em
	    ->getRepository(Uwagi::class)
	    ->findBy([
		'uczen'=>$student->getId()
	    ]);
	
	return $this->render('student/school_note.html.twig',[
	    'schoolNote'=>$schoolNote
	]);
    }
    
     /**
     * @Route("/ankieta", name="student_questionnaire")
     */
    public function questionnaire(Request $request){
	$em=$this->getDoctrine()->getManager();
	
	//sprawdzanie przerwy techicznej
	if(AdminController::technicalBreak($this)) return $this->redirectToRoute('technical_break',[],302);
			
	//sprawdzawdzanie czy użytkownik to uczeń
	if(!$this->get('session')->has('student')){
	    $this->get('session')->set('danger','Nie jesteś uczniem.');
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
	
	//pobranie sesji ucznia
	$sessionStudentId=$this->get('session')->get('user')['user']->getId();
	$student=$em
	    ->getRepository(Uczniowie::class)
	    ->findOneBy(['uzytkownik'=>$sessionStudentId]);
	
	//formularz
	$form=$this->createForm(RateTeacherType::class,null,['id'=>$student->getId()]);
	
        //wysłanie ocen do bazy
        if($request->isMethod('post')){
	    $form->handleRequest($request);
            $data=$form->getData();
            foreach($data as $key=>$value){
                $id=explode('_',$key);
                $teacher=$em->getRepository(Pracownicy::class)->find($id[0]);
                $rate=new Ocenianie();
                $rate->setProwadzacy($teacher);
                $rate->setUczen($student);
                $rate->setOcena($value);
                $em->persist($rate);
                $em->flush();
            }
        }
        
	return $this->render('student/questionnaire.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}
