/**
 * Autor:    Ricardo Rodriguez
 * Objetivo: Controle de Eventos do Sistema
 */

$("input[type=text]").focus(function() {
   $(this).select();
});

$( function() {
	$("#email").focusout(function(){
		jsProfile.checkEmail();
	});

	/**
	 * Clique do botão de novo cadastro
	 */
	$("#newUser").click(function() {
		jsProfile.saveNewUser();
		
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

