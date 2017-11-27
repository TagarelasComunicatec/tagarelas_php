<?php
namespace AppBundle\Entity;
class RestApi {
	
    protected static $instance = null;
    
	private $secret;
	private $host; 
	private $port;  
	private $useSSL;   
	private $server;
	private $plugin ;
	
	
	
	protected function __construct(){	    
	}

	protected function __clone(){
	    
	}
	/**
	 * instance of RestApi
	 * @return RestApi
	 */
	public static function getInstance(){
	    if (! isset(static::$instance)){
	        static::$instance = new RestApi();
	    }
	    return static::$instance;
	}
   
	public function __toString(){
	    return ' Secret: '. $this->secret . 
	           ' Host: ' . $this->host .
	           ' Port: ' . $this->port .
	           ' useSSL: ' . $this->useSSL .
	           ' server: ' . $this->server . 
	           ' plugin: ' . $this->plugin;
	}

    /**
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getUseSSL()
    {
        return $this->useSSL;
    }

    /**
     * @return string
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @return string
     */
    public function getPlugin()
    {
        return $this->plugin;
    }


    /**
     * @param string $secret
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
        return $this;
    }

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @param string $port
     */
    public function setPort($port)
    {
        $this->port = $port;
        return $this;
    }

    /**
     * @param string $useSSL
     */
    public function setUseSSL($useSSL)
    {
        $this->useSSL = $useSSL;
        return $this;
    }

    /**
     * @param string $server
     */
    public function setServer($server)
    {
        $this->server = $server;
        return $this;
    }

    /**
     * @param string $plugin
     */
    public function setPlugin($plugin)
    {
        $this->plugin = $plugin;
        return $this;
    }

	
	
}