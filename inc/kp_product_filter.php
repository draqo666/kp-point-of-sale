<?php

/**
 * Generate product filters from taxonpmies
 * 
 * @param nothing
 * 
 * @return string echo form and script
 * 
 */

function kp_product_filter(){  
    echo "<div class='row'>";
    $all_offer = get_terms('typ_oferty', array('hide_empty' => false));
        foreach ($all_offer as $offer) { 
            if(isset($_SESSION['filters'])) {
                if(in_array($offer->term_id, $_SESSION['filters'])) {
                    $checked = true;
                } else {
                    $checked = false;
                }
            } else {
                $checked = null;
            }

            ?>
            <div class="col-12 col-md-6 not-margin">
                <label for="<?php echo $offer->term_id;?>">
                    <input type="checkbox" name="filter" id="<?php echo $offer->term_id;?>" value="<?php echo $offer->term_id;?>" <?php if($checked) { echo 'checked'; } ?>>
                    <span><?php echo $offer->name;?></span>
                </label>
            </div>
        <?php }
    echo '</div>';

    $btn['filter'] = __('Filtruj', 'kp-point-of-sale'); 
    $btn['reset'] = __('Reset', 'kp-point-of-sale'); 
    echo '<div class="row justify-content-end" style="padding-right: 1rem;">';
    echo '<input type="submit" value="'.$btn['filter'].'" class="krispol_button"><input type="reset" value="'.$btn['reset'].'" class="krispol_button">';
    echo '</div>';

    ?>


    <script>(function($) {
            "use_strict";
            var cboxArray = [];
            $('input[type="submit"]').click(function() {
                $('input[name="filter"]').each( function () {
                    if($(this).prop("checked")) {
                        cboxArray.push($(this).val());
                    }
                });
                $.ajax({
                    type: "POST",
                    url: $('.kp_point_of_sale').data('ajax-action'),
                    data: {'filters': cboxArray, 'action': 'kp_save_filters_session'},
                    dataType: "json",
                    success: function (data) {
                        location.reload(); 
                        //console.log(data)
                    },
                    error: function (err) {
                        location.reload();
                        //console.log(err)
                    }
                });
            });
            $('input[type="reset"]').click(function() {
                var cboxArray = [];

                $.ajax({
                    type: "POST",
                    url: $('.kp_point_of_sale').data('ajax-action'),
                    data: {'filters': cboxArray, 'action': 'kp_save_filters_session'},
                    dataType: "json",
                    success: function (data) {
                        location.reload();
                    },
                    error: function (err) {
                        location.reload();
                    }
                });
            });
        })(jQuery);
        </script>
    <?php
}