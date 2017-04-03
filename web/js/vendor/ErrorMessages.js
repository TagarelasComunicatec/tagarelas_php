/**
 * 
 */
 $ (function(){
    errorMessage = function(msg,hide){
	  jError(
		 msg,
		{
		  autoHide : hide, 
		  clickOverlay : false,
		  MinWidth : 250,
		  TimeShown : 3000,
		  ShowTimeEffect : 200,
		  HideTimeEffect : 200,
		  LongTrip :20,
		  HorizontalPosition : 'center',
		  VerticalPosition : 'center',
		  ShowOverlay : true,
   		  ColorOverlay : '#000',
		  OpacityOverlay : 0.3,
		  onClosed : function(){ 
		   
		  },
		  onCompleted : function(){
		   
		  }
		});
	  };
    });