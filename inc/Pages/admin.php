<?php
/**
 * @package spotifyplayer
*/
namespace Inc\Pages;

use Inc\API\SettingsAPI;
use Inc\Base\BaseController;
use Inc\API\Callbacks\AdminCallbacks;
use Inc\API\Callbacks\ManagerCallbacks;


class Admin extends BaseController{

    public $callbacks;
    public $settings;
    public $pages = array();
    public $subpages = array();

    public function register()
    {
        $this->settings = new SettingsAPI();
        
        $this->callbacks = new AdminCallbacks;

        $this->setPages();
        
        $this->setSubPages();

        $this->settings->addPages($this->pages)->withSubPage('Dashboard')->addSubPages($this->subpages)->register();
        
    }

    public function setPages()
    {
        $this->pages = array(
            array(
                'page_title' => 'Spotify Plugin', 
                'menu_title' => 'Spotify', 
                'capability' => 'manage_options', 
                'menu_slug' => 'spotify_plugin', 
                'callback' => array($this->callbacks, 'adminDashboard'),
                'icon_url' => 'dashicons-store', 
                'position' => 110
            )
        );
    }
    public function setSubPages()
    {
        $this->subpages = array( 
            array(
            'parrent_slug' => 'spotify_plugin', 
            'page_title' => 'Custom Post Types', 
            'menu_title' => 'CPT', 
            'capability' => 'manage_options', 
            'menu_slug' => 'spotify_CPT', 
            'callback' => array( $this->callbacks, 'adminCpt' )
            ),
            array(
            'parrent_slug' => 'spotify_plugin', 
            'page_title' => 'Custom Taxonomies', 
            'menu_title' => 'Taxonomies', 
            'capability' => 'manage_options', 
            'menu_slug' => 'spotify_Taxonemies', 
            'callback' => array( $this->callbacks, 'adminTaxonomy' )
            ),
            array(
            'parrent_slug' => 'spotify_plugin', 
            'page_title' => 'Custom Widgets', 
            'menu_title' => 'Widgets', 
            'capability' => 'manage_options', 
            'menu_slug' => 'spotify_Widgets', 
            'callback' => array( $this->callbacks, 'adminWidget' )
            )
        );
    }
    public function setSettings(){
        $args = array(
            array(
                'option_group' => 'spotify_option_group',
                'option_name' => 'text_example',
                'callback' => array($this->callbacks, 'spotifyOptionsGroup')

            )
        );
    }
    public function setSections(){
        
    }
    public function setFields(){
        
    }
} 

?>