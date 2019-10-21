<?php
	add_theme_support('automatic-feed-links');
	add_theme_support( 'post-thumbnails', array( 'post', 'page', 'slide', 'project', 'news' ) );
	
	add_post_type_support('page', 'excerpt');

	set_post_thumbnail_size( 50, 50, true );

	add_image_size( 'service-thumb', 180, 100, true);
	
	add_image_size( 'column-160-auto', 160, 9999);
	add_image_size( 'column-160', 160, 100, true);

	add_image_size( 'column-220-auto', 220, 9999);
	add_image_size( 'column-220', 220, 150, true);

	add_image_size( 'column-340-auto', 340, 9999);
	add_image_size( 'column-340', 340, 150, true);

	add_image_size( 'column-460-auto', 460, 9999);
	add_image_size( 'column-460', 460, 150, true);

	add_image_size( 'column-700-auto', 700, 9999);
	add_image_size( 'column-700', 700, 150, true);

	add_image_size( 'column-900-auto', 900, 9999);
	add_image_size( 'column-900', 900, 150, true);

	add_action('init', 'loadSetupReference'); 
	 
	 
	if ( ! isset( $content_width ) ) $content_width = 940;
	
	function loadSetupReference(){
		if (is_admin()){
		
			wp_enqueue_script('setup-js', get_template_directory_uri().'/_admin/js/custom-setup.js');    		
			wp_enqueue_style('setup-css', get_template_directory_uri().'/_admin/css/options-panel.css');
			
		}else{
		
			wp_enqueue_style('theme-style', get_template_directory_uri().'/style.css');
			wp_enqueue_style('theme-skin', get_template_directory_uri().'/_skins/'.ewf_current_skin());
			wp_enqueue_style('theme-style-print', get_template_directory_uri().'/style-print.css', array(), '1.0', 'print');
		
			wp_deregister_script('jquery');
			wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js', false, '1.5', true);
			wp_enqueue_script('jquery');
			
			//**  Cufon - font Replacement
			if (get_option( EWF_SETUP_THNAME.'_cufon', 'true')=='true'){
				wp_enqueue_script('plugin-cufon', get_template_directory_uri().'/_layout/js/cufon/cufon.js', array('jquery'),'1.0', true );
				wp_enqueue_script('cufon-font-museo', get_template_directory_uri().'/_layout/js/cufon/cufon-font.js', array('plugin-cufon'),'1.0', true );
			}
			
			//**  Tipsy - tooltips
			wp_enqueue_script('plugin-tipsy', get_template_directory_uri().'/_layout/js/tipsy/jquery.tipsy.js', array('jquery'),'1.0', true );    		
			wp_enqueue_style('plugin-tipsy-css', get_template_directory_uri().'/_layout/js/tipsy/css.tipsy.css');
			
			//**  prettyPhoto - lightbox
			wp_enqueue_script('plugin-prettyPhoto', get_template_directory_uri().'/_layout/js/prettyphoto/jquery.prettyPhoto.js', array('jquery'),'1.0', true );    		
			wp_enqueue_style('plugin-prettyPhoto-css', get_template_directory_uri().'/_layout/js/prettyphoto/css.prettyPhoto.css');
			
			//**  Validity - form validation
			wp_enqueue_script('plugin-validity', get_template_directory_uri().'/_layout/js/validity/jquery.validity.js', array('jquery'),'1.0', true );    		
			wp_enqueue_style('plugin-validity-css', get_template_directory_uri().'/_layout/js/validity/css.validity.css');			
			
			//**  Cycle - content slider
			wp_enqueue_script('plugin-cycle', get_template_directory_uri().'/_layout/js/cycle/jquery.cycle.all.min.js', array('jquery'),'1.0', true );    		
			
			//**  Tabify - create tabs
			wp_enqueue_script('plugin-tabify', get_template_directory_uri().'/_layout/js/tabify/jquery.tabify-1.4.js', array('jquery'),'1.0', true );    		
			
			//**  Accordion - create accordions
			wp_enqueue_script('plugin-acordion', get_template_directory_uri().'/_layout/js/accordion/jquery.accordion.js', array('jquery'),'1.0', true );    		
			
			//**  GMap - for google maps
			$gmaps_api_key = get_option(EWF_SETUP_THNAME."_maps_api_key");
			if ( $gmaps_api_key != null){
				wp_enqueue_script('plugin-gmap-api','http://maps.google.com/maps?file=api&amp;v=2&amp;key='.$gmaps_api_key, array('jquery'),'1.0', true );    		
				wp_enqueue_script('plugin-gmap', get_template_directory_uri().'/_layout/js/gmap/jquery.gmap-1.1.0-min.js', array('jquery'),'1.0', true );    		
			}
			
			//**  ScrollTo - scroll overflowed elements
			//wp_enqueue_script('plugin-localscroll', get_template_directory_uri().'/_layout/js/scrollto/jquery.localscroll-min.js', array('jquery'),'1.0', true );    		
			//wp_enqueue_script('plugin-scrollto', get_template_directory_uri().'/_layout/js/scrollto/jquery.scrollTo-min.js', array('jquery'),'1.0', true );
			
			//**  Custom JS
			wp_enqueue_script('js-scripts', get_template_directory_uri().'/_layout/js/scripts.js', array('jquery'),'1.0', true );    		
			wp_enqueue_script('js-plugins', get_template_directory_uri().'/_layout/js/plugins.js', array('jquery'),'1.0', true );    		
			
			if ( is_singular() ) wp_enqueue_script( "comment-reply" ); 
		
		}
	}


	function ewf_comments( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case '' :
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<div class="fixed">
			<?php echo get_avatar( $comment, 60 ); ?>
			<div class="comment-body">
				<p class="who">
					<strong><?php comment_author();  ?></strong> - <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?> 
					<br /> 
					<span class="date"><?php comment_date(); ?></span>
				</p>
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', SETUP_THEME_DOMAIN ); ?></em>
				<?php endif; ?>
				
				<?php comment_text(); ?>
				
				<?php edit_comment_link( __( 'Edit', SETUP_THEME_DOMAIN ), ' ' );?>
			</div>
			</div>
		<?php
				break;
			case 'pingback'  :
			case 'trackback' :
		?>
		
		<li class="post pingback">
			<p><?php _e( 'Pingback:', SETUP_THEME_DOMAIN ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('Edit', SETUP_THEME_DOMAIN), ' ' ); ?></p>
		<?php
				break;
		endswitch;
	}
	
	
	

	add_action('admin_init', 'ewf_add');	
		
	function ewf_column($cols) {
		$cols['item-id'] = '<span>ID</span>'; 
		return $cols;
	} 

	function ewf_value($column_name, $id) { 
		if ($column_name == 'item-id') echo $id;
	}

	function ewf_return_value($value, $column_name, $id) {
		if ($column_name == 'item-id') $value = $id;
		return $value;
	}

	function ewf_css() {
		echo ' <style type="text/css"> #item-id { width: 50px; }</style>';
	}

	function ewf_add() {
		add_action('admin_head', 'ewf_css');

		add_filter('manage_posts_columns', 'ewf_column');
		add_action('manage_posts_custom_column', 'ewf_value', 10, 2);

		add_filter('manage_pages_columns', 'ewf_column');
		add_action('manage_pages_custom_column', 'ewf_value', 10, 2);

		foreach ( get_taxonomies() as $taxonomy ) {
			add_action("manage_edit-${taxonomy}_columns", 'ewf_column');			
			add_filter("manage_${taxonomy}_custom_column", 'ewf_return_value', 10, 3);
		}
	}

	if (!function_exists('is_post_type')){
		function is_post_type($type = null){
			global $post;
			
			if (get_post_type($post) == strtolower($type)){
				return true;
			}else{
				return false;
			}
		}
	}


?>