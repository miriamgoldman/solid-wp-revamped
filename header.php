<?php  
	global $doctype; 
	global $class; 
	?>
<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	
	<title><?php echo get_bloginfo('name');?> | <?php echo the_title();?></title>
	

	<?php wp_head(); ?>
</head>
<body <?php body_class($class); ?>> 
	<div id="wrap">
		
		<div id="header">
		
			<div class="row dropdown-container fixed">
			
				<div class="col-220">
				<a href="<?php echo get_bloginfo('url');?>">
					<?php
					if ( function_exists( 'the_custom_logo' ) ) {
 						the_custom_logo();
					}
					?>
				</a>

					
				
				</div><!-- end .col-220 -->	
				<div class="col-700 last">

			
					<?php
						$walker = new My_Walker;
						
						wp_nav_menu( array( 
						'theme_location' => 'top-menu',
						'menu_id' => 'dropdown-menu'
						)); 
					?>
				</div><!-- end .col-700 -->	
								
			</div><!-- end .row -->
			<div class="row">
			 <div class="site-tagline">
					<?php echo get_bloginfo('description'); ?>
				</div>	
			</div>
			
			<div class="hr"></div>		
		</div><!-- end #header -->
	