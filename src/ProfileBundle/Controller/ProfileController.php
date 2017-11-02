<?php

namespace ProfileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use ProfileBundle\Service\ProfileService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends Controller {
    
    /**
     * @Route("/profile", name="profile_homepage")
     */
    public function indexAction()
    {
        return $this->render('ProfileBundle:Profile:index.html.twig');
    }
    
    /** 
     * @Route("/profile/edit", options={"expose"=true}, name="profile_edit")
     */
    public function editAction(){
     	return $this->render('ProfileBundle:Profile:edit.html.twig');
    }    
    
    /**
     * @Route("/profile/cancelprofile", name="profile_cancelprofile")
     */ 
    public function cancelProfileAction(){
      	return $this->render('ProfileBundle:Profile:cancelprofile.html.twig');
    }
    
    /**
     * @Route("/profile/canceledprofile", name="profile_canceledprofile")
     */
    public function calceledProfileAction(){
     	$profileService = $this->get('profile.services');
        $profileService->cancelUser();
      	return $this->render('default/login.html.twig');
    }
    
    /**
     * @Route("/profile/changessword", name="profile_changepassword")
     */
    public function changePasswordAction(){
       	return $this->render('ProfileBundle:Profile:changepassword.html.twig');
    }
    
    /**
     * @Route("/profile/savechangedpassword", name="profile_savechangepassword")
     */
    public function saveChangedPasswordAction(){
        	$profileService = $this->get('profile.services');
        	$myReturn = array();
        	try{
        		$profileService->saveChangedPassword();
        		$myReturn = array (
        				"responseCode" => 200,
        				"result" => ProfileService::SUCCESS_SAVE,
        		);
        	} catch (\Exception $e){
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
    
    /**
     * @Route(" /profile/loaduser", name="profile_loaduser")
     */ 
    public function loadUserAction(){
        	$request     = $this->container->get('request_stack')->getCurrentRequest();
        	$session = $request->getSession();
        	$profileService = $this->get ( 'profile.services' );
        	$result = $profileService->findUserByUsernameOrEmail($session->get("username"));
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
    
    /**
     * @Route(" /profile/loadallusers", name="profile_loadallusers")
     */
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
  
    /**
     * @Route("/profile/checkemail", name="profile_checkemail")
     */ 
    public function checkEmailAction(){
        	$request = $this->container->get('request_stack')->getCurrentRequest();
        	$email         = $request->get("email");
        	$profileService = $this->get('profile.services');
        	$myReturn = [ ];
        	try {
        	        $result    = $profileService->findUserByUsernameOrEmail($email);
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
    
    /**
     * @Route("/profile/checkshortname", name="profile_checkshortname")
     */
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
    
    /**
     * @Route("/profile/saveuser", name="profile_saveuser")
     */
    public function saveUserAction() {
        	$profileService = $this->get('profile.services');
        	try{
        	    $profileService->updateUserData();
        		$myReturn = array (
        				"responseCode" => 200,
        				"result" => ProfileService::SUCCESS_SAVE,
        		);
        	} catch (\Exception $e){
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
    
    /**
     * @Route("/profile/new", name="profile_new")
     */ 
    public function newAction(){
        	$profileService = $this->get('profile.services');
        	try{
        		$profileService->save();
        		$myReturn = array (
        				"responseCode" => 200,
        				"result" => ProfileService::SUCCESS_SAVE,
        		);
        	} catch (\Exception $e){
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
