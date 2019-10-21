<?php
	//add_action('admin_menu', 'ewf_setup_options');
	add_action('admin_menu', 'ewf_setup_request');
	add_action('wp_head', 'ewf_append_analytics_code');
	add_action('wp_head', 'ewf_append_css_code');
	
	
	$_ewf_skins = ewf_load_skins();
	
	$options = array (
		array("type" => "layout", "mode"=>"open"),
		
		array("type" => "full-panel", "mode"=>"open"),
			
			array("type" => "tabs-bar", "mode"=>"open"),
				array("type" => "tab", "id"=>'tab_ct_01', "name"=>__("General",EWF_SETUP_THEME_DOMAIN), 'selected'=>'true'),
				array("type" => "tab", "id"=>'tab_ct_02',"name"=>__("Homepage", EWF_SETUP_THEME_DOMAIN), 'selected'=>'false'),
				array("type" => "tab", "id"=>'tab_ct_04',"name"=>__("Includes", EWF_SETUP_THEME_DOMAIN), 'selected'=>'false'),
				array("type" => "tab", "id"=>'tab_ct_05',"name"=>__("Newsletter", EWF_SETUP_THEME_DOMAIN), 'selected'=>'false'),
			array("type" => "tabs-bar", "mode"=>"close", 'selected'=>'false'),
			
		array("type" => "full-panel", "mode"=>"content"),
			
			/**
			*
			*	General settings
			*
			**/
			array("type" => "panel", "name" => "Home page", "mode"=>"open" , "current"=> true, "tab" => "tab_ct_01"),
					
				array(    "type" => "input-skins", 
							"id" => EWF_SETUP_THNAME."_theme_skin",
				 "section-title" => __('Choose the theme color',EWF_SETUP_THEME_DOMAIN),
					   "options" => $_ewf_skins['options'],
		   "section-description" => __('Solid comes with a default theme.', EWF_SETUP_THEME_DOMAIN),
						   "std" => "Default",
						  ),
						  
				array(      "id" => EWF_SETUP_THNAME."_cufon",
				 "section-title" => __('Cufon Fonts',EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __('You can activate or deactivate cufon.',EWF_SETUP_THEME_DOMAIN),
						 "label" => __('Use Cufon fonts',EWF_SETUP_THEME_DOMAIN),
						  "type" => "checkbox",
						   "std" => "true"),
						  
					array(      "id" => EWF_SETUP_THNAME."_logo_text",
					 "section-title" => __("Use Text ",EWF_SETUP_THEME_DOMAIN),
			   "section-description" => __("You can use text instead of images in the logo.",EWF_SETUP_THEME_DOMAIN),
							 "label" => __("Use text in logo",EWF_SETUP_THEME_DOMAIN),
							  "type" => "checkbox",
							   "std" => "false"),
							   							   
					array(    "type" => "text", 
								"id" => EWF_SETUP_THNAME."_logo_title",
					 "section-title" => __("Logo title",EWF_SETUP_THEME_DOMAIN),
			   "section-description" => __("Please type the value of logo text.",EWF_SETUP_THEME_DOMAIN),
							   "std" => 'Solid',
							  ),
							  
					array(    "type" => "text", 
								"id" => EWF_SETUP_THNAME."_logo_url",
					 "section-title" => __("Logo image",EWF_SETUP_THEME_DOMAIN),
			   "section-description" => __("Please type the url of the logo.",EWF_SETUP_THEME_DOMAIN),
							   "std" => get_template_directory_uri().'/_layout/images/logo.png',
							  ),
							  
						  
					array(      "id" => EWF_SETUP_THNAME."_news_comments",
					 "section-title" => __("News comments ",EWF_SETUP_THEME_DOMAIN),
			   "section-description" => __("Allow users to comment on news.",EWF_SETUP_THEME_DOMAIN),
							 "label" => __("Use comments",EWF_SETUP_THEME_DOMAIN),
							  "type" => "checkbox",
							   "std" => "false"),
							  
					array(    "type" => "text", 
								"id" => EWF_SETUP_THNAME."_contact_mail",
					 "section-title" => __("Contact mail",EWF_SETUP_THEME_DOMAIN),
			   "section-description" => __("Add an e-mail addres to receive mails sent by contact form.",EWF_SETUP_THEME_DOMAIN),
							   "std" => null,
							  ),
							  
					array(    "type" => "text", 
								"id" => EWF_SETUP_THNAME."_maps_api_key",
					 "section-title" => __("Maps API Key",EWF_SETUP_THEME_DOMAIN),
			   "section-description" => __("Please add the API Key obtained from google maps.",EWF_SETUP_THEME_DOMAIN),
							   "std" => null,
							  ),

				array(    "type" => "select", 
							"id" => EWF_SETUP_THNAME."_page_blog",
				 "section-title" => __("Blog page",EWF_SETUP_THEME_DOMAIN),
					   "options" => ewf_load_site_pages(
							array(
								get_option(EWF_SETUP_THNAME."_page_news", null)=>0, 
								get_option(EWF_SETUP_THNAME."_page_portfolio", null)=>0
								)),
		   "section-description" => __("Please add the blog page so every post will have the blog's header image.",EWF_SETUP_THEME_DOMAIN),
						   "std" => null,
						  ),

				array(    "type" => "select", 
							"id" => EWF_SETUP_THNAME."_page_news",
				 "section-title" => __("News page",EWF_SETUP_THEME_DOMAIN),
					   "options" => ewf_load_site_pages(
							array(
								get_option(EWF_SETUP_THNAME."_page_blog", null)=>0, 
								get_option(EWF_SETUP_THNAME."_page_portfolio", null)=>0
								)),
		   "section-description" => __("Please add the news page so every news post will have the news page header image.",EWF_SETUP_THEME_DOMAIN),
						   "std" => null,
						  ),
						  				
				array(    "type" => "select", 
							"id" => EWF_SETUP_THNAME."_page_portfolio",
				 "section-title" => __("Portfolio page",EWF_SETUP_THEME_DOMAIN),
					   "options" => ewf_load_site_pages(
							array(
								get_option(EWF_SETUP_THNAME."_page_news", null)=>0, 
								get_option(EWF_SETUP_THNAME."_page_blog", null)=>0
								)),
		   "section-description" => __("Please add the portfolio page so every project will have the portfolio's header image.",EWF_SETUP_THEME_DOMAIN),
						   "std" => null,
						  ),
						  
				array(    "type" => "select", 
							"id" => EWF_SETUP_THNAME."_portfolio_taxonomy_view",
				 "section-title" => __("Portfolio service layout",EWF_SETUP_THEME_DOMAIN),
					   "options" => array('1 Column', '3 Columns'),
		   "section-description" => __("Please choose the portfolio section layout.",EWF_SETUP_THEME_DOMAIN),
						   "std" => '3 Columns',
						  ),
							  
			array("type" => "panel", "mode"=>"close"),
		
		
			/**
			*   
			*	Newsletter settings
			*   
			**/
			array("type" => "panel", "name" => "Includes", "mode"=>"open" , "tab" => "tab_ct_05"),
							  
					array(    "name" => "E-mails list",
								"id" => EWF_SETUP_THNAME."_newsletter_mails",
					 "section-title" => __("E-mails",EWF_SETUP_THEME_DOMAIN),
			   "section-description" => __("Here are the e-mails collected using the newsletter submit form.", EWF_SETUP_THEME_DOMAIN),
							   "std" => "",
							  "type" => "showbox"),
							  							  
			array("type" => "panel", "mode"=>"close"),
					
		
			/**
			*   
			*	Includes settings
			*   
			**/
			array("type" => "panel", "name" => "Includes", "mode"=>"open" , "tab" => "tab_ct_04"),
							  
					array(    "type" => "textarea", 
								"id" => EWF_SETUP_THNAME."_include_analytics",
					 "section-title" => __('Google Analytics',EWF_SETUP_THEME_DOMAIN),
			   "section-description" => __('Paste the analytics code ',EWF_SETUP_THEME_DOMAIN),
							   "std" => null ,
							  ),
							  
					array(    "type" => "textarea", 
								"id" => EWF_SETUP_THNAME."_include_css",
					 "section-title" => __('Extra CSS Code',EWF_SETUP_THEME_DOMAIN),
			   "section-description" => __('Paste extra css code here',EWF_SETUP_THEME_DOMAIN),
							   "std" => null,
							  ),
							  
			array("type" => "panel", "mode"=>"close"),
			
			

			/**
			*
			*	Homepage Settings
			*
			**/
			array("type" => "panel", "name" => __('Homepage',EWF_SETUP_THEME_DOMAIN), "mode"=>"open", "tab" => "tab_ct_02",),			   
			
					array(      "id" => EWF_SETUP_THNAME."_slider_home",
					 "section-title" => __('Homepage slider',EWF_SETUP_THEME_DOMAIN),
			   "section-description" => __('You can activate or deactivate the homepage slider.',EWF_SETUP_THEME_DOMAIN),
							 "label" => __('Show slider on home page',EWF_SETUP_THEME_DOMAIN),
							  "type" => "checkbox",
							   "std" => "true"),
								  
					array(      "id" => EWF_SETUP_THNAME."_slider_text",
					 "section-title" => __('Slider text',EWF_SETUP_THEME_DOMAIN),
			   "section-description" => __('You can activate or deactivate the slider text from the bottom.',EWF_SETUP_THEME_DOMAIN),
							 "label" => __('Show text on slides',EWF_SETUP_THEME_DOMAIN),
							  "type" => "checkbox",
							   "std" => "true"),
											   
					array(      "id" => EWF_SETUP_THNAME."_slider_link",
					 "section-title" => __('Slides link',EWF_SETUP_THEME_DOMAIN),
			   "section-description" => __('You can add links to slides.',EWF_SETUP_THEME_DOMAIN),
							 "label" => __('Add links',EWF_SETUP_THEME_DOMAIN),
							  "type" => "checkbox",
							   "std" => "true"),
							   
					array(    "type" => "text", 
								"id" => EWF_SETUP_THNAME."_slider_timeout",
					 "section-title" => __('Slides delay',EWF_SETUP_THEME_DOMAIN),
			   "section-description" => __('Milliseconds between slide transitions <br/>(0 to disable auto advance).', EWF_SETUP_THEME_DOMAIN),
							   "std" => "5000",
							  ),
						   
			array("type" => "panel", "mode"=>"close"),
			

		
		array("type" => "full-panel", "mode"=>"close"),
		array("type" => "layout", "mode"=>"close"),
	);
	
	
	function ewf_setup_firstrun() {
		global $options;
		
		if (get_option(EWF_SETUP_THNAME."_firstrun", false) == false){
			foreach ($options as $value) {
				if (($value['type']=='textarea' || $value['type']=='text' || $value['type']=='checkbox' || $value['type']=='select')) {
					update_option( $value['id'], $value['std'] ); 
				}
			} 
			
			update_option(EWF_SETUP_THNAME."_firstrun",true);
		}
	}
	
	function ewf_setup_request() {
		global $options, $_ewf_skins;
		
		$currentSession = $options;
		
		if ( array_key_exists('page', $_GET) && $_GET['page'] == EWF_SETUP_PAGE) {
			if ( array_key_exists('save', $_REQUEST) ) {
				foreach ($options as $value) {
				
					if (($value['type']=='textarea' || $value['type']=='text' || $value['type']=='input-skins' || $value['type']=='checkbox' || $value['type']=='select') && array_key_exists($value['id'], $_REQUEST) ) {
						if ($value['type']=='checkbox' && $_REQUEST[ $value['id'] ]=='on') { $_REQUEST[ $value['id'] ]='true'; }
						update_option( $value['id'], $_REQUEST[ $value['id'] ] ); 					
					}else{
						if ($value['type']=='checkbox'){
							update_option( $value['id'], 'false' ); 
						}
					}
				}
			} else if( array_key_exists('reset', $_REQUEST)) {
				foreach ($options as $value) {
					if (($value['type']=='textarea' || $value['type']=='text' || $value['type']=='checkbox' || $value['type']=='select')) {
						update_option( $value['id'], $value['std'] ); 
					}
				} 

				header("Location: themes.php?page=functions.php");
			}else if(array_key_exists('install', $_REQUEST)){
				foreach ($options as $value) {
					if (($value['type']=='textarea' || $value['type']=='text' || $value['type']=='checkbox' || $value['type']=='select')) {
						update_option( $value['id'], $value['std'] ); 
					}
				}
			}
			
		}
	
	
		$icon_path = null; //get_bloginfo( 'template_directory' ).'/setup/images/icon.png';
		add_admin_menu_separator(29);
		
		header('EWF_SETUP_TITLE:'.EWF_SETUP_TITLE);
		header('EWF_SETUP_PAGE:'.EWF_SETUP_PAGE);

		add_menu_page('EWF Admin'	, __('Theme Options', EWF_SETUP_THEME_DOMAIN)	, 'edit_themes' , EWF_SETUP_PAGE	, 'ewf_setup_options'	, $icon_path, 30);
	}
	
	function ewf_setup_options() {
		global $options, $_ewf_skins;
		$count_tabs = 0;

		if ( array_key_exists('saved', $_REQUEST)){ 
			echo '<div id="message" class="updated fade"><p><strong>'.__('Event Framework - Settings saved.',EWF_SETUP_THEME_DOMAIN).'</strong></p></div>';
			}
			
		if ( array_key_exists('reset', $_REQUEST)){ 
			echo '<div id="message" class="updated fade"><p><strong>'.__('Event Framework - Settings reset.',EWF_SETUP_THEME_DOMAIN).'</strong></p></div>';
			}

		if ( array_key_exists('install', $_REQUEST)){ 
			echo '<div id="message" class="updated fade"><p><strong>'.__('Event Framework - The theme has been installed!',EWF_SETUP_THEME_DOMAIN).'</strong></p></div>';
			}

			
		echo '<div id="setup"><form method="post" >';
					
		foreach ($options as $value) {
			switch ( $value['type'] ) {
					
				case "tab": 
					if ($value['selected']=='true'){
						echo '<li id="'.$value['id'].'" class="current"><a href="#">'.$value['name'].'</a></li>';
					}else{
						echo '<li id="'.$value['id'].'" ><a href="#">'.$value['name'].'</a></li>';
					}
					break;
					
					
				case "full-panel": 
					if ($value['mode']=="open"){
						echo '<div class="full-panel clfixed">';
					}
								
					if ($value['mode']=="content"){
						echo '<div class="full-content clfixed">';
					}
					
					if ($value['mode']=="close"){
						echo '</div></div>';
					}
					
					break;
					
				case "layout": 
					if ($value['mode']=="open"){
						echo '
							<div id="outer-wrap" class="ewf-setup">

								<div id="wrap" class="clfixed">

									<div id="header" class="clfixed">
									<!-- ///   HEADER   /////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
									
										<h3>Solid Wordpress<br /> Template Options Panel</h3>
									
										<div class="hr-2"></div>

										<div class="row clfixed">
										
											<div class="col-300">
											
												<p>Version :<strong>1.0.0</strong></p>
											
											</div><!-- end .col-300 -->	
											<div class="col-300 text-right last">

												<input name="save" type="submit" style="cursor:pointer" value="Save Changes" /> / 
												<input type="hidden" name="action" value="save" />
												
												<input name="reset" type="submit" style="cursor:pointer" value="Reset Changes" />
											
											</div><!-- end .col-300 -->	
											
										</div><!-- end .row -->

									<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
									
									</div><!-- end #header -->
									<div id="content">
						';
					}
					
					if ($value['mode']=="close"){
						echo '
								<div class="hr"></div>

							</div><!-- end #wrap -->

						</div>	
						';
					}
					break;
					
				case "tabs-bar": 
					if ($value['mode']=="open"){
						echo '<ul class="tabs clfixed">';
					}
					
					if ($value['mode']=="close"){
						echo '</ul>';
					}
					break;
					
				case "panel": 
					if ($value['mode']=="open"){
					/*
					*/
						$extra = null;
						if (array_key_exists('current', $value)){
							$extra = ' current ';
						}
					
						echo '<div class="panel '.$extra.$value['tab'].' clfixed">
								<!--<div class="panel-bar"><div><div><div class="controls"></div></div></div></div>-->
								<div class="panel-content">';
					}
					
					if ($value['mode']=="close"){
					/*
					*/
						echo '</div></div>';
					}
					break;

				case "open": 
					echo '<div class="section">';
					break;


				case "close":
					echo '</div>';
					break;

					
				case "label":
					echo '<label>'.$value['name'].'</label>';
					break;

					
				case "title":
					echo '<h2>'.$value['name'].'</h2>';
					break;
				
				
				case "maintitle":
					echo '<div style="display:block;background:url('.bloginfo('template_directory').'/images/adminheader.jpg) no-repeat bottom left #1f628c;height:60px;margin:10px 0;"></div>';
					echo $value['name'];
					break;

					
				case "titleWithSaveButton":
					//echo '<h2><span>'.$value['name'].'</span><input name="save" type="submit" value="Save changes" /></h2><div class="inner">';
					break;

					
					
				case 'text':
					$textVal = '';
					if ( get_option( $value['id'] ) != "") {  $textVal = stripslashes(get_option( $value['id'] ));  } else {  $textVal = $value['std']; }
					
					echo '<div class="bordered clfixed">
							<div class="col-220">
								<h4>'.$value['section-title'].'</h4>
								<p><em>'.$value['section-description'].'</em></p>
							</div>
							<div class="col-340 last">
								<input style="border:1px solid #CCCCCC;padding:4px;" name="'.$value['id'].'" id="'.$value['id'].'" type="'.$value['type'].'" value="'.$textVal.'"/>							
							</div>
						  </div>';
					break;

					
				case 'textarea':
					echo '<div class="bordered clfixed">
							<div class="col-220">
								<h4>'.$value['section-title'].'</h4>
								<p><em>'.$value['section-description'].'</em></p>
							</div>
						  <div class="col-340 last">
							<textarea style="border:1px solid #CCCCCC;padding:4px;" name="'.$value['id'].'" type="'.$value['type'].'" cols="" rows="">';
								if ( get_option( $value['id'] ) != "") { 
									echo stripslashes(get_option($value['id']) ); 
								} else { 
									echo $value['std']; 
								}
					echo '</textarea>
						   </div>
						</div>';
					break;
					
				case 'showbox':
					echo '<div class="bordered clfixed">
							<div class="col-220">
								<h4>'.$value['section-title'].'</h4>
								<p><em>'.$value['section-description'].'</em></p>
							</div>
						  <div class="col-340 last">';
							echo '<textarea style="border:1px solid #CCCCCC;padding:4px;" cols="" rows="15">';
								if ( get_option( $value['id'] ) != "") { 
									$list = unserialize(get_option($value['id']));
									$list = array_reverse($list, true);
									
									if (is_array($list)){
										foreach($list as $key=>$item){
											echo $item.',';
										}
									}else{
										echo __('No e-mails for the moment.',EWF_SETUP_THEME_DOMAIN);
									}
								}else{
									echo __('No e-mails for the moment.',EWF_SETUP_THEME_DOMAIN);
								}
							echo '</textarea>';
					echo '</div>
						</div>';
					break;

					
				case 'input-skins':
					echo '<div class="bordered clfixed">
							<div class="col-220">
								<h4>'.$value['section-title'].'</h4>
								<p><em>'.$value['section-description'].'</em></p>
							</div>
						    <div class="col-340 last">';
							
							$css_title = get_option( $value['id']);
							$css_file = $_ewf_skins['full'][$css_title];
							
							/*
							echo '<pre>';
								print_r($_ewf_skins['full']);
								echo '<br>Title:'.$css_title;
							echo '</pre> <div>Current css:['.$css_file.']</div>';
							
							$found = false;
							*/
							
							echo '<select name="'.$value['id'].'" id="'.$value['id'].'">';
								foreach ($value['options'] as $key => $option) {
									echo '<option';
										if ( get_option( $value['id'] ) == $option) { 
											echo ' selected="selected"'; 
										}
									echo '>'.$option.'</option>';
								}
							echo '</select>';
					echo '</div>
						</div>';
					break;
					
				case 'select':
					echo '<div class="bordered clfixed">
							<div class="col-220">
							<h4>'.$value['section-title'].'</h4>
							<p><em>'.$value['section-description'].'</em></p>
						  </div>';
						
					echo '<div class="col-340 last">';
						echo '<select name="'.$value['id'].'" id="'.$value['id'].'">';
							foreach ($value['options'] as $key => $option) {
								echo '<option';
									if ( get_option( $value['id'] ) == $option) { 
										echo ' selected="selected"'; 
									}
								echo '>'.$option.'</option>';
							}
						echo '</select>';
					echo '</div></div>';
					break;

					
				case "checkbox":
					$currentVal = get_option($value['id']);
					
					if ($currentVal=='true'){
						$checked = " checked ";
					}else{ 
						$checked = "";
					}
					
					echo '<div class="bordered clfixed">
							<div class="col-220">
							<h4>'.$value['section-title'].'</h4>
							<p><em>'.$value['section-description'].'</em></p>
						  </div>
						  <div class="col-340 last">
							 <input type="checkbox" name="'.$value['id'].'" id="'.$value['id'].'" '.$checked.' />
							 <label>'.$value['label'].'</label>
						  </div></div>';
					break;
			}
		}
		
			//echo '<input name="save" type="submit" value="'.__('Save changes',EWF_SETUP_THEME_DOMAIN).'" />';
			//echo '<input type="hidden" name="action" value="save" />';
		echo '</form>';
		
		/*
		echo '<form method="post">';
			echo '<input  style="right:120px;" name="reset" type="submit" value="',__('Reset',EWF_SETUP_THEME_DOMAIN).'" />';
			echo '<input type="hidden" name="action" value="reset" />';
		echo '</form>';
		*/
	}

	function add_admin_menu_separator($position) {
	  global $menu;
	  $index = 0;
	  
	  foreach($menu as $offset => $section) {
		if (substr($section[2],0,9)=='separator')
		  $index++;
		if ($offset>=$position) {
		  $menu[$position] = array('','read',"separator{$index}",'','wp-menu-separator');
		  break;
		}
	  }
	  
	}
	
	function ewf_append_analytics_code (){
		$analytics_code = stripslashes_deep(get_option(EWF_SETUP_THNAME."_include_analytics",null));
		
		if ( $analytics_code != null){ 
			echo '<script  type="text/javascript">';
				echo $analytics_code;
			echo '</script>';
		
		}
	}
	
		
	function ewf_append_css_code (){
		$css_code = stripslashes_deep(get_option(EWF_SETUP_THNAME."_include_css",null));
		
		if ( $css_code != null){ 
			echo '<style>';
				echo $css_code;
			echo '</style>';
		}
	}
	
	function ewf_current_skin(){
		global $_ewf_skins;
		
		$css_title = get_option( EWF_SETUP_THNAME."_theme_skin", 'Default' );
		$css_file = $_ewf_skins['full'][$css_title];
		
		return $css_file;
	}
	
	function ewf_load_skins(){
		$themeSkins_full = array();
		$themeSkins_opt = array();
		$themePath = TEMPLATEPATH.'/_skins/';
		
		$dir = opendir($themePath);
		while ($dir && ($file = readdir($dir)) !== false) {
			if (strtolower(pathinfo($file, PATHINFO_EXTENSION))== "css"){
				$skinName = str_replace(array('-', '_', '#'), ' ', pathinfo($file, PATHINFO_FILENAME));
				$skinName = ucwords(strtolower($skinName));
				
				$themeSkins_full[$skinName] = $file;
				$themeSkins_opt[] = $skinName;
		  }
		}
		
		apply_filters("debug", "PATH: ".$themePath);
		
		foreach($themeSkins_full as $key=>$value){
			apply_filters("debug", "Skin: $key - ".$value);
		} 
		
		return array('full'=>$themeSkins_full, 'options'=>$themeSkins_opt);

	}
	
	function ewf_load_site_pages($exclude = null){
		$pages_list = get_pages();
		$pages_return = array();
		
		$pages_return[] = __('Select page',EWF_SETUP_THEME_DOMAIN);
		
		if (is_array($exclude)){
			foreach($pages_list as $current_page){
				if (!array_key_exists($current_page->post_title, $exclude)){
					$pages_return[] = $current_page->post_title;
				}
			}
		}else{
			foreach($pages_list as $current_page){
				$pages_return[] = $current_page->post_title;
			} 
		}
		
		return $pages_return;
	}
?>