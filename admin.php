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
    echo '<p>Options should go here</p>';
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