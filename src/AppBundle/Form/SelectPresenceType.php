<?php

namespace AppBundle\Form;

use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class SelectPresenceType extends AbstractType{
    
//    public  $em;
//    
//    public function __construct(EntityManagerInterface $em){
//        $this->em=$em;
//    }
    
    public function buildForm(FormBuilderInterface $builder,array $options){
//	$terms=$this->em->getRepository(Terminarz::class)->findAll();
//	
//	foreach($terms as $value)
//	    $choices[$value->getId()]=$value->getId();
	
	$builder
	    ->setMethod('GET')
//	    ->setAction($this->generateUrl('teacher_select_presence'))
	    ->add('dzien',DateType::class,['widget'=>'single_text','data'=>new DateTime()])
//	    ->add('zajecia',ChoiceType::class,['choices'=>$choices])
	    ->add('submit',SubmitType::class)
	    ->getForm();
    }
}
