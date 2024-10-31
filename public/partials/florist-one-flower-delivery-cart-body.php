<?php

/**
 * @link       https://www.floristone.com
 * @since      1.0.0
 *
 * @package    Florist_One_Flower_Delivery
 * @subpackage Florist_One_Flower_Delivery/public/partials
 */
?>

<ul class="list-group list-group-lg mb-4 ms-0">

  <?php for($i=0;$i<count($products_for_display);$i++){

  $checkout_code =  $products_for_display[$i]["CODE"];
  if ($checkout_code == 'TREES'){
    $checkout_name = $products_for_display[$i]["DESCRIPTION"];
  }
  else {
    $checkout_name = $products_for_display[$i]["NAME"];
  }
  $checkout_price = $products_for_display[$i]["PRICE"];
  $currency_symbol = '$';
  if (isset($products_for_display[$i]["CURRENCY_SYMBOL"])){
    $currency_symbol = $products_for_display[$i]["CURRENCY_SYMBOL"];
  }
  $makeModal = (isset($product_modal)) ? ($product_modal == 1) ? 'data-bs-toggle="modal" data-bs-target="#florist-one-flower-delivery-view-modal"' : "" : "";
  ?>

    <li class="list-group-item border-start-0 border-end-0">
      <div class="row align-items-center">
        <div class="col-4 py-2">
          <!-- Image -->
          <a  data-code="<?php echo $checkout_code;?>" <?php echo $makeModal;?> class="florist-one-flower-delivery-many-products-single-product" href="#">
            <img src="<?php echo $products_for_display[$i]["IMG"]?>" alt="..." class="img-fluid">
          </a>
        </div>
        <div class="col ms-3 ">
          <!-- Title -->
          <div class="d-flex mb-2 mt-2 fw-bold lh-sm">
            <a href="#" <?php echo $makeModal;?> data-code="<?php echo $checkout_code;?>" class="text-decoration-none text-body florist-one-flower-delivery-many-products-single-product"><?php echo $checkout_name;?></a>
            <?php if (!isset($hide_price)){ ?>
            <span class="ms-auto"><?php echo $currency_symbol . $checkout_price?></span>
            <?php } ?>
          </div>
          <!-- Text -->
          <p class="mb-4 font-size-sm text-muted">Item: <?php echo $checkout_code;?></p>
          <?php if ($dont_show_remove_button != 1) { ?>
          <!--Footer -->
            <div class="d-flex align-items-center">
              <!-- Remove -->
                <a href="#" style="color:#909090!important;"  class="florist-one-flower-delivery-cart-remove-item font-size-xs text-dark text-decoration-none w-lighter ms-auto" id="florist-one-flower-delivery-cart-remove-item-<?php echo $checkout_code;?>" data-code="<?php echo $checkout_code;?>"> <small>x Remove</small></a>
            </div>
          <?php } ?>
        </div>
      </div>
    </li>
  <?php } ?>
</ul>
