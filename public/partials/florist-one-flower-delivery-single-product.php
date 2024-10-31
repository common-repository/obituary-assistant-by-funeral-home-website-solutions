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

$item_ammount =  '<select class="form-select w-25 d-inline" id="fws-add-to-cart-amount"><option value="1" selected="">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select>';
$single_prodcut_buttton_icon = '<svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="#000000" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>';
$single_product_button ='<div class="mb-5 d-flex">' . $item_ammount . '<button type="button" href="#" data-checkout="show" class="f1fd_primary florist-one-flower-delivery-add-to-cart btn btn-md florist-one-flower-delivery-button" id="florist-one-flower-delivery-add-to-cart-' . $api_response_body["PRODUCTS"][0]["CODE"] . '-1" data-code="' . $api_response_body["PRODUCTS"][0]["CODE"] . '">Add To Cart ' . $single_prodcut_buttton_icon . '</button></div>';
$single_product_button_2 ='<div class="mt-5"><button type="button" data-checkout="show" href="#" class="f1fd_primary florist-one-flower-delivery-add-to-cart btn btn-md florist-one-flower-delivery-button" id="florist-one-flower-delivery-add-to-cart-' . $api_response_body["PRODUCTS"][0]["CODE"] . '-2" data-code="' . $api_response_body["PRODUCTS"][0]["CODE"] . '">Add To Cart</button></div>';
$single_product_name = '<h3>' . $api_response_body["PRODUCTS"][0]["NAME"] . '</h3>';  

?>
<div class="d-flex flex-wrap center fws-add-to-cart mt-3">
  <div style="flex:1 0 300px"><!--image-->
      <img class="img-fluid p-4 mb-3" src=" <?php echo $api_response_body['PRODUCTS'][0]['LARGE'] ?>" />
  </div>
  <div class="align-left" style="flex:1 0 300px"><!--info-->
    <div class="pt-3">
      <?php 
        //echo $single_product_button; 
        echo $single_product_name; 
      ?>
    </div>
    <p class="lh-base text-muted"><?php echo $api_response_body["PRODUCTS"][0]["DESCRIPTION"] ?></p>
    <p class="text-muted">$<?php echo $api_response_body["PRODUCTS"][0]["PRICE"] ?></p>

    <?php echo $single_product_button;?>
  </div> 
</div>



