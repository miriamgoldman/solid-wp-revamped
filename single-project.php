<?php get_header(); ?>

	<div id="content" class="fixed">
	
	<?php		
		 while ($wp_query->have_posts()) : $wp_query->the_post();
			$custom = get_post_custom($post->ID);
			
			$image_id = get_post_thumbnail_id();  
			$image_large_preview = wp_get_attachment_image_src($image_id,'project-preview-large');  
			$image_large = wp_get_attachment_image_src($image_id,'large');  
			
			$terms = get_the_terms ($post->ID, 'service');
			
			$custom = get_post_custom($post->ID);
			
			if (array_key_exists('project_date_interval', $custom)){
				$project_interval = $custom["project_date_interval"][0];
			}else{
				$project_interval = null;
			}
						
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
					
					$portfolio_page = get_post($portfolio_page_id); 
					
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
								<h2>'.$portfolio_page->post_title.'</h2>
								<p>'.$portfolio_page->post_excerpt.'</p>
							</div>
						</div>';
					}else{
						echo '
						<div class="inner-page-title-container">
							<div class="inner-page-title fixed">
								<h2>'.$portfolio_page->post_title.'</h2>
								<p>'.$portfolio_page->post_excerpt.'</p>
							</div> 
						</div>';
					}
					
					
					echo '</div>';
					echo '<div class="hr"></div>';
				}
			$arrImages = get_children('post_type=attachment&post_mime_type=image&post_parent='. $post->ID.'&orderby=menu_order&order=ASC' );
			
			echo '
			<div class="fixed">
				<div class="col-220">
					<a href="'.get_permalink($portfolio_page_id).'">'.__('Back to portfolio', EWF_SETUP_THEME_DOMAIN).'</a>
				</div> 
				<div class="col-460 last">
					<h3>'.get_the_title().'</h3>
				</div>
			</div>
			
			<div class="hr"></div>';
			
			echo '<div class="row fixed">';
			
				echo '<div class="col-220">
							<p>'.__('Client', EWF_SETUP_THEME_DOMAIN).'<br/> <strong>'.get_the_title().'</strong></p>';
							
							if ($project_interval!=null){
								echo '<p>'.__('Time Period', EWF_SETUP_THEME_DOMAIN).'<br/><strong>'.$project_interval.'</strong></p>';
								}
					
							if (is_array($terms)){
								echo  '<p>'.__('Services provided', EWF_SETUP_THEME_DOMAIN).':</p>';
								echo  '<ul class="side-nav">';
									foreach($terms as $key => $service){
										echo '<li><a href="'.get_term_link($service->name, 'service').'">'.$service->name.'</a></li>';
									}
								echo  '</ul>';
							}
				echo '</div>';
					
				echo '<div class="col-700 last">';
						
					if (count($arrImages) > 0){
						echo '<div id="slideshow-portfolio">
								<ul>';
							
								if (count($arrImages)==1){
									echo '<li><img height="300" width="700" alt="" src="'.$image_large_preview[0].'" style="opacity: 1;"></li>';
								}
								
								if($arrImages) {					
									foreach($arrImages as $oImage) {
										if ($oImage->ID != $image_id){
											$cr_image_large_preview = wp_get_attachment_image_src( $oImage->ID, 'project-large-preview');						
											echo '<li><img height="300" width="700" alt="" src="'.$cr_image_large_preview[0].'" style="opacity: 1;"></li>';
										}
									}
								}
								
								echo '</ul><div id="portfolio-slideshow-pager">&nbsp;</div>';
						echo '</div>';
					}else{
						echo ewf_message(__('There are no images in the post, please add images to display the slide show!',EWF_SETUP_THEME_DOMAIN));
					}
						
					
				
					echo '<div class="hr"></div>';			
				
					echo '<div class="fixed">';			
					the_content();
					echo '</div>';			
					
				echo '</div>';				
				
			echo '</div>';			
			
			
						

			
		 endwhile; 				  
	?>

	</div>
	
<?php get_footer(); ?>