
<?php 

require_once(PLUGIN_DIR."inc/kp_get_breadcrumb.php");

get_header();

$posts_array = kp_get_posts(array(
    'wp_args' => array(
        'posts_per_page' => - 1,
        'post_type'      => 'salon',
    ),
    'locale' => get_locale(),
    'filters' => $_SESSION['filters'],
    'city' => get_queried_object()->term_id,
    'fromDB' => true
));

?>

    <div class="kp_point_of_sale" data-ajax-action="<?php echo admin_url( 'admin-ajax.php', 'http://' ); ?>">
        <?php /* --- Breadcrumbs --- */ ?>
        <div class="row breadcrumbs">
            <?php 
            $b = array(
                ["url" => home_url(),"name" => __('Strona główna', 'kp-point-of-sale')], 
                ["url" => get_post_type_archive_link('salon'),"name" => __('Lista salonów', 'kp-point-of-sale')], 
                ["url" => null,"name" => get_queried_object()->name], 
            );
            echo kp_get_breadcrumb($b); ?>
        </div>

        <?php /* --- Header --- */ ?>
        <div class="row header">
            <div class="col-sm-12 col-md-10">
                <h1><?php echo get_queried_object()->name; ?></h1>
            </div>
            <div class="col-sm-12 col-md-2">
                <a class="btn-search" href="javascript:history.back();">
                    <?php echo __('Wróć', 'kp-point-of-sale'); ?>
                </a>
            </div>
        </div>

        <?php /* --- Search form --- */ ?>
        <section>
            <div class="row">
                <?php kp_search(); ?>
            </div>
        </section>

        <?php /* --- Main content --- */ ?>
        <section class="cityInfo">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <p class="mb-4" style="text-transform: uppercase; font-weight: bold">
                        <?php echo __('Wybierz produkty', 'kp-point-of-sale'); ?>
                    </p>
                    <div class="cityInfo__productFilter">
                        <?php kp_product_filter(); ?>
                    </div>
                    <div class="cityInfo__places">
                        <?php 
                            if ( ! empty( $posts_array ) ) {
                                ?>
                                <p class="mb-4" style="text-transform: uppercase; font-weight: bold">
                                    <?php echo __('Wybierz punkt sprzedaży', 'kp-point-of-sale'); ?>
                                </p>
                                <div class="cityInfo__places-wrapper">
                                    <?php 
                                        foreach($posts_array as $post) {
                                            kp_get_place_item( $post['post_obj'] );
                                        }
                                    ?>
                                </div>
                        <?php } else echo '<p>'.__('Brak wyników spełniających kryteria', 'kp-point-of-sale').'</p>'; ?>
                    </div>
                </div>
                <div class="col-12 col-lg-6" id="kpMap" data-config='
                    <?php echo kp_convert_posts_to_json($posts_array, array(
                        'lng'   => get_post_meta($posts_array[0]['post_obj']->ID, 'kp_geo_cords_lng')[0],
                        'lat'   => get_post_meta($posts_array[0]['post_obj']->ID, 'kp_geo_cords_lat')[0],
                    ), null, 11.5); ?>
                '>
            </div>
        </section>

        <?php /* --- SEO text --- */ ?>
        <section>
            <p class="city-txt">
				<?php echo get_queried_object()->description; ?>
            </p>
        </section>
    </div>

    <script><?php kp_get_map($posts_array, get_locale(), 'city') ; ?></script>
    <style>
        .page-heading {
            display:none !important;
        }
    </style>
<?php
get_footer(); ?>