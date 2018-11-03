<?php

namespace AppBundle\Form;

//use AppBundle\Entity\Klasy;
use AppBundle\Entity\Przedmioty;
use AppBundle\Entity\Uczniowie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SelectRatingType extends AbstractType{
    
    public  $em;
    
    public function __construct(EntityManagerInterface $em){
        $this->em=$em;
    }
    
    public function buildForm(FormBuilderInterface $builder,array $options){
	
//	$class=$this->em->getRepository(Klasy::class)->findOneBy(['wychowawca'=>$options['id']]);
//	$students=$this->em->getRepository(Uczniowie::class)->studentsWhereClassTeacher($class->getId());
	$students=$this->em->getRepository(Uczniowie::class)->studentsWhereClassTeacher($options['id']);
	
	$subjects=$this->em->getRepository(Przedmioty::class)->findAll();
	
	foreach($students as $value)
	    $choiceStudens[$value->getNumerLegitymacji()]=$value->getId();
	
	foreach($subjects as $value)
	    $choiceSubjects[$value->getPrzedmiot()->getNazwa()]=$value->getId();
	
	$builder
	    ->setMethod('GET')
	    ->add('uczen',ChoiceType::class,['choices'=>@$choiceStudens])
	    ->add('przedmiot',ChoiceType::class,['choices'=>$choiceSubjects])
	    ->add('submit',SubmitType::class)
	    ->getForm();
    }
    
    public function configureOptions(OptionsResolver $resolver){
	$resolver->setDefaults(['id'=>null]);
    }
}
