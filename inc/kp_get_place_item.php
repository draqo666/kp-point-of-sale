<?php

/**
 * 
 * @since 1.0.0
 * 
 * Generate dom with item to show in city
 * 
 * @param object - $post - object with post
 * 
 * @return string - with dom to echo 
 *
 */

function kp_get_place_item($post) {

    if ( $ph = get_field( 'kp_phone', $post ) || $ph = get_field( 'kp_phone_mobile', $post )  ) {
        $field['kp_phones']['icon'] = '<img src="'.PLUGIN_URL.'assets/images/phone.png" alt="" class="img_ico"/>';
    } else {
        $field['kp_phones']['icon'] = '';
    }
    if ( $ph = get_field( 'kp_phone', $post  ) ) {
        $field['kp_phones']['kp_phone'] = get_field( 'kp_phone', $post ).'<br/>';
    } else {
        $field['kp_phones']['kp_phone'] = '';
    }
    if ( $ph = get_field( 'kp_phone_mobile', $post  ) ) {
        $field['kp_phones']['kp_phone_mobile'] = get_field( 'kp_phone_mobile', $post ).'<br/>';
    } else {
        $field['kp_phones']['kp_phone_mobile'] = '';
    }
    if ( $www = get_field( 'kp_www', $post ) ) { 
        $field['kp_www'] = '<a href="'.$www.'" target="_blank">'.$www.'</a>';
        $field['kp_www_icon'] = '<img src="'.PLUGIN_URL.'assets/images/globe.svg" alt="" class="img_ico" />';
    } else {
        $field['kp_www'] = '';
        $field['kp_www_icon'] = '';
    }
    if ( $email = get_field( 'kp_email', $post ) ) { 
        $field['kp_email'] = '<a href="mailto:'.$email.'">'.$email.'</a>';
        $field['kp_email_icon'] = '<img src="'.PLUGIN_URL.'assets/images/envelope.png" alt="" class="img_ico" />';
    } else {
        $field['kp_email'] = '';
        $field['kp_email_icon'] = '';
    }
    
    $terms = get_the_terms($post, 'typ_placowki' )[0];
    $city = get_the_terms($post, 'miasto' )[0];
    $term_list = wp_get_post_terms( $post->ID , 'certyfikat', array( "fields" => "all" ) );

    $whatsapp = get_field('kp_whatsapp', $post->ID);
    $whatsapp_message = get_field('kp_whatsapp_message', $post->ID);
    $messenger = get_field('kp_messenger', $post->ID);

    if( isset($whatsapp) && !empty($whatsapp) ) {
        $whatsapp_container = '<a href="https://api.whatsapp.com/send?phone=+48'.$whatsapp.''.((isset($whatsapp_message))?'&text='.$whatsapp_message:"").'" class="direct_message" target="_blank"><img src="'.plugin_dir_url( __FILE__ ).'img/whatsapp.png"></a>';
    } else {
        $whatsapp_container = '';
    }

    if( isset($messenger) && !empty($messenger) ) {
        $messenger_container = '<a href="http://m.me/'.$messenger.'" class="direct_message" target="_blank"><img src="'.plugin_dir_url( __FILE__ ).'img/messenger.png"></a>';
    } else {
        $messenger_container = '';
    }

    echo '
        <div class="place" data-id="'.$post->ID.'">
            <div class="place_head">
                <div class="left">
                    <div class="title mb-3">'.get_the_title( $post ).'</div>
                    <p class="address">
                        '.$city->name.', '.get_field( 'kp_address', $post ).'
                    </p>
                    <div class="place_details">
                        <div>
                        '.
                            $field['kp_phones']['icon'].
                            $field['kp_phones']['kp_phone'].
                            $field['kp_phones']['kp_phone_mobile']
                        .'
                         '.$whatsapp_container.$messenger_container.'
                         
                        </div>

                        <div>
                        '.
                            $field['kp_email_icon'].
                            $field['kp_email']
                        .'
                        </div>
                    </div>
                </div>
                <div class="text-right right ">
                    <div class="d-none d-sm-block mb-3" style="font-size: 1.2rem">'.$terms->name.'</div>
                    <div class="mb-3" ><img src="'.get_field('kp_icon',$terms).'" alt=""></div>
                </div>
            </div>
            <div class="place_foot mt-3">
                <div class="left">
                ';

                    foreach ( $term_list as $term ) {
                        if(get_field('kp_tag_color', 'certyfikat_'.$term->term_id)) {
                            $color = get_field('kp_tag_color', 'certyfikat_'.$term->term_id);
                        } else {
                            $color = "#C3C3C3";
                        }
                        if(get_field('kp_tag_color_text', 'certyfikat_'.$term->term_id)) {
                            $colorText = get_field('kp_tag_color_text', 'certyfikat_'.$term->term_id);
                        } else {
                            $colorText = "#000";
                        }
                        if(get_field('kp_icon', 'certyfikat_'.$term->term_id)) {
                            $icon = "<img src='".get_field('kp_icon', 'certyfikat_'.$term->term_id)."' style='margin-top:3rem' />";
                        } else {
                            $icon = "";
                        }
                        
                        if($term->description) {
                            $modal = '
                                <div class="modal fade kp-modal" id="'.$term->slug.'" tabindex="-1" role="dialog" aria-labelledby="'.$term->slug.'" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-2">'.$icon.'</div>
                                                    <div class="col-md-10">
                                                        <h2>'.$term->name.'</h2>
                                                        '.$term->description.'
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ';
                            echo '
                                <button class="krispol_tag" style="color: '.$colorText.'; background: '.$color.'" data-toggle="modal" data-target="#'.$term->slug.'">
                                    '.$term->name.'
                                </button>
                                '.$modal.'
                            ';
                        } else {
                            echo '
                                <span class="krispol_tag" style="color: '.$colorText.'; background: '.$color.'" >
                                    '.$term->name.'
                                </span>
                            ';
                        }

                    }
                echo '</div>
                <div class="text-right right mt-2">
                    <a class="krispol_button krispol_button_orange" href="'.get_permalink( $post ).'">'.__('Więcej', 'kp-point-of-sale').'</a>
                </div>
            </div>
        </div>
    ';

}