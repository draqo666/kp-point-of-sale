<?php

/**
 * 
 * @since 1.0.0
 * 
 * Add more columns in tables Messages template
 *
 */

add_filter( 'manage_form_messages_posts_columns', function( $columns ) {
    $columns['kp_form_mail'] = __( 'Nadawca', 'kp-point-of-sale');
    $columns['kp_form_to'] = __( 'Adresat', 'kp-point-of-sale' );
    $columns['kp_form_name'] = __( 'Imię i nazwisko', 'kp-point-of-sale');
    $columns['kp_form_phone'] = __( 'Telefon', 'kp-point-of-sale' );
    $columns['kp_created'] = __( 'Wysłano', 'kp-point-of-sale' );
    unset($columns['title']);
    unset($columns['date']);

    /*
    echo "<pre>";
    var_dump($columns);
    echo "</pre>";
    */

    return $columns;
});

add_action('manage_form_messages_posts_custom_column', function($column, $post_id){

    if($column === 'kp_form_name') {
        echo get_post_meta( $post_id, 'kp_form_name')[0];
    }
    if($column === 'kp_form_phone') {
        echo get_post_meta( $post_id, 'kp_form_phone')[0];
    }
    if($column === 'kp_form_mail') {
        echo get_post_meta( $post_id, 'kp_form_mail')[0];
    }
    if($column === 'kp_form_to') {
        echo get_post_meta( $post_id, 'kp_form_to')[0];
    }
    if($column === 'kp_created') {
        echo get_the_date('', $post_id);
        echo ', ';
        echo get_the_time( '', $post_id );
    }

}, 10, 2);


add_action( 'restrict_manage_posts', function() {
    $type = 'form_messages';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }

    //only add filter to post type you want
    if ('form_messages' == $type){
        ?>
        <input type="text" name="kp_form_to" value="<?php if(isset($_GET['kp_form_to'])) { echo $_GET['kp_form_to']; } ?>" placeholder="<?php echo __( 'Adresat', 'kp-point-of-sale' ); ?>" />
        <input type="text" name="kp_form_mail" value="<?php if(isset($_GET['kp_form_mail'])) { echo $_GET['kp_form_mail']; } ?>" placeholder="<?php echo __( 'Nadawca', 'kp-point-of-sale' ); ?>" />
        <input type="text" name="kp_form_name" value="<?php if(isset($_GET['kp_form_name'])) { echo $_GET['kp_form_name']; } ?>" placeholder="<?php echo __( 'Imię i Nazwisko', 'kp-point-of-sale' ); ?>" />
        <input type="text" name="kp_form_phone" value="<?php if(isset($_GET['kp_form_phone'])) { echo $_GET['kp_form_phone']; } ?>" placeholder="<?php echo __( 'Telefon', 'kp-point-of-sale' ); ?>" />
        <input type="text" name="kp_form_message" value="<?php if(isset($_GET['kp_form_message'])) { echo $_GET['kp_form_message']; } ?>" placeholder="<?php echo __( 'Treść', 'kp-point-of-sale' ); ?>" />
        <?php
    }
} );


add_filter( 'parse_query', function( $query ) {
    global $pagenow;

    $type = 'form_messages';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }
    $query->query_vars['meta_query'] = array(
        'relation' => 'AND',
    );
    if ( 'form_messages' == $type && is_admin() && $pagenow=='edit.php' && isset($_GET['kp_form_to']) && $_GET['kp_form_to'] != '') {
        $query->query_vars['meta_query'][] = array(
            'key'     => 'kp_form_to',
            'value'   => $_GET['kp_form_to'],
            'compare' => 'LIKE'
        );
    }
    if ( 'form_messages' == $type && is_admin() && $pagenow=='edit.php' && isset($_GET['kp_form_mail']) && $_GET['kp_form_mail'] != '') {
        $query->query_vars['meta_query'][] = array(
            'key'     => 'kp_form_mail',
            'value'   => $_GET['kp_form_mail'],
            'compare' => 'LIKE'
        );
    }
    if ( 'form_messages' == $type && is_admin() && $pagenow=='edit.php' && isset($_GET['kp_form_name']) && $_GET['kp_form_name'] != '') {
        $query->query_vars['meta_query'][] = array(
            'key'     => 'kp_form_name',
            'value'   => $_GET['kp_form_name'],
            'compare' => 'LIKE'
        );
    }
    if ( 'form_messages' == $type && is_admin() && $pagenow=='edit.php' && isset($_GET['kp_form_name']) && $_GET['kp_form_phone'] != '') {
        $query->query_vars['meta_query'][] = array(
            'key'     => 'kp_form_phone',
            'value'   => $_GET['kp_form_phone'],
            'compare' => 'LIKE'
        );
    }
    if ( 'form_messages' == $type && is_admin() && $pagenow=='edit.php' && isset($_GET['kp_form_message']) && $_GET['kp_form_message'] != '') {
        $query->query_vars['meta_query'][] = array(
            'key'     => 'kp_form_message',
            'value'   => $_GET['kp_form_message'],
            'compare' => 'LIKE'
        );
    }
    /*
    echo "<pre style='margin-left: 300px;'>";
    var_dump($query->query_vars['meta_query']);
    echo "</pre>";
    */

});
