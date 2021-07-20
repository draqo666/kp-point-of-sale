<?php
/**
 * Set news terms posts
 * 
 * @param int $post - post id
 * @param string $terms seperate eg. `Warszawa, Kraków`
 * @param string $taxonomy - name of taxonomy eg. `miasto`
 * 
 * @return boolean true if looks good
 * 
 */
function kp_set_post_terms($post, $terms, $taxonomy) {

    $terms = explode(",", $terms);

    $term_ids = [];

    /**
     * Prepare array with Tax IDs
     */
    foreach($terms as $term) {
        $resp = term_exists( $term, $taxonomy );
        $resp_array = (array) $resp;

        if(isset($resp_array['term_id'])) {
            $term_ids[] = $resp_array['term_id'];
        } else {
            $resp = wp_insert_term($term, $taxonomy);
            $resp_array = (array)$resp;

            if (isset($resp_array['term_id'])) {
                $term_ids[] = $resp_array['term_id'];
            } else {
                $term_ids[] = $resp_array['error_data']['term_exists'];
            }
        }
    }

    /**
     * Return result about actions
     */
    return array(
        'wp_insert_term' => $resp_array,
        'wp_set_post_terms' => array(
            'term' => $terms,
            'resp' => wp_set_post_terms($post, $term_ids, $taxonomy)
        )
    );
}