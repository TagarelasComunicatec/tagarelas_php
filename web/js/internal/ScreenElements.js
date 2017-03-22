/**
 *  Contains all Screen Dynamic Elements 
 */

$( function() {
	
	jsScreenElements = { }; 

	/*
	 * Prepare div group
	 */
	jsScreenElements.divGroupByStatus = function(status){
		if (status === global.statusUser.PENDING) {
			return jsScreenElements.divGroupPending;
		} else if(status === global.statusUser.ACTIVE )
			return jsScreenElements.divGroupActive;
		
    }
	
	jsScreenElements.divTitleGroupByStatus = function(status){
		if (status === global.statusUser.PENDING) 
			return jsScreenElements.divGroupPendingTitle;
		else if(status === global.statusUser.ACTIVE ) 
			return jsScreenElements.divGroupActiveTitle;
	}
	
	
	/*
	 * Prepare div Session
	 */
	jsScreenElements.divSessionByStatus = function(status){
		if (status === global.statuSession.SCHEDULED) 
			return jsScreenElements.divSessionScheduled;
	    
		else if(status === global.statusSession.ACTIVE ) 
			return jsScreenElements.divSessionActive;
	    
	    else if(status === global.statusSession.PENDING ) 
			return jsScreenElements.divSessionPending;
		
	    else if(status === global.statusSession.PUBLIC ) 
			return jsScreenElements.divSessionPublic;
	};
	
	jsScreenElements.divTitleSessionByStatus = function(status){
		if (status === global.statuSession.SCHEDULED) 
			return jsScreenElements.divSessionScheduledTitle;
	    
		else if(status === global.statusSession.ACTIVE ) 
			return jsScreenElements.divSessionActiveTitle;
	    
	    else if(status === global.statusSession.PENDING ) 
			return jsScreenElements.divSessionPendingTitle;
		
	    else if(status === global.statusSession.PUBLIC ) 
			return jsScreenElements.divSessionPublicTitle;
	};
	
	
	
	/**
	 * Pending Groups
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
		 '                onclick="location.href=\'' + $("#divNewGroup").attr("url") + '\';"' +
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

	jsScreenElements.divSessionScheduledTitle =
		'<h1>' +
		'     <small> '+
	    '       Sessões agendadas'+
        '     </small>' +
        '</h1> ';
	
	jsScreenElements.divSessionScheduled = 
		'<div class="col-xs-12 col-sm-4 col-md-3">' +
	    '     <div class="thumbnail clearfix">'+
		'          <a href="#" class="titulo-da-sessao titulo-sessao-agendada">'+
		'	               $sessionName$'+
		'          </a>'+
		'          <div class="caption">'+
		' 	            <div class="data-e-hora-da-sessao">'
		' 	             	<i class="material-icons">&#xE192;</i> $sessionDateTime$'+
		'           	</div>' +
		'        	    <div class="sessao-info-adicional">'+	
		'          		    <small>'+
		'  			            <a href="#">'
		'        				    <img src="$avatar$" width="18px" height="18px" style="background-color: #ccc"> $groupName$'+
		' 			             </a>'+
		' 		            </small>'+
		'	             </div> <!-- sessao-info-adicional -->'+
		' 	             <div class="link-de-acoes-da-sessao clearfix">'+
		'		              <div class="text-uppercase pull-left">'+
		'          			       <a href="#">Ler Mais</a>'+
		'	           	      </div>'+
		'   	      	      <div class="text-uppercase pull-right">'+
		' 			                <a href="#">Participar</a>'+
		'  		               </div>'+
		'        	     </div>'+
		'          </div> <!-- caption !-->'+
	    '       </div> <!-- thumbnail !-->'+
        '</div> <!-- col !-->'
	
	
	jsScreenElements.divSessionActiveTitle =
		'<h1>'+
		'  <small>'+
	    '     Sessões que irei participar '+
	    '     <span class="opcoes-feed">' +
		'         <small>'+
		'  	          <a href=\'location.href="#";\'>Ver todas</a> |' + 
		'     	           <button id="btnNewSession" '+  
		'                        onclick=\'location.href="'+ $('#divNewSession').attr('url') +'";\''+
		'	                     class="btn btn-success btn-xs">Criar Sessão'+
		'                   </button>'+
		'         </small>' +
		'      </span>' +
        ' </small>'+
        '</h1> ';
	
	jsScreenElements.divSessionActive = 
		'<div class="col-xs-12 col-sm-4 col-md-3">' +
		'   <div class="thumbnail clearfix">'
	    '        <a href="#" class="titulo-da-sessao titulo-sessao-que-irei-participar">'
		'             $sessionName$'+
	    '        </a>'+
	    '        <div class="caption">'+ 
		'             <div class="data-e-hora-da-sessao">'+
		'	               <i class="material-icons">&#xE192;</i> $datetimeSession'+
		'             </div>'+
		'             <div class="sessao-info-adicional">'+	
		' 	               <small>'+
		'                		<a href="#">'+ 
		' 			                  <img src="$avatar$" width="18px" height="18px" style="background-color: #ccc">'+
		'                                  $groupName$'+
		' 		                </a>'+
		'	               </small>'+
		'             </div> <!-- sessao-info-adicional -->'+
		'             <div class="link-de-acoes-da-sessao clearfix">'+
		' 	               <div class="text-uppercase pull-left">'+
		'	   	                <a href="#">Ler Mais</a>'+
		' 	               </div>'+
		'             </div>'+
	    '        </div> <!-- caption !-->'+
        '   </div> <!-- thumbnail !-->'+
        '</div> <!-- col !-->';
	
	jsScreenElements.divSessionPendingTitle = 
		'<h1>'+
		'   <small>'+
	    '       Sessões que não confirmei presença '+
	    '       <span class="opcoes-feed">'+
	    '             <small><a href="#">Ver todas</a></small>' +
	    '       </span>' +
        '   </small>' +
        '</h1>';
	
	jsScreenElements.divSessionPending = 
		'<div class="col-xs-12 col-sm-4 col-md-3">'+
		'    <div class="thumbnail clearfix">'+
	    '          <a href="#" class="titulo-da-sessao titulo-sessao-que-nao-confirmei-presenca">'+
		'              $sessionName$'+
	    '          </a>'+
	    '          <div class="caption">'+
		'              <div class="data-e-hora-da-sessao">'+
		'   	            <i class="material-icons">&#xE192;</i> $datetimeSession'+
		'               </div>'+
		'               <div class="sessao-info-adicional">'+	
		' 	                 <small>'+
		' 		                <a href="#">'+
		' 			               <img src="" width="18px" height="18px" style="background-color: #ccc">'+
		'                              $groupName$'+
		'		                </a>'+
		'	                 </small>'+
		'               </div> <!-- sessao-info-adicional -->'+
		'               <div class="link-de-acoes-da-sessao clearfix">'+
		' 	                 <div class="text-uppercase pull-left">'+
		' 		                  <a href="#">Ler Mais</a>'+
		' 	                 </div>'+
		'               </div>'+
	    '          </div> <!-- caption !-->'+
        '    </div> <!-- thumbnail !-->'+
        '</div> <!-- col !-->  ';
	
	jsScreenElements.divSessionPublicTitle = 
		'<h1>'+
		'   <small>'+
	    '       Sessões públicas '+
	    '       <span class="opcoes-feed">' + 
	    '            <small>'+
	    '               <a href="#">Ver todas</a>'+
	    '            </small>'+
	    '       </span>'+
        '   </small>'+
        '</h1>';
	
	jsScreenElements.divSessionPublic = 
		'<div class="col-xs-12 col-sm-4 col-md-3">'+
		'     <div class="thumbnail clearfix">'
	    '         <a href="#" class="titulo-da-sessao titulo-sessao-publica">'+
		'            $sessionName$'+
	    '         </a>'+
	    '         <div class="caption">'+
		'             <div class="data-e-hora-da-sessao">'+
		'               	<i class="material-icons">&#xE192;</i> $datetimeSession$'+
		'             </div>'+
		'             <div class="sessao-info-adicional">'+	
		'  	                <small>'+
		' 		               <a href="#">'+
		'						   <img src="" width="18px" height="18px" style="background-color: #ccc">'+
		'							   $groupName$'+
		' 					   </a>'+
		'	                </small>'+
		' 			  </div> <!-- sessao-info-adicional -->'+
		'			  <div class="link-de-acoes-da-sessao clearfix">'+
		'			  <div class="text-uppercase pull-left">'+
		'					<a href="#">Ler Mais</a>'+
		'			  </div>'+
		'		  	  <div class="text-uppercase pull-right">'+
		'					<a href="#">Participar</a>'+
		'		   	  </div>'+
		'		   </div>'+
		'		 </div> <!-- caption !-->'+
		' 	</div> <!-- thumbnail !-->'+
		'</div> <!-- col !--> '; 
	
	jsScreenElements.divLastActivitiesTitle = 
		'<h2>'+
		'    <small>Últimas Atividades Da Rede</small>'+
		'</h2>';
	
	jsScreenElements.divLastActivities = 
		'<div class="panel panel-default atividade-recente-da-rede">'+
		'     <div class="panel-heading">'+
	    '          <span class="glyphicon $activityIcon$" aria-hidden="true"></span> $activityType$'+
        '     </div>'+
        '     <div class="panel-body">'+
	    '        <p>'+
		'          <a href="">'+
		'    	        <img src="$profileImage" class="avatar-img avatar-pequeno"> $subTitle$'+
		'          </a>'+
	    '        </p>'+
	    '        $activeMessage$'+
        '    </div>'+
        '</div> ';
	
});