<?php

	add_action('init', 'ewf_register_type_news');
	
	add_shortcode("news-overview"	, "ewf_news_sc_overview");
	add_shortcode("news-recent"	, "ewf_news_sc_recent");
	
	function ewf_news_sc_recent($atts, $content){
		global $paged, $post;
		
		extract(shortcode_atts(array(
			"items" => 4,
			"order" => "desc", 
			"title" => __('news archive', EWF_SETUP_THEME_DOMAIN),
			"url" => null
		), $atts));
		
		$src = null;
		
		$query = array( 'post_type' => 'news', 'posts_per_page' => $items, 'order'=>$order, 'orderby'=>'ID' );

		$wp_query_news = new WP_Query($query);

		$src .= '<ul id="news-box">';
		
		$count_items = 0;
		
		while ($wp_query_news->have_posts()) : $wp_query_news->the_post();
			$extra_class = null;
			
			if ($count_items == 0) { $extra_class = ' class="first" '; }
			
			if ($count_items+1 == $wp_query_news->post_count && $url == null) { $extra_class = ' class="last" '; }
			
			$src .= '<li '.$extra_class.'><a href="'.get_permalink().'">'.get_the_title().'</a>';
			$src .= '<p class="date">'.get_the_time('F jS, Y').'</p></li>';
			
			if ($url != null && $count_items+1 == $wp_query_news->post_count){
				$src .= '<li class="last" ><a href="'.$url.'">'.$title.'</a></li>';
				}
			
			$count_items++;
		endwhile;
		
		$src .= '</ul>';
		
		wp_reset_query();
		
		return $src;
	}
	
	function ewf_news_sc_overview($atts, $content){
		global $paged, $post;
		
		extract(shortcode_atts(array(
			"items" => 2,
			"nav" => true,
			"order" => "asc"
		), $atts));
		
		$src = null;
		
		$paged = get_query_var('paged') ? get_query_var('paged') : 1;
		$query = array( 'post_type' => 'news', 'posts_per_page' => $items, 'paged' => $paged, 'order'=>$order, 'orderby'=>'ID' );

		$wp_query_news = new WP_Query($query);

		$count_items = 0;
		while ($wp_query_news->have_posts()) : $wp_query_news->the_post();
			
			if ($count_items){
				$src .= '<div class="hr"></div>';
				}
			
			$src .= '<div class="news fixed">';
				$src .= '<p class="date">'.get_the_time('F jS, Y').'</p>';
				$src .= '<h3><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
				$src .= get_the_content(__('Read More', EWF_SETUP_THEME_DOMAIN));
			$src .= '</div>';

			$count_items++;
		endwhile;
		
		wp_reset_query();
		
		if ($nav){
			$src .= ewf_news_pagination($items, $wp_query_news);
		}
		
		return $src;
	}
	
	
	function ewf_register_type_news() {
		register_post_type('news', 
		
			array(
			'labels' => array(
				'name' 					=> __( 'News'						,EWF_SETUP_THEME_DOMAIN ),
				'singular_name' 		=> __( 'News'						,EWF_SETUP_THEME_DOMAIN ),
				'add_new' 				=> __( 'Add New'					,EWF_SETUP_THEME_DOMAIN ),
				'add_new_item' 			=> __( 'Add New Article'			,EWF_SETUP_THEME_DOMAIN ),
				'edit' 					=> __( 'Edit'						,EWF_SETUP_THEME_DOMAIN ),
				'edit_item' 			=> __( 'Edit Article'				,EWF_SETUP_THEME_DOMAIN ),
				'new_item' 				=> __( 'New Article'				,EWF_SETUP_THEME_DOMAIN ),
				'view' 					=> __( 'View Article'				,EWF_SETUP_THEME_DOMAIN ),
				'view_item' 			=> __( 'View Article'				,EWF_SETUP_THEME_DOMAIN ),
				'search_items' 			=> __( 'Search Articles'			,EWF_SETUP_THEME_DOMAIN ),
				'not_found' 			=> __( 'No articles found'			,EWF_SETUP_THEME_DOMAIN ),
				'not_found_in_trash' 	=> __( 'No articles found in Trash'	,EWF_SETUP_THEME_DOMAIN ),
				'parent' 				=> __( 'Parent articles'			,EWF_SETUP_THEME_DOMAIN ),
				),
			'public' 	=> true,
			'rewrite' 	=> true, 
			'slug'		=> 'news',
			'show_ui' 	=> true,
			'supports' 	=> array('title', 'thumbnail', 'editor', 'excerpt', 'comments') 
			));
	} 
	

	function ewf_news_pagination($range = 4, $query){
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