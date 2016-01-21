<?php

add_action('admin_menu', 'eactivities_admin_menu');

// This action doesn't go into register_form because it makes it more complicated to add inputs prior to the pre-existing email input
// without ruining the subsequent layout
add_action('login_footer', 'eactivities_override_registration_form');

function eactivities_admin_menu() {
    add_options_page('Eactivities options', 'Eactivities', 'manage_options', 'dlp-eactivities', 'eactivities_options');
}

function eactivities_options() {
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    ?>
    <div class="wrap">
    <h2>ICU Eactivities</h2>

        <form method="post" action="options.php">

            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

