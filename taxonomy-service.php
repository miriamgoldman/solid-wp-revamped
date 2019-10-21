<?php get_header(); ?>

	<div id="content">
	
	<?php
	
		$items = get_query_var('posts_per_page');
		$items_count = 0;
		$items_row = 0;
		$items_src = null;
		
		$paged = get_query_var('paged') ? get_query_var('paged') : 1;
		$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

		$portfolio_page_id = 0;
		$portfolio_page = get_option(EWF_SETUP_THNAME."_page_portfolio", 0);
		
		if ($portfolio_page != null){
			$portfolio_page = get_page_by_title($portfolio_page);
			
			if (is_object($portfolio_page)){
				$portfolio_page_id = $portfolio_page->ID;
				}
		}
		
		if ($portfolio_page_id) {
			echo '<div class="row fixed">';
			
			$service_page = get_post($portfolio_page_id); 
			
			$ewf_header_image_id = ewf_getHeaderImageID($portfolio_page_id);
			$ewf_header_image = null;
			
			if ($ewf_header_image_id){
				$ewf_header_image = wp_get_attachment_image_src($ewf_header_image_id,'page-header');  
			}
			
			if ($ewf_header_image){
				echo '
				<div class="inner-page-title-container">
					<img src="'.$ewf_header_image[0].'" width="940" height="220" alt="" />
					<div class="inner-page-title fixed">
						<h2>'.$service_page->post_title.'</h2>
						<p>'.$service_page->post_excerpt.'</p>
					</div>
				</div>';
			}else{
				echo '
				<div class="inner-page-title-container">
					<div class="inner-page-title fixed">
						<h2>'.$service_page->post_title.'</h2>
						<p>'.$service_page->post_excerpt.'</p>
					</div> 
				</div>';
			}
			
			
			echo '</div>';
			echo '<div class="hr"></div>';
		}
		
		
		$query = array( 'post_type' => 'project', 'posts_per_page' => $items, 'paged' => $paged , 'taxonomy'=>'service','term'=>$term->slug );
		
		$wp_query = new WP_Query($query);
		$results = 0;

		$layout = get_option(EWF_SETUP_THNAME."_portfolio_taxonomy_view", '3 Columns');
		
		echo '<div class="row fixed">';
			
			echo '<div class="col-220 no-print">';
					ewf_setSection('zone-sidebar');
					if ( !function_exists('dynamic_sidebar')  || !dynamic_sidebar('sidebar-page') );
			echo '</div>';
			
			echo '<div class="col-700 last">';
				
				if ($layout == "3 Columns"){
						while ($wp_query->have_posts()) : $wp_query->the_post();
							global $post;
							
							$results = $wp_query->post_count;
							
							$items_count++;
							$items_row++; 
							
							$extra_class = null;
							
							$image_id = get_post_thumbnail_id();  
							$image_small_preview = wp_get_attachment_image_src($image_id,'project-preview-small');  
							$image_large = wp_get_attachment_image_src($image_id,'large');  
							
							if ($items_row == 3){ $extra_class = "last"; }
							if ($items_row == 1){ 
								if ( $items_count>3 ) { $items_src .= '<div class="row-0'.$items_row.' hr"></div>'; }
								$items_src .= '<div class="row fixed">'; 
								}
										
							$items_src .='<div class="portfolio-item col-220 '.$extra_class.'">';
									if ($image_id){
										$items_src .= '<p><a href="'.$image_small_preview[0].'" class="portfolio-item-preview" rel="prettyPhoto[projects]" title="'.get_the_excerpt().'"><img src="'.$image_small_preview[0].'" width="220" height="140" alt="'.get_the_title().'" /></a></p>';
									}else{
										$items_src.= ewf_message(__('There is no featured image, please add one!', EWF_SETUP_THEME_DOMAIN));
									}
									
							$items_src .= '	<h3><a href="'.get_permalink().'">'.get_the_title().'</a></h3>
											<p>'.get_the_excerpt().'</p>
											<p><a href="'.get_permalink().'">'.__('Read More',EWF_SETUP_THEME_DOMAIN).'</a></p>
											</div>';
							
							if ($items_row == 3){ 
								$items_row = 0; 
								$items_src .= '</div>'; 
							}else { 
								if ($wp_query->post_count == $items_count){ $items_src .= '</div><!--forced row end-->'; }
							}
						
						endwhile;
								
				}
				
				if ($layout == "1 Column"){
							while ($wp_query->have_posts()) : $wp_query->the_post();
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
										<h3><a href="'.get_permalink().'">'.get_the_title().'</a></h3>
										<p>'.get_the_excerpt().'</p>
										<p><a href="'.get_permalink().'">'.__('Read More',EWF_SETUP_THEME_DOMAIN).'</a></p>';
									
									$items_src.= '</div>
								</div><div class="hr"></div>';
							endwhile;
				
				}
				
				echo $items_src;
		
				if ( $wp_query->found_posts > $items ){
					echo '<div class="hr"></div>';
					echo '<div class="fixed">'.ewf_projects_pagination(get_query_var('posts_per_page'), $wp_query).'</div>';
				}
		
			echo '</div>';	
		echo '</div>';	
		
		
	?>

	</div>
	
<?php get_footer(); ?>