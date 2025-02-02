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

	$("#shortName").focusout(function(){
		jsProfile.checkShortName();
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
	
	$("#newGroupForm").submit(function(event){
	    jsGroup.saveNewGroup(this,event);
	}); 
	
	/**
	 * Configure the datetime field of session bundle
	 */
	
	$("#dtBox").DateTimePicker();
	
	/**
	 * Load events in feed page
	 */
	
	if ($("#pendingGroup").length){
		jsGroup.loadGroupsByStatus(global.statusUser.PENDING,0,$("#pendingGroup"));
	}
	
	if ($("#activeGroup").length){
		jsGroup.loadGroupsByStatus(global.statusUser.ACTIVE,4,$("#activeGroup"));
	}
	
	if ($("#scheduledSession").length){
		jsSession.loadSessionsByStatus(global.statusSession.SCHEDULED,4,$("#scheduledSession"));
	};
	
	if ($("#activeSession").length){
		jsSession.loadSessionsByStatus(global.statusSession.ACTIVE,4,$("#activeSession"));
	};
	
	if ($("#pendingSession").length){
		jsSession.loadSessionsByStatus(global.statusSession.PENDING,4,$("#pendingSession"));
	};
	
	if ($("#publicSession").length){
		jsSession.loadSessionsByStatus(global.statusSession.PUBLIC,4,$("#publicSession"));
	}; 
});	

