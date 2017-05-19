<?php
namespace AppBundle\Utility;


use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use AppBundle\Openfire\Ofuser;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Utility\AppRest;
use AppBundle\Entity\GroupUser;
use AppBundle\Openfire\Ofgroupuser;
use AppBundle\Openfire\Ofuserprop;


class MailerSender {

	CONST     EMAIL_REGISTRATION = "Emails/registration.html.twig";
	
	private   $container;
	private   $logger;
	private   $subject;
	private   $from;
	private   $to;
	private   $emailBody;
	private   $contents;
	
	
	public function __construct(Container $cont, Logger $log){
		$this->container = $cont;
		$this->logger    = $log;
	}
	
	/**
	 *  
	 */
	public function sendEmail($parameters){
		
	}
}