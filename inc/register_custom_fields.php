<?php
/**
 * 
 * Add fields to options page
 * - `acf-options-ustawienia-salony`
 * 
 * Add fields to post types
 * - `salon`
 * - `messages`
 * 
 * Add fields to taxonomies
 * - `typ_placowki`
 * - `certyfikat`
 * - `typ_oferty`
 * - `typ_placowki`
 * 
 */

if( function_exists('acf_add_local_field_group') ):

    /**
     * Only options_page
     */
    acf_add_local_field_group(array(
        'key' => 'group_5d1464d881227',
        'title' => 'Opcje',
        'fields' => array(
            array(
                'key' => 'field_5d1464e2c6fa3',
                'label' => __( 'Tekst główny modułu', 'kp-point-of-sale' ),
                'name' => 'kp_body_main_content',
                'type' => 'wysiwyg',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'delay' => 0,
            ),
            array(
                'key' => 'field_5d15d51d67b7e',
                'label' => __( 'Treść zgody w formularzach', 'kp-point-of-sale' ),
                'name' => 'kp_form_agreement',
                'type' => 'textarea',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'new_lines' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options-ustawienia-salony',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
    ));
    acf_add_local_field_group(array(
        'key' => 'group_5d39d40e9f855',
        'title' => 'reCAPTCHA 3',
        'fields' => array(
            array(
                'key' => 'field_5d39d417e8afa',
                'label' => __( 'Klucz publiczny', 'kp-point-of-sale' ),
                'name' => 'recaptcha_public_key',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_5d39d435e8afb',
                'label' => __( 'Klucz prywatny', 'kp-point-of-sale' ),
                'name' => 'recaptcha_secret_key',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options-ustawienia-salony',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
    ));
    
    /**
     * Fields in post type `salon `
     */
    acf_add_local_field_group(array(
        'key' => 'group_5cc09fe62bdfe',
        'title' => __( 'Dane punktu sprzedaży', 'kp-point-of-sale' ),
        'fields' => array(
            array(
                'key' => 'field_5cc09ff3f558a',
                'label' => __( 'Adres', 'kp-point-of-sale' ),
                'name' => 'kp_address',
                'type' => 'text',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => __( 'np. Jesionowa 5/15', 'kp-point-of-sale' ),
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_5cc0a00ef558b',
                'label' => __( 'Telefon', 'kp-point-of-sale' ),
                'name' => 'kp_phone',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'min' => '',
                'max' => '',
                'step' => '',
            ),
            array(
                'key' => 'field_5cc0a064f558c',
                'label' => __( 'Telefon komórkowy', 'kp-point-of-sale' ),
                'name' => 'kp_phone_mobile',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'min' => '',
                'max' => '',
                'step' => '',
            ),
            array(
                'key' => 'field_5cc0a064f558g',
                'label' => __( 'Whatsapp', 'kp-point-of-sale' ),
                'name' => 'kp_whatsapp',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'min' => '',
                'max' => '',
                'step' => '',
            ),
            array(
                'key' => 'field_5cc0a064f558i',
                'label' => __( 'Whatsapp wiadomość powitalna', 'kp-point-of-sale' ),
                'name' => 'kp_whatsapp_message',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'min' => '',
                'max' => '',
                'step' => '',
            ),
            array(
                'key' => 'field_5cc0a064f558h',
                'label' => __( 'Messenger', 'kp-point-of-sale' ),
                'name' => 'kp_messenger',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'min' => '',
                'max' => '',
                'step' => '',
            ),
            array(
                'key' => 'field_5cc0a07ff558d',
                'label' => __( 'Fax', 'kp-point-of-sale' ),
                'name' => 'kp_fax',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'min' => '',
                'max' => '',
                'step' => '',
            ),
            array(
                'key' => 'field_5cc0a08df558e',
                'label' => __( 'E-mail', 'kp-point-of-sale' ),
                'name' => 'kp_email',
                'type' => 'email',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
            array(
                'key' => 'field_5cc0a09df558f',
                'label' => __( 'E-mail dla formularza', 'kp-point-of-sale' ),
                'name' => 'kp_email_form',
                'type' => 'email',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
            array(
                'key' => 'field_5cc0a0b9f5590',
                'label' => __( 'WWW', 'kp-point-of-sale' ),
                'name' => 'kp_www',
                'type' => 'url',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
            ),
            array(
                'key' => 'field_5cc0a0cdf5591',
                'label' => __( 'Facebook URL', 'kp-point-of-sale' ),
                'name' => 'kp_facebook_url',
                'type' => 'url',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
            ),
            array(
                'key' => 'field_5cc0a0e2f5592',
                'label' => __( 'Geo Cords (lat)', 'kp-point-of-sale' ),
                'name' => 'kp_geo_cords_lat',
                'type' => 'text',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_5cc14b3c75353',
                'label' => __( 'Geo Cords (lng)', 'kp-point-of-sale' ),
                'name' => 'kp_geo_cords_lng',
                'type' => 'text',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_5d26e0b9884e5',
                'label' => __( 'Kraj', 'kp-point-of-sale' ),
                'name' => 'kp_lang',
                'type' => 'select',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'pl_PL' => 'PL',
                    'en_US' => 'EN',
                    'sk_SK' => 'SK',
                    'de_DE' => 'DE',
                    'sv_SE' => 'SV',
                    'cs_CZ' => 'CS',
                    'fr_FR' => 'FR',
                    'ro_RO' => 'RO',
                ),
                'default_value' => array(
                ),
                'allow_null' => 0,
                'multiple' => 0,
                'ui' => 0,
                'ajax' => 0,
                'return_format' => 'value',
                'placeholder' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'salon',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
    ));

    /**
     * Fields in post type `messages`
     */
    acf_add_local_field_group(array(
        'key' => 'group_5d134fbf73a2b',
        'title' => __( 'Formularze', 'kp-point-of-sale' ),
        'fields' => array(
            array(
                'key' => 'field_5d13500f39eb1',
                'label' => __( 'Adresat', 'kp-point-of-sale' ),
                'name' => 'kp_form_to',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_5d134fc31a385',
                'label' => __( 'Nadawca', 'kp-point-of-sale' ),
                'name' => 'kp_form_name',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_5d134fcc1a386',
                'label' => __( 'E-mail', 'kp-point-of-sale' ),
                'name' => 'kp_form_mail',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_5d134fda1a387',
                'label' => __( 'Telefon', 'kp-point-of-sale' ),
                'name' => 'kp_form_phone',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_5d134fe01a388',
                'label' => __( 'Treść', 'kp-point-of-sale' ),
                'name' => 'kp_form_message',
                'type' => 'textarea',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'new_lines' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'form_messages',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
    ));

    /**
     * Fields in taxonomy `typ_placowki`, `certyfikat`, `typ_oferty`
     */
    acf_add_local_field_group(array(
        'key' => 'group_5cc0a21fd63a1',
        'title' => __( 'Ikony', 'kp-point-of-sale' ),
        'fields' => array(
            array(
                'key' => 'field_5cc0a24a6c859',
                'label' => __( 'Ikona', 'kp-point-of-sale' ),
                'name' => 'kp_icon',
                'type' => 'image',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
                'min_width' => '',
                'min_height' => '',
                'min_size' => '',
                'max_width' => '',
                'max_height' => '',
                'max_size' => '',
                'mime_types' => '',
            ),

        ),
        'location' => array(
            array(
                array(
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'typ_placowki',
                ),
            ),
            array(
                array(
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'certyfikat',
                ),
            ),
            array(
                array(
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'typ_oferty',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
    ));
    
    /**
     * Fields only in `typ_placowki`
     */
    acf_add_local_field_group(array(
        'key' => 'group_5cc0b21fd63a1',
        'title' => __( 'Typ placówki', 'kp-point-of-sale' ),
        'fields' => array(
            array(
                'key' => 'field_5ac0a25f6c85a',
                'label' => __( 'Ikona na mapie', 'kp-point-of-sale' ),
                'name' => 'kp_icon_map',
                'type' => 'image',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
                'min_width' => '',
                'min_height' => '',
                'min_size' => '',
                'max_width' => '',
                'max_height' => '',
                'max_size' => '',
                'mime_types' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'typ_placowki',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
    ));
    acf_add_local_field_group(array(
        'key' => 'group_5d22e184b459c',
        'title' => __( 'Pozycjonowanie', 'kp-point-of-sale' ),
        'fields' => array(
            array(
                'key' => 'field_5d22e18b475db',
                'label' => __( 'Wartość pozycji', 'kp-point-of-sale' ),
                'name' => 'kp_value_position',
                'type' => 'select',
                'instructions' => __( 'Ustal wartość pozycjonowania elementu. Jeśli zaznaczysz wartość 1 - element będzie sortowany jako pierwszy, jeśli 10 element będzie sortowany jako ostatni.', 'kp-point-of-sale' ),
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    1 => '1',
                    2 => '2',
                    3 => '3',
                    4 => '4',
                    5 => '5',
                    6 => '6',
                    7 => '7',
                    8 => '8',
                    9 => '9',
                    10 => '10',
                ),
                'default_value' => array(
                    0 => 1,
                ),
                'allow_null' => 0,
                'multiple' => 0,
                'ui' => 0,
                'ajax' => 0,
                'return_format' => 'value',
                'placeholder' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'typ_placowki',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
    ));
    
    /**
     * Fields only in `typ_oferty`
     */
    acf_add_local_field_group(array(
        'key' => 'group_5cc1b21fd63a1',
        'title' => __( 'Typ oferty', 'kp-point-of-sale' ),
        'fields' => array(
            array(
                'key' => 'field_5d09f332187c1',
                'label' => __( 'URL Oferty (redirect)', 'kp-point-of-sale' ),
                'name' => 'kp_url_redirect',
                'type' => 'url',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'typ_oferty',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
    ));

    /**
     * Fields only in `certyfikaty`
     */
    acf_add_local_field_group(array(
        'key' => 'group_5d2d75c452d1d',
        'title' => __( 'Kolory', 'kp-point-of-sale' ),
        'fields' => array(
            array(
                'key' => 'field_5d2d75cbf93a9',
                'label' => __( 'Kolor', 'kp-point-of-sale' ),
                'name' => 'kp_tag_color',
                'type' => 'color_picker',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '#C3C3C3',
            ),
            array(
                'key' => 'field_5d2d78e4ac1c7',
                'label' => __( 'Kolor text', 'kp-point-of-sale' ),
                'name' => 'kp_tag_color_text',
                'type' => 'color_picker',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'certyfikat',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
    ));

endif;

function my_acf_init() {
    acf_update_setting('google_api_key', 'AIzaSyArkvvOTs5gWeotFnu43uNgiPNnGpORIGU');
}
add_action('acf/init', 'my_acf_init');
