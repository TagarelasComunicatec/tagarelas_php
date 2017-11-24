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
	global.error.shortNameFound = "Nome curto já está cadastrado. Tente outro !!";
	global.error.format 		= "A senha necessita conter no mínimo 1 letra maiúscula, 1 minúscula e 1 algarismo"; 
	global.error.length 		= "O tamanho mínimo para senha são " + pass.minimalLength +  " caracteres";
	global.error.confirm    	= "Senhas não conferem. Tente de novo";
	
	global.error.confirmTerm    = "Por favor, confirme se concorda com os termos de uso e privacidade";	

	global.error.ln001          = " alt='Erro na tentativa de chamar rotina AJAX - Codigo LN001.' "	+ 
	                              " title='Erro na tentativa de chamar rotina AJAX - Codigo LN001.' ";
	
	global.error.ln002          = " alt='Erro na tentativa de chamar rotina AJAX - Codigo LN002.' "	+ 
								  " title='Erro na tentativa de chamar rotina AJAX - Codigo LN002.' ";

	global.error.groupNameFound      = "Nome do grupo já está cadastrado. Tente outro nome";
	global.error.groupEmpty          = "Nome do grupo não está preenchido. Tente de novo";
	global.error.groupMemberNotFound = "Insira pelo menos 1 nome como membro do grupo";
	
	global.error.connection     = "Falha na conexao. Problemas ao executar o navegador. <BR /> Código Suporte: " ;
	global.error.tryagain       = "Tente novamente."
		
	global.error.sessionName	    = "Informe corretamente o nome da Sessão";
	global.error.sessionDescription = "Informe corretamente o assunto da Sessão";
	global.error.sessionNotFound    = "Nome da Sessão já está cadastrado";
	global.error.sessionDateTime    = "Informe a data e hora da sessão";
	global.error.sessionGroups	    = "Informe os grupos e/ou membros que farão parte da sessão";
	global.error.sessionVisibility	= "Informe se a visibilidade da sessão é pública ou privada";
	global.error.sessionDuration    = "Informe a duração da sessão (em minutos)",
		
		
	global.saveOk				= "Informação foi salva com sucesso";
	global.saveError			= "A informação não foi salva. Tente mais tarde";
	
	/*
	 * Variaveis de Ambiente Mobile
	 */	
		
	global.isMobile 			= false;
	
	/*
	 * Variaveis de Ambiente
	 */	
		
	global.recordFound				= 	"1";
	global.recordNotFound			=   "2";
	global.recordSavedWithSuccess   =   "3";
	global.recordUnsaved			=   "4";
	global.loginCorrect				=   "5";
	global.loginUncorrect			=   "6";
	global.usersFound 				= 	"7";
	global.usersNotFound 			=   "8";

	global.statusUser = { };

	global.statusUser.PENDING  = "USER_PENDING";
	global.statusUser.ACTIVE   = "USER_ACTIVE";
	global.statusUser.REJECTED = "USER_REJECT";
	global.statusUser.CANCELED = "USER_CANCELED";
	global.statusUser.BANNED   = "USER_BANNED";
	
	global.statusSession = { };
	global.statusSession.SCHEDULED=0;
	global.statusSession.ACTIVE=1;
	global.statusSession.PENDING=2;
	global.statusSession.PUBLIC=3;
	
	
	global.statusUser.title  = [
								 "Grupos Pendentes de Confirmação",
								 "Meus Grupos",
								 "Grupos Rejeitados",
								 "Grupos Cancelados pelo Administrador",
								 "Grupos que fui banido",
								 ];
	
	
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
		
	/**
	 * ========================================================
	 * Verifica as condições necessárias para aprovar uma senha
	 * ========================================================
	 */
	
	pass.doVerifyPassword = function (password,confirmPassword){
	    var result 			= {};
	    var p 				= password;
	    var cp 				= confirmPassword;
	    
	    result.status = true;

	    if(p.length < pass.minimalLength){
	        result.status   =false;
	        global.msgbox.data('messageBox').danger(window.important, global.error.length);
	        return result.status;
	    }  else  if (p != cp) {
	        result.status   =false;
	        global.msgbox.data('messageBox').danger(window.important,global.error.confirm);
	        return result.status;
	    }

	    var numUpper = 0;
	    var numLower = 0;
	    var numNums = 0;
	    var numSpecials = 0;
	    
	    for(var i=0; i<p.length; i++){
	        if(global.regex.anUpperCase.test(p[i]))
	            numUpper++;
	        else if(global.regex.aLowerCase.test(p[i]))
	            numLower++;
	        else if(global.regex.aNumber.test(p[i]))
	            numNums++;
	        else if(global.regex.aSpecial.test(p[i]))
	            numSpecials++;
	    }

	    if(numUpper    < pass.minimalUpper  || 
	       numLower    < pass.minimalLower  || 
	       numNums     < pass.minimalNumber || 
	       numSpecials < pass.minimalEspChar){
	        result.status  = false;
	        global.msgbox.data('messageBox').danger(window.important,global.error.format);
	        return result.status;
	    }
	    return result.status;
	}
	
	window.fullUrl = function(){
		var myurl = $("#divHost").attr("url");
		myurl = myurl.replace("app_dev.php","");
		return myurl;
	}

	/**
	 * Verifica a validade do Email
	 * @param email 
	 * @param confirmeEmail
	 * @returns {Boolean} true - emails ok, false - não ok
	 */

	window.docheckEmail = function (email, confirmeEmail){
		if (! global.isValidEmailAddress(email)){
			global.msgbox.data('messageBox').danger(window.important,global.error.emailFormat + email);
			return false;
		}

		if (email != confirmeEmail){
			global.msgbox.data('messageBox').danger(window.important,global.error.confirmEmail);
			return false;
		}	
		
		return true;
	};
	
	
	window.doCheckIsEmptyField = function(field,msgError){
		var field = $('#'+field).val()+'';
		if (! field){
			global.msgbox.data('messageBox').danger(window.important,msgError);
			return true;
		}
		return false;
	};
	
	
	window.ajaxLoading = function(show){
		$.LoadingOverlay(show, {
			  // background color
			  color           : "rgba(255, 255, 255, 0.8)",
			  // additonal CSS classes
			  custom          : "",
			  // fade out the loading overlay
			  fade            : true,
			  // use Font Awesome 4 icons for the loading spinner
			  fontawesome     : "",
			  // default loading spinner
			  image           : window.fullUrl()  + "img/loading.gif",
			  // postion of the spinner
			  imagePosition   : "center center",
			  // min/max size of the spinner
			  maxSize         : "100px",
			  minSize         : "20px",
			  // Specifies an interval in milliseconds to resize the Loading Overlay accoring to its container.
			  // Use this when the DOM element is supposed to change size while the Loading Overlay is shown.
			  resizeInterval  : 0,
			  // size of the spinner
			  size            : "50%",
			  // z-index property
			  zIndex          : undefined
			});
	};
	
	window.ajaxLoading("hide");
	
});