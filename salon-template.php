<?php

require_once(PLUGIN_DIR . "inc/kp_get_breadcrumb.php");

get_header();

$posts_array = kp_get_posts(array(
	'locale' => get_locale(),
	'posts' => [get_the_ID()], // Must be array
	'fromDB' => false,
));

?>

<?php
$term_list = wp_get_post_terms(get_the_ID(), 'miasto', array("fields" => "all"));
foreach ($term_list as $term) {
	$miasto     = $term->name;
	$url_miasto = get_term_link($term);
}
?>

<div class="kp_point_of_sale" data-ajax-action="<?php echo admin_url('admin-ajax.php', 'http://'); ?>">
	<div class="row breadcrumbs">
		<?php
		$b = array(
			["url" => home_url(), "name" => __('Strona główna', 'kp-point-of-sale')],
			["url" => get_post_type_archive_link('salon'), "name" => __('Lista salonów', 'kp-point-of-sale')],
			["url" => $url_miasto, "name" => $miasto],
			["url" => null, "name" => get_the_title()]
		);
		echo kp_get_breadcrumb($b); ?>
	</div>
	<div class="row header">
		<div class="col-sm-12 col-md-10">
			<h1>
				<?php
				echo get_the_terms(get_the_id(), 'typ_placowki')[0]->name;
				?>
			</h1>
		</div>
		<div class="col-sm-12 col-md-2">
			<a class="btn-search" href="javascript:history.back();">
				<?php echo __('Wróć', 'kp-point-of-sale'); ?>
			</a>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 col-md-10">
			<p>
				<?php
				$type = wp_get_post_terms(get_the_ID(), 'typ_placowki');
				echo $type[0]->description
				?>
			</p>
		</div>
	</div>
	<section>
		<div class="row">
			<?php kp_search(); ?>
		</div>
	</section>

	<section class="companyInfo">
		<div class="row">
			<div class="col-12 col-md-6">
				<div class="companyInfo__details">
					<div class="row">
						<div class="col-12 col-lg-8 not-padding">
							<h1><?php the_title(); ?></h1>
							<div class="row companyInfo__contactItem">
								<img class="img_ico" src="<?php echo plugin_dir_url(__FILE__); ?>/assets/images/pin.png" alt="" />
								<?php echo $miasto; ?>
								<br />
								<?php the_field('kp_address'); ?>
							</div>
							<div class="row companyInfo__contactItem">
								<?php if ($ph = get_field('kp_phone') || $ph = get_field('kp_phone_mobile')) { ?>
									<img src="<?php echo plugin_dir_url(__FILE__); ?>/assets//images/phone.png" alt="" class="img_ico" />
								<?php } ?>

								<?php if ($ph = get_field('kp_phone')) { ?>
									<?php the_field('kp_phone'); ?><br />
								<?php } ?>
								<?php if ($ph = get_field('kp_phone_mobile')) { ?>
									<?php the_field('kp_phone_mobile'); ?><br />
								<?php } ?>
							</div>
							<div class="row companyInfo__contactItem">
								<?php if ($fax = get_field('kp_fax')) { ?>
									<img src="<?php echo plugin_dir_url(__FILE__); ?>/assets/images/fax.png" class="img_ico" alt="" />
									<?php the_field('kp_fax'); ?><?php } ?>
							</div>
							<div class="row companyInfo__contactItem">
								<?php if ($www = get_field('kp_email')) { ?>
									<img src="<?php echo plugin_dir_url(__FILE__); ?>/assets/images/envelope.png" class="img_ico" alt="" />
									<a href="mailto:<?php the_field('kp_email'); ?>"><?php the_field('kp_email'); ?></a><?php } ?>
							</div>
							<div class="row companyInfo__contactItem">
								<?php if ($www = get_field('kp_www')) { ?>
									<img src="<?php echo plugin_dir_url(__FILE__); ?>/assets/images/globe.svg" alt="" class="img_ico" />
									<a target="_blank" href="<?php echo $www; ?>"><?php echo $www; ?></a><?php } ?>
							</div>
							<?php
							$whatsapp = get_field('kp_whatsapp');
						    $whatsapp_message = get_field('kp_whatsapp_message');
						    $messenger = get_field('kp_messenger');

						    if( isset($whatsapp) && !empty($whatsapp) ) {
						        $whatsapp_container = '<a href="https://api.whatsapp.com/send?phone=+48'.$whatsapp.''.((isset($whatsapp_message))?'&text='.$whatsapp_message:"").'" class="direct_message" target="_blank"><img src="'.plugin_dir_url( __FILE__ ).'inc/img/whatsapp.png"></a>';
						    } else {
						    	$whatsapp_container = '';
						    }

						    if( isset($messenger) && !empty($messenger) ) {
						        $messenger_container = '<a href="http://m.me/'.$messenger.'" class="direct_message" target="_blank"><img src="'.plugin_dir_url( __FILE__ ).'inc/img/messenger.png"></a>';
						    } else {
						    	$messenger_container = '';
						    }
							?>
							<?php if( isset($whatsapp) || isset($messenger) ) {?>
							<div class="row companyInfo__contactItem single_salon-direct-messages">
								<?php echo $whatsapp_container; echo $messenger_container;?>
							</div>
							<?php } ?>
							<div class="row companyInfo__contactItem">
								<?php if ($fb = get_field('kp_facebook_url')) { ?>
									<img src="<?php echo plugin_dir_url(__FILE__); ?>/assets/images/fb.png" alt="" class="img_ico" />
									<a href="<?php echo $fb; ?>">Przejdź na fanpage salonu</a><?php } ?>
							</div>
						</div>
						<div class="col-12 col-lg-4 not-padding text-right">
							<div class="companyInfo__logoCompany">
								<?php echo get_the_post_thumbnail(null, 'full'); ?>
							</div>
							<div class="companyInfo__logoType">
								<?php $terms = get_the_terms(get_the_ID(), 'typ_placowki')[0]; ?>
								<img src="<?php echo get_field('kp_icon', $terms); ?>" alt="">
							</div>

						</div>
					</div>
				</div>
				<?php
				$term_list = wp_get_post_terms(get_the_ID(), 'certyfikat', array("fields" => "all"));
				if (!empty($term_list)) {
					?>
					<div class="companyInfo__certificates">
						<div class="row">
							<?php
								foreach ($term_list as $term) {
									if (get_field('kp_tag_color', 'certyfikat_' . $term->term_id)) {
										$color = get_field('kp_tag_color', 'certyfikat_' . $term->term_id);
									} else {
										$color = "#C3C3C3";
									}
									if (get_field('kp_tag_color_text', 'certyfikat_' . $term->term_id)) {
										$colorText = get_field('kp_tag_color_text', 'certyfikat_' . $term->term_id);
									} else {
										$colorText = "#000";
									}
									if (get_field('kp_icon', 'certyfikat_' . $term->term_id)) {
										$icon = "<img src='" . get_field('kp_icon', 'certyfikat_' . $term->term_id) . "' style='margin-top:3rem' />";
									} else {
										$icon = "";
									}


									if (empty($term->name)) {
										continue;
									} else {
										if ($term->description) {
											$modal = '
																										<div class="modal fade kp-modal" id="' . $term->slug . '" tabindex="-1" role="dialog" aria-labelledby="' . $term->slug . '" aria-hidden="true">
																												<div class="modal-dialog" role="document">
																														<div class="modal-content">
																																<div class="modal-header">
																																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																																		<span aria-hidden="true">&times;</span>
																																		</button>
																																</div>
																																<div class="modal-body">
																																		<div class="row">
																																				<div class="col-md-2">' . $icon . '</div>
																																				<div class="col-md-10">
																																						<h2>' . $term->name . '</h2>
																																						' . $term->description . '
																																				</div>
																																		</div>

																																</div>
																														</div>
																												</div>
																										</div>
																								';
											echo '
																										<button class="krispol_tag" style="color: ' . $colorText . '; background: ' . $color . '" data-toggle="modal" data-target="#' . $term->slug . '">
																												' . $term->name . '
																										</button>
																										' . $modal . '
																								';
										} else {
											echo '
																								<span class="krispol_tag" style="color: ' . $colorText . '; background: ' . $color . '" >
																										' . $term->name . '
																								</span>
																								';
										}
									}

									?>
							<?php } ?>
						</div>
					</div>
				<?php
				}
				?>
			</div>
			<div class="col-12 col-lg-6" id="kpMap" data-config='
										<?php echo kp_convert_posts_to_json($posts_array, array(
											'lng'   => get_post_meta($posts_array[0]['post_obj']->ID, 'kp_geo_cords_lng')[0],
											'lat'   => get_post_meta($posts_array[0]['post_obj']->ID, 'kp_geo_cords_lat')[0],
										), null, 13); ?>
								'>
			</div>
	</section>
	<section class="offer">
		<p class="section_title mb-5"><?php echo __('Oferta', 'kp-point-of-sale'); ?></p>
		<div class="row">
			<?php $offer_list = wp_get_post_terms(get_the_ID(), 'typ_oferty', array("fields" => "all"));

			foreach ($offer_list as $term) { ?>

				<div class="col-12 col-md-3" style="display: flex;flex-wrap: wrap;">
					<div class="offer__item">
						<img src="<?php echo get_field('kp_icon', $term); ?>" alt="">
						<div>
							<h4><?php echo $term->name; ?></h4>
							<p><?php echo $term->description; ?></p>
						</div>

						<div class="mt-5">
							<?php
								if (get_field('kp_url_redirect', $term)) {
									echo '<a href="' . get_field('kp_url_redirect', $term) . '" class="krispol_button krispol_button_orange">' . __('Więcej', 'kp-point-of-sale') . '</a>';
								}
								?>
						</div>

					</div>
				</div>
			<?php } ?>

		</div>
	</section>
	<?php
	if (get_post_meta(get_the_ID(), 'kp_email_form')[0]) {
		?>
		<section>
			<p class="section_title mb-5">
				<?php echo __('Masz pytania? Napisz do nas', 'kp-point-of-sale'); ?>
			</p>
			<div class="contact_form">
				<div class="message_form"></div>
				<form action="" id="contact_form_kp" data-ajax-action="<?php echo admin_url('admin-ajax.php', 'http://'); ?>">
					<div class="contact_form_inputs">
						<label for="">
							<?php echo __('Imię i nazwisko', 'kp-point-of-sale'); ?>
							<input name="name" type="text" placeholder="<?php echo __('np. Adam Kowalski', 'kp-point-of-sale'); ?> ">
						</label>
						<label for="">
							<?php echo __('Telefon', 'kp-point-of-sale'); ?>
							<input name="phone" type="tel" placeholder="<?php echo __('np. 500 123 456', 'kp-point-of-sale'); ?>">
						</label>
						<label for="">
							<?php echo __('Adres e-mail', 'kp-point-of-sale'); ?>
							<input name="mail" required type="email" placeholder="<?php echo __('np. ak@domena.pl', 'kp-point-of-sale'); ?>">
						</label>
					</div>
					<div class="contact_form_textarea">
						<label for="">
							<?php echo __('Treść wiadomości', 'kp-point-of-sale'); ?>
							<textarea name="message"></textarea>
						</label>
					</div>
					<div class="contact_form_buttons">
						<div class="col">
							<label for="" class="checkbox clearfix">
								<input name="accept" required value="check" type="checkbox">
								<p>
									<?php the_field('kp_form_agreement', 'option'); ?>
								</p>
							</label>
						</div>
						<div class="col p-0">
							<button class="krispol_button krispol_button_orange" type="submit">
								<?php echo __('Wyślij', 'kp-point-of-sale'); ?>
							</button>
						</div>
					</div>
					<div style="padding: 0;margin: 0; text-align:center; width: 100%">
						<p>
							<?php echo __('Formularz korzysta z zabezpieczenia Google reCaptcha', 'kp-point-of-sale'); ?>
						</p>
						<p>
							<a href="https://www.google.com/intl/pl/policies/privacy/" target="_blank"><?php echo __('Prywatność', 'kp-point-of-sale'); ?></a> -
							<a target="_blank" href="https://www.google.com/intl/pl/policies/terms/"><?php echo __('Warunki', 'kp-point-of-sale'); ?></a>
						</p>
					</div>

					<input type="hidden" value="" name="recaptcha_response" id="recaptcha_response">
				</form>
			</div>
		</section>
	<?php } ?>
</div>

<script>
	grecaptcha.ready(function() {
		grecaptcha.execute('<?php echo the_field('recaptcha_public_key', 'option'); ?>', {
			action: 'homepage'
		}).then(function(token) {
			var recaptchaResponse = document.getElementById('recaptcha_response');
			recaptchaResponse.value = token;
		});
	});

	(function($) {
		$(document).on('submit', '#contact_form_kp', function(e) {
			e.preventDefault();
			var data = $('#contact_form_kp').serialize();
			$.ajax({
				type: 'POST',
				url: $('#contact_form_kp').data('ajax-action'),
				data: {
					'data': data,
					'action': 'kp_send_mail',
					'pid': '<?php echo get_the_ID(); ?>'
				},
				success: function(data) {
					$('.message_form').show().html(data.message);

					$('.message_form').removeClass('error');
					if (data.type === 'success') {
						$('.message_form').addClass('success');
						$('#contact_form_kp').addClass('hide');
					} else {
						$('.message_form').addClass('error');
					}
				},
				error: function(err) {
					console.log(err)
					$('.message_form').show().html('Wystąpił problem. Prosimy spróbować później.');
					$('.message_form').removeClass('success');
					$('.message_form').addClass('error');
				},
			});

			return false;
		});
	})(jQuery);
</script>


<?php
get_footer(); ?>