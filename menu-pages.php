<?php
function linkages_custom_menu_page(){
	add_menu_page( 
		__( 'Linkages Site Report', 'linkages' ),
		'Linkages Site Report',
		'manage_options',
		'linkages-helper',
		'linkages_overall_report_callback',
		'',
		109
	);

	add_submenu_page(
		'linkages-helper', // Parent slug
		__( 'Linkages Settings', 'linkages' ), // Page title
		__( 'Settings', 'textdomain' ), // Menu title
		'manage_options', // Capability required
		'linkages-helper-overall', // Submenu slug
		// 'linkages_overall_report_callback' // Callback function
		'linkages_custom_menu_page_callback' // Callback function
	);
}
 
add_action( 'admin_menu', 'linkages_custom_menu_page' );
