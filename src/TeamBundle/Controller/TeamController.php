<?php

namespace TeamBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class TeamController extends Controller
{
    /**
     * @Route("/team")
     */
    public function indexAction()
    {
        return $this->render('TeamBundle:Team:index.html.twig');
    }
}
