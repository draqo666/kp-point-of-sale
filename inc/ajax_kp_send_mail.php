<?php

/**
 * Get data from form and then save post and send mail
 *
 *
 * @since 1.0.0
 *
 * @param array     $data
 * 
 * @param string    $data['recaptcha_response']
 * @param string    $data['message']
 * @param string    $data['name']
 * @param string    $data['phone']
 * @param string    $data['mail']
 * @param boolean   $data['accept']
 * 
 * @return nothing
 */

function kp_send_mail()
{
    parse_str($_POST['data'], $data);
    $post_id = $_POST['pid'];

    $reCaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
    $reCaptchaSecret = get_field('recaptcha_secret_key', 'option');


    $reCaptchaResp  = $data['recaptcha_response'];

    $recaptcha = file_get_contents($reCaptchaUrl . '?secret=' . $reCaptchaSecret . '&response=' . $reCaptchaResp);
    $recaptcha = json_decode($recaptcha);

    if ($recaptcha->success == true) {
        // Take action based on the score returned:
        if ($recaptcha->score >= 0.5) {
            $isHuman = true;
        } else {
            $isHuman = false;
        }
    } else { // there is an error /
        $isHuman = null;
        $return = array(
            'message'  =>  __('Problem z wysłaniem wiadomości. Skontaktuj się na adres e-mail biuro@krispol.pl', 'kp-point-of-sale'),
            'type'       => 'error',
            'additionalInfo' => 'Issue with captcha'
        );
    }
    $isHuman = true;

    if ($isHuman === true) {
        if (is_numeric($_POST['pid'])) {
            $mail = get_field('kp_email_form', $post_id);
            // $mail = 'P.Orwat@krispol.pl';
            // $mail = 'dkoczula@eatnet.pl,radek@wicked.works';
        }

        if (!empty($mail)) {
            $subject = 'Zapytanie ofertowe';
            $body = array();

            if( !empty($data['name']) ) {
                $body[] = "Imię i Nazwisko: <b>".$data['name']."</b><br/>";
            }

            $body[] = "Adres e-mail: <b>".$data['mail']."</b><br/>";

            if( !empty($data['phone']) ) {
                $body[] = "Telefon: <b>".$data['phone']."</b>";
            }

            if( !empty($data['message']) ) {
                $body[] = "<br/><br/>".$data['message'];
            }

            $body[] = "<br/><br/>--<br/>Wiadomość została wysłana z formularza kontaktowego ze strony <a href='https://krispol.pl/'>krispol.pl</a>";

            $headers = array('Content-Type: text/html; charset=UTF-8');
            $headers[] = 'From: ' . $data['name'] . ' <' . $data['mail'] . '>';
            if (
                !empty($data['mail']) &&
                !empty($data['accept'])
            ) {

                $create_post = wp_insert_post(array(
                    "post_type" => "form_messages",
                    "post_title" => $data['mail'] . " >> " . $mail,
                ));
                if ($create_post) {

                    update_post_meta($create_post, 'kp_form_to', $mail);
                    update_post_meta($create_post, 'kp_form_name', $data['name']);
                    update_post_meta($create_post, 'kp_form_mail', $data['mail']);
                    update_post_meta($create_post, 'kp_form_phone', $data['phone']);
                    update_post_meta($create_post, 'kp_form_message', $data['message']);
                    $mail = wp_mail($mail, $subject, implode('', $body), $headers);

                    $return = array(
                        'message'   => __('Dziękujemy za wysłanie wiadomości', 'kp-point-of-sale'),
                        'type'      => 'success',
                        'mailDebug' => $mail
                    );
                } else {
                    $return = array(
                        'message'  => __('Problem z wysłaniem wiadomości. Skontaktuj się na adres e-mail biuro@krispol.pl', 'kp-point-of-sale'),
                        'type'       => 'error',
                        'additionalInfo'    => "Can't create post"
                    );
                }
            } else {
                $is = 0;
                $return['message'] = __('Nie wypełniłeś wszystkich pól: ', 'kp-point-of-sale');
                // if (empty($data['name'])) {
                //     $return['message'] .= __('Imię i nazwisko', 'kp-point-of-sale');
                //     $is = 1;
                // }
                // if (empty($data['phone'])) {
                //     if ($is > 0) {
                //         $return['message'] .= ', ';
                //     }
                //     $return['message'] .= __('Telefon', 'kp-point-of-sale');
                //     $is = 1;
                // }
                if (empty($data['mail'])) {
                    if ($is > 0) {
                        $return['message'] .= ', ';
                    }
                    $return['message'] .= __('E-mail', 'kp-point-of-sale');
                    $is = 1;
                }
                // if (empty($data['message'])) {
                //     if ($is > 0) {
                //         $return['message'] .= ', ';
                //     }
                //     $return['message'] .= __('Treść wiadomości', 'kp-point-of-sale');
                //     $is = 1;
                // }
                if (empty($data['accept'])) {
                    if ($is > 0) {
                        $return['message'] .= ' ' . __('oraz', 'kp-point-of-sale') . ' ';
                    }
                    $return['message'] .= __('nie zaznaczyłeś zgody na przetwarzanie danych osobowych.', 'kp-point-of-sale');
                    $is = 1;
                }

                $return['type'] = 'error';
            }
        }
    } else if ($isHuman === false) {
        $return = array(
            'message'  => __('Problem z wysłaniem wiadomości. Skontaktuj się na adres e-mail biuro@krispol.pl', 'kp-point-of-sale'),
            'type'       => 'error',
            'additionalInfo' => 'Probably it is bot.'
        );
    }
    wp_send_json($return);
    wp_die();
}
add_action('wp_ajax_kp_send_mail', 'kp_send_mail');
add_action('wp_ajax_nopriv_kp_send_mail', 'kp_send_mail');
