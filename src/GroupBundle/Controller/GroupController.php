<?php

namespace GroupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GroupBundle\Service\GroupService;
use Symfony\Component\HttpFoundation\Response;
use ProfileBundle\Service\ProfileService;
use AppBundle\Utility\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class GroupController extends Controller
{
    /**
     * @Route("/group", name="group_homepage")
     */
    public function indexAction()
	{
		return $this->render('GroupBundle:Group:index.html.twig');
	}

	/**
	 * @Route("/group/new", name="group_create")
	 */
	public function createGroupAction()
	{
		return $this->render('GroupBundle:Group:new.html.twig');
	}
	
	/**
	 * @Route("/group/edit", name="group_edit")
	 */
	public function editGroupAction()
	{
		return $this->render('GroupBundle:Group:edit.html.twig');
	}
	
	/**
	 * @Route("/group/sessions", name="group_sessions")
	 */ 
	public function sessionsGroupAction()
	{
		return $this->render('GroupBundle:Group:sessionsgroup.html.twig');
	}
	
	/**
	 * @Route("/group/loadallgroups", name="group_loadallgroups")
     */ 
	public function loadAllGroupsAction(){
		$groupService = $this->get("group.services");
		$returnCode  =	$groupService->loadAllGroups();
		$myReturn    = array (
				"responseCode" => 200,
				"result" => $returnCode,
		);
		$returnJson = json_encode ( $myReturn );
		return new Response ( $returnJson, 200, array (
				'Content-Type' => 'application/text'
		) );
	}
	
	/**
	 * @Route("/group/loadimagegroup", name="group_uploadimage")
	 */ 
	public function loadImageGroupAction(){

		$groupService = $this->get('group.services');
		$filename = $groupService->persistImage();
		
		$myReturn = array (
				     'status' => "success",
				     'fileUploaded' => true,
					 'responseCode' => 200,
					 'result' => $filename,
					);              
		$returnJson = json_encode ( $myReturn );
		return new Response ( $returnJson, 200, array (
				'Content-Type' => 'application/text'
				) );
		
	}
	
	/**
	 * @Route("/group/checkname", name="group_checkgroupname")
	 */
	public function checkGroupByNameAction(){
		$request  = $this->container->get('request_stack')->getCurrentRequest();
		$groupName = $request->get("groupName");
		$groupService = $this->get('group.services');
		$myReturn = [ ];
		try {
			$result    = $groupService->findGroupByKey(GroupService::FIND_BY_NAME,$groupName);
			$returnCode = (count($result) > 0 )? GroupService::NAME_FOUND:
												 GroupService::NAME_NOT_FOUND;
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
	 * @Route("/group/save_new_group", name="group_savenewgroup")
	 */
	public function saveNewGroupAction(){
		try {  
		     $groupService = $this->get("group.services");
		     $myResult     =	$groupService->save();
		     //--------------------------
		     // Save users for the group
		     //--------------------------
		     $this->saveGroupUsers();
		     $myReturn     = array (
							"responseCode" => 200,
							"result" => $myResult,
			  );
		     $returnJson = json_encode ( $myReturn );
		     return new Response ( $returnJson, 200, array (
		 		'Content-Type' => 'application/text'
		     ) );
		     
		} catch (\Exception $e){
		 	throw $e;    	
	    }
	}
	
	/**
	 * Save all users from a group
	 */
	private function saveGroupUsers(){
		$profileService  = $this->get("profile.services");
		$request 		 = $this->container->get('request_stack')->getCurrentRequest();
		$groupname 		 = $request->get("groupName");
		$users			 = Utils::convertToArray($request->get("users"));
		/*
		 * Save the administrator
		 */
		$username = $this->container->get('session')->get('username');
		if ($username != null){
			$profileService->addUserToGroup($username,$groupname);
		}
		/*
		 * Save the other components
		 */
		if (! empty($users)) // Users selected.
			foreach($users as $user){
				$profileService->addUserToGroup($user,$groupname, $this->get("group.services"));
			}
	
	}
	
	/**
	 * @Route("/group/loadusergroups", name="group_loadUserGroups")
	 */ 
	public function loadUserGroupsAction() {
		$groupService = $this->get("group.services");
		$myResult     =	$groupService->loadUserGroups();
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
