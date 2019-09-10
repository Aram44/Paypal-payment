<?php
/**
 * @package paypal
 */

if ( !defined( 'WP_UNINSTALL_PLUGIN' )){
	die;
}
	delete_option('paypal_payment_address');
	delete_option('paypal_payment_currencye');
	delete_option('paypal_payment_subject');
	delete_option('paypal_payment_option1');
	delete_option('paypal_payment_value1');
	delete_option('paypal_payment_option2');
	delete_option('paypal_payment_value2');
	delete_option('paypal_payment_option3');
	delete_option('paypal_payment_value3');
	delete_option('paypal_payment_option4');
	delete_option('paypal_payment_value4');
	delete_option('paypal_payment_option5');
	delete_option('paypal_payment_value5');
	delete_option('paypal_payment_return_url');
	delete_option('paypal_payment_cancel_url');
	delete_option('paypal_payment_showoption');
	delete_option('paypal_payment_numoptions');
	delete_option('paypal_payment_otheramount');
	delete_option('paypal_payment_referencebox');
	delete_option('paypal_widget_titlename');
	delete_option('paypal_widget_referancetitle');
	delete_option('paypal_widget_img');