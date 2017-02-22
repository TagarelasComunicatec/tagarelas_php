<?php
namespace ProfileBundle\Service;


use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\EntityManager;

class ProfileService {
	protected $entity;
	private   $container;
	
	public function __construct(EntityManager $em, Container $cont){
		$this->entity = $em;
		$this->container = $cont;
	}
	
	public function findUserByEmail(string $email){
		$qb = $this->entity->createQueryBuilder();
		$qb->select('u')
			->from('User', 'u')
			->where('u.email LIKE :email')
	   	    ->setParameter('email', '%"' . $email . '"%');
	   	return $qb->getQuery()->getResult();
	}
	
}