/**
 * Autor:    Ricardo Rodriguez
 * Métodos de atualização de informações de grupos de usuários.
 */

$( function() {
	jsGroup = {};
	
	jsGroup.CHECKOK = true;
	jsGroup.totalMembersGroups = 0;
	
	/**
	 * Load Group by Status
	 */
	jsGroup.loadUserGroups = function(limit, areaHtml){
		/**
		 * Execute call to load all groups
		 */
		if (window.ajaxLoading)  window.ajaxLoading("show");
		var loadUserGroupsPath = $("#divLoadUserGroups").attr("ajaxurl");
		var myData     = {'limit' : limit};
		areaHtml.empty();
		var activeGroup = jsScreenElements.divTitleGroupByUser();
		areaHtml.append(activeGroup);
		$.ajax({
			url:loadUserGroupsPath,
			data: myData,
			type: 'POST',
			cache: true,
			
			error: function(){
				window.ajaxLoading("hide");
				
			},
			
			success: function(returned){ 
				if (window.ajaxLoading)  window.ajaxLoading("hide");
				var dataout = $.parseJSON(returned);
				if (dataout.result.length == 0) return;
				for(var index=0, len = dataout.result.length; index < len; index++ ){
				    var myData = dataout.result[index];
				    var myText = jsScreenElements.divGroupByUser();
				    myText = myText.replace("$groupName$"   , myData.groupname );
				    myText = myText.replace("$admin$"       , myData.admin );
				    myText = myText.replace("$totalMembers$", myData.totalMembers );
				    myText = myText.replace("$avatar$",
				    		 window.fullUrl()  + 
				    		 "uploads/groupimages/" + myData.avatar)
				    areaHtml.append(myText);
				}
				
				return;
			},
			
			statusCode: {
				404: function() {
					if (window.ajaxLoading) window.ajaxLoading("hide");
					global.msgbox.data('messageBox').danger(window.important, 
							global.error.connection + loadUserGroupsPath + ". (404) ");
				},
			    500: function() {
			      	if (window.ajaxLoading) window.ajaxLoading("hide");
				       global.msgbox.data('messageBox').danger(window.important, 
						  global.error.connection + loadUserGroupsPath + ". (500)");
			    }
			},
			
		});	
	};
	
	/**
	 * Verify if group exists
	 */
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
	};
	
	/**
	 * Verify if group has members to save
	 */
	jsGroup.hasMembers = function(){
		if ((jsGroup.membersSelected).length > 0) return true;	
		
		global.msgbox.data('messageBox').danger(window.important, 
												global.error.groupMemberNotFound);
		return false;
	};
	
	/**
	 * Save the group
	 */
	jsGroup.saveNewGroup = function(myForm,event){
		 
		if(window.FormData === undefined) return; // for HTML5 browsers
			
		 var groupName   = $("#groupName").val();
		 var divPosicao  = '#imgGroupName';
		 var users	     = jsProfile.membersSelected;
         var usersString ='';
		 
		 for(var index = 0, len = users.length; index < len; ++index  ){
			 usersString += users[index].username;
			 if (index < len -1) usersString +="|";
		 }
		 
		 /* Check if fields is ok! */
		 if (! jsGroup.hasGroupName(groupName, divPosicao)) return false;
		 if (! jsProfile.hasMembers()) return false;
			
		 jsGroup.checkGroupName(true);
		 if (! jsGroup.CHECKOK ) return false;
		 
		 var filedata = $("#avatar").prop("files")[0];
		 
		 var formObj = $(myForm);
		 var formURL = formObj.attr("action");
		 
		 var formData = new FormData();
		
		 
		 formData.append("groupName", groupName); 
		 formData.append("users", usersString);
		 formData.append("file", filedata) ;
		 
		 var myData = { 
				 'groupName' : groupName,
				 'users'     : users,
		 };
		 
		 
		 $.ajax({
		        url: formURL,
		        type: 'post',
		        data:  formData,
		        //mimeType:"multipart/form-data",
		        contentType: false,
		        cache: false,
		        processData:false,
		        success: function(returned, textStatus, jqXHR)
		        {
		          //debugger;
					var dataout = $.parseJSON(returned);
					if($.trim(dataout.result) === global.recordSavedWithSuccess){
						global.msgbox.data('messageBox').info(window.important, 
								 global.saveOk)
						$("#groupName").val('');		 
						location.reload();// clear the form.
						return;
					} else  {
						global.msgbox.data('messageBox').error(window.important, 
								global.saveError);
					}
					return;
		        },
		        error: function(jqXHR, textStatus, errorThrown) 
		        {
		        	 $.notify(errorThrown+ ' '+ textStatus, true);
		         },
				statusCode: {
					404: function() {
						if (window.ajaxLoading) window.ajaxLoading("hide");
						global.msgbox.data('messageBox').danger(window.important, 
								global.error.connection + urlLoadAllUsers + ". (404) ");
					},
				    500: function() {
				      	if (window.ajaxLoading) window.ajaxLoading("hide");
					       global.msgbox.data('messageBox').danger(window.important, 
							  global.error.connection + urlLoadAllUsers + ". (500)");
				    }
				},          
		    });
		 event.preventDefault(); //Prevent Default action. 
		 event.unbind();

	};
	
	jsGroup.membersSelected = [ ];
	
	/**
	 * Verify the count of members
	 */
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
	
	/**
	 * Load All groups
	 */
	jsGroup.loadAllGroups = function(){
		/**
		 * Execute call to load all groups
		 */
		if (window.ajaxLoading) window.ajaxLoading("show");
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
				if (window.ajaxLoading) window.ajaxLoading("hide");
				jsGroup.totalMembersGroups = 0;
				var dataout = $.parseJSON(returned);
				$('#sessionGroups').magicsearch({
		            dataSource: dataout.result,
		            fields: ['groupname', 'totalMembers'],
		            id: 'groupname',
		            format: '%groupname% · %totalMembers% ',
		            multiple: true,
		            multiField: 'groupname',
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
					if (window.ajaxLoading) window.ajaxLoading("hide");
					global.msgbox.data('messageBox').danger(window.important, 
							global.error.connection + urlLoadAllUsers + ". (404) ");
				},
			    500: function() {
			      	if (window.ajaxLoading) window.ajaxLoading("hide");
				       global.msgbox.data('messageBox').danger(window.important, 
						  global.error.connection + urlLoadAllUsers + ". (500)");
			    }
			},
			
		});
	};
	
	/**
	 * Verify if group exists and show information to user
	 */
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
					if (window.ajaxLoading) window.ajaxLoading("hide");
					global.msgbox.data('messageBox').danger(window.important, 
							global.error.connection + urlLoadAllUsers + ". (404) ");
				},
			    500: function() {
			      	if (window.ajaxLoading) window.ajaxLoading("hide");
				       global.msgbox.data('messageBox').danger(window.important, 
						  global.error.connection + urlLoadAllUsers + ". (500)");
			    }
			}
		});
	};			
	
	if ($('#pageSession').length)
		jsGroup.loadAllGroups();

});	