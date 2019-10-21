<?php get_header(); ?>

	<div id="content">

		<div class="row fixed">
			<?php
			
				$blog_page_id = 0;
				$blog_page = get_option(EWF_SETUP_THNAME."_page_blog", null);
				
				if ($blog_page != null){
					$blog_page = get_page_by_title($blog_page);
					
					if (is_object($blog_page)){
						$blog_page_id = $blog_page->ID;
						}
				}
				
				if ($blog_page_id) {
					$blog_page = get_post($blog_page_id);  
					
					$ewf_header_image_id = ewf_getHeaderImageID($blog_page_id);
					$ewf_header_image = null;
					
					if ($ewf_header_image_id){
						$ewf_header_image = wp_get_attachment_image_src($ewf_header_image_id,'page-header');  
					}
					
					if ($ewf_header_image){
						echo '
						<div class="inner-page-title-container">
							<img src="'.$ewf_header_image[0].'" width="940" height="220" alt="" />
							<div class="inner-page-title fixed">
								<h2>'.$blog_page->post_title.'</h2>
								<p>'.$blog_page->post_excerpt.'</p>
							</div>
						</div>';
					}else{
						echo '
						<div class="inner-page-title-container">
							<div class="inner-page-title fixed">
								<h2>'.$blog_page->post_title.'</h2>
								<p>'.$blog_page->post_excerpt.'</p>
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
							echo'<h3><a href="' . get_permalink() . '" rel="bookmark">'.get_the_title($post->ID).'</a></h3>' ;
							echo '<p>'.__('Posted by', EWF_SETUP_THEME_DOMAIN).': <strong>'.get_the_author().'</strong> | '.__('Posted on', EWF_SETUP_THEME_DOMAIN).': <strong>'.get_the_time('F jS, Y').'</strong> | <a href="#">'.get_comments_number().' '.__('Comments', EWF_SETUP_THEME_DOMAIN).'</a></p>';
								
							echo the_content();
						endwhile; 
						?>
					</div>
					
					<?php comments_template( '', true ); ?>
			</div>
		</div>
		 
	</div>
	
<?php get_footer(); ?>