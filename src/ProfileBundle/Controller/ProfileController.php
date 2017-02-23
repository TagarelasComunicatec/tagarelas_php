<?php

namespace ProfileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use ProfileBundle\Service\ProfileService;

class ProfileController extends Controller
{
    public function indexAction()
    {
        return $this->render('ProfileBundle:Profile:index.html.twig');
    }
    
    public function editAction()
    {
    	return $this->render('ProfileBundle:Profile:edit.html.twig');
    }
    
    public function checkEmailAction(){
    	$request = $this->container->get('request_stack')->getCurrentRequest();
    	$email         = $request->get("email");
    	$profileService = $this->get('profile.services');
    	try {
    			$result    = $profileService->findUserByEmail($email);
    			$returnCode = (count($result) > 0 )? ProfileService::EMAIL_NOT_FOUND:
    												 ProfileService::EMAIL_FOUND;
    			$myReturn = array (
    				"responseCode" => 200,
    				"result" => $returnCode,
    				"method" => $request->getMethod(),
    				"type of result" => gettype($result),
    				"count of result" => count($result),	
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
    
    public function newAction()
    {
    	$profileService = $this->get('profile.services');
    	try{
    		$profileService->saveUser();
    		$myReturn = array (
    				"responseCode" => 200,
    				"result" => ProfileService::SUCCESS_SAVE,
    		);
    	} catch (Exception $e){
    		$myReturn = array (
    				"responseCode" => 400,
    				"result" => $e->getTraceAsString(),
    				);
     	}
 
     	$returnJson = json_encode ( $myReturn );
    	return new Response ( $returnJson, 200, array (
    			'Content-Type' => 'application/text'
    	) );    	
    }

}
