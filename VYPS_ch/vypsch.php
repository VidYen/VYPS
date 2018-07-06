<?php

 /*
Plugin Name:  VYPS Coinhive Addon
Plugin URI:   http://vyps.org
Description:  Adds Coinhive API to the VYPS so you can award points based on hashes mined to your users
Version:      00.01.28
Author:       VidYen, LLC
Author URI:   https://vidyen.com/
License:      GPLv2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//register_activation_hook(__FILE__, 'vyps_ch_install'); //I do not this this is needed.

//Ok we are going to call the shortcode function file. Originally there were a whole lot more shortcodes, but sometimes
//destroying all the extra features and simplification is the best route.
include( plugin_dir_path( __FILE__ ) . '/includes/ch_sc_func.php'); //This include creates the menu in the VYPS submenu




//I would love to make this like it's own thing but then we'd have to assume they installed the warning plug in. lol.
include( plugin_dir_path( __FILE__ ) . '/includes/ch_menu.php'); //This include creates the menu in the VYPS submenu

//include( plugin_dir_path( __FILE__ ) . '/includes/no_vyps_menu.php'); //This include creates it on top level to inform to install VYPS
/*
//Check to see if VYPS installed function and run menus accordingly
function vyps_base_plugin_check() {

	//if (function_exists('vyps_point_transfer_tbl_func')) { //I feel the if function exists is a bit safer.
	if ( is_plugin_active( 'vidyen-point-system-vyps/vyps.php' ) ) {

	} else {

	}

} */

//There was some short codes down here here originally, but moved to /includes/ch_sc_func.php
