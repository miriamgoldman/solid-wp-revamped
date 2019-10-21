
	//** on DOM loaded
	jQuery(function() {
	
		jQuery('.panel .controls').click(function(){
			var panelBody = $(this).closest('.panel');
			var panelContent = $('.panel-content', panelBody);
			
			
			if (jQuery(this).hasClass('down')){
				jQuery(panelContent).slideDown();
				jQuery(this).removeClass('down');
			}else{
				jQuery(panelContent).slideUp();
				jQuery(this).addClass('down');
			}	
		});		
		
		var fullPanel = jQuery('.full-panel');
		
		jQuery('.tabs li', fullPanel).click(function (){
			var tabID = jQuery(this).attr('id');
			
			jQuery('.tabs li.current', fullPanel).removeClass('current');
			jQuery(this).addClass('current');
			
			jQuery('.panel:not(.'+tabID+')', fullPanel).css('display','none');
			jQuery('.panel.'+tabID, fullPanel).css('display','block');
		});
		
		jQuery('.ewf-post-image').hover(function(){
			jQuery('div', this).stop(true,true).fadeIn('slow');
		}, function(){
			jQuery('div', this).stop(true,true).fadeOut('slow');
		});
		
		jQuery('.ewf-post-image img').live('click', function() {	
			var widget = jQuery(this).closest('.widget-content');
			var img_id = jQuery(this).attr('alt');
			
			jQuery('.img-id', widget).attr('value',img_id);
			jQuery('.widget-article-post-imgs', widget).fadeOut('slow');
			
			//alert("Img ID: "+img_id);
		});		
		
		jQuery('.ewf-page-header').live('click', function() {	
			var img_id = jQuery(this).attr('alt');
				
			jQuery('.ewf-page-header').removeClass('current');
			jQuery(this).addClass('current');
			
			jQuery('#ewf-page-header-id').attr('value',img_id).addClass('current');
		});
		
		
		
		
		
		
		
		
		
		
		//*** layout sidebar code
		jQuery('.ewf-page-layout').click(function(){
			var layout = jQuery(this).attr('id');
			
			jQuery('#ewf-page-layout').attr('value', layout);	
			
			jQuery('.ewf-page-layout.active').removeClass('active');
			jQuery(this).addClass('active');
		});
		
		//*** layout footer code
		jQuery('.ewf-footer-layout').click(function(){
			var layout = jQuery(this).attr('id');
			
			jQuery('#ewf-footer-layout').attr('value', layout);	
			
			jQuery('.ewf-footer-layout.active').removeClass('active');
			jQuery(this).addClass('active');
		});
		
		
		
	});