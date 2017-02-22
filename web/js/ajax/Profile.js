/**
 * Autor:    Ricardo Rodriguez
 * Objetivo: Métodos de atualização de informações de usuário.
 */

$( function() {
	jsProfile = {};
	
	jsProfile.checkEmail = function() {
		var email 	   = $("#email").val();
		var divPosicao = '#imgEmail';
		var url        = $('#checkEmailPath').val();

		//debugger;

		//========================================================
		var	pageurl = url;			// Executa atrav�s de AJAX a p�gina informada
		//========================================================
		//	Para consultar mais opcoes possiveis numa chamada ajax
		// 		http://api.jquery.com/jQuery.ajax/
		//=========================================================
		var myData = {'email' : email};
		
		$.ajax({
			url: pageurl,
			data: myData,
			type: 'POST',
			cache: true,
	
			beforeSend: function( ) {
				$(divPosicao).empty();
				$(divPosicao).append(imgLoading);
			},
		
			error: function(){
				imgError = inicioImgHtmlTag +  closing  +
						   global.error.ln001 + fimImgHtmlTag;
			    $(divPosicao).empty();
			    $(divPosicao).append(imgError);

			},

			success: function(result){ 
				//debugger;
				if($.trim(result) == '1'){
					$(divPosicao).empty();
					$(divPosicao).append(imgOk);
					return;
					
				} else if ($.trim(result) == '2'){  // registro já existe
					$(divPosicao).empty();
					$(divPosicao).append(imgTrash);
					global.msgbox.data('messageBox').danger(window.important, 
							gglobal.error.emailFound);
					return;
				}
				
				imgError = inicioImgHtmlTag +  closing  +
				           global.error.ln001 + fimImgHtmlTag;
				           $(divPosicao).empty();
				           $(divPosicao).append(imgError);
				return;
			},
			statusCode: {
				404: function() {
					global.msgbox.data('messageBox').danger(window.important, 
							global.error.connection + pageurl + ". "+ global.error.tryagain);
				}
			}
		});
	};		

	
	
	
	
});

