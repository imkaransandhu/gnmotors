<?php
if ( ! function_exists( 'stm_getCurrencySelectorHtml' ) ) {
	function stm_getCurrencySelectorHtml() {
		$show_currency_select = stm_me_get_wpcfto_mod( 'top_bar_currency_enable', false );
		$currency_list        = stm_me_get_wpcfto_mod( 'currency_list', '' );

		if ( ! empty( $currency_list ) && is_array( $currency_list ) ) {
			$current_currency = '';
			if ( isset( $_COOKIE['stm_current_currency'] ) ) {
				$mc               = explode( '-', sanitize_text_field( $_COOKIE['stm_current_currency'] ) );
				$current_currency = $mc[0];
			}

			$currency[0] = stm_me_get_wpcfto_mod( 'price_currency_name', 'USD' );
			$symbol[0]   = stm_me_get_wpcfto_mod( 'price_currency', '$' );
			$to[0]       = '1';

			if ( ! empty( $currency_list ) ) {
				foreach ( $currency_list as $k => $val ) {
					if ( ! empty( $val['currency'] ) && ! empty( $val['symbol'] ) && ! empty( $val['to'] ) ) {
						$currency[] = trim( $val['currency'] );
						$symbol[]   = trim( $val['symbol'] );
						$to[]       = trim( $val['to'] );
					}
				}
			}

			// translators: %s: Selected currency.
			$selected_currency_text = __( 'Currency (%s)', 'motors' );
			$select_html            = '<div class="pull-left currency-switcher">';
			$select_html           .= "<div class='stm-multiple-currency-wrap'><select data-translate='" . esc_attr( $selected_currency_text ) . "' data-class='stm-multi-currency' name='stm-multi-currency'>";
			$count_currency         = count( $currency );
			for ( $q = 0; $q < $count_currency; $q ++ ) {
				$selected      = ( $symbol[ $q ] === $current_currency ) ? 'selected' : '';
				$val           = html_entity_decode( $symbol[ $q ] ) . '-' . $to[ $q ];
				$currencyTitle = $currency[ $q ];

				if ( ! isset( $_COOKIE['stm_current_currency'] ) && 0 === $q || ! empty( $selected ) ) {
					$currencyTitle = sprintf( $selected_currency_text, $currency[ $q ] );
				}

				$select_html .= "<option value='{$val}' " . $selected . ">{$currencyTitle}</option>";
			}
			$select_html .= '</select></div>';
			$select_html .= '</div>';

			if ( count( $currency ) > 1 && $show_currency_select ) {
				echo wp_kses(
					$select_html,
					array(
						'select' => array(
							'data-translate' => array(),
							'data-class'     => array(),
							'name'           => array(),
						),
						'option' => array(
							'value'    => array(),
							'selected' => array(),
						),
						'div'    => array(
							'class' => array(),
						),
					)
				);
			}
		}
	}
}

if ( ! function_exists( 'getConverPrice' ) ) {
	function getConverPrice( $price ) {
		if ( isset( $_COOKIE['stm_current_currency'] ) ) {
			$default_currency = get_option( 'price_currency', '$' );
			$cookie           = explode( '-', sanitize_text_field( $_COOKIE['stm_current_currency'] ) );
			$cookie           = ( ! empty( $cookie[1] ) ) ? $cookie[1] : $default_currency;
			if ( is_numeric( $price ) && is_numeric( $cookie ) ) {
				$price = ( $price * $cookie );
			}
		}

		return $price;
	}
}
