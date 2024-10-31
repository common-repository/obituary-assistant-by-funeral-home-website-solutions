<?php

/**
 * @link       https://www.floristone.com
 * @since      1.0.0
 *
 * @package    Florist_One_Flower_Delivery
 * @subpackage Florist_One_Flower_Delivery/public/partials
 */
?>

<h3 class="florist-one-flower-delivery-checkout-heading">My Cart</h3>

<?php

  $config_options = get_option('fhw-solutions-obituaries_1');


  if ($products_for_display == "" || $products_for_display == null){
    echo '<p>Your shopping cart is empty</p>';
  }
  else {
  
    if (isset($display_tree_message_seperate)){
      echo '<div class="alert alert-info mt-3 text-center" role="alert">' . $display_tree_message_seperate . '</div>';
    } ?>
    
    <div class="d-inline-flex flex-wrap pt-5 fhws-gap" style="">
      <div class="" style="flex: 1 1 350px">
        <?php include 'florist-one-flower-delivery-cart-body.php'; ?>
      </div>
    
      <div class="" style="flex: 1 0 250px">
        <!-- Total -->
        <?php include 'florist-one-flower-delivery-cart-body-price.php'; ?>
        <p><a href="#" class="florist-one-flower-delivery-checkout f1fd_primary btn btn-lg w-100" data-page="4" data-code="">Checkout <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="13 17 18 12 13 7"></polyline><polyline points="6 17 11 12 6 7"></polyline></svg></a></p>
        <p><a class="text-decoration-none btn-link text-body fw-bold florist-one-flower-delivery-menu-cart-button my-4" data-bs-dismiss="modal" data-bs-target="#florist-one-flower-delivery-view-modal"  href="#">&#8592; Continue Shopping</a></p>
      </div>
    </div>
    
<?php } ?>
