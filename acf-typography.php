<?php
/*
 * Plugin Name: Advanced Custom Fields: Typography
 * Plugin URI: https://github.com/reyhoun/acf-typography
 * Description: Typography with Google Fonts Field for Advanced Custom Fields
 * Version: 0.6.4
 * Author: Reyhoun
 * Author URI: http://reyhoun.com/
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * GitHub Plugin URI: https://github.com/reyhoun/acf-typography
 * GitHub Branch: master
*/

// 1. set text domain
// Reference: https://codex.wordpress.org/Function_Reference/load_plugin_textdomain
load_plugin_textdomain( 'acf-typography', false, dirname( plugin_basename(__FILE__) ) . '/lang/' ); 


// 2. Include field type for ACF5
// $version = 5 and can be ignored until ACF6 exists
function include_field_types_typography( $version ) {
	include_once('acf-typography-v5.php');	
}

add_action('acf/include_field_types', 'include_field_types_typography');
?>