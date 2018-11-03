<?php

namespace AppBundle\Repository;

use DateTime;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class UczniowieRepository extends EntityRepository{
    
    public function studentsWhere15minLastTerm($term){
	
	return $this
	    ->createQueryBuilder('u')
	    ->select('u')
	    ->innerJoin('AppBundle:Obecnosci','o',Join::WITH,'o.uczen=u.id')
	    ->join('o.zajecia','z')
	    ->where('z.data>:now')
	    ->andWhere('o.obecny=0')
	    ->andWhere('z.termin='.$term)
	    ->setParameter('now',new DateTime('-15 minutes'))
	    ->getQuery()
	    ->getResult();
    }
    
    public function studentsWhereClassTeacher($teacher){

	return $this
	    ->createQueryBuilder('u')
	    ->select('u')
	    ->join('u.klasa','k')
	    ->join('k.wychowawca','p')
	    ->where('p.id='.$teacher)
	    ->getQuery()
	    ->getResult();
    }
}
