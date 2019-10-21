<?php
	add_filter('widget_text', 'do_shortcode');
	add_action('wp_footer', 'ewf_map_javascript_handler');


	add_shortcode("hr"						, "ewf_sc_hr");				//
	add_shortcode("br"						, "ewf_sc_br");				//
	add_shortcode("map"						, "ewf_sc_map");			//
	add_shortcode("template-url"			, "ewf_sc_url");			//

	add_shortcode("subpages"				, "ewf_sc_childpages");		//
	
	add_shortcode("blog-search"				, "ewf_sc_blog_search");	//
	add_shortcode("blog"					, "ewf_sc_blog");			//
	add_shortcode("form-contact"			, "ewf_sc_form_contact");	//
	
	add_shortcode( "code"					, "ewf_sc_code");			//
	
	add_shortcode( "message"				, "ewf_sc_message");		//
	add_shortcode( "clientlogo"				, "ewf_sc_client_logo");	//
	add_shortcode( "blockquote"				, "ewf_sc_quote");
	add_shortcode( "highlight"				, "ewf_sc_highlight");		//
	add_shortcode( "highlight2"				, "ewf_sc_highlight2");		//
	add_shortcode( "checklist"				, "ewf_sc_checklist");		//
	
	add_shortcode( "links-slide"			, "ewf_sc_links_slide");	//
	add_shortcode( "links"					, "ewf_sc_links");			//
	add_shortcode( "brochure"				, "ewf_sc_brochure");		//
	
	add_shortcode( "lightbox"				, "ewf_sc_lightbox");		//
	
	add_shortcode( "acordion"				, "ewf_sc_acordion");		//
	add_shortcode( "slide"					, "ewf_sc_acordion_slide");	//

	add_shortcode( "tabs"	 				, "ewf_sc_tabs");			//
	add_shortcode( "tab"			 		, "ewf_sc_tabs_tab");		//
	
	add_shortcode( "newsletter"				, "ewf_sc_newsletter");
	
	//add_shortcode( "pre"					, "ewf_sc_pre");
	//add_shortcode( "more"					, "ewf_sc_more");
	//add_shortcode( "h1"		 			, "ewf_sc_h1");
	//add_shortcode( "h2"					, "ewf_sc_h2");
	//add_shortcode( "h3"					, "ewf_sc_h3");
	//add_shortcode( "h4"					, "ewf_sc_h4");
	//add_shortcode( "h5" 					, "ewf_sc_h5");
	
	//add_shortcode( "article"				, "ewf_sc_article");
	
	//add_shortcode( "recent-posts"			, "ewf_sc_recentposts");
	//add_shortcode( "recent-comments"		, "ewf_sc_recentcomments");
	
	//add_shortcode( "prices"				, "ewf_sc_prices");
	//add_shortcode( "raw"					, "ewf_sc_raw");

	//add_shortcode( "clean"				, "ewf_sc_clean");
	//add_shortcode( "pullquote"			, "ewf_sc_pullquote");
	//add_shortcode( "expand"				, "ewf_sc_expand");
	//add_shortcode( "frame"				, "ewf_sc_frame");
	//add_shortcode( "dropcap"				, "ewf_sc_dropcap");
	
	//add_shortcode( "thumbs"				, "ewf_sc_thumbs");
	//add_shortcode( "categs"				, "ewf_sc_categs");
	
	$_ewf_maps_instances = null;
	$_ewf_links_extra_slide_instances = null;
	
	$_ewf_acordion_instances = array('0'=>null);
	$_ewf_acordion_slides_instances = array('0'=>null);
	
	$_ewf_tabs_instances = array('0'=>null);
	
	
	function ewf_sc_tabs_tab ( $atts, $content = null ){
		global $_ewf_tabs_instances;
		
		$current_tab_instance_id =  count($_ewf_tabs_instances)-1;
		$current_tab_id =  count($_ewf_tabs_instances[$current_tab_instance_id]);
		
		extract(shortcode_atts(array(
			"current" => false,
			"title" => "Tab ".$current_tab_id
		), $atts));
			
		$_ewf_tabs_instances[$current_tab_instance_id][$current_tab_id]['title'] = $title;
		$_ewf_tabs_instances[$current_tab_instance_id][$current_tab_id]['current'] = $current;
		$_ewf_tabs_instances[$current_tab_instance_id][$current_tab_id]['content'] = do_shortcode($content);
	}	
	
	function ewf_sc_tabs ( $atts, $content = null ){
		global $_ewf_tabs_instances;
					
		$tab_instance_id =  count($_ewf_tabs_instances);
		$_ewf_tabs_instances[$tab_instance_id] = null;
				
		do_shortcode($content);
				
		$src_tabs = null;
		$src_content = null;
		
		$src_tabs.='<ul id="tab-'.$tab_instance_id.'" class="tabs-menu fixed">';
		foreach($_ewf_tabs_instances[$tab_instance_id] as $key=> $tab){
			$src_tabs.= '<li ';
			if ($tab['current']){ $src_tabs.= 'class="current"'; }
			$src_tabs.= '><a href="#content-tab-'.$tab_instance_id.'-'.$key.'">'.$tab['title'].'</a></li>';
			
			$src_content.= '<div id="content-tab-'.$tab_instance_id.'-'.$key.'" class="tabs-content" ';
			if (!$tab['current']){ $src_content.= 'style="display:none;"'; }
			$src_content.= '>'.$tab['content'].'</div>';
			
		}
		$src_tabs.='</ul>';
		
		return $src_tabs.$src_content;
		//return '<ul class="accordion fixed"  id="accordion-'.$acordion_id.'">'.do_shortcode($content).'</ul>';
	}		
	
	function ewf_sc_acordion_slide ( $atts, $content = null ){
		global $_ewf_acordion_instances;
		global $_ewf_acordion_slides_instances;

		$current_acordion_id = count($_ewf_acordion_instances)-1;
		$slide_id =  count($_ewf_acordion_slides_instances);
		$_ewf_acordion_slides_instances[$slide_id] = null;
		
		$src = null;
		
		extract(shortcode_atts(array(
			"title" => 'Slide '.$slide_id,
			"current" => false
		), $atts));		
				
		if ($current){ 
			$src .= '<li class="current"><a rel="#accordion-'.$current_acordion_id.'-slide-'.$slide_id.'">'.$title.'</a><div style="display:block;"><p>'.$content.'</p></div></li>';
		}else{
			$src .= '<li><a rel="#accordion-'.$current_acordion_id.'-slide-'.$slide_id.'">'.$title.'</a><div style="display: none;"><p>'.$content.'</p></div></li>';
		}
		
		return $src;
	}
	
	function ewf_sc_url( $atts, $content = null ){
		return get_template_directory_uri();
	}
				
	function ewf_sc_acordion ( $atts, $content = null ){
		global $_ewf_acordion_instances;
		
		extract(shortcode_atts(array(
			//"align" => 'left'
		), $atts));
			
		$acordion_id =  count($_ewf_acordion_instances);
		$_ewf_acordion_instances[$acordion_id] = null;
				
		return '<ul class="accordion fixed"  id="accordion-'.$acordion_id.'">'.do_shortcode($content).'</ul>';
	}	
	
	function ewf_sc_checklist ( $atts, $content = null ){
		extract(shortcode_atts(array(
			//"align" => 'left'
		), $atts));
			
		return '<div class="checklist">'.$content.'</div>';
	}
	
	function ewf_sc_raw($content) {
		$new_content = '';
		$pattern_full = '{(\[raw\].*?\[/raw\])}is';
		$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
		$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

		foreach ($pieces as $piece) {
			if (preg_match($pattern_contents, $piece, $matches)) {
				$new_content .= $matches[1];
			} else {
				$new_content .= wptexturize(wpautop($piece));
			}
		}

		return '*'.$new_content;
	}
	
	function ewf_sc_blog_navigation($range = 4, $query){
		$src_nav = null;
		$max_page = null;

		$class_current = 'current';
		
		$current_page = $query->query_vars['paged'];
		if ($current_page == 0) { $current_page = 1; }
	
	
	  // How much pages do we have?
	  if ( !$max_page ) {
		$max_page = $query->max_num_pages;
	  }
	
	  $src_nav .= '<ul class="pagination fixed">';
	
	  // We need the pagination only if there are more than 1 page
	  if($max_page > 1){
	  
		$src_nav .= '<li><strong>'.__('Page ',EWF_SETUP_THEME_DOMAIN).$current_page.' of '.$max_page.'</strong></li>';
	  
		if(!$current_page){
		  $current_page = 1;
		}
		// On the first page, don't put the First page link
		if($current_page != 1){
		 // $src_nav.= "<li><a href=" . get_pagenum_link(1) . "> First </a></li>";
		}
		
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

		// On the last page, don't put the Last page link
		if($current_page != $max_page){
		 // $src_nav.= "<li><a href=" . get_pagenum_link($max_page) . "> Last </a></li>";
		}
	  }
	  
	  $src_nav .= '</ul>';
	  
	  
	  return $src_nav;
	}

	function ewf_sc_links( $atts, $content = null ){
		$full_atts = shortcode_atts(array(
			"items" => -1, 
			"order" => 'asc', 
			"parent" => false
		), $atts);
		
		extract($full_atts);
			
		$src = null;
	
		$order = strtoupper($order);
		
		
		$parent_page = get_post($atts['page']); 
		$parent_title = $parent_page->post_title;
		
		$parent_permalink = get_permalink($parent_page->ID);
		$parent_url = str_replace(array('http://', 'https://'),'',strtolower($parent_permalink));
		$current_url = strtolower($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		
		
		if (array_key_exists('page', $atts)){
			$opt = 'child_limit=10&';
			$src.= '<ul class="side-nav">';
			
			$wp_query_childs =  new WP_Query(array( 'post_type' => 'page', 'posts_per_page'=> $items, 'post_parent'=>$atts['page'], 'order'=>$order, 'orderby'=>'ID' ));
			
			if ($order == 'ASC' && $parent == true ){
				if ($current_url==$parent_url){ $extra = "class='current' "; }else{ $extra = null; }				
				$src.= '<li '.$extra.'><a href="'.$parent_permalink.'">'.$parent_title.'</a></li>';
			}
			
			while ($wp_query_childs->have_posts()) : $wp_query_childs->the_post();
				$item_url = str_replace(array('http://', 'https://'),'',strtolower(get_permalink()));
				
				if ($current_url==$item_url){
					$extra = "class='current' ";
				}else{
					$extra = null;
				}
				
				$src.= '<li '.$extra.'><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
			endwhile;

			if ($order == 'DESC' && $parent == true ){
				if ($current_url==$parent_url){ $extra = "class='current' "; }else{ $extra = null; }				
				$src.= '<li '.$extra.'><a href="'.$parent_permalink.'">'.$parent_title.'</a></li>';
			}
			
			wp_reset_query();
			
			$src.= '</ul>';
		}
		
		return $src;
	} 
	
	function ewf_sc_links_slide ( $atts, $content = null ){
		global $_ewf_links_extra_slide_instances;
		
		extract(shortcode_atts(array(
			"items" => -1, 
			"link" => 'true', 
			"order" => 'asc',
			"title" => __("more", EWF_SETUP_THEME_DOMAIN)
		), $atts)); 
		
		$nav_count = 0;
		
		$src_nav = null;
		$src_content = null;
		
		$order = strtoupper($order);
		
		$section_slide_id =  count($_ewf_links_extra_slide_instances);
		$_ewf_links_extra_slide_instances[$section_slide_id] = null;
		
		if (array_key_exists('page', $atts)){
			$src_nav.= '<ul id="services-menu" class="instance-'.$section_slide_id.'">';
			$wp_query_childs =  new WP_Query(array( 'post_type' => 'page', 'post_parent'=>$atts['page'],  'posts_per_page'=> $items, 'order'=>$order, 'orderby'=>'ID' ));
			while ($wp_query_childs->have_posts()) : $wp_query_childs->the_post();
				$nav_count++;
				
				if ( $wp_query_childs->post_count == $nav_count ){ $extra = ' class="last" '; }else{ $extra = null; }
				
				$src_nav.= '<li '.$extra.'><a href="#slide-item-'.$section_slide_id.$nav_count.'">'.get_the_title().'</a></li>';
				
				$src_content.= '<div class="service" id="slide-item-'.$section_slide_id.$nav_count.'"><h4>'.get_the_title().'</h4><p>'.get_the_excerpt().'</p>';
				
				if ($link == 'true'){
					$src_content.='<p><a href="'.get_permalink().'">'.$title.'</a></p>'; 
				}
				
				$src_content.='</div>';
			endwhile;
			$src_nav.= '</ul>';
			
			wp_reset_query();
		}
		
		$src = '<div class="fixed clear"><div class="col-220">'.$src_nav.'</div><div class="col-460 last"><div id="services-container">'.$src_content.'</div></div></div>';
		return $src;
	}
	
	function ewf_sc_categs ( $atts, $content = null ){
		extract(shortcode_atts(array(
			"align" => 'left'
		), $atts));
			
		$categories = get_categories('orderby=count&hide_empty=0');
		$items = 0;
		$lines = 2;
		
		$src = null;
		$src.= '<ul class="side-nav clearfix">';
		
		foreach ($categories as $categ) {
			$items++;
			$src.= '<li><a href="#">'.$categ->name.' <span>('.$categ->count.')</span></a></li>';
		}
		$src.= '</ul>';
					
		return $src;
	}
	
	function ewf_sc_thumbs ( $atts, $content = null ){
		extract(shortcode_atts(array(
			"thumb" => "medium",
			"columns" => 0,
			"rows" => 4,
			"smart" => true
		), $atts));
		
		$sizes = array("small", "medium", "large", "big"); 
		$src = null;
		
		if ($smart && function_exists('ewf_getColumn')){
			$width = ewf_getColumn();
			
			switch($thumb) {
				case "small":
					$columns = 5;
					$height = ($width/100) * 18.00;
					break;
				
				case "medium":
					$columns = 4;
					$height = ($width/100) * 23.10;
					break;
				
				case "large":
					$columns = 3;
					$height = ($width/100) * 31.6;
					break;
				
				case "big":
					$columns = 2;
					break;	
			}
		}
		
		
		
		$items = $columns * $rows;
		
		$src.= 	'<div class="sc-thumbs col-w'.$width.'">';
		$src.=	'<ul class="thumbs-'.$thumb.' clearfix">';
			
		$args = array( 'post_type' => 'attachment', 'numberposts' => $items, 'post_status' => null, 'post_parent' => $post->ID ); 
		$attachments = get_posts($args);
		$count = 0;
		if ($attachments) {
			foreach ( $attachments as $attachment ) {
				$count++;
				$extra_class = null;

				if ($count == $columns) {
					$extra_class = "class='last'";
					$count = 0;
				}
				
				$current_image = wp_get_attachment_image_src( $attachment->ID, "thumb-".$thumb );
				$src.='<li '.$extra_class.' style="background:url('.$current_image[0].') no-repeat center center;height:'.$height.'px;"></li>';
			}
		}
			
		$src.=	'</ul>';
		$src.=	'</div>';
					
		return $src;
	}
	
	function ewf_sc_recentcomments ( $atts, $content = null ){
		extract(shortcode_atts(array(
			"items" => 5
		), $atts));
			
		$src = null;
		
		$sc_comments = get_comments( array(
			'number'    => 5,
			'status'    => 'approve'
		) );
	
			
		$src.="<ul class='sc-recent-comments'>";
				foreach($sc_comments as $key => $single_comment){
					$src.="<li>";
						$src.='<span class="author" >'.$single_comment->comment_author.'</span>';
						$src.='<span class="date" >'.date( 'G:i d-M-Y' , strtotime($single_comment->comment_date)).'</span>';
						$src.='<p>'.$single_comment->comment_content.'</p>';
					$src.="</li>";
				}
		$src.="</ul>";
			
			
		return $src;
		//return '<span class="pullquote '.$align.'">&#8220;'.$content.'&#8221;</span>';
	}
	
	function ewf_sc_recentposts ( $atts, $content = null ){
		extract(shortcode_atts(array(
			"items" => 4,
			"category" => 0,
			"orderby" => "post_date",
			"order" => "DESC",
			"exclude" => null,
			
		), $atts));
		
		$src = null;
		$args = array(
		'numberposts' => $items,
		'category' => $category,
		'orderby' => $orderby,
		'order' => $orders,
		'exclude' => $exclude,
		'post_type' => 'post',
		'post_status' => 'publish');	
		
		$sc_recent_posts = wp_get_recent_posts($args);
		
		$src.="<ul class='sc-recent-comments'>";
				foreach($sc_recent_posts as $key => $single_post){
					$src.="<li>";
						$src.="<h5>".$single_post['post_title'].'</h5>';
						$src.="<p>".$single_post['post_excerpt'].'</p>';
					$src.="</li>";
					
					//echo '<pre>';
					//	print_r($single_post);
					//echo '</pre>';
				}
		$src.="</ul>";
		
		return $src;
	}
	
	function ewf_sc_newsletter ( $atts, $content = null ){
		extract(shortcode_atts(array(), $atts));			
		$value = "'".__('subscribe to newsletter...', EWF_SETUP_THEME_DOMAIN)."'";
		
		$src =      '<form method="get" action="#" id="newsletter-subscribe">
						<fieldset> 
							<input type="text" onblur="if(this.value=='."''".') this.value='.$value.'" onfocus="if(this.value=='.$value.')this.value='."''".';" value="'.__('subscribe to newsletter...', EWF_SETUP_THEME_DOMAIN).'" id="subscribe-email" class="text" />
							<input type="submit" value="'.__('submit', EWF_SETUP_THEME_DOMAIN).'" class="subscribe-submit-btn" />
						</fieldset></form>';
					
		return $src;
	}	
	
	function ewf_sc_brochure ( $atts, $content = null ){
		extract(shortcode_atts(array(
			"title" => null,
			"url" => null
		), $atts));
			
		return '<div class="pdf"><a href="'.$url.'">'.$title.'</a></div>';
	}
		
	function ewf_sc_pullquote ( $atts, $content = null ){
		extract(shortcode_atts(array(
			"align" => 'left'
		), $atts));
			
		return '<span class="pullquote '.$align.'">&#8220;'.$content.'&#8221;</span>';
	}
	
	function ewf_sc_frame ( $atts, $content = null ){
		extract(shortcode_atts(array(
			"align" => 'left',
			"src" => null,
			"href" => null
		), $atts));
		
		if ($href){
			return '<a href="'.$href.'" class="frame '.$align.'"><img src="'.$src.'" ><span>'.$content.'</span></a>';
		}else{
			return '<div class="frame '.$align.'"><img src="'.$src.'" ><span>'.$content.'</span></div>';
		}
	}
	
	function ewf_sc_expand ( $atts, $content = null ){
		extract(shortcode_atts(array(
			"title" => null
		), $atts));
		
		$extra = null;
		$controls = '<span class="expand-plus">+</span><span class="expand-minus">-</span>';
		
		if ($title){
			$extra = '<h2>'.$title.' '.$controls.'</h2>';
		}else{
			$extra = $controls;
		}
		
		return '<div class="expand">'.$extra.'<p>'.$content.'</p></div>';
	}	
	
	function ewf_sc_br ( $atts, $content = null ){
		return '<br/>';
	}	
	
	function ewf_sc_dropcap ( $atts, $content = null ){
		$letter = substr($content, 0,1);
		$content = substr($content, 1, strlen($content));
		return '<p class="dropcap"><span class="dropcap">'.$letter.'</span>'.$content.'</p>';
	}
	
	function ewf_sc_highlight2 ( $atts, $content = null ){
		extract(shortcode_atts(array(
			"style" => 'small'
		), $atts));
			
		return '<span class="text-highlight2">'.$content.'</span>';
	}	
	
	function ewf_sc_highlight ( $atts, $content = null ){
		extract(shortcode_atts(array(
			"style" => 'small'
		), $atts));
			
		return '<span class="text-highlight">'.$content.'</span>';
	}
	
	function ewf_sc_message ( $atts, $content = null ){
		extract(shortcode_atts(array(
			"type" => 'success'
		), $atts));
		
		$class = null;
		
		switch($type){
			case "success":
				$class="successmsg";
				break;
			
			case "error":
				$class="errormsg";
				break;
			
			case "info":
				$class="infomsg";
				break;
			
			case "notice":
				$class="noticemsg";
				break;
		}
			
		return '<div class="'.$class.'">'.$content.'</div>';
	}
	
	function ewf_sc_client_logo ( $atts, $content = null ){
		extract(shortcode_atts(array(
			"src" => null,
			"href" => null,
			"size" => 'large', 
			"margin" => null
		), $atts));
		
		$class = 'client';
			
		if (array_key_exists('0', $atts) && $atts[0]=='small' ||  array_key_exists('1', $atts) && $atts[1]=='small' && array_key_exists('2', $atts) && $atts[2]=='small'){
			$size = 'small';
			$class = 'client-small';
		}
			
		if ($margin == 'left') { $class .= ' mleft'; }
		if ($margin == 'right') { $class .= ' mright'; }
			
		$_src  = null;
			if ($href != null) { 
				$_src .= '<div class="'.$class.'"><div style="background:url('.$src.') no-repeat center center;" class="client-logo"><a class="fixed" href="'.$href.'"></a></div></div>';
			}else{
				$_src .= '<div class="'.$class.'"><div style="background:url('.$src.') no-repeat center center;" class="client-logo"></div></div>';
			}			
				
		return ewf_shortcode_fix($_src);
	}
		
	function ewf_sc_quote ( $atts, $content = null ){
		extract(shortcode_atts(array(
			"class" => null,
			"style" => 'normal',
			"align" => null,
			"author"=>null
		), $atts));
		
		$extra = null;
		
		$src  = null;
		$src .= '<blockquote class="clear ';
			if ($align == 'left') {
				$src .= 'blockquote-left ';
				}
				
			if ($align == 'right') {
				$src .= 'blockquote-right';
				}
				
				$src .= $class;
		$src .= '"><p>';
			
		$src .= $content;
		
		if($author){
			$src .= '<br/><span>'.$author.'</span>';
			}
			
		$src .= '</p></blockquote>';
			
		return $src;
	}
	
	function ewf_sc_pre ( $atts, $content = null ){
		extract(shortcode_atts(array(
			"class" => null
		), $atts));
		
		if ($class != null){
			return '<pre class="'.$class.'">'.$content.'</pre>';
		}else{
			return '<pre>'.$content.'</pre>';
		}
	}
	
	function ewf_sc_code ( $atts, $content = null ){
		return '<code>'.$content.'</code>';
	}
	
	function ewf_sc_clean ( $atts, $content = null ){		
		return $content;
	}
	
	function ewf_sc_more ( $atts, $content = null ){
		extract(shortcode_atts(array(
			"href" => ''
		), $atts));
		
		return '<a class="more" href="'.$href.'">'.$content.'</a>';
	}
	
	function ewf_sc_h1 ( $atts, $content = null ){
		return '<h1>'.$content.'</h1>';
	}

	function ewf_sc_h2 ( $atts, $content = null ){
		return '<h2>'.$content.'</h2>';
	}
	
	function ewf_sc_h3 ( $atts, $content = null ){
		return '<h3>'.$content.'</h3>';
	}
	
	function ewf_sc_h4 ( $atts, $content = null ){
		return '<h4>'.$content.'</h4>';
	}
	
	function ewf_sc_h5 ( $atts, $content = null ){
		return '<h5>'.$content.'</h5>';
	}
	
	function ewf_search_image_size($image_id, $column_width, $width = "auto", $height = "auto", $return_array = false){
		$image_sizes = get_intermediate_image_sizes();
		$image_url = null;
		
		if ($column_width == 0) { return null; }
		
		/*
		echo '<br/>----';
		echo '<br/>Detected Width:'.$column_width;
		echo '<br/>width:'.$width;
		echo '<br/>height:'.$height;
		echo '<br/>image_id:'.$image_id;
		echo '<br/>----';
		*/
		
		foreach($image_sizes as $key => $image_size){
			$current_image = wp_get_attachment_image_src( $image_id, $image_size );
			
			if ($current_image) { 
				/*
				echo '<br/>Current size: '.$current_image[1].'x'.$current_image[2];
				*/
				
				if ($width == "auto" && $height == "auto" && $current_image[1] == $column_width){
					if ($return_array) {
						return $current_image;
					}else{
						return $current_image[0];
					}
				}
					
				if ($width == "auto" && $height != "auto" && $current_image[1] == $column_width && $current_image[2] == $height){
					if ($return_array) {
						return $current_image;
					}else{
						return $current_image[0];
					}
				}
			}
		}
		
		return null;
	}
	
	function ewf_sc_article ( $atts, $content = null ){
		global $post;

		$src = null;
		$image_url == null;
		
		extract(shortcode_atts(array(
			"id" 		=> 0,
			"width" 	=> "auto",
			"height" 	=> "150",
			"details" 	=> false,
			"corners" 	=> true,
			"link" 		=> true,
			"title"		=> true,
			"featured"	=> false,
			"image" 	=> true,
			"more" 		=> false,
			"style" 	=> "default"
		), $atts));
		
		
		$default_styles = array(
			'blog' => array( "image" => true, "more"=>true, "title" =>true, "details"=>true),
			'default' => array (),
			'feature' => array( "image" => true, "more"=>false, "link"=>false, "preview"=>true, "featured"=>true ),
			'clean' => array( "image" => true, "more"=>false, "link"=>false, "title"=> true, "corners"=>false )
		);
		
		extract( $default_styles[$style] );
		
		
		if (function_exists('ewf_getColumn')){
			$column_width = ewf_getColumn();
			
			$image_id = get_post_thumbnail_id($id);  
			$image_info = ewf_search_image_size($image_id, $column_width, $width, $height, true); 
			$image_url = $image_info[0];
			
			
			apply_filters("debug", "ewf_search_image_size : [count:".count($image_info)."]");
			
			if ($image_url == null) {
				if ($height == "auto") { $height = 200; }
				$image_url = 'http://dummyimage.com/'.$column_width.'x'.$height.'/ccc/fff.png&text=++image+not+available++';
				}
		}

		
		if ($id>0){
			$current_post = get_post($id, ARRAY_A);
			$current_permalink = get_permalink($id);
			
			$src.= '<div class="article-single '.$style.'" >';
				
				if (!$featured){
					//** Show article title
					//
					if ($title){
						$src.= '<h2><a href="'.$current_permalink.'">'.$current_post['post_title'].'</a></h2>';
						}
					
					
					//** Show article details - author && date && coments
					//
					if ($details){
						$src.= '<div>';
							$src.= '<span class="author">Maria</span> ';
							$src.= '<span class="date">16:41 13-mar-2011</span> ';
							$src.= '<span class="comments">12</span>';
						$src.= '</div>';
						}
				}
				
				//** Show featured image
				//
				if ($image_url!=null && $image){
				
					if ($corners){
						$src.= '<div class="img-borders" style="background:url('.$image_url.') no-repeat center center;width:'.$image_info[1].'px;height:'.$image_info[2].'px;">';
						
						if ($link) {
							$src.= '<a href="'.get_permalink($id).'"></a>';
							}
						
						$src.= '</div>';
					}else{
						$src.= '<img src="'.$image_url.'" alt="'.$current_post['post_title'].'"/>';
					}
				}
				
				if ($featured){
					//** Show article title
					//
					if ($title){
						$src.= '<h2><a href="'.$current_permalink.'">'.$current_post['post_title'].'</a></h2>';
						}
					
					
					//** Show article details - author && date && coments
					//
					if ($details){
						$src.= '<div>';
							$src.= '<span class="author">Maria</span> ';
							$src.= '<span class="date">16:41 13-mar-2011</span> ';
							$src.= '<span class="comments">12</span>';
						$src.= '</div>';
						}
				}
				
				
				$src.= '<p>'.$current_post['post_excerpt'];
				
				//** Show 'read more' link
				//
				if($more){
					$src.='<a href="'.$current_permalink.'" class="more" >read more</a>';
					}
					
				$src.='</p>';
			$src.= '</div>';
		}
		
		return $src;
	}
	
	function ewf_sc_childpages ( $atts, $content = null ){
		global $post;
		
		$params = shortcode_atts(array( "items" => -1,  "page" => 0, "order"=> 'asc', 'id' => null), $atts );
		extract($params);
			
		$src = null;
		$count_row = 0;
		$count = 0;
		
		$order = strtoupper($order);
		$include_posts = array();
				
		$query = array( 
			"post_type" 	=> "page", 
			"sort_column" 	=> "id", 
			"orderby"		=> "ID" ,
			"order" 		=> $order, 
			"post_parent"	=> $page, 
			"posts_per_page"=> $items 
		);
		
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
						
			$query['post__in'] = $include_posts;
			unset($query['posts_per_page']); 
			unset($query['post_parent']); 		
		}
		
		if (array_key_exists('page', $atts) || array_key_exists('id', $atts) ){
			$wp_query_childs =  new WP_Query($query);
			$extra_class = null;
			
			if ($wp_query_childs->post_count > 3){ $extra_class = ' services'; }
			
			$src .= '<ul id="services-overview" class="fixed'.$extra_class.'">';
			
			while ($wp_query_childs->have_posts()) : $wp_query_childs->the_post();		
				$count_row++;
				$count++;
				
				$tmp_item = null;
				if ($count_row==1){ $class_extra='class="first"'; }else{ $class_extra = null; }
				if ($count_row==3){ }
				
				$tmp_item.='<li '.$class_extra.'>';
					$ewf_page_thumb_id = get_post_thumbnail_id();  
					
					
					$tmp_item.='<h5><a href="'.get_permalink().'">'.get_the_title().'</a></h5>';
					$tmp_item.='<p>'.get_the_excerpt().'</p>';
					
					if ($ewf_page_thumb_id){
						$image_url = wp_get_attachment_image_src($ewf_page_thumb_id,'column-160');  
						$tmp_item.='<div><img src="'.$image_url[0].'" width="180" height="100" alt="'.get_the_title().'" /></div>';
					}
					
					$tmp_item.='<div class="services-overview-overlay"></div>';
				$tmp_item.='</li>';
				
				if ($count == 3){
					$count = 0;
					$count_row = 0;
				}
				
				$src .= $tmp_item;
			endwhile;
			
			$src .= '</ul>';
			
			wp_reset_query();
			
		}
		
		return $src;
	}
	 
	function ewf_sc_form_contact( $atts, $content = null ){	
		$src='
			<form action="javascript:void(0);" class="fixed" id="contact-form">
				<fieldset>
					<p id="formstatus"></p> 
					<div>
						<label for="name">'.__('Your Name', EWF_SETUP_THEME_DOMAIN).': <span class="required">*</span></label><input type="text" value="" name="name" id="name" class="text"/>
					</div> 
					<div>
						<label for="email">'.__('Your Email Address', EWF_SETUP_THEME_DOMAIN).': <span class="required">*</span></label><br/><input type="text" value="" name="email" id="email" class="text">
					</div> 
					<div>
						<label for="subject">'.__('Subject', EWF_SETUP_THEME_DOMAIN).': <span class="required">*</span></label><br/><input type="text" value="" name="subject" id="subject" class="text">
					</div> 
					<div>
						<label for="message">'.__('Message', EWF_SETUP_THEME_DOMAIN).': </label><br><textarea cols="25" rows="3" name="message" id="message"></textarea>
					</div>
					<div>
						<input type="submit" value="'.__('Send!', EWF_SETUP_THEME_DOMAIN).'" name="submit"><br/>
					</div>
				</fieldset>
			</form>';
		 
		return ewf_shortcode_fix($src);
	}
	
	function ewf_sc_blog_search( $atts, $content = null ){
		$src = null;
		
		$src.= '<form id="search" method="get" id="searchform" action="'.get_bloginfo('url').'">';
		$src.= '<fieldset>';
			$src.= '<input type="text" class="text" id="search-input" name="s" value="search..." onfocus="if(this.value=='."'search...'".')this.value='."''".';" onblur="if(this.value=='."''".')this.value='."'search...'".'"  />';
			$src.= '<input type="hidden" name="post_type" value="post" />';
			$src.= '<input type="submit" class="search-submit-btn" id="search_submit" value="" />';
		$src.= '</fieldset>';
		$src.= '</form>';
		
		return $src;
		
	}
	
	function ewf_sc_blog( $atts, $content = null ){
		global $post;
		$src = null;
		
		extract(shortcode_atts(array(
			"posts" 		=> 2,
			"categ_include" => null, 
			"categ_exclude" => null,
			"posts_exclude" => null,
			"layout" 		=> "single", 
			"height" 		=> "auto",
			"width" 		=> "auto",
			"date" 			=> "true",
			"info"			=> "true",
			"nav" 			=> "true",
			"style" 		=> null
		), $atts));
		
		$position = array('odd', 'even');
		global $more;
		
				wp_reset_query();
				
				$paged = get_query_var('page') ? get_query_var('page') : 0;
				if ($paged == 0){
					$paged = get_query_var('paged') ? get_query_var('paged') : 1;
				} 
				 
				$wp_query_blog = new WP_Query(array( 'post_type' => 'post', 'posts_per_page' => $posts, 'paged' =>$paged ));
				$count = 0;
				
				/*
				echo '<br/>Paged:'.$paged;
				echo '<br/>Page:'.get_query_var('page');
				echo '<pre>';
					print_r($wp_query_blog);
				echo '</pre>';
				*/
				
				 while ($wp_query_blog->have_posts()) : $wp_query_blog->the_post();
					$count++;
					$pair = $count % 2;
					
					
					$post_class = get_post_class();
					$post_class_fin = null;
					
					foreach($post_class as $key=> $ctclass){
						$post_class_fin.= ' '.$ctclass;
					}
									
					$src .= '<div class="blog-post '.$position[$pair].' fixed '.$post_class_fin.'">';
						
							$image_id = get_post_thumbnail_id($post->ID);  
							if ($image_id>0){
								$src .= '<div class="col-220">';
									$thumb_details = wp_get_attachment_image_src( $image_id ,'column-220-auto');
									$src .= '<img src="'.$thumb_details[0].'" alt="'.get_the_title().'"/>';
								$src .= '</div>';
								
								$src .= '<div class="col-460 last">';
							}
						
							$src .= '<h3><a href="' . get_permalink() . '" rel="bookmark">'.get_the_title($post->ID).'</a></h3>' ;
							
							if ($info == "true"){
								$src .= '<p>'.__('Posted by', EWF_SETUP_THEME_DOMAIN).': <strong>'.get_the_author().'</strong> | '.__('Posted on',EWF_SETUP_THEME_DOMAIN).': <strong>'.get_the_time('F jS, Y').'</strong> | <a href="'.get_comments_link().'">'.get_comments_number().' '.__('Comments', EWF_SETUP_THEME_DOMAIN).'</a></p>';
								}
							
							$more = false;
							$src .= do_shortcode(get_the_content(__('Read More', EWF_SETUP_THEME_DOMAIN)));  
							$more = true;
							
							if ($image_id>0){
								$src .= '</div>';
								}
								
					$src .= '</div>';
					
					
					if ($wp_query_blog->post_count > $count){
						$src .= '<div class="hr"></div>';
					}
					
					if ($wp_query_blog->post_count == $count && $nav == "true"){
						$src .= '<div class="hr"></div>';
					}
				
				endwhile;		
				
				if ($nav == "true"){
					$src .= ewf_sc_blog_navigation($posts, $wp_query_blog);
				}
		return $src;
	}	
		
	function erm_get_post_categs($post_id){
		$categs_ids = wp_get_post_categories( $post_id );
		$categs_src = null;
		$categs_arr = array();
		
		foreach($categs_ids as $c){
			$cat = get_category( $c );
			$categs_src .= '<a href="'.$cat->slug.'" >'.$cat->name.'</a> ';
		}
		
		return $categs_src;
	}
	
	/*
		spacing: nosp|null
	*/
	function ewf_sc_hr ( $atts, $content = null ){
		extract(shortcode_atts(array(
			"spacing" => null,
		), $atts));
		
		return '<div class="hr '.$spacing.'"></div>';
	}	
	
	function ewf_map_javascript_handler($return = false){
		global $_ewf_maps_instances;
		
		$src = null;
		
		if (is_array($_ewf_maps_instances)){
			$src.='<script type="text/javascript">window.onload=function(){';
				foreach($_ewf_maps_instances as $map_id => $atts){
					$first = false;
					$last = false;
					
					$src.= '$("#'.$map_id.'").gMap({ ';
						
						if ($atts['marker']==true ){
							 $src.= 'markers: [{ ';
							 
							if (array_key_exists('popup', $atts) && $atts['lat'] != 0 ){
								 $src.= 'popup: '.$atts['popup']; $first = true;
								}
							 							 
							if (array_key_exists('lat', $atts) && $atts['lat']>0 ){
								if ($first) { $src.=','; }
								 $src.= 'latitude: '.$atts['lat']; $first = true;
								}
							 
							if (array_key_exists('long', $atts) && $atts['lat']>0  ){
								if ($first) { $src.=','; }
								 $src.= 'longitude: '.$atts['long']; $first = true;
								}
								
							if (array_key_exists('address',$atts) && $atts['address'] != '' ){
								if ($first) { $src.=','; }
								 $src.= 'address: "'.$atts['address'].'"'; $first = true;
								}
								
							if (array_key_exists('details',$atts) && $atts['details'] != '' ){
								 if ($first) { $src.=','; }
								 $src.= 'html: "'.$atts['details'].'"'; $first = true;
								}
							 
							 $src.= '}]'; 
							 
							 $last = true;
						} 
						
						
						if (array_key_exists('address',$atts) && $atts['address'] != '' ){
							 if ($last) { $src.=','; }
							 $src.= 'address: "'.$atts['address'].'"'; $last = true;
							}						
						
						if (array_key_exists('zoom', $atts)){
							if ($last) { $src.=','; }
							 $src.= 'zoom: '.$atts['zoom']; $last = true;
							}
					$src.='});';
				} 
			$src.='}</script>';
		}
				
		if ($return){
			return $src;
		}else{
			echo $src;
		}
	}
	
	
	function ewf_sc_map($atts, $content){
		global $_ewf_maps_instances;
		
		$att_fin = shortcode_atts(array(
			"zoom" => 14,
			"address" => null,
			"lat" => 0,
			"long" => 0, 
			"details" => null, 
			"marker" => 1, 
			"popup" => 0
		), $atts);
		
		extract($att_fin);
		
		$gmaps_api_key = get_option(EWF_SETUP_THNAME."_maps_api_key", null);
		
		if ($gmaps_api_key != null) {
			$map_id = "map_sc_".count($_ewf_maps_instances);
			$_ewf_maps_instances[$map_id] = $att_fin;
			
			return '<div id="'.$map_id.'" class="map"></div>';
		}else{
			return ewf_message(__('You need to generate a <a href="http://code.google.com/apis/maps/signup.html" >Google Maps API Key</a>, add it in theme options before using [map] shortcode!', EWF_SETUP_THEME_DOMAIN ));
		}
	}
	
	function ewf_sc_lightbox($atts, $content){
		global $_ewf_maps_instances;
		
		extract( shortcode_atts(array(
			"group" => null,
			"url" => null,
			"src" => null
		), $atts));
		
		$rel = null;
		$cnt = null;
		
		if ( $group!=null){
			$rel = 'prettyPhoto['.$group.']';
		}else{
			$rel = 'prettyPhoto';
		}
		
		if ($content != null){
			$cnt = $content;
		} else{
			if ($src != null) {
				$cnt = $cnt='<img src="'.$src.'" alt="" />';
			}else{
				return null;
			}
		}
		
		return '<a href="'.$url.'" rel="'.$rel.'">'.$cnt.'</a>';
	
	}
	
	function ewf_get_the_content_with_formatting ($more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
		$content = get_the_content($more_link_text, $stripteaser, $more_file);
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]&gt;', $content);
		return $content;
	}
	
?>