<?php

	//@ini_set('pcre.backtrack_limit', 500000);
	
	add_shortcode("section", "ewf_sc_section");
	add_shortcode("clearfix", "ewf_sc_clearfix");
	add_shortcode("column", "ewf_sc_column");
	add_shortcode("col", "ewf_sc_column");
	
	add_shortcode("col160", "ewf_sc_column_160");
	add_shortcode("col220", "ewf_sc_column_220");
	add_shortcode("col340", "ewf_sc_column_340");
	add_shortcode("col460", "ewf_sc_column_460");
	add_shortcode("col700", "ewf_sc_column_700");
	
	
	$_ewf_current_column = array();
	$_ewf_current_section = array();
	
	function ewf_getColumn(){
		global $_ewf_current_column;
		global $_ewf_current_section;
		
		$column_width = 0;
		
		$current_column = $_ewf_current_column[count($_ewf_current_column)-1];
		
		
		$layout_styles = array(
			"03-layout-sidebar-single" => 235
		);
		
		
		switch($_ewf_current_section){
			case '03-layout-full':
				if ($current_column=="double"){
					$column_width = 590;
				}else{
					$column_width = 285;
				}
				break;
				
			case '02-layout-full':
				$column_width = 460;
				break;
		} 
		
		$layout_key = $_ewf_current_section;
		
		if (array_key_exists($_ewf_current_section, $layout_styles)){
			$column_width = $layout_styles[$layout_key];
		}
		
		if ($column_width==0 && $current_column>0 ) { $column_width = $current_column; }
		
		apply_filters("debug", "ewf_getColumn : [determined:".$column_width."] [read:".$current_column.']');	
		
		return $column_width;
	}
	
	function ewf_setColumn( $width=0 ){
		global $_ewf_current_column;
		
		apply_filters("debug", "ewf_setColumn : ".$width);
		
		$_ewf_current_column[] = $width;
	}
	
	
	function ewf_setZone( $width = 0 ){
		global $_ewf_current_column;
		
		apply_filters("debug", "setZone : ".$width);
		
		$_ewf_current_column[] = $width;
	}
	
	
	function ewf_setSection( $columns=0 ){
		global $_ewf_current_section;
		global $_ewf_current_column; 
		
		$_ewf_current_section = $columns;
		$_ewf_current_column = array() ; 
		apply_filters("debug", "setSection : ".$columns);
	}
	
	function ewf_sc_section ( $atts, $content = null){
		$src = null;
		
		$src.='<div class="row fixed">';
			$src .= do_shortcode($content);
		$src.='</div>';
		
		return $src;
	}	
	
	function ewf_sc_clearfix ( $atts, $content = null){
		$src = null;
		
		$src.='<div class="fixed">';
			$src .= do_shortcode($content);
		$src.='</div>';
		
		return $src;
	}
	
	function ewf_sc_section_old ( $atts, $content){
		global $post;
		
		$wp_metadata = get_post_custom();
		$wp_template = null;
		$src = null;
		
		if (array_key_exists('_erm-page-layout',$wp_metadata) && $wp_template == null){
			$wp_template = $wp_metadata['_erm-page-layout'][0];
		}
		
		if (array_key_exists('_wp_page_template', $wp_metadata) && $wp_template == null){
			$wp_template = $wp_metadata['_wp_page_template'][0];
		}
		
		$class = null;
		
		extract(shortcode_atts(array(
			"columns" => 2
		), $atts ));
		
		switch($wp_template){
			case 'page-contact.php':
				$class = "medColumns clearfix";
				break;
			
			default:
				$class = "columns-0".$columns." clearfix";
				break;		
		}
				
		$src.='<div class="row fixed">';
			//set section index
			ewf_setSection('0'.$columns.'-'.$wp_template);
		
			$src .= do_shortcode($content);
		$src.='</div>';
		
		return $src;
	}
	

	function ewf_sc_column_160( $atts, $content ){
		extract(shortcode_atts(array(
			"class" => null,
		), $atts));	
		
		$src = null;
		
		if (is_array($atts)){
			if (array_key_exists('0', $atts) && $atts[0]=='last' ||  array_key_exists('1', $atts) && $atts[1]=='last' && array_key_exists('2', $atts) && $atts[2]=='last'){
				$class.= ' last';
			}
		}
		
		$src.= '<div class="col-160 '.$class.'">';
			ewf_setColumn(160);
			$src.=do_shortcode($content);
		$src.='</div>';
		
		return $src;
	}
	
	function ewf_sc_column_220( $atts, $content ){
		extract(shortcode_atts(array(
			"class" => null,
		), $atts));	
		
		$src = null;
		
		if (is_array($atts)){
			if (array_key_exists('0', $atts) && $atts[0]=='last' ||  array_key_exists('1', $atts) && $atts[1]=='last' && array_key_exists('2', $atts) && $atts[2]=='last'){
				$class.= ' last';
			}
		}
		
		$src.= '<div class="col-220 '.$class.'">';
			ewf_setColumn(220);
			$src.=do_shortcode($content);
		$src.='</div>';
		
		return $src;

	}

	function ewf_sc_column_340( $atts, $content ){
		extract(shortcode_atts(array(
			"class" => null,
		), $atts));	
		
		$src = null;
		
		if (is_array($atts)){
			if (array_key_exists('0', $atts) && $atts[0]=='last' ||  array_key_exists('1', $atts) && $atts[1]=='last' && array_key_exists('2', $atts) && $atts[2]=='last'){
				$class.= ' last';
			}
		}
		
		$src.= '<div class="col-340 '.$class.'">';
			ewf_setColumn(340);
			$src.=do_shortcode($content);
		$src.='</div>';
		
		return $src;

	}
	
	function ewf_sc_column_460( $atts, $content ){
		extract(shortcode_atts(array(
			"class" => null,
		), $atts));	
		
		$src = null;
		
		if (is_array($atts)){
			if (array_key_exists('0', $atts) && $atts[0]=='last' ||  array_key_exists('1', $atts) && $atts[1]=='last' && array_key_exists('2', $atts) && $atts[2]=='last'){
				$class.= ' last';
			}
		}
		
		$src.= '<div class="col-460 '.$class.'">';
			ewf_setColumn(460);
			$src.=do_shortcode($content);
		$src.='</div>';
		
		return $src;
	}
	
	function ewf_sc_column_700( $atts, $content ){
		extract(shortcode_atts(array(
			"class" => null,
		), $atts));	
		
		$src = null;
		
		if (is_array($atts)){
			if (array_key_exists('0', $atts) && $atts[0]=='last' ||  array_key_exists('1', $atts) && $atts[1]=='last' && array_key_exists('2', $atts) && $atts[2]=='last'){
				$class.= ' last';
			}
		}
		
		$src.= '<div class="col-700 '.$class.'">';
			ewf_setColumn(700);
			$src .= do_shortcode($content);
		$src.='</div>';
		
		return $src;
	}
	
	function ewf_sc_column( $atts, $content ){
		extract(shortcode_atts(array(
			"width" => null,
			"class" => null,
		), $atts));
		
		$src = null;
		$size = array('160'=> null, '220'=> null, '460'=> null, '700'=>null);
		$class = null;
		
		if (array_key_exists('0', $atts) && $atts[0]=='last' ||  array_key_exists('1', $atts) && $atts[1]=='last' && array_key_exists('2', $atts) && $atts[2]=='last'){
			$class.= ' last';
		}
		
		if (array_key_exists($width, $size)){
			$src.= '<div class="col-'.$width.' '.$class.'">';
				ewf_setColumn($width);
				$src.=do_shortcode($content);
				
			$src.='</div>';
		}else {
			$src.= ewf_message('Error, column size not recognized');
		}
		
		return $src;
	}
	
	function ewf_message($msg, $reference = null){
		return '<div class="errormsg">'.$msg.'</div>';
	}
	
	if ( !function_exists('ewf_shortcode_fix') ) :
		function ewf_shortcode_fix($content) {
			$new_content = '';
			
			$pattern_full = '{(\[raw\].*?\[/raw\])}is';
			$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
			$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);
			
			foreach ($pieces as $piece) {
				if (preg_match($pattern_contents, $piece, $matches)) {
					$new_content .= $matches[1];
				} else {
					$new_content .= wptexturize(wpautop($piece));		
				}
			}
			
			return $new_content;
		}
		
		remove_filter('the_content', 'wpautop');
		remove_filter('the_content', 'wptexturize');

		add_filter('the_content', 'ewf_shortcode_fix', 99);
		add_filter('widget_text', 'ewf_shortcode_fix', 99);

	endif;

?>