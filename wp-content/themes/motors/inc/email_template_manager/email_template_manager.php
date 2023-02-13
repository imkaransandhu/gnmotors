<?php
add_action( 'admin_menu', 'add_email_template_view' );
function add_email_template_view() {
	$title = esc_html__( 'Email Template Manager', 'motors' );
	add_submenu_page( 'tools.php', $title, $title, 'administrator', 'email-templaet-manager', 'email_template_view' );
}

function email_template_view() {
	get_template_part( 'inc/email_template_manager/main' );
}

function get_default_subject( $template_name ) {
	$test_drive              = esc_html__( 'Request Test Drive [car]', 'motors' );
	$request_price           = esc_html__( 'Request car price [car]', 'motors' );
	$trade_offer             = esc_html__( 'Trade offer [car]', 'motors' );
	$trade_in                = esc_html__( 'Car Trade In', 'motors' );
	$sell_a_car              = esc_html__( 'Sell a car', 'motors' );
	$add_a_car               = esc_html__( 'Car Added', 'motors' );
	$pay_per_listing         = esc_html__( 'New Pay Per Listing', 'motors' );
	$report_review           = esc_html__( 'Report Review', 'motors' );
	$password_recovery       = esc_html__( 'Password recovery', 'motors' );
	$request_for_a_dealer    = esc_html__( 'Request for becoming a dealer', 'motors' );
	$welcome                 = esc_html__( 'Welcome', 'motors' );
	$new_user                = esc_html__( 'New user', 'motors' );
	$user_listing_wait       = esc_html__( 'Add a car', 'motors' );
	$user_listing_approved   = esc_html__( 'Car Approved', 'motors' );
	$user_email_confirmation = esc_html__( 'User Email Confirm', 'motors' );

	return ${'' . $template_name};
}

function getDefaultTemplate( $template_name ) {
	$test_drive = '<table>
        <tr>
            <td>Name - </td>
            <td>[name]</td>
        </tr>
        <tr>
            <td>Email - </td>
            <td>[email]</td>
        </tr>
        <tr>
            <td>Phone - </td>
            <td>[phone]</td>
        </tr>
        <tr>
            <td>Date - </td>
            <td>[best_time]</td>
        </tr>
    </table>';

	$request_price = '<table>
        <tr>
            <td>Name - </td>
            <td>[name]</td>
        </tr>
        <tr>
            <td>Email - </td>
            <td>[email]</td>
        </tr>
        <tr>
            <td>Phone - </td>
            <td>[phone]</td>
        </tr>
    </table>';

	$trade_offer = '<table>
        <tr>
            <td>Name - </td>
            <td>[name]</td>
        </tr>
        <tr>
            <td>Email - </td>
            <td>[email]</td>
        </tr>
        <tr>
            <td>Phone - </td>
            <td>[phone]</td>
        </tr>
        <tr>
            <td>Trade Offer - </td>
            <td>[price]</td>
        </tr>
    </table>';

	$trade_in = '<table>
        <tr>
            <td>First name - </td>
            <td>[first_name]</td>
        </tr>
        <tr>
            <td>Last Name - </td>
            <td>[last_name]</td>
        </tr>
        <tr>
            <td>Email - </td>
            <td>[email]</td>
        </tr>
        <tr>
            <td>Phone - </td>
            <td>[phone]</td>
        </tr>
        <tr>
            <td>Car - </td>
            <td>[car]</td>
        </tr>
        <tr>
            <td>Make - </td>
            <td>[make]</td>
        </tr>
        <tr>
            <td>Model - </td>
            <td>[model]</td>
        </tr>
        <tr>
            <td>Year - </td>
            <td>[stm_year]</td>
        </tr>
        <tr>
            <td>Transmission - </td>
            <td>[transmission]</td>
        </tr>
        <tr>
            <td>Mileage - </td>
            <td>[mileage]</td>
        </tr>
        <tr>
            <td>Vin - </td>
            <td>[vin]</td>
        </tr>
        <tr>
            <td>Exterior color</td>
            <td>[exterior_color]</td>
        </tr>
        <tr>
            <td>Interior color</td>
            <td>[interior_color]</td>
        </tr>
        <tr>
            <td>Exterior condition</td>
            <td>[exterior_condition]</td>
        </tr>
        <tr>
            <td>Interior condition</td>
            <td>[interior_condition]</td>
        </tr>
        <tr>
            <td>Owner</td>
            <td>[owner]</td>
        </tr>
        <tr>
            <td>Accident</td>
            <td>[accident]</td>
        </tr>
        <tr>
            <td>Comments</td>
            <td>[comments]</td>
        </tr>
    </table>';

	$add_a_car = '<table>
        <tr>
            <td>User Added car.</td>
            <td></td>
        </tr>
        <tr>
            <td>User id - </td>
            <td>[user_id]</td>
        </tr>
        <tr>
            <td>Car ID - </td>
            <td>[car_id]</td>
        </tr>
    </table>';

	$update_a_car_ppl = '<table>
        <tr>
            <td>User Updated car.</td>
            <td></td>
        </tr>
        <tr>
            <td>User id - </td>
            <td>[user_id]</td>
        </tr>
        <tr>
            <td>Car ID - </td>
            <td>[car_id]</td>
        </tr>
        <tr>
            <td>Revision Link - </td>
            <td>[revision_link]</td>
        </tr>
    </table>';

	$pay_per_listing = '<table>
        <tr>
            <td>New Pay Per Listing. Order id - </td>
            <td>[order_id]</td>
        </tr>
        <tr>
            <td>Order status - </td>
            <td>[order_status]</td>
        </tr>
        <tr>
            <td>User - </td>
            <td>[first_name] [last_name] [email]</td>
        </tr>
        <tr>
            <td>Car Title - </td>
            <td>[listing_title]</td>
        </tr>
        <tr>
            <td>Car Id - </td>
            <td>[car_id]</td>
        </tr>
    </table>';

	$report_review = '<table>
        <tr>
            <td colspan="2">Review with id: "[report_id]" was reported</td>
        </tr>
        <tr>
            <td>Report content</td>
            <td>[review_content]</td>
        </tr>
    </table>';

	$password_recovery = '<table>
        <tr>
            <td>Please, follow the link, to set new password:</td>
            <td>[password_content]</td>
        </tr>
    </table>';

	$request_for_a_dealer = '<table>
        <tr>
            <td>User Login:</td>
            <td>[user_login]</td>
        </tr>
    </table>';

	$welcome = '<table>
        <tr>
            <td>Congratulations! You have been registered in our website with a username: </td>
            <td>[user_login]</td>
        </tr>
    </table>';

	$new_user = '<table>
        <tr>
            <td>New user Registered. Nickname: </td>
            <td>[user_login]</td>
        </tr>
    </table>';

	$user_listing_wait = '<table>
        <tr>
            <td>Your car [car_title] is waiting to approve.</td>
            <td></td>
        </tr>
    </table>';

	$user_listing_approved = '<table>
        <tr>
            <td>Your car [car_title] is approved.</td>
            <td></td>
        </tr>
    </table>';

	return ${'' . $template_name};
}

function getTemplateShortcodes( $template_name ) {
	$testDrive = array(
		'car'       => '[car]',
		'f_name'    => '[name]',
		'email'     => '[email]',
		'phone'     => '[phone]',
		'best_time' => '[best_time]',
	);

	$requestPrice = array(
		'car'    => '[car]',
		'f_name' => '[name]',
		'email'  => '[email]',
		'phone'  => '[phone]',
	);

	$tradeOffer = array(
		'car'    => '[car]',
		'f_name' => '[name]',
		'email'  => '[email]',
		'phone'  => '[phone]',
		'price'  => '[price]',
	);

	$tradeIn = array(
		'car'                => '[car]',
		'first_name'         => '[first_name]',
		'last_name'          => '[last_name]',
		'email'              => '[email]',
		'phone'              => '[phone]',
		'make'               => '[make]',
		'model'              => '[model]',
		'stm_year'           => '[stm_year]',
		'transmission'       => '[transmission]',
		'mileage'            => '[mileage]',
		'vin'                => '[vin]',
		'exterior_color'     => '[exterior_color]',
		'interior_color'     => '[interior_color]',
		'owner'              => '[owner]',
		'exterior_condition' => '[exterior_condition]',
		'interior_condition' => '[interior_condition]',
		'accident'           => '[accident]',
		'comments'           => '[comments]',
		'video_url'          => '[video_url]',
		'image_urls'         => '[image_urls]',
	);

	$addACar = array(
		'user_id' => '[user_id]',
		'car_id'  => '[car_id]',
	);

	$userCar = array(
		'car_id'    => '[car_id]',
		'car_title' => '[car_title]',
	);

	$updateACarPPL = array(
		'user_id'       => '[user_id]',
		'car_id'        => '[car_id]',
		'revision_link' => '[revision_link]',
	);

	$perPayListing = array(
		'first_name'    => '[first_name]',
		'last_name'     => '[last_name]',
		'email'         => '[email]',
		'order_id'      => '[order_id]',
		'order_status'  => '[order_status]',
		'listing_title' => '[listing_title]',
		'car_id'        => '[car_id]',
	);

	$reportReview = array(
		'report_id'      => '[report_id]',
		'review_content' => '[review_content]',
	);

	$passwordRecovery = array(
		'password_content' => '[password_content]',
	);

	$requestForADealer = array(
		'user_login' => '[user_login]',
	);

	$welcome = array(
		'user_login' => '[user_login]',
	);

	$valueMyCar = array(
		'car'   => '[car]',
		'email' => '[email]',
		'price' => '[price]',
	);

	$newUser = array(
		'user_login' => '[user_login]',
	);

	$userConfirmationEmail = array(
		'user_login'        => '[user_login]',
		'confirmation_link' => '[confirmation_link]',
		'site_name'         => '[site_name]',
	);

	return ${'' . $template_name};
}

function updateTemplates() {
	$opt = array( 'add_a_car_', 'user_listing_wait_', 'user_listing_approved_', 'update_a_car_ppl_', 'trade_in_', 'trade_offer_', 'request_price_', 'test_drive_', 'update_a_car_', 'report_review_', 'password_recovery_', 'request_for_a_dealer_', 'welcome_', 'new_user_', 'pay_per_listing_', 'value_my_car_', 'user_email_confirmation_' );

	foreach ( $opt as $key ) {
		update_option( $key . 'template', $_POST[ $key . 'template' ] ); // todo sanitize
		update_option( $key . 'subject', $_POST[ $key . 'subject' ] ); // todo sanitize
		if ( 'trade_in_' === $key ) {
			update_option( 'sell_a_car_subject', $_POST['sell_a_car_subject'] ); // todo sanitize
		} elseif ( 'value_my_car_' === $key ) {
			update_option( 'value_my_car_reject_subject', $_POST['value_my_car_reject_subject'] ); // todo sanitize
			update_option( 'value_my_car_reject_template', $_POST['value_my_car_reject_template'] ); // todo sanitize
		}
	}
}

if ( isset( $_POST['update_email_templates'] ) ) {
	updateTemplates();
}

function stm_generate_subject_view( $subject_name, $args ) {
	$template = stripslashes( get_option( $subject_name . '_subject', get_default_subject( $subject_name ) ) );

	if ( $template != '' ) {
		foreach ( $args as $k => $val ) {
			$template = str_replace( "[{$k}]", $val, $template );
		}

		return $template;
	}

	return '';
}

function stm_generate_template_view( $template_name, $args ) {
	$template = stripslashes( get_option( $template_name . '_template', getDefaultTemplate( $template_name ) ) );

	if ( ! empty( $template ) ) {
		foreach ( $args as $k => $val ) {
			$template = str_replace( "[{$k}]", $val, $template );
		}

		return $template;
	}

	return '';
}
