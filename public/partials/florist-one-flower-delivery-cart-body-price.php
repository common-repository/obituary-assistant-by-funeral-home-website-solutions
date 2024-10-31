<?php

/**
 * @link       https://www.floristone.com
 * @since      1.0.0
 *
 * @package    Florist_One_Flower_Delivery
 * @subpackage Florist_One_Flower_Delivery/public/partials
 */
?>

<?php
  if (!isset($currency_symbol)){
    $currency_symbol = '$';
  }

?>

<div class="card mb-4 bg-light border-0">
  <div class="card-body py-0">
    <ul class="list-group  list-group-flush ms-0">
      <li class="list-group-item bg-light d-flex py-4 px-0">
        <small>Subtotal</small><small class="ms-auto"><?php echo $currency_symbol . number_format($get_total_response_body['SUBTOTAL'], 2) ?></small>
      </li>
      <?php
        if ($get_total_response_body['FLORISTONESERVICECHARGE'] > 0){
          echo '<li class="list-group-item bg-light d-flex py-4 px-0">' .
          '<small>Service Charge</small><small class="ms-auto">' . $currency_symbol . number_format($get_total_response_body["FLORISTONESERVICECHARGE"], 2) . '</small>' .
          '</li>';
        }
        if ($get_total_response_body['TAXTOTAL'] > 0){
          echo '<li class="list-group-item bg-light d-flex py-4 px-0">' .
          '<small>Sales Tax</small><small class="ms-auto">' . $currency_symbol . number_format($get_total_response_body["TAXTOTAL"], 2) . '</small>' .
          '</li>';
        }
      ?>
      <li class="list-group-item bg-light d-flex py-4 px-0 fw-bold fs-6">
        <span>Total</span><span class="ms-auto"><?php echo $currency_symbol . number_format($get_total_response_body['ORDERTOTAL'], 2) ?></span>
      </li>
    </ul>
  </div>
</div>

<?php
  echo '<input type="hidden" id="florist-one-flower-delivery-payment-order-total" class="florist-one-flower-delivery-payment-order-total" value="'. number_format($get_total_response_body['ORDERTOTAL'], 2) . '"/>';
?>
