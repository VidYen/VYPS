<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
** This is where we pull the sql call functions from
** There are no attributes or input since its hard coded.
** Yes, it was a lot of copying and pasting.
*/

/*** Currency ID SQL Call ***/
function vyps_rts_sql_currency_id_func()
{
	global $wpdb;

	//the $wpdb stuff to find what the current name and icons are
	$table_name_rts = $wpdb->prefix . 'vidyen_rts';

	$first_row = 1; //Note sure why I'm setting this.

	//Input ID pull
	$point_id_query = "SELECT currency_id FROM ". $table_name_rts . " WHERE id= %d"; //I'm not sure if this is resource optimal but it works. -Felty
	$point_id_query_prepared = $wpdb->prepare( $point_id_query, $first_row );
	$point_id = $wpdb->get_var( $point_id_query_prepared );

	$point_id = intval($point_id); //Extra sanitzation

	return $point_id;
}

/************START LIGHT SOLIDER FUNCTIONS********/
/*** LIght Soldier ID SQL Call ***/
function vyps_rts_sql_light_soldier_id_func()
{
	global $wpdb;

	//the $wpdb stuff to find what the current name and icons are
	$table_name_rts = $wpdb->prefix . 'vidyen_rts';

	$first_row = 1; //Note sure why I'm setting this.

	//Input ID pull
	$point_id_query = "SELECT light_soldier_id FROM ". $table_name_rts . " WHERE id= %d"; //I'm not sure if this is resource optimal but it works. -Felty
	$point_id_query_prepared = $wpdb->prepare( $point_id_query, $first_row );
	$point_id = $wpdb->get_var( $point_id_query_prepared );

	$point_id = intval($point_id); //Extra sanitzation

	return $point_id;
}

/*** LIght Soldier COST SQL Call ***/
function vyps_rts_sql_light_soldier_cost_func()
{
	global $wpdb;

	//the $wpdb stuff to find what the current name and icons are
	$table_name_rts = $wpdb->prefix . 'vidyen_rts';

	$first_row = 1; //Note sure why I'm setting this.

	//Input ID pull
	$point_id_query = "SELECT light_soldier_cost FROM ". $table_name_rts . " WHERE id= %d"; //I'm not sure if this is resource optimal but it works. -Felty
	$point_id_query_prepared = $wpdb->prepare( $point_id_query, $first_row );
	$point_id = $wpdb->get_var( $point_id_query_prepared );

	$point_id = intval($point_id); //Extra sanitzation

	return $point_id;
}

/*** LIght Soldier Time SQL Call ***/
function vyps_rts_sql_light_soldier_time_func()
{
	global $wpdb;

	//the $wpdb stuff to find what the current name and icons are
	$table_name_rts = $wpdb->prefix . 'vidyen_rts';

	$first_row = 1; //Note sure why I'm setting this.

	//Input ID pull
	$point_id_query = "SELECT light_soldier_time FROM ". $table_name_rts . " WHERE id= %d"; //I'm not sure if this is resource optimal but it works. -Felty
	$point_id_query_prepared = $wpdb->prepare( $point_id_query, $first_row );
	$point_id = $wpdb->get_var( $point_id_query_prepared );

	$point_id = intval($point_id); //Extra sanitzation

	return $point_id;
}

/************END LIGHT SOLIDER FUNCTIONS********/


/************Begin Resource functions FUNCTIONS********/