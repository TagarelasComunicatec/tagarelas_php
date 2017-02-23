<?php
namespace ProfileBundle\Service;


use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use AppBundle\Entity\User;

class ProfileService {
	const EMAIL_NOT_FOUND = 1;
	const EMAIL_FOUND = 2;

	const SUCCESS_SAVE= 3;
	const FAIL_SAVE = 4;
	
	protected $em;
	private   $container;
	private   $logger;
	
	public function __construct(EntityManager $entityManager, Container $cont, Logger $log){
		$this->em = $entityManager;
		$this->container = $cont;
		$this->logger = $log;
	}
	
	public function findUserByEmail($email){
		$qb = $this->em->createQueryBuilder();
		$qb->select('u.id')
			->from('AppBundle:User', 'u')
			->where('u.email LIKE :email')
	   	    ->setParameter('email', $email );
		
		$myReturn =  $qb->getQuery()->getResult();

		return $myReturn;
	}
	
	public function saveUser(){
		$request = $this->container->get('request_stack')->getCurrentRequest();
		$email   = $request->get("email");
		if (count($this->findUserByEmail($email)) >0){
			throw new \Exception('Email já está cadastrado. Não foi possível alterar a informação');
		}
		$user = new User();
		$user->loadByRequest($request);
		$this->em->persist($user);
		$this->em->flush();
	}

}