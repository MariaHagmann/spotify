<?php //Code von Matthias
class Admin
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_plugin_page'));
        add_action('admin_init', array($this, 'page_init'));
    }

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

    public function page_init()
    {
        // Register person field
        register_setting(
            'spotifyplayer_settings',
            'spotifyplayerselectPerson',
            array($this, 'selectPerson')
        );

        // Register ClientID and ClientSecret fields
        register_setting(
            'spotifyplayer_settings',
            'spotifyplayer_clientID'
        );
        register_setting(
            'spotifyplayer_settings',
            'spotifyplayer_clientSecret'
        );

        add_settings_section(
            'spotifyplayer_section',
            'Settings',
            array($this, 'print_section_info'),
            'spotifyplayer_settings'
        );

        add_settings_field(
            'spotifyplayerselectPerson',
            'person',
            array($this, 'person_callback'),
            'spotifyplayer_settings',
            'spotifyplayer_section'
        );

        // Add ClientID and ClientSecret fields
        add_settings_field(
            'spotifyplayer_clientID',
            'Client ID',
            array($this, 'clientID_callback'),
            'spotifyplayer_settings',
            'spotifyplayer_section'
        );

        add_settings_field(
            'spotifyplayer_clientSecret',
            'Client Secret',
            array($this, 'clientSecret_callback'),
            'spotifyplayer_settings',
            'spotifyplayer_section'
        );
    }

    public function person_callback()
    {
        $value = get_option('spotifyplayerselectPerson', 'Ricky');
        echo '<select name="spotifyplayerselectPerson">';
        echo '<option value="Timo" ' . selected($value, 'Timo', false) . '>Timo</option>';
        echo '<option value="Maria" ' . selected($value, 'Maria', false) . '>Maria</option>';
        echo '<option value="Ricky" ' . selected($value, 'Ricky', false) . '>Ricky</option>';
        echo '</select>';
    }

    // ClientID callback
    public function clientID_callback()
    {
        $value = get_option('spotifyplayer_clientID');
        echo '<input type="text" name="spotifyplayer_clientID" value="' . esc_attr($value) . '">';
    }

    // ClientSecret callback
    public function clientSecret_callback()
    {
        $value = get_option('spotifyplayer_clientSecret');
        echo '<input type="text" name="spotifyplayer_clientSecret" value="' . esc_attr($value) . '">';
    }

    public function print_section_info()
    {
        print 'Choose person for view of the spotifyplayer and enter your Client ID and Secret:';
    }

}