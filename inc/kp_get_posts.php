<?php

/**
 * Retrieve list of latest posts or posts matching criteria.
 * 
 * It was created becouse we have reggeresion in WP 4.3 
 *
 * The defaults are as follows:
 *
 * @param array $args {
 *  @type array     $wp_args      All avaiable arguments in get_posts in 4.3 version
 * 
 *  @type string    $locale       Language
 *  @type array     $order_by     Orderby field from taxonomies or post_type
 *  @type array     $filters      Specific product filters
 *  @type boolean   $fromDB       
 * }
 * @return array List of posts.
 */

function kp_get_posts($args) {
    ( !isset($args['locale']) ) ? $args['locale'] = 'pl_PL' : null;

    $result = [];
    if($args['fromDB'] === true) {
        $posts = get_posts($args['wp_args']);
    } else {
        $posts = $args['posts'];
    }


    /**
     * 
     * Construct and filter 
     * 
     */
    foreach($posts as $p) {
        if($args['fromDB'] === true) {
            $post = $p;
        } else {
            $post = get_post($p);
        }

        $lang = get_post_meta($post->ID, 'kp_lang');

        if( !empty($lang) ) {
            if( get_post_meta($post->ID, 'kp_lang')[0] === $args['locale'] ) {
                
                $terms['point_type'] = get_the_terms($post->ID, 'typ_placowki');
                $terms['cert'] = get_the_terms($post->ID, 'certyfikat');
                $terms['offer_type'] = get_the_terms($post->ID, 'typ_oferty');
                $terms['cities'] = get_the_terms($post->ID, 'miasto'); 
                
                if(isset($args['filters'])) {
                    $offers = [];
                    foreach($terms['offer_type'] as $offer) {
                        $offers[] = $offer->term_id;
                    }
                    if( count(array_diff($args['filters'], $offers)) == 0 ) {
                        $result[] = array(
                            'post_obj' => $post,
                            'taxonomy' => array(
                                'typ_placowki' => $terms['point_type'],
                                'certyfikat' => $terms['cert'],
                                'typ_oferty' => $terms['offer_type'],
                                'miasta' => $terms['cities']
                            ),
                            'position' => (get_field('kp_value_position', 'typ_placowki_'.$terms['point_type']) !== NULL) ? (int) get_field('kp_value_position', 'typ_placowki_'.$terms['point_type'][0]->term_id) : 10,
                            'number_of_certificates' => count($terms['cert'])
                        );
                    };
                } else {
                    $result[] = array(
                        'post_obj' => $post,
                        'taxonomy' => array(
                            'typ_placowki' => $terms['point_type'],
                            'certyfikat' => $terms['cert'],
                            'typ_oferty' => $terms['offer_type'],
                            'miasta' => $terms['cities']
                        ),
                        'position' => (int) get_field('kp_value_position', 'typ_placowki_'.$terms['point_type'][0]->term_id),
                        'number_of_certificates' => count($terms['cert'])
                    );
                }
    
            }
        }

    }

    $posts = $result;
    $result = null;

    /**
     * 
     * Filter city
     * 
     */
    foreach($posts as $post) {
        if( isset($args['city']) ) {
            if($post['taxonomy']['miasta'][0]->term_id === $args['city']) {
                $result[] = $post;
            }
        } else {
            $result[] = $post;
        }
    }


    if(!empty($result)) {
        $result = array_orderby($result, 'position', SORT_ASC, 'number_of_certificates', SORT_DESC);
    }

    return $result;
}