<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Klasy;
use AppBundle\Entity\Terminarz;
use AppBundle\Entity\Uczniowie;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * @Route("/nauczyciel")
 */
class TeacherControllerController extends Controller{
    
    /**
     * @Route("/obecnosci/{term}", name="presence", defaults={"term"="0"})
     */
    public function presenceAction($term){
	$em=$this->getDoctrine()->getManager();
	
	$terms=$em->getRepository(Terminarz::class)->findAll();
	$students=$em->getRepository(Uczniowie::class)->findAll();
	
	$form=$this->createFormBuilder()
	    ->setMethod('POST')
	    ->add('temat',TextType::class)
	    ->getForm();
	
	for($i=0;$i<count($students);$i++)
	    $form->add($students[$i]->getId(),CheckboxType::class,['label'=>$students[$i]->getImie()." ".$students[$i]->getNazwisko(),'required'=>false]);
	$form->add('submit',SubmitType::class);
	
	return $this->render('teacher/presence.html.twig',[
	    'terms'=>$terms,
	    'form'=>$form->createView()
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
