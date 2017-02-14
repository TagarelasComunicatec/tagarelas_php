<?php

namespace FeedBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FeedController extends Controller
{
    public function indexAction()
    {
        return $this->render('FeedBundle:Feed:index.html.twig');
    }
}
