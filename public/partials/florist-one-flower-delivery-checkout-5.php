<?php
/**
 * @link       https://www.floristone.com
 * @since      1.0.0
 *
 * @package    Florist_One_Flower_Delivery
 * @subpackage Florist_One_Flower_Delivery/public/partials
 */
?>

<h3>Thank You for Your Order</h3>

<p style="font-size: 24px; margin-top: 40px; margin-bottom: 80px;">Your order number is <?php echo $orderno ?></p>

<?php

  $dont_show_remove_button = 1;
  $product_modal = 0;
  $hide_price = true;
  include 'florist-one-flower-delivery-cart-body.php';
  clearCart();
?>

<script>
  jQuery(document).ready(function() {
  var uri = window.location.toString();
    if (uri.indexOf("?") > 0) {
        var clean_uri = uri.substring(0, uri.indexOf("?"));
        window.history.replaceState({}, document.title, clean_uri);
    }
  });
</script>
