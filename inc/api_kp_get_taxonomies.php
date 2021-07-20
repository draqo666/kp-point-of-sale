<?php

/**
 * Get taxonomy terms from post
 *
 * @since 1.0.0
 *
 * @param string $taxonomy - type of taxonomy (eg. miasto) 
 * @param int $post_id - post id
 * 
 * @return array 
 *  ['id'] - term id
 *  ['name'] - title term
 * 
 */
function api_kp_get_taxonomies($taxonomy, $post_id) {

    $terms = get_the_terms((int)$post_id, $taxonomy);


    $result = [];
    $item = [];

    foreach($terms as $term) {
        $termArray =  (array) $term;

        $item['id'] = $termArray['term_id'];
        $item['name'] = $termArray['name'];

        $result[] = $item;
    }

    return $result;
}