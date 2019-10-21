<?php


	if (function_exists('register_sidebar')){

		
		/** Footer sidebar
		 **/
		register_sidebar(array('id' => 'footer-left', 'name' => __('Footer Widget 1',EWF_SETUP_THEME_DOMAIN), 'description'   => __('In the footer the left column',EWF_SETUP_THEME_DOMAIN),'before_title'  => '<p><strong>','after_title'   => '</strong></p>','before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget'  => '</div>' ));
		register_sidebar(array('id' => 'footer-center-left', 'name' => __('Footer Widget 2',EWF_SETUP_THEME_DOMAIN), 'description'   => __('In the footer the center left column',EWF_SETUP_THEME_DOMAIN),'before_title'  => '<p><strong>','after_title'   => '</strong></p>', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget'  => '</div>' ));
		register_sidebar(array('id' => 'footer-center-right', 'name' => __('Footer Widget 3',EWF_SETUP_THEME_DOMAIN), 'description'   => __('In the footer the center right column',EWF_SETUP_THEME_DOMAIN),'before_title'  => '<p><strong>','after_title'   => '</strong></p>', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget'  => '</div>' ));
		register_sidebar(array('id' => 'footer-right', 'name' => __('Footer Widget 4',EWF_SETUP_THEME_DOMAIN), 'description'   => __('In the footer the left column',EWF_SETUP_THEME_DOMAIN),'before_title'  => '<p><strong>','after_title'   => '</strong></p>', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget'  => '</div>' ));
	
		/**	Header Widget
		 **/
		register_sidebar(array('id' => 'header-right', 'name' => __('Header Widget',EWF_SETUP_THEME_DOMAIN), 'description'   => __('In the footer the left column',EWF_SETUP_THEME_DOMAIN),'before_title'  => null, 'after_title' => null, 'before_widget' => null, 'after_widget' => null ));
		
		
		/**	Page Sidebars
		 **/
		register_sidebar(array('id' => 'sidebar-page', 'name' => __('Sidebar page',EWF_SETUP_THEME_DOMAIN), 'description'   => __('Page sidebar',EWF_SETUP_THEME_DOMAIN),'before_title'  => '<h4>','after_title'   => '</h4>', 'before_widget' => '<div id="%1$s" class="widget list-nav %2$s">', 'after_widget'  => '</div><br/>' ));

	}

?>