<?php
/**
 * Plugin Name:       Linkages Helper Plugin
 * Description:       Very long description
 * Version:           1.0.1
 * Text Domain:       linkages
*/

require_once( plugin_dir_path( __FILE__ ) . 'functions.php' );

//Plugin endpoints
require_once( plugin_dir_path( __FILE__ ) . 'endpoints/content.php' );
require_once( plugin_dir_path( __FILE__ ) . 'endpoints/post.php' );

// Register Menu Pages (callback functions)
require_once( plugin_dir_path( __FILE__ ) . 'callbacks/menu-page.php' );
require_once( plugin_dir_path( __FILE__ ) . 'callbacks/sub-menu-page-overall.php' );

//Register Menu Pages
require_once( plugin_dir_path( __FILE__) . 'menu-pages.php' );
