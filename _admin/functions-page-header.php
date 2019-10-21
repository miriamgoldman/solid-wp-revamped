<?php
	global $post;
	
	add_action('admin_menu', 'ewf_headerMetaBox');
	add_action('save_post', 'ewf_headerMetaBoxCodeUpdate');
	
	add_image_size( 'page-meta-headerImgID', 50, 50, true);
	add_image_size( 'page-header', 940, 220, true);

	function ewf_getHeaderImageID($post_id){
		$ewf_image_id = 0;
		
		$custom = get_post_custom($post_id);
		if (array_key_exists('_ewf-page-header-id',$custom) && $custom["_ewf-page-header-id"][0] != null){
			$ewf_image_id = $custom["_ewf-page-header-id"][0];
		}
		
		return intval($ewf_image_id);
	}
	
	function ewf_headerMetaBox() {
		add_meta_box( 'ewf-header-setup',__('Page header image',EWF_SETUP_THEME_DOMAIN), 'ewf_headerMetaBoxCode', 'page', 'normal', 'high');
	}

	function ewf_headerMetaBoxCode() {
			global $post;
			 
			$custom = get_post_custom($post->ID);
			
			// Check if there is a setup layout
			if (array_key_exists('_ewf-page-header-id',$custom)){
				$ewf_page_header_id = $custom["_ewf-page-header-id"][0];
				
				if ($ewf_page_header_id == null){ $ewf_page_header_id = '0'; }
			}else{
				$ewf_page_header_id= '0';
			}
			
			$arrImages = get_children('post_type=attachment&post_mime_type=image&post_parent='. $post->ID.'&orderby=menu_order&order=ASC' );
			
			if (count($arrImages) > 0){
				$image_id = get_post_thumbnail_id();  
				
				echo '<div class="clearfix">';
						foreach($arrImages as $oImage) {
							if ($oImage->ID != $image_id){
								$cr_image_large_preview = wp_get_attachment_image_src( $oImage->ID, 'page-meta-headerImgID');						
								
								if ($ewf_page_header_id == $oImage->ID){
									echo '<img height="50" class="ewf-page-header current" width="50" alt="'.$oImage->ID.'" src="'.$cr_image_large_preview[0].'">';
								}else{
									echo '<img height="50" class="ewf-page-header" width="50" alt="'.$oImage->ID.'" src="'.$cr_image_large_preview[0].'">';
								}
							}
						}
				echo '</div>';
			}
			
			echo '<input type="hidden" id="ewf-page-header-id" name="ewf-page-header-id" value="'.$ewf_page_header_id.'" />';
	}

	function ewf_headerMetaBoxCodeUpdate() {
		global $post;
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post->ID;
		}
		
		update_post_meta($post->ID, "_ewf-page-header-id", $_POST["ewf-page-header-id"]);
	}
	
	?>