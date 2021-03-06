<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//vyps_point_balance function
//NOTE: Rather than do the user checks here we have to get the game_id passed from the calling function.
//There could be a possible reason to get balance when user not logged in ,but for now this works well enough.

/*** POINT Balance FUNCTION ***/
function vidyen_mmo_wm_point_balance_func($point_id, $game_id)
{
  //The usual suspects to get the sql calls up
  global $wpdb;
	$table_name_log = $wpdb->prefix . 'vyps_points_log';

  //balance
	//$balance_points = $wpdb->get_var( "SELECT sum(points_amount) FROM $table_vyps_log WHERE game_id = $userID AND points = $point_id"); //Oooh. I love it when I get my variable names the same.
	$balance_points_query = "SELECT sum(points_amount) FROM ". $table_name_log . " WHERE game_id = %s AND point_id = %d";
	$balance_points_query_prepared = $wpdb->prepare( $balance_points_query, $game_id, $point_id ); //NOTE: Originally this said $current_game_id but although I could pass it through to something else it would not be true if admin specified a UID. Ergo it should just say it $userID
	$balance_points = $wpdb->get_var( $balance_points_query_prepared );

  $balance_points = intval($balance_points); //This should go out as an raw in. The name and icon can be printed seperatly as needed.

  //Return it out as an int
  return $balance_points;
}
