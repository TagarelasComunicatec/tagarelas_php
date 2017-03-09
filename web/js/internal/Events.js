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
	
	$("#sessionName").focusout(function(){
		jsSession.checkSessionName();
	});
	
	$("#insertNewSession").click(function() {
		jsSession.saveNewSession();
	});
	
	/**
	 * Configure the datetime field of session bundle
	 */
	
	$("#dtBox").DateTimePicker();
	
	/**
	 * Load events em feed page
	 */
	
	if ($("#pendingGroup").length){
		jsGroup.loadGroupsByStatus(global.statusUser.PENDING,0,$("#pendingGroup"));
	}
	if ($("#activeGroup").length){
		jsGroup.loadGroupsByStatus(global.statusUser.ACTIVE,4,$("#activeGroup"));
	}
	
	 $("#newGroupForm").submit(function(event){
	    jsGroup.saveNewGroup(this,event);
	 }); 

	; 
});	

