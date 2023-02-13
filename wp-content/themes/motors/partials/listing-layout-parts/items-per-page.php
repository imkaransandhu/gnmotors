<?php
$listing_grid_choices = explode(',', stm_me_get_wpcfto_mod('listing_grid_choices', '9,12,18,27'));
$view_type = sanitize_file_name( stm_listings_input( 'view_type', stm_me_get_wpcfto_mod( "listing_view_type", "list" ) ) );
$listing_grid_choice = (!empty(get_post_meta(stm_get_listing_archive_page_id(), ($view_type == 'grid') ? 'ppp_on_grid' : 'ppp_on_list', true))) ? get_post_meta(stm_get_listing_archive_page_id(), ($view_type == 'grid') ? 'ppp_on_grid' : 'ppp_on_list', true) : get_option( 'posts_per_page' );

if (!empty($_GET['posts_per_page'])) {
    $listing_grid_choice = intval($_GET['posts_per_page']);
}

if(!in_array($listing_grid_choice, $listing_grid_choices)) {
    $listing_grid_choices[] = intval($listing_grid_choice);
}

if (!empty($listing_grid_choices)): ?>
    <?php if (stm_is_motorcycle()): ?>
        <span class="stm_label heading-font"><?php esc_html_e('Vehicles per page:', 'motors'); ?></span>
    <?php endif; ?>
    <span class="first"><?php esc_html_e('Show', 'motors'); ?></span>
    <?php if (stm_is_motorcycle()): ?>
        <div class="stm_motorcycle_pp">
    <?php endif; ?>
    <ul>
        <?php foreach ($listing_grid_choices as $listing_grid_choice_single): ?>
            <?php
            if ($listing_grid_choice_single == $listing_grid_choice) {
                $active = 'active';
            } else {
                $active = '';
            }

            $link = add_query_arg(array('posts_per_page' => intval($listing_grid_choice_single)));
            $link = preg_replace( "/\/page\/\d+/", '', remove_query_arg(array('paged', 'ajax_action'), $link));
            ?>

            <li class="<?php echo esc_attr($active); ?>">
                <span>
                    <a href="<?php echo esc_url($link); ?>">
                        <?php echo intval($listing_grid_choice_single); ?>
                    </a>
                </span>
            </li>

        <?php endforeach; ?>
    </ul>
    <?php if (stm_is_motorcycle()): ?>
        </div>
    <?php endif; ?>
    <span class="last"><?php esc_html_e('items per page', 'motors'); ?></span>
<?php endif; ?>