<?php
/**
 * Save filters from typ_oferty.
 *
 *
 * @since 1.0.0
 * @access private
 *
 * @param array  IDs terms.
 * 
 * @return nothing
 */
function kp_save_filters_session() {
  session_start();
  $filters = $_POST['filters'];
  $_SESSION['filters'] = $_POST['filters'];
  wp_send_json( $_SESSION['filters'] );
  
}

add_action( 'wp_ajax_kp_save_filters_session', 'kp_save_filters_session' );
add_action( 'wp_ajax_nopriv_kp_save_filters_session', 'kp_save_filters_session' );
