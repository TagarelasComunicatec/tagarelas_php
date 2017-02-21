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
		
		
	    var password    = $("#password").val();
		var confirmPass = $("#confirmPassword").val();
        var email       = $("#email").val();
        
        if (! window.doCheckEmptyField($("#name"), global.error.nameFormat)){
        	$("#name").focus();
        	return;
        }

        if (! window.doCheckEmptyField($("#shortName"), global.error.shortNameFormat)){
        	$("#shortName").focus();
        	return;
        }
        
		if (! window.docheckEmail(email,email) ){
			$("#email").focus();
			return;
		}
			
		if (! pass.doVerifyPassword(password,confirmPass)){
			$("#password").focus();
			return;
			
		}
			
		var agree =$('#agree').is(":checked");
		if (! agree) {
			global.msgbox.data('messageBox').danger(window.important, global.error.confirmTerm);
			return;
		}
		
		
	});
	
	
	
	
	
	
});	

