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
    
    public function  loginUserAction(){
    	$profileService = $this->get('profile.services');
    	$myReturn = [ ];
    	try{
    		$result = $profileService->loginUser();
    		$myReturn = array (
    				"responseCode" => 200,
    				"result" => $result,
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
    
    public function editAction()
    {
    	return $this->render('ProfileBundle:Profile:edit.html.twig');
    }    
    
    public function cancelProfileAction(){
    	return $this->render('ProfileBundle:Profile:cancelprofile.html.twig');
    }
    
    public function calceledProfileAction(){
    	$profileService = $this->get('profile.services');
        $profileService->cancelUser();
    	return $this->render('default/login.html.twig');
    }
    
    public function changePasswordAction(){
    	return $this->render('ProfileBundle:Profile:changepassword.html.twig');
    }
    
    public function saveChangedPasswordAction(){
    	$profileService = $this->get('profile.services');
    	$myReturn = array();
    	try{
    		$profileService->saveChangedPassword();
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
    
    public function loadUserAction(){
    	$request     = $this->container->get('request_stack')->getCurrentRequest();
    	$session = $request->getSession();
    	$profileService = $this->get ( 'profile.services' );
    	$result = $profileService->findUserByUsername($session->get("username"));
    	$returnCode = (count ( $result ) > 0) ?
    	        ProfileService::USERS_FOUND : ProfileService::USERS_NOT_FOUND;
    	$myReturn = array (
    	        		"responseCode" => 200,
    	        		"result"       => $returnCode,
    	        		"user"        => $result
   				 	);
    	$returnJson = json_encode ( $myReturn );
    	return new Response ( $returnJson, 200, array (
    	        		'Content-Type' => 'application/text' ) );
    }
    
    
    public function loadAllUsersAction(){
		$profileService = $this->get ( 'profile.services' );
		
		$result = $profileService->loadAllUsers ();
		$returnCode = (count ( $result ) > 0) ? 
						ProfileService::USERS_FOUND : ProfileService::USERS_NOT_FOUND;
		$myReturn = array (
				"responseCode" => 200,
				"result" => $returnCode,
				"users" => $result 
		);
		$returnJson = json_encode ( $myReturn );
		return new Response ( $returnJson, 200, array (
				'Content-Type' => 'application/text' 
		) );
    }
    
    public function checkEmailAction(){
    	$request = $this->container->get('request_stack')->getCurrentRequest();
    	$email         = $request->get("email");
    	$profileService = $this->get('profile.services');
    	$myReturn = [ ];
    	try {
    			$result    = $profileService->findUserByEmail($email);
    			$returnCode = (count($result) > 0 )? ProfileService::EMAIL_NOT_FOUND:
    												 ProfileService::EMAIL_FOUND;
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
    
    public function checkShortNameAction(){
    	$request = $this->container->get('request_stack')->getCurrentRequest();
    	$shortName  = $request->get("shortName");
    	$profileService = $this->get('profile.services');
    	$myReturn = [ ];
    	try {
    		$result    = $profileService->findUserByUsername($shortName);
    		$returnCode = (count($result) > 0 )? ProfileService::SHORTNAME_NOT_FOUND:
    		ProfileService::SHORTNAME_FOUND;
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
    
    public function saveUserAction()
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
    public function newAction()
    {
    	$profileService = $this->get('profile.services');
    	try{
    		$profileService->save();
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
