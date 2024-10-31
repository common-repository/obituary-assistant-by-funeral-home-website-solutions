<?php
/**
 * @link       https://www.floristone.com
 * @since      1.0.0
 *
 * @package    Florist_One_Flower_Delivery
 * @subpackage Florist_One_Flower_Delivery/public/partials
 */

  $add_to_cart_icon = '<svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="currentColor" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>';


  $calc_price_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calculator" viewBox="0 0 16 16">' .
                     '<path d="M12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"/>' .
                     '<path d="M4 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-2zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-4z"/>' .
                     '</svg>';

  $getTrees_img = $api_response_body['productURL'];
  $getTrees_certificate = $api_response_body['productSeeCertificate'];
  $getTrees_certificate_img = $api_response_body['productSeeCertificateImg'];
  $description_list = '<ul class="lh-base px-0 ms-3 mb-5 text-start">';


?>



<div class="row mb-5" id="fws-trees-container">
  <h3 class=""><?php echo $api_response_body['itemName']?></h3>
  <div class="col">
    <div class="d-flex flex-wrap justify-content-center">
      <div class="f1fd-product-image text-center px-4"><!--image-->
          <img width="350px" class="img-fluid mb-3" src=" <?php echo $getTrees_img ?>" />
          <a href="<?php echo $getTrees_certificate_img ?>" target="tree_cert_tab">
            <img width="350px" class="img-fluid mb-3" src="<?php echo $getTrees_certificate_img ?>" />
          </a>
          <p><?php echo $getTrees_certificate ?></p>
      </div>
      <div class="f1fd-product-discription"><!--info-->
        <?php
          $elements = get_option('fhw-solutions-elements');
          for ($copy=0;$copy < count((array)$api_response_body['productPrimaryCopy']);$copy++){
            echo '<p class="lh-sm fs-4">' . $api_response_body['productPrimaryCopy'][$copy]['heading'] . '</p>';
            echo '<p class="lh-base">';
            echo $description_list;
            if ($copy == 0){
              array_splice($api_response_body['productPrimaryCopy'][$copy]['rows'], 1, 0, array());
              $api_response_body['productPrimaryCopy'][$copy]['rows'][1]["text"] = $elements['PURCHASE_RECOGNITION']['oa-copy-product-description']['heading'];
              $api_response_body['productPrimaryCopy'][$copy]['rows'][1]["bullet"] = true;
            }

            for ($bullet=0;$bullet < count($api_response_body['productPrimaryCopy'][$copy]['rows']);$bullet++){
              echo '<li class="mb-2">' . $api_response_body['productPrimaryCopy'][$copy]['rows'][$bullet]['text'] . '</li>';
            }
            if($copy == 1 & !empty($api_response_body['productCountryPrimaryCopy'])){
              for ($bulletl=0;$bulletl < count((array)$api_response_body['productCountryPrimaryCopy'][0]['rows']);$bulletl++){
                echo '<li class="mb-2">' . $api_response_body['productCountryPrimaryCopy'][0]['rows'][$bulletl]['text'] . '</li>';
              }
            }
            echo  '</ul></p>';
          }
          ?>
        <div class="fws-add-to-cart-tree">
            <?php
              $defaultPrice = $api_response_body['price'];
              $defaultNumber = $api_response_body['minimumNumberOfTrees'];
              $quantityDisplay = $api_response_body['quantityDisplay'];
              $displayedDefaultPrice = '$' . number_format($defaultPrice, 2);
              $pricePerTree = $defaultPrice / $defaultNumber;
              $newProductHeading = 'Plant Trees';
              $currencySymbol = $api_response_body['currency_symbol'];
            ?>
            <p class="lh-sm fs-4 text-dark"><?php echo $newProductHeading; ?></p>

            <div class="input-group mb-3">
              <table class="border-0 florist-one-flower-delivery-trees-choices">
                <?php
                  for ($i=0; $i < count($quantityDisplay); $i++){
                    echo '<tr>';
                    echo '<td><input type="radio" name="number_of_trees" value="' . $quantityDisplay[$i] .'"></td>';
                    echo '<td align="center">' . $quantityDisplay[$i] . ' Tree' . ($quantityDisplay[$i] > 1 ? 's' : '') . ' </td>';
                    echo '<td>-</td>';
                    echo '<td align="center">' . $currencySymbol . number_format(($quantityDisplay[$i] * $pricePerTree), 2) . '</td>';
                    echo '</tr>';
                  }
                ?>
							</table>
            </div>
            <div id="fws-trees-calculate-msg-choose-number"></div>

           <button type="button" data-checkout="show" href="#" data-bs-toggle="modal" data-bs-target="#florist-one-flower-delivery-view-modal" class="f1fd_primary  florist-one-flower-delivery-add-to-cart btn mt-3" id="plant-a-tree-add-to-cart1" data-name="<?php echo $api_response_body['productProductHeading']['text'] ?>" data-code="<?php echo str_replace(' ', '-',$api_response_body['productProductHeading']['text']) ?>" data-price="<?php echo $api_response_body['price'] ?>" data-number="5">Add To Cart <?php echo $add_to_cart_icon; ?></button>

            <p class="lh-sm fs-4 text-dark mt-5"><?php echo $api_response_body['productSecondaryCopy'][0]['heading']; ?></p>
            <?php for ($bulletl=0;$bulletl < count((array)$api_response_body['productSecondaryCopy'][0]['rows']);$bulletl++){
                echo '<p>' . $api_response_body['productSecondaryCopy'][0]['rows'][$bulletl]['text'] . '</p>';
              } ?>
            <div class="input-group mb-3">
              <div style="width:100px">
                <input type="number" id="florist-one-flower-delivery-plant-a-tree-select-your-own" name="florist-one-flower-delivery-plant-a-tree-select-your-own" class="form-control" min="<?php echo $api_response_body['minimumNumberOfTrees'] ?>" step="1"  placeholder="Number" aria-label="Recipient's username" aria-describedby="button-addon2">
              </div>
              <button id="florist-one-flower-delivery-calcualte-price" class="f1fd_primary  florist-one-flower-delivery-plant-a-tree-select-your-own-calculate btn ms-3" type="button"><?php echo $calc_price_icon; ?> Calculate Price</button>
            </div>
            <div id="fws-trees-calculate-msg"></div>
        </div>
      </div>
    </div>
  </div>
</div>
