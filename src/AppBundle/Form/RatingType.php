<?php

namespace AppBundle\Form;

use AppBundle\Entity\Uczniowie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RatingType extends AbstractType{
    
    public  $em;
    
    public function __construct(EntityManagerInterface $em){
        $this->em=$em;
    }
    
    public function buildForm(FormBuilderInterface $builder,array $options){
	$student=$this->em->getRepository(Uczniowie::class)->find($options['id']);
	
	$ratingArray=[
	    '6'=>6,'5+'=>5.25,'5'=>5,'5-'=>4.75,'4+'=>4.25,'4'=>4,'4-'=>3.75,'3+'=>3.25,
	    '3'=>3,'3-'=>2.75,'2+'=>2.25,'2'=>2,'2-'=>1.75,'1+'=>1.25,'1'=>1
	];
	$typeRatingArray=[
	    'sprawdzian'=>'sprawdzian','kartkówka'=>'kartkówka',
	    'odpowiedź'=>'odpowiedź','praca domowa'=>'praca domowa'
	];
	
        $builder->setMethod('POST')
	    ->add('ocena',ChoiceType::class,['choices'=>$ratingArray])
	    ->add('typ',ChoiceType::class,['choices'=>$typeRatingArray])
	    ->add('submit',SubmitType::class)
	    ->getForm();
    }
    
    public function configureOptions(OptionsResolver $resolver){
	$resolver->setDefaults(['id'=>null]);
    }
}
