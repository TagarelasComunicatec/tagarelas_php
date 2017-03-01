/**
 * Autor:    Ricardo Rodriguez
 * Métodos de atualização de informações de grupos de usuários.
 */

$( function() {
	jsGroup = {};
	
	jsGroup.INCLUDE = 0;
	jsGroup.DELETE  = 1;
	jsGroup.CHECKOK = true;
	
	jsGroup.hasGroupName = function (groupName,divPosicao){
		if (groupName) return true;
		
		imgError = inicioImgHtmlTag +  closing  
				   + " title='"	
				   + global.error.groupEmpty + "'" 
				   + fimImgHtmlTag;
		$(divPosicao).empty();
		$(divPosicao).append(imgError);
		global.msgbox.data('messageBox').danger(window.important, 
				global.error.groupEmpty);
	    return false;	
	}
	
	
	jsGroup.hasMembers = function(){
		if ((jsGroup.membersSelected).length > 0) return true;	
		
		global.msgbox.data('messageBox').danger(window.important, 
												global.error.groupMemberNotFound);
		return false;
	}
	
	jsGroup.saveNewGroup = function(){
		var groupName  = $("#groupName").val();
		var divPosicao = '#imgGroupName';
		var users	   = jsGroup.membersSelected;
		var myData     = {'groupName' : groupName,
					      'users'	  : users 	};
		var pageurl    = $("#saveNewGroupPath").val();
		
		/* Check if fields is ok! */
		if (! jsGroup.hasGroupName(groupName, divPosicao)) return;
		if (! jsGroup.hasMembers()) return;
		
		jsGroup.checkGroupName(true);
		if (! jsGroup.CHECKOK ) return;
	    $.ajax({
			
			url: pageurl,
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
							global.error.connection + pageurl + ". "+ global.error.tryagain);
				}
			}
		});
		
	}
	
	jsGroup.checkGroupName = function(showMessage){
		
		var groupName= $("#groupName").val();
		var pageurl  = $('#checkGroupNamePath').val();
		var divPosicao = '#imgGroupName';
		var myData = {'groupName' : groupName};
		
		if (! jsGroup.hasGroupName(groupName, divPosicao)) return; 
	
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
				 			 +	global.error.groupNameFound + "'" 
							 + fimImgHtmlTag;
				
				var dataout = $.parseJSON(returned);
				jsGroup.CHECKOK = false;
				if($.trim(dataout.result) === global.recordNotFound){
					$(divPosicao).append(imgOk);
					jsGroup.CHECKOK = true;
				} else  { 
					$(divPosicao).append(imgError);
					if (showMessage) {
						global.msgbox.data('messageBox').danger(window.important, 
								global.error.groupNameFound);
					}
					
				}
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
	
	jsGroup.membersSelected = new Array();
	
	jsGroup.controlData = function(action,data){
		var totalRegistros = 0
		if (jsGroup.INCLUDE == action){
			var totalRegistros = jsGroup.membersSelected.push(data);
		
		} else {
		     jsGroup.membersSelected = $.grep(jsGroup.membersSelected,function(item){
			             return (item.id !== data.id);
		     });
			 totalRegistros = jsGroup.membersSelected.length;            
	    }
		
		$("#total-de-membros").html(totalRegistros);
	};
	
	jsGroup.loadAllUsers = function() {
		/**
		 * Execute call to load all users
		 */
		window.ajaxLoading("show");
		var urlLoadAllUsers = $("#loadAllUsersPath").val();
		$.ajax({
			url:  urlLoadAllUsers,
			data: [],
			type: 'POST',
			cache: true,
			
			error: function(){
				window.ajaxLoading("hide");
				
			},
			
			success: function(returned){ 
				window.ajaxLoading("hide");
				var dataout = $.parseJSON(returned);
				if(global.usersFound  ==$.trim(dataout.result)){
					$('#groupMembers').magicsearch({
			            dataSource: dataout.users,
			            fields: ['realName', 'nickname'],
			            id: 'id',
			            format: '%realName% · %nickname%',
			            multiple: true,
			            multiField: 'realName',
			            dropdownBtn: true,
			            multiStyle: {
			                space: 5,
			                width: 80
			            },
			            success:function($imput,data){
			            	jsGroup.controlData(jsGroup.INCLUDE,data);
			            	return true;
			            },
			            afterDelete: function($input, data) {
			            	jsGroup.controlData(jsGroup.DELETE,data);
			            	return true;
			            },

					});
					
					
					return;
				}
			},
			statusCode: {
				404: function() {
					window.ajaxLoading("hide");
					global.msgbox.data('messageBox').danger(window.important, 
							global.error.connection + pageurl + ". "+ global.error.tryagain);
				}
			},
			
		});
	
	};
	
	/**
	 * If exists $("#newGroupLoadDiv") - I'm in Group page then load all users.
	 */
	if ($("#newGroupLoadDiv").length)
		jsGroup.loadAllUsers();
	
	
});	