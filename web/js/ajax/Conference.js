/**
	 *  Conference Administration
 *  ==========================
 */

$( function() {
	jsConference = { };
	
	jsConference.BOSH_SERVICE ='http://localhost:7070';
	jsConference.connection   = null;
	
	/**
	 * Connect to a conference.
	 */
	jsConference.connect = function() {
		jsConference.connection = new Strophe.Connection(jsConference.BOSH_SERVICE);
		jsConference.connection.rawInput  = jsConference.rawInput;
		jsConference.connection.rawOutput = jsConference.rawOutput;
	};
	
	jsConference.rawInput = function(data) {
		 console.log('RCV ' + data);
	};	
	
	jsConference.rawOutput =  function(data) {
		 console.log('SENT ' + data);
	};
	
	jsConference.onConnect= function (status){
		 if (status == Strophe.Status.CONNECTING) {
			 console.log('Strophe is connecting.');
		 } else if (status == Strophe.Status.CONNFAIL) {
			 console.log('Strophe failed to connect.');
			 $('#connect').get(0).value = 'connect';
	     } else if (status == Strophe.Status.DISCONNECTING) {
	    	 console.log('Strophe is disconnecting.');
         } else if (status == Strophe.Status.DISCONNECTED) {
        	 console.log('Strophe is disconnected.');
			$('#connect').get(0).value = 'connect';
         } else if (status == Strophe.Status.CONNECTED) {
        	console.log('Strophe is connected.');
         }
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