<?php

namespace AppBundle\Utils;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\PhpBridgeSessionStorage;

class Message{
    
    public  $em;
    
    public function __construct($em){
        $this->em=$em;
    }
    
    public function count(){
	$session=new Session(new PhpBridgeSessionStorage());
	$sessionUserId=$session->get('user');
	
	if(isset($sessionUserId))
	    $sessionUserId=$session->get('user')['user']->getId();
	else 
	    $sessionUserId=0;
	
	$messages=$this->em->createQuery(
	        "SELECT count(w.id) countMessages ".
		"FROM AppBundle\Entity\Wiadomosci w ".
		"JOIN AppBundle\Entity\Uzytkownicy u ".
		"WITH w.odbiorca=u.id ".
		"WHERE w.odbiorca=".$sessionUserId." AND w.odczytana=0 AND w.statusOdbiorcy=0"
	    )
	    ->getResult();
		
	if($messages[0]['countMessages']>0)
	    $session->set('newMessages',$messages[0]['countMessages']);
	else if(isset($session))
	    $session->remove('newMessages');
    }
}