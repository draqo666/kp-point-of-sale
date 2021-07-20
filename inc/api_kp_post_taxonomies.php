<?php

/**
 * Create taxonomy (depraced)
 *
 * @since 1.0.0
 *
 * @param object $data - object with taxonomies (from get_posts wordpress function)
 * @param string $taxonomy - name of taxonomies
 * 
 * @return array
 * 
 */

function api_kp_post_taxonomies($data, $taxonomy) {
    $data_array =  (array) $data;

    if(!empty($data_array)) {
        $resp = wp_insert_term( $data_array['name'], $taxonomy );
        $resp_array = (array) $resp;
        
        if(isset($resp_array['term_id'])) {
            $result = array(
                "code" => "term_added",
                "message" => "A term added",
                "data" => array(
                    "status" => 200,
                    "term_id" => $resp['term_id']
                )
            );
        } else {
            $result = array(
                "code" => "term_exists",
                "message" => "A term with the name provided already exists with this parent.",
                "data" => array(
                    "status" => 409,
                    "term_id" => $resp_array['error_data']['term_exists']
                )
            );
            http_response_code(409);
        }
    
    } else {
        $result = array(
            "code" => "rest_missing_callback_param",
            "message" => "Missing parameter(s): name",
            "data" => array(
                "status" => 400
            )
        );
        http_response_code(400);
    };

    return $result;
}

