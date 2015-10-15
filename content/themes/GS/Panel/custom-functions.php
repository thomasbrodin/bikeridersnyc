<?php 
add_filter('wp_title', 'vp_filter_wp_title', 9, 3);
function vp_filter_wp_title( $old_title, $sep, $sep_location ) {
	$ssep = ' ' . $sep . ' ';
	if (is_home() ) {
		return get_bloginfo('name');
	}
	elseif(is_single() || is_page() )
	{
		return get_the_title();
	}
	elseif( is_category() ) $output = $ssep . 'Category';
	elseif( is_tag() ) $output = $ssep . 'Tag';
	elseif( is_author() ) $output = $ssep . 'Author';
	elseif( is_year() || is_month() || is_day() ) $output = $ssep . 'Archives';
	else $output = NULL;
	 
	// get the page number we're on (index)
	if( get_query_var( 'paged' ) )
	$num = $ssep . 'page ' . get_query_var( 'paged' );
	 
	// get the page number we're on (multipage post)
	elseif( get_query_var( 'page' ) )
	$num = $ssep . 'page ' . get_query_var( 'page' );
		 
	// else
	else $num = NULL;
		 
	// concoct and return new title
	return get_bloginfo( 'name' ) . $output . $old_title . $num;
}

add_action('wp_head', 'vp_customization');
//This function handles the Colorization tab of the theme options
if(! function_exists('vp_customization'))
{
	function vp_customization() {
		//favicon
		global $bk;

		if(isset($bk['favicon']) && $bk['favicon'] != '')
			echo '<link rel="shortcut icon" href="' . $bk['favicon'] . '" />';
	
	}
}
?>