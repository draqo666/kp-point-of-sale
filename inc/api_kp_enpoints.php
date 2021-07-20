<?php

/**
 * Prepare endpoint urls
 *
 *
 * @since 1.0.0
 *
 * @param array $data
 * 
 * @return json
 * 
 */

function isValidJSON($str) {
    json_decode($str);
    return json_last_error() == JSON_ERROR_NONE;
}

add_action( 'init', function() {
    if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
        if(isset($_GET['rest_api'])) {
            if($_GET['rest_api'] === 'true') {
                if(isset($_GET['endpoint'])) {
                    if($_GET['endpoint'] === 'point-of-sales') {
                        $data = file_get_contents("php://input");

                        if(isset($_GET['post'])) {
                            $result = api_kp_post_point_of_sales(json_decode($data, true), $_GET['post']);
                        } else {
                            $result = api_kp_post_point_of_sales(json_decode($data, true), null);
                        }

                        wp_send_json($result);
                    } else if ($_GET['endpoint'] === 'point-of-sales/typ_oferty') {

                        $data = file_get_contents("php://input");
                        $result = api_kp_post_taxonomies(json_decode($data, true), 'typ_oferty');
                        wp_send_json($result);

                    } else if ($_GET['endpoint'] === 'point-of-sales/miasto') {

                        $data = file_get_contents("php://input");
                        $result = api_kp_post_taxonomies(json_decode($data, true), 'miasto');
                        wp_send_json($result);

                    } else if ($_GET['endpoint'] === 'point-of-sales/certyfikat') {

                        $data = file_get_contents("php://input");
                        $result = api_kp_post_taxonomies(json_decode($data, true), 'certyfikat');
                        wp_send_json($result);

                    } else if ($_GET['endpoint'] === 'point-of-sales/typ_placowki') {

                        $data = file_get_contents("php://input");
                        $result = api_kp_post_taxonomies(json_decode($data, true), 'typ_placowki');
                        wp_send_json($result);

                    } else {
                        wp_send_json([
                            'message' => "This endpoint is not exist!"
                        ]);
                        http_response_code(404);
                    }
                }

            }
        }
    } else if( $_SERVER['REQUEST_METHOD'] === 'GET' ) {
        if(isset($_GET['rest_api'])) {
            if($_GET['rest_api'] === 'true') {
                if(isset($_GET['endpoint'])) {
                    if($_GET['endpoint'] === 'point-of-sales') {

                        $result = api_kp_get_point_of_sales();
                        wp_send_json($result);

                    } else if ($_GET['endpoint'] === 'point-of-sales/typ_oferty') {
                        if(isset($_GET['post'])) {
                            $result = api_kp_get_taxonomies('typ_oferty', $_GET['post']);
                            wp_send_json($result);
                        } else {
                            wp_send_json([
                                'message' => "Don't find post!"
                            ]);
                            http_response_code(404);
                        }
                    } else if ($_GET['endpoint'] === 'point-of-sales/miasto') {

                        if(isset($_GET['post'])) {
                            $result = api_kp_get_taxonomies('miasto', $_GET['post']);
                            wp_send_json($result);
                        } else {
                            wp_send_json([
                                'message' => "Don't find post!"
                            ]);
                            http_response_code(404);
                        }

                    } else if ($_GET['endpoint'] === 'point-of-sales/certyfikat') {

                        if(isset($_GET['post'])) {
                            $result = api_kp_get_taxonomies('certyfikat', $_GET['post']);
                            wp_send_json($result);
                        } else {
                            wp_send_json([
                                'message' => "Don't find post!"
                            ]);
                            http_response_code(404);
                        }

                    } else if ($_GET['endpoint'] === 'point-of-sales/typ_placowki') {

                        if(isset($_GET['post'])) {
                            $result = api_kp_get_taxonomies('typ_placowki', $_GET['post']);
                            wp_send_json($result);
                        } else {
                            wp_send_json([
                                'message' => "Don't find post!"
                            ]);
                            http_response_code(404);
                        }

                    } else {
                        wp_send_json([
                            'message' => "This endpoint is not exist!"
                        ]);
                        http_response_code(404);
                    }
                } else {
                    wp_send_json([
                        'message' => "Don't find endpoint!"
                    ]);
                    http_response_code(404);
                }
                exit;
            }
        }
    } else {
        wp_send_json([
            'message' => "Don't know what is request method!"
        ]);
        http_response_code(404);
        wp_die();
    }
});

