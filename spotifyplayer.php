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

defined( 'ABSPATH') or die('no work');

if(!class_exists('SpotifyPlayer' )){

    class SpotifyPlayer
    {
        
        function register(){
            //style in backend
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue'));
            //style in frontend
            //add_action( 'wp_enqueue_scripts', array( $this, 'enqueue'));

            add_action('admin_menu', array($this, 'add_admin_pages'));

            plugin_basename(__FILE__);

            add_filter('plugin_action_link-', array($this, 'settings_link'));
        }

        public function settings_link($links){

        }

        public add_admin_pages() {
            add_menu_page('Spotify Plugin', 'Spotify', 'manage_options', 'spotify_plugin', 
            array($this, 'admin_index'), 'dashicons-store', 110)
        }

        public function admin_index(){

        }

        protected function create_post_type(){
            add_action( 'init', array( $this, 'custom_post_type'));

        }
        
        function custom_post_type() {
            register_post_type('song', ['public' => true, 'label' => 'Songs']);
        }

        function enqueue(){
            wp_enqueue_style('mypluginstyle', plugins_url('/assets/mystyle.css', __FILE__));
            wp_enqueue_script('mypluginscript', plugins_url('/assets/myscript.js', __FILE__));

        }

        function activate() {
            require_once plugin_dir_path(__FILE__) . 'inc/plugin-activate.php';
            PluginActivate::activate();
        }
    }


    $SpotifyPlayer = new SpotifyPlayer();
    $SpotifyPlayer->register();

    register_activation_hook(__FILE__, array('PluginActivate', 'activate'));

    require_once plugin_dir_path(__FILE__) . 'inc/plugin-deactivate.php';
    register_activation_hook(__FILE__, array('PluginDeactivate', 'deactivate'));



}