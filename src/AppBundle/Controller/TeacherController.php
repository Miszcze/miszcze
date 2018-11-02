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
use AppBundle\Form\SchoolLateType;
use AppBundle\Form\SchoolNoteType;
use AppBundle\Form\SelectPresenceType;
use AppBundle\Form\SelectRatingType;
use AppBundle\Utils\Message;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/nauczyciel")
 */
class TeacherController extends Controller{
    
    public function __construct(EntityManagerInterface $em){
	(new Message($em))->count();
    }
    
    /**
     * @Route("/sprawdzanie-obecnosci/{term}", name="teacher_check_presence", defaults={"term"="0"})
     */
    public function presenceAction(Request $request,$term){
	$em=$this->getDoctrine()->getManager();
	
	//sprawdzawdzanie czy użytkownik to nauczyciel
	if(!$this->get('session')->has('teacher')){
	    $this->get('session')->set('danger','Nie jesteś nauczycielem.');
	    return $this->redirectToRoute('homepage',[],302);
	}
	
	//tworzenie kominikatu info
	if($this->get('session')->has('info')){
	    $this->get('session')->get('info');
	    $this->get('twig')->addGlobal('info',$this->get('session')->get('info'));
	    $this->get('session')->remove('info');
	}
	
	//utworzenie kominikatu danger
	if($this->get('session')->has('danger')){
	    $this->get('session')->get('danger');
	    $this->get('twig')->addGlobal('danger',$this->get('session')->get('danger'));
	    $this->get('session')->remove('danger');
	}
	
	//pobranie sesji nauczyciela
	$sessionTeacherId=$this->get('session')->get('user')['user']->getId();
	$teacherLogged=$em
	    ->getRepository(Pracownicy::class)
	    ->findOneBy(['uzytkownik'=>$sessionTeacherId]);

	$terms=$em
	    ->getRepository(Terminarz::class)
	    ->termWhereTeacher($teacherLogged->getId());
		
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
		$presence->setObecny($form->get($students[$i]->getNumerLegitymacji())->getData());
		$presence->setZajecia($lesson);
		$em->persist($presence);
	    }
	    $em->flush();
	    
	    $this->get('session')->set('info','Sprawdzono obecność.');
	    return $this->redirectToRoute('teacher_check_presence');
	}
	
	if(isset($form))
	    return $this->render('teacher/presence.html.twig',[
		'term'=>$term,
		'terms'=>$terms,
		'form'=>$form->createView()
	    ]);
	else
	    return $this->render('teacher/presence.html.twig',[
		'terms'=>$terms
	    ]);
    }
    
    /**
     * @Route("/wstawienie-oceny/{term}/{student}", name="teacher_insert_rating", defaults={"term"="0","student"="0"})
     */
    public function ratingAction(Request $request,$term,$student){
	$em=$this->getDoctrine()->getManager();
	
	if(!$this->get('session')->has('teacher')){
	    $this->get('session')->set('danger','Nie jesteś nauczycielem.');
	    return $this->redirectToRoute('homepage',[],302);
	}
	
	if($this->get('session')->has('info')){
	    $this->get('session')->get('info');
	    $this->get('twig')->addGlobal('info',$this->get('session')->get('info'));
	    $this->get('session')->remove('info');
	}
	
	if($this->get('session')->has('danger')){
	    $this->get('session')->get('danger');
	    $this->get('twig')->addGlobal('danger',$this->get('session')->get('danger'));
	    $this->get('session')->remove('danger');
	}
	
	$form=$this->createForm(RatingType::class,null,['id'=>$student]);
	$student=$em->getRepository(Uczniowie::class)->find($student);
	$term=$em->getRepository(Terminarz::class)->find($term);
	
	$sessionTeacherId=$this->get('session')->get('user')['user']->getId();
	$teacherLogged=$em
	    ->getRepository(Pracownicy::class)
	    ->findOneBy(['uzytkownik'=>$sessionTeacherId]);

	$terms=$em
	    ->getRepository(Terminarz::class)
	    ->groupByTermWhereTeacher($teacherLogged->getId());
	
	if(!empty($term)) 
	    $students=$em->getRepository(Uczniowie::class)->findBy(['klasa'=>$term->getKlasa()]);
	if(!empty($student))
	    $ratings=$em
	    ->getRepository(Oceny::class)
	    ->findBy([
		'uczen'=>$student->getId(),
		'przedmiot'=>$term->getKtoCo()->getId()
	    ]);
	
	if($request->isMethod('post')){
	    $form->handleRequest($request);
	    $rating=new Oceny();
	    $rating->setKiedy(new DateTime());
	    $rating->setOcena($form->get('ocena')->getData());
	    $rating->setPrzedmiot($term->getKtoCo());
	    $rating->setUczen($student);
	    $rating->setTyp($form->get('typ')->getData());
	    $rating->setStatus(0);
	    
	    $em->persist($rating);
	    $em->flush();
	    
	    $this->get('session')->set('info','Wstawiono ocenę.');
	    return $this->redirectToRoute('teacher_insert_rating',[
		'term'=>$term->getId(),
		'student'=>$student->getId()
	    ]);
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
	
	if(!$this->get('session')->has('teacher')){
	    $this->get('session')->set('danger','Nie jesteś nauczycielem.');
	    return $this->redirectToRoute('homepage',[],302);
	}
	
	if($this->get('session')->has('info')){
	    $this->get('session')->get('info');
	    $this->get('twig')->addGlobal('info',$this->get('session')->get('info'));
	    $this->get('session')->remove('info');
	}
	
	if($this->get('session')->has('danger')){
	    $this->get('session')->get('danger');
	    $this->get('twig')->addGlobal('danger',$this->get('session')->get('danger'));
	    $this->get('session')->remove('danger');
	}
	
	$lessonHours=$em->getRepository(GodzLek::class)->findAll();
	$teacher=$em->getRepository(Pracownicy::class)->findOneBy(['uzytkownik'=>$this->get('session')->get('user')['user']]);
	$subject=$em->getRepository(Przedmioty::class)->findBy(['prowadzacy'=>$teacher]);
	
	$arrayWeek=['poniedzialek','wtorek','sroda','czwartek','piatek','sobota'];
	for($k=0;$k<count($subject);$k++)
	for($j=0;$j<count($arrayWeek);$j++)
	for($i=0;$i<count($lessonHours);$i++){
	    $lesson=$em
		->getRepository(Terminarz::class)
		->findOneBy([
		    'dzienTygodnia'=>$arrayWeek[$j],
		    'godzina'=>$lessonHours[$i],
		    'ktoCo'=>$subject[$k]
		]);
	    
	    if($k==0) $lessons[$i][$arrayWeek[$j]]=$lesson;
	    elseif(!empty($lesson)) $lessons[$i][$arrayWeek[$j]]=$lesson;
	}
	
	
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
	
	if(!$this->get('session')->has('teacher')){
	    $this->get('session')->set('danger','Nie jesteś nauczycielem.');
	    return $this->redirectToRoute('homepage',[],302);
	}
	
	if($this->get('session')->has('info')){
	    $this->get('session')->get('info');
	    $this->get('twig')->addGlobal('info',$this->get('session')->get('info'));
	    $this->get('session')->remove('info');
	}
	
	if($this->get('session')->has('danger')){
	    $this->get('session')->get('danger');
	    $this->get('twig')->addGlobal('danger',$this->get('session')->get('danger'));
	    $this->get('session')->remove('danger');
	}
	
	$sessionTeacherId=$this->get('session')->get('user')['user']->getId();
	$teacherLogged=$em
	    ->getRepository(Pracownicy::class)
	    ->findOneBy(['uzytkownik'=>$sessionTeacherId]);

	$terms=$em
	    ->getRepository(Terminarz::class)
	    ->createQueryBuilder('t')
	    ->select('t')
	    ->join('t.ktoCo','p')
	    ->join('p.prowadzacy','tt')
	    ->where('tt.id='.$teacherLogged->getId())
	    ->groupBy('t.ktoCo')
	    ->getQuery()
	    ->getResult();
	
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
    
    /**
     * @Route("/spoznienia/{term}", name="teacher_school_late", defaults={"term"="0"})
     */
    public function schoolLateAction(Request $request,$term){
	$em=$this->getDoctrine()->getManager();
	
	if(!$this->get('session')->has('teacher')){
	    $this->get('session')->set('danger','Nie jesteś nauczycielem.');
	    return $this->redirectToRoute('homepage',[],302);
	}
	
	if($this->get('session')->has('info')){
	    $this->get('session')->get('info');
	    $this->get('twig')->addGlobal('info',$this->get('session')->get('info'));
	    $this->get('session')->remove('info');
	}
	
	if($this->get('session')->has('danger')){
	    $this->get('session')->get('danger');
	    $this->get('twig')->addGlobal('danger',$this->get('session')->get('danger'));
	    $this->get('session')->remove('danger');
	}
	
	$sessionTeacherId=$this->get('session')->get('user')['user']->getId();
	$teacherLogged=$em
	    ->getRepository(Pracownicy::class)
	    ->findOneBy(['uzytkownik'=>$sessionTeacherId]);

	$thisTerm=$em
	    ->getRepository(Terminarz::class)
	    ->find($term);
	
	$terms=$em
	    ->getRepository(Terminarz::class)
	    ->createQueryBuilder('t')
	    ->select('t')
	    ->join('t.ktoCo','p')
	    ->join('p.prowadzacy','tt')
	    ->where('tt.id='.$teacherLogged->getId())
	    ->groupBy('t.ktoCo')
	    ->getQuery()
	    ->getResult();
	
	$form=$this->createForm(SchoolLateType::class,null,['id'=>$term]);
	
	if($request->isMethod('post')){
	    $form->handleRequest($request);
	    
	    //obecnosci poprawić!
	    $presence=$em->getRepository(Obecnosci::class)->findOneBy([
		'uczen'=>$form->get('uczen')->getData()
	    ]);
	    
	    $presence->setObecny(2);
	    $em->persist($presence);
	    $em->flush();
	    
	    $this->get('session')->set('info','Wstawiono spóźnienie.');
	    return $this->redirectToRoute('teacher_school_late',['term'=>$term]);
	}
	
	return $this->render('teacher/school_late.html.twig',[
	    'terms'=>$terms,
	    'term'=>$thisTerm,
	    'form'=>$form->createView()
	]);
    }
    
    /**
     * @Route("/obecnosci", name="teacher_select_presence")
     */
    public function selectPresenceAction(Request $request){
	$em=$this->getDoctrine()->getManager();
	
	if(!$this->get('session')->has('teacher')){
	    $this->get('session')->set('danger','Nie jesteś nauczycielem.');
	    return $this->redirectToRoute('homepage',[],302);
	}
	
	if($this->get('session')->has('info')){
	    $this->get('session')->get('info');
	    $this->get('twig')->addGlobal('info',$this->get('session')->get('info'));
	    $this->get('session')->remove('info');
	}
	
	if($this->get('session')->has('danger')){
	    $this->get('session')->get('danger');
	    $this->get('twig')->addGlobal('danger',$this->get('session')->get('danger'));
	    $this->get('session')->remove('danger');
	}
	
	$sessionTeacherId=$this->get('session')->get('user')['user']->getId();
	$teacherLogged=$em
	    ->getRepository(Pracownicy::class)
	    ->findOneBy(['uzytkownik'=>$sessionTeacherId]);
	
	$get=$request->query->get('select_presence');
	
	$presence=$em
	    ->getRepository(Obecnosci::class)
	    ->createQueryBuilder('o')
	    ->select('o')
	    ->join('o.zajecia','z')
	    ->join('z.termin','t')
	    ->join('t.ktoCo','p')
	    ->join('p.prowadzacy','tt')
	    ->where('tt.id='.$teacherLogged->getId())
	    ->andWhere('z.data>:get_data')
	    ->andWhere('z.data<:get_data_end')
	    ->setParameter('get_data',$get['dzien'].' 00:00')
	    ->setParameter('get_data_end',$get['dzien'].' 59:59')
	    ->getQuery()
	    ->getResult();
	
	$form=$this->createForm(SelectPresenceType::class);
	
	return $this->render('teacher/select_presence.html.twig',[
	    'presences'=>$presence,
	    'form'=>$form->createView()
	]);
    }
    
    /**
     * @Route("/oceny/{term}", name="teacher_select_rating", defaults={"term"="0"})
     */
    public function selectRatingAction(Request $request,$term){
	$em=$this->getDoctrine()->getManager();
	
	if(!$this->get('session')->has('teacher')){
	    $this->get('session')->set('danger','Nie jesteś nauczycielem.');
	    return $this->redirectToRoute('homepage',[],302);
	}
	
	if($this->get('session')->has('info')){
	    $this->get('session')->get('info');
	    $this->get('twig')->addGlobal('info',$this->get('session')->get('info'));
	    $this->get('session')->remove('info');
	}
	
	if($this->get('session')->has('danger')){
	    $this->get('session')->get('danger');
	    $this->get('twig')->addGlobal('danger',$this->get('session')->get('danger'));
	    $this->get('session')->remove('danger');
	}
	
	$sessionTeacherId=$this->get('session')->get('user')['user']->getId();
	$teacherLogged=$em
	    ->getRepository(Pracownicy::class)
	    ->findOneBy(['uzytkownik'=>$sessionTeacherId]);
	
	$get=$request->query->get('select_rating');
	
//	$presence=$em
//	    ->getRepository(Obecnosci::class)
//	    ->createQueryBuilder('o')
//	    ->select('o')
//	    ->join('o.zajecia','z')
//	    ->join('z.termin','t')
//	    ->join('t.ktoCo','p')
//	    ->join('p.prowadzacy','tt')
//	    ->where('tt.id='.$teacherLogged->getId())
//	    ->andWhere('z.data>:get_data')
//	    ->andWhere('z.data<:get_data_end')
//	    ->setParameter('get_data',$get['dzien'].' 00:00')
//	    ->setParameter('get_data_end',$get['dzien'].' 59:59')
//	    ->getQuery()
//	    ->getResult();
	
	$rating=$em
	    ->getRepository(Oceny::class)
	    ->createQueryBuilder('o')
	    ->select('o')
	    ->join('o.uczen','u')
	    ->join('o.przedmiot','p')
	    ->where('u.id=:student')
	    ->andWhere('p.id=:subject')
	    ->setParameter('student',$get['uczen'])
	    ->setParameter('subject',$get['przedmiot'])
	    ->getQuery()
	    ->getResult();
	
	$form=$this->createForm(SelectRatingType::class);
	
	return $this->render('teacher/select_rating.html.twig',[
	    'rating'=>$rating,
	    'form'=>$form->createView()
	]);
    }
}