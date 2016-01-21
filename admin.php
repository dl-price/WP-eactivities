<?php

add_action('admin_menu', 'eactivities_admin_menu');


    add_action('admin_init', 'register_eactivities_options');


function eactivities_admin_menu() {
    add_options_page('Eactivities options', 'Eactivities', 'manage_options', 'icu-eactivities', 'eactivities_options');
}

function eactivities_options() {
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    ?>
    <div class="wrap">
    <h2>ICU Eactivities</h2>

        <form method="post" action="options.php">

            <?php
            settings_fields('icu-users');
            do_settings_sections('icu-users');
            submit_button(); ?>
        </form>
    </div>
    <?php
}

function register_eactivities_options() {
        add_settings_section('icu-users', 'Users', null, 'icu-users');

        add_settings_field('allow_custom_usernames', 'Allow custom usernames', 'display_allow_custom_usernames', 'icu-users', 'icu-users');

    register_setting('icu-users', 'allow_custom_usernames');
}

function display_allow_custom_usernames() {
    ?>
    <input type="checkbox" name="allow_custom_usernames" value="1" <?php checked(1, get_option('allow_custom_usernames'), true); ?> />
<?php

}

