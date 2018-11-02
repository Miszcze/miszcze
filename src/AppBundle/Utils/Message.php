<?php

namespace AppBundle\Utils;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class Message{
    
    public  $em;
    
    public function __construct(EntityManagerInterface $em){
        $this->em=$em;
    }
    
    public function count(){

	$session=new Session();
	
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
		"WHERE w.odbiorca=".$sessionUserId." AND w.odczytana=0"
	    )
	    ->getResult();
		
	if($messages[0]['countMessages']>0)
	    $session->set('newMessages',$messages[0]['countMessages']);
	else
	    $session->remove('newMessages');
    }
}

/*
namespace AppBundle\Utils;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class Message extends Controller{
    
    public function count($controller){
	$entityManager=$controller->getDoctrine()->getManager();
	
	$sessionUserId=$controller->get('session')->get('user');
	if(isset($sessionUserId))
	    $sessionUserId=$controller->get('session')->get('user')['user']->getId();
	else 
	    $sessionUserId=0;
	
	$messages=$entityManager->createQuery(
	        "SELECT count(w.id) countMessages ".
		"FROM AppBundle\Entity\Wiadomosci w ".
		"JOIN AppBundle\Entity\Uzytkownicy u ".
		"WITH w.odbiorca=u.id ".
		"WHERE w.odbiorca=".$sessionUserId." AND w.odczytana=0"
	    )
	    ->getResult();
	
	if($messages[0]['countMessages']>0)
	    $controller->get('twig')->addGlobal('newMessages',$messages[0]['countMessages']);
    }
}
*/