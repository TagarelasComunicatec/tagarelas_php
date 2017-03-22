<?php

namespace SessionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use SessionBundle\Service\SessionService;

class SessionController extends Controller
{
    public function indexAction()
    {
        return $this->render('SessionBundle:Session:index.html.twig');
    }
    
    public function mySessionsAction()
    {
    	return $this->render('SessionBundle:Session:mysessions.html.twig');
    }
    
    public function newSessionAction()
    {
    	return $this->render('SessionBundle:Session:new.html.twig');
    }
    
    public function saveSessionAction()
    {
    	$sessionService = $this->get("session.services");
    	$returnCode  =	$sessionService->save();
    	$myReturn    = array (
    			"responseCode" => 200,
    			"result" => $returnCode,
    	);
    	$returnJson = json_encode ( $myReturn );
    	return new Response ( $returnJson, 200, array (
    	) );
    }
    
    public function checkSessionByNameAction(){
    	
    	$request = $this->container->get('request_stack')->getCurrentRequest();
    	$email         = $request->get("sessionName");
    	$sessionService = $this->get('session.services');
    	$myReturn = [ ];
    	
    	try {
    		$result    = $sessionService->findSessionByName($email);
    		$returnCode = (count($result) > 0 )? SessionService::SESSION_NOT_FOUND:
    											 SessionService::SESSION_FOUND;
    		$myReturn = array (
    				"responseCode" => 200,
    				"result" => $returnCode,
    		);
    		 
    	} catch( \Exception $e){
    		$myReturn = array (
    				"responseCode" => 400,
    				"result" => $e->getTraceAsString(),
    				"method" => $request->getMethod()
    		);
    	}
    	 
    	$returnJson = json_encode ( $myReturn );
    	return new Response ( $returnJson, 200, array (
    			'Content-Type' => 'application/text'
    	) );
    }
    
    public function loadSessionByStatusAction() {
    	$sessionService = $this->get("Session.services");
    	$myResult     =	$sessionService->loadSessionByStatus();
    	$myReturn    = array (
    			"responseCode" => 200,
    			"result" => $myResult,
    	);
    	$returnJson = json_encode ( $myReturn );
    	return new Response ( $returnJson, 200, array (
    			'Content-Type' => 'application/text'
    	) );
    }
    
    
}
