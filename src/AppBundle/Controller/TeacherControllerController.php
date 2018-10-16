<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Klasy;
use AppBundle\Entity\Obecnosci;
use AppBundle\Entity\Terminarz;
use AppBundle\Entity\Uczniowie;
use AppBundle\Entity\Zajecia;
use AppBundle\Form\PresenceType;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/nauczyciel")
 */
class TeacherControllerController extends Controller{
    
    /**
     * @Route("/obecnosci/{term}", name="presence", defaults={"term"="0"})
     */
    public function presenceAction(Request $request,$term){
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
	    
	    return $this->redirectToRoute('presence');
	}
	
	if(isset($form))
	    return $this->render('teacher/presence.html.twig',[
		'term'=>$term,
		'terms'=>$terms,
		'form'=>$form->createView()
	    ]);
	else
	    return $this->render('teacher/presence.html.twig',[
		'term'=>null,	
		'terms'=>$terms,
		'form'=>null
	    ]);
    }
    
    /**
     * @Route("/oceny/{term}/{student}", name="rating", defaults={"term"="0","student"="0"})
     */
    public function ratingAction($term,$student){
	$em=$this->getDoctrine()->getManager();
	
	$terms=$em->getRepository(Terminarz::class)->findAll();
	$students=$em->getRepository(Uczniowie::class)->findAll();
	
	return $this->render('teacher/rating.html.twig',[
	    'terms'=>$terms,
	    'students'=>$students
	]);
    }
}
