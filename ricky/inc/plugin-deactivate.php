<?php
/**
 * @package spotifyplayer
*/

class PluginDeactivate{
    public static function deactivate(){
        flush_rewrite_rules();
    }
}
