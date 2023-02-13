<?php
	if( !stm_is_car_dealer() ):
		$title_default = stm_me_get_wpcfto_mod( 'listing_directory_title_default', esc_html__( 'Cars for sale', 'motors' ) );
	?>
	<div class="stm-listing-directory-title">
		<h3 class="title"><?php echo esc_html( $title_default ); ?></h3>
	</div>
<?php endif; ?>
<div class="stm-car-listing-sort-units clearfix">
	<div class="stm-sort-by-options clearfix">
		<span><?php esc_html_e('Sort by:', 'motors'); ?></span>
		<div class="stm-select-sorting">
			<select>
				<?php echo stm_get_sort_options_html(); ?>
			</select>
		</div>
	</div>

	<?php
		$view_type = stm_listings_input('view_type', stm_me_get_wpcfto_mod("listing_view_type", "list"));
		if($view_type == 'list') {
			$view_list = 'active';
			$view_grid = '';
		} else {
			$view_grid = 'active';
			$view_list = '';
		}
	?>

	<div class="stm-view-by">
		<a href="#" class="view-grid view-type <?php echo esc_attr($view_grid); ?>" data-view="grid">
			<i class="stm-icon-grid"></i>
		</a>
		<a href="#" class="view-list view-type <?php echo esc_attr($view_list); ?>" data-view="list">
			<i class="stm-icon-list"></i>
		</a>
	</div>
</div>