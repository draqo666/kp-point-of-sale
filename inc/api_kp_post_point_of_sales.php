<?php

/**
 * Create or update point of sale
 *
 * @since 1.0.0
 *
 * @param object $data - object with post (from get_posts wordpress function)
 * @param int $post - post id
 * 
 * @return array|int
 * 
 */
function api_kp_post_point_of_sales($data, $post) {
    $data_array =  (array) $data;
    $data_acf_array = (array) $data_array['fields'];

    error_log(print_r($data_acf_array, true));
    
    /**
     * 
     * Check if post is exist in database
     * 
     */
    
    if($post !== null) {
        $post_exist = get_post($post);

        if($post_exist === null) {
            http_response_code(404);
            $result = [
                "code" => 'rest_post_invalid_id',
                "data" => [
                    "status" => 401
                ]
            ];
        } else {
            $isupdate = wp_update_post( array(
                'ID'=> $post,
                'post_title' => isset($data_array['title']) ? $title = $data_array['title'] : "Brak nazwy"
            ));

            /**
             * Add taxonomies
             */
            $terms_added = [];
            $taxonomies = ['miasto', 'typ_placowki', 'certyfikat', 'typ_oferty'];
            foreach($taxonomies as $taxonomy) {
                if(isset($data_array[$taxonomy])) {
                    $terms = $data_array[$taxonomy];
                    $terms_added[] = kp_set_post_terms($post, $terms, $taxonomy);
                }
            }

            $acf_fields = [
                'kp_address', 
                'kp_phone', 
                'kp_phone_mobile',
                'kp_whatsapp',
                'kp_whatsapp_message',
                'kp_messenger', 
                'kp_fax',
                'kp_email', 
                'kp_email_form', 
                'kp_www',
                'kp_facebook_url',
                'kp_geo_cords_lat', 
                'kp_geo_cords_lng',
                'kp_lang'
            ];

            foreach($acf_fields as $acf_field) {
                if(isset($data_acf_array[$acf_field])) {
                    update_post_meta($post, $acf_field, $data_acf_array[$acf_field]);
                }
            }

            /**
             * Get results
             */
            $result = array(
                'details' => array(
                    'wp_update_post'    => $isupdate,
                    'kp_set_post_terms' => $terms_added
                )
            );
        }
    } else {
        $created_post_id = wp_insert_post([
            'post_title'    => isset($data_array['title']) ? $title = $data_array['title'] : "Brak nazwy",
            'post_type'     => 'salon',
            'post_status'   => 'publish',
        ]);

        /**
         * Add taxonomies
         */
        $terms_added = [];
        $taxonomies = ['miasto', 'typ_placowki', 'certyfikat', 'typ_oferty'];
        foreach($taxonomies as $taxonomy) {
            if(isset($data_array[$taxonomy])) {
                $terms = $data_array[$taxonomy];
                $terms_added[] = kp_set_post_terms($created_post_id, $terms, $taxonomy);
            }
        }
    
        /**
         * Add fields
         */
        $acf_fields = [
            'kp_address', 
            'kp_phone', 
            'kp_phone_mobile',
            'kp_whatsapp',
            'kp_whatsapp_message',
            'kp_messenger', 
            'kp_fax',
            'kp_email', 
            'kp_email_form', 
            'kp_www',
            'kp_facebook_url',
            'kp_geo_cords_lat', 
            'kp_geo_cords_lng',
            'kp_lang'
        ];

        foreach($acf_fields as $acf_field) {
            if(isset($data_acf_array[$acf_field])) {
                update_post_meta($created_post_id, $acf_field, $data_acf_array[$acf_field]);
            }
        }

        $result = array(
            'details' => array(
                'wp_insert_post' => $created_post_id,
                'kp_set_post_terms' => $terms_added
            )
        );
    }

    return $result;
}

