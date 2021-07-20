<?php

/**
 * Completely disable term archives for this taxonomy.
 * 
 * - typ_placowki
 * - typ_oferty
 * - certyfikat
 * 
 */

add_action('pre_get_posts', function($qry) {
    if (is_admin()) return;
    if (is_tax('typ_placowki') || is_tax('typ_oferty') || is_tax('certyfikat')){
        $qry->set_404();
    }
});


