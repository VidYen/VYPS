<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*** AJAX TO GRAB HASH PER SECOND FROM MO ***/

//register the ajax for non authenticated users
//NOTE: Non-authed users (those in LoA)
add_action( 'wp_ajax_nopriv_vidyen_rts_sack_village_action', 'vidyen_rts_sack_village_action');

// register the ajax action for authenticated users
add_action('wp_ajax_vidyen_rts_sack_village_action', 'vidyen_rts_sack_village_action');

//register the ajax for non authenticated users
//NOTE: for missions they need to be authenticated
//add_action( 'wp_ajax_nopriv_vidyen_rts_sack_village_action', 'vidyen_rts_sack_village_action' );

// handle the ajax request
function vidyen_rts_sack_village_action()
{
  if (!is_user_logged_in())
  {
    if (!isset($_POST['user_id']))
    {
      wp_die(); //If the game_id didn't come through then it means the get from the above didnt' work
                //and by all accounts it should die at that point.
    }
    else
    {
      $game_id = sanitize_text_field( $_POST['user_id'] ); //If its good enough for the Romans, it's good enough for me.
      $user_id = 0; //Signal that user has a user_id but not logged in
      $user_logged_in = FALSE;
    }
  }
  elseif (is_user_logged_in())
  {
    //Either user is logged in or they isn't.
    $user_id = get_current_user_id();
    $game_id = '';
    $user_logged_in = TRUE;
  }
  else
  {
    wp_die();
  }

  global $wpdb; // this is how you get access to the database

  //Assumption. We know the user send 20 soldiers... so we figure out how many survived.
  $solider_point_id = vyps_rts_sql_light_soldier_id_func();
  $solider_icon = vyps_point_icon_func($solider_point_id);
  $soldiers_sent = 20;
  $soldiers_reason = 'Soldiers killed';
  $vyps_meta_id = 'Mission_sack';

  //Resource IDs
  $currency_point_id = vyps_rts_sql_currency_id_func();
  $wood_point_id = vyps_rts_sql_wood_id_func();
  $iron_point_id = vyps_rts_sql_iron_id_func();
  $stone_point_id = vyps_rts_sql_stone_id_func();

  //And see if they are logged in. I'm using variables as I believe checking to log in uses more checking power
  if ($user_logged_in == FALSE)
  {
    $current_soldier_amount = vidyen_mmo_wm_point_balance_func($solider_point_id, $game_id);
  }
  else
  {
    $current_soldier_amount = vyps_point_balance_func($solider_point_id, $user_id);
  }

  if ($current_soldier_amount < $soldiers_sent)
  {
    $story = "You don't have enough soldiers to send. They refuse to budge from the barracks.";
    $loot = "You received 0 resources.";

    $soldiers_killed = 0;

    $money_looted = 0;
    $wood_looted = 0;
    $iron_looted = 0;
    $stone_looted = 0;

    $village_rts_sack_village_server_response = array(
        'system_message' => 'NOTENOUGHSOLDIERS',
        'mission_story' => $story,
        'mission_loot' => $loot,
        'money_looted' => $money_looted,
        'wood_looted' => $wood_looted,
        'iron_looted' => $iron_looted,
        'stone_looted' => $stone_looted,
        'soldiers_killed' => $soldiers_killed,
        'time_left' => 0,
    );
      echo json_encode($village_rts_sack_village_server_response); //Proper method to return json
      wp_die(); // this is required to terminate immediately and return a proper response
  }

  $mission_id = 'sackvillage03'; //five minute village sack
  $mission_time = 180; //5 minutes
  $reason = 'Sack the village!';
  $vyps_meta_id = ''; //I can't think what to use here.

  //First lets check if a mission is currently running.
  $current_mission_time = vidyen_rts_check_mission_time_func($user_id, $mission_id, $mission_time, $game_id);

  //$current_mission_time = 0; //Testing if its this function or the other one

  //In case this is the first mission.
  if ($current_mission_time < 1 )
  {
      //Ok lets set out and conquer!
      $mission_add_result = vidyen_rts_add_mission_func( $mission_id, $mission_time, $user_id, $reason, $vyps_meta_id, $game_id );
      //In my mental stupdity, I forgot to update after adding.
      $current_mission_time = vidyen_rts_check_mission_time_func($user_id, $mission_id, $mission_time, $game_id);
  }
  else
  {
    $story = "You must wait until local villages recover before taking advantage of them.";
    $loot = "You need to wait $current_mission_time seconds before pillaging again.";

    $soldiers_killed = 0;

    $money_looted = 0;
    $wood_looted = 0;
    $iron_looted = 0;
    $stone_looted = 0;

    $village_rts_sack_village_server_response = array(
        'system_message' => 'YOUMUSTWAIT',
        'mission_story' => $story,
        'mission_loot' => $loot,
        'money_looted' => $money_looted,
        'wood_looted' => $wood_looted,
        'iron_looted' => $iron_looted,
        'stone_looted' => $stone_looted,
        'soldiers_killed' => $soldiers_killed,
        'time_left' => $current_mission_time,
    );
      echo json_encode($village_rts_sack_village_server_response); //Proper method to return json
      wp_die(); // this is required to terminate immediately and return a proper response
  }


  $soldiers_killed = mt_rand( 0 , $soldiers_sent ); //It's possible no one died.

  $money_looted = mt_rand( 0 , 500 );
  $wood_looted = mt_rand( 0 , 100 );
  $iron_looted = mt_rand( 0 , 75 );
  $stone_looted = mt_rand( 0 , 50 ); //Why would you loot stone?

  if ($soldiers_killed < 5)
  {
    $story = "Your soldiers suprise the villagers pillaging them all and taking little casualties with $soldiers_killed $solider_icon killed. They even tore down the poor stone huts carrying back stone.";
    $loot = "You received $money_looted copper coins, $wood_looted wood, $iron_looted iron ore, and $stone_looted units of stone.";

    //Technically no soldiders were killed.
  }
  elseif ($soldiers_killed < 10)
  {
    $story = "Your soldiers attack and take some light casualties with $soldiers_killed $solider_icon lost. They remaining are too lazy to haul back the stone. It's heavy.";
    $loot = "You received $money_looted copper coins, $wood_looted wood, and $iron_looted iron ore." ;
    $stone_looted = 0; //Just had to reset that.
  }
  elseif ($soldiers_killed < 15)
  {
    $story = "Your soldiers attack but the villagers were angry at being disturbed at second lunch and killed a good deal of your men with $soldiers_killed $solider_icon lost but they were able to flee with some loot. They remaining soldiers are too lazy to haul back stone and iron.";
    $loot = "You received $money_looted copper coins and $wood_looted wood.";
    $stone_looted = 0; //Just had to reset that.
    $iron_looted = 0;
  }
  elseif ($soldiers_killed < 20)
  {
    $story = "Your soldiers sack the village but most of them die with $soldiers_killed $solider_icon lost. They only carry back the copper coins they theived.";
    $loot = "You received $money_looted in copper coins." ;
    $stone_looted = 0; //Just had to reset that.
    $iron_looted = 0;
    $wood_looted = 0;
  }
  elseif ($soldiers_killed > 19)
  {
    $story = "Your soldiers got drunk before attacking the peasants and attacked a nearby castle instead. All with $soldiers_killed $solider_icon died.";
    $loot = "You received 0 resources.";
    $stone_looted = 0; //Just had to reset that.
    $iron_looted = 0;
    $wood_looted = 0;
    $money_looted = 0;
  }
  else
  {
    $story = "Error?";
    $loot = "RNGJesus save us!";
  }

  //Time to remove soldiers via functions.
  vyps_point_deduct_func( $solider_point_id, $soldiers_killed, $user_id, $soldiers_reason, $vyps_meta_id, $game_id );

  //Time to credit resources. I'm being lazy and getting the whole response sum so i can see in js (this whole thing was made in 2 hours)
  $response_sum = vyps_point_credit_func( $currency_point_id, $money_looted, $user_id, $soldiers_reason, $vyps_meta_id, $vyps_meta_data = '', $vyps_meta_subid1 = '', $vyps_meta_subid2 ='', $vyps_meta_subid3= '', $game_id);
  $response_sum = $response_sum + vyps_point_credit_func( $wood_point_id, $wood_looted, $user_id, $soldiers_reason, $vyps_meta_id, $vyps_meta_data = '', $vyps_meta_subid1 = '', $vyps_meta_subid2 ='', $vyps_meta_subid3= '', $game_id);
  $response_sum = $response_sum + vyps_point_credit_func( $iron_point_id, $iron_looted, $user_id, $soldiers_reason, $vyps_meta_id, $vyps_meta_data = '', $vyps_meta_subid1 = '', $vyps_meta_subid2 ='', $vyps_meta_subid3= '', $game_id );
  $response_sum = $response_sum + vyps_point_credit_func( $stone_point_id, $stone_looted, $user_id, $soldiers_reason, $vyps_meta_id, $vyps_meta_data = '', $vyps_meta_subid1 = '', $vyps_meta_subid2 ='', $vyps_meta_subid3= '', $game_id );

  $village_rts_sack_village_server_response = array(
      'system_message' => $response_sum,
      'mission_story' => $story,
      'mission_loot' => $loot,
      'money_looted' => $money_looted,
      'wood_looted' => $wood_looted,
      'iron_looted' => $iron_looted,
      'stone_looted' => $stone_looted,
      'soldiers_killed' => $soldiers_killed,
      'time_left' => $current_mission_time,
  );

  echo json_encode($village_rts_sack_village_server_response); //Proper method to return json

  wp_die(); // this is required to terminate immediately and return a proper response
}
