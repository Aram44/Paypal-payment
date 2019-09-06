<?php
/**
 * Plugin Name: Paypal
 * Description: Paypal payment by Aram
 * Version: 1.0
 * Author: Aram
 *
 * @package paypal
 */

defined( 'ABSPATH' ) || exit;

function add_paypal_plugin_scripts() {
    wp_enqueue_script('jquery');
	wp_enqueue_script( 'widget-script', plugins_url( '\assets\paypal-plugin.js', __FILE__ ), array('jquery') );
}

add_action( 'wp_enqueue_scripts', 'add_paypal_plugin_scripts' );

function add_paypal_page(){
	require_once plugin_dir_path(__FILE__) . 'paypal-adminbar-page.php';
}
function add_paypal_widget_page(){
	require_once plugin_dir_path(__FILE__) . 'paypal-widget-options-page.php';
}
function add_paypal_admin_pages(){
	add_menu_page('Paypal payment', 'Paypal', 'manage_options', 'paypal_payment', 'add_paypal_page', 'dashicons-screenoptions', 75);
	add_submenu_page( 'paypal_payment', 'Paypal payment', 'Widget', true, 'paypal_widget',  'add_paypal_widget_page' );
}

add_action('admin_menu', 'add_paypal_admin_pages' );

function pay_pal_plugin_install(){
		add_option('paypal_payment_address', get_bloginfo('admin_email'));
		add_option('paypal_payment_currencye', 'USD');
		add_option('paypal_payment_subject', 'Plugin Service Payment');
		add_option('paypal_payment_option1', 'Basic Service - 10');
		add_option('paypal_payment_value1', '10');
		add_option('paypal_payment_option2', 'Gold Service - 20');
		add_option('paypal_payment_value2', '20');
		add_option('paypal_payment_option3', 'Platinum Service - 30');
		add_option('paypal_payment_value3', '30');
		add_option('paypal_payment_option4', '');
		add_option('paypal_payment_value4', '');
		add_option('paypal_payment_option5', '');
		add_option('paypal_payment_value5', '');
        add_option('paypal_payment_return_url', home_url());
        add_option('paypal_payment_cancel_url', home_url());
		add_option('paypal_payment_showoption', 'true');
		add_option('paypal_payment_numoptions', '1');
		add_option('paypal_payment_otheramount', 'true');
		add_option('paypal_payment_referencebox', 'true');
		add_option('paypal_widget_titlename', 'PayPal Widget');
		add_option('paypal_widget_referancetitle', get_bloginfo('admin_email'));
		add_option('paypal_widget_img', plugins_url('/Paypal-payment/img/pay1.gif'));
	}
function paypal_show_error_message(){
    _e('<p>Error: Please re-activate this plugin</p>');
}

if (!class_exists('Paypal_Widget')) {
class Paypal_Widget extends WP_Widget {
	function Paypal_Widget () {
		parent::__construct( false, 'PayPal Widget' );
	}
	function widget( $args, $instance ) {

	define('PP_BUTTON_IMG', get_option('paypal_widget_img'));

    $paypal_payment_email = get_option('paypal_payment_address') || paypal_show_error_message();
    $paypal_payment_currency = get_option('paypal_payment_currencye') || paypal_show_error_message();
    $paypal_payment_subject = get_option('paypal_payment_subject') || paypal_show_error_message();
    $paypal_plugin_showpotion = get_option('paypal_payment_showoption') || paypal_show_error_message();

    $paypal_plugin_val1 = get_option('paypal_payment_value1');
	$paypal_plugin_val2 = get_option('paypal_payment_value2');
	$paypal_plugin_val3 = get_option('paypal_payment_value3');
	$paypal_plugin_val4 = get_option('paypal_payment_value4');
	$paypal_plugin_val5 = get_option('paypal_payment_value5');

    $paypal_print_widget = '';
    $paypal_print_widget .= '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" class="wp_paypal_pay">';
    $paypal_print_widget .= '<input type="hidden" name="cmd" value="_xclick" />';
    $paypal_print_widget .= '<input type="hidden" name="business" value="'.esc_attr($paypal_payment_email).'" />';
    $paypal_print_widget .= '<input type="hidden" name="item_name" value="'.esc_attr($paypal_payment_subject).'" />';
    $paypal_print_widget .= '<input type="hidden" name="currency_code" value="'.esc_attr($paypal_payment_currency).'" />';
    $paypal_print_widget .= '<div><h2 class="widget-title">'.get_option('paypal_widget_titlename').'</h2>';

    if (empty($paypal_plugin_val1)===true and empty($paypal_plugin_val2)===true and empty($paypal_plugin_val3)===true and empty($paypal_plugin_val4)===true and empty($paypal_plugin_val5)===true) {
	    $paypal_plugin_showpotion = false;
	}else{
		$paypal_print_widget .= '<select id="amount" name="amount" style="width: 300px;">';
	}
    if (!empty($paypal_plugin_val1)) {
		$paypal_print_widget .= '<option value='.$paypal_plugin_val1.'>'.get_option('paypal_payment_option1').' '.get_option('paypal_payment_currencye').'</option>';}
    if (!empty($paypal_plugin_val2)) {
		$paypal_print_widget .= '<option value='.$paypal_plugin_val2.'>'.get_option('paypal_payment_option2').' '.get_option('paypal_payment_currencye').'</option>';}
    if (!empty($paypal_plugin_val3)) {
		$paypal_print_widget .= '<option value='.$paypal_plugin_val3.'>'.get_option('paypal_payment_option3').' '.get_option('paypal_payment_currencye').'</option>';}
    if (!empty($paypal_plugin_val4)) {
		$paypal_print_widget .= '<option value='.$paypal_plugin_val4.'>'.get_option('paypal_payment_option4').' '.get_option('paypal_payment_currencye').'</option>';}
	if (!empty($paypal_plugin_val5)) {
		$paypal_print_widget .= '<option value='.$paypal_plugin_val5.'>'.get_option('paypal_payment_option5').' '.get_option('paypal_payment_currencye').'</option>';}
    if ($paypal_plugin_showpotion == true)
		$paypal_print_widget .= '</select><br>';
    if(get_option('paypal_payment_otheramount')=='true' or $paypal_plugin_showpotion == false){
		$paypal_print_widget .= '<div"><strong>Other Amount:</strong></div>';
		$paypal_print_widget .= '<div style="margin-top:10px;"><input type="number" min="1" step="any" name="other_amount" title="Other Amount" value="" style="max-width:80px;"></div>';
	}
	if (get_option('paypal_payment_referencebox')==='true') {
		$paypal_print_widget .= '<strong>'.get_option('paypal_widget_referancetitle').'</strong>';
		$paypal_print_widget .= '<input type="hidden" name="on0" value="'.apply_filters('wp_pp_button_reference_name','Reference').'"/>';
		$paypal_print_widget .= '<div><input type="text" name="os0" maxlength="60" value="'.apply_filters('wp_pp_button_reference_value','').'"/></div>';
	}

    $paypal_print_widget .= '<input type="hidden" name="no_shipping" value="0" /><input type="hidden" name="no_note" value="1" /><input type="hidden" name="bn" value="TipsandTricks_SP" />';
    
    if (!empty($wp_pp_return_url)) {
        $paypal_print_widget .= '<input type="hidden" name="return" value="'.get_option('paypal_payment_return_url').'" />';
    } else {
        $paypal_print_widget .='<input type="hidden" name="return" value="' . home_url() . '" />';
    }

    if (!empty($wp_pp_cancel_url)) {
        $paypal_print_widget .= '<input type="hidden" name="cancel_return" value="' .get_option('paypal_payment_cancel_url'). '" />';
    }
    
    $paypal_print_widget .= '<div>';
    $paypal_print_widget .= '<br><input type="image" src="'.PP_BUTTON_IMG.'" name="submit" alt="Pay" style="width: 130px;" id="paybutton">';
    $paypal_print_widget .= '</div>';
    
    $paypal_print_widget .= '</form>';
    echo $paypal_print_widget;
	}
	function update( $new_instance, $old_instance ) {
		
	}
	function form($instance) {
		_e("Set the Plugin Settings from the Widget menu");
	}
}
}
function register_Paypal_Widget() {
	register_widget( 'Paypal_Widget' );
}

add_action( 'widgets_init', 'register_Paypal_Widget' );
register_activation_hook(__FILE__, 'pay_pal_plugin_install' );