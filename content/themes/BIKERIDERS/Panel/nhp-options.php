<?php



if(!class_exists('NHP_Options')){

	require_once( dirname( __FILE__ ) . '/options/options.php' );

}


/*

 * Custom function for filtering the args array given by theme, good for child themes to override or add to the args array.

 */

function change_framework_args($args){

	

	//$args['dev_mode'] = false;

	

	return $args;

	

}//function

//add_filter('nhp-opts-args-twenty_eleven', 'change_framework_args');



/*

 * This is the meat of creating the options page

 * Override some of the default values, uncomment the args and change the values

 * - no $args are required, but there there to be over ridden if needed.

 */



function setup_framework_options(){


	$args = array();



//Set it to dev mode to view the class settings/info in the form - default is false

$args['dev_mode'] = false;



//Remove the default stylesheet? make sure you enqueue another one all the page will look whack!

//$args['stylesheet_override'] = true;



//Add HTML before the form

//$args['intro_text'] = __('<p>Don\'t forget to save the settings!</p>', 'nhp-opts');



//Choose to disable the import/export feature

$args['show_import_export'] = false;



//Choose a custom option name for your theme options, the default is the theme name in lowercase with spaces replaced by underscores

$args['opt_name'] = 'BK';


//Custom menu icon

//$args['menu_icon'] = '';


//Custom menu title for options page - default is "Options"

$args['menu_title'] = __('Options', 'nhp-opts');



//Custom Page Title for options page - default is "Options"

$args['page_title'] = __('Theme Options', 'nhp-opts');



//Custom page slug for options page (wp-admin/themes.php?page=***) - default is "nhp_theme_options"

$args['page_slug'] = 'bk_options';



//Custom page capability - default is set to "manage_options"

//$args['page_cap'] = 'manage_options';



//page type - "menu" (adds a top menu section) or "submenu" (adds a submenu) - default is set to "menu"

//$args['page_type'] = 'submenu';



//parent menu - default is set to "themes.php" (Appearance)

//the list of available parent menus is available here: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters

//$args['page_parent'] = 'themes.php';



//custom page location - default 100 - must be unique or will override other items

$args['page_position'] = null;



$args['footer_credit'] = '';



//Custom page icon class (used to override the page icon next to heading)

//$args['page_icon'] = 'icon-themes';



//Want to disable the sections showing as a submenu in the admin? uncomment this line

//$args['allow_sub_menu'] = false;

		

//Set ANY custom page help tabs - displayed using the new help tab API, show in order of definition		

// $args['help_tabs'][] = array(

// 							'id' => 'nhp-opts-1',

// 							'title' => __('Theme Information 1', 'nhp-opts'),

// 							'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'nhp-opts')

// 							);

// $args['help_tabs'][] = array(

// 							'id' => 'nhp-opts-2',

// 							'title' => __('Theme Information 2', 'nhp-opts'),

// 							'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'nhp-opts')

// 							);



//Set the Help Sidebar for the options page - no sidebar by default										

// $args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'nhp-opts');



$sections[] = array(

				'title' => __('General Settings', 'nhp-opts'),

				'desc' => __('<p class="description">Here you can configure the general aspects of the theme.!</p>', 'nhp-opts'),

				//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.

				//You dont have to though, leave it blank for default.

				'icon' => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_062_attach.png',

				'fields' => array(

					array(

						'id' => 'favicon',

						'type' => 'upload',

						'title' => 'Favicon',

						'sub_desc' => 'This is the little icon in the address bar for your website'

						),

					array(

						'id' => 'email',

						'type' => 'text',

						'title' => 'Contact e-mail',

						'sub_desc' => 'This is the e-mail where you\'ll receive all the messages, appears on footer and schedule forms',

						'std' => get_bloginfo('admin_email')

						),

					array(

						'id' => 'topheader_smalltext',

						'type' => 'text',

						'title' => 'Top header text',

						'sub_desc' => 'This appears under the home slider text above. Some little description about you here.',

						'std' => 'Bikeridersnyc.com'

						),

					array(

						'id' => 'topheader_smallertext',

						'type' => 'text',

						'title' => 'Top header smaller text',

						'sub_desc' => 'This appears after the Header Text on the homepage, some more info about you here.',

						'std' => 'Premium Bicycle Services'

						),

					array(

						'id' => 'phone',

						'type' => 'text',

						'title' => 'Phone',

						'sub_desc' => 'The phone shows up in the footer and schedule forms',

						'std' => ''

						),

					array(

						'id' => 'address',

						'type' => 'text',

						'title' => 'Address',

						'sub_desc' => 'The Adress shows up in the footer and schedule form',

						'std' => ''

						),
					array(

						'id' => 'city',

						'type' => 'text',

						'title' => 'City',

						'sub_desc' => 'The city shows up in the footer',

						'std' => ''

						),

					array(

						'id' => 'contact_map',

						'type' => 'text',

						'title' => 'Map it',

						'sub_desc' => 'Link to Map',

						'std' => ''

						),

					array(

						'id' => 'facebook_url',

						'type' => 'text',

						'title' => 'Facebook URL',

						'sub_desc' => 'Shows up on the footer. Leave empty if not used.'

						),

					array(

						'id' => 'twitter_username',

						'type' => 'text',

						'title' => 'Twitter username',

						'sub_desc' => 'Shows up on the footer and is used in the twitter updates shortcode. Leave empty if not used.',

						'std' => ''

						),

					array(

						'id' => 'tumblr_url',

						'type' => 'text',

						'title' => 'Tumblr URL',

						'sub_desc' => 'Shows up on the footer. Leave empty if not used.',

						'std' => ''

						),

					array(

						'id' => 'instagram_url',

						'type' => 'text',

						'title' => 'Instagram URL',

						'sub_desc' => 'Shows up on the footer. Leave empty if not used.',

						'std' => ''

						),

					)

				);



$sections[] = array(

				'icon' => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_157_show_lines.png',

				'title' => __('Integration', 'nhp-opts'),

				'desc' => __('<p class="description">Use this to integrate google analytics code or to add any meta tag / html code you want.</p>', 'nhp-opts'),

				'fields' => array(

					array(

						'id' => 'integration_footer',

						'type' => 'textarea',

						'title' => __('Code before the &lt;/body&gt; tag', 'nhp-opts'), 

						'sub_desc' => __('<strong>Use this one for google analytics for example.</strong>', 'nhp-opts'),

						'std' => ''

						),

					array(

						'id' => 'integration_header',

						'type' => 'textarea',

						'title' => __('The code will be added before the &lt;/head&gt; tag', 'nhp-opts'), 

						'sub_desc' => __('Use this one if you want to verify your site for google/bing/alexa/etc for example.', 'nhp-opts'),

						'std' => ''

						),

					)

				);


	global $NHP_Options;

	$NHP_Options = new NHP_Options($sections, $args);

}

add_action('init', 'setup_framework_options', 0);

?>