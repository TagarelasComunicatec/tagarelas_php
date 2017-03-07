<?php
namespace GroupBundle\Service;


use AppBundle\Entity\Group;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr\Join;
use Monolog\Logger;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\GroupUser;
use AppBundle\Entity\Rule;
use AppBundle\Entity\StatusUser;
use AppBundle\AppBundle;

class GroupService {
	const NAME_FOUND     = 1;
	const NAME_NOT_FOUND = 2;

	const FIND_BY_NAME = 3;
	const FIND_BY_CREATOR = 4;

	protected $em;
	private   $container;
	private   $logger;
	
	public function __construct(EntityManager $entityManager, Container $cont, Logger $log){
		$this->em = $entityManager;
		$this->container = $cont;
		$this->logger = $log;
	}
	
	public function loadAllGroups(){
		$qb = $this->em->createQueryBuilder();
		$qb->select('g.id,g.groupName,count(gu.id) as totalMembers')
		   ->from('AppBundle:Group', 'g')
		   ->join('AppBundle:GroupUser', 'gu', Join::WITH,'gu.idGroup = g.id')
		   ->groupBy('g.id,g.groupName')
		   ->orderBy('g.groupName');
		 $myReturn =  $qb->getQuery()->getResult();
		 return $myReturn;
	}
	/**
	 * Load user groups by status and user
	 */
	public function loadGroupByStatus(){
		$request = $this->container->get('request_stack')->getCurrentRequest();
		$groups = $this->loadAllGroups();
		$userId =  $this->container->get('session')->get('userId');
		$status =  $request->get("status");
		$myReturn = array();
		foreach ($groups as $group){
			$myReturn = $this->loadGroupUserInformation($group, $userId, $status, $myReturn);
		}
		return $myReturn;
	}
	
	/**
	 * @param QueryBuilder $qb
	 * @param Group        $group
	 * @param int		   $userId
	 * @param int		   $status
	 * @param array		   $myReturn
	 */
	private function loadGroupUserInformation($group,$userId,$status, &$myReturn){
		$groupsuser = $this->generateQueryGroupUser($group, $userId, $status);
		foreach($groupsuser as $gu){
			$group["userStatus"] = $gu["userStatus"];
			$myReturn[ ] = $group;
		}
		return $myReturn;
	}
	/**
	 * @param Group        $group
	 * @param int		   $user
	 * @param int		   $status
	 */
	private function generateQueryGroupUser($group,$userId,$status){
		$qb = $this->em->createQueryBuilder();
		$qb->select('gu.id,gu.idUser, gu.idGroup ,gu.userStatus')
			->from('AppBundle:GroupUser', 'gu')
			->where('gu.idGroup = :idGroup')
			->andwhere('gu.idUser = :idUser')
			->andWhere('gu.userStatus = :status')
			->setParameter("idGroup", $group["id"])
			->setParameter('idUser', $userId)
			->setParameter('status', $status);
		return  $qb->getQuery()->getResult();
	}
	
	public function findGroupByKey($key,$value){
		$qb = $this->em->createQueryBuilder();
		$qb->select('g.id,g.groupName,g.avatar,g.createdBy')
			->from('AppBundle:Group', 'g');
		
		if (GroupService::FIND_BY_CREATOR==$key){
			$qb->where('g.createdBy = :value')
	   	       ->setParameter('value', $value );
		} else {
			$qb->where('g.groupName = :value')
			->setParameter('value', $value );
		}
		
		//$this->logger->err("Aviso de emergencia", $qb->__toString());
		$myReturn =  $qb->getQuery()->getResult();
		return $myReturn;
	}
	
	
	public function save(){
		$request = $this->container->get('request_stack')->getCurrentRequest();
		$groupName   = $request->get("groupName");
		if (count($this->findGroupByKey(GroupService::FIND_BY_NAME,$groupName)) >0){
			throw new \Exception('Nome Grupo já está cadastrado. ' .
								 'Não foi possível cadastrar o grupo. ');
		}
		
		$userId        = $this->container->get('session')->get('userId');
		$usersGroup	   = $request->get("users");
		$group         = new Group();
		
		$group->loadByRequest($request)
			   ->setCreatedBy($userId);
	    $this->em->getConnection()->beginTransaction(); // manipulacao de tabelas
		try{
		    $this->em->persist($group);
		    /* Persist the administrator */
		    $this->persistAdministrator($group,$userId);
		    /* Persist the groups elements */
		    $this->persistGroupMembers($group,$userId, $usersGroup);
		    $this->em->flush();
		    $this->em->getConnection()->commit();
		    return Rule::SUCCESS_SAVE;
		} catch(Exception $e){
			$this->em->getConnection()->rollBack();
			$this->logger->error("Conteudo de user by reference " . $e->__toString());
			return Rule::FAIL_SAVE;
		}

	}

	private function persistAdministrator(Group $group,  $userId){
		/*
		 * Persist the groupAdministrator
		 */
		$groupUsers = new GroupUser();
		$groupUsers->setIdGroup($group->getId())
					->setIdUser($userId)
					->setCreatedBy($userId)
					->setUserStatus(StatusUser::ACTIVE)
					->setRules(Rule::ADMIN);
					
		$this->em->persist($groupUsers);
	}
	private function persistGroupMembers(Group $group, $userId, $userGroups){

		foreach($userGroups as $userGroup){
			$groupUsers = new GroupUser();
			$groupUsers->setIdGroup($group->getId())
					   ->setIdUser($userGroup["id"])
					   ->setCreatedBy($userId)
					   ->setUserStatus(StatusUser::PENDING)
					   ->setRules(Rule::USER);
			$this->em->persist($groupUsers);
		}
	}
}