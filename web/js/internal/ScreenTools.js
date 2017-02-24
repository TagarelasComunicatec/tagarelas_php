/**
 * Autor:    Ricardo Rodriguez
 * Objetivo: Ferramentas de Tela
 */

$( function() {
	
	$(document).mouseup(function (e){
		var area_selecionada = $("#menu");

		if (!area_selecionada.is(e.target) && area_selecionada.has(e.target).length === 0) 
		{
			$("#menu").find(".collapse").each(function(index) {
				
				if($(this).hasClass("in")) {
				
					$(this).removeClass("in");
					$(this).attr("aria-expanded", "false");
					$("#mais-menu-usuario, #mais-menu-pesquisa, #mais-menu-xs, #mais-menu-sm, #mais-menu-lg").children("a").attr("aria-expanded", "false");
				}		
				
			});
		}
	});
	
	// esconder menu aberto se clicar em outro item do menu
	$(document).ready(function(){
		$("#mais-menu-usuario, #mais-menu-pesquisa, #mais-menu-xs, #mais-menu-sm, #mais-menu-lg").click(function () {
					
			var item_selecionado = $(this).children("a");			
					
			if(item_selecionado.attr("aria-expanded") == "false") {
				$("#menu").find(".collapse").each(function(index) {
				
					if($(this).hasClass("in")) {
					
						$(this).removeClass("in");
						$(this).attr("aria-expanded", "false");
						$("#mais-menu-usuario, #mais-menu-pesquisa, #mais-menu-xs, #mais-menu-sm, #mais-menu-lg").children("a").attr("aria-expanded", "false");
					}		
					
				});
				item_selecionado.attr("aria-expanded", "true");
			}
			else {
				item_selecionado.attr("aria-expanded", "false");
			}
		
		});
		
		// footer no final da página quando o conteúdo é pouco
		var docHeight = $(window).height();
		var footerHeight = $('footer').height();
		var footerTop = $('footer').position().top + footerHeight;
	   
		if (footerTop < docHeight) {
			$('footer').css('margin-top', (docHeight - footerTop) + 'px');
		}
		
		$('#submenu-pesquisa').on('shown.bs.collapse', function () {
			$("#pesquisa-principal").focus();
		});
	
		var jsonDataContatos = [
		{
			"id": "1",
			"avatar": "img/default-avatar.gif",
			"nomeUsuario": "Usuário 1"
		},
		{
			"id": "2",
			"avatar": "img/default-avatar.gif",
			"nomeUsuario": "Usuário 2"
		},
		{
			"id": "3",
			"avatar": "img/default-avatar.gif",
			"nomeUsuario": "Usuário 3"
		}
		];
		
		var contatos = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('id', 'avatar', 'nomeUsuario'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			local: jsonDataContatos

		});

		//*----------------------
		contatos.initialize();
		//*----------------------
		$('#pesquisa-principal').typeahead(
			{
				offset: true,	// os resultados são de acordo com as letras iniciais
				accent: false, // ignora os acentos na busca do resultado
				minLength: 1, // quantidade mínima de caracteres para apresentar o resultado da pesquisa
				order: "asc",
				backdrop: { "background-color": "#fff" },
			}, 
			{
				name: 'contatos',
				display: 'nomeUsuario',
				source: contatos.ttAdapter(),
				templates: {
					empty: [
						'<span class="sem-sugestao">Nenhum resultado encontrado</span>'
					].join('\n'),
					suggestion: function(data) {
						return '<a href="#" id="' + data.id + '" onclick="adicionarMembro(this); return false;">' +
						'<img src="' + data.avatar + '" class="avatar-img avatar-pequeno">' +
						'<span class="texto">' + data.nomeUsuario + '</span>' +
						'<span class="id" style="display: none">' + data.id + '</span>' +
						'</a>'
					}
				}
			}
		);
	}); 
	
	//*------------------------------
	ajustarLarguraDosItensDoScroll();
	//*-------------------------------
	
	function ajustarLarguraDosItensDoScroll() {
		$(".frame").find(".slide").each(function(index) {
			$(this).children().each(function(index) {
				$(this).width($(this).width()+15);
			});
			
		});
	}
	
	$( window ).resize(function() {
		scrollHorizontalResponsivo();
	});
	
	$(window).on("orientationchange", function(){
		scrollHorizontalResponsivo();
	});
	
	function scrollHorizontalResponsivo() {
		
		$(".frame").each(function(index) { 
		
			var frame = $(this);
			
			frame.find(".slide").each(function(index) {
			
				var slide = $(this);
				
				if(slide.width() < frame.width()) {
				
					frame.sly(false);
					
					frame.parent().find(".btn-control-scroll").each(function(index) {
					
						if(!$(this).hasClass("disabled"))
							$(this).addClass("disabled");
							
					});
				}
				else {
					frame.sly(false);
					reloadScroll();
				}
				
			});
		});
	}
	
	var conteudo_menu_ativo;

	function ConteudoMenuAtivo() {
		$('#conteudo-menu-scroll ul li').each(function(index) {
			if($(this).hasClass("ativo"))
				conteudo_menu_ativo = index;
		});
	}
	//*------------------
	ConteudoMenuAtivo();
	reloadScroll();
	//*-----------------
	
	function reloadScroll() {
		$frame  = $('#conteudo-menu-scroll');
		var $slidee = $frame.children('ul').eq(0);
		var $wrap   = $frame.parent();

		// Call Sly on frame
		$frame.sly({
			// Item based navigation
			horizontal: 1,
			itemNav: 'basic',
			smart: 1,
			activateOn: 'click',
			
			// Dragging
			mouseDragging: 1,
			touchDragging: 1,
			releaseSwing: 1,
			elasticBounds: 1,
			
			// Scrolling
			scrollBy: 1,
			
			// Mixed options
			speed: 1000,
			startAt: conteudo_menu_ativo,

			// Buttons
			prevPage: $wrap.find('.prevPage'),
			nextPage: $wrap.find('.nextPage')
		});
	}			

	
	function retirarMembro(botao, event) {
		// remoção do membro
		botao.parentElement.remove();
		
		// atualização da mensagem de quantidade de membros adicionados
		var total_de_membros_atual = parseInt($("#total-de-membros").text()) - 1;
		$("#total-de-membros").text(total_de_membros_atual);
		mensagemDeTotalDeMembros(total_de_membros_atual);		
	}
	
	function adicionarMembro(link) {
		// bloqueio da inclusão de um contato já adicionado
		var bloqueio = false;
		
		$(".previa-membros-adicionados").find("li").each(function(index) {
			if($(this).children('.id').text() == link.id)
				bloqueio = true;
		});
		
		if(bloqueio == true)
			return false;
		
		// inclusão do membro
		var contato_selecionado = $("#" + link.id).html();
		$(".previa-membros-adicionados ul").first().prepend("<li>" + contato_selecionado + " <button class='btn btn-link' onclick='retirarMembro(this)'> <i class='material-icons'>&#xE5CD;</i></button> </li>");
		
		// atualização da mensagem de quantidade de membros adicionados
		var total_de_membros_atual = parseInt($("#total-de-membros").text()) + 1;
		$("#total-de-membros").text(total_de_membros_atual);
		mensagemDeTotalDeMembros(total_de_membros_atual);
	}
	
	function mensagemDeTotalDeMembros(total_de_membros_atual) {
		if(total_de_membros_atual <= 1 ) {
			$("#mensagem-total-de-membros").text("Membro adicionado");
		}
		else {
			$("#mensagem-total-de-membros").text("Membros adicionados");
		}
	}
	
	function retirarMembro(botao, event) {
		// remoção do membro
		botao.parentElement.remove();
		
		// atualização da mensagem de quantidade de membros adicionados
		var total_de_membros_atual = parseInt($("#total-de-membros").text()) - 1;
		$("#total-de-membros").text(total_de_membros_atual);
		mensagemDeTotalDeMembros(total_de_membros_atual);		
	}
	
	function adicionarMembro(link) {
		// bloqueio da inclusão de um contato já adicionado
		var bloqueio = false;
		
		$(".previa-membros-adicionados").find("li").each(function(index) {
			if($(this).children('.id').text() == link.id)
				bloqueio = true;
		});
		
		if(bloqueio == true)
			return false;
		
		// inclusão do membro
		var contato_selecionado = $("#" + link.id).html();
		$(".previa-membros-adicionados ul").first().prepend("<li>" + contato_selecionado + " <button class='btn btn-link' onclick='retirarMembro(this)'> <i class='material-icons'>&#xE5CD;</i></button> </li>");
		
		// atualização da mensagem de quantidade de membros adicionados
		var total_de_membros_atual = parseInt($("#total-de-membros").text()) + 1;
		$("#total-de-membros").text(total_de_membros_atual);
		mensagemDeTotalDeMembros(total_de_membros_atual);
	}
	
	function mensagemDeTotalDeMembros(total_de_membros_atual) {
		if(total_de_membros_atual <= 1 ) {
			$("#mensagem-total-de-membros").text("Membro adicionado");
		}
		else {
			$("#mensagem-total-de-membros").text("Membros adicionados");
		}
	}
	
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
	}
	
	
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
			  image           : "/tagarelas/web//img/loading.gif",
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
	}
	
	window.ajaxLoading("hide");
});	

