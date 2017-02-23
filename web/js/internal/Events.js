/**
 * Autor:    Ricardo Rodriguez
 * Objetivo: Controle de Eventos do Sistema
 */



$( function() {
	$("input[type=text]").focus(function() {
		   $(this).select();
	});
	
	$("#email").focusout(function(){
		jsProfile.checkEmail();
	});

	/**
	 * Clique do botão de novo cadastro
	 */
	$("#newUser").click(function() {
		jsProfile.saveNewUser();
		
	});
	
	$("#loginUserTagarelas").click(function() {
		jsProfile.checkLoginTagarelas();
		
	});
	
	
	$('#loadingDiv')
    .hide()  // Hide it initially
    .ajaxStart(function() {
        $(this).show();
    })
    .ajaxStop(function() {
        $(this).hide();
    });	

	
});	

