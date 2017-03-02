/**
 * Session Javascript Ajax file
 */

$( function() {
	jsSession 					= {};
	jsSession.members			= [ ];
	jsSession.groups			= [ ];
	jsSession.sessionNameFound 	= false
	
	jsSession.checkFields = function(){
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
		if ( !jsSession.checkFields()) {
			return false;
		}
		
		return true;
	};
	
	jsSession.checkSessionName = function() {
		var sessionName = $("#sessionName").val();
		var divPosicao  = '#imgSessionName';
		var pageurl     = $('#checkSessionNamePath').val();

		//debugger;
		
		var myData = {'sessionName' : sessionName};
		$.ajax({
			url: pageurl,
			data: myData,
			type: 'POST',
			cache: true,
	
			beforeSend: function( ) {
				$(divPosicao).empty();
				$(divPosicao).append(imgLoading);
			},
		
			error: function(){
				imgError = inicioImgHtmlTag +  closing  +
						  + " alt='"	
						  + global.error.ln001 + "'" + fimImgHtmlTag;
			    $(divPosicao).empty();
			    $(divPosicao).append(imgError);


			},

			success: function(returned){ 
				//debugger;
				$(divPosicao).empty();
				imgError = inicioImgHtmlTag +  closing  
				 			 + " title='"	
				 			 +	global.error.sessionFound + "'" 
							 + fimImgHtmlTag;
				
				var dataout = $.parseJSON(returned);
				jsSession.sessionNameFound = false;
				if($.trim(dataout.result) === global.recordFound){
					jsSession.sessionNameFound = true;
					$(divPosicao).append(imgOk);
				} else  
					$(divPosicao).append(imgError);
				 
				return;
			},
			statusCode: {
				404: function() {
					global.msgbox.data('messageBox').danger(window.important, 
							global.error.connection + pageurl + ". "+ global.error.tryagain);
				}
			}
		});
	};		
	
			
});