<?php

namespace GroupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GroupBundle\Service\GroupService;
use Symfony\Component\HttpFoundation\Response;

class GroupController extends Controller
{
	public function indexAction()
	{
		return $this->render('GroupBundle:Group:index.html.twig');
	}
	public function createGroupAction()
	{
		return $this->render('GroupBundle:Group:new.html.twig');
	}
	public function editGroupAction()
	{
		return $this->render('GroupBundle:Group:edit.html.twig');
	}
	
	public function sessionsGroupAction()
	{
		return $this->render('GroupBundle:Group:sessionsgroup.html.twig');
	}
	
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
	
	public function saveNewGroupAction(){
		 $groupService = $this->get("group.services");
		 $myResult  =	$groupService->save();
		 $myReturn    = array (
							"responseCode" => 200,
							"result" => $myResult,
					);
		 $returnJson = json_encode ( $myReturn );
		 return new Response ( $returnJson, 200, array (
		 		'Content-Type' => 'application/text'
		 ) );
	}
	
	public function loadGroupsByStatusAction() {
		$groupService = $this->get("group.services");
		$logger = $this->get('logger');
		$myResult     =	$groupService->loadGroupByStatus($logger);
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
