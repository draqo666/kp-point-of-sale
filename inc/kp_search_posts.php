<?php

/**
 * Search posts
 * 
 * 
 * @param array $args
 *  ['locale'] - locale (eg. pl_PL)
 *  ['phrase'] - string with words
 *  ['filters'] - optional filters
 * 
 * @see kp_product_filter()
 * 
 * @return string echo form and script
 * 
 */

function get_term_meta( $term_id, $key = '', $single = false ) {
    return get_metadata( 'term', $term_id, $key, $single );
}

function kp_get_term_meta($term_id, $key) {
    global $wpdb;

    $result = $wpdb->get_row( $wpdb->prepare( "
        SELECT meta_value
        FROM {$wpdb->prefix}termmeta
        WHERE term_id = %d AND meta_key = %s",
        $term_id, $key
    ) );

    return $result->meta_value;
}

function kp_search_posts($args, $ids = false) {
    // ( isset($args['locale']) ) ? $args['locale'] = 'pl_PL' : null;
    /*

        Depraced 1.0

        global $wpdb;
        $value = $args['phrase'];
        $value = '%'.$wpdb->esc_like($value).'%';
        $sql = $wpdb->prepare("SELECT p.ID
            FROM {$wpdb->prefix}posts p
            LEFT JOIN {$wpdb->prefix}postmeta m ON m.post_id = p.ID
            LEFT JOIN {$wpdb->prefix}term_relationships r ON r.object_id = p.ID
            LEFT JOIN {$wpdb->prefix}term_taxonomy tt ON tt.term_taxonomy_id = r.term_taxonomy_id AND tt.taxonomy = 'miasto'
            LEFT JOIN {$wpdb->prefix}terms t ON t.term_id = tt.term_id
            WHERE p.post_status = 'publish' AND p.post_type = 'salon'
                AND ((m.meta_key = 'kp_address' AND m.meta_value LIKE %s) 
                    OR (t.name LIKE %s)
                    OR (p.post_title LIKE %s))
            GROUP BY p.ID", $value, $value, $value, $value, $value);
        $posts = $wpdb->get_col($sql);
    */

    $argu = array(
        'posts_per_page'   => -1,
        'post_type'        => 'salon',
        'post_status'      => 'publish',
    ); 

    if( isset($args['locale']) ) {
        $argu['meta_key'] = 'kp_lang';
        $argu['meta_value'] = $args['locale'];
    }

    if( isset($args['filters']) ) {
        $argu['tax_query'] = array(
            array(
                'taxonomy' => 'typ_oferty',
                'field'    => 'term_id',
                'terms'    => $args['filters'],
            ),
        );
    };

    $posts = get_posts($argu);

    $list = array();
    $result_array = [];
    foreach($posts as $post) {

        $distance = kp_get_circle_distance(
            (float)$args['geocords']['lat'],
            (float)$args['geocords']['lng'],
            (float)get_post_meta($post->ID, 'kp_geo_cords_lat')[0],
            (float)get_post_meta($post->ID, 'kp_geo_cords_lng')[0],
            "K"
        );

        if($distance <= $args['distance']) {
            array_push($result_array, $post->ID );
            $list[$post->ID] = $distance;
        }
    }

    $lista = array();

    foreach( $list as $post=>$distance ) {
        $terms = get_the_terms($post, 'typ_placowki' )[0];
        $kp_value_position = get_field('kp_value_position', $terms);

        $lista[$kp_value_position][$post] = $distance;
    }

    ksort($lista);
    array_walk($lista, 'ksort');

    foreach( $lista as $type=>$data ) {
        asort($lista[$type], SORT_NUMERIC);
    }

    $result_array = array();

    foreach( $lista as $type=>$data ) {
        $result_array = array_merge($result_array, array_keys($data));
    }





    // print_r($result_array);

    

    // $keys1 = array_keys($lista['salon-krishome']);
    // array_multisort(
    //     $lista['salon-krishome'], SORT_ASC, SORT_NUMERIC, $lista['salon-krishome'], $keys1
    // );
    // $lista['salon-krishome'] = array_combine($keys1, $lista['salon-krishome']);

    // $keys2 = array_keys($lista['partner-handlowy']);
    // array_multisort(
    //     $lista['partner-handlowy'], SORT_ASC, SORT_NUMERIC, $lista['partner-handlowy'], $keys2
    // );
    // $lista['partner-handlowy'] = array_combine($keys2, $lista['partner-handlowy']);

    // $keys3 = array_keys($lista['centrum-kompetencyjne']);
    // array_multisort(
    //     $lista['centrum-kompetencyjne'], SORT_ASC, SORT_NUMERIC, $lista['centrum-kompetencyjne'], $keys3
    // );
    // $lista['centrum-kompetencyjne'] = array_combine($keys3, $lista['centrum-kompetencyjne']);

    // $keys4 = array_keys($lista['salon-krishome-centrum-kompetencyjne']);
    // array_multisort(
    //     $lista['salon-krishome-centrum-kompetencyjne'], SORT_ASC, SORT_NUMERIC, $lista['salon-krishome-centrum-kompetencyjne'], $keys4
    // );
    // $lista['salon-krishome-centrum-kompetencyjne'] = array_combine($keys4, $lista['salon-krishome-centrum-kompetencyjne']);

    // $result_array = array();

    // foreach($lista['salon-krishome'] as $single=>$dist) {
    //     $result_array[] = $single;
    // }

    // foreach($lista['salon-krishome-centrum-kompetencyjne'] as $single=>$dist) {
    //     $result_array[] = $single;
    // }

    // foreach($lista['centrum-kompetencyjne'] as $single=>$dist) {
    //     $result_array[] = $single;
    // }

    // foreach($lista['partner-handlowy'] as $single=>$dist) {
    //     $result_array[] = $single;
    // }

    $posts_array = kp_get_posts(array (
        'locale' => get_locale(),
        'filters' => $args['filters'],
        'city' => null,
        'fromDB' => false,
        'posts' => $result_array
    ));
    
    if( $ids ) {
        return $result_array;
    } else {
        return $posts_array;
    };
}