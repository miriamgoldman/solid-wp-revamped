<?php

	//add_theme_support( 'post-thumbnails', array( 'project'));
		
	add_shortcode("projects-columns"	, "ewf_projects_sc_columns");
	add_shortcode("projects-detailed"	, "ewf_projects_sc_detailed");
	add_shortcode("projects-related"	, "ewf_projects_sc_related");
	add_shortcode("projects-filter"		, "ewf_projects_sc_filter");
	
	add_action('init'		, 'ewf_register_type_project');
	add_action('init'		, 'ewf_register_project_taxonomies', 0 );  
	add_action('admin_menu'	, 'ewf_projects_meta_install');
	add_action('save_post'	, 'ewf_projects_meta_update');
	
	add_image_size( 'project-preview-small', 220, 140, true);
	add_image_size( 'project-preview-large', 460, 180, true);
	
	 
	function ewf_projects_meta_install() {
		 add_meta_box( 'ewf_projects_meta',__('Projects settings', EWF_SETUP_THEME_DOMAIN), 'ewf_projects_meta_source', 'project', 'normal', 'high' );
	}

	function ewf_projects_meta_update() {
		global $post;
		update_post_meta($post->ID, "project_date_interval", $_POST["project_date_interval"]);
	}
 
	function ewf_projects_meta_source() { 
			global $post;
			
			$custom = get_post_custom($post->ID);
		
			$project_interval = $custom["project_date_interval"][0];
			
			echo '
			<div style="padding-top:10px;">
				<label style="display:block;padding:2px;">'.__('Date interval', EWF_SETUP_THEME_DOMAIN).': </label><input style="width:220px;" name="project_date_interval" value="'.$project_interval.'">
			</div>';
	}
	
	
	function ewf_projects_sc_filter($atts, $content){
		extract(shortcode_atts(array(
			"url" => null,
			"title" => null,
			"full" => 0
		), $atts));
		
		if ($full == 0){ 
			$full = get_option(EWF_SETUP_THNAME."_page_portfolio", 0); 
			
			$page_portfolio_title = get_option(EWF_SETUP_THNAME."_page_portfolio", null );
			$page_portfolio = get_page_by_title( $page_portfolio_title );
			
			if (is_object($page_portfolio)){
				$full = $page_portfolio->ID;
				} 
		}

		if ($full) { 
			$full_page = get_post($full); 
			
			apply_filters('debug', 'Portfolio ID: '.$full);
				
			if ($url == null) { $url = get_permalink($full_page->ID); }
			if ($title == null) { $title = $full_page->post_title; } 
		}		
		
		$terms = get_terms ('service');
		$src = null;

		$current_url = strtolower($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		$current_url = str_replace(array('http://', 'https://', 'page/2/', 'page/3/', 'page/4/', 'page/5/', 'page/6/', 'page/7/', 'page/8/', 'page/9/', 'page/10/', 'page/11/', 'page/12/', 'page/13/', 'page/14/', 'page/15/' ),'',strtolower($current_url));
		
		$src .= '<ul class="side-nav">'; 
			if ($full) { 
				$full_url = str_replace(array('http://', 'https://'),'',strtolower($url));
		
				$extra = null;
				if ($current_url==$full_url){ $extra = "class='current' "; }
				
				$src .= '<li '.$extra.'><a href="'.$url.'">'.$title.'</a></li>';
		}

			foreach($terms as $key => $service){
				$item_permalink = get_term_link($service->slug, 'service');
				$item_url = str_replace(array('http://', 'https://'),'',strtolower($item_permalink));
				
				$extra = null;
				if ($current_url==$item_url){ $extra = "class='current' "; }
		
				$src .= '<li '.$extra.'><a href="'.$item_permalink.'">'.$service->name.'</a></li>';
			}
		$src .= '</ul>';
		
		return $src;
	}
	function ewf_projects_sc_detailed($atts, $content){
		global $paged, $post;
		
		extract(shortcode_atts(array(
			"items" => 4,
			"nav" => "true",
			"order" => "asc",
			"service" => null
		), $atts));
		
		
		$paged = get_query_var('paged') ? get_query_var('paged') : 1;
		$query = array( 'post_type' => 'project', 'posts_per_page' => $items, 'paged' => $paged, 'order'=>$order, 'orderby'=>'ID' );
		
		if ($service != null){
			$query['tax_query'] = array(
				array(
					'taxonomy' => 'service',
					'field' => 'slug',
					'terms' => array( $service )
				));
		}
			
		$wp_query_project = new WP_Query($query);
		
		$items_src = null;
		$items_count = 0;
		
		while ($wp_query_project->have_posts()) : $wp_query_project->the_post();
			$items_count++;
			$image_id = get_post_thumbnail_id();  
			
			$image_small_preview = wp_get_attachment_image_src($image_id,'project-preview-large');  
			$image_large = wp_get_attachment_image_src($image_id,'large');  
			
			$items_src .= '<div class="portfolio-item row fixed">
				<div class="col-460">';
				
			if ($image_id){
				$items_src.= '<a href="'.$image_large[0].'" class="portfolio-item-preview" rel="prettyPhoto" title="'.get_the_excerpt().'"><img src="'.$image_small_preview[0].'" width="460" height="180" alt="'.get_the_title().'" /></a>';
			}else{
				$items_src.=  ewf_message(__('There is no featured image, please add one!', EWF_SETUP_THEME_DOMAIN));
			}
					
			$items_src.= '</div>
				<div class="col-220 last">
					<h3 class="project-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h3>
					<p>'.get_the_excerpt().'</p>
					<p><a href="'.get_permalink().'">'.__('Read More',EWF_SETUP_THEME_DOMAIN).'</a></p>';
				
				$items_src.= '</div>
			</div>';
			
			if ($wp_query_project->post_count > $items_count){
				$items_src.= '<div class="hr"></div>';
			}
			
			if ($wp_query_project->post_count == $items_count && $nav == "true"){
				$items_src.= '<div class="hr"></div>';
			}
			
		endwhile;
		
		wp_reset_query();
		
		if ($nav == "true"){
			$items_src .= ewf_projects_pagination($items, $wp_query_project);
		}
		
		return $items_src;
	}	
	
	
	function ewf_projects_sc_related ($atts, $content){	
		extract(shortcode_atts(array(
			"items" => 1,
			"exclude" => null,
			"order" => "asc",
			"id" => null,
			"service" => null,
		), $atts));
		
		global $post;
		$current_post = $post->ID;
		$include_posts = array();
		
		
		$items_count = 0;
		$items_row = 0;
		$items_src = null;
			
		$query = array( 'post_type' => 'project', 'order'=> $order, 'orderby' => 'ID',  'posts_per_page'=>$items, 'tax_query' => array(  array('taxonomy' => 'service', 'field' => 'slug', 'terms' => array( $service ))) );
	
		if ($exclude != null){
			if (is_numeric($id)){
				// if we have only one ID
				$exclude_items[] = $id ;
			}else{
				//If there are more ids separated by comma
				$tmp_id = explode(',', trim($id));
				foreach($tmp_id as $key => $item_id){
					if (is_numeric($item_id)){
						$exclude_items[] = $item_id ;
					}
				}
			}
			
			$exclude_items[] = $current_post;
			$query['post__not_in'] = $exclude_items;
		}else{
			$query['post__not_in'] = array($current_post);
		}
		
	
		if ($id != null){
			if (is_numeric($id)){
				// if we have only one ID
				$include_posts[] = $id ;
			}else{
				//If there are more ids separated by comma
				$tmp_id = explode(',', trim($id));
				foreach($tmp_id as $key => $item_id){
					if (is_numeric($item_id)){
						$include_posts[] = $item_id ;
					}
				}
			}
			
			unset($query['post__not_in']);
			unset($query['tax_query']);
			
			$query['post__in'] = $include_posts;
			$query['posts_per_page'] = count($include_posts);
		}
		
		$wp_query_project = new WP_Query($query);
		
		while ($wp_query_project->have_posts()) : $wp_query_project->the_post();
			global $post;
			
			$items_count++;
			$items_row++; 
			
			$extra_class = null;
			
			$image_id = get_post_thumbnail_id();  
			$image_small_preview = wp_get_attachment_image_src($image_id,'project-preview-small');  
			$image_large = wp_get_attachment_image_src($image_id,'large');  
			
			if ($items_row == 4){ $extra_class = "last"; }
			if ($items_row == 1){ $items_src .= '<div class="row fixed">'; }
						
			$items_src .='<div class="portfolio-item col-220 '.$extra_class.'">
				<p>
					<a href="'.$image_large[0].'" class="portfolio-item-preview" rel="prettyPhoto[projects]" title="'.get_the_excerpt().'">
						<img src="'.$image_small_preview[0].'" width="220" height="120" alt="'.get_the_title().'" />
					</a>
				</p>
				<h4><a href="'.get_permalink().'">'.get_the_title().'</a></h4>
				<p>'.get_the_excerpt().'</p></div>'; 
			
			if ($items_row == 4){ 
				$items_row = 0; 
				$items_src .= '</div>'; 
			}else { 
				if ($wp_query_project->post_count == $items_count){ $items_src .= '</div><!--forced row end-->'; }
			}
		
		
		
		endwhile;
		
		
		return $items_src;
	}
	
	function ewf_projects_sc_columns($atts, $content){	
		extract(shortcode_atts(array(
			"items" => 6,
			"id" => null,
			"nav" => false,
			"order" => "asc",
			"link" => false,
			"title" => __("view more work", EWF_SETUP_THEME_DOMAIN),
			"url" => "#",
			"service" => null,
		), $atts));
		
		
		$order = strtoupper($order);
		
		$items_count = 0;
		$row_count = 0;
		$items_row = 0;
		$items_src = null;
		
		$paged = get_query_var('paged') ? get_query_var('paged') : 1;
		
		if ($id == null){
			$query = array( 'post_type' => 'project', 'orderby'=> 'ID', 'order' => $order, 'posts_per_page' => $items, 'paged' => $paged );
		
			if ($service != null){
				$query['tax_query'] = array(
					array(
						'taxonomy' => 'service',
						'field' => 'slug',
						'terms' => array( $service )
					));
			}
			
			$wp_query_project = new WP_Query($query);
		}else{	
			$select_items = array();
			
			if (is_numeric($id)){
				// if we have only one ID
				$select_items[] = $id ;
			}else{
				//If there are more ids separated by comma
				$tmp_id = explode(',', trim($id));
				foreach($tmp_id as $key => $item_id){
					if (is_numeric($item_id)){
						$select_items[] = $item_id ;
					}
				}
			}
			
			$items = count($select_items);
			$wp_query_project = new WP_Query(array( 'post_type' => 'project', 'posts_per_page'=>$items, 'post__in' => $select_items, 'order'=> $order, 'orderby'=> 'id'));
		}
			
				while ($wp_query_project->have_posts()) : $wp_query_project->the_post();
					global $post;
					
					$items_count++;
					$items_row++; 
					
					$extra_class = null;
					
					$image_id = get_post_thumbnail_id();  
					$image_small_preview = wp_get_attachment_image_src($image_id,'project-preview-small');  
					$image_large = wp_get_attachment_image_src($image_id,'large');  
					
					if ($items_row == 3){ $extra_class = "last"; $row_count ++; }
					if ($items_row == 1){ 
						if ($row_count > 0) { $items_src .= '<div class="hr"></div>'; }
						$items_src .= '<div class="row fixed">'; 
						
					}
								
					$items_src .='<div class="portfolio-item col-220 '.$extra_class.'">';
					
					if ($image_id){
						$items_src .= '<p><a href="'.$image_large[0].'" class="portfolio-item-preview" rel="prettyPhoto[projects]" title="'.get_the_excerpt().'"><img src="'.$image_small_preview[0].'" width="220" height="140" alt="'.get_the_title().'" /></a></p>';
					}else{
						$items_src.= ewf_message(__('There is no featured image, please add one!', EWF_SETUP_THEME_DOMAIN));
					}
						
					$items_src .='<h3><a href="'.get_permalink().'">'.get_the_title().'</a></h3>
						<p>'.get_the_excerpt().'</p>';
						
					$items_src .= '<p><a href="'.get_permalink().'">'.__('Read More', EWF_SETUP_THEME_DOMAIN).'</a></p></div>';
					
					if ($items_row == 3){ 
						$items_row = 0; 
						$items_src .= '</div>'; 
					}else { 
						if ($wp_query_project->post_count == $items_count){ $items_src .= '</div>'; }
					}
				
				endwhile;
				
				wp_reset_query();
				
				if ($nav == "true"){
					$items_src .= '<div class="hr"></div>';
					$items_src .= '<div class="fixed">'.ewf_projects_pagination($items, $wp_query_project).'</div>';
				}

		
		if ($link){
			$items_src .= '<div class="fixed"><a href="'.$url.'">'.$title.'</a></div>';
		}
		
		return $items_src;
	}

	function ewf_register_type_project() {
		register_post_type('project', 
		
			array(
			'labels' => array(
				'name' 					=> __( 'Projects'					,EWF_SETUP_THEME_DOMAIN ),
				'singular_name' 		=> __( 'Project'					,EWF_SETUP_THEME_DOMAIN ),
				'add_new' 				=> __( 'Add New'					,EWF_SETUP_THEME_DOMAIN ),
				'add_new_item' 			=> __( 'Add New Project'			,EWF_SETUP_THEME_DOMAIN ),
				'edit' 					=> __( 'Edit'						,EWF_SETUP_THEME_DOMAIN ),
				'edit_item' 			=> __( 'Edit Project'				,EWF_SETUP_THEME_DOMAIN ),
				'new_item' 				=> __( 'New Project'				,EWF_SETUP_THEME_DOMAIN ),
				'view' 					=> __( 'View Project'				,EWF_SETUP_THEME_DOMAIN ),
				'view_item' 			=> __( 'View Project'				,EWF_SETUP_THEME_DOMAIN ),
				'search_items' 			=> __( 'Search Projects'			,EWF_SETUP_THEME_DOMAIN ),
				'not_found' 			=> __( 'No projects found'			,EWF_SETUP_THEME_DOMAIN ),
				'not_found_in_trash' 	=> __( 'No projects found in Trash'	,EWF_SETUP_THEME_DOMAIN ),
				'parent' 				=> __( 'Parent project'				,EWF_SETUP_THEME_DOMAIN ),
				),
			'public' 	=> true,
			'rewrite' 	=> true, 
			'slug'		=> 'project',
			'show_ui' 	=> true,
			'supports' 	=> array('title', 'editor', 'thumbnail', 'excerpt')
			));
	}
	
	function ewf_register_project_taxonomies() {
		register_taxonomy( 'service', 'project', 
			array( 'hierarchical' => true, 
						   'slug' => 'service',
						  'label' => __('Services', EWF_SETUP_THEME_DOMAIN), 
					  'query_var' => true,
						'rewrite' => true ));  
	}

	function ewf_projects_pagination($range = 4, $query){
		$src_nav = null;

		$class_current = 'current';
		$current_page = $query->query_vars['paged'];
		$max_page = 0;

	  // How much pages do we have?
	  if ( !$max_page ) {
		$max_page = $query->max_num_pages;
	  }
	
	  $src_nav .= '<ul class="pagination fixed">';
	
	  // We need the pagination only if there are more than 1 page
	  if($max_page > 1){
	  
		$src_nav .= '<li><strong>'.__('Page ', EWF_SETUP_THEME_DOMAIN).$current_page.' of '.$max_page.'</strong></li>';
	  
		if(!$current_page){
		  $current_page = 1;
		}
		// On the first page, don't put the First page link
		//if($current_page != 1){
		 // $src_nav.= "<li><a href=" . get_pagenum_link(1) . "> First </a></li>";
		//}
		
		// We need the sliding effect only if there are more pages than is the sliding range
		if($max_page > $range){
		  // When closer to the beginning
		  if($current_page < $range){
			for($i = 1; $i <= ($range + 1); $i++){
			  
			  $src_nav.= "<li ";
			  if($i==$current_page) $src_nav.= "class='".$class_current."'";
			  
			  $src_nav.= "><a href='" . get_pagenum_link($i) ."'";
			  $src_nav.= ">$i</a></li>";
			}
		  }
		  // When closer to the end
		  elseif($current_page >= ($max_page - ceil(($range/2)))){
			for($i = $max_page - $range; $i <= $max_page; $i++){
			  $src_nav.= "<li ";
			  
			  if($i==$current_page) $src_nav.= "class='".$class_current."'";
			  
			  $src_nav.= "><a href='" . get_pagenum_link($i) ."'";
			  $src_nav.= ">$i</a></li>";
			}
		  }
		  // Somewhere in the middle
		  elseif($current_page >= $range && $current_page < ($max_page - ceil(($range/2)))){
			for($i = ($current_page - ceil($range/2)); $i <= ($current_page + ceil(($range/2))); $i++){
			  $src_nav.= "<li ";
			  
			  if($i==$current_page) $src_nav.= "class='".$class_current."'";
			  
			  $src_nav.= "><a href='" . get_pagenum_link($i) ."'";
			  $src_nav.= ">$i</a></li>";
			}
		  }
		}
		// Less pages than the range, no sliding effect needed
		else{
		  for($i = 1; $i <= $max_page; $i++){
			$src_nav.= "<li ";
			
			if($i==$current_page) $src_nav.= "class='".$class_current."'";
			
			$src_nav.= "><a href='" . get_pagenum_link($i) ."'";
			$src_nav.= ">$i</a></li>";
		  }
		}
	  }
	  
	  $src_nav .= '</ul>';
	  
	  
	  return $src_nav;
	}
	
?>