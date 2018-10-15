<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Terminarz;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

class AdminControllerTest extends WebTestCase{
    
    //zalogowany admin z parametrem dodawanie
    public function testTimeTableAction(){
        $client=static::createClient();
	
	$session=$client->getContainer()->get('session');
	$session->set('admin',true);
	$session->save();
        $crawler=$client->request('GET','/admin/terminarz');
	
        $this->assertEquals(200,$client->getResponse()->getStatusCode());
        $this->assertContains('Dodawanie terminu',$crawler->filter('#container h2')->text());
    }
    
    //zalogowany admin z parametrem edycja
    public function test2TimeTableAction(){
        $client=static::createClient();
	
	$session=$client->getContainer()->get('session');
	$session->set('admin',true);
	$session->save();
        $crawler=$client->request('GET','/admin/terminarz/0/0/1');
	
        $this->assertEquals(200,$client->getResponse()->getStatusCode());
        $this->assertContains('Edytowanie terminu',$crawler->filter('#container h2')->text());
    }
        
    //zalogowany admin z parametrem klasa 1a
    public function test3TimeTableAction(){
        $client=static::createClient();
	
	$session=$client->getContainer()->get('session');
	$session->set('admin',true);
	$session->save();
        $crawler=$client->request('GET','/admin/terminarz/1/a');
	
        $this->assertEquals(200,$client->getResponse()->getStatusCode());
        $this->assertContains('Klasa 1a',$crawler->filter('#container h2')->text());
    }
    
    //niezalogowany admin
    public function test4TimeTableAction(){
        $client=static::createClient();
	
	$client->request('GET','/admin/terminarz');
	
        $this->assertEquals(302,$client->getResponse()->getStatusCode());//302 albo 403
    }
    
//    function test5TimeTableAction(){
//	$client=static::createClient();
//	
//	$session=$client->getContainer()->get('session');
//	$session->set('admin',true);
//	$session->save();
//	$crawler=$client->request('POST','/admin/terminarz');
////	$buttonCrawlerNode=$crawler->selectButton('submit');
//	$form=$crawler->selectButton('Wyślij')->form();
//	
//	$form['form[sala]']=1;
//	$form['form[godzina]']=1;
//	$form['form[dzienTygodnia]']='poniedzialek';
//	$form['form[ktoCo]']=1;
//	$form['form[klasa]']=1;
//	$form['form[typ]']='plan';
//	$form['form[poczatek]']='01-01-2000';
//	$form['form[koniec]']='01-01-2100';
//	
//	$client->submit($form);
//	
//	$this->assertEquals(Response::HTTP_CREATED,$client->getResponse()->getStatusCode());
//    }
}