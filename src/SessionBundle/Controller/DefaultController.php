<?php

namespace SessionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SessionBundle:Default:index.html.twig');
    }
}
