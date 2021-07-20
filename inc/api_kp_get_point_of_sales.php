<?php

/**
 * Get all point of sales
 *
 *
 * @since 1.0.0
 *
 * @param empty
 * 
 * @return json
 */


function api_kp_get_point_of_sales() {
    $args = array(
        'posts_per_page'   => -1,
        'orderby'          => 'date',
        'order'            => 'DESC',
        'post_type'        => 'salon',
        'post_status'      => 'publish',
        'suppress_filters' => true,
    );
    $posts = get_posts($args);
    $result = [];

    foreach($posts as $post) {
        /**
         * Get fields
         */
        $post_array =  (array) $post;

        /**
         * Parse mordern REST API to Plugin API
         */
        $post_target['id'] = $post_array['ID'];
        $post_target['title']['rendered'] = $post_array['post_title'];
        $post_target['status'] = $post_array['post_status'];
        $post_target['id'] = $post_array['ID'];

        $typ_oferty = api_kp_get_taxonomies('typ_oferty', $post_array['ID']);
        $typ_oferty_array = wp_list_pluck( $typ_oferty, 'name' );

        $certyfikat = api_kp_get_taxonomies('certyfikat', $post_array['ID']);
        $certyfikat_array = wp_list_pluck( $certyfikat, 'name' );

        $acf['acf'] = [
            'kp_address'        => (get_post_meta($post_array['ID'], 'kp_address')) ? get_post_meta($post_array['ID'], 'kp_address')[0] : '', 
            'kp_phone'          => (get_post_meta($post_array['ID'], 'kp_phone')) ? get_post_meta($post_array['ID'], 'kp_phone')[0] : '', 
            'kp_phone_mobile'   => (get_post_meta($post_array['ID'], 'kp_phone_mobile')) ? get_post_meta($post_array['ID'], 'kp_phone_mobile')[0] : '', 
            'kp_whatsapp'       => (get_post_meta($post_array['ID'], 'kp_whatsapp')) ? get_post_meta($post_array['ID'], 'kp_whatsapp')[0] : '', 
            'kp_whatsapp_message'       => (get_post_meta($post_array['ID'], 'kp_whatsapp_message')) ? get_post_meta($post_array['ID'], 'kp_whatsapp_message')[0] : '', 
            'kp_messenger'       => (get_post_meta($post_array['ID'], 'kp_messenger')) ? get_post_meta($post_array['ID'], 'kp_messenger')[0] : '', 
            'kp_fax'            => (get_post_meta($post_array['ID'], 'kp_fax')) ? get_post_meta($post_array['ID'], 'kp_fax')[0] : '', 
            'kp_email'          => (get_post_meta($post_array['ID'], 'kp_email')) ? get_post_meta($post_array['ID'], 'kp_email')[0] : '', 
            'kp_email_form'     => (get_post_meta($post_array['ID'], 'kp_email_form')) ? get_post_meta($post_array['ID'], 'kp_email_form')[0] : '', 
            'kp_www'            => (get_post_meta($post_array['ID'], 'kp_www')) ? get_post_meta($post_array['ID'], 'kp_www')[0] : '', 
            'kp_facebook_url'   => (get_post_meta($post_array['ID'], 'kp_facebook_url')) ? get_post_meta($post_array['ID'], 'kp_facebook_url')[0] : '', 
            'kp_geo_cords_lat'  => (get_post_meta($post_array['ID'], 'kp_geo_cords_lat')) ? get_post_meta($post_array['ID'], 'kp_geo_cords_lat')[0] : '', 
            'kp_geo_cords_lng'  => (get_post_meta($post_array['ID'], 'kp_geo_cords_lng')) ? get_post_meta($post_array['ID'], 'kp_geo_cords_lng')[0] : '', 
            'kp_lang'           => (get_post_meta($post_array['ID'], 'kp_lang')) ? get_post_meta($post_array['ID'], 'kp_lang')[0] : '', 
            'typ_placowki'      => (api_kp_get_taxonomies('typ_placowki', $post_array['ID'])[0]['name']) ? api_kp_get_taxonomies('typ_placowki', $post_array['ID'])[0]['name'] : '',
            'typ_oferty'        => implode(",\n", $typ_oferty_array), 
            'miasto'            => (api_kp_get_taxonomies('miasto', $post_array['ID'])[0]['name']) ? api_kp_get_taxonomies('miasto', $post_array['ID'])[0]['name'] : '', 
            'certyfikat'        => implode(",\n", $certyfikat_array),
        ];


        /**
         * Prepare Taxonomies proparties
         */
        $tax_types = ['miasto', 'typ_placowki', 'typ_oferty', 'certyfikat'];
        foreach($tax_types as $tax_type) {
            $taxs = get_the_terms($post_array['ID'], $tax_type);
            if($taxs === false) {
                $taxonomies[$tax_type] = [];
            } else {
                foreach($taxs as $tax) {
                    $taxonomies[$tax_type][] = $tax->term_id;
                }
            }
        }

        /**
         * Merge all
         */

        $post_array = $post_target + $acf + $taxonomies;

        $result[] = $post_array;
    }

    return $result;
}

