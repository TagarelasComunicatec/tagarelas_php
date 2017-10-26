<?php

namespace ChatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ChatController extends Controller
{
    /**
     * @Route("/chat", name="chat_homepage")
     */
    public function indexAction()
    {
        return $this->render('ChatBundle:Chat:index.html.twig');
    }
}
