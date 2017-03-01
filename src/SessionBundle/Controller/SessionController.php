<?php

namespace SessionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SessionController extends Controller
{
    public function indexAction()
    {
        return $this->render('SessionBundle:Session:index.html.twig');
    }
    
    public function mySessionsAction()
    {
    	return $this->render('SessionBundle:Session:mysessions.html.twig');
    }
    
    public function newSessionAction()
    {
    	return $this->render('SessionBundle:Session:new.html.twig');
    }
}
