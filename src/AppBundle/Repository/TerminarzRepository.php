<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TerminarzRepository extends EntityRepository{

    public function termWhereTeacher($id){
	
	return $this
	    ->createQueryBuilder('t')
	    ->select('t')
	    ->join('t.ktoCo','p')
	    ->join('p.prowadzacy','tt')
	    ->where('tt.id='.$id)
	    ->getQuery()
	    ->getResult();
    }

    public function groupBytermWhereTeacher($id){
	
	return $this
	    ->createQueryBuilder('t')
	    ->select('t')
	    ->join('t.ktoCo','p')
	    ->join('p.prowadzacy','tt')
	    ->where('tt.id='.$id)
	    ->groupBy('t.ktoCo')
	    ->getQuery()
	    ->getResult();
    }
}
