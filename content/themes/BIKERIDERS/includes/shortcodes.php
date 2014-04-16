<?php
function filter_shortcode($content) {
	return do_shortcode(strip_tags($content, "<h1><h2><h3><h4><h5><h6><a><img><div><ul><li><ol><table><td><th><span><p><br><strong><em><b><i><iframe><embed>"));
}

add_shortcode('addthis','vp_addthis');
function vp_addthis($atts, $content = null){
	extract(shortcode_atts(array(
		"variation" => 1,
	), $atts));
	
	$output = '<div style="margin: 5px; display: inline">';
	switch($variation) {
		case 1:
			$output .= '<div class="addthis_toolbox addthis_default_style ">
				<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
				<a class="addthis_button_tweet"></a>
				<a class="addthis_button_pinterest_pinit"></a>
				<a class="addthis_counter addthis_pill_style"></a>
				</div>';
			break;
		case 2:
			$output .= '<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
				<a class="addthis_button_preferred_1"></a>
				<a class="addthis_button_preferred_2"></a>
				<a class="addthis_button_preferred_3"></a>
				<a class="addthis_button_preferred_4"></a>
				<a class="addthis_button_compact"></a>
				<a class="addthis_counter addthis_bubble_style"></a>
				</div>';
			break;
		case 3:		
			$output .= '<div class="addthis_toolbox addthis_default_style ">
				<a class="addthis_button_preferred_1"></a>
				<a class="addthis_button_preferred_2"></a>
				<a class="addthis_button_preferred_3"></a>
				<a class="addthis_button_preferred_4"></a>
				<a class="addthis_button_compact"></a>
				<a class="addthis_counter addthis_bubble_style"></a>
				</div>';
			break;
		case 4:
			$output .= '<div class="addthis_toolbox addthis_floating_style addthis_counter_style" style="left:50px;top:50px;">
				<a class="addthis_button_facebook_like" fb:like:layout="box_count"></a>
				<a class="addthis_button_tweet" tw:count="vertical"></a>
				<a class="addthis_button_google_plusone" g:plusone:size="tall"></a>
				<a class="addthis_counter"></a>
				</div>';
			break;
	}
	$output .= '<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4ff05056494689b5"></script>';
	$output .= '</div>';		
	return $output;
}
add_shortcode('one_third','vp_one_third');
function vp_one_third($atts, $content = null){
	extract(shortcode_atts(array(
		'noleft' => '',
		'noright' => ''
	), $atts));
	$content = filter_shortcode($content);
	$class = '';
	if($noleft !== '')
		$class .= 'alpha ';
	if($noright !== '')
		$class .= 'omega';
	$output = '<div class="one-third column ' . $class . '">' . $content . '</div>';
	return $output;
}
add_shortcode('one_half','vp_one_half');
function vp_one_half($atts, $content = null){
	extract(shortcode_atts(array(
		'noleft' => '',
		'noright' => ''
	), $atts));
	$content = filter_shortcode($content);
	$class = '';
	if($noleft !== '')
		$class .= 'alpha ';
	if($noright !== '')
		$class .= 'omega';
	$output = '<div class="eight columns ' . $class . '">' . $content . '</div>';
	return $output;
}

add_shortcode('two_thirds','vp_two_thirds');
function vp_two_thirds($atts, $content = null){
	extract(shortcode_atts(array(
		'noleft' => '',
		'noright' => ''
	), $atts));
	$content = filter_shortcode($content);
	$class = '';
	if($noleft !== '')
		$class .= 'alpha ';
	if($noright !== '')
		$class .= 'omega';
	$output = '<div class="two-thirds column ' . $class . '">' . $content . '</div>';
	return $output;
}

add_shortcode('one_fourth','vp_one_fourth');
function vp_one_fourth($atts, $content = null){
	extract(shortcode_atts(array(
		'icon' => '',
		'noleft' => '',
		'noright' => ''
	), $atts));
	$content = filter_shortcode($content);
	$class = '';
	if($noleft !== '')
		$class .= 'alpha ';
	if($noright !== '')
		$class .= 'omega';
	$output = '<div class="four columns ' . $class . '">';
	if($icon !== '')
		$output .= '<img alt="" src="' . esc_attr($icon) . '">';
	$output .= $content;
	$output .= '</div>';
	return $output;
}

add_shortcode('subtext','vp_subtext');
function vp_subtext($atts, $content = null){
	$content = filter_shortcode($content);
	$output = '<p class="line2nd">' . $content . '</p>';
	return $output;
}


add_shortcode('slider', 'vp_slider');
function vp_slider($atts, $content=null) {
	$id = rand(0, 25000);
	$content = filter_shortcode($content);
	$output = '<div class="flexslider flex-' . $id . '">';
	$output .= '<ul class="slides">';
	$output .= $content;
	$output .= '</ul></div>';
	$output .= '
	<script type="text/javascript">
		jQuery(".flex-' . $id . '").flexslider({
				animation: "fade",
				slideshowSpeed: 7000,
				animationSpeed: 1000,
				slideshow: false,
			});
	</script>';
	return $output;
}

add_shortcode('slider_img', 'vp_slider_img');
function vp_slider_img($atts, $content=null) {
	extract(shortcode_atts(array(
		'alt' => '',
		'url' => ''
	), $atts));
	$content = filter_shortcode($content);
	if($content != '')
	{
		if($url !== '')
			$output = ' <li><a target="_blank" href="' . esc_url($url) . '"><img alt="' . $alt . '" src="' . $content . '" /></a></li>' . PHP_EOL;
		else
			$output = ' <li><img alt="' . $alt . '" src="' . $content . '"></li>' . PHP_EOL;
		return $output;
	}
	else return '';
}

add_shortcode('button', 'vp_button');
function vp_button($atts, $content=null) {
	extract(shortcode_atts(array(
		'type' => '',
		'url' => '',
		'color' => ''
	), $atts));
	$content = filter_shortcode($content);
	if  ($type == 'bikefit')
		$encurl = ''. home_url('/appointments/lab/') .'?appointment_type=Bike%20Fitting%20(%24349.99)';
	elseif($type == 'prefitting')
		$encurl = ''. home_url('/appointments/lab/') .'?appointment_type=Pre%20Fitting%20(%24424.99)';
	elseif($type == 'refitting')
		$encurl = ''. home_url('/appointments/lab/') .'?appointment_type=Refitting%20(Bike%20Fit)%20(%24174.99)';
	elseif($type == 'cleat')
		$encurl = ''. home_url('/appointments/lab/') .'?appointment_type=Cleat%20fitting%20(%2474.99)';
	elseif($type == 'LT')
		$encurl = ''. home_url('/appointments/lab/') .'?appointment_type=Lactate%20Testing%20(%24224.99)';
	elseif($type == 'training')
		$encurl = ''. home_url('/appointments/lab/') .'?appointment_type=On-Bike%20Skills%20Session%20(1%20hr)%20(%24174.99)';
	elseif($type == 'all')
		$encurl = ''. home_url('/appointments/lab/').'';
	else
		$encurl = '';
	if($content !== '')
	{	
		if($color === '')
		{
			if($url === '')
			{
				if($type === '')	
				$output = '<a class="appointment fancybox.iframe" href="' . home_url('/appointments/mechanical/') . '"><div class="buttonbook">' . $content . '<span class="arrow">→</span></div></a>';	
				else
				$output = '<a class="appointment fancybox.iframe" href="' . $encurl . '"><div class="buttonbook">' . $content . '<span class="arrow">→</span></div></a>';
				return $output;
			}
			else
			{
				$output = '<a href="'. $url .'"><div class="buttonbook">' . $content . '<span class="arrow">→</span></div></a>';
				return $output;
			}
			return $output;
		}
		else 
		{	
				if($type === '')	
				$output = '<a class="appointment fancybox.iframe" href="' . home_url('/appointments/mechanical/') . '"><div class="buttonbook" style="background-color: #' . $color . '">' . $content . '<span class="arrow">→</span></div></a>';	
				else
				$output = '<a class="appointment fancybox.iframe" href="' . $encurl . '"><div class="buttonbook" style="background-color: #' . $color . '">' . $content . '<span class="arrow">→</span></div></a>';
				return $output;
	
		}
	}
	else return '';
}

add_shortcode('review', 'vp_testimonial');
function vp_testimonial($atts, $content=null) {
	extract(shortcode_atts(array(
		'name' => '',
		'date' => '',
		'title' => '',
	), $atts));
	$content = filter_shortcode($content);
	if($content !== '')
	{
		$output ='<div class="one-third column">'. $name .'<br>
		<img src="'. get_bloginfo('template_url') .'/images/review_star.png" />&nbsp;
		<img src="'. get_bloginfo('template_url') .'/images/review_star.png" />&nbsp;
		<img src="'. get_bloginfo('template_url') .'/images/review_star.png" />&nbsp;
		<img src="'. get_bloginfo('template_url') .'/images/review_star.png" />&nbsp;
		<img src="'. get_bloginfo('template_url') .'/images/review_star.png" /><br>
		' .$date. '<br></div>
		<div class="two-thirds column review"><h4>' . $title . '</h4>' . $content . '</div>
		<hr>';
		return $output;
	}
	else return '';
}

add_shortcode('quote_slider', 'vp_quote_slider');
function vp_quote_slider($atts, $content=null) {
	$content = filter_shortcode($content);
	$id = rand(1, 25000);
	$output = '<div class="quote-container">
          <div class="quote-slider" id="quote-slider-' . $id . '">' . PHP_EOL;
    $output .= $content;
    $output .= '</div>
    <div class="quote-nav-left" id="quote-nav-left-' . $id . '">
		<a href="#" onclick="return false">&laquo; left</a>
	</div>
	<div class="quote-nav-right" id="quote-nav-right-' . $id . '">
		<a href="#" onclick="return false">right &raquo;</a>
	</div>
    </div>' . PHP_EOL;
    $output .= "<script type='text/javascript'>
    jQuery().ready(function() {
    jQuery('#quote-slider-$id').cycle({
    		fx: 'scrollHorz',
    		easing: 'easeInOutExpo',
    		prev: '#quote-nav-left-$id a',
    		next: '#quote-nav-right-$id a',
    		timeout: 5000
    	});
	});
    </script>" . PHP_EOL;
    return $output;
}
add_shortcode('quote', 'vp_quote');
function vp_quote($atts, $content=null) {
	extract(shortcode_atts(array(
		'author' => ''
	), $atts));

	$content = filter_shortcode($content);
	$output = '<div class="panel">
            <p class="quote">&ldquo;' . $content . '&rdquo;</p>
            <p class="quoter">' . $author . '</p>
    </div>' . PHP_EOL;
    return $output;
}

add_shortcode('clear', 'vp_clear');
function vp_clear($atts, $content=null) {
	return '<div class="clear"></div>';
}
add_shortcode('center', 'vp_centered');
function vp_centered($atts, $content=null) {
	$content = filter_shortcode($content);
	return '<div style="text-align: center">' . $content . '</div>';
}
add_shortcode('list', 'vp_list');
function vp_list($atts, $content=null) {
	extract(shortcode_atts(array(
		'type' => 'bullet'
	), $atts));
	$content = filter_shortcode($content);
	if($type == 'bullet')
		$output = '<ul class="list bullet">';
	elseif($type == 'check')
		$output = '<ul class="list check">';
	elseif($type == 'float')
		$output = '<ul class="list float">';
	else return '';
	$output .= $content;
	$output .= '</ul>';
	return $output;
}

add_shortcode('feature','vp_feature');
function vp_feature($atts, $content = null){
	$content = filter_shortcode($content);
	if($content != '')
		return '<li>' . $content . '</li>';	
}

add_shortcode('header','vp_header');
function vp_header($atts, $content = null) {
	$content = filter_shortcode($content);
	$output = '<h3 style="text-align: center; margin-top: 25px"><span class="lines">' . $content . '</span></h3>';
	return $output;
}
add_shortcode('subheader','vp_subheader');
function vp_subheader($atts, $content = null) {
	$content = filter_shortcode($content);
	$output = '<div class="action"><p>' . $content . '</p></div>';
	return $output;
}
?>