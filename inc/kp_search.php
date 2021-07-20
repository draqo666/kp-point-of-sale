<?php
/**
 * Generate form 
 * 
 * @param nothing
 * 
 * @see kp_search_posts()
 * 
 * @return string echo form
 * 
 */
function kp_search(){
    ?>
    <div class="col-12">
        <div id="kpSearchForm"></div>
    </div>

    <?php 
    /*
    This is legacy form. We changed controls to React and querying from OpenStreetMaps,
    because we have to count distance, and show places near other cities.
    
        <div class="col-12">
            <form role="search" data-test="df" action="<?php echo site_url('/'); ?>" method="get" id="searchform">
                <div class="searchbox">
                    <label for="">
                        <p class="mb-4" style="text-transform: uppercase; font-weight: bold">
                            <?php echo __('Skorzystaj z wyszukiwarki', 'kp-point-of-sale'); ?>
                        </p>
                        <div class="searchbox_inner_wrapper">
                            <input type="text" name="s" placeholder="<?php echo __('Nazwa lub adres salonu', 'kp-point-of-sale'); ?>">
                            <input type="hidden" name="post_type" value="salon" />
                            <button type="submit"  class="krispol_button krispol_button_orange">
                                <?php echo __('Wyszukaj', 'kp-point-of-sale'); ?>
                            </button>
                        </div>
                    </label>
                </div>
            </form>
        </div>
    */
    ?>

    <?php
}