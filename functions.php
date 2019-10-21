<?php


	define( 'EWF_SETUP_PAGE'			, 'functions.php');			//* page containing setup
	
	define( 'EWF_SETUP_THEME_DOMAIN'	, 'publimedia');			//* translation domain
	define( 'EWF_SETUP_THNAME'			, 'bitpub');				//* theme options short name
	define( 'EWF_SETUP_TITLE'			, 'Presenter Setup');		//* wordpress menu title
	
	
	load_theme_textdomain( EWF_SETUP_THEME_DOMAIN, TEMPLATEPATH.'/_lang/' );
	$locale_file = TEMPLATEPATH . "/_lang/".get_locale().".php";
	if ( is_readable( $locale_file ) ) require_once( $locale_file );
	
	
	include_once ('_admin/functions-setup.php');
	include_once ('_admin/functions-menus.php');
	include_once ('_admin/functions-shortcodes.php');
	include_once ('_admin/functions-shortcodes-columns.php');
	include_once ('_admin/functions-type-project.php');
	include_once ('_admin/functions-type-slide.php');
	include_once ('_admin/functions-type-news.php');
	include_once ('_admin/functions-options.php');
	include_once ('_admin/functions-layout.php');
	include_once ('_admin/functions-page-header.php');
	include_once ('_admin/functions-sidebars.php');
 
	ewf_setup_firstrun();
 
?>