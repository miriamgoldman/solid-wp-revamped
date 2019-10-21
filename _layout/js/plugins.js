(function($){
		  
	$(document).ready(function(){
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////						   
		

		
		// -------------------------------------------------------------------------------------------------------
		// Tipsy - facebook like tooltips jQuery plugin
		// -------------------------------------------------------------------------------------------------------
		
		$('.tip').tipsy({gravity: 'w', fade: true});
		
		// -------------------------------------------------------------------------------------------------------
		// pretyPhoto - jQuery lightbox plugin
		// -------------------------------------------------------------------------------------------------------
		
		$("a[rel^='prettyPhoto']").prettyPhoto({
			opacity: 0.80, 						// Value between 0 and 1
			default_width: 500,
			default_height: 344,
			theme: 'light_square', 				// light_rounded / dark_rounded / light_square / dark_square / facebook 
			hideflash: false, 					// Hides all the flash object on a page, set to TRUE if flash appears over prettyPhoto 
			modal: false 						// If set to true, only the close button will close the window 
		});
		
	

		
		// -------------------------------------------------------------------------------------------------------
		//  Tabify - jQuery tabs plugin
		// -------------------------------------------------------------------------------------------------------
		
		$('#tab-1').tabify();
		$('#tab-2').tabify();
		$('#tab-3').tabify();
		$('#tab-4').tabify();
		$('#tab-5').tabify();
		
		// -------------------------------------------------------------------------------------------------------
		//  Accordeon - jQuery accordeon plugin
		// -------------------------------------------------------------------------------------------------------
		
		$('#accordion-1').accordion();
		$('#accordion-2').accordion();
		$('#accordion-3').accordion();
		$('#accordion-4').accordion();
		$('#accordion-5').accordion();
		
		// -------------------------------------------------------------------------------------------------------
		//  Comment Form - Validation
		// -------------------------------------------------------------------------------------------------------
		
		$("#comment-form").validity(function() {
			$("#author").require();                      
			$("#email").require().match("email");                      
			$("#comment").require();                      
		});
		
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	});

})(window.jQuery);

// non jQuery plugins below

