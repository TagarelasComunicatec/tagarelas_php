<?php
namespace AppBundle\Utility;
use  Gidkom\OpenFireRestApi\OpenFireRestApi;
class AppRest {
	
	static function doConnectRest(){
		// Create the Openfire Rest api object
		$api = new OpenFireRestApi();
		
		// Set the required config parameters
		
		$api->secret = "P1m&nT&l";
		
		$api->host = "localhost";
		$api->port = "9090";  // default 9090
		
		// Optional parameters (showing default values)
		
		$api->useSSL = false;
		$api->plugin = "/plugins/restapi/v1";  // plugin
		return $api;
	}
}