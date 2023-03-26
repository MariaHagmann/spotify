<?php
class Admin
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_plugin_page'));
        add_action('admin_init', array($this, 'page_init'));
    }

    // Add options page
    public function add_plugin_page()
    {
        add_menu_page(
            'Spotify Settings',
            'spotifyplayer',
            'manage_options',
            'spotifyplayer',
            array($this, 'create_admin_page')
        );
    }

    // Create options page
    public function create_admin_page()
    {
        ?>
        <div class="wrap">
            <h1>spotifyplayer Settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('spotifyplayer_settings');
                do_settings_sections('spotifyplayer_settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    // Register and add fields for a select between 3 values "Timo", "Maria" and "Ricky"
    public function page_init()
    {
        register_setting(
            'spotifyplayer_settings',
            'spotifyplayer__selectPerson',
            array($this, 'selectPerson')
        );
        add_settings_field(
            'spotifyplayer__selectPerson',
            'person',
            array($this, 'person_callback'),
            'spotifyplayer_settings',
            'spotifyplayer_section'
        );
    }

    //Person callback
    public function person_callback()
    {
        $value = get_option('spotifyplayerselectPerson', 'Ricky');
        echo '<select name="spotifyplayerselectPerson">';
        echo '<option value="Timo" ' . selected($value, 'Timo', false) . '>Timo</option>';
        echo '<option value="Maria" ' . selected($value, 'Maria', false) . '>Maria</option>';
        echo '<option value="Ricky" ' . selected($value, 'Ricky', false) . '>Ricky</option>';
        echo '</select>';
    }
    
        // Print section information
        public function print_section_info()
        {
            print 'Choose person for view of the spotifyplayer:';
        }

}