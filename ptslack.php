<?php
/**
* Plugin Name: Pountech Slack
* Description: A simple slack integration plugin
* Version: 1.0.0
* Author: Mohamed Mokhtar
* License: GPL2
*/

// prevent direct file access
defined( 'ABSPATH' ) or die( 'No script please!' );


require_once 'vendor/autoload.php';



function ptslack_channels_func( $atts , $slack=null ) {
    $slack = ( $slack ) ? $slack : new wrapi\slack\slack(get_option("slack_token"));

    $channels = $slack->conversations->list(array("exclude_archived" => 1));

    if  ( !$channels['ok'] ) {
        return "<strong>" . __("Something went wrong", 'ptslack') . "</strong>";
    }

    if ( empty( $channels['channels'] ) ) {
        return "<strong>" . __("No Channels to view", 'ptslack') . "</strong>";
    }
    


    $return = "<ul>";

    foreach ( $channels['channels'] as $channel ) {
        $return .= "<li><h3>{$channel['name']}</h3><p>{$channel['purpose']['value']}</p></li>";
    }

    $return .= "</ul>";

    return $return;

 }
 add_shortcode( "ptslack_channels", "ptslack_channels_func" );
 


// Register the menu.
add_action( "admin_menu", "ptslack_plugin_menu_func" );
function ptslack_plugin_menu_func() {
   add_submenu_page( "options-general.php",
        "Pountech Slack",
        "Pountech Slack",
        "manage_options",
        "pountechslack",
        "ptslack_plugin_options"
    );
}

// Print the markup for the page
function ptslack_plugin_options() {
   if ( !current_user_can( "manage_options" ) )  {
      wp_die( __( "You do not have sufficient permissions to access this page." ) );
   }
?>


<form method="post" action="<?php echo admin_url( 'admin-post.php'); ?>">

   <input type="hidden" name="action" value="update_ptslack_settings" />

   <h3>Access Token Submit</h3>

   <p>
      <label><?php _e("Slack App access token", "ptslack"); ?></label>
      <input class="" type="password" name="slack_token" value="<?php echo get_option('slack_token')?>" />
   </p>

   <input class="button button-primary" type="submit" value="<?php _e("Save", "ptslack"); ?>" />

</form>


<?php
}


// handle save plugin settings
add_action( 'admin_post_update_ptslack_settings', 'ptslack_handle_save' );
function ptslack_handle_save() {
    // Get the options that were sent
   $token = (!empty($_POST["slack_token"])) ? $_POST["slack_token"] : NULL;

   // Update the values
   update_option( "slack_token", $token, TRUE );

   // Redirect back to settings page
   $redirect_url = get_bloginfo("url") . "/wp-admin/options-general.php?page=pountechslack&status=success";
   header("Location: ".$redirect_url);
   exit;
}