<?php get_header(); ?>

	<div id="content">

		<div class="row fixed">
			<?php
			
				$news_page_id = 0;
				$news_page = get_option(EWF_SETUP_THNAME."_page_news", 0);
				
				if ($news_page != null){
					$news_page = get_page_by_title($news_page);
					
					if (is_object($news_page)){
						$news_page_id = $news_page->ID;
						}
				}
				
				if ($news_page_id) {
					$news_page = get_post($news_page_id); 
					
					$ewf_header_image_id = ewf_getHeaderImageID($news_page_id);
					$ewf_header_image = null;
					
					if ($ewf_header_image_id){
						$ewf_header_image = wp_get_attachment_image_src($ewf_header_image_id,'page-header');  
					}
					
					if ($ewf_header_image){
						echo '
						<div class="inner-page-title-container">
							<img src="'.$ewf_header_image[0].'" width="940" height="220" alt="" />
							<div class="inner-page-title fixed">
								<h2>'.$news_page->post_title.'</h2>
								<p>'.$news_page->post_excerpt.'</p>
							</div>
						</div>';
					}else{
						echo '
						<div class="inner-page-title-container">
							<div class="inner-page-title fixed">
								<h2>'.$news_page->post_title.'</h2>
								<p>'.$news_page->post_excerpt.'</p>
							</div> 
						</div>';
					}
				}
			
			?>
		</div>
		
		<div class="hr"></div>
		
		<div class="row fixed">
			<div class="col-220 no-print">
				<?php
					ewf_setSection('zone-sidebar');
					if ( !function_exists('dynamic_sidebar')  || !dynamic_sidebar('sidebar-page') );
				?>
			</div>
			
			<div class="col-700 last">
					<div class="blog-post">
						<?php
						if ( have_posts() ) while ( have_posts() ) : the_post(); 										
							echo '<div class="news fixed">';
								echo '<p class="date">'.get_the_time('F jS, Y').'</p>';
								echo '<h3><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
								echo the_content();
							echo '</div>';
						endwhile; 
						?>
					</div>
					
					<?php
					
						if (get_option(EWF_SETUP_THNAME."_news_comments", "false") == 'true'){
							comments_template( '', true );
						}
						
					?>
			</div>
		</div>
		 
	</div>
	
<?php get_footer(); ?>