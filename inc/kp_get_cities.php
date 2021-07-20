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
                <a href='" . get_term_link($city) . "'>
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
