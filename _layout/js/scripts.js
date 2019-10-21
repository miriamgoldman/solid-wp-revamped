(function($){	
	
	// -------------------------------------------------------------------------------------------------------
	// Form Validation script - used by the Contact Form script
	// -------------------------------------------------------------------------------------------------------
	
	function validateMyAjaxInputs() {

		$.validity.start();
		// Validator methods go here:
		$("#name").require();
		$("#email").require().match("email");
		$("#subject").require();	

		// End the validation session:
		var result = $.validity.end();
		return result.valid;
	}
	
	// -------------------------------------------------------------------------------------------------------
	// Form Clear
	// -------------------------------------------------------------------------------------------------------
	
	$.fn.clearForm = function() {
	  return this.each(function() {
	 var type = this.type, tag = this.tagName.toLowerCase();
	 if (tag == 'form')
	   return $(':input',this).clearForm();
	 if (type == 'text' || type == 'password' || tag == 'textarea')
	   this.value = '';
	 else if (type == 'checkbox' || type == 'radio')
	   this.checked = false;
	 else if (tag == 'select')
	   this.selectedIndex = -1;
	  });
	};

	$(document).ready(function(){
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////						   
		
		// -------------------------------------------------------------------------------------------------------
		// Dropdown Menu
		// -------------------------------------------------------------------------------------------------------
		
		$("ul#dropdown-menu li").hover(function () {
												 
			$(this).addClass("hover");
			$('ul:first', this).css({visibility: "visible",display: "none"}).slideDown(200);
		}, function () {
			
			$(this).removeClass("hover");
			$('ul:first', this).css({visibility: "hidden"});
		});
		
		if ( ! ( $.browser.msie && ($.browser.version == 6) ) ){
			$("ul#dropdown-menu li ul li:has(ul)").find("a:first").addClass("arrow");
		}
								
		// -------------------------------------------------------------------------------------------------------
		// Hover over Services Overview + make entire service overview clickable
		// -------------------------------------------------------------------------------------------------------
		
		$(".services-overview-overlay").hide();
		
		 $("#services-overview li").hover(
			  function(){$(this).find('.services-overview-overlay').show();},
			  function(){$(this).find('.services-overview-overlay').hide();}
			);
		 
		 $("#services-overview li").click(function(){
			 window.location=$(this).find("a").attr("href");
			 return false;
		});
		 
		// -------------------------------------------------------------------------------------------------------
		// Contact Form 
		// -------------------------------------------------------------------------------------------------------
		
		$("#contact-form").submit(function () {
											
			if (validateMyAjaxInputs()) { //  procced only if form has been validated ok with validity
				var str = $(this).serialize();
				$.ajax({
					type: "POST",
					url: themePath+"/_layout/php/send.php",
					data: str,
					success: function (msg) {
						$("#formstatus").ajaxComplete(function (event, request, settings) {
							if (msg == 'OK') { // Message Sent? Show the 'Thank You' message
								result = '<div class="successmsg">Your message has been sent. Thank you!</div>';
								$('#contact-form').clearForm();
							} else {
								result = msg;
							}
							$(this).html(result);
						});
					}
		
				});
				return false;
			}
		});
		
		// Protfolio Fade 
		// -------------------------------------------------------------------------------------------------------
		
		if ($.browser.msie && $.browser.version < 7) return;

			$(".portfolio-item-preview img").fadeTo(1, 1);
			$(".portfolio-item-preview img").hover(
			
			function () {
				$(this).fadeTo("fast", 0.80);
			}, function () {
				$(this).fadeTo("slow", 1);
			});

			
		
		// -------------------------------------------------------------------------------------------------------
		// Protfolio Fade 
		// -------------------------------------------------------------------------------------------------------
		// -------------------------------------------------------------------------------------------------------
		
		$('.subscribe-submit-btn').click(function(){
			var mail = $('#subscribe-email').attr('value');
			
			if (mail == msg_newsletter_label) { 
				$('#subscribe-email').attr(msg_newsletter_error);
				return false;
			}
			
			if (mail == msg_newsletter_error) { 
				return false;
			}
			
			if (isValidEmailAddress(mail)){

				$.post(themePath+'/_layout/php/subscribe.php', {subscribe: mail},
				function(data){ 
					if (data.success == '1'){
						$('#subscribe-email').attr('value',data.message);
					}else{
						if (data.err == '100'){
							$('#subscribe-email').attr('value',data.message);
						}
						
						if (data.err == '101'){
							$('#subscribe-email').attr('value',data.message);
						}
					}
				});
				
			}else{
				$('#subscribe-email').attr('value', msg_newsletter_error);
			}
			
			return false;
		});
			
			
			
			
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	});
	
})(window.jQuery);	

	//Function for e-mail validation on newsletter field
	function isValidEmailAddress(emailAddress) {
		var pattern = new RegExp(/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/);
		return pattern.test(emailAddress);
	}

// non jQuery scripts below