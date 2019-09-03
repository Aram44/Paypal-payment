<h1>Widget Options</h1>
<?php
if (isset($_POST['widget_update'])) {
    if (isset($_POST['showoption'])) {
        update_option('paypal_payment_showoption', 'true');
    }else{
        update_option('paypal_payment_showoption', 'false');
    }
    if (isset($_POST['ppother'])) {
        update_option('paypal_payment_otheramount', 'true');
    }else{
        update_option('paypal_payment_otheramount', 'false');
    }
    if (isset($_POST['pprbox'])) {
        update_option('paypal_payment_referencebox', 'true');
    }else{
        update_option('paypal_payment_referencebox', 'false');
    }
	$ppwt = $_POST['paypal_widget_titlename'];
    if (isset($_POST['paypal_referancetitle'])){
        $pprtbt = $_POST['paypal_referancetitle'];
        update_option('paypal_widget_referancetitle', $pprtbt);
    }
	$ppwi = $_POST['payment_button_type'];
	update_option('paypal_widget_titlename', $ppwt);
	update_option('paypal_widget_img', $ppwi);

    echo '<div id="message" class="updated fade" style="margin-left: 0px;"><p><strong>Widget Options Updated!</strong></p></div>';
}
?>
<div class=wrap>
<form method="post" action="">
<div class="postbox" style="margin-top: 10px;">
    <table class="form-table">
        <tr><td width="25%" align="left"  style="padding-top: 0px; padding-bottom: 0px; margin-bottom: 0px; margin-top: 0px;">
            <h3>Show Options:</h3>
            </td><td align="left">
            <input type="checkbox" name="showoption" value="showoption" 
            <?php
            if (get_option('paypal_payment_showoption')=='true'){echo "checked";} ?> />
        </td></tr>
        <tr><td width="25%" align="left"  style="padding-top: 0px; padding-bottom: 0px; margin-bottom: 0px; margin-top: 0px;">
            <h3>Show Other Amount:</h3>
            </td><td align="left">
            <input type="checkbox" name="ppother" value="otheramount" 
            <?php
            if (get_option('paypal_payment_otheramount')=='true'){echo "checked";} ?> />
        </td></tr>
        <tr><td width="25%" align="left"  style="padding-top: 0px; padding-bottom: 0px; margin-bottom: 0px; margin-top: 0px;">
            <h3>Show Reference Text Box:</h3>
            </td><td align="left">
            <input type="checkbox" name="pprbox" value="referencebox" 
            <?php
            if (get_option('paypal_payment_referencebox')=='true'){echo "checked";} ?> />
        </td></tr>
        <tr><td width="20%" align="left"  style="padding-top: 0px;">
        	<h3>Widget Title:</h3>
            </td><td align="left">
            <input name="paypal_widget_titlename" type="text" size="30" <?php 
            echo "value='".get_option('paypal_widget_titlename')."'";
            ?>/>
        </td></tr>
        <?php 
            if (get_option('paypal_payment_referencebox')=='true'){
                echo '<tr><td width="20%" align="left"  style="padding-top: 0px;">
            <h3>Reference Text Box Title:</h3>
            </td><td align="left">
            <input name="paypal_referancetitle" type="text" size="30"';
            echo "value='".get_option('paypal_widget_referancetitle')."' />";
            }
            ?>
        </td></tr>
    </table>
<h3 style="margin-left: 10px; font-size: 20px;">Button style</h3>
<table style="width:100%; border-spacing:0; padding:0; text-align:center;">
    <tr>
        <td>
    <input type="radio" name="payment_button_type" value="pay1" <?php ;if (get_option('paypal_widget_img')=='pay1'){echo "checked";} ?> />
        </td>
        <td>
    <input type="radio" name="payment_button_type" value="pay2" <?php ;if (get_option('paypal_widget_img')=='pay2'){echo "checked";} ?> />
        </td>
        <td>
    <input type="radio" name="payment_button_type" value="pay3" <?php ;if (get_option('paypal_widget_img')=='pay3'){echo "checked";} ?> />
        </td>
        <td>
    <input type="radio" name="payment_button_type" value="pay4" <?php ;if (get_option('paypal_widget_img')=='pay4'){echo "checked";} ?> />
        </td>
    </tr>
    <tr>
        <td><img src="<?php echo plugins_url();?>/Paypal-payment/img/pay1.gif" width="150" height="58" alt="" /></td>
        <td><img src="<?php echo plugins_url();?>/Paypal-payment/img/pay2.gif" width="150" height="58" alt="" /></td>
        <td><img src="<?php echo plugins_url();?>/Paypal-payment/img/pay3.gif" width="150" height="40" alt="" /></td>
        <td><img src="<?php echo plugins_url();?>/Paypal-payment/img/pay4.gif" width="150" height="40" alt="" /></td>
    </tr>
</table>
<div class="submit" style="margin-left: 10px;">
    <input type="submit" class="button-primary" name="widget_update" value="Update options" />
</div></div></form></div>