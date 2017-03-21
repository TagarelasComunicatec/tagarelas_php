/**
 *  Contains all Screen Dynamic Elements 
 */

$( function() {
	
	jsScreenElements = { }; 

	jsScreenElements.divGroupByStatus = function(status){
		if (status === global.statusUser.PENDING) {
			return jsScreenElements.divGroupPending;
		} else if(status === global.statusUser.ACTIVE )
			return jsScreenElements.divGroupActive;
		
    }
	
	jsScreenElements.divTitleGroupByStatus = function(status){
		if (status === global.statusUser.PENDING) {
			return jsScreenElements.divGroupPendingTitle;
		} else 
			return jsScreenElements.divGroupActiveTitle;
	}
	
	/**
	 * Grupos Pendentes
	 */
	jsScreenElements.divGroupPendingTitle =
		'<h1><small >Grupos Pendentes de Confirmação</small></h1>';
	
	jsScreenElements.divGroupPending = 

		"<div class='col-xs-12 col-sm-6 col-md-3'> "+
		"   <div class='caixa-de-apresentacao'>" +
		"     <a href='#'>" +
	    "        <img src='$avatar$' class='pull-left'>$groupName$"+
	    "	  </a>" +
	    "        <div class='info-adicional'>" +
	   	"				$totalMembers$ Membros"+
	    "        </div>"+
	    "        <br />"+
		"        <div class='link-de-acoes-da-sessao clearfix'> "+
		"		        <div class='text-uppercase pull-left'>"+
		"			       <a id='linkConfirm'>Confirmar</a>" +
		"       		</div>"+
		"       		<div class='text-uppercase pull-right'>"+
		"        			<a id='linkReject' href='#'>Ignorar</a>"+
		"        		</div>"+
		"        </div>"+
	    "    </div>"+
	    "</div>";
	
	/**
	 * Grupos Ativos
	 */
	jsScreenElements.divGroupActiveTitle = 
		'<h1>'+
	     '    <small>Grupos que faço parte'+
		 '           <span class="opcoes-feed"><small>'+
		 '          <a href="#">Ver Todos</a> |' +
		 '               <button id="newGroup"' +
		 '                onclick="location.href=\'' + $("divSaveNewGroup").attr("ajaxurl") + '\';"' +
		 '                class="btn btn-success btn-xs">Criar Grupo</button></small><span>'
	     ' </small>'+ 
        '</h1>';
	
	jsScreenElements.divGroupActive = 	 
		'<div class="col-xs-12 col-sm-6 col-md-3">'+
	    '    <div class="caixa-de-apresentacao"' +
		'        <a href="#">' +
		'        	<img src="$avatar$" class="pull-left">' +
		'	               $groupName$'+
		'        </a>'+
		'           <div class="info-adicional">'+
		'	         $totalMembers$ Membros' +      
		'           </div>'+
	    '     </div>'+
        '</div>';

	jsScreenElements.divSession
	
	
	
	
});