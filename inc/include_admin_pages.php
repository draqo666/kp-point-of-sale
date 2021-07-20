<?php

/**
 * @since 1.0.0
 * 
 * Add custom admin pages
 * - Import Salonów
 * - Export salonów
 * 
 */

if( function_exists('acf_add_options_page') ) {
    $option_page = acf_add_options_sub_page(array(
		'page_title' 	=> 'Ustawienia - Salony',
		'menu_title' 	=> 'Ustawienia - Salony',
		'parent_slug' 	=> 'options-general.php',
    ));
}

add_action( 'admin_menu', function() {
    add_submenu_page( 
        'edit.php?post_type=salon', 
        __( 'Import salonów' ), 
        __( 'Import salonów' ), 
        'manage_options', 
        'import_krispol', 
        function() {
            echo "<div id='kpAdminImportTool' class='wrap'></div>";
        }
    );
    add_submenu_page( 
        'edit.php?post_type=salon', 
        __( 'Export salonów' ), 
        __( 'Export salonów' ), 
        'manage_options', 
        'export_krispol', 
        function() {
            echo "<div id='kpAdminExportTool'  class='wrap'></div>";
        }
    );
} );
