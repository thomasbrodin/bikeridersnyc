<?php
/*
Plugin Name: HEX Custom admin UI 
Description: Customisation of WP admin UI
Author: HEX creative
Author URI: http://www.hexcreativenetwork.com
*/

add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );
add_action( 'wp_before_admin_bar_render', 'child_theme_creator_admin_bar_render', 100);
add_action( 'admin_menu', 'remove_menus', 999 );
add_action( 'wp_dashboard_setup', 'remove_dashboard_widgets');

function remove_admin_bar_links() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');          
    $wp_admin_bar->remove_menu('about');           
    $wp_admin_bar->remove_menu('wporg');           
    $wp_admin_bar->remove_menu('documentation');    
    $wp_admin_bar->remove_menu('support-forums');   
    $wp_admin_bar->remove_menu('feedback');             
    $wp_admin_bar->remove_menu('updates');         
    $wp_admin_bar->remove_menu('comments');         
    $wp_admin_bar->remove_node( 'new-link','new-content' );
    $wp_admin_bar->remove_node( 'new-media','new-content' );
    $wp_admin_bar->remove_node( 'new-produits','new-content');
    $wp_admin_bar->remove_node( 'new-user', 'new-content' );
    $wp_admin_bar->remove_menu( 'SearchWP' );  
    $wp_admin_bar->remove_menu( 'w3tc');
}

function remove_menus() {
    global $wp_admin_bar, $current_user;
    remove_menu_page('index.php'); //Dashboard
    if ($current_user->ID != 1) {
        remove_menu_page('upload.php'); //Media
        remove_menu_page('plugins.php'); //Plugins
        remove_menu_page('tools.php'); //Tools
        remove_menu_page('edit-comments.php');  
        remove_menu_page('upload.php' );     
        remove_menu_page('options-general.php'); //Settings 
        remove_menu_page('edit.php?post_type=acf'); //ACF
        remove_menu_page('wpcf7'); // Contact Form
        remove_submenu_page( 'themes.php', 'customize.php'); //Appearance submenus
        remove_submenu_page( 'themes.php', 'widgets.php' ); //Appearance submenus
        remove_submenu_page( 'themes.php', 'theme-editor.php');
    }       
}

function remove_dashboard_widgets()
  {
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
    remove_meta_box('dashboard_activity', 'dashboard', 'normal');

  }
    