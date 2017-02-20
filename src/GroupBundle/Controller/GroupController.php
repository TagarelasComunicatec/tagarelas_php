<?php

namespace GroupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GroupController extends Controller
{
	public function indexAction()
	{
		return $this->render('GroupBundle:Group:index.html.twig');
	}
	public function createGroupAction()
	{
		return $this->render('GroupBundle:Group:creategroup.html.twig');
	}
	public function editGroupAction()
	{
		return $this->render('GroupBundle:Group:editgroup.html.twig');
	}
	public function sessionsGroupAction()
	{
		return $this->render('GroupBundle:Group:sessionsgroup.html.twig');
	}
}
