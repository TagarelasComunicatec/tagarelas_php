/**
 * Autor:    Ricardo Rodriguez
 * Métodos de atualização de informações de grupos de usuários.
 */

$( function() {
	jsGroup = {};

	jsGroup.CHECKOK = true;
	jsGroup.totalMembersGroups = 0;
	
	
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
		var users	   = jsProfile.membersSelected;
		var myData     = {'groupName' : groupName,
					      'users'	  : users 	};
		var saveNewGroupUrl = $("#divSaveNewGroup").attr("ajaxurl");
		
		/* Check if fields is ok! */
		if (! jsGroup.hasGroupName(groupName, divPosicao)) return;
		if (! jsProfile.hasMembers()) return;
		
		jsGroup.checkGroupName(true);
		if (! jsGroup.CHECKOK ) return;
	    $.ajax({
			
			url: saveNewGroupUrl,
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
							global.error.connection + saveNewGroupUrl + ". "+ global.error.tryagain);
				}
			}
		});
		
	};
	
	jsGroup.membersSelected = [ ];
	
	jsGroup.controlData = function(action,data){
		var totalMembros = data.totalMembers-0;
		if (jsProfile.INCLUDE == action){
			jsGroup.membersSelected.push(data);
			jsGroup.totalMembersGroups += totalMembros;
		
		} else {
			jsGroup.membersSelected = $.grep(jsGroup.membersSelected,function(item){
			             return (item.id !== data.id);
		     });
			jsGroup.totalMembersGroups -= totalMembros;         
	    }
		$("#totalMembrosGrupos").html(jsGroup.totalMembersGroups);
		$("#totalGruposHidden").val(jsGroup.totalMembersGroups);
		
		jsProfile.controlTotals();
	};
	
	jsGroup.loadAllGroups = function(){
		/**
		 * Execute call to load all groups
		 */
		window.ajaxLoading("show");
		var loadAllGroupsPath = $("#divLoadAllGroups").attr("ajaxurl");

		$.ajax({
			url:loadAllGroupsPath,
			data: [],
			type: 'POST',
			cache: false,
			
			error: function(){
				window.ajaxLoading("hide");
				
			},
			
			success: function(returned){ 
				window.ajaxLoading("hide");
				jsGroup.totalMembersGroups = 0;
				var dataout = $.parseJSON(returned);
				$('#sessionGroups').magicsearch({
		            dataSource: dataout.result,
		            fields: ['groupName', 'totalMembers'],
		            id: 'id',
		            format: '%groupName% · %totalMembers% ',
		            multiple: true,
		            multiField: 'groupName',
		            dropdownBtn: true,
		            multiStyle: {
		                space: 5,
		                width: 80
		            },
		            success:function($imput,data){
		            	jsGroup.controlData(jsProfile.INCLUDE,data);
		            	return true;
		            },
		            afterDelete: function($input, data) {
		            	jsGroup.controlData(jsProfile.DELETE,data);
		            	return true;
		            },

				});
				return;
			},
			statusCode: {
				404: function() {
					window.ajaxLoading("hide");
					global.msgbox.data('messageBox').danger(window.important, 
							global.error.connection + loadAllGroupsPath + ". "+ global.error.tryagain);
				}
			},
			
		});
	};
	
	jsGroup.checkGroupName = function(showMessage){
		
		var groupName= $("#groupName").val();
		var checkGroupNameUrl = $("#divCheckGroupName").attr("ajaxurl");
		var divPosicao = '#imgGroupName';
		var myData = {'groupName' : groupName};
		
		if (! jsGroup.hasGroupName(groupName, divPosicao)) return; 
	
		$.ajax({
			
			url: checkGroupNameUrl,
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
							global.error.connection +checkGroupNameUrl + ". "+ global.error.tryagain);
				}
			}
		});
	};			
	
	if ($('#pageSession').length)
		jsGroup.loadAllGroups();

});	