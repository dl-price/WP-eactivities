<?php
/**
 * Plugin Name: WP Eactivities
 * Description: This plugin adds some features to connect to ICU eactivities and LDAP
 * Version: 1.0.0
 * Author: Daniel Price
 * Author URI: http://dlprice.co.uk
 * License: GPL2
 */

require plugin_dir_path( __FILE__ ) . 'admin.php';

add_filter('pre_option_users_can_register', 'eactivities_override_user_registration');

function eactivities_override_user_registration($allow) {
    return true;
}