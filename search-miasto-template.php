<?php
require_once(PLUGIN_DIR . "inc/kp_get_breadcrumb.php");
$posts_array = kp_search_posts(array(
	'locale'    =>  wpml_get_code( ICL_LANGUAGE_CODE ),
	'phrase'    =>  $_GET['s'],
	'geocords'  =>  array(
		'lng'   => $_GET['lng'],
		'lat'   => $_GET['lat']
	),
	'distance'  => $_GET['distance'],
	'filters'	=> $_SESSION['filters']
));

$posts_array_ids = kp_search_posts(array(
	'locale'    =>  wpml_get_code( ICL_LANGUAGE_CODE ),
	'phrase'    =>  $_GET['s'],
	'geocords'  =>  array(
		'lng'   => $_GET['lng'],
		'lat'   => $_GET['lat']
	),
	'distance'  => $_GET['distance'],
	'filters'	=> $_SESSION['filters']
), true);

if( isset($_SESSION['filters']) ) {
	// $posts_array['filters'] = $_SESSION['filters'];
}

if ($posts_array === null && $_GET['distance'] != 100 ) {
	$query = $_GET;
	// replace parameter(s)
	if ($query['distance'] == 25) $query['distance'] = 50;
	else if ($query['distance'] == 50) $query['distance'] = 100;
	else $query['distance'] = 100;
	$query['increased_distance'] = "1";


	$query_result = http_build_query($query);
	// $new_link = '/'.ICL_LANGUAGE_CODE.'/index.php?' . $query_result;
	$new_link = $_SERVER['PHP_SELF'] . "?" . $query_result;
	header("Location: " . $new_link);
	die();
}
get_header();
?>

<div class="kp_point_of_sale" data-ajax-action="<?php echo admin_url('admin-ajax.php', 'http://'); ?>">
	<div class="row breadcrumbs">
		<?php
		$b = array(
			["url" => home_url(), "name" => __('Strona główna', 'kp-point-of-sale')],
			["url" => get_post_type_archive_link('salon'), "name" => __('Lista salonów', 'kp-point-of-sale')],
			["url" => null, "name" => __('Wyszukanie', 'kp-point-of-sale')],
		);
		echo kp_get_breadcrumb($b); ?>
	</div>
	<div class="row header">
		<div class="col-sm-12 col-md-10">
			<?php if (!empty($_GET['s'])) { ?>
				<h1><?php echo __('Wyszukiwanie dla frazy', 'kp-point-of-sale'); ?> <?php echo $_GET['s']; ?></h1>
			<?php } ?>
		</div>
		<div class="col-sm-12 col-md-2">
			<a class="btn-search" href="javascript:history.back();"><?php echo __('Wróć', 'kp-point-of-sale'); ?></a>
		</div>
	</div>
	<section>
		<div class="row">
			<?php kp_search(); ?>
			<div class="col">
				<?php 
				if ($_GET['increased_distance']) {
					echo '<div class="mt-2 alert alert-warning">'.sprintf( __( 'W podanym obszarze poszukiwań nie znaleziono salonów, dlatego powiększyliśmy go do %s km', 'kp-point-of-sale' ), $_GET['distance'] ).'</div>'; 
				}
				?>
			</div>
		</div>
	</section>

	<section class="cityInfo">
		<div class="row">
			<div class="col-12 col-lg-6">
				<p class="mb-3" style="text-transform: uppercase; font-weight: bold">
					<?php echo __('Wybierz produkty', 'kp-point-of-sale'); ?>
				</p>
				<div class="cityInfo__productFilter">
					<?php kp_product_filter(); ?>
				</div>
				<div class="cityInfo__places">
					<p class="mb-3" style="text-transform: uppercase; font-weight: bold">
						<?php echo __('Wybierz punkt sprzedaży', 'kp-point-of-sale'); ?>
					</p>
					<?php
					error_log(print_r($posts_array_ids, true));
					if (!empty($posts_array_ids)) {
						?>
						<div class="cityInfo__places-wrapper">
							<?php
								$args = array(
									'post__in' => $posts_array_ids,
									'post_type' => 'salon',
									'orderby'=>'post__in',
									'posts_per_page' => -1
								);
								$the_query = new WP_Query( $args );
								if ( $the_query->have_posts() ) {
									while ( $the_query->have_posts() ) {
										$the_query->the_post();
										kp_get_place_item($post);
									}
								}
								?>
						</div>
					<?php
					} else {
						echo '<p>Brak wyników spełniających kryteria</p>';
					}
					?>
				</div>
			</div>
			<div class="col-12 col-lg-6" id="kpMap" data-config='
                    <?php 
                    // error_log(print_r($posts_array, true));
                    echo kp_convert_posts_to_json($posts_array, array(
											'lng'   => $_GET['lng'],
											'lat'   => $_GET['lat']
										), $_GET['distance'], 5); ?>
                '></div>
		</div>
</div>

<style>
	.page-heading {
		display: none !important;
	}
</style>

<?php
get_footer(); ?>