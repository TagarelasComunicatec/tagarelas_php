<?php

namespace AboutBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Exception;
use AppBundle\Openfire\Produto;

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
    
    /**
     * @Route("/about/produto", name="produto")
     */
    public function produtoAction() {
        /*
         * Carreta a tela de produto
         */
        return $this->render('AboutBundle:About:produto.html.twig');
        
    }
    /**
     * @Route("/about/saveproduto", name="saveproduto")
     */
    public function saveProdutoAction(){
        $produto = new Produto();
        $request  = $this->container->get('request_stack')->getCurrentRequest();
        $produto->loadByRequest($request);
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        try{ 
           $em->persist($produto);
           $em->flush();
           $em->getConnection()->commit();
        } catch (\Exception $exception) {
            $em->getConnection()->rollBack();
            throw $exception;
        }
        return $this->render('AboutBundle:About:produto.html.twig');
    }
}
