<?php

/**
 * @package spotifyplayer
*/
/*
Plugin Name: Spotify Player 
Plugin URI: http://SpotifyPlayer 
Description: This is my first Wordpress Plugin about creating a spotify player
Version: 1.0.0
Author: Riccardo Ramos
Text Domain: spotify
*/

$clientId = '747c64ed25b24a1a896d61bc8c3a181f';
$clientSecret = '178f5fefe8ae4514a7503366ffeebdd2';



//If the file gets opened seperatly
defined( 'ABSPATH') or die('no work, wrong way');

//Require once the Composer Autoload
if(file_exists(dirname(__FILE__) . '/vendor/autoload.php')){
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}
define('PLUGIN', plugin_basename(__FILE__));

//Code that runs during plugin activation
function activate_spotify_plugin(){
    Inc\Base\Activate::activate();
}
register_activation_hook(__FILE__, 'activate_spotify_plugin');

//Code that runs during plugin deactivation
function deactivate_spotify_plugin(){
    Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook(__FILE__, 'deactivate_spotify_plugin');

if(class_exists('Inc\\Init' )){
    Inc\Init::register_services();
}

require_once(plugin_dir_path(__FILE__) . 'SpotifyAPI.php');

if(class_exists('SpotifyAPI')){
    $spotifyAPI = new SpotifyAPI($clientId, $clientSecret);
}
require_once(plugin_dir_path(__FILE__) . '/templates/admin.php');

if(class_exists('Admin')){
   $admin = new Admin();
}
