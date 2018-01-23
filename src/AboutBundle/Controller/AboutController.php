<?php

namespace AboutBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AboutController extends Controller
{
    /**
     * @Route("/about/index")
     */
    public function indexAction()
    {
        return $this->render('AboutBundle:About:index.html.twig');
    }
    
    /**
     * @Route("/about/projeto", name="projeto")
     */
    public function projetoAction()
    {
        return $this->render('AboutBundle:About:projeto.html.twig');

    }
    /**
     * @Route("/about/pesquiseconosco", name="pesquiseconosco")
     */
    public function pesquiseConoscoAction() {
        return $this->render('AboutBundle:About:pesquiseconosco.html.twig');       

    }
}
