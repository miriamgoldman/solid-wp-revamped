<?php
	define ('EWF_LAYOUT_SIDEBARS', true);
	define ('EWF_LAYOUT_FOOTER', false);


	add_action('admin_menu', 'ewf_layoutMetaBox');
	add_action('admin_menu', 'ewf_removeMetaCustomFields' );
	
	add_action('save_post', 'ewf_layoutSidebarsMetaBoxSettingsUpdate');
	add_action('save_post', 'ewf_layoutFooterMetaBoxSettingsUpdate');
	
	
	function ewf_removeMetaCustomFields() {
		if (EWF_LAYOUT_SIDEBARS){
			remove_meta_box( 'postcustom', 'page', 'normal' ); 
			}
		
		if (EWF_LAYOUT_FOOTER){
			
			}
	}
	
	function ewf_layoutMetaBox() {
		
		if (EWF_LAYOUT_SIDEBARS){
			add_meta_box( 'ewf-layout-sidebars-setup',__('Sidebar Layout Settings',EWF_SETUP_THEME_DOMAIN), 'ewf_layoutSidebarsMetaBoxCode', 'page', 'normal', 'high');
			}
			
		if (EWF_LAYOUT_FOOTER){
			add_meta_box( 'ewf-layout-footer-setup',__('Footer Layout Settings',EWF_SETUP_THEME_DOMAIN), 'ewf_layoutFooterMetaBoxCode', 'page', 'normal', 'high');
			}
	}

	function ewf_layoutSidebarsMetaBoxCode() {
			global $post;
			
			$layouts = array(
				array(
					'icon' => 'layout-sidebar-single-left.png',
					'name' => 'layout-sidebar-single-left'
				),
				array(
					'icon' => 'layout-full.png',
					'name' => 'layout-full'
				),
				array(
					'icon' => 'layout-sidebar-single-right.png',
					'name' => 'layout-sidebar-single-right'
				),
				/*
				array(
					'icon' => 'layout-sidebar-double.png',
					'name' => 'layout-sidebar-double'
				),
				*/
			);
			
			$layout_default = 'layout-sidebar-single-left';
			
			$ewf_page_layout = null;
			$custom = get_post_custom($post->ID);
			
			// Check if there is a setup layout
			if (array_key_exists('_ewf-page-layout',$custom)){
				$ewf_page_layout = $custom["_ewf-page-layout"][0];
			}else{
				$ewf_page_layout = $layout_default;
			}
			
			echo '<div class="clearfix">';
				foreach($layouts as $key=>$layout){
					$class = null;
					
					if ($ewf_page_layout==$layout['name']){ $class=" active"; }else{ $class=null; }
				
					echo '<div style="background:url('.get_bloginfo('template_directory').'/_admin/images/'.$layout['icon'].') no-repeat;" class="ewf-page-layout'.$class.'"  id="'.$layout['name'].'" ></div>';
				}
			echo '</div>';
			
			echo '<input type="hidden" id="ewf-page-layout" name="ewf-page-layout" value="'.$ewf_page_layout.'" />';
	}
	
	function ewf_layoutFooterMetaBoxCode() {
			global $post;
			
			$layouts = array(
				array(
					'icon' => 'layout-footer-three-equal.png',
					'name' => 'layout-footer-three-equal'
				),
				array(
					'icon' => 'layout-footer-three-unequal.png',
					'name' => 'layout-footer-three-unequal'
				),
				array(
					'icon' => 'layout-footer-four.png',
					'name' => 'layout-footer-four'
				),
				array(
					'icon' => 'layout-footer-double-equal.png',
					'name' => 'layout-footer-double'
				),

			);
			
			$ewf_footer_layout = null;
			$custom = get_post_custom($post->ID);
			
			// Check if there is a setup for footer layout
			if (array_key_exists('_ewf-footer-layout',$custom)){
				$ewf_footer_layout = $custom["_ewf-footer-layout"][0];
				}
			
			echo '<div class="clearfix">';
				foreach($layouts as $key=>$layout){
					$class = null;
					
					if ($ewf_footer_layout==$layout['name']){ $class=" active"; }else{ $class=null; }
				
					echo '<div style="background:url('.get_bloginfo('template_directory').'/_admin/images/'.$layout['icon'].') no-repeat;" class="ewf-footer-layout'.$class.'"  id="'.$layout['name'].'" ></div>';
				}
			echo '</div>';
			
			echo '<input type="hidden" id="ewf-footer-layout" name="ewf-footer-layout" value="'.$EWF_footer_layout.'" />';
	}

	function ewf_layoutSidebarsMetaBoxSettingsUpdate() {
		global $post;
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post->ID;
		}
		
		update_post_meta($post->ID, "_ewf-page-layout", $_POST["ewf-page-layout"]);
	}
	
	function ewf_layoutFooterMetaBoxSettingsUpdate() {
		global $post;
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post->ID;
		}
		
		update_post_meta($post->ID, "_ewf-footer-layout", $_POST["ewf-footer-layout"]);
	}
	
	function ewf_get_sidebar_layout($default = "layout-full"){
		global $post;
		$item_meta = get_post_custom($post->ID);	// get the item custom variables
		
		if (array_key_exists('_ewf-page-layout',$item_meta)){
			$layout = $item_meta["_ewf-page-layout"][0];
			
			if ($layout!=null) { 
				$default = $layout; 
			}			
		}
			
		return $default;	
	}
	
	function ewf_get_footer_layout($default = "layout-footer-four"){
		global $post;
		$item_meta = get_post_custom($post->ID);	// get the item custom variables
		
		if (is_array($item_meta) && array_key_exists('_ewf-footer-layout',$item_meta)){
			$layout = $item_meta["_ewf-footer-layout"][0];
			
			if ($layout!=null) { 
				$default = $layout; 
			}			
		}
			
		return $default;
	}
	
	?>