<?php

require_once(PLUGIN_DIR . "inc/kp_get_breadcrumb.php");

get_header();


$posts_array = kp_get_posts(array(
    'wp_args' => array(
        'posts_per_page' => -1,
        'post_type'      => 'salon',
    ),
    'locale' => get_locale(),
    'filters' => $_SESSION['filters'],
    'city' => null,
    'fromDB' => true,
));


$zoom = 6;
if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
    if(ICL_LANGUAGE_CODE == 'en') {
        $zoom = 4;
    }
}

?>

<div class="kp_point_of_sale" data-ajax-action="<?php echo admin_url('admin-ajax.php', 'http://'); ?>">
    <div class="row breadcrumbs">
        <?php
        $b = array(
            ["url" => home_url(), "name" => __('Strona główna', 'kp-point-of-sale')],
            ["url" => get_post_type_archive_link('salon'), "name" => __('Lista salonów', 'kp-point-of-sale')],
        );
        echo kp_get_breadcrumb($b); ?>
    </div>


    <div class="row">
        <div class="col-12">
            <h1><?php echo __('Znajdź salon', 'kp-point-of-sale'); ?></h1>
            <p>
                <?php the_field('kp_body_main_content', 'option'); ?>
            </p>
        </div>
    </div>
    <section>
        <div class="row">
            <?php kp_search(); ?>
        </div>
    </section>

    <section class="cityInfo">
        <div class='row'>
            <div class="col-12 col-lg-6">
                <p class="mb-4" style="text-transform: uppercase; font-weight: bold">
                    <?php echo __('Wybierz produkty', 'kp-point-of-sale'); ?>
                </p>
                <div class="cityInfo__productFilter">
                    <?php kp_product_filter(); ?>
                </div>

                <div class="middle_section_left_cities">
                    <p class="mb-4" style="text-transform: uppercase; font-weight: bold">
                        <?php echo __('Wybierz miasto', 'kp-point-of-sale'); ?>
                    </p>
                    <div class="city_wrapper">
                        <?php
                        if (!empty($posts_array)) {
                            kp_get_cities($posts_array);
                        } else {
                            echo "<p class='text-center mt-5'>";
                            echo __("Brak wyników", 'kp-point-of-sale');
                            echo "</p>";
                        }

                        ?>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6" id="kpMap" data-config='
                    <?php echo kp_convert_posts_to_json($posts_array, array(
                        'lng'   => kp_get_geocords_default(get_locale(), 'lng'),
                        'lat'   => kp_get_geocords_default(get_locale(), 'lat')
                    ), null, $zoom); ?>
                '>

            </div>
        </div>

    </section>
</div>

<script>
    /**
     * Biding
     */
    var el = document.getElementsByClassName('city_wrapper');
    document.onkeyup = function(e) {
        if (document.activeElement.getAttribute('id') !== 'searchInput') {
            scrollToElement(e)
        }
    };
</script>

<style>
    .page-heading {
        display: none !important;
    }
</style>



<?php get_footer(); ?>