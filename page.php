<?php get_header(); ?>
<?php
	
	$page_layout = ewf_get_sidebar_layout();
	
?>	
		<div id="content" class="fixed">
			<?php 
			 
				ewf_setSection('full-content'); 
				
				global $post;
				$location = str_replace(array(strtolower(get_bloginfo('url'))),'',strtolower(get_permalink()));
				
				if (strlen($location)>2){
					
					$ewf_post_id = $post->ID; 
					
					$ewf_header_image_id = ewf_getHeaderImageID($post->ID);
					$ewf_header_image = null;

					
					if (!$ewf_header_image_id && $post->post_parent){
						$ewf_header_image_id = ewf_getHeaderImageID($post->post_parent);  
						$ewf_post_id = $post->post_parent;
						}
					
					if($ewf_header_image_id){
						$ewf_header_image = wp_get_attachment_image_src($ewf_header_image_id,'page-header');  
						}
					
					$ewf_post = get_post($ewf_post_id);
					
					if ($ewf_header_image){
						echo '
						<div class="inner-page-title-container">
							<img src="'.$ewf_header_image[0].'" width="940" height="220" alt="" />
							<div class="inner-page-title fixed">
								<h2>'.$ewf_post->post_title.'</h2>
								<p>'.$ewf_post->post_excerpt.'</p>
							</div>
						</div>
						
						<div class="hr"></div>';
					}else{ 
						echo '
						<div class="inner-page-title-container">
							<div class="inner-page-title fixed">
								<h2>'.$ewf_post->post_title.'</h2>
								<p>'.$ewf_post->post_excerpt.'</p>
							</div>
						</div>
						
						<div class="hr"></div>';
					}
					
				}else {
				
					// Load homepage slider 
					if (get_option( EWF_SETUP_THNAME.'_slider_home', 'true')=='true'){
						$wp_slider_query = new WP_Query(array( 'post_type' => 'slide', 'orderby'=>'DATE', 'order'=>'ASC', 'posts_per_page' => -1 ));
						
						//echo '<pre>';
						//	print_r($wp_slider_query);
						//echo '</pre>';
						
						if ($wp_slider_query->post_count){
							echo' 
							<div class="row slideshow-container no-print fixed">
								<div id="slideshow-index">
									<ul>';

									
									 while ($wp_slider_query->have_posts()) : $wp_slider_query->the_post();
										$custom = get_post_custom($post->ID);
							
										if (array_key_exists('slide_url', $custom) && trim($custom['slide_url'][0])!=null){
											$slide_url = $custom["slide_url"][0];
											apply_filters('debug', 'Y - Slide ID:'.$post->ID.' - URL:['.$slide_url.'] ['.count($slide_url).']');
										}else{
											$slide_url = null;
											apply_filters('debug', 'N - Slide ID:'.$post->ID.' - URL:['.$slide_url.']');
										} 
										 
										if (array_key_exists('slide_link_title', $custom)){									
											$slide_link_title = $custom["slide_link_title"][0];
										}else{
											$slide_link_title = __('more', EWF_SETUP_THEME_DOMAIN);
										}
							
										$image_id = get_post_thumbnail_id();  
										$image_url = wp_get_attachment_image_src($image_id,'slider-full');  
										
										echo '<li>';
											echo '<img src="'.$image_url[0].'" width="940" height="350" alt="" />';
											
											if (get_option( EWF_SETUP_THNAME.'_slider_text', 'true')=='true'){
												$slidertext = get_the_excerpt();
												
												if ($slidertext != null && $slide_link_title != null ){
													echo '<div class="slidetext">';
													echo '<h2>'.get_the_title().'</h2>';
													echo '<p>'.$slidertext;
													
													if (get_option( EWF_SETUP_THNAME.'_slider_link', 'true')=='true' && $slide_url != null ){
														echo ' <a href="'.$slide_url.'">'.$slide_link_title.'</a>';
													}
													
													echo '</p></div>';
												}
											}
										echo '</li>';
										
									endwhile; 	
									
									wp_reset_query();
									
							  echo '</ul>
									<div id="index-slideshow-pager">&nbsp;</div>
								</div> 
							</div>
							
							<div class="hr"></div>';
						}else{
							echo ewf_message(__('There are no slides, please add slides to show the slider!',EWF_SETUP_THEME_DOMAIN));
						} 
					}
				}
				
			
				switch ($page_layout) {
				
					case "layout-sidebar-single-left": 
							echo '<div class="row fixed">';
								echo '<div class="col-220 no-print">';
									ewf_setSection('zone-sidebar');
									if ( !function_exists('dynamic_sidebar')  || !dynamic_sidebar('sidebar-page') );
								echo '</div>';
								
								echo '<div class="col-700 last">';
										if ( have_posts() ) while ( have_posts() ) : the_post(); 										
											echo the_content();
										endwhile; 
								echo '</div>';
							echo '</div>';
					break;
				
					case "layout-sidebar-single-right": 
							echo '<div class="row fixed">';
								echo '<div class="col-700">';
									if ( have_posts() ) while ( have_posts() ) : the_post(); 
										echo the_content();
									endwhile; 
								echo '</div>';
								
								echo '<div class="col-220 last no-print">';
									ewf_setSection('zone-sidebar');
									if ( !function_exists('dynamic_sidebar')  || !dynamic_sidebar('sidebar-page') );								
								echo '</div>';
							echo '</div>';

					break;
				
					case "layout-full": 
						if ( have_posts() ) while ( have_posts() ) : the_post(); 
							echo the_content();
						endwhile; 
						break;
				}

				//if ($post->post_parent){
				//	echo '<pre>';
				//		global $post;
				//		print_r($post);
				//	echo '</pre>';
				//}
			?>
		</div>	
	
<?php get_footer(); ?>
