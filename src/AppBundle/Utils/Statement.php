<?php

namespace AppBundle\Utils;

use Symfony\Component\HttpFoundation\Session\Session;

class Statement{
    
    private $role;
    
    public function __construct(){

    }
    
    public function setGlobal(){
	$session=new Session();
	
//	$this->container->get('twig')->addGlobal('dupa','cipka');
	
    }
}