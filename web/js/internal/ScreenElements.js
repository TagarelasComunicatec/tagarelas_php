/**
 *  Contains all Screen Dynamic Elements 
 */

$( function() {
	
	jsScreenElements = { }; 
			
	jsScreenElements.divGroupByStatus = 

			"<div class='col-xs-12 col-sm-6 col-md-3'> "+
			"   <div class='caixa-de-apresentacao'>" +
			"     <a href='#'>" +
		    "        <img src='$avatarGroup$' class='pull-left'>$groupName$"+
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

});