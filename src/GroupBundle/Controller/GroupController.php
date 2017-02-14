<?php

namespace GroupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GroupController extends Controller
{
    public function indexAction()
    {
        return $this->render('GroupBundle:Group:index.html.twig');
    }
}
