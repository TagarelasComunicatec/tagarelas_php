/**
 * Autor:    Ricardo Rodriguez
 * Objetivo: Funcoes Globais do Sistema de Alunos
 */

$( function() {
	
	$('#submitLogin').click(

			function(event){

				var user	  = $('#user').val(); 
				var senha	  = $('#password').val();
				var captcha	  = $('#captcha_code').val();		
				var senhaMd5  = calcMD5(senha);
				$('#userHidden').val(user);
				$('#passwordHidden').val(senhaMd5);
				$('#captcha_codeHidden').val(captcha);
				$('#password').val(senhaMd5);
				$('#login').submit();
				return true;
			});

	$('#submitEmail').click(

			function(event){

				var userUid = getURLParameter('0');
				var token   = getURLParameter('1');
				var idToken = getURLParameter('2');

				var email	= $('#email').val();
				var confirmeEmail = $('#emailConfirm').val();

				if (! window.docheckEmail(email, confirmeEmail)) {
					return false;
				}


				$('#changeEmail').submit();
			});


	$('#submitPassword').click( 

			function(event){

				var userUid 				= getURLParameter('0');
				var token   				= getURLParameter('1');
				var idToken 				= getURLParameter('2');
				var senhaAtual			    = calcMD5($('#actualPassword').val());
				var novaSenha				= calcMD5($('#newPassword').val());
				var novaSenhaConfirm		= calcMD5($('#confirmNewPassword').val());


				validadePassword = pass.doVerifyPassword(novaSenha,novaSenhaConfirm);
				
				if (!validadePassword.status){
					errorMessage(validadePassword.msgError,true);
					$('#newPassword').focus();
					return false;
				}	

				/*
				 *Trafega pela rede apenas senhas criptografadas. 
				 */

				$('#actualPassword').val(senhaAtual);
				$('#newPassword').val(novaSenha);
				$('#confirmNewPassword').val(novaSenhaConfirm);

				$('#changePassword').submit();	
				return true;

			});

	$('#newPassword').complexify(
			{ minimumChars:6, 
				strengthScaleFactor:0.7}, 
				function(valid, complexity){
					var calculated = (complexity/100)*268 - 134;
					var prop = 'rotate('+(calculated)+'deg)';

					// Rotate the arrow
					arrow = $('#main .arrow');
					arrow.css({
						'-moz-transform':prop,
						'-webkit-transform':prop,
						'-o-transform':prop,
						'-ms-transform':prop,
						'transform':prop
					});	

				});

	/*
	 * ---------------------------------------------------------------
	 * Executa o submit da tela de primeiro acesso.
	 * Nesta tela só consta a matricula, que redirecionará o cliente.
	 * ----------------------------------------------------------------
	 */
	$('#search').click(	
			function(event){
				var filtro = $('#filterSearch').val();
				$('#key').val(filtro);
				$('#type').val(filtro);
				$('#rpp').val(12);
				$('#curpage').val(1);
				$('#adminForm').submit();	
				return true;
			});

	
	$('#resetFilter').click(	
			function(event){
			    $('#filterSearch').val('');
				$('#key').val('');
				$('#type').val('');
				$('#rpp').val(12);
				$('#curpage').val(1);
				$('#adminForm').submit();	
				return true;
			});

	/*
	 * Executa a chamada de submissão da tela de primeiro acesso
	 */
	$('#submitPrimeiroAcesso').click(	
			function(event){
				
				$('#primeiroAcesso').submit();
				
				return true;

			});

	/*
	 * ----------------------------------------------------------------
	 * Executa o submit da tela de primeiro acesso do aluno 
	 * Nesta tela consta todos os dados do aluno
	 * ----------------------------------------------------------------
	 */
	$('#submitPrimeiroAcessoAluno').click(	
			function(event){

				senha			 = ($('#newPassword').val()+'').trim();
				confirmeSenha	 = ($('#confirmNewPassword').val()+'').trim();
				
				/*
				 *Trafega pela rede apenas senhas criptografadas. 
				 */
				senhaCript = calcMD5(senha);
				$('#newPassword').val(senhaCript);
				$('#confirmNewPassword').val(senhaCript);
				$('#primeiroAcessoAluno').submit();
				
				return true;

	});
	
	
	
	/*
	 * ----------------------------------------------------------------
	 * Executa o submit da tela de primeiro acesso do professor 
	 * Nesta tela consta todos os dados do professor
	 * ----------------------------------------------------------------
	 */
	$('#submitPrimeiroAcessoProfessor').click(	
			function(event){
				
				if (! doCheckPrimeiroAcessoProfessor()){
					return false;
				}
				
				$('#primeiroAcessoProfessor').submit();
				
				return true;

			});
	

	
	doCheckPrimeiroAcessoProfessor = function() {
		
		cpfHidden 		 = ($('#d').val()+'').trim();
		nascimentoHidden = ($('#e').val()+'').trim();
		cpf				 = ($('#cpf').val()+'').trim();
		nascimento		 = ($('#dataNascimento').val()+'').trim();
		email			 = ($('#email').val()+'').trim();
		confirmeEmail	 = ($('#confirmeEmail').val()+'').trim();
		senha			 = ($('#newPassword').val()+'').trim();
		confirmeSenha	 = ($('#confirmNewPassword').val()+'').trim();

		cpfMd5 = calcMD5(cpf.trim());
		
		if (cpfMd5 != cpfHidden){
			console.log(cpfMd5 , cpfHidden);
			errorMessage(global.error.cpf,true);
			$('#cpf').focus();
			
		}
		
		nascimentoInvertido = newdate = nascimento.split("/").reverse().join("-");
		nasc = calcMD5(nascimentoInvertido);
		
		if (nasc != nascimentoHidden){
			errorMessage(global.error.nascimento,true);
			$('#dataNascimento').focus();
		}
		
		if (! window.docheckEmail(email, confirmeEmail)) {
			$('#email').focus();
			return false;
		}

		var validadePassword = pass.doVerifyPassword(senha,confirmeSenha);
		
		if (!validadePassword.status){
			errorMessage(validadePassword.msgError,true);
			$('#newPassword').focus();
			return false;
		}
		
		/*
		 *Trafega pela rede apenas senhas criptografadas. 
		 */
		senhaCript = calcMD5(senha);
		$('#newPassword').val(senhaCript);
		$('#confirmNewPassword').val(senhaCript);
		
		return true;
		
		
	};

	/**
	 * ===============================================
	 * Critica do botão de submit do form lancarNotas.
	 * ===============================================
	 */
	
	$( "#lancarNotas" ).submit(function( event ) {
		  console.log( "Handler for .submit() called." );
		  return doCheckDataEntryLancarNotas();
	});
		
	/**
	 * ============================================================================
	 * Verifica os dados inseridos na tela de entrada de dados de lancarNotas e
	 * bloqueia a continuação do processo caso não sejam satisfeitas as condições
	 * de entrada de dados.
	 * ============================================================================
	 */
	doCheckDataEntryLancarNotas = function(){
		var result 		= true;
		var notaMinima	= $('#notaMinima').val()-0;
		var notaMaxima	= $('#notaMaxima').val()-0;
		
		$( "input[name='nota[]']" ).each(
			    function( intIndex, element ){
			    	console.log('nota lancada->index: '+ intIndex + ' Valor: ' + $(element).val());
			    	// Verifica se o professor digitou virgula ao invés de um número.
			    	if (($(element).val()).indexOf(",") > 0){
			    		errorMessage('Verique entrada de dados. Troque as vírgulas (,) por pontos decimais (exemplo: 8.3)',true);
			    		result = false;
			    		return result;
			    	}	
			    	if (($(element).val()).lenght > 0 && isNaN($(element).val())) {
			    		errorMessage('Verique entrada de dados. São válidos apenas números ponto decimal (exemplo: 6.5)',true);
			    		result = false;
			    		
			    	}
			    	if (! isNaN($(element).val())){
			    		myNota = $(element).val() - 0;
			    		if (myNota < notaMinima || myNota > notaMaxima){
			    			result = false;
			    		}	
			    	}
			   	}
		);
		//-------------------------------------------------------------------- 
		// Apresenta mensagem de notas inválidas, caso alguma esteja com erro.
		//--------------------------------------------------------------------
		if (! result) errorMessage('Verique entrada de dados. Corrija notas inválidas',true);
		
		return result;
	};
	
	/*
	 * Radio button de flgAtivo. 
	 */

	$('input[type=radio][name=ativo1]').click(function() {
		$('#flgAtivo').val(1);
		$( '#lblAtivo1').attr('class', "btn active btn-success" );
		$( '#lblAtivo0').attr('class', "btn" );;
	});

	$('input[type=radio][name=ativo0]').click(function() {
		$('#flgAtivo').val(0);
		$("#lblAtivo0").attr('class', 'btn active btn-danger' );
		$('#lblAtivo1').attr('class', 'btn' );;
	});
	
	/*
	 * Radio button de SuperUsuario. 
	 */
	$('input[type=radio][name=super1]').click(function() {
		$('#superUser').val(1);
		$( '#lblSuper1').attr('class', "btn active btn-success" );
		$( '#lblSuper0').attr('class', "btn" );;
	});

	$('input[type=radio][name=super0]').click(function() {
		$('#superUser').val(0);
		$("#lblSuper0").attr('class', 'btn active btn-danger' );
		$('#lblSuper1').attr('class', 'btn' );;
	});
	

	$('#showHideError').click( function() {
		    $("#showError").toggle();
	});
	
	/**
	 * Mostra ou esconde o footer da tela.
	 */
	$('#closeFooter').click( function(){
		sessionStorage.setItem("footerHidden", true);
		doShowHideBaseFooter();
	});
	
	$('#openFooter').click( function(){
		sessionStorage.removeItem("footerHidden");
		doShowHideBaseFooter();
	});
	
	doShowHideBaseFooter = function(){
		hidden = sessionStorage.getItem("footerHidden");
		if (hidden) {
			$('#basefooter').hide();
  		    $('#basefooterSlim').show();
		} else {
			$('#basefooter').show();
  		    $('#basefooterSlim').hide();
		} 
	};
	
	getURLParameter = function (sParam) {
		var sPageURL = window.location.search.substring(1);
		var sURLVariables = sPageURL.split('&');
		for (var i = 0; i < sURLVariables.length; i++){
			var sParameterName = sURLVariables[i].split('=');
			if (sParameterName[0] == sParam) return sParameterName[1];
		}
	};

	doHideElementsPrimeiroAcesso = function(){
		if (! $('#d')){
			return;
		}
		cpfHidden 		 = ($('#d').val()+'').trim();
		nascimentoHidden = ($('#e').val()+'').trim();
		myCpfHidden 			 = calcMD5(cpfHidden);
		myNascimentoHidden 	 = calcMD5(nascimentoHidden);
		$('#d').val(myCpfHidden);
		$('#e').val(myNascimentoHidden);
	}
	
	doHideElementsPrimeiroAcesso();
	doShowHideBaseFooter();
	
	
});	

