<?php
$list = 'active';
$grid = '';

if ( ! empty( $_GET['view'] ) and $_GET['view'] == 'grid' ) { //phpcs:ignore
	$list = '';
	$grid = 'active';
}
?>

	<div class="stm-car-listing-sort-units stm-car-listing-directory-sort-units clearfix">
		<div class="stm-listing-directory-title">
			<h4 class="stm-seller-title"><?php esc_html_e( 'My Favorites', 'motors' ); ?></h4>
		</div>
		<div class="stm-directory-listing-top__right">
			<div class="clearfix">
				<?php if ( stm_is_multilisting() ) : ?>
					<div class="multilisting-select">
						<?php
						$listings = stm_listings_multi_type_labeled( true );
						if ( ! empty( $listings ) ) :
							?>
							<div class="select-type select-listing-type" style="margin-right: 15px;">
								<div class="stm-label-type"><?php esc_html_e( 'Listing type', 'motors' ); ?></div>
								<select>
									<option value="all"
											selected><?php esc_html_e( 'All listing types', 'motors' ); ?></option>
									<?php foreach ( $listings as $slug => $label ) : ?>
										<option value="<?php echo esc_attr( $slug ); ?>" <?php echo ( isset( $_GET['listing_type'] ) && ! empty( $_GET['listing_type'] ) && $_GET['listing_type'] === $slug ) ? 'selected' : ''; //phpcs:ignore ?>><?php echo esc_html( $label ); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<div class="stm-view-by">
					<a href="
					<?php
					echo esc_url(
						add_query_arg(
							array(
								'page' => 'favourite',
								'view' => 'grid',
							),
							stm_get_author_link( '' )
						)
					);
					?>
					"
					class="view-grid view-type <?php echo esc_attr( $grid ); ?>">
						<i class="stm-icon-grid"></i>
					</a>
					<a href="
					<?php
					echo esc_url(
						add_query_arg(
							array(
								'page' => 'favourite',
								'view' => 'list',
							),
							stm_get_author_link( '' )
						)
					);
					?>
					" class="view-list view-type <?php echo esc_attr( $list ); ?>">
						<i class="stm-icon-list"></i>
					</a>
				</div>
			</div>
		</div>
	</div>

<?php
$user = wp_get_current_user();
if ( ! empty( $user->ID ) ) {

	$favourites = get_the_author_meta( 'stm_user_favourites', $user->ID );

	if ( ! empty( $favourites ) ) {

		$fav_type = stm_listings_multi_type( true );

		if ( isset( $_GET['listing_type'] ) && ! empty( $_GET['listing_type'] ) ) {//phpcs:ignore
			$fav_type = $_GET['listing_type'];//phpcs:ignore
		}

		$args = array(
			'post_type'      => $fav_type,
			'post_status'    => 'publish',
			'posts_per_page' => - 1,
			'post__in'       => array_unique( explode( ',', $favourites ) ),
		);

		$fav = new WP_Query( $args );

		$exist_adds = array();

		?>

		<?php if ( $fav->have_posts() ) : ?>
			<div class="
			<?php
			if ( 'active' === $grid ) {
				echo 'row';
			}
			?>
			car-listing-row clearfix">
				<?php
				while ( $fav->have_posts() ) :
					$fav->the_post();
					?>
					<?php
					$exist_adds[] = get_the_id();
					if ( 'active' === $list ) {
						?>
						<div class="stm-listing-fav-loop">
							<?php
							if ( 'draft' === get_post_status( get_the_ID() ) ) {
								?>
								<div class="stm-car-overlay-disabled"></div>
								<div class="stm_edit_pending_car">
									<h4><?php esc_html_e( 'Disabled', 'motors' ); ?></h4>
									<div class="stm-dots"><span></span><span></span><span></span></div>
								</div>
								<?php
							} elseif ( 'pending' === get_post_status( get_the_ID() ) ) {
								?>
								<div class="stm-car-overlay-disabled"></div>
								<div class="stm_edit_pending_car">
									<h4><?php esc_html_e( 'Under review', 'motors' ); ?></h4>
									<div class="stm-dots"><span></span><span></span><span></span></div>
								</div>
								<?php
							}
							get_template_part( 'partials/listing-cars/listing-list-directory', 'loop' );
							?>
						</div>
						<?php
					} else {
						get_template_part( 'partials/listing-cars/listing-grid-directory', 'loop' );
					}
					?>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>

		<!--Get deleted adds-->
		<?php
		$my_adds      = array_unique( explode( ',', $favourites ) );
		$deleted_adds = array_diff( $my_adds, $exist_adds );
		?>

		<?php if ( ! empty( $deleted_adds ) && ! isset( $_GET['listing_type'] ) ) : //phpcs:ignore?>
			<div class="stm-deleted-adds">
				<?php foreach ( $deleted_adds as $deleted_add ) : ?>
					<?php if ( 0 !== $deleted_add ) : ?>
						<div class="stm-deleted-add">
							<div class="heading-font">
								<i class="fas fa-times stm-listing-favorite" data-id="<?php echo esc_attr( $deleted_add ); ?>"></i>
								<?php esc_html_e( 'Item has been removed', 'motors' ); ?>
							</div>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( empty( $my_adds ) && empty( $deleted_adds ) ) : ?>
			<h4><?php esc_html_e( 'You have not added favorites yet', 'motors' ); ?>.</h4>
			<?php
		endif;

	} else {
		?>

		<h4><?php esc_html_e( 'You have not added favorites yet', 'motors' ); ?>.</h4>
		<?php
	}
}

$current_url = stm_get_author_link( '' );
$glue        = '?';

$url_array = $_GET;//phpcs:ignore
if ( isset( $url_array['listing_type'] ) ) {
	unset( $url_array['listing_type'] );
}

if ( ! empty( $url_array ) ) {
	$current_url = add_query_arg( $url_array, stm_get_author_link( '' ) );
	$glue        = '&';
}
?>
<?php // @codingStandardsIgnoreStart ?>
	<script type="text/javascript">
        jQuery(document).ready(function () {
            var $ = jQuery;
            $('.stm-deleted-adds .stm-deleted-add .heading-font .fa-times').on('click', function () {
                $(this).closest('.stm-deleted-add').slideUp();
            });
        });
	</script>
<?php if ( stm_is_multilisting() ) : ?>
	<script type="text/javascript">
        jQuery(document).ready(function () {
            var $ = jQuery;
            // listing type select
            $('.select-listing-type select').select2().on('change', function () {
                var opt_val = $(this).val();
                if (opt_val == 'all') {
                    location.href = '<?php echo esc_url( add_query_arg( array( 'page' => 'favourite' ), stm_get_author_link( '' ) ) ); ?>';
                } else {
                    location.href = '<?php echo esc_url( $current_url ) . esc_html( $glue ); ?>&listing_type=' + opt_val;
                }
            });
        });
	</script>
<?php endif; ?>
<?php // @codingStandardsIgnoreEnd ?>
