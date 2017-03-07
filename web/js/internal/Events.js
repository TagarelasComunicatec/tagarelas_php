/**
 * Autor:    Ricardo Rodriguez
 * Objetivo: Controle de Eventos do Sistema
 */



$( function() {
	$("input[type=text]").focus(function() {
		   $(this).select();
	});
	
	$("#email").focusout(function(){
		jsProfile.checkEmail();
	});

	/**
	 * Clique do botão de novo cadastro
	 */
	$("#newUser").click(function() {
		jsProfile.saveNewUser();
		
	});
	
	$("#loginUserTagarelas").click(function() {
		jsProfile.checkLoginTagarelas();
		
	});
	
	$("#groupName").focusout(function(){
		jsGroup.checkGroupName();
	});

	/**
	 * Clique do botão de novo grupo
	 */
	$("#insertNewGroup").click(function() {
		jsGroup.saveNewGroup();
	});
	
	$("#sessionName").focusout(function(){
		jsSession.checkSessionName();
	});
	
	$("#insertNewSession").click(function() {
		jsSession.saveNewSession();
	});
	
	/**
	 * Configure the datetime field of session bundle
	 */
	
	$("#dtBox").DateTimePicker();
	
	/**
	 * Load events em feed page
	 */
	
	if ($("#pendingGroup").length){
		jsGroup.loadGroupsByStatus(global.statusUser.PENDING,$("#pendingGroup"));
	}
	
	
	$('#imageGroup').ssi_uploader({

		  // The utl to which the ajax request is sent.
		  url: $("#divUpload").attr("url"),

		  // Sends extra data with the request.
		 // data: {},

		  // en, gr, pt_br
		  locale: 'pt_br',

		  // Enables/disables the file preview.
		  preview: true,

		  // Enables/disables drag and drop.
		  dropZone: true,

		  // How many files are allowed per upload.
		  maxNumberOfFiles: '2',


		  // If true the upload will continue normally even if there is an error in a callback function. 
		  // If false the upload will aborted, if it's possible, and will console.log the errors.
		  ignoreCallbackErrors: false,

		  // The maximum size of each file.
		  maxFileSize: 10,

		  // Extends the default options of $.ajax function. 
		  ajaxOptions: {},

		  // The files allowed to be uploaded. 
		  allowed: ['jpg', 'jpeg', 'png', 'bmp', 'gif'],

		  // The method that will be used to display the messages.
		  errorHandler: {
		    method: function (msg) {
		        alert(msg);
		    },
		    success: 'success',
		    error: 'error'
		  },
		  
		  // executed when the upload process end
		 /* onUpload: function () {
		  },

		  // executed when each file finishes to uploading
		  onEachUpload: function () {
		  },

		  // executed before an upload process starts
		  beforeUpload: function () {
		  },

		  // executed just before each file starts to uploading
		  beforeEachUpload: function () {
		  },*/
		  
		});
	

});	

