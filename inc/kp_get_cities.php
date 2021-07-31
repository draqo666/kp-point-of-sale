<?php

/**
 * 
 * @since 1.0.0
 * 
 * Generate list of cities from posts
 * 
 * @param array - posts
 *  ['post_obj'] - object posts from wordpress
 * @return string - with dom to echo 
 *
 */

add_action( 'wp_ajax_nopriv_get_city_results','get_city_results' );
add_action( 'wp_ajax_get_city_results','get_city_results' );
function get_city_results() {
	$city = $_POST['city_name'];

	$langCode = (apply_filters( 'wpml_current_language', NULL ) == 'pl') ? 'index.php' : apply_filters( 'wpml_current_language', NULL );

	$request = wp_remote_get('https://nominatim.openstreetmap.org/search?q='.$city.'&format=json&polygon=1&addressdetails=1&countrycodes='.$langCode);

	if( is_wp_error( $request ) ) {
		return false;
	}

	$body = wp_remote_retrieve_body( $request );
	$data = json_decode($body);

	wp_send_json('/?s='.$data[0]->display_name.'&lng='.$data[0]->lon.'&lat='.$data[0]->lat.'&distance=25&post_type=salon');
}

function kp_get_cities($posts)
{
	$pids = [];
	foreach ($posts as $p) {
		$pids[] = $p['post_obj']->ID;
	}

	$found = false;
	$all_city = wp_get_object_terms($pids, 'miasto');

	foreach ($all_city as $city) {
		echo "
            <div class='city' data-letter='" . strtoupper(substr($city->name, 0, 1)) . "'>
                <a href='" . get_term_link($city) . "' class='get_city_link' data-city-name='".$city->name."'>
                    <div class='city_inner_wrapper'>
                        <p>" . $city->name . "</p>
                        <p>
                            " . $city->count . " " . _plural_word_salon($city->count) . "
                        </p>
                    </div>
                </a>
            </div>
        ";
	}
}

function _plural_word_salon($count)
{
	if ($count === 1) {
		return __('salon', 'kp-point-of-sale');
	} else if ($count >= 2 && $count < 5) {
		return __('salony', 'kp-point-of-sale');
	} else {
		return __('salonów', 'kp-point-of-sale');
	}
}
