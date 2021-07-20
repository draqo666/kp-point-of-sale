<?php

/**
 * 
 * @since 1.0.0
 * @deprecated 1.1.0
 * 
 * Generate <script> to generate map 
 * 
 * @param array - $posts
 * @param string - locale (eg. pl_PL)
 * @param string - country or city
 * 
 * @return string - with dom to echo 
 *
 */

function kp_get_map($posts, $locale, $view) {
    if ( $view === 'city' ) { 
        foreach ($posts as $key => $p) {
            if($key === 0) {
                echo 'var center = ['.get_field( 'kp_geo_cords_lat', $p['post_obj'] ).','.get_field( 'kp_geo_cords_lng', $p['post_obj'] ).'];';
                echo 'var zoom = 12;';
            }
        } 
    } else if ( $view === 'country' ) {
        if($locale === 'pl_PL') {
            echo 'var zoom = 6;';
            echo 'var center = [52.237049, 19.017532];';
        } else if($locale === 'en_US') {
            echo 'var zoom = 6;';
            echo 'var center = [47.944921, 6.215274];';
        } else if($locale === 'sk_SK') {
            echo 'var zoom = 7;';
            echo 'var center = [48.621792, 18.54746];';
        } else if($locale === 'de_DE') {
            echo 'var zoom = 6;';
            echo 'var center = [47.4886209, 12.9789238];';
        } else if($locale === 'sv_SE') {
            echo 'var zoom = 6;';
            echo 'var center = [52.237049, 19.017532];';
        } else if($locale === 'cs_CZ') {
            echo 'var zoom = 6;';
            echo 'var center = [49.518701, 14.777863];';
        } else if($locale === 'fr_FR') {
            echo 'var zoom = 62;';
            echo 'var center = [46.404751, 1.2544063];';
        } else {
            echo 'var zoom = 6;';
            echo 'var center = [52.237049, 19.017532];';
        }
    } else {
        echo 'var zoom = 15;';
        echo 'var center = [52.237049, 19.017532];';
    }

    echo " var cords = [ " ;
    foreach ($posts as $key => $p) { 
        if (get_field( 'kp_geo_cords_lat', $p['post_obj'] ) && get_field( 'kp_geo_cords_lng', $p['post_obj'] ) ) { 
            if($p['taxonomy']['typ_placowki'] !== false) {
                $icon_field = get_field('kp_icon_map', 'typ_placowki_'.$p['taxonomy']['typ_placowki'][0]->term_id);

                ($icon_field === NULL) ? $icon_field = PLUGIN_URL.'assets/images/dom.png' : null;
                ($icon_field === false) ? $icon_field = PLUGIN_URL.'assets/images/dom.png' : null;
            } else {
                $icon_field = PLUGIN_URL.'assets/images/dom.png';
            }

            echo "{";
                echo "cords: {";
                    echo "lat:";
                    echo get_field( 'kp_geo_cords_lat', $p['post_obj'] ); 
                    echo ",";

                    echo "lng:";
                    echo get_field( 'kp_geo_cords_lng', $p['post_obj'] ); 
                    echo ",";

                echo "},";
                echo "icon:'";
                    echo $icon_field;
                echo "',";
                echo "url: '".get_the_permalink($p['post_obj']->ID)."'";
            echo "},";
        } 
    } 

    echo " ]; ";
    echo " genMap(cords, 'map', zoom, center); ";
    
}