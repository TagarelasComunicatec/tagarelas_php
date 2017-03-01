/**
 * Session Javascript Ajax file
 */

$( function() {
	jsSession 			= {};
	jsSession.members	= [ ];
	jsSession.groups	= [ ];
	
	jsSession.verifyData = function(){
		var theMessage = ""; 
		
		if (! $("#sessionName").val()){
			theMessage = global.error.sessionName;
			
		} else if ( ! $("#datetimeSession").val() ){
			theMessage = global.error.sessionDateTime;
		
		} else if ( ! $("#description").val() ){
			theMessage = global.error.sessionDescription;
			
		} else if (!$("input[name='visibility']:checked").val()){
			theMessage = global.error.sessionVisibility;
			
        } else if ( (jsSession.groups.length + jsSession.members.length) === 0){
			theMessage = global.error.sessionGroups
			
		} else {
			return true;
		}
		
		/* error condition */
		global.msgbox.data('messageBox').danger(window.important,theMessage);
		
		return false;
		
	};
	
	jsSession.saveNewSession = function(){
		if ( !jsSession.verifyData()) {
			return false;
		}
		
		return true;
	}
			
});