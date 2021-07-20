<?php
/**
 * 
 * @since 1.0.0
 * 
 * Generate breadcrumb
 * 
 * @param array - config breadcrumbs
 *  ['name']
 *  ['url']
 * @return string - with html to echo
 *
 */

function kp_get_breadcrumb($array) {
    $home_url = home_url( 'punkty-sprzedazy' );
    $dom = "<div class='col-12'><ul>";

    foreach($array as $key=>$item) {
        $dom = $dom."
        <li>
            <a href=".$item['url'].">
                ".$item['name']."
                <i class='fa fa-caret-right' aria-hidden='true'></i>
            </a>
        </li>
        ";
    }
    $dom = $dom."</ul></div>";

    return ($dom);
}