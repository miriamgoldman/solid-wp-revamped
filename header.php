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
	
		<noscript>
			<link href="<?php echo get_template_directory_uri(); ?>/style-nojs.css" rel="stylesheet" type="text/css" /> 
			<div class="nojs-warning"><strong><?php _e('JavaScript seems to be Disabled!', EWF_SETUP_THEME_DOMAIN); ?></strong> <?php  _e('Some of the website features are unavailable unless JavaScript is enabled.', EWF_SETUP_THEME_DOMAIN); ?></div>
		</noscript>
		
		<div id="header">
		<!-- ///   HEADER   /////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
		
			<div class="row dropdown-container fixed">
			
				<div class="col-220">
				
					<?php 
						if (get_option(EWF_SETUP_THNAME."_logo_text",'true') == 'true'){
							$logo_title = get_option(EWF_SETUP_THNAME."_logo_title", 'Solid');
							
							echo '<h3 class="logo"><a href="'.get_bloginfo('url').'" title="'.__('Back Home', EWF_SETUP_THEME_DOMAIN).'" id="logo" >'.$logo_title.'</a></h3>';
						}else{
							if (get_option(EWF_SETUP_THNAME."_logo_url",null) != null){
								$logo_url = get_option(EWF_SETUP_THNAME."_logo_url");
							}else{
								$logo_url = get_template_directory_uri().'/_layout/images/logo.png';
							}
							
							echo '<a href="'.get_bloginfo('url').'" title="'.__('Back Home', EWF_SETUP_THEME_DOMAIN).'" id="logo"><img src="'.$logo_url.'" alt="" /></a>';
						}
					?>
				
				</div><!-- end .col-220 -->	
				<div class="col-700 last">

					<div class="text-right header-widget">
						<?php if ( !function_exists('dynamic_sidebar')  || !dynamic_sidebar('header-right') );  ?>
					</div>
					<?php
						$walker = new My_Walker;
						
						wp_nav_menu( array( 
						'theme_location' => 'top-menu',
						'menu_id' => 'dropdown-menu',
						'walker' => $walker			)); 
					?>
				</div><!-- end .col-700 -->	
				
			</div><!-- end .row -->
			
			<div class="hr"></div>

		<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
		
		</div><!-- end #header -->
	