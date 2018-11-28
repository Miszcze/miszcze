<?php

namespace AppBundle\Form;

use AppBundle\Entity\Pracownicy;
use AppBundle\Entity\Uczniowie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\Query\Expr\Join;

class RateTeacherType extends AbstractType{
    
    public  $em;
    
    public function __construct(EntityManagerInterface $em){
        $this->em=$em;
    }
    
    public function buildForm(FormBuilderInterface $builder,array $options){
        $questions=[
            'Jakość prowadzenia lekcji przez Nauczyciela.',
            'Punktualność w sprawdzaniu kartkówek/sprawdzianów.',
            'Zachowanie nauczyciela na lekcji.',
            'Przekazywanie wiedzy przez nauczyciela.',
            'Wstawianie plusów podczas zajęć.',
            'Nie przetrzymywanie uczniów po dzwonku.',
            'Nie je oraz nie pije podczas zajęć.',
            'Nie wychodzi z klasy zostawiając uczniom jakieś zadanie.',
            'Nie wychodzi do toalety podczas zajęć.',
            'Nie wmawia uczniom, że uczy najważniejszego przedmiotu.'
        ];
        
        $student=$this->em
	    ->getRepository(Uczniowie::class)
	    ->find($options['id']);
        
        $teachers=$this->em
	    ->getRepository(Pracownicy::class)
            ->createQueryBuilder('p')
	    ->select('p')
            ->innerJoin('AppBundle:Przedmioty','s',Join::WITH,'p.id=s.prowadzacy')
            ->innerJoin('AppBundle:Terminarz','z',Join::WITH,'s.id=z.ktoCo')
            ->where('z.klasa='.$student->getKlasa()->getId())
            ->groupBy('p.id')
            ->getQuery()
	    ->getResult();
        
        foreach($teachers as $value)
            $teachersIdArray[]=$value->getId();
        
        foreach($teachers as $value)
            $teachersLabelArray[]=$value->getImie().' '.$value->getNazwisko();
	
	for($i=1;$i<=10;$i++)
            $ratingArray[]=$i;
        

        $builder->setMethod('POST')->getForm();
       
        for($i=0;$i<count($teachersIdArray);$i++)
        for($j=0;$j<count($questions);$j++)
            $builder->add($teachersIdArray[$i].'_'.$j,ChoiceType::class,[
                'choices'=>$ratingArray,
                'label'=>$teachersLabelArray[$i].' - '.$questions[$j],
                'attr'=>['class'=>'form-control  custom-select'],
                'label_attr'=>['class'=>'text-primary']
            ]);

        $builder->add('submit',SubmitType::class,['attr'=>['class'=>'btn btn-primary mt-3','label'=>'Wyślij']]);
    }
    
    public function configureOptions(OptionsResolver $resolver){
	$resolver->setDefaults(['id'=>null]);
    }
}
