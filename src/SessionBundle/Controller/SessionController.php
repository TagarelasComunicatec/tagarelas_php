<?php

namespace SessionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SessionController extends Controller
{
    public function indexAction()
    {
        return $this->render('SessionBundle:Session:index.html.twig');
    }
}
