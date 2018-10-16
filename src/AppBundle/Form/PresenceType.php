<?php

namespace AppBundle\Form;

use AppBundle\Entity\Terminarz;
use AppBundle\Entity\Uczniowie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PresenceType extends AbstractType{
    
    public  $em;
    
    public function __construct(EntityManagerInterface $em){
        $this->em=$em;
    }
    
    public function buildForm(FormBuilderInterface $builder,array $options){
	$em=$this->em;
	$term=$em->getRepository(Terminarz::class)->find($options['id']);
	$students=$em->getRepository(Uczniowie::class)->findBy(['klasa'=>$term->getKlasa()]);
	
	$presenceArray=['Obecny'=>1,'Nieobeny'=>0];
	
        $builder->setMethod('POST')
	    ->add('temat',TextType::class)
	    ->add('opis',TextareaType::class,['required'=>false])
	    ->getForm();
	
	for($i=0;$i<count($students);$i++)
	    $builder->add($students[$i]->getId(),ChoiceType::class,['label'=>$students[$i]->getImie()." ".$students[$i]->getNazwisko(),'data'=>1,'choices'=>$presenceArray]);
	
	$builder->add('submit',SubmitType::class);
    }
    
    public function configureOptions(OptionsResolver $resolver){
	$resolver->setDefaults(['id'=>null]);
    }
}
