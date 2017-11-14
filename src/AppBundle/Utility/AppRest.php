<?php
namespace AppBundle\Utility;

use Symfony\Component\DependencyInjection\Container;
use AppBundle\Entity\RestApi;

class AppRest {
    
	static function doConnectRest(RestApi $restapi){
		// Create the Openfire Rest api object
	    $api = new \Gidkom\OpenFireRestApi\OpenFireRestApi();
		
		// Set the required config parameters
		
		$api->secret = $restapi->getSecret();
		
		$api->host = $restapi->getHost();
		$api->port = $restapi->getPort();  
		
		// Optional parameters (showing default values)
		
		$api->useSSL = $restapi->getUseSSL();
		$api->plugin = $restapi->getPlugin();  // plugin
		return $api;
	}
	
	static function doConnectRestToSession(RestApi $restapi){
	    $api = new \Gnello\OpenFirerestapi\API(
	        $restapi->getHost(), 
	        $restapi->getPort(), 
	       $restapi->getSecret());
	    
	    $api->Settings()->setServerName($restapi->getServer());
	    $api->Settings()->setHost($restapi->getHost());
	    $api->Settings()->setPort($restapi->getPort());
	    $api->Settings()->setSSL($restapi->getUseSSL());
	    $api->Settings()->setPlugin($restapi->getPlugin());
	    
	    return $api;
	}
	
}