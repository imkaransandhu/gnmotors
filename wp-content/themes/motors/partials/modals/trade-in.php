<div class="modal" id="trade-in" tabindex="-1" role="dialog" aria-labelledby="myModalLabelTradeIn">
	<div id="request-trade-in-offer">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-header-iconed">
					<i class="stm-moto-icon-trade"></i>
					<h3 class="modal-title" id="myModalLabelTradeIn">
						<?php esc_html_e( 'Trade in', 'motors' ); ?>
					</h3>
					<div class="test-drive-car-name">
						<?php echo wp_kses_post( stm_generate_title_from_slugs( get_queried_object_id() ) ); ?>
					</div>
					<div class="mobile-close-modal" data-dismiss="modal" aria-label="Close">
						<i class="fas fa-times" aria-hidden="true"></i>
					</div>
				</div>
				<div class="modal-body">
					<?php get_template_part( 'partials/trade-in', null, array( 'is_modal' => true ) ); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	(function($) {
		"use strict";

		$(document).ready(function(){
			if(window.location.hash === '#error-fields') {
				$('#trade-in').modal('show');
				history.pushState("", document.title, window.location.pathname + window.location.search);
			}
		});

	})(jQuery);
</script>
