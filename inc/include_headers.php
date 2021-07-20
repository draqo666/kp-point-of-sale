<?php

/**
 * 
 * @since 1.2.1
 * 
 * Add `description` to header in salon
 *
 */
add_action('wp_head', function () {
  global $post;

  if ($post->post_type == 'salon') {
    $type = wp_get_post_terms(get_the_ID(), 'typ_placowki');
    echo '<meta name="description" content="' . esc_attr($type[0]->description) . '">';
  }
});
