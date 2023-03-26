<?php

/**
 * Trigger this file in Plugin uninstall
 * 
 * @package spotifyplayer
*/

if(!defined('WP_UNINSTALL_PLUGIN')){
    die;
}

//cleare DB stored data
/**$songs = get_posts(array('post_type' => 'song', 'numberposts' => -1));

foreach($songs as $song){
    wp_delete_post($song->ID, true);
} 
*/

global $wpbd;
$wpbd->query("DELETE FROM wp_posts WHERE post_type = 'song'");