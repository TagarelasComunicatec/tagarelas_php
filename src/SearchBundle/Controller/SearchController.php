<?php

namespace SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchController extends Controller
{
    public function indexAction()
    {
        return $this->render('SearchBundle:Search:index.html.twig');
    }
}
