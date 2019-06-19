<?php
/**
 * Plugin Name: MLM Plugin
 * Description: To provide mlm using wordpress register:[mlm_reg_shortcode].
 * Version: 1.0
 * Author: Sahil Gulati
 * Author URI: http://www.facebook.com/sahilgulati007
 */
global $jal_db_version;
$jal_db_version = '1.0';
function jal_install() {
    global $wpdb;
    global $jal_db_version;
    $table_name = $wpdb->prefix . 'mlm';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
		mid bigint(20) NOT NULL AUTO_INCREMENT,
		uid bigint(20) NOT NULL,
		mgid bigint(20) NOT NULL,
		mnm tinytext NOT NULL,
	    mplan text NOT NULL,
	    country text NOT NULL,
	    state text NOT NULL,
	    city text NOT NULL,
	    zip text NOT NULL,
		PRIMARY KEY  (mid)
	) $charset_collate;";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    $table_name = $wpdb->prefix . 'mlm_package_detail';
    $sql = "CREATE TABLE $table_name (
		pid mediumint(9) NOT NULL AUTO_INCREMENT,
		pnm text NOT NULL,
		pprice mediumint(9) NOT NULL,
	    pdesc text NOT NULL,
		PRIMARY KEY  (pid)
	) $charset_collate;";
    dbDelta( $sql );
    add_option( 'jal_db_version', $jal_db_version );
}
register_activation_hook( __FILE__, 'jal_install' );
//adding in menu
add_action('admin_menu', 'at_mlm_menu');
function at_mlm_menu()
{
    //adding plugin in menu
    add_menu_page('mlm_list', //page title
        'MLM Listing', //menu title
        'read', //capabilities
        'MLM_Listing', //menu slug
        'mlm_list' //function
    );
    //adding submenu to a menu
    add_submenu_page(null,//parent page slug
        'Chat_view',//page title
        'Chat View',//menu title
        'manage_options',//manage options
        'Chat_View',//slug
        'chat_view'//function
    );
    add_submenu_page('MLM_Listing',//parent page slug
        'Add_Package',//page title
        'Add Package',//menu title
        'manage_options',//manage options
        'Add_Package',//slug
        'add_package'//function
    );
    add_submenu_page('MLM_Listing',//parent page slug
        'View_Package',//page title
        'View Package',//menu title
        'manage_options',//manage options
        'View_Package',//slug
        'view_package'//function
    );

}
define('ROOTDIR', plugin_dir_path(__FILE__));
require_once(ROOTDIR . 'mlm_list.php');
require_once(ROOTDIR . 'mlm_register.php');
require_once(ROOTDIR . 'add_package.php');
require_once(ROOTDIR . 'view_package.php');