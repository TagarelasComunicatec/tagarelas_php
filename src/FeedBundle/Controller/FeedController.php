<?php

namespace FeedBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FeedController extends Controller
{
    public function feedAction()
    {
        return $this->render('FeedBundle:Feed:feed.html.twig');
    }
    
}
