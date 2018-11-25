<?php

namespace AppBundle\Repository;

use DateTime;
use Doctrine\ORM\EntityRepository;

class ObecnosciRepository extends EntityRepository{
    
    public function last15minTerms($term,$student){
	
	$ret=$this
	    ->createQueryBuilder('o')
	    ->select('o')
	    ->join('o.zajecia','z')
	    ->where('z.data>:now')
	    ->andWhere('o.obecny=0')
	    ->andWhere('z.termin='.$term)
	    ->andWhere('o.uczen='.$student)
	    ->setParameter('now',new DateTime('-15 minutes'))
	    ->getQuery()
	    ->getResult();
	
	return $ret[0];
    }
    
    public function selectPresence($teacherLogged,$day){
	
	return $this
	    ->createQueryBuilder('o')
	    ->select('o')
	    ->join('o.zajecia','z')
	    ->join('z.termin','t')
	    ->join('t.ktoCo','p')
	    ->join('p.prowadzacy','tt')
	    ->where('tt.id='.$teacherLogged)
	    ->andWhere('z.data>:get_data')
	    ->andWhere('z.data<:get_data_end')
	    ->setParameter('get_data',$day.' 00:00')
	    ->setParameter('get_data_end',$day.' 59:59')
	    ->getQuery()
	    ->getResult();
    }
    
    public function selectPresenceWhereStudent($student,$day){
	
	return $this
	    ->createQueryBuilder('o')
	    ->select('o')
	    ->join('o.zajecia','z')
	    ->join('z.termin','t')
	    ->join('t.ktoCo','p')
	    ->join('o.uczen','u')
	    ->where('u.id='.$student)
	    ->andWhere('z.data>:get_data')
	    ->andWhere('z.data<:get_data_end')
	    ->setParameter('get_data',$day.' 00:00')
	    ->setParameter('get_data_end',$day.' 23:59')
	    ->getQuery()
	    ->getResult();
    }
}
