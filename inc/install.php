<?php

/**
 * 
 * @since 1.0.0
 * 
 * During instalation I have to require another plugin to be enable
 *
 */

register_activation_hook( __FILE__, 'child_plugin_activate' );
function child_plugin_activate(){
    // Require parent plugin
    if ( ! 
        is_plugin_active( 'acf-to-rest-api/class-acf-to-rest-api.php' ) && 
        is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) and current_user_can( 'activate_plugins' ) ) {
        // Stop activation redirect and show error
        wp_die('Sorry, but this plugin requires plugin the ACF to Rest API, ACF, and Custom Post Type UI to be installed and active. <br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');
    }
}

