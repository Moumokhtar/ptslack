<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
 
// delete slack token option
delete_option('slack_token');

// delete pages on uninstall
$channel_list_page = get_page_by_title( 'Slack Channels' );

if ( $channel_list_page ) {
    wp_delete_post( $channel_list_page->ID, true );
}