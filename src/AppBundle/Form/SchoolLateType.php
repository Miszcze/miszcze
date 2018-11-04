<?php

namespace AppBundle\Form;

use AppBundle\Entity\Terminarz;
use AppBundle\Entity\Uczniowie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SchoolLateType extends AbstractType{
    
    public  $em;
    
    public function __construct(EntityManagerInterface $em){
        $this->em=$em;
    }
    
    public function buildForm(FormBuilderInterface $builder,array $options){
	$em=$this->em;
	$term=$em->getRepository(Terminarz::class)->find($options['id']);

	if(isset($term)){
	    $students=$em
		->getRepository(Uczniowie::class)
		->studentsWhere15minLastTerm($term->getId());

	    foreach($students as $value)
		$choicesStudent[$value->getNumerLegitymacji()]=$value->getId();
	}
	
        $builder->setMethod('POST')
	    ->add('uczen',ChoiceType::class,['choices'=>@$choicesStudent])
	    ->add('submit',SubmitType::class)
	    ->getForm();
    }
    
    public function configureOptions(OptionsResolver $resolver){
	$resolver->setDefaults(['id'=>null]);
    }
}
