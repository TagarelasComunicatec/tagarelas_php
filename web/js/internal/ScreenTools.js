/**
 * Autor:    Ricardo Rodriguez
 * Objetivo: Funcoes Globais do Sistema de Alunos
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

		contatos.initialize();
		
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
	
	
});	

