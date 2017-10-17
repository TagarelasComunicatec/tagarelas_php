<?php
namespace GroupBundle\Service;


use AppBundle\Openfire\Ofgroup as Group;
use AppBundle\Openfire\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr\Join;
use Monolog\Logger;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Openfire\Ofgroupuser as GroupUser;
use AppBundle\Entity\Rule;

class FeedService {
	
	protected $em;
	private   $container;
	private   $logger;
	
	public function __construct(EntityManager $entityManager, Container $cont, Logger $log){
		$this->em = $entityManager;
		$this->container = $cont;
		$this->logger = $log;
	}
	
}