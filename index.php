<?php
/**
 * Plugin Name: Paypal
 * Description: Paypal payment by Aram
 * Version: 1.0
 * Author: Aram
 *
 * @package paypal
 */

defined('ABSPATH') or die('Error: file not found');

    function add_paypal_page(){
		require_once plugin_dir_path(__FILE__) . 'admin.php';
	}
	function add_widget_page(){
		require_once plugin_dir_path(__FILE__) . 'widgetoptions.php';
	}
    function add_admin_pages(){
		add_menu_page('Paypal payment', 'Paypal', 'manage_options', 'paypal_payment', 'add_paypal_page', 'dashicons-screenoptions', 75);
		add_submenu_page( 'paypal_payment', 'Paypal payment', 'Widget', true, 'paypal_widget',  'add_widget_page' );
	}
    add_action('admin_menu', 'add_admin_pages' );
function pay_pal_activate(){
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
		add_option('paypal_widget_img', 'pay1');
	}

class Paypal_Widget extends WP_Widget {
	function Paypal_Widget () {
		parent::__construct( false, 'PayPal Widget' );
	}
	function widget( $args, $instance ) {
    $paypal_payment_email = get_option('paypal_payment_address');
    $paypal_payment_currency = get_option('paypal_payment_currencye');
    $paypal_payment_subject = get_option('paypal_payment_subject');
    $pp_showoption = get_option('paypal_payment_showoption');

    $pp_val1 = get_option('paypal_payment_value1');
	$pp_val2 = get_option('paypal_payment_value2');
	$pp_val3 = get_option('paypal_payment_value3');
	$pp_val4 = get_option('paypal_payment_value4');
	$pp_val5 = get_option('paypal_payment_value5');

    $paypal_button = get_option('paypal_widget_img');

    /* === Paypal form === */
    $output = '';
    $output .= '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" class="wp_paypal_pay">';
    $output .= '<input type="hidden" name="cmd" value="_xclick" />';
    $output .= '<input type="hidden" name="business" value="'.esc_attr($paypal_payment_email).'" />';
    $output .= '<input type="hidden" name="item_name" value="'.esc_attr($paypal_payment_subject).'" />';
    $output .= '<input type="hidden" name="currency_code" value="'.esc_attr($paypal_payment_currency).'" />';
    $output .= '<div><h2 class="widget-title">'.get_option('paypal_widget_titlename').'</h2>';

    if (empty($pp_val1)==true and empty($pp_val2)==true and empty($pp_val3)==true and empty($pp_val4)==true and empty($pp_val5)==true) {
	    $pp_showoption = false;
	}else{
		$output .= '<select id="amount" name="amount" style="width: 300px;">';
	}
    if (!empty($pp_val1)) {
		$output .= '<option value='.$pp_val1.'>'.get_option('paypal_payment_option1').' '.get_option('paypal_payment_currencye').'</option>';}
    if (!empty($pp_val2)) {
		$output .= '<option value='.$pp_val2.'>'.get_option('paypal_payment_option2').' '.get_option('paypal_payment_currencye').'</option>';}
    if (!empty($pp_val3)) {
		$output .= '<option value='.$pp_val3.'>'.get_option('paypal_payment_option3').' '.get_option('paypal_payment_currencye').'</option>';}
    if (!empty($pp_val4)) {
		$output .= '<option value='.$pp_val4.'>'.get_option('paypal_payment_option4').' '.get_option('paypal_payment_currencye').'</option>';}
	if (!empty($pp_val5)) {
		$output .= '<option value='.$pp_val5.'>'.get_option('paypal_payment_option5').' '.get_option('paypal_payment_currencye').'</option>';}
    if ($pp_showoption == true)
		$output .= '</select>';
    if(get_option('paypal_payment_otheramount')=='true' or $pp_showoption == false){
		$output .= '<div"><strong>Other Amount:</strong></div>';
		$output .= '<div style="margin-top:10px;"><input type="number" min="1" step="any" name="other_amount" title="Other Amount" value="" style="max-width:80px;"></div>';
	}
	if (get_option('paypal_payment_referencebox')=='true') {
		$output .= '<strong>'.get_option('paypal_widget_referancetitle').'</strong>';
		$output .= '<input type="hidden" name="on0" value="'.apply_filters('wp_pp_button_reference_name','Reference').'"/>';
		$output .= '<div><input type="text" name="os0" maxlength="60" value="'.apply_filters('wp_pp_button_reference_value','').'"/></div>';
	}

    $output .= '<input type="hidden" name="no_shipping" value="0" /><input type="hidden" name="no_note" value="1" /><input type="hidden" name="bn" value="TipsandTricks_SP" />';
    
    if (!empty($wp_pp_return_url)) {
        $output .= '<input type="hidden" name="return" value="'.get_option('paypal_payment_return_url').'" />';
    } else {
        $output .='<input type="hidden" name="return" value="' . home_url() . '" />';
    }

    if (!empty($wp_pp_cancel_url)) {
        $output .= '<input type="hidden" name="cancel_return" value="' .get_option('paypal_payment_cancel_url'). '" />';
    }
    
    $output .= '<div>';
    $output .= '<br><input type="image" src="'.plugins_url().'/Paypal-payment/img/'.$paypal_button.'.gif" name="submit" alt="Pay!" style="width: 130px;" id="paybutton">';
    $output .= '</div>';
    
    $output .= '</form>';
    $output .= <<<EOT
<script type="text/javascript">
jQuery(document).ready(function($) {
    $('.wp_paypal_pay').submit(function(e){
        var form_obj = $(this);
        var other_amt = form_obj.find('input[name=other_amount]').val();
        if (!isNaN(other_amt) && other_amt.length > 0){
            options_val = other_amt;
            $('<input>').attr({
                type: 'hidden',
                id: 'amount',
                name: 'amount',
                value: options_val
            }).appendTo(form_obj);
        }		
        return;
    });
});
</script>
EOT;
    echo $output;
	}
	function update( $new_instance, $old_instance ) {
		
	}
	function form($instance) {
		_e("Set the Plugin Settings from the Widget menu");
	}
}

function register_Paypal_Widget() {
	register_widget( 'Paypal_Widget' );
}

add_action( 'widgets_init', 'register_Paypal_Widget' );
register_activation_hook(__FILE__, 'pay_pal_activate' );
