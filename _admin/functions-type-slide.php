<?php

	//add_theme_support( 'post-thumbnails', array( 'slide')); 
	
	add_action('init', 'ewf_register_type_slide');
	
	add_action('admin_menu'	, 'ewf_slide_meta_install');
	add_action('save_post'	, 'ewf_slide_meta_update');
	
	add_image_size( 'slider-full', 940, 350, true);
	
	function ewf_register_type_slide() {
		register_post_type('slide', 
		
			array(
			'labels' => array(
				'name' 					=> __( 'Slides'						,EWF_SETUP_THEME_DOMAIN ),
				'singular_name' 		=> __( 'Slide'						,EWF_SETUP_THEME_DOMAIN ),
				'add_new' 				=> __( 'Add New'					,EWF_SETUP_THEME_DOMAIN ),
				'add_new_item' 			=> __( 'Add New Slide'				,EWF_SETUP_THEME_DOMAIN ),
				'edit' 					=> __( 'Edit'						,EWF_SETUP_THEME_DOMAIN ),
				'edit_item' 			=> __( 'Edit Slide'					,EWF_SETUP_THEME_DOMAIN ),
				'new_item' 				=> __( 'New Slide'					,EWF_SETUP_THEME_DOMAIN ),
				'view' 					=> __( 'View Slide'					,EWF_SETUP_THEME_DOMAIN ),
				'view_item' 			=> __( 'View Slide'					,EWF_SETUP_THEME_DOMAIN ),
				'search_items' 			=> __( 'Search Slides'				,EWF_SETUP_THEME_DOMAIN ),
				'not_found' 			=> __( 'No slides found'			,EWF_SETUP_THEME_DOMAIN ),
				'not_found_in_trash' 	=> __( 'No slides found in Trash'	,EWF_SETUP_THEME_DOMAIN ),
				'parent' 				=> __( 'Parent slides'				,EWF_SETUP_THEME_DOMAIN ),
				),
			'public' 	=> true,
			'rewrite' 	=> false, 
			'slug'		=> 'slide',
			'show_ui' 	=> true,
			'supports' 	=> array('title', 'thumbnail', 'excerpt')
			));
	}
	
	function ewf_slide_meta_install() {
		 add_meta_box( 'ewf_slides_meta',__('Slides settings'), 'ewf_slide_meta_source', 'slide', 'normal', 'high' );
	}

	function ewf_slide_meta_update() {
		global $post;
		update_post_meta($post->ID, "slide_url", $_POST["slide_url"]);
		update_post_meta($post->ID, "slide_link_title", $_POST["slide_link_title"]);
	}
 
	function ewf_slide_meta_source() {
			global $post;
			
			$custom = get_post_custom($post->ID);
		
			$slide_url = $custom["slide_url"][0];
			$slide_link_title = $custom["slide_link_title"][0];
			
			if ($slide_link_title == null){
				$slide_link_title = 'more';
				}
			
			echo '
			<div style="padding-top:10px;">
				<label style="display:block;padding:2px;">'.__('Slide URL', EWF_SETUP_THEME_DOMAIN).': </label><input style="width:220px;" name="slide_url" value="'.$slide_url.'">
			</div>
			
			<div style="padding-top:10px;">
				<label style="display:block;padding:2px;">'.__('Link Title', EWF_SETUP_THEME_DOMAIN).': </label><input style="width:220px;" name="slide_link_title" value="'.$slide_link_title.'" />
			</div>';
	}


?>