<?php

add_action('admin_menu', 'eactivities_admin_menu');

function eactivities_admin_menu() {
    add_options_page('Eactivities options', 'Eactivities', 'manage_options', 'dlp-eactivities', 'eactivities_options');
}

function eactivities_options() {
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    echo '<p>Options should go here</p>';
}