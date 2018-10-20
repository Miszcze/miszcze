<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Klasy;
use AppBundle\Entity\Obecnosci;
use AppBundle\Entity\Oceny;
use AppBundle\Entity\Terminarz;
use AppBundle\Entity\Uczniowie;
use AppBundle\Entity\Zajecia;
use AppBundle\Form\PresenceType;
use AppBundle\Form\RatingType;
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
     * @Route("/obecnosci/{term}", name="presence", defaults={"term"="0"})
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
     * @Route("/oceny/{term}/{student}", name="rating", defaults={"term"="0","student"="0"})
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
}
