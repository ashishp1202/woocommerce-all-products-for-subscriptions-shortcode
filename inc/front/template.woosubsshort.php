<?php session_start();
if(isset(WC()->cart) && WC()->cart->get_cart_contents_count() == 0){
    $_SESSION['enable_subscription'] = '';
}else{?>
<input type="checkbox" value="enable" id="enable_subscription" <?php if(!empty($_SESSION['enable_subscription'])) echo "checked";?>>Make cart product as subscription
<?php } ?>