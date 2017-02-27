<?php
namespace GroupBundle\Service;


use AppBundle\Entity\Group;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Session\Session;

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
	
	
	public function saveGroup(){
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
		
		foreach ($usersGroup as $userGroup){
			$user = $this->em->getReference("AppBundle:User", $userGroup["id"]);
			$group->addUser($user);
		
		}
		
		$this->em->persist($group);
		$this->em->flush();

	}
}