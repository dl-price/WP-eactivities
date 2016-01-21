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

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'login';

// This action doesn't go into register_form because it makes it more complicated to add inputs prior to the pre-existing email input
// without ruining the subsequent layout
if ($action == 'register') {
    add_action('login_footer', 'eactivities_override_registration_form');
}

add_filter('pre_option_users_can_register', 'eactivities_override_user_registration');

// Currently allows user registration for any site in which this plugin is enabled. This will change.
function eactivities_override_user_registration($allow) {
    return true;
}

function eactivities_override_registration_form() {
    $page_so_far = ob_get_contents();
    $shortcode_markup = '';

    $dom = new DOMDocument();
    $dom->loadHTML($page_so_far);

    $xpath = new DOMXPath($dom);
    $form = $xpath->query('//form')->item(0);

    $email = $xpath->query('//label[@for=\'user_email\']')->item(0)->parentNode;

    $shortcode = create_user_registration_element($dom, 'user_shortcode', 'Shortcode');

    $form->insertBefore($shortcode, $email);

    $firstname = create_user_registration_element($dom, 'first_name', 'First Name');
    $form->insertBefore($firstname, $email);

    $lastname = create_user_registration_element($dom, 'last_name', 'Last Name');
    $form->insertBefore($lastname, $email);

    ob_get_clean();
    echo $dom->saveHTML();
}

function create_user_registration_element($dom, $input_id, $input_label) {
    $e = $dom->createElement('p');
    $e_inner = $dom->createDocumentFragment();
    $e_inner->appendXML('<label for="' . $input_id . '">' . $input_label . '<input type="text" name="' . $input_id . '" id="' . $input_id . '" class="input" value="" size="20" /></label>');
    $e->appendChild($e_inner);

    return $e;
}