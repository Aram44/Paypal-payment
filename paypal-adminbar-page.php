<h1>Paypal Payment options</h1>
<?php
if (isset($_POST['payment_update'])) {
    $numofoptions = 1;
	update_option('paypal_payment_address', $_POST['paypal_payment_email']);
	update_option('paypal_payment_currencye', $_POST['payment_currency']);
	update_option('paypal_payment_subject', $_POST['payment_subject']);
	update_option('paypal_payment_option1', $_POST['payment_option1']);
	update_option('paypal_payment_value1', $_POST['payment_value1']);
    if(strlen($_POST['payment_option2'])!=0) {
       $numofoptions++;
       update_option('paypal_payment_option2', $_POST['payment_option2']);
       update_option('paypal_payment_value2', $_POST['payment_value2']);
    }
    if(strlen($_POST['payment_option3'])!=0) {
       $numofoptions++;
    update_option('paypal_payment_option3', $_POST['payment_option3']);
    update_option('paypal_payment_value3', $_POST['payment_value3']);
    }
    if(strlen($_POST['payment_option4'])!=0) {
       $numofoptions++;
    update_option('paypal_payment_option4', $_POST['payment_option4']);
    update_option('paypal_payment_value4', $_POST['payment_value4']);
    }
    if(strlen($_POST['payment_option5'])!=0) {
       $numofoptions++;
    update_option('paypal_payment_option5', $_POST['payment_option5']);
    update_option('paypal_payment_value5', $_POST['payment_value5']);
    }
    update_option('paypal_payment_numoptions', $numofoptions);
	update_option('paypal_payment_return_url', $_POST['paypal_return_url']);
	update_option('paypal_payment_cancel_url', $_POST['paypal_cancel_url']);
	echo '<div id="message" class="updated fade" style="margin-left: 0px;"><p><strong>Payment Options Updated!</strong></p></div>';
}
$wp_options = get_option('wp_pp_ref_title');
$paypal_payment_currency = get_option('paypal_payment_currencye');
?>
<div class=wrap>
<div id="poststuff"><div id="post-body">
<form method="post" action="">
    <?php wp_nonce_field('wp_accept_pp_payment_settings_update'); ?>
    <input type="hidden" name="info_update" id="info_update" value="true" />
    <div class="postbox">
        <h3 style="margin-left: 10px;"><label for="title" style="cursor: auto;">Plugin Usage</label></h3>
    <div class="inside">      
        <p>Use the <b>WP Paypal Payment</b> Widget from the Widgets menu</p>
    </div></div>
    <div class="postbox">
        <h3 style="margin-left: 10px;"><label for="title"  style="cursor: auto;">WP Paypal Payment or Donation Accept Plugin Options</label></h3>
    <div class="inside">
        <table class="form-table" id="add_newoption">
            <tr valign="top"><td width="25%" align="left">
            <strong>Paypal Email address:</strong>
            </td><td align="left">
            <input name="paypal_payment_email" type="text" size="35" value="<?php echo get_option('paypal_payment_address'); ?>"/>
            <br /><i>This is the Paypal Email address where the payments will go</i><br />
            </td></tr>
            <tr valign="top"><td width="25%" align="left">
            <strong>Choose Payment Currency: </strong>
            </td><td align="left">
        <select id="paypal_payment_currency" name="payment_currency">
    <?php _e('<option value="USD"') ?><?php if ($paypal_payment_currency === "USD") echo " selected " ?><?php _e('>US Dollar</option>') ?>
    <?php _e('<option value="GBP"') ?><?php if ($paypal_payment_currency === "GBP") echo " selected " ?><?php _e('>Pound Sterling</option>') ?>
    <?php _e('<option value="EUR"') ?><?php if ($paypal_payment_currency === "EUR") echo " selected " ?><?php _e('>Euro</option>') ?>
    <?php _e('<option value="AUD"') ?><?php if ($paypal_payment_currency === "AUD") echo " selected " ?><?php _e('>Australian Dollar</option>') ?>
    <?php _e('<option value="CAD"') ?><?php if ($paypal_payment_currency === "CAD") echo " selected " ?><?php _e('>Canadian Dollar</option>') ?>
    <?php _e('<option value="NZD"') ?><?php if ($paypal_payment_currency === "NZD") echo " selected " ?><?php _e('>New Zealand Dollar</option>') ?>
    <?php _e('<option value="HKD"') ?><?php if ($paypal_payment_currency === "HKD") echo " selected " ?><?php _e('>Hong Kong Dollar</option>') ?>
        </select>
            <br /><i>This is the currency for your visitors to make Payments or Donations in.</i><br />
            </td></tr>
        <tr valign="top"><td width="25%" align="left">
            <strong>Payment Subject:</strong>
            </td><td align="left">
            <input name="payment_subject" type="text" size="35" value="<?php echo get_option('paypal_payment_subject'); ?>"/>
            <br /><i>Enter the Product or service name or the reason for the payment here. The visitors will see this text</i><br />
        </td></tr>
        <tr valign="top">
            <td width="25%" align="left">
            <strong>Return URL from PayPal:</strong>
            </td><td align="left">
            <input name="paypal_return_url" type="text" size="60" value="<?php echo esc_url(get_option('paypal_payment_return_url')); ?>"/>
            <br /><i>Enter a return URL (could be a Thank You page). PayPal will redirect visitors to this page after Payment.</i><br />
        </td></tr>
        <tr valign="top">
            <td width="25%" align="left">
            <strong>Cancel URL from PayPal:</strong>
            </td><td align="left">
            <input name="paypal_cancel_url" type="text" size="60" value="<?php echo esc_url(get_option('paypal_payment_cancel_url')); ?>"/>
            <br /><i>Enter a cancel URL. PayPal will redirect visitors to this page if they click on the cancel link.</i><br />
        </td></tr>
        <tr valign="top"><td width="25%" align="left"><input type="button" value="Add Option" class="addoption_button"></td></td><td align="left"><i>Enter the name of the service or product and the price. eg. Enter "Basic service - $10" in the Payment Option text box and "10.00" in the price text box to accept a payment of $10 for "Basic service". Leave the Payment Option and Price fields empty if u don't want to use that option. For example, if you have 3 price options then fill in the top 3 and leave the rest empty.</i></td></tr>
        <script type="text/javascript">
        jQuery(document).ready(function($) {
        var numofoption = <?php echo (int)get_option('paypal_payment_numoptions'); ?>;
        $('.addoption_button').click(function(e){
            numofoption++;
        if (numofoption < 6){
           $('#add_newoption').append("<tr valign='top'><td width='25%' align='left'><strong>Payment Option "+numofoption+":</strong></td><td align='left'><input name='payment_option"+numofoption+"' type='text' size='25' value=''/><strong> Price : </strong><input name='payment_value"+numofoption+"' type='number' min='1' value='' /><br /></td></tr>");
    }
            });
        });
        </script>   
        <tr valign="top"><td width="25%" align="left">
            <strong>Payment Option 1:</strong>
            </td><td align="left">
            <input name="payment_option2" type="text" size="25" value="<?php echo get_option('paypal_payment_option1'); ?>"/>
                <strong>Price :</strong>
            <input name="payment_value2" type="number" min="1" value="<?php echo get_option('paypal_payment_value1'); ?>"/>
        <br /></td></tr>
        <?php
        $num_options = (int)get_option('paypal_payment_numoptions');
        for ($i=2; $i <= $num_options; $i++) {
            $payoption = get_option('paypal_payment_option'.$i);
            $payvalue = get_option('paypal_payment_value'.$i);
            echo "<tr valign='top'><td width='25%' align='left'><strong>Payment Option ".$i.":</strong></td><td align='left'><input name='payment_option".$i."' type='text' size='25' value='".$payoption."'/><strong> Price : </strong><input name='payment_value".$i."' type='number' min='1' value='".$payvalue."'/><br /></td></tr>";
        }
        ?>
    </table>
    </div></div>
    <div class="submit">
        <input type="submit" class="button-primary" name="payment_update" value="<?php _e('Update options'); ?> &raquo;" />
    </div>
    </form>
</div></div></div>