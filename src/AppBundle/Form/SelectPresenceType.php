<?php

namespace AppBundle\Form;

use AppBundle\Entity\Terminarz;
use AppBundle\Entity\Uczniowie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
	    ->add('dzien',DateType::class,['widget'=>'single_text'])
//	    ->add('zajecia',ChoiceType::class,['choices'=>$choices])
	    ->add('submit',SubmitType::class)
	    ->getForm();
    }
}
