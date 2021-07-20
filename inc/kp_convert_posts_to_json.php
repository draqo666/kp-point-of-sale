<?php

function kp_convert_posts_to_json($posts, $init, $distance, $zoom)
{
  if ($distance !== null) {
    if ($distance <= 25) {
      $zoom = 9;
    } else if ($distance > 25 && $distance <= 50) {
      $zoom = 7.5;
    } else {
      $zoom = 6.5;
    }
  }

  $distance = (int) $distance * 1000;

  $result = array(
    "init" => array(
      "geocords" => array(
        "lat" => $init['lat'],
        "lng" => $init['lng']
      ),
      "zoom" => $zoom,
      "distance" => $distance
    ),
    "markers" => []
  );

  foreach ($posts as $p) {

    if ($p['taxonomy']['typ_placowki'] !== false) {
      $icon_field = get_field('kp_icon_map', 'typ_placowki_' . $p['taxonomy']['typ_placowki'][0]->term_id);

      ($icon_field === NULL) ? $icon_field = PLUGIN_URL . 'assets/images/dom.png' : null;
      ($icon_field === false) ? $icon_field = PLUGIN_URL . 'assets/images/dom.png' : null;
    } else {
      $icon_field = PLUGIN_URL . 'assets/images/dom.png';
    }

    $whatsapp = get_field('kp_whatsapp',$p['post_obj']->ID);
    $whatsapp_message = get_field('kp_whatsapp_message',$p['post_obj']->ID);
    $messenger = get_field('kp_messenger',$p['post_obj']->ID);

    array_push($result['markers'], array(
      "icon"      => $icon_field,
      'url'       => get_the_permalink($p['post_obj']->ID),
      "geocords"  => array(
        "lat" => get_post_meta($p['post_obj']->ID, 'kp_geo_cords_lat')[0],
        "lng" => get_post_meta($p['post_obj']->ID, 'kp_geo_cords_lng')[0]
      ),
      "popupData"      => array(
        "title"         => $p['post_obj']->post_title,
        "type"          => $p['taxonomy']['typ_placowki'][0]->name,
        "address"       => get_post_meta($p['post_obj']->ID, 'kp_address')[0],
        "city"          => $p['taxonomy']['miasta'][0]->name,
        "phone"         => get_post_meta($p['post_obj']->ID, 'kp_phone')[0],
        "phone_mobile"  => get_post_meta($p['post_obj']->ID, 'kp_phone_mobile')[0],
        "email"         => get_post_meta($p['post_obj']->ID, 'kp_email')[0],
        "link"          => get_the_permalink($p['post_obj']->ID),
        "whatsapp"      => ((isset($whatsapp))?$whatsapp:""),
        "whatsapp_message"      => ((isset($whatsapp_message))?$whatsapp_message:""),
        "messenger"      => ((isset($messenger))?$messenger:"")
      )
    ));
  }

  return json_encode($result);
}
