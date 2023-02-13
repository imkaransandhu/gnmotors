<?php
$data = stm_get_single_car_listings();

$terms_args = array(
	'orderby'    => 'name',
	'order'      => 'ASC',
	'hide_empty' => false,
	'fields'     => 'all',
	'pad_counts' => true,
);

?>
<div class="stm_add_car_form_1">
	<div class="stm-car-listing-data-single stm-border-top-unit ">
		<div class="title heading-font"><?php esc_html_e( 'Listing Item Details', 'motors' ); ?></div>
		<span class="step_number step_number_1 heading-font"><?php esc_html_e( 'step', 'motors' ); ?> 1</span>
	</div>

	<?php if ( !empty( $taxonomy ) ): ?>
		<div class="stm-form1-intro-unit">
			<div class="row">
				<?php
					foreach ( $taxonomy as $tax ):
					$tax_info = stm_get_all_by_slug($tax);

					$terms = [];
					
					if(empty($tax_info['listing_taxonomy_parent'])) {
						$terms = stm_get_category_by_slug_all($tax, true);
					}

                    $has_selected = '';
					
                    if(!empty($id)) {
                        $post_terms = wp_get_post_terms($id, $tax);
                        if(!empty($post_terms[0])) {
                            $has_selected = $post_terms[0]->slug;
                        } elseif (!empty($tax_info["slug"])) {
	                        $has_selected = get_post_meta($id, $tax_info['slug'], true);
                        }
                    }

					$number_field = false;

					if($use_inputs && !empty($tax_info['numeric']) && $tax_info['numeric']) $number_field = true;
                ?>
					<div class="col-md-3 col-sm-3 stm-form-1-selects">
						<div class="stm-label heading-font"><?php echo esc_html(stm_get_name_by_slug($tax)); ?>*</div>
						<?php if($number_field): ?>
                            <?php $value = get_post_meta($id, $tax_info['slug'], true); ?>
							<input value="<?php echo esc_attr($value); ?>" min="0" type="number" name="stm_f_s[<?php echo esc_attr($tax); ?>]" required />
						<?php else: ?>
							<select class="add_a_car-select" data-class="stm_select_overflowed" data-selected="<?php echo esc_attr($has_selected); ?>" name="stm_f_s[<?php echo esc_attr(str_replace("-", "_pre_", $tax)); ?>]">
								<option value="" selected="selected"><?php esc_html_e('Select', 'motors'); ?> <?php echo esc_html(stm_get_name_by_slug($tax)); ?></option>
								<?php if(!empty($terms)):
									foreach($terms as $term): ?>
										<option value="<?php echo esc_attr($term->slug); ?>" <?php if(!empty($has_selected) and $term->slug == $has_selected) {echo 'selected';} ?>>
											<?php echo trim(esc_attr($term->name)); ?>
										</option>
									<?php endforeach; ?>
								<?php endif; ?>
							</select>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<style type="text/css">
			<?php foreach($taxonomy as $tax): ?>

			.stm-form1-intro-unit .select2-selection__rendered[title="<?php esc_html_e('Select', 'motors'); ?> <?php stm_dynamic_string_translation_e('Add A Car Step 1 Slug Name', stm_get_name_by_slug($tax)); ?>"] {
				background-color: transparent !important;
				border: 1px solid rgba(255,255,255,0.5);
				color: #fff !important;
			}
			.stm-form1-intro-unit .select2-selection__rendered[title="<?php esc_html_e('Select', 'motors'); ?> <?php stm_dynamic_string_translation_e('Add A Car Step 1 Slug Name', stm_get_name_by_slug($tax)); ?>"] + .select2-selection__arrow b {
				color: rgba(255,255,255,0.5);
			}
			<?php endforeach; ?>
		</style>
	<?php endif; ?>

	<div class="stm-form-1-end-unit clearfix">
		<?php if ( ! empty( $data ) && is_array($taxonomy) ): ?>
			<?php foreach ( $data as $data_key => $data_unit ): ?>
			<?php
                if(!in_array($data_unit['slug'], $taxonomy)) :
                $terms = get_terms( $data_unit['slug'], $terms_args );
                ?>
			<div class="stm-form-1-quarter">
				<?php if ( ! empty( $data_unit['numeric'] ) and $data_unit['numeric'] ): ?>

					<?php $value = '';
					if(!empty($id)) {
						$value = get_post_meta($id, $data_unit['slug'], true);
					} ?>

					<input
						type="number"
						class="form-control <?php echo (!empty($value)) ? 'stm_has_value' : ''; ?>"
						name="stm_s_s_<?php echo esc_attr( $data_unit['slug'] ); ?>"
						value="<?php echo esc_attr($value); ?>"
						placeholder="<?php printf(esc_attr__( 'Enter %s %s', 'motors' ), esc_attr__( $data_unit['single_name'], 'motors' ), ( ! empty( $data_unit['number_field_affix'] ) ) ? '(' . esc_attr__( $data_unit['number_field_affix'], 'motors' ) . ')' : '') ; ?>"
					/>
				<?php else: ?>
					<select name="stm_s_s_<?php echo esc_attr( $data_unit['slug'] ) ?>" class="add_a_car-select">
						<?php $selected = '';
						if(!empty($id)) {
							$selected = get_post_meta($id, $data_unit['slug'], true);
						}
						?>
						<option value=""><?php printf(esc_html__( 'Select %s', 'motors' ), esc_html__( $data_unit['single_name'], 'motors' )) ?></option>
						<?php if ( ! empty( $terms ) ):
							foreach ( $terms as $term ): ?>
								<?php
								$selected_opt = '';
								if($selected == $term->slug) {
									$selected_opt = 'selected';
								} ?>
								<option value="<?php echo esc_attr( $term->slug ); ?>" <?php echo esc_attr($selected_opt); ?>><?php echo esc_attr( $term->name ); ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				<?php endif; ?>
				<div class="stm-label">
					<?php if ( ! empty( $data_unit['font'] ) ): ?>
						<i class="<?php echo esc_attr( $data_unit['font'] ); ?>"></i>
					<?php endif; ?>
					<?php stm_dynamic_string_translation_e('Add A Car Step 1 Taxonomy Label ' . $data_unit['single_name'], $data_unit['single_name']); ?>
				</div>
			</div>
        <?php endif; ?>
		<?php endforeach; ?>

			<style type="text/css">
				<?php foreach($data as $data_unit): ?>

				.stm-form-1-end-unit .select2-selection__rendered[title="<?php echo esc_attr__('Select', 'motors'); ?> <?php stm_dynamic_string_translation_e('Add A Car Step 1 Taxonomy Label', $data_unit['single_name']); ?>"] {
					background-color: transparent !important;
					border: 1px solid rgba(255, 255, 255, 0.5);
					color: #888 !important;
				}

				<?php endforeach; ?>
			</style>

			<?php stm_listings_load_template('add_car/step_1_additional_fields', array('histories' => $stm_histories, 'post_id' => $id)); ?>

            <?php
                $data_value = get_post_meta($id, 'stm_car_location', true);
                $data_value_lat = get_post_meta($id, 'stm_lat_car_admin', true);
                $data_value_lng = get_post_meta($id, 'stm_lng_car_admin', true);
            ?>

                <div class="stn-add-car-location-wrap">
                    <div class="stm-car-listing-data-single">
                        <div class="title heading-font"><?php esc_html_e( 'Listing item Location', 'motors' ); ?></div>
                    </div>
                    <div class="stm-form-1-quarter stm_location stm-location-search-unit">
                        <div class="stm-location-input-wrap stm-location">
                            <div class="stm-label">
                                <i class="stm-service-icon-pin_2"></i>
                                <?php esc_html_e('Location', 'motors'); ?>
                            </div>
                            <input type="text" name="stm_location_text"<?php if (!empty($data_value)) { ?> class="stm_has_value" <?php } ?>
                                   id="stm-add-car-location" value="<?php echo esc_attr($data_value); ?>"
                                   placeholder="<?php esc_attr_e('Enter ZIP or Address', 'motors'); ?>"/>
                        </div>
                        <div class="stm-location-input-wrap stm-lng">
                            <div class="stm-label">
                                <i class="stm-service-icon-pin_2"></i>
                                <?php esc_html_e('Latitude', 'motors'); ?>
                            </div>
                            <input type="text" class="text_stm_lat" name="stm_lat" value="<?php echo esc_attr($data_value_lat); ?>"
                                   placeholder="<?php esc_attr_e('Enter Latitude', 'motors'); ?>"/>
                        </div>
                        <div class="stm-location-input-wrap stm-lng">
                            <div class="stm-label">
                                <i class="stm-service-icon-pin_2"></i>
                                <?php esc_html_e('Longitude', 'motors'); ?>
                            </div>
                            <input type="text" class="text_stm_lng" name="stm_lng" value="<?php echo esc_attr($data_value_lng); ?>"
                                   placeholder="<?php esc_attr_e('Enter Longitude', 'motors'); ?>"/>
                        </div>
                        <div class="stm-link-lat-lng-wrap">
                            <a href="https://www.latlong.net/" target="_blank"><?php echo esc_html__('Lat and Long Finder', 'motors'); ?></a>
                        </div>
                    </div>
                </div>

		<?php endif; ?>
	</div>
</div>