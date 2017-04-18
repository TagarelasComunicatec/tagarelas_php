/**
	 *  Conference Administration
 *  ==========================
 */

$( function() {
	jsConference = {
			IS_CONNECT: true,
			SERVER: '127.0.0.1',
			DOMAIN: 'localhost',
			jid: 'ricardo@gmail.com',
	        password: '123456'
	};
	
	/**
	 * Connect to a conference.
	 */
	jsConference.connect = function() {
		var xmpp = require("../xmpp");  
		var conn = new xmpp.Connection(this.DOMAIN);  
		var sys = require("sys");  
		var id = 1; 
		
		conn.log = function (_, m) { sys.puts(m); };  
		conn.connect(jsConference.jid, jsConference.password, 
				function (status, condition){  
				          if(status == xmpp.Status.CONNECTED){  
				            conn.addHandler(onMessage, null, 'message', null, null,  null);  
				            setInterval(function(){  
				                 id++;  
				                 conn.send(xmpp.iq({from: jid + "." + 
				                	 	conn.host, to: conn.host, id: "iq:" + id, type: "get"}).c
				                	 	("ping", {xmlns: 'urn:xmpp:ping'}));  
				  
				                    }, 60000);  
				          } else  
				             conn.log(xmpp.LogLevel.DEBUG, "New connection status: " + status + (condition?(" ("+condition+")"):""));  
				});  
				  
	};

	/**
	 * Show calendar of a conference
	 */
	jsConference.checkCalendar = function(conference) {
		
	};
	
	/**
	 * Verify if a conference is open.
	 */
	jsConferrence.isOpen = function(conference) {
		
	};
	
	/**
	 * Close my participation on a conference
	 */
	jsConference.close = function(conference) {
		
	};
	
	/**
	 * Send a private or public message
	 */
	jsConference.send = function(conference, type, sender,receiver,body) {
		
	};
	
	/**
 	 *  Load all messages from a conference
	 */
	jsConference.doLoadMessages = function(conference) {
		
	};
	
	/**
	 * Load the private messages to me from a conference.
	 */
	jsConference.doLoadPrivateMessages = function(conference, toMe){
		
	};
});