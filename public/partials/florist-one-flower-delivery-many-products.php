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
  $config_options = get_option('florist-one-flower-delivery');
  $total_products = $api_response_body["TOTAL"];
  $pages = ceil($total_products / $count);

  if (array_key_exists("CATEGORIES",$api_response_body['PRODUCTS'][0])){

    foreach($api_response_body['PRODUCTS'][0]['CATEGORIES'] as $x => $val) {
      if ($category == $val['CATEGORY']){
        $category_title = $val['DISPLAY'];
      }
    }
  } else {
   if ($api_response_body['CATEGORY'] == 'fbs'){
        $category_title = 'Best Sellers';
    }
  }
  if (!$loadmore){

    echo '<div class="d-flex flex-wrap justify-content-start">';
    echo '<h3 class="florist-one-flower-delivery-many-products-category">'. $category_title . '</h3>';
    echo '</div>';

    // start container
    echo '<div class="d-flex flex-wrap align-content-center fhws-gap align-content-between" id="florist-one-flower-delivery-many-products-display">';

  }

    for ($i=0;$i<count((array)$api_response_body["PRODUCTS"]);$i++) {

      echo '<div class=" d-flex flex-column position-relative justify-content-between florist-one-flower-delivery-many-products-display align-center">';

      if ($api_response_body["PRODUCTS"][$i]["CODE"] != "TREES"){
        echo '<a class="florist-one-flower-delivery-many-products-single-product p-3 text-center text-decoration-none" data-bs-toggle="modal" data-bs-target="#florist-one-flower-delivery-view-modal" href="#" id="' . $api_response_body["PRODUCTS"][$i]["CODE"] . '-1" class="florist-one-flower-delivery-many-products-single-product" data-url="' . $api_response_body["PRODUCTS"][$i]["SMALL"] . '" data-code="' . $api_response_body["PRODUCTS"][$i]["CODE"] . '">';
        echo '<img src="' . $api_response_body["PRODUCTS"][$i]["SMALL"] . '" alt="' . $api_response_body["PRODUCTS"][$i]["NAME"] . '"/>';
        echo '</a>';
        echo '<a class="florist-one-flower-delivery-many-products-single-product p-3 text-decoration-none" data-bs-toggle="modal" data-bs-target="#florist-one-flower-delivery-view-modal" href="#" id="' . $api_response_body["PRODUCTS"][$i]["CODE"] . '-1" class="florist-one-flower-delivery-many-products-single-product" data-url="' . $api_response_body["PRODUCTS"][$i]["SMALL"] . '" data-code="' . $api_response_body["PRODUCTS"][$i]["CODE"] . '">';
        echo '<p class="pt-2 text-center">' . $api_response_body["PRODUCTS"][$i]["NAME"] . '</p>';
        echo '</a>';
      }

      else {
        echo '<a class="florist-one-flower-delivery-many-products-single-product p-3 text-center text-decoration-none" id="' . $api_response_body["PRODUCTS"][$i]["CODE"] . '-1" class="florist-one-flower-delivery-many-products-single-product" data-url="' . $api_response_body["PRODUCTS"][$i]["SMALL"] . '" data-code="' . $api_response_body["PRODUCTS"][$i]["CODE"] . '">';
        echo '<img src="' . $api_response_body["PRODUCTS"][$i]["SMALL"] . '" alt="' . $api_response_body["PRODUCTS"][$i]["NAME"] . '"/>';
        echo '</a>';
        echo '<a class="florist-one-flower-delivery-many-products-single-product p-3 text-decoration-none" id="' . $api_response_body["PRODUCTS"][$i]["CODE"] . '-1" class="florist-one-flower-delivery-many-products-single-product" data-url="' . $api_response_body["PRODUCTS"][$i]["SMALL"] . '" data-code="' . $api_response_body["PRODUCTS"][$i]["CODE"] . '">';
        echo '<p class="pt-2 text-center">' . $api_response_body["PRODUCTS"][$i]["NAME"] . '</p>';
        echo '</a>';
      }

      echo '<div>';

      echo '<p class="text-muted text-center">' . "$" . number_format($api_response_body["PRODUCTS"][$i]["PRICE"], 2) . '</p>';

      // buttons (view detail, add to cart)
      echo '<div class="d-flex mb-5 mx-auto justify-content-center florist-one-flower-delivery-many-products-display-button">';

      if ($api_response_body["PRODUCTS"][$i]["CODE"] != "TREES"){

        echo '<button type="button" href="#" data-bs-toggle="modal" data-bs-target="#florist-one-flower-delivery-view-modal" class="w-100 f1fd_secondary florist-one-flower-delivery-many-products-single-product ms-1 me-1 border" data-url="'. $api_response_body["PRODUCTS"][$i]["SMALL"] . '" data-code="' . $api_response_body["PRODUCTS"][$i]["CODE"] . '">';
        echo '<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>';
        echo '</button>';

        echo '<button type="button" href="#" data-bs-toggle="modal" data-bs-target="#florist-one-flower-delivery-view-modal" class="w-100 florist-one-flower-delivery-add-to-cart ms-1 me-1 border f1fd_secondary" data-code="' . $api_response_body["PRODUCTS"][$i]["CODE"] . '">';
        echo '<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>';
        echo '</button>';

      }

      else {

        echo '<button type="button" class="w-100 f1fd_secondary florist-one-flower-delivery-many-products-single-product ms-1 me-1 border" data-url="'. $api_response_body["PRODUCTS"][$i]["SMALL"] . '" data-code="' . $api_response_body["PRODUCTS"][$i]["CODE"] . '">';
        echo '<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>';
        echo '</button>';

        echo '<button type="button" href="#" data-bs-toggle="modal" data-bs-target="#florist-one-flower-delivery-view-modal" class="w-100 florist-one-flower-delivery-add-to-cart ms-1 me-1 border f1fd_secondary" id="plant-a-tree-add-to-cart2" data-name="Plant ' . $api_response_body["PRODUCTS"][$i]["MINIMUM_TREES"] . ' Trees" data-code="Plant-' . $api_response_body["PRODUCTS"][$i]["MINIMUM_TREES"] . '-Trees" data-price="' . $api_response_body["PRODUCTS"][$i]["PRICE"] . '" data-number="' . $api_response_body["PRODUCTS"][$i]["MINIMUM_TREES"] . '">';
        echo '<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>';
        echo '</button>';

      }

      echo '</div>';

      echo '</div>';

      echo '</div>';

    }

  ?>

</div>
<!--end container -->

<?php
  $button_view = (!$loadmore && $api_response_body["TOTAL"] > $count ) ? '' : 'd-none';
?>

<div class="d-flex"><button class="mx-auto px-3 florist-one-flower-delivery-menu-link-more btn f1fd_secondary  <?php echo $button_view?>" data-items-count="<?php echo $total_products;?>" data-pages="<?php echo $pages;?>" data-current-page="2" data-count="<?php echo $count;?>" data-category="<?php echo $category;?>">See More <?php echo $category_title?> <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg></button></div>
