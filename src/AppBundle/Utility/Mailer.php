<?php
namespace AppBundle\Utility;


use Monolog\Logger;
use Symfony\Component\DependencyInjection\Container;


class MailerSender implements MailerInterface {
	
	private   $container;
	private   $logger;
	private   $subject;
	private   $to;
	private   $emailBody;
	private   $contents;
	
	
	public function __construct(Container $cont, Logger $log){
		$this->container = $cont;
		$this->logger    = $log;
	}
	
	/**
	 * Como funciona o serviço de envio de emails:
	 * 
	 * 1. Crie a pagina .html.twig no diretorio app/Resource/Email/
	 * 2. Em MailerInterface insira o nome do Twig (Veja os anteriores) 
	 * 3. Em sua Controller:
	 *    3.1 	$mailerService = $this->get('mailer.services');
	 *    3.2.  $mailerService-> setSubject("assunto")
	 *                        -> setTo("endereco do destinatario")
	 *                        -> setBody(MailerInterface::<<nome da seu arquivo)
	 *                        -> setContents(array com dados adicionais de seu file twig)
	 *                        -> send();
	 *                        
	 */
	public function send(){
		$message = \Swift_Message::newInstance()
		->setSubject($this->subject)
		->setFrom('tagarelas.comunicatec@gmail.com')
		->setTo($this->to)
		->setBody(
				$this->renderView(
						$this->emailBody, $this->contents),
			          	'text/html'
				)
				/*
				 * If you also want to include a plaintext version of the message
				 ->addPart(
				 $this->renderView(
				 'Emails/registration.txt.twig',
				 array('name' => $name)
				 ),
				 'text/plain'
				 )
				 */
		;
		$this->container->get('mailer')->send($message);
	}
	
	public function setSubject($subject) {
		$this->subject = $subject;
		return $this;
	}
	
	public function setTo($to) {
		$this->to = $to;
		return $this;
	}
	
	public function setEmailBody($emailBody) {
		$this->emailBody = $emailBody;
		return $this;
	}
	
	public function setContents($contents) {
		$this->contents = $contents;
		return $this;
	}
	
}