<?php

//Menu to show the shortcode instructions.
//NOTE: I have decided to move this plugin menu to the official as it's just shorcode

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action('admin_menu', 'vyps_vy256_submenu', 440 );

/* Creates the VY256 submenu on the main VYPS plugin */

function vyps_vy256_submenu() {

  $parent_menu_slug = 'vyps_points';
  $page_title = "VYPS VY256 Shortcodes";
  $menu_title = 'VY256 Miner Shortcodes';
  $capability = 'manage_options';
  $menu_slug = 'vyps_vy256_page';
  $function = 'vyps_vy256_sub_menu_page';

    add_submenu_page($parent_menu_slug, $page_title, $menu_title, $capability, $menu_slug, $function);
}


/* this next function creates the page on the VY256 submenu */

function vyps_vy256_sub_menu_page() {

  //NOTE: I do not think these are needed since we moved into new path.
  /* Getting the plugin root path. I'm calling VYPS_root but not to be confused with the root in the folder */
  /*
  $VYPS_root_path = plugin_dir_path(__FILE__);
	$path_find = "VYPS_ch/includes/";
	$path_remove = '';
	$VYPS_root_path = str_replace( $path_find, $path_remove, $VYPS_root_path);
  */
	$VYPS_logo_url = plugins_url() . '/vidyen-point-system-vyps/images/logo.png'; //I should make this a function.
  $VYPS_worker_url = plugins_url() . '/vidyen-point-system-vyps/images/vyworker_small.gif'; //Small version
	echo '<br><br><img src="' . $VYPS_logo_url . '" > ';
  echo '<br><img src="' . $VYPS_worker_url . '" > ';

  echo "
  <div class=\"wrap\">
    <h1>VYPS VY256 Simple Miner (BETA) User Tracking API Shortcodes</h1>
    <p>This is a simple browser miner that uses VidYen's VY256 pool. The UI, better hash tracking, and performance will be updated as development progresses.</p>
    <p>This pool runs through vy256.com server and is in development mode which means the server may crash or be down at anytime. Please contact us through support if you have problems.</p>
    <p>This allows you to use a local miner on WordPress that by passes adblock or other AV software. That said, you should always explain what this is and I've required the consent buttons by default.</p>
    <p>There is now a cpu control. It is not as percise as Coinhive, but it allows you to know use 100% by cranking it up to 6 (It's possible to lock up your computer with two browsers open at 10 so I'm leaving a cap on it) or you can turn it to 0 to pause. Note the hash updates sometimes come in waves as it has to go from your client's browser to our stratum to the pool and then back each time.</p>
    <p>The benefit however, is that this version does not require any account like Coinhive. AND as far as my testing goes, does not get blocked by uBLock or Brave. Also Malwarebytes never complained in premium mode (unlike Coinhive). That alone makes the low CPU worth it, but we are working on getting code better.</p>
    <p>Alls you need is a viable Monero XMR wallet. <a href=\"https://mymonero.com\" target=\"_blank\">MyMonero</a> works well enough. Currently, the VY256 miner supports the <a href=\"https://moneroocean.stream/\" target=\"_blank\">MoneroOcean</a> pool and the payouts and monitoring are through that site (Not VidYen). As the project progresses, we plan to add other pools, but currently every seems fine with Monero Ocean. (We value your opinion if you have another pool in mind)</p>
    <p>Even though this version did not cause uBlock, Brave Browser, or Malwarebytes to complain...</p>
    <h2>REMEMBER: USING BROWSER MINING WITHOUT CONSENT OF THE USER IS CONSIDERED NOT ONLY A HOSTILE ACTION BUT ALSO ILLEGAL IN SOME JURISTICTIONS!</h2>
    <h2>VIDYEN, LLC IS AGAINST ANY ATTEMPT BY WORDPRESS SITE OWNERS TO TRY TO BYPASS CONSENT AND AWARENESS OF THE END USER USER IN AN ATTEMPT TO MINE XMR IN SECRET OR THROUGH OBFUSCATION!</h2>
    <h2>BY USING THESE SHORTCODES ON YOUR WORDPRESS SITE, YOU AGREE TO NOT ONLY MAKE YOUR USERS AWARE OF WHAT YOU ARE DOING, BUT YOU LET THEM KNOW WHAT IMPLICATIONS IT CAN HAVE ON THEIR CPU, ELECTRICTY USE, AND BATTERY USE!</h2>
    <p>You should make users aware that this may happen in your consent disclaimer.</p>
    <p>That said, legitimate organizations like <a href=\"https://www.thehopepage.org/\" target=\"_blank\">UNICEF</a> are using browser mining for donations, so like any peice of technology it can be used for both legal and illegal purposes.</p>
    <p>If you are concerned about the issues of having browser miners on your site, we recommend using the Adscend shortcode to use traditional advertisements for site monetization.</p>
    <p>Also, as long as you do not put the VY256 shortcode on your site, it will not expose your users to any code from browser mining as no code is called until the accept button is clicked.</p>
    <p><b>NOTE:</b> To display the simple miner you need to place the consent button shortcode on your page to create a POST call that the simple miner shortcode will recognize.</p>
    <p>It is up to you to come up with a consent message, but you need to inform the user what browser mining is and what it may do resource- and battery- wise to their device. (Feel free to use the same message that is on the VidYen official page).</p>
    <p><b>The consent and simple miner shortcode must be put on the same page to work!</b></p>
    <p><b>Users must be logged in to see any of these shortcode as the intent was to track user effort.</b></p>
    <h1>Shortcodes and Syntax</h1>
    <h2>Consent Button Shortcode</h2>
    <p>Replace (optional) and (required) with your info.</p>
    <p><b>[vyps-256-consent text=(optional)]</b></p>
    <p>Display the simple miner consent button. You can customize the text on the button by using txt=.To add spaces in the button text, use quotes.</p>
    <h2>VY256 Miner Display and User Tracking Shortcode</h2>
    <p><b>[vyps-256 wallet=(required) pid=(required) throttle=(optional) site=(required)]</b></p>
    <p>This will display the simple miner after the button on the consent shortcode has been pressed.</p>
    <p>wallet: Your XMR wallet.</p>
    <p>pool: The mining pool you wish to use. Bey default it is moneroocean.stream. There will be a list of compatible pools at bottom of page.</p>
    <p>pid: The VYPS point ID found in the &quot;VYPS Point List&quot; of the point type you want to redeem to (NOTE: Hashes are always redeemed for a 1 for 1. You can use the point exchange shortcode to convert to different amounts before transferring to WooCommerce.)</p>
    <p>threads: Default is 1 to only mine one thread. We would recommend leaving it set to 1 in the event your users have slow devices.</p>
    <p>throttle: The default is 50 which reduces CPU use by 50%, so they only use 50% for mining. I would also recommend leaving this set to 50 and allowing the user to increase it if they want to mine faster via the simple miner GUI.</p>
    <p>Example:</p>
    <p><b>[vyps-256 wallet=48Vi6kadiTtTyemhzigSDrZDKcH6trUTA7zXzwamziSmAKWYyBpacMjWbwaVe4vUMveKAzAiA4j8xgUi29TpKXpm3wL5K5a pid=4 throttle=10 site=vidyen] Please consent to mining. [vyps-256-consent]</b></p>
    <p>This will show the miner after the consent button has been clicked.</p>
    <p><b>[vyps-256-debug wallet=(required) pid=(required) throttle=(optional) site=(required)]</b></p>
    <p>A version that shows you behind the scenes if you are trying to troubleshoot the connection.</p>
    <h1>Graphics</h1>
    <p>You can use the shortcode graphic=0 to turn off animated worker or graphic=1 or 2 if you want to select a particular one. Plans for holidays coming soon!</p>
    <h1>Miner Sharing Shortcodes</h1>
    <p><b>[vyps-xmr-wallet]</b></p>
    <p>This allows users to add their XMR to their user meta for Miner Sharing option with VY256</p>
    <h1>Support</h1>
    <p>Since this is running on our servers and we expanded the code, VidYen, LLC is the one handling the support. Please go to <a href=\"https://www.vidyen.com/about/\" target=\"_blank\">VidYen About</a> or on our <a href=\"https://wordpress.org/support/plugin/vidyen-point-system-vyps\" target=\"_blank\">WordPress support page</a>.</p>
    <p>If server is down and/or you need assistance immediatly, join the <a href=\"https://discord.gg/6svN5sS\" target=\"_blank\">VidYen Discord</a> and PM Felty. (It will ping my phone, so do not abuse. -Felty)</p>
    <p>For anyone who is trying this, we want to thank you for testing and that please let us know if you have any problems!</p>
    <p>Keep in mind that both we and the pools do take some fees, but it is generally way less than Coinhives 20% and depending on the pool you can get a smaller minimum payout.</p>
    <p>Our code is open source so if you want to run your own version, just go to our github and grab the code.</p>
    <p>In the most recent update we now use port 80 on http://cloud.vy256.com so you should no longer have to worry about your server blocking random ports. That said you still need curl installed on PHP.</p>
    <p>If cloud.vy256.com is down you can always set the shortcode attribute to cloud=1 to and open port 8081 on your server to use the backup.</p>
    <h2>Supported pool list:</h2>
    <p>moneroocean.stream</p>
    <h2>Future plans.</h2>
    <p>We do have a goal to add more pools down the road, but for now Monero Ocean works and the developer of that pool is very responsive and fair.</p>
    <p>Felty does have a goal to add MSR support due to its unique method of mining, but that will be down the road when it gets mining branches.</p>" .
    /*<p>xmrpool.eu</p>
    <p>moneropool.com</p>
    <p>monero.crypto-pool.fr</p>
    <p>monerohash.com</p>
    <p>minexmr.com</p>
    <p>usxmrpool.com</p>
    <p>supportxmr.com</p>
    <p>moneroocean.stream</p>
    <p>poolmining.org</p>
    <p>minemonero.pro</p>
    <p>xmr.prohash.net</p>
    <p>minercircle.com</p>
    <p>xmr.nanopool.org</p>
    <p>xmrminerpro.com</p>
    <p>clawde.xyz</p>
    <p>dwarfpool.com</p>
    <p>xmrpool.net</p>
    <p>monero.hashvault.pro</p>
    <p>osiamining.com</p>
    <p>killallasics</p>
    <p>arhash.xyz</p>
    <p>aeon-pool.com</p>
    <p>minereasy.com</p>
    <p>aeon.sumominer.com</p>
    <p>aeon.rupool.tk</p>
    <p>aeon.hashvault.pro</p>
    <p>aeon.n-engine.com</p>
    <p>aeonpool.xyz</p>
    <p>aeonpool.dreamitsystems.com</p>
    <p>aeonminingpool.com</p>
    <p>aeonhash.com</p>
    <p>durinsmine.com</p>
    <p>aeon.uax.io</p>
    <p>aeon-pool.sytes.net</p>
    <p>aeonpool.net</p>
    <p>supportaeon.com</p>
    <p>pooltupi.com</p>
    <p>aeon.semipool.com</p>
    <p>slowandsteady.fun</p>
    <p>trtl.flashpool.club</p>
    <p>etn.spacepools.org</p>
    <p>etn.nanopool.org</p>
    <p>etn.hashvault.pro</p>*/ "
  </div>
    ";

  	/* I may not want advertising, but I suppose putting it here never hurts */
  	//$credits_include = $VYPS_root_path . 'includes/credits.php';

}
