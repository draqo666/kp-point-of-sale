<?php

/**
 * Add scripts to Wordpress Admin Panel
 */
add_action('admin_enqueue_scripts', function ($hook) {

	if (isset($_GET['page'])) {
		if ($_GET['page'] === 'import_krispol' || $_GET['page'] === 'export_krispol') {
			wp_enqueue_script('kp-point-of-sale', PLUGIN_URL . 'build/js/admin.js', '', KP_VER, true);
			/*
            
            This functions is commented becouse we use 4.2 Wordpresw without Wordpress API. 
            In future we will uncomment and parse with official Wordpress API

            wp_localize_script( 'kp-point-of-sale', 'wpApiSettings', array(
                'root' => esc_url_raw( rest_url() ),
                'nonce' => wp_create_nonce( 'wp_rest' )
            ) );
            */
		}
	}
});

/**
 * Add scripts and stylesheets to front
 */
add_action('wp_enqueue_scripts', function () {
	wp_enqueue_script('kp-point-of-sale', PLUGIN_URL . 'assets/scripts/front-end.js', '', KP_VER, false);
	wp_enqueue_script('kp-point-of-sale-jsx', PLUGIN_URL . 'build/js/front-end.js', '', KP_VER, false);
	wp_localize_script(
		'kp-point-of-sale-jsx',
		'kpTranslate',
		array(
			"use_the_search_engine" => __('Skorzystaj z wyszukiwarki', 'kp-point-of-sale'),
			"search" => __('Wyszukaj', 'kp-point-of-sale'),
			"more" => __('Więcej', 'kp-point-of-sale'),
			"no_results" => __('Brak wyników', 'kp-point-of-sale'),
			"an_unexpected_error_occurred_please_try_again_soon" => __('Wystąpił nieoczekiwany błąd, spróbuj za chwilę ponownie.', 'kp-point-of-sale'),
			"enter_any_address_or_city_and_find_a_showroom_nearby" => __('Wpisz dowolny adres lub miasto i znajdź salon w pobliżu', 'kp-point-of-sale'),
		)
	);
	wp_localize_script(
		'kp-point-of-sale-jsx',
		'kpSettings',
		array(
			"locale" => get_locale(),
			"langCode" => _get_lang_code(get_locale()),
			"themeUrl" => PLUGIN_URL
		)
	);
	wp_enqueue_style('kp-point-of-sale', PLUGIN_URL . 'assets/stylesheets/style.css', '', KP_VER, false);
	wp_register_script('prefix_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js');
});

function add_this_script_head()
{
	?>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />

	<style>
		.leaflet-tile-pane {
			-webkit-filter: grayscale(100%);
			filter: grayscale(100%);
		}
	</style>

	<script src="https://www.google.com/recaptcha/api.js?render=<?php echo the_field('recaptcha_public_key', 'option'); ?>"></script>

<?php
}

add_action('wp_head', 'add_this_script_head');



function _get_lang_code($output)
{

	// return substr($output, 0, -3);

	switch ($output) {
	    case 'de_DE':
	        return 'at,ch';
	        break;
	    case 'cs_CZ':
	        return 'cz';
	        break;
	    case 'sk_SK':
	    	return 'sk';
	    case 'pl_PL':
	        return 'pl';
	        break;
	    case 'en_US':
	    	return 'be,bg,hr,cy,dk,ee,fi,fr,gr,hu,ie,it,lv,lt,lu,mt,nl,pt,ro,si,es,se,al,ad,am,by,ba,fo,ge,gi,is,im,xk,li,mk,md,mc,me,no,ru,sm,rs,tr,ua,bg,va';
	    defalut:
	    	return substr($output, 0, -3);
	}
}
