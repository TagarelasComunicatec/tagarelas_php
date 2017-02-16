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
	simuladorNotas = {};

	/*
	 * ============================================
	 * Utilização do NameSpace window no SIAAC-WEB
	 * ============================================
	 */
	
	window.debug  				=  true;
	window.debugCriticaFiltro  	=  false;
	
	window.host					= "";
	window.loading				= window.host + "http://siaac.cp2.g12.br/js/ajax/lineicons/ajax-loader.gif";
	window.closing 				= window.host + "http://siaac.cp2.g12.br/js/ajax/lineicons/Close-icon.png";
	window.okimg  				= window.host + "http://siaac.cp2.g12.br/js/ajax/lineicons/Ok-icon.png";
	window.trashimg 			= window.host + "http://siaac.cp2.g12.br/js/ajax/lineicons/Action-remove-icon.png";
	window.alertimg				= window.host + "http://siaac.cp2.g12.br/js/ajax/lineicons/sign-Alert-icon.png";

	window.divMatricula			= "divMatricula";
	window.urlLoadUsuario 		= null;

	window.loginCompleto  		= {};

	window.divPolo 				= 'imgPolo';
	window.divTurma				= 'imgTurma';
	window.divDisciplina		= 'imgDisciplina';
	window.divAvaliacao			= 'imgAvaliacao';
	window.divMes				= 'imgMes';
	window.divAlunos			= 'divAlunos';

	window.divTipoAvaliacao		= 'divTipoAvaliacao';
	window.divTotalAlunos		= 'divTotalAlunos';
	window.divNotaMinima		= 'divNotaMinima';
	window.divNotaMaxima		= 'divNotaMaxima';
	window.divNotaVermelha		= 'divNotaVermelha';
	window.divDadosProva		= 'divDadosProva';
	window.divAlunos			= 'divAlunos';

	window.loading				= window.host + "http://siaac.cp2.g12.br/js/ajax/lineicons/ajax-loader.gif";
	window.closing 				= window.host + "http://siaac.cp2.g12.br/js/ajax/lineicons/Close-icon.png";
	window.okimg  				= window.host + "http://siaac.cp2.g12.br/js/ajax/lineicons/Ok-icon.png";
	window.trashimg 			= window.host + "http://siaac.cp2.g12.br/js/ajax/lineicons/Action-remove-icon.png";
	window.alertimg				= window.host + "http://siaac.cp2.g12.br/js/ajax/lineicons/Sign-Alert-icon.png";
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
	
	window.CLEARALL				= 1;
	window.CLEARTURMA			= 2;
	window.CLEARDISCIPLINA		= 3;
	window.CLEARMES				= 4;
	window.CLEARAVALIACAO		= 5;
	window.CLEARRESUMO			= 6

	window.doClearSelects			= function(doClear){
		switch(doClear) {

		case CLEARALL:
			var $select		 = $('#selectPolo');
			$select.val(-1);
			$("#imgPolo").empty();
			
		case CLEARTURMA:	
			var $select		 = $('#selectTurma');
			$select.find('option').remove(); 	
			$("#imgTurma").empty();
			
		case CLEARDISCIPLINA:
			var $select		 = $('#selectDisciplina');
			$select.find('option').remove();
			$("#imgDisciplina").empty();
			
		case CLEARMES:
			if ($('#selectMes')){
				var $select		 = $('#selectMes');
				$select.find('option').remove();
			}
			$("#imgMes").empty();
			
		case CLEARAVALIACAO:
			if ($('#selectAvaliacao')){
				var $select		 = $('#selectAvaliacao');
				$select.find('option').remove();
			}
			$("#imgAvaliacao").empty();
			
		case CLEARRESUMO:
			var $resumo = $('.divResumo');
			if ($resumo.is(':visible')) {
				$resumo.hide();
			}
			$("#divAlunos").empty();

		}	

	}
	
	
	window.doClearSelects(window.CLEARALL);


	/*
	 * ================================
	 * Controle de segurança de Senhas
	 * ================================
	 */
	pass.minimalLength      = 7;
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
	
	global.error.matriculaformat= "Preencha corretamente a Matricula";
	global.error.nomeformat		= "Preencha corretamente o nome";
	global.error.format 		= "A senha necessita conter no mínimo 1 letra maiúscula, 1 minúscula e 1 algarismo"; 
	global.error.length 		= "O tamanho mínimo para senha são " + pass.minimalLength +  "caracteres";
	global.error.confirm    	= "Senhas não conferem. Tente de novo";
	global.error.notaNaoLancada = "Nota do aluno não foi lançada.";
	global.error.notaMinima		= "Nota do aluno é menor que ";
	global.error.notaMaxima		= "Nota do aluno é maior que ";
	global.error.emailFormat    = "Formato do email inválido. Tente de novo. ";
	global.error.confirmEmail   = "Emails Digitados não conferem !!"
	
	/*
	 * Variaveis de Ambiente Mobile
	 */	
		
	global.isMobile 			= false;	
		
	/*
	 * ======================================================
	 * Checagem de notas
	 * ======================================================
	 */
	
	window.verificaNotas = {

		/**
		 * ============================================
		 * Variaveis referentes ao controle de notas.
		 * Esses valores est�o disostos como hidden na
		 * tela de entrada de dados de notas dos alunos
		 * =============================================
		 */	

		notaMinima: 0,
		notaMaxima: 0,
		notaVermelha: 0,
		nota: null,
		nomeAluno: '',
		inputNota: null,

		doCheckCasasDecimais: function(){
			myNota = this.nota + "";
			return myNota.match(/^\d{1,2}(\.\d{1})?$/i);
		},

		doCheckValue:  function() { 

			if (this.inputNota.value==null || this.inputNota.value=="") {
				console.info("Nota apresentada como null ou em branco " + nota);
				return false;
			}
						
			if (isNaN(this.inputNota.value)){
				errorMessage( "Nota lançada inválida. Nota deve estar entre  " + verificaNotas.notaMinima + " e " + verificaNotas.notaMaxima + ". Tente novamente.", true);
				return false;
			}
			
			this.nota = this.nota - 0;
			var isNotaInvalida =  this.nota < this.notaMinima || 
								  this.nota > this.notaMaxima;

				  
			console.info("isNotaInvalida ? " + isNotaInvalida);
			
			if (isNotaInvalida) { 
				errorMessage("Nota informada (" + this.nota + ") para aluno " + this.nomeAluno +
						" não é válida. Tente de novo.",true ); 
				return false; 
			} 
								  
								  
			this.inputNota.style.color='blue';

			if (this.nota < this.notaVermelha){
				this.inputNota.style.color='red';
			}


			return true;

		} 
	};
	

	window.mensagemErroNota = function(nota, notaMinima, notaMaxima){

		nota = nota - 0;
		
		if (nota <  notaMinima)
			return global.error.notaMinima + notaMinima + ".";

		if (nota >  notaMaxima ) 
			return  global.error.notaMaxima + notaMaxima + ". ";
		
		return global.error.notaNaoLancada + ' - ' + nota;
	}
	
	window.printArea = function(){
		$('#printThis').hide();
		w=window.open('','','left=0,top=0,width=1,height=1,toolbar=0,scrollbars=0,status  =0');
		w.document.write('<!DOCTYPE html>');
		w.document.write('<html>');
		w.document.write("<link rel=\"stylesheet\" type=\"text/css\" href=\"/Notas_Online/web/css/estilocp2.css\" />");
		w.document.write("<link rel=\"stylesheet\" type=\"text/css\" href=\"/Notas_Online/web/css/estilo.css\" />");
		w.document.write("<body onload='window.print();window.onmouseover = function() { self.close(); }' >");
		w.document.write($('#printArea').html());
		w.document.write("</body>");
		w.document.write('</html>');
		w.print();
		setTimeout(function(){window.close();}, 100000);
		$('#printThis').show();
	}

	global.isValidEmailAddress= function(emailAddress) {
	    return global.regex.email.test(emailAddress);
	}

	
	window.doSavePassword = function(){
		
		var actualPassword 	 	  = calcMD5($('#actualPassword').val()+'');
		var pass				  = ($('#newPassword').val()+'').trim();
		var newPass				  = ($('#confirmNewPassword').val()+'').trim();
		var newPassword 	      = calcMD5($('#newPassword').val()+'');
		var confirmNewPassword    = calcMD5($('#confirmNewPassword').val()+'');
		
		result = pass.doVerifyPassword (pass,newPass);
		
		if (! result.status) {
			errorMessage(result.msgError,true);
			return false;
		}
		
		$('#changeEmail').submit();
	}
	
	/**
	 * Verifica a validade do Email
	 * @param email 
	 * @param confirmeEmail
	 * @returns {Boolean} true - emails ok, false - não ok
	 */

	window.docheckEmail = function (email, confirmeEmail){
		if (! global.isValidEmailAddress(email)){
			errorMessage(global.error.emailFormat + email,true);
			return false;
		}

		if (email != confirmeEmail){
			errorMessage(global.error.confirmEmail,true);
			return false;
		}	
		
		return true;
	}

	
	/*
	 *  ===========================
	 *  Constantes do Sistema.
	 *  ===========================
	 *  
	 */
	window.constants = {};
	window.constants.titulo = {};
	
	window.constants.titulo.cert1 			= "1ª Certificação";
	window.constants.titulo.cert2 			= "2ª Certificação";
	window.constants.titulo.cert3 			= "3ª Certificação";
	window.constants.titulo.ma 	  			= "MA";
	window.constants.titulo.paf 			= "PAF";
	window.constants.titulo.graus 			= "Graus";
	window.constants.titulo.apoio 			= "Apoio";
	window.constants.titulo.media			= "Média";
	window.constants.titulo.simulacao		= "<BR/>Simulação";
	window.constants.titulo.x3				= "&nbsp;x3";
	window.constants.titulo.x4				= "&nbsp;x4";
	window.constants.titulo.nome			= "Nome";
	window.constants.titulo.matricula		= "Matricula";
	window.constants.titulo.numeroChamada	= "Nº Chamada";
	window.constants.doispontos				= ": "
	window.constants.codAvaliacaoCert3		= 3;
	window.constants.codAvaliacaoPaf		= 21;

	
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
	        result.msgError = global.error.length;
	        return result;
	    }  else  if (p != cp) {
	        result.status   =false;
	        result.msgError = global.error.confirm;
	        return result;
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
	        result.msgError=global.error.format;
	        return result;
	    }
	    return result;
	}
	
	
	
	  
	
	
});