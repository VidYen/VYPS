<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//This is specifically designed to just read the SQL settings once to minimize the SQL hits.
function vidyen_vy_wm_settings()
{
  global $wpdb;

  //grab table name
  $table_name_wm = $wpdb->prefix . 'vidyen_wm_settings';

  $index = 1; //Well first row

  //SQL query of current row on settings table
  $wm_data_query = "SELECT * FROM ". $table_name_wm . " WHERE id = %d";
  $wm_data_query_prepared = $wpdb->prepare( $wm_data_query, $index );
  $wm_data = $wpdb->get_results($wm_data_query_prepared);

  foreach ($wm_data as $result)
  {
    $button_text = $result->button_text;
    $disclaimer_text = $result->disclaimer_text;
    $eula_text = $result->eula_text;
    $current_wmp = $result->current_wmp;
    $current_pool = $result->current_pool;
    $pool_password = $result->pool_password;
    $crypto_wallet = $result->crypto_wallet;
    $wm_active = $result->wm_active;
    $wm_fee_active = $result->wm_fee_active;
    //Array parsing to cram it into multi dimensional row
    //TODO: Add index names and not numbers for second part!
    $wm_parsed_array[$index]['button_text'] = $button_text;
    $wm_parsed_array[$index]['disclaimer_text'] = $disclaimer_text;
    $wm_parsed_array[$index]['eula_text'] = $eula_text;
    $wm_parsed_array[$index]['current_wmp'] = $current_wmp;
    $wm_parsed_array[$index]['current_pool'] = $current_pool;
    $wm_parsed_array[$index]['pool_password'] = $pool_password;
    $wm_parsed_array[$index]['crypto_wallet'] = $crypto_wallet;
    $vy_wm_parsed_array[$index]['wm_active'] = $wm_active;
  	$vy_wm_parsed_array[$index]['wm_fee_active'] = $wm_fee_active;

    $index++; //Technically it should be only one row unless I screwed up.
  }
  return $wm_parsed_array;
}