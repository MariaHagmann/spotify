<?php
/**
 * @package spotifyplayer
*/

namespace Inc;

final class Init{

    /*
    *Store all the classes inside an array
    * @return array Full list of classes
    */
    public static function get_services(){
        return [
            Pages\Admin::class,
            Base\Enqueue::class,
            Base\SettingsLinks::class

        ];
    }
    /*
    * Loop through the classes, initialize them, and call the register() method if it exists
    * @return
    */
    public static function register_services(){
        foreach(self::get_services() as $class){
            $service = self::instantiate($class);

            if(method_exists($service, 'register')){
                $service->register();
            }
        }
    }

    /*
    * Initialize the class
    * @param class $class from the services array
    * @return class instance  new instance of the class
    */
    private static function instantiate($class){
        $service = new $class();
        return $service;
    }
}


/*
<?php
use Inc\Base\Activate;
use Inc\Base\Deactivate;
use Inc\Admin\AdminPages;
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


defined( 'ABSPATH') or die('no work');

if(file_exists(dirname(__FILE__) . '/vendor/autoload.php')){
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}



if(!class_exists('SpotifyPlayer' )){

    class SpotifyPlayer
    {
        public $plugin;

        function __construct(){
            $this->plugin = plugin_basename(__FILE__);
        }

        function register(){
            //style in backend
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue'));
            //style in frontend
            //add_action( 'wp_enqueue_scripts', array( $this, 'enqueue'));

            add_action('admin_menu', array($this, 'add_admin_pages'));

            add_filter("plugin_action_links_$this->plugin", array($this, 'settings_link'));
        }

        public function settings_link($links){
            $settings_link = '<a href="admin.php?page=spotify_plugin">Settings</a>';
            array_push($links, $settings_link);
            return $links;
        }

        public function add_admin_pages() {
            add_menu_page('Spotify Plugin', 'Spotify', 'manage_options', 'spotify_plugin', 
            array($this, 'admin_index'), 'dashicons-store', 110);
        }

        public function admin_index(){
            require_once plugin_dir_path(__FILE__) . 'templates/admin.php';
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
            //require_once plugin_dir_path(__FILE__) . 'inc/plugin-activate.php';
            Activate::activate();
        }
        function deactivate() {
            //require_once plugin_dir_path(__FILE__) . 'inc/plugin-activate.php';
            Deactivate::deactivate();
        }
    }


    $SpotifyPlayer = new SpotifyPlayer();
    $SpotifyPlayer->register();

    register_activation_hook(__FILE__, array($SpotifyPlayer, 'activate'));

    //require_once plugin_dir_path(__FILE__) . 'inc/Deactivate.php';
    register_activation_hook(__FILE__, array($SpotifyPlayer, 'deactivate'));



}
*/
?>