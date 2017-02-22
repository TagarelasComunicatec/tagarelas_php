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
						  + " alt='"	
						  + global.error.ln001 + "'" + fimImgHtmlTag;
			    $(divPosicao).empty();
			    $(divPosicao).append(imgError);

			},

			success: function(returned){ 
				//debugger;
				$(divPosicao).empty();
				imgError = inicioImgHtmlTag +  closing  
				 			 + " title='"	
				 			 +	global.error.emailFound + "'" 
							 + fimImgHtmlTag;
				
				var dataout = $.parseJSON(returned);
				
				if($.trim(dataout.result) === global.recordFound)
					$(divPosicao).append(imgOk);
				else 
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

