<?php

/**
 * 
 * Add custom post types and taxonomies
 * 
 * Post types
 * - `salon`
 * - `messages`
 * 
 * Taxonomies
 * - `typ_placowki`
 * - `certyfikat`
 * - `typ_oferty`
 * - `typ_placowki`
 * 
 */

function cptui_register_my_cpts() {

	/**
	 * Post Type: Punkty sprzedazy.
	 */

	$labels = array(
		"name" => __( "Salony", "kp-point-of-sale" ),
		"singular_name" => __( "salon", "kp-point-of-sale" ),
		"menu_name" => __( "Mapa - Salony", "kp-point-of-sale" ),
		"all_items" => __( "Wszystkie salony", "kp-point-of-sale" ),
	);

	$args = array(
		"label" => __( "Mapa - Salony", "kp-point-of-sale" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"delete_with_user" => false,
		"show_in_rest" => true,
		//"rest_base" => "point_of_sale",
		//"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => "salony",
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( 'slug' => 'salony', 'with_front' => true, ),
		"query_var" => true,
		"supports" => array( "title", "editor", "thumbnail", "custom-fields" ),
	);

	register_post_type( "salon", $args );

	/**
	 * Post Type: Form messages.
	 */

	$labels = array(
		"name" => __( "Wiadomości", "kp-point-of-sale" ),
		"singular_name" => __( "Wiadomość", "kp-point-of-sale" ),
		"menu_name" => __( "Formularze - Salony", "kp-point-of-sale" ),
		"all_items" => __( "Wszystkie wiadomości", "kp-point-of-sale" ),
	);

	$args = array(
		"label" => __( "Formularze - Salony", "kp-point-of-sale" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => false,
		"show_ui" => true,
		"delete_with_user" => false,
		"show_in_rest" => false,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => false,
		"exclude_from_search" => true,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "form_messages", "with_front" => true ),
		"query_var" => true,
		"supports" => array( "title" ),
	);

	register_post_type( "form_messages", $args );
}
add_action( 'init', 'cptui_register_my_cpts' );

/**
 * Add Taxonomeis
 */

function cptui_register_my_taxes_miasto() {

	/**
	 * Taxonomy: Miasta.
	 */

	$labels = array(
		"name" => __( "Miasta", "kp-point-of-sale" ),
		"singular_name" => __( "Miasto", "kp-point-of-sale" ),
		"menu_name" => __( "Miasta", "kp-point-of-sale" ),
		"all_items" => __( "Wszystkie miasta", "kp-point-of-sale" ),
		"edit_item" => __( "Edytuj miasto", "kp-point-of-sale" ),
		"view_item" => __( "Zobacz miasto", "kp-point-of-sale" ),
		"update_item" => __( "Zaktualizuj miasto", "kp-point-of-sale" ),
		"add_new_item" => __( "Dodaj nowe miasto", "kp-point-of-sale" ),
		"new_item_name" => __( "Dodaj nowe miasto", "kp-point-of-sale" ),
		"search_items" => __( "Wyszukaj miasta", "kp-point-of-sale" ),
		"popular_items" => __( "Popularne miasta", "kp-point-of-sale" ),
		"add_or_remove_items" => __( "Dodaj lub usuń miasta", "kp-point-of-sale" ),
		"not_found" => __( "Nie znaleziono miast", "kp-point-of-sale" ),
		"no_terms" => __( "Brak miast", "kp-point-of-sale" ),
	);

	$args = array(
		"label" => __( "Miasta", "kp-point-of-sale" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "miasto",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		);
	register_taxonomy( "miasto", array( "salon" ), $args );
}
add_action( 'init', 'cptui_register_my_taxes_miasto' );
function cptui_register_my_taxes_typ_placowki() {

	/**
	 * Taxonomy: Typy placówek.
	 */

	$labels = array(
		"name" => __( "Rodzaj placówki", "kp-point-of-sale" ),
		"singular_name" => __( "Rodzaj placówki", "kp-point-of-sale" ),
	);

	$args = array(
		"label" => __( "Rodzaj placówki", "kp-point-of-sale" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'typ_placowki', 'with_front' => true, ),
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "typ_placowki",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		);
	register_taxonomy( "typ_placowki", array( "salon" ), $args );
}
add_action( 'init', 'cptui_register_my_taxes_typ_placowki' );
function cptui_register_my_taxes_typ_oferty() {

	/**
	 * Taxonomy: Typy ofert.
	 */

	$labels = array(
		"name" => __( "Oferta", "kp-point-of-sale" ),
		"singular_name" => __( "Oferta", "kp-point-of-sale" ),
	);

	$args = array(
		"label" => __( "Oferta", "kp-point-of-sale" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'typ_oferty', 'with_front' => true, ),
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "typ_oferty",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		);
	register_taxonomy( "typ_oferty", array( "salon" ), $args );
}
add_action( 'init', 'cptui_register_my_taxes_typ_oferty' );
function cptui_register_my_taxes_certyfikat() {

	/**
	 * Taxonomy: Certyfikaty.
	 */

	$labels = array(
		"name" => __( "Certyfikaty", "kp-point-of-sale" ),
		"singular_name" => __( "Certyfikat", "kp-point-of-sale" ),
	);

	$args = array(
		"label" => __( "Certyfikaty", "kp-point-of-sale" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'certyfikat', 'with_front' => true, ),
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "certyfikat",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		);
	register_taxonomy( "certyfikat", array( "salon" ), $args );
}
add_action( 'init', 'cptui_register_my_taxes_certyfikat' );