<?php
$bk = get_option('bk');
add_action( 'after_setup_theme', 'vp_setup' );
if ( ! function_exists( 'vp_setup' ) ){
	function vp_setup(){
		global $bk;
		require get_template_directory() . '/Panel/custom-functions.php';
		require get_template_directory() . '/includes/shortcodes.php';
		require get_template_directory() . '/includes/additional_functions.php';
		load_theme_textdomain('bk', get_template_directory() . '/languages');
		require 'Panel/nhp-options.php';
	}
}
// Loading js files into the theme
add_action('wp_head', 'vp_scripts');
if ( !function_exists('vp_scripts') ) {
	function vp_scripts() {
		global $bk;
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'custom', get_template_directory_uri() . '/js/custom-min.js', array('jquery'), '',true);
	}

}

//Loading the CSS files into the theme
add_action('wp_enqueue_scripts', 'vp_load_css');
if( !function_exists('vp_load_css') ) {
	function vp_load_css() {
		global $bk;
		wp_enqueue_style( 'main', get_template_directory_uri() . '/css/main-min.css');
	}
}

// Clean up the <head>
	function removeHeadLinks() {
			remove_action('wp_head', 'rsd_link');
			remove_action('wp_head', 'wlwmanifest_link');
		}
		add_action('init', 'removeHeadLinks');
		remove_action('wp_head', 'wp_generator');

if ( ! isset( $content_width ) ) $content_width = 960;

function encEmail ($orgStr) {
		$encStr = "";
		$nowStr = "";
		$rndNum = -1;

		$orgLen = strlen($orgStr);
		for ( $i = 0; $i < $orgLen; $i++) {
				$encMod = rand(1,2);
				switch ($encMod) {
				case 1: // Decimal
						$nowStr = "&#" . ord($orgStr[$i]) . ";";
						break;
				case 2: // Hexadecimal
						$nowStr = "&#x" . dechex(ord($orgStr[$i])) . ";";
						break;
				}
				$encStr .= $nowStr;
		}
		return $encStr;
}

function register_menus() {
	register_nav_menus( array(
					'main-menu' => 'Main Menu',
					'service-menu' => 'Service menu',
					'about-menu' => 'About menu',
					'team-menu' => 'Team menu',
					'footer-menu' => 'Footer menu',
					'mobile-menu' => 'Mobile menu',
					)
						);
}
add_action('init', 'register_menus');

class secondary_walker extends Walker_Nav_Menu
{
			function start_el(&$output, $item, $depth, $args)
			{
					 global $wp_query;
					 $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

					 $class_names = $value = '';

					 $classes = empty( $item->classes ) ? array() : (array) $item->classes;

					 $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
					 $class_names = ' class="'. esc_attr( $class_names ) . '"';

					 $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .' data-index="item'. $item->ID . '">';

					 $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
					 $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
					 $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
					 if($item->object == 'page')
					 {
								$varpost = get_post($item->object_id);
								// $parent_title = get_the_title($post->post_parent);
								$attributes .= ' class="smoothy" href="#' . $varpost->post_name . '"';
					 }
					 else
								$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
						$item_output = $args->before;
						$item_output .= '<a'. $attributes .'>';
						$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID );
						$item_output .= $args->link_after;
						$item_output .= '</a>';
						$item_output .= $args->after;

						$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
						}
}

class primary_walker extends Walker_Nav_Menu
{
			function start_el(&$output, $item, $depth, $args)
			{
					 global $wp_query;
					 $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

					 $class_names = $value = '';

					 $classes = empty( $item->classes ) ? array() : (array) $item->classes;

					 $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
					 $class_names = ' class="'. esc_attr( $class_names ) . '"';

					 $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .' data-index="item'. $item->ID . '">';

					 $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
					 $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
					 $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
					 $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

					 $description  = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';

					 if($depth != 0)
					 {
										 $description = "";
					 }

						$item_output = $args->before;
						$item_output .= '<a'. $attributes .'>';
						$item_output .= $args->link_before .apply_filters( 'the_title', $item->title, $item->ID );
						$item_output .= $description.$args->link_after;
						$item_output .= '</a>';
						$item_output .= $args->after;

						$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
						}
}

add_filter( 'posts_orderby', 'sort_query_by_post_in', 10, 2 );
function sort_query_by_post_in( $sortby, $thequery ) {
	if ( !empty($thequery->query['post__in']) && isset($thequery->query['orderby']) && $thequery->query['orderby'] == 'post__in' )
		$sortby = "find_in_set(ID, '" . implode( ',', $thequery->query['post__in'] ) . "')";
	return $sortby;
}

add_action('init', 'vp_sidebars');
function vp_sidebars() {
	$args = array(
				'name'          => 'Right sidebar',
				'before_widget' => '<div id="%1$s" class="padding-bottom %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widgettitle">',
				'after_title'   => '</h3>' );
	register_sidebar($args);
}


// Image Sizes
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
}

?>
