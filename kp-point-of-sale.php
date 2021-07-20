<?php
/*
Plugin Name:  Krispol - Point of Sale
Description:  Plugin help show point of sale and import/export prodcedure
Version:      1.2.4
Author:       OX Media
Author URI:   https://oxmedia.pl
License:      Business/Commercial
*/
/*
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
*/

define('PLUGIN_DIR', plugin_dir_path(__FILE__));
define('PLUGIN_URL', plugin_dir_url(__FILE__));
define('KP_VER', '1.2.4');

/**
 * 
 * Init sources
 * 
 */
require_once(PLUGIN_DIR . "inc/install.php");
// Add support to translate
add_action('plugins_loaded', function () {
    load_plugin_textdomain('kp-point-of-sale', FALSE, basename(dirname(__FILE__)) . '/languages/');
});

function kp_clear_session() {
  unset($_SESSION['filters']);
}
 
add_action( 'wpml_language_has_switched', 'kp_clear_session' );


function wpml_url_fix( $languages ) {
    foreach( $languages as $code=>$lang ) {
        if( strpos($lang['url'], '?s=') !== false ) {
            $languages[$code]['url'] = get_bloginfo('url').'/'.$lang['language_code'];
        }
    }
    
    return $languages;
}
add_filter( 'icl_ls_languages', 'wpml_url_fix');

require_once(PLUGIN_DIR . "inc/register_sources.php");
require_once(PLUGIN_DIR . "inc/register_custom_post_types.php");
require_once(PLUGIN_DIR . "inc/register_custom_fields.php");

/**
 * 
 * Back-end Functions
 * 
 */
require_once(PLUGIN_DIR . "inc/redirects.php");
require_once(PLUGIN_DIR . "inc/kp_array_orderby.php");
require_once(PLUGIN_DIR . "inc/kp_get_posts.php");
require_once(PLUGIN_DIR . "inc/kp_get_map.php");
require_once(PLUGIN_DIR . "inc/kp_get_cities.php");
require_once(PLUGIN_DIR . "inc/kp_search_posts.php");
require_once(PLUGIN_DIR . "inc/kp_set_post_terms.php");
require_once(PLUGIN_DIR . "inc/kp_get_circle_distance.php");
require_once(PLUGIN_DIR . "inc/kp_convert_posts_to_json.php");
require_once(PLUGIN_DIR . "inc/kp_get_geocords_default.php");

/**
 * 
 * Admin back office
 * 
 */
require_once(PLUGIN_DIR . "inc/include_admin_pages.php");
require_once(PLUGIN_DIR . "inc/include_admin_tables_cpt.php");
require_once(PLUGIN_DIR . "inc/include_front_end_templates.php");

/**
 * 
 * Front-end Functions
 * 
 */

require_once(PLUGIN_DIR . "inc/kp_search.php");
require_once(PLUGIN_DIR . "inc/kp_product_filter.php");
require_once(PLUGIN_DIR . "inc/kp_get_place_item.php");
require_once(PLUGIN_DIR . "inc/include_headers.php");

/**
 * 
 * Ajax
 * 
 */
require_once(PLUGIN_DIR . "inc/ajax_kp_save_filter_session.php");
require_once(PLUGIN_DIR . "inc/ajax_kp_send_mail.php");

/**
 * 
 * APIs
 * 
 */
require_once(PLUGIN_DIR . "inc/api_kp_enpoints.php");
require_once(PLUGIN_DIR . "inc/api_kp_get_point_of_sales.php");
require_once(PLUGIN_DIR . "inc/api_kp_post_point_of_sales.php");
require_once(PLUGIN_DIR . "inc/api_kp_get_taxonomies.php");
require_once(PLUGIN_DIR . "inc/api_kp_post_taxonomies.php");

function enqueuing_admin_scripts(){
	wp_enqueue_script('blockUI', plugin_dir_url( dirname( __FILE__ ) ).'kp-point-of-sale/assets/scripts/jquery.blockUI.js');
}

add_action('wp_footer', 'add_lang_code');
function add_lang_code() { ?>
    <script>
    var getLangCode = '<?php echo (apply_filters( 'wpml_current_language', NULL ) == 'pl') ? 'index.php' : apply_filters( 'wpml_current_language', NULL ) ;  ?>';
    </script>
<?php }

function wpml_get_code( $lang = "" ) {
 
    $langs = icl_get_languages( 'skip_missing=0' );
    if( isset( $langs[$lang]['default_locale'] ) ) {
        return $langs[$lang]['default_locale'];
    }
 
    return false;
}
 
// add_action( 'admin_enqueue_scripts', 'enqueuing_admin_scripts' );

// add_action('admin_head', 'pointOfSaleExport');
function pointOfSaleExport() { ?>
<script>
window.addEventListener('DOMContentLoaded', (event) => {
	if( jQuery('#kpAdminExportTool').length ) {
		jQuery('#kpAdminExportTool .ant-table-body table tbody').block({ 
            message: 'Wczytano <span id="salon_current">0</span>/<span id="salon_total">0</span>', 
            centerY: 0,
            centerX: 0,
            css: { 
            	border: '0',
            	top:  '200px', 
                left: '50%', 
                width: '150px',
                background: '#1890ff',
                color: '#fff',
                padding: '10px'
            },
            overlayCSS: { 
            	backgroundColor: '#fff' 
            }
        }); 
	}
});


var wczytano = 0;
var total = 0;

(function() {
    var origOpen = XMLHttpRequest.prototype.open;
    XMLHttpRequest.prototype.open = function() {
        this.addEventListener('load', function() {
            var type = this.responseURL;
            if( type.indexOf("certyfikat") > 0 ) {
            	wczytano++;
            	jQuery('#salon_current').text(wczytano);

            	if( wczytano == total ) {
            		jQuery('#kpAdminExportTool .ant-table-body table tbody').unblock();
            	}
            }


            if( type.indexOf("?rest_api=true&endpoint=point-of-sales/") == -1 ) {
            	const obj = JSON.parse(this.responseText);
            	total = obj.length;
            	jQuery('#salon_total').text(total);
            }
        });
        origOpen.apply(this, arguments);
    };
})();

</script>
<?php }
?>
