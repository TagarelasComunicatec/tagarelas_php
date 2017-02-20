<?php

namespace ProfileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProfileController extends Controller
{
    public function indexAction()
    {
        return $this->render('ProfileBundle:Profile:index.html.twig');
    }
    
    public function editAction()
    {
    	return $this->render('ProfileBundle:Profile:edit.html.twig');
    }
    

}
