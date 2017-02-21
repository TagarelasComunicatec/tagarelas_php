/**
 * Autor:    Ricardo Rodriguez
 * Objetivo: Funcoes Globais do Sistema de Alunos
 */

$("input[type=text]").focus(function() {
   $(this).select();
});

$( function() {
	/**
	 * Clique do botão de novo cadastro
	 */
	$("#newUser").click(function() {
		
		
	    var password      = $("#password").val();
		var confirmPass   = $("#confirmPassword").val();
        var email         = $("#email").val();
        var confirmEmail  = $("#confirmEmail").val();
		var agree =$('#agree').is(":checked");
		
        if (window.doCheckIsEmptyField("name", global.error.nameFormat)){
        	$("#name").focus();
        	return false;
        } else if (window.doCheckIsEmptyField("shortName", global.error.shortNameFormat)){
        	$("#shortName").focus();
        	return false;
        } else if (! window.docheckEmail(email,confirmEmail) ){
			$("#email").focus();
			return false;
		} else if (! pass.doVerifyPassword(password,confirmPass)){
			$("#password").focus();
			return false;
		} else if (! agree) {
			global.msgbox.data('messageBox').danger(window.important, global.error.confirmTerm);
			return false;
		}
		
		
	});
	
	
	
	
	
	
});	

