<?php get_header(); ?>

	<div id="content">

		<div class="row inner-page-title-container">
			<?php
				global $wp_query;
				echo '<h3>'.__('Blog', EWF_SETUP_THEME_DOMAIN).'</h3>';
			?>
		</div>
		
		<div class="row fixed">
			<div class="col-220">
				<?php
					ewf_setSection('zone-sidebar');
					if ( !function_exists('dynamic_sidebar')  || !dynamic_sidebar('sidebar-page') );
				?>
			</div>
			
			<div class="col-700 last">
					<div class="blog-post">
						<?php
						
						$src = null;
						
						if ( have_posts() ) while ( have_posts() ) : the_post(); 										
							$src .= '<div class="blog-post">';
								$src .= '<h3><a href="' . get_permalink() . '" rel="bookmark">'.get_the_title($post->ID).'</a></h3>' ;
								$src .= '<p>'.__('Posted by', EWF_SETUP_THEME_DOMAIN).':<strong>'.get_the_author().'</strong> | '.__('Posted on',EWF_SETUP_THEME_DOMAIN).': <strong>'.get_the_time('F jS, Y').'</strong> | <a href="'.get_comments_link().'">'.get_comments_number().' '.__('Comments', EWF_SETUP_THEME_DOMAIN).'</a></p>';
								
								$src .= get_the_content();
								
								$src .= '<p class="text-right"><a href="'.get_permalink().'">'.__('Read More', EWF_SETUP_THEME_DOMAIN).'</a></p>';
							$src .= '</div>';
							$src .= '<div class="hr-alt2"></div>';
							
						endwhile; 
						
						if ($wp_query->found_posts > $wp_query->query_vars['posts_per_page']){
							$src .= ewf_sc_blog_navigation($wp_query->query_vars['posts_per_page'], $wp_query);
							}
							
						echo $src;
						
						?>
					</div>
			</div>
		</div>
		 
	</div>
	
<?php get_footer(); ?>