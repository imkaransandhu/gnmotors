<?php
add_action( 'wp_footer', 'stm_mm_CurrentUrl' );
function stm_mm_CurrentUrl() {
	?>
	<script>
		var mmAjaxUrl = '<?php echo esc_js( admin_url( 'admin-ajax.php', 'relative' ) ); ?>';
	</script>
	<?php
}


add_action( 'wp_ajax_stm_mm_get_posts_by_cat', 'stm_mm_get_posts_by_cat' );
add_action( 'wp_ajax_nopriv_stm_mm_get_posts_by_cat', 'stm_mm_get_posts_by_cat' );
function stm_mm_get_posts_by_cat() {
	if ( empty( $_GET['catId'] ) ) {
		die;
	}

	$category_id  = intval( $_GET['catId'] );
	$view_style   = $_GET['viewStyle'];
	$has_children = $_GET['hasChild'];

	$pgp = '';
	switch ( $view_style ) {
		case 'stm-mm-hl':
			$pgp = ( 'has_child' !== $has_children ) ? 7 : 4;
			break;
		case 'stm-4-col':
			$pgp = 4;
			break;
		default:
			$pgp = 3;
	}

	$query = new WP_Query(
		array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => $pgp,
			'tax_query'      => array(
				array(
					'taxonomy' => 'category',
					'field'    => 'id',
					'terms'    => $category_id,
				),
			),
		)
	);

	$output = '';

	if ( $query->have_posts() ) {
		$q = 0;
		ob_start();
		while ( $query->have_posts() ) {
			$query->the_post();
			if ( 'stm-mm-hl' !== $view_style ) {
				require STM_MM_DIR . 'templates/loop/loop-' . $view_style . '.php';
			} else {
				if ( 0 === $q ) {
					require STM_MM_DIR . 'templates/loop/loop-' . $view_style . '-1.php';
				} else {
					require STM_MM_DIR . 'templates/loop/loop-' . $view_style . '-2.php';
				}
			}
			$q++;
		}

		$output .= ob_get_clean();
	}
	wp_reset_postdata();

	wp_send_json( $output );
	exit;
}
