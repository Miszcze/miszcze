<?php

namespace AppBundle\Utils;

class GenerateString{

    public $length;
    public $characters;
    
    public function __construct($length=10,$characters='ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'){
	$this->length=$length;
	$this->characters=$characters;
    }
    
    public function setLength($length){
	$this->length=$length;
    }
    
    public function getLength(){
	return $this->length;
    }
    
    public function setCharacters($characters){
	$this->characters=$characters;
    }
    
    public function getCharacters(){
	return $this->characters;
    }
    
    function getGenerateString(){
	$charactersLength=strlen($this->characters)-1;
	$string='';
	for($i=0;$i<$this->length;$i++) $string.=$this->characters[rand(0,$charactersLength)];
	
	return $string;
    }
}
