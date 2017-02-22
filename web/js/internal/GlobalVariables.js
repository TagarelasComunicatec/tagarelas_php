/**
 *  Variaveis Globais do Sistema 
 */

$( function() {

	/*
	 * ==============================
	 * NamesSpaces Globais do Sistema
	 * ==============================
	 */	
	global   	   = {};
	pass 		   = {};

	/*
	 * ============================================
	 * Utilização do NameSpace window no SIAAC-WEB
	 * ============================================
	 */
	
	window.debug  				=  true;

	
	window.host					= "";
	window.loading				= window.host + "http://siaac.cp2.g12.br/js/ajax/lineicons/ajax-loader.gif";
	window.closing 				= window.host + "http://siaac.cp2.g12.br/js/ajax/lineicons/Close-icon.png";
	window.okimg  				= window.host + "http://siaac.cp2.g12.br/js/ajax/lineicons/Ok-icon.png";
	window.trashimg 			= window.host + "http://siaac.cp2.g12.br/js/ajax/lineicons/Action-remove-icon.png";
	window.alertimg				= window.host + "http://siaac.cp2.g12.br/js/ajax/lineicons/sign-Alert-icon.png";

	window.urlLoadUsuario 		= null;
	window.loginCompleto  		= {};
	window.inicioImgHtmlTag		= "<img src=";
	window.fimImgHtmlTag 		= " />";
	window.imgLoading 			= inicioImgHtmlTag + loading   + fimImgHtmlTag;
	window.imgOk	   			= inicioImgHtmlTag + okimg     +  fimImgHtmlTag;
	window.imgError   			= inicioImgHtmlTag +  closing  + fimImgHtmlTag;
	window.imgTrash   			= inicioImgHtmlTag +  trashimg
								 + " alt='Aluno sem nota' title='Aluno sem nota' "
								 + fimImgHtmlTag;

	window.imgAlert   			= inicioImgHtmlTag +  alertimg
	 + " alt='Faltas superam aulas previstas' title='Faltas superam aulas previstas' "
	 + fimImgHtmlTag;
	
	
	/**
	 * ================================
	 * Controle de segurança de Senhas
	 * ================================
	 */
	pass.minimalLength      = 6;
	pass.minimalUpper       = 0;
	pass.minimalLower       = 0;
	pass.minimalNumber      = 0;
	pass.minimalEspChar     = 0;

	/*
	 * ================================
	 * Expressoes regulares
	 * ================================
	 */
	global.regex   = {};
	
	global.regex.email = 
		 new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
	
	global.regex.anUpperCase = /[A-Z]/;
	global.regex.aLowerCase  = /[a-z]/; 
	global.regex.aNumber	 = /[0-9]/;
    global.regex.aSpecial 	 = /[!|@|#|$|%|^|&|*|(|)|-|_]/;
    
	/*
	 * =================================================================
	 * Mensagens de Erro JavaScript do Sistema
	 * =================================================================
	 */
	global.error   = {};	
	global.error.cpf	    	= 'CPF incorreto. Verifique o conteúdo e digite apenas números.';
	global.error.nascimento 	= 'Data de Nascimento incorreta. Digite no formato dd/mm/aaaa.';
	global.error.emailFormat    = "Formato do email inválido. Tente de novo. ";
	global.error.emailFound     = "Email já está cadastrado. Verifique seu email ";
	global.error.confirmEmail   = "Emails Digitados não conferem !!"
	global.error.passFormat     = "Formato do senha inválida. Tente de novo. ";
	global.error.confirmPass    = "Emails Digitados não conferem !!"

	global.error.nameFormat		= "Preencha corretamente o nome";
	global.error.shortNameFormat= "Preencha corretamente o nome curto" ;
	global.error.format 		= "A senha necessita conter no mínimo 1 letra maiúscula, 1 minúscula e 1 algarismo"; 
	global.error.length 		= "O tamanho mínimo para senha são " + pass.minimalLength +  " caracteres";
	global.error.confirm    	= "Senhas não conferem. Tente de novo";
	
	global.error.confirmTerm    = "Por favor, confirme se concorda com os termos de uso e privacidade";	

	global.error.ln001          = " alt='Erro na tentativa de chamar rotina AJAX - Codigo LN001.' "	+ 
	                              " title='Erro na tentativa de chamar rotina AJAX - Codigo LN001.' ";
	
	global.error.ln002          = " alt='Erro na tentativa de chamar rotina AJAX - Codigo LN002.' "	+ 
								  " title='Erro na tentativa de chamar rotina AJAX - Codigo LN002.' ";
	
	global.error.connection     = "Falha na conexao. Problemas ao executar o navegador. <BR /> Código Suporte: " ;
	global.error.tryagain       = "Tente novamente.";
	
	/*
	 * Variaveis de Ambiente Mobile
	 */	
		
	global.isMobile 			= false;
	
	global.isValidEmailAddress= function(emailAddress) {
	    return global.regex.email.test(emailAddress);
	}

	
	global.msgbox = 
	   $("body").messageBox({
			// autoclose timeout. 0 = disable autoclose
			autoClose : 0,
			// show autoclose counter
			showAutoClose : true,      
			// enable modal mode  
			modal:true,
			// path to the CSS
			css: '../css/messageBox.css',
			// called when message box is closed
			cbClose: false,      
			// called when message box is ready         
			cbReady: false,      
			// localization        
			locale:{
			  NO : 'Não',
			  YES : 'Sim',
			  CANCEL : 'Cancelar',
			  OK : 'Ok',
			  textAutoClose: 'Esta tela fechará em %d segundos'
			}
		});
		
	/*
	 *  ===========================
	 *  Constantes do Sistema.
	 *  ===========================
	 *  
	 */
	window.constants = {};
	window.constants.titulo = {};
	


	
});