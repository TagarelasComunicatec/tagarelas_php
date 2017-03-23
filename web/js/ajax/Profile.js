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
	
	jsProfile.checkShortName = function() { 
		// debugger
		
		var shortName = $("#shortName").val();
		var checkShortNamePath = $("#divCheckShortNamePath").attr("ajaxurl");
		var myData = {'shortName' : shortName};
		
		$.ajax({
			url: checkShortNamePath,
			data: myData,
			type: 'POST',
			cache: true,
	
			beforeSend: function( ) {
				 $("#shortName").css({'background-color' : '#fff'});
			},
		
			error: function(){

			},

			success: function(returned){ 
				//debugger;
				$(divPosicao).empty();
				var dataout = $.parseJSON(returned);
				jsProfile.SHORTNAME_FOUND = false;
				if($.trim(dataout.result) === global.recordFound){
					jsProfile.SHORTNAME_FOUND = true;
					 $("#shortName").css({'background-color' : '#fff'});
				} else  
					 $("#shortName").css({'background-color' : '#5B1762'});
				 
				return;
			},
			statusCode: {
				404: function() {
					global.msgbox.data('messageBox').danger(window.important, 
							global.error.connection + checkShortNamePath + ". "+ global.error.tryagain);
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
			cache: true,
	
			beforeSend: function( ) {
				$("#email").css({'background-color' : '#ffffff'});			},
		
			error: function(){

			},

			success: function(returned){ 
				//debugger;
				var dataout = $.parseJSON(returned);
				jsProfile.EMAIL_FOUND = false;
				if($.trim(dataout.result) === global.recordFound){
					jsProfile.EMAIL_FOUND = true;
					$("#email").css({'background-color' : '#5B1762'});
				} else  
					$("#email").css({'background-color' : '#ffffff'});
				 
				return;
			},
			statusCode: {
				404: function() {
					global.msgbox.data('messageBox').danger(window.important, 
							global.error.connection + checkEmailPath + ". "+ global.error.tryagain);
				}
			}
		});
	};		

	
	jsProfile.saveNewUser = function() {
		jsProfile.checkShortName();
		jsProfile.checkEmail();
		//------------------------------------------
		var passMD5   = calcMD5($("#password").val());
		var cPassMD5  = calcMD5($("#confirmPassword").val());
		//------------------------------------------
		jsProfile.screenData = { 'name'           : $("#name").val(),
								 'shortName'      : $("#shortName").val(),
								 'password'       : passMD5,
								 'confirmPassword': cPassMD5,
								 'email'          : $("#email").val(),
								 'confirmEmail'   : $("#confirmEmail").val(),
								 'agree'          : $('#agree').is(":checked"),
								 'path'           : $("#divSaveNewProfile").attr("ajaxurl"),
								 'login'          : $("#divloginPath").attr("ajaxurl"),
				     			};
		if  (! jsProfile.checkFields())
			return false;
		
		/**
		 * Execute the call of save record
		 */
		window.ajaxLoading("show");
		$.ajax({
			url: jsProfile.screenData.path,
			data: jsProfile.screenData,
			type: 'POST',
			cache: true,
				
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
				}
			}
		});
	};		
	
	jsProfile.checkLoginTagarelas = function(){
		//------------------------------------------
		var email 	  = $("#email").val();
		var passMD5   = calcMD5($("#password").val());

		//------------------------------------------
		jsProfile.screenData = { 'password'       : passMD5,
								 'email'          : $("#email").val(),
								 'checkLoginPath' : $("#divCheckLoginPath").attr("ajaxurl"),
								 'feedPath'       : $("#divFeedPath").attr("ajaxurl"),
				     			};
		/**
		 * Execute the call of save record
		 */
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
			             return (item.id !== data.id);
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
		/**
		 * Execute call to load all users
		 */
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
							global.error.connection + urlLoadAllUsers + ". "+ global.error.tryagain);
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

