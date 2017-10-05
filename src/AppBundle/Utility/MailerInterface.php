<?php
namespace AppBundle\Utility;

interface MailerInterface {
		
	    /**
	     * Declare abaixo os arquivos .twig para envio de emails.
	     */
	    CONST EMAIL_REGISTRATION = "Emails/registration.html.twig";
		
		
		/**
		 * Contrato send.
		 * Funчуo de enviar emails a partir dos dados contidos 
		 * em Mailer. 
		 */
		public function send();
}