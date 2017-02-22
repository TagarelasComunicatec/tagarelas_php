<?php
namespace ProfileBundle\Service;


use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;

class ProfileService {
	protected $entity;
	private   $container;
	private   $logger;
	
	public function __construct(EntityManager $em, Container $cont, Logger $log){
		$this->entity = $em;
		$this->container = $cont;
		$this->logger = $log;
	}
	
	public function findUserByEmail($email){
		$qb = $this->entity->createQueryBuilder();
		$qb->select('u.id')
			->from('AppBundle:User', 'u')
			->where('u.email LIKE :email')
	   	    ->setParameter('email', $email );
		
		$myReturn =  $qb->getQuery()->getResult();
	   	$this->logger->err("Type of myReturn da query executada". gettype($myReturn));
		
	   	return $myReturn;
	}
	
}