<?php

namespace SessionBundle\Service;

use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Rule;
use AppBundle\Entity\SessionUser;
use AppBundle\Entity\SessionGroup;

class SessionService {

	const SESSION_FOUND     = 1;
	const SESSION_NOT_FOUND = 2;
	
	protected $em;
	private $container;
	private $logger;

	public function __construct(EntityManager $entityManager, Container $cont, Logger $log) {
		$this->em = $entityManager;
		$this->container = $cont;
		$this->logger = $log;
	}
	public function loadAllSession() {
		$qb = $this->em->createQueryBuilder ();
		$qb->select ( 's.id,s.sessionName,s.description' )->from ( 'AppBundle:Session', 's' );
		$myReturn = $qb->getQuery ()->getResult ();
		
		return $myReturn;
	}
	public function findSessionByName($sessionName) {
		$qb = $this->em->createQueryBuilder ();
		$qb->select ( 's.id,s.sessionName,s.description' )->from ( 'AppBundle:Session', 's' )->where ( 's.sessionName LIKE :sessionName' )->setParameter ( 'sessionName', $sessionName );
		
		$myReturn = $qb->getQuery ()->getResult ();
		
		return $myReturn;
	}
	public function save() {
		$request = $this->container->get ( 'request_stack' )->getCurrentRequest ();
		$sessionName = $request->get ( "sessionName" );
		if (count ( $this->findSessionByName ( $sessionName ) ) > 0) {
			throw new \Exception ( 'Nome da Sessão já está cadastrada. ' . 'Não foi possível cadastrar a sessão. ' );
		}
		
		$userId = $this->container->get ( 'session' )->get ( 'userId' );
		$users = $request->get ( "users" );
		$groups = $request->get ( "groups" );
		
		$session = new \AppBundle\Entity\Session ();
		
		$session->loadByRequest ( $request )
				->setCreatedBy ( $userId )
				->setIdMediator( $userId )
				->setIsDeleted(false);
		
		$this->em->getConnection ()->beginTransaction (); // manipulacao de tabelas
		try {
			$this->em->persist ( $session );
			/* Persist the administrator */
			$this->persistSessionGroups($session, $groups, $userId);
			/* Persist the groups elements */
			$this->persistSessionMembers ( $session, $userId, $users );
			$this->em->flush ();
			$this->em->getConnection ()->commit ();
			return Rule::SUCCESS_SAVE;
		} catch ( Exception $e ) {
			$this->em->getConnection ()->rollBack ();
			$this->logger->error ( "Sessao nao foi salva " . $e->__toString () );
			return Rule::FAIL_SAVE;
		}
	}
	
	private function persistSessionGroups($session, $groups, $userId) {
		foreach ( $groups as $group ) {
			$sessionGroup = new SessionGroup();
			$sessionGroup->setIdSession ( $session->getId () )
						 ->setIdGroup ( $group ["id"] )
			             ->setCreatedBy ( $userId )
					     ->setRules ( Rule::USER );
			$this->em->persist ( $sessionGroup );
		}
	}
	
	
	private function persistSessionMembers($session, $userId, $users) {
		foreach ( $users as $user ) {
			$sessionUser = new SessionUser ();
			$sessionUser->setIdSession ( $session->getId () )
						->setIdUser ( $user ["id"] )
						->setCreatedBy ( $userId )
						->setRules ( Rule::USER );
			$this->em->persist ( $sessionUser );
		}
	}
}