<?php

namespace FeedBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class FeedController extends Controller
{
    /**
     * @Route("/feed", name="feed_homepage")
     */
    public function feedAction()
    {
        return $this->render('FeedBundle:Feed:feed.html.twig');
    }
    
}
