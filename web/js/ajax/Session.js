/**
 * Session Javascript Ajax file
 */

$( function() {
	jsSession 					= {};
	jsSession.members			= [ ];
	jsSession.groups			= [ ];
	jsSession.sessionNameFound 	= false;
	
	/**
	 * Load Group by Status
	 */
	jsSession.loadSessionsByStatus = function(status,limit,areaHtml){
		/**
		 * Execute call to load all groups
		 */
		if (window.ajaxLoading)  window.ajaxLoading("show");
		var loadStatusSessionPath = $("#divLoadSessionsByStatus").attr("ajaxurl");
		var myData     = {'status' : status,'limit' : limit};
		$.ajax({
			url:loadStatusSessionPath,
			data: myData,
			type: 'POST',
			cache: true,
			
			error: function(){
				window.ajaxLoading("hide");
				
			},
			
			success: function(returned){ 
				if (window.ajaxLoading)  window.ajaxLoading("hide");
				areaHtml.empty();
				var dataout = $.parseJSON(returned);

				myStatus = jsScreenElements.divTitleSessionByStatus(status-0) ;
				areaHtml.append(myStatus);

				if (dataout.result.length == 0) return;
				
				for(var index=0, len = dataout.result.length; index < len; index++ ){
				    var myData = dataout.result[index];
				    var myText = jsScreenElements.divSessionByStatus(status-0);
				    myText = myText.replace("$sessionName$"   , myData.sessionName );
				    myText = myText.replace("$datatimeSession$"   , myData,sessionDate );
				    myText = myText.replace("$groupName$", myData.groupName );
				    areaHtml.append(myText);
				}
				
				return;
			},
			
			statusCode: {
				404: function() {
					if (window.ajaxLoading)  window.ajaxLoading("hide");
					global.msgbox.data('messageBox').danger(window.important, 
							global.error.connection + loadAllGroupsPath + ". "+ global.error.tryagain);
				}
			},
			
		});	
	};
	
	
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
			
        } else if ( (jsGroup.totalMembersGroups + jsProfile.totalMembers) === 0){
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
		var sessionName     = $("#sessionName").val();
		var divPosicao      = '#imgSessionName';
		var datetimeSession = $('#datetimeSession').val();
		var users	        = jsProfile.membersSelected;
		var groups		    = jsGroup.membersSelected;
		var visibility		= $("input[name='visibility']:checked").val();
		var description		= $("#description").val();
		var myData          = {'sessionName' 			: sessionName,
					           'datetimeSession'	   	: datetimeSession,
					           'users'					: users,
					           'groups'					: groups,
					           'visibility'				: visibility,
					           'description'			: description,	
					           };
		var saveNewSessionUrl =  $("#divSaveNewSession").attr("ajaxurl");
		
		  $.ajax({
				
				url: saveNewSessionUrl,
				data: myData,
				type: 'POST',
				cache: true,
		
				beforeSend: function( ) {
				},
			
				error: function(){
				},

				success: function(returned){ 
					//debugger;
					var dataout = $.parseJSON(returned);
					if($.trim(dataout.result) === global.recordSavedWithSuccess){
						global.msgbox.data('messageBox').info(window.important, 
								 global.saveOk);
					} else  
						global.msgbox.data('messageBox').error(window.important, 
								global.saveError);
					return;
				},
				statusCode: {
					404: function() {
						global.msgbox.data('messageBox').danger(window.important, 
								global.error.connection + saveNewSessionUrl + ". "+ global.error.tryagain);
					}
				}
			});
		
		return true;
	};
	
	jsSession.checkSessionName = function() {
		var sessionName         = $("#sessionName").val();
		var divPosicao          = '#imgSessionName';
		var pageUrlSession      = $("#divCheckSessionName").attr("ajaxurl");
	
		var myData = {'sessionName' : sessionName};
		$.ajax({
			url: pageUrlSession,
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
							global.error.connection + pageUrlSession + ". "+ global.error.tryagain);
				}
			}
		});
	};		
	
			
});