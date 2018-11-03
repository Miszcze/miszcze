<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class OcenyRepository extends EntityRepository{
    
    public function selectRating($student,$subject,$teacher){
	
	return $this
	    ->createQueryBuilder('o')
	    ->select('o')
	    ->join('o.uczen','u')
	    ->join('o.przedmiot','p')
	    ->join('u.klasa','k')
	    ->join('k.wychowawca','w')
	    ->where('u.id=:student')
	    ->andWhere('p.id=:subject')
	    ->andWhere('w.id=:teacher')
	    ->setParameter('student',$student)
	    ->setParameter('subject',$subject)
	    ->setParameter('teacher',$teacher)
	    ->getQuery()
	    ->getResult();
    }
}
