<?php
namespace GroupBundle\Service;


use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use Symfony\Component\DependencyInjection\Container;

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
		$group = new Group();
		$group->loadByRequest($request);
		$this->em->persist($group);
		$this->em->flush();
	}

}