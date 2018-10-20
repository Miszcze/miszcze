<?php

namespace AppBundle\Controller;

use AppBundle\Entity\GodzLek;
use AppBundle\Entity\Obecnosci;
use AppBundle\Entity\Oceny;
use AppBundle\Entity\Pracownicy;
use AppBundle\Entity\Przedmioty;
use AppBundle\Entity\Terminarz;
use AppBundle\Entity\Uczniowie;
use AppBundle\Entity\Uwagi;
use AppBundle\Entity\Zajecia;
use AppBundle\Form\PresenceType;
use AppBundle\Form\RatingType;
use AppBundle\Form\SchoolNoteType;
use AppBundle\Utils\Message;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/nauczyciel")
 */
class TeacherControllerController extends Controller{
    
    /**
     * @Route("/obecnosci/{term}", name="teacher_presence", defaults={"term"="0"})
     */
    public function presenceAction(Request $request,$term){
	(new Message($this))->count($this);
	if(!$this->get('session')->has('teacher')) return $this->redirectToRoute('homepage',[],302);
	if($this->get('session')->has('info')){
	    $info=$this->get('session')->get('info');
	    $this->get('session')->remove('info');
	}
	$em=$this->getDoctrine()->getManager();
	
	$terms=$em->getRepository(Terminarz::class)->findAll();
		
	if(!empty($term)){
	    $form=$this->createForm(PresenceType::class,null,['id'=>$term]);
	    $term=$em->getRepository(Terminarz::class)->find($term);
	}
	
	if($request->isMethod('post')){
	    $form->handleRequest($request);
	    $lesson=new Zajecia();
	    $lesson->setTemat($form->get('temat')->getData());
	    $lesson->setOpis($form->get('opis')->getData());
	    $lesson->setData(new DateTime());
	    $lesson->setTermin($term);
	    $em->persist($lesson);
	    
	    $students=$em->getRepository(Uczniowie::class)->findBy(['klasa'=>$term->getKlasa()]);
	    for($i=0;$i<count($students);$i++){
		$presence=new Obecnosci();
		$presence->setUczen($students[$i]);
		$presence->setObecny($form->get($students[$i]->getId())->getData());
		$presence->setZajecia($lesson);
		$em->persist($presence);
	    }

	    $em->flush();
	    
	    $this->get('session')->set('info','Sprawdzono obecność.');
	    return $this->redirectToRoute('presence');
	}
	
	if(isset($form))
	    return $this->render('teacher/presence.html.twig',[
		'term'=>$term,
		'terms'=>$terms,
		'form'=>$form->createView(),
		'info'=>@$info
	    ]);
	else
	    return $this->render('teacher/presence.html.twig',[
		'terms'=>$terms,
		'info'=>@$info
	    ]);
    }
    
    /**
     * @Route("/oceny/{term}/{student}", name="teacher_rating", defaults={"term"="0","student"="0"})
     */
    public function ratingAction(Request $request,$term,$student){
	$em=$this->getDoctrine()->getManager();
	
	$form=$this->createForm(RatingType::class,null,['id'=>$student]);
	$student=$em->getRepository(Uczniowie::class)->find($student);
	$term=$em->getRepository(Terminarz::class)->find($term);
	$terms=$em->getRepository(Terminarz::class)->findAll();
	if(!empty($term)) 
	    $students=$em->getRepository(Uczniowie::class)->findBy(['klasa'=>$term->getKlasa()]);
	if(!empty($student))
	    $ratings=$em->getRepository(Oceny::class)->findBy(['uczen'=>$student->getId()]);

	if($request->isMethod('post')){
	    $form->handleRequest($request);
	    $rating=new Oceny;
	    $rating->setKiedy(new DateTime());
	    $rating->setOcena($form->get('ocena')->getData());
	    $rating->setPrzedmiot($term->getKtoCo());
	    $rating->setUczen($student);
	    $rating->setTyp($form->get('typ')->getData());
	    $rating->setStatus(0);
	    
	    $em->persist($rating);
	    $em->flush();
	}
	
	return $this->render('teacher/rating.html.twig',[
	    'ratings'=>@$ratings,
	    'term'=>@$term,
	    'terms'=>$terms,
	    'student'=>$student,
	    'students'=>@$students,
	    'form'=>$form->createView()
	]);
    }
    
    
    /**
     * @Route("/plan-zajec", name="teacher_time_table")
     */
    public function timeTableAction(){
	$em=$this->getDoctrine()->getManager();
	
	$lessonHours=$em->getRepository(GodzLek::class)->findAll();
	$teacher=$em->getRepository(Pracownicy::class)->findOneBy(['uzytkownik'=>$this->get('session')->get('user')['user']]);
	$subject=$em->getRepository(Przedmioty::class)->findOneBy(['prowadzacy'=>$teacher]);
	//$timeTable=$em->getRepository(Terminarz::class)->findBy(['ktoCo'=>$subject]);
	
	$arrayWeek=['poniedzialek','wtorek','sroda','czwartek','piatek','sobota'];
	for($j=0;$j<count($arrayWeek);$j++)
	for($i=0;$i<count($lessonHours);$i++)
	$lessons[$i][$arrayWeek[$j]]=$em
	    ->getRepository(Terminarz::class)
	    ->findOneBy([
		'dzienTygodnia'=>$arrayWeek[$j],
		'godzina'=>$lessonHours[$i],
		'ktoCo'=>$subject
	    ]);
	
	return $this->render('teacher/time_table.html.twig',[
	    'lessonHours'=>$lessonHours,
	    'lessons'=>$lessons
	]);
    }
    
    
    /**
     * @Route("/uwagi/{term}/{student}", name="teacher_school_note", defaults={"term"="0","student"="0"})
     */
    public function schoolNoteAction(Request $request,$term,$student){
	$em=$this->getDoctrine()->getManager();
	
	$terms=$em->getRepository(Terminarz::class)->findAll();
	
	if(!empty($term)){
	    $form=$this->createForm(SchoolNoteType::class,null,['id'=>$term]);
	    if($request->getMethod('post')){
		
		
		$schoolNote=new Uwagi();
		$schoolNote->getUczen();
		$schoolNote->setOdczytane(0);
		$schoolNote->setStatus(0);
	    }
	}
	
	if(!isset($form))
	    return $this->render('teacher/school_note.html.twig',[
		'terms'=>$terms
	    ]);
	else
	    return $this->render('teacher/school_note.html.twig',[
		'terms'=>$terms,
		'form'=>$form->createView() 
	    ]);
    }
}