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
	
	$("#groupName").focusout(function(){
		jsGroup.checkGroupName();
	});

	/**
	 * Clique do botão de novo grupo
	 */
	$("#insertNewGroup").click(function() {
		jsGroup.saveNewGroup();
	});
	
	/**
	 * Configure the datetime field of session bundle
	 */
	
	$("#dtBox").DateTimePicker();
	
});	

