/**
 * Autor:    Ricardo Rodriguez
 * Objetivo: Métodos de atualização de informações de usuário.
 */

$( function() {
	jsProfile = {};

	jsProfile.EMAIL_FOUND = false;
	jsProfile.SHORTNAME_FOUND = false;
	
	jsProfile.INCLUDE = 0;
	jsProfile.DELETE  = 1;

	
	jsProfile.checkFields= function() {
		
		if (window.doCheckIsEmptyField("name", global.error.nameFormat)){
        	$("#name").focus();
        	return false;
        } else if (window.doCheckIsEmptyField("shortName", global.error.shortNameFormat)){
        	$("#shortName").focus();
        	return false;	
        } else if (!window.docheckEmail(jsProfile.screenData.email,
        								 jsProfile.screenData.confirmEmail) ){
			$("#email").focus();
			return false;
		} else if (! pass.doVerifyPassword(jsProfile.screenData.password,
										   jsProfile.screenData.confirmPassword)){
			$("#password").focus();
			return false;
		} else if (!jsProfile.screenData.agree) {
			global.msgbox.data('messageBox').danger(window.important, global.error.confirmTerm);
			return false;
		}
		return true;
	};
	
	
	jsProfile.cancelPassword = function (myForm,event){
		
		if (window.ajaxLoading) window.ajaxLoading("show");

		 var formObj = $(myForm);
		 var formURL = formObj.attr("action");
		 
		 var formData = new FormData();
		
		 
		 formData.append("username", $("#shortName").val());
		 
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
		        	if (window.ajaxLoading) window.ajaxLoading("hide");
					return;
		        },
		        error: function(jqXHR, textStatus, errorThrown) 
		        {
		        	if (window.ajaxLoading) window.ajaxLoading("hide");
		        	 $.notify(errorThrown+ ' '+ textStatus, true);
		         },
		         statusCode: {
						404: function() {
							global.msgbox.data('messageBox').danger(window.important, 
									global.error.connection + checkShortNamePath + ". "+ global.error.tryagain);
						},
					    500: function() {
					      	if (window.ajaxLoading) window.ajaxLoading("hide");
						       global.msgbox.data('messageBox').danger(window.important, 
								  global.error.connection + urlLoadAllUsers + ". (500)");
					    }
				}
	 });
	
	jsProfile.changePassword = function (myForm,event){
		
		if (! pass.doVerifyPassword($("#password").val(),$("#confirmPassword").val())){			
					$("#password").focus();		
					return;
		}
		
		if (window.ajaxLoading) window.ajaxLoading("show");

		 var formObj = $(myForm);
		 var formURL = formObj.attr("action");
		 
		 var formData = new FormData();
		
		 
		 formData.append("username", $("#shortName").val());
		 formData.append("password", $("#password").val());;
		
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
		        	if (window.ajaxLoading) window.ajaxLoading("hide");
					var dataout = $.parseJSON(returned);
					if($.trim(dataout.result) === global.recordSavedWithSuccess){
						global.msgbox.data('messageBox').info(window.important, 
								 global.saveOk)	 
						return;
					} else  {
						global.msgbox.data('messageBox').error(window.important, 
								global.saveError);
					}
					return;
		        },
		        error: function(jqXHR, textStatus, errorThrown) 
		        {
		        	if (window.ajaxLoading) window.ajaxLoading("hide");
		        	 $.notify(errorThrown+ ' '+ textStatus, true);
		         },
		         statusCode: {
						404: function() {
							global.msgbox.data('messageBox').danger(window.important, 
									global.error.connection + checkShortNamePath + ". "+ global.error.tryagain);
						},
					    500: function() {
					      	if (window.ajaxLoading) window.ajaxLoading("hide");
						       global.msgbox.data('messageBox').danger(window.important, 
								  global.error.connection + urlLoadAllUsers + ". (500)");
					    }
				}
		 });
		 if (event) {
			 event.preventDefault(); //Prevent Default action. 
			 event.unbind();
		 }
	}
	
	
	jsProfile.saveUser = function(myForm,event) {
		// debugger
		if (window.ajaxLoading) window.ajaxLoading("show");
		
        var filedata = $("#avatar").prop("files")[0];
		 
		 var formObj = $(myForm);
		 var formURL = formObj.attr("action");
		 
		 var formData = new FormData();
		
		 
		 formData.append("username", $("#shortName").val());
		 formData.append("name", $("#name").val());
		 formData.append("email", $("#email").val());
		 formData.append("file", filedata) ;
		
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
							global.msgbox.data('messageBox').danger(window.important, 
									global.error.connection + checkShortNamePath + ". "+ global.error.tryagain);
						},
					    500: function() {
					      	if (window.ajaxLoading) window.ajaxLoading("hide");
						       global.msgbox.data('messageBox').danger(window.important, 
								  global.error.connection + urlLoadAllUsers + ". (500)");
					    }
					}
		 });
		 if (event) {
			 event.preventDefault(); //Prevent Default action. 
			 event.unbind();
		 }
	}
	
	jsProfile.loadUser = function() { 
		// debugger
		if (window.ajaxLoading) window.ajaxLoading("show");
		
		$.ajax({
			url: $("#divLoadUser").attr("ajaxurl"),
			data: { },
			type: 'POST',
			cache: true,
	
			beforeSend: function( ) {
			
			},
		
			error: function(){
				if (window.ajaxLoading) window.ajaxLoading("hide");
			},

			success: function(returned){ 
				//debugger;
				if (window.ajaxLoading) window.ajaxLoading("hide");
				var dataout = $.parseJSON(returned);
				user = dataout.user[0];
				$("#shortName").val(user.username);
				$("#name").val(user.name);
				$("#email").val(user.email);
			},
			statusCode: {
				404: function() {
					global.msgbox.data('messageBox').danger(window.important, 
							global.error.connection + checkShortNamePath + ". "+ global.error.tryagain);
				},
			    500: function() {
			      	if (window.ajaxLoading) window.ajaxLoading("hide");
				       global.msgbox.data('messageBox').danger(window.important, 
						  global.error.connection + urlLoadAllUsers + ". (500)");
			    }
			}
		});

	};

	jsProfile.checkShortName = function() { 
		// debugger
		
		var shortName = $("#shortName").val();
		var checkShortNamePath = $("#divCheckShortNamePath").attr("ajaxurl");
		var myData = {'shortName' : shortName};
		
		$.ajax({
			url: checkShortNamePath,
			data: myData,
			type: 'POST',
			cache: false,
	
			beforeSend: function( ) {
			
			},
		
			error: function(){
				if (window.ajaxLoading) window.ajaxLoading("hide");
			},

			success: function(returned){ 
				//debugger;
				var dataout = $.parseJSON(returned);
				jsProfile.SHORTNAME_FOUND = false;
				if($.trim(dataout.result) === global.recordFound){
					jsProfile.SHORTNAME_FOUND = true;
				} else  
					
				return;
			},
			statusCode: {
				404: function() {
					if (window.ajaxLoading) window.ajaxLoading("hide");
					global.msgbox.data('messageBox').danger(window.important, 
							global.error.connection + checkShortNamePath + ". "+ global.error.tryagain);
				},
			    500: function() {
			      	if (window.ajaxLoading) window.ajaxLoading("hide");
				       global.msgbox.data('messageBox').danger(window.important, 
						  global.error.connection + urlLoadAllUsers + ". (500)");
			    }
			}
		});
		
		
		
	};
	
	jsProfile.checkEmail = function() {
		var email 	   = $("#email").val();
		var checkEmailPath = $("#divCheckEmailPath").attr("ajaxurl");

		//debugger;

		var myData = {'email' : email};
		
		$.ajax({
			url: checkEmailPath,
			data: myData,
			type: 'POST',
			cache: false,
	
			beforeSend: function( ) {
			},
		
			error: function(){
				if (window.ajaxLoading) window.ajaxLoading("hide");
			},

			success: function(returned){ 
				//debugger;
				if (window.ajaxLoading) window.ajaxLoading("hide");
				var dataout = $.parseJSON(returned);
				jsProfile.EMAIL_FOUND = false;
				if($.trim(dataout.result) === global.recordFound){
					jsProfile.EMAIL_FOUND = true;
					
				} else  
					
				 
				return;
			},
			statusCode: {
				404: function() {
					if (window.ajaxLoading) window.ajaxLoading("hide");
					global.msgbox.data('messageBox').danger(window.important, 
							global.error.connection + checkEmailPath + ". "+ global.error.tryagain);
				},
			    500: function() {
			      	if (window.ajaxLoading) window.ajaxLoading("hide");
				       global.msgbox.data('messageBox').danger(window.important, 
						  global.error.connection + urlLoadAllUsers + ". (500)");
			    }
			}
		});
	};		

	
	jsProfile.saveNewUser = function() {
		jsProfile.checkShortName();
		jsProfile.checkEmail();
		
		jsProfile.screenData = { 'name'           : $("#name").val(),
								 'shortName'      : $("#shortName").val(),
								 'password'       : $("#password").val(),
								 'passMD5'        : calcMD5($("#password").val()),
								 'confirmPassword': $("#confirmPassword").val(),
								 'email'          : $("#email").val(),
								 'confirmEmail'   : $("#confirmEmail").val(),
								 'agree'          : $('#agree').is(":checked"),
								 'path'           : $("#divSaveNewProfile").attr("ajaxurl"),
								 'login'          : $("#divloginPath").attr("ajaxurl"),
				     			};
		if  (! jsProfile.checkFields())
			return false;
		
		window.ajaxLoading("show");
		$.ajax({
			url: jsProfile.screenData.path,
			data: jsProfile.screenData,
			type: 'POST',
			cache: false,
				
			success: function(returned){ 
				//debugger;
				window.ajaxLoading("hide");
				var dataout = $.parseJSON(returned);
				if($.trim(dataout.result) === global.recordSavedWithSuccess){
					location.href =jsProfile.screenData.login;
				} else  
					alert('Erro no cadastro:');
				return;
			},
			statusCode: {
				404: function() {
					window.ajaxLoading("hide");
					global.msgbox.data('messageBox').danger(window.important, 
							global.error.connection + jsProfile.screenData.path + ". "+ global.error.tryagain);
				},
			    500: function() {
			      	if (window.ajaxLoading) window.ajaxLoading("hide");
				       global.msgbox.data('messageBox').danger(window.important, 
						  global.error.connection + urlLoadAllUsers + ". (500)");
			    }
			}
		});
	};		
	
	jsProfile.checkLoginTagarelas = function(){
		//------------------------------------------
		var email 	  = $("#email").val();
		var passMD5   = calcMD5($("#password").val());

		//------------------------------------------
		jsProfile.screenData = { 'password'       : $("#password").val(),
								 'email'          : $("#email").val(),
								 'checkLoginPath' : $("#divCheckLoginPath").attr("ajaxurl"),
								 'feedPath'       : $("#divFeedPath").attr("ajaxurl"),
				     			};
		window.ajaxLoading("show"); d
		$.ajax({
			url: jsProfile.screenData.checkLoginPath,
			data: jsProfile.screenData,
			type: 'POST',
			cache: true,
				
			success: function(returned){ 
				window.ajaxLoading("hide");
				var dataout = $.parseJSON(returned);
				if($.trim(dataout.result) === global.loginCorrect){
					location.href =jsProfile.screenData.feedPath;
				} else  
					alert('Login Inválido. Tente de novo');
				return;
			},
			statusCode: {
				404: function() {
					window.ajaxLoading("hide");
					global.msgbox.data('messageBox').danger(window.important, 
							global.error.connection + jsProfile.screenData.checkLoginPath + ". "+ global.error.tryagain);
				},
			    500: function() {
			      	if (window.ajaxLoading) window.ajaxLoading("hide");
				       global.msgbox.data('messageBox').danger(window.important, 
						  global.error.connection + urlLoadAllUsers + ". (500)");
			    }
			}
		});
	};

	jsProfile.membersSelected = new Array();
	jsProfile.totalMembers = 0;
	
	jsProfile.hasMembers = function(){
		if ((jsProfile.membersSelected).length > 0) return true;	
		global.msgbox.data('messageBox').danger(window.important, 
												global.error.groupMemberNotFound);
		return false;
	}
	
	jsProfile.controlData = function(action,data){
		var totalRegistros = 0
		if (jsProfile.INCLUDE == action){
			jsProfile.totalMembers = jsProfile.membersSelected.push(data);
		
		} else {
			jsProfile.membersSelected = $.grep(jsProfile.membersSelected,function(item){
			             return (item.usename !== data.username);
		     });
			jsProfile.totalMembers = jsProfile.membersSelected.length;            
	    }
		
		$("#totalDeMembros").html(jsProfile.totalMembers);
		$("#totalDeMembrosHidden").val(jsProfile.totalMembers)
		jsProfile.controlTotals();
	};
	
	jsProfile.controlTotals = function (){
		$("#totalParticipantes").html(jsProfile.totalMembers+jsGroup.totalMembersGroups);
	};
	
	jsProfile.loadAllUsers = function() {

		if (window.ajaxLoading) window.ajaxLoading("show");
		var urlLoadAllUsers =  $("#divLoadAllUsers").attr("ajaxurl");
		$.ajax({
			url:  urlLoadAllUsers,
			data: [],
			type: 'POST',
			cache: false,
			
			error: function(){
				if (window.ajaxLoading)
					window.ajaxLoading("hide");
				
			},
			
			success: function(returned){ 
				if (window.ajaxLoading) window.ajaxLoading("hide");
				var dataout = $.parseJSON(returned);
				if(global.usersFound  ==$.trim(dataout.result)){
					$('#allMembers').magicsearch({
			            dataSource: dataout.users,
			            fields: ['username', 'name'],
			            id: 'username',
			            format: '%username% · %name%',
			            multiple: true,
			            multiField: 'username',
			            dropdownBtn: true,
			            multiStyle: {
			                space: 5,
			                width: 80
			            },
			            success:function($imput,data){
			            	jsProfile.controlData(jsProfile.INCLUDE,data);
			            	return true;
			            },
			            afterDelete: function($input, data) {
			            	jsProfile.controlData(jsProfile.DELETE,data);
			            	return true;
			            },

					});
					
					
					return;
				}
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
	 * If exists $("#loadAllUsersDiv") - I'm in Group page then load all users.
	 */
	if ($("#pageGroup").length || $("#pageSession").length)
		jsProfile.loadAllUsers();
	
	
});

