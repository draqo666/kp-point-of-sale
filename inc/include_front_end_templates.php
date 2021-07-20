<?php

/**
 * 
 * @since 1.0.0
 * 
 * Add templates to `salon` post type
 *
 */

add_filter('single_template', function($single) {
	global $post;

	if ( $post->post_type == 'salon' ) {
		if ( file_exists(  PLUGIN_DIR . 'salon-template.php' ) ) {
			return  PLUGIN_DIR . 'salon-template.php';
		}
	}
	return $single;
});

add_filter('archive_template', function($template) {
	if ( is_post_type_archive('salon') ) {
		return PLUGIN_DIR . 'salony-template.php';
	}
	return $template;
});

add_filter( 'taxonomy_template', 'city_template' );
function city_template( $template = '' ) {

	if (is_tax('miasto') ) {
		return PLUGIN_DIR . 'miasto-template.php';
	}

	return $template;

}

add_filter('template_include', 'search_city');
function search_city($template) {
	global $wp_query;
	$post_type = get_query_var('post_type');
	if( $wp_query->is_search && $post_type == 'salon' )
	{
		return PLUGIN_DIR. 'search-miasto-template.php';
	}
	return $template;
}