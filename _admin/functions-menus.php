<?php


	if ( function_exists( 'register_nav_menus' ) ) {
		register_nav_menus(
			array(
			  'top-menu' => __('Top Menu',EWF_SETUP_THEME_DOMAIN),
			)
		);
	}


	class My_Walker extends Walker_Nav_Menu
	{
		function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
			global $wp_query;
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			$current_url = strtolower($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
			$item_url = str_replace(array('http://', 'https://'),'',strtolower($item->url));
			

			if ($item_url==$current_url){ 
				$class_selection = 'class="current"'; 
			}else{ 
				$class_selection = ''; 
			}
			
			$output .= $indent . '<li id="menu-item-'. $item->ID . '" '.$class_selection.'>';
		
			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
			$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
			$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
			$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
			
			$item_output = $args->before;
			$item_output .= '<a'. $attributes .'>';
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ). $args->link_after;
			$item_output .= '</a>';
			$item_output .= $args->after;

			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}

	class My_Walker_Footer extends Walker_Nav_Menu
	{
		function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
			global $wp_query;
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			$current_url = strtolower($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
			$item_url = str_replace(array('http://', 'https://'),'',strtolower($item->url));
			
			if ($item_url==$current_url){ 
				$class_selection = 'class="selected"'; 
			}else{ 
				$class_selection = ''; 
			}
			
			$output .= $indent . '<li id="menu-item-'. $item->ID . '" '.$class_selection.'>';
		
			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
			$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
			$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
			$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

			$item_output .= '<a'. $attributes .'>';
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= '</a>';

			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}

?>