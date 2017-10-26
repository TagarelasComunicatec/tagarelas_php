<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
	/**
	 * @Route("/new", name="newLogin")
	 */
	public function newAction()
	{
		return $this->render('ProfileBundle:Profile:new.html.twig');
	}
	
}
