<?php
/**
 * @link       https://www.floristone.com
 * @since      1.0.0
 *
 * @package    Florist_One_Flower_Delivery
 * @subpackage Florist_One_Flower_Delivery/public/partials
 */
?>


<p class="florist-one-flower-delivery-review-error-message" style="display: none; color: red; text-align: center;">Please correct the fields in red below and then click on 'Process Order'.</p>

<h3>Checkout</h3>

<!--
<?php if (!is_writable(session_save_path())) {
    echo 'Session path "'.session_save_path().'" is not writable for PHP!';
} else {

	echo 'okay';
} ?>
-->

<?php

$dont_show_remove_button=1;
$config_options = get_option('fhw-solutions-obituaries_3');

// include proper authorize net accept.js script
if (isSecure()) {
  $credentials = getCredentials();
  echo '<script type="text/javascript" src="' . $credentials['AUTHORIZENET_URL'] . '" charset="utf-8"></script>';
}

function selectOptions($label, $delivery_dates, $id, $section ){

    switch ($label) {
      case "State*":
        if($section == "Bill To"){
          if(isset($_SESSION['florist-one-flower-delivery-customer-country'])){
            if($_SESSION['florist-one-flower-delivery-customer-country']=='US' || $_SESSION['florist-one-flower-delivery-customer-country']=='CA'){
              echo "<option value=''>&#8212; Select &#8212;</option>";
            } else {
              echo "<option value=''>&#8212; Not Required &#8212;</option>";
            }
          } else {
            echo "<option value=''>&#8212; Select &#8212;</option>";
          }
        } else {
          echo "<option value=''>&#8212; Select &#8212;</option>";
        }
        if($section == "Deliver To"){
          include 'recipient-state-list.php';
        } else {
          include 'customer-state-list.php';
        }
        break;
      case "Country*":
        echo "<option value=''>&#8212; Select &#8212;</option>";
        /*echo "<option value='US'" . ($_SESSION[$id]=='US'? 'selected="selected"' : '' ) . ">United States</option>";
        echo "<option value='CA'" .($_SESSION[$id]=='CA'? 'selected="selected"' : '' ) . ">Canada</option>";*/
        if($section == "Bill To"){
          include 'customer-country-list.php';
        } else {
          echo "<option value='US'" . ($_SESSION[$id]=='US'? 'selected="selected"' : '' ) . ">United States</option>";
          echo "<option value='CA'" .($_SESSION[$id]=='CA'? 'selected="selected"' : '' ) . ">Canada</option>";
        }
        break;
      case "Delivery Date":
        for($i=0;$i<count((array)$delivery_dates['DATES']);$i++){
          if ($delivery_dates['DATES'][$i] == $_SESSION["florist-one-flower-delivery-delivery-date"]){
            echo '<option value="'.$delivery_dates['DATES'][$i].'" selected="selected">'.$delivery_dates['DATES'][$i].' - '.date("l", mktime(0, 0, 0, substr($delivery_dates['DATES'][$i],0,2), substr($delivery_dates['DATES'][$i],3,2), substr($delivery_dates['DATES'][$i],6,4))) .'</option>';
          }
          else{
            echo '<option value="'.$delivery_dates['DATES'][$i].'">'.$delivery_dates['DATES'][$i].' - '.date("l", mktime(0, 0, 0, substr($delivery_dates['DATES'][$i],0,2), substr($delivery_dates['DATES'][$i],3,2), substr($delivery_dates['DATES'][$i],6,4))) .'</option>';
          }
        }
        break;
      case "Expiration Month":
        for($i=1;$i<13;$i++){
            echo '<option value="'.str_pad($i, 2, '0', STR_PAD_LEFT).'">'.str_pad($i, 2, '0', STR_PAD_LEFT).'</option>';
        }
        break;
      case "Expiration Year":
        $year = date("Y");
        for($i=0;$i<15;$i++){
            echo '<option value="'.$year.'">'.$year.'</option>';
            $year++;
        }
        break;
      default:
        echo "no input";
    }
};
?>

<?php function fws_create_input($size, $type, $label, $comment, $section, $delivery_dates, $value){ ?>

  <div class="<?php echo $size;?>">

    <?php

      switch ($label) {
        case "Delivery Date":
          $input_label = "Orders placed now can be delivered on:";
          break;
        case "Card Message":
          $input_label = "Gift Card Message*";
          break;
        case "Special Instructions":
          $input_label = "Special Delivery Instructions";
          break;
        case "State*":
          if($section == "Bill To"){
            if (isset($_SESSION['florist-one-flower-delivery-customer-country'])){
              switch ($_SESSION['florist-one-flower-delivery-customer-country']) {
                case "CA":
                  $input_label = "Province*";
                  break;
                case "US":
                  $input_label = "State*";
                  break;
                default:
                  $input_label = "State";
              }
            } else {
              $input_label = "State*";
            }
          } else if ($section == "Deliver To") {
            if (isset($_SESSION['florist-one-flower-delivery-recipient-country'])){
              switch ($_SESSION['florist-one-flower-delivery-recipient-country']) {
                case "CA":
                  $input_label = "Province*";
                  break;
                case "US":
                  $input_label = "State*";
                  break;
                default:
                  $input_label = "State*";
              }
            } else {
              $input_label = "State*";
            }

          } else {
            $input_label = $label;
          }
          break;
        case "Postal Code*":
          if($section == "Bill To"){
            if (isset($_SESSION['florist-one-flower-delivery-customer-country'])){
              switch ($_SESSION['florist-one-flower-delivery-customer-country']) {
                case "CA":
                  $input_label = "Postal Code*";
                  break;
                case "US":
                  $input_label = "Zip Code*";
                  break;
                default:
                  $input_label = "Postal Code";
              }
            } else {
              $input_label = "Zip Code*";
            }
          } else if ($section == "Deliver To") {
            if (isset($_SESSION['florist-one-flower-delivery-recipient-country'])){
              switch ($_SESSION['florist-one-flower-delivery-recipient-country']) {
                case "CA":
                  $input_label = "Postal Code*";
                  break;
                case "US":
                  $input_label = "Zip Code*";
                  break;
                default:
                  $input_label = "Postal Code*";
              }
            } else {
              $input_label = "Postal Code";
            }
          } else {
            $input_label = "Postal Code*";
          }
          break;
        default:
         $input_label = $label;
      }

      //generate name and ID
      switch ($section) {
        case "Delivery Date":
          $id_suffix = "-" . strtolower(preg_replace('/[\*]+/', '', preg_replace("/[\s_]/", "-", $label)));
          break;
        case "Loved One":
          $id_suffix = "-tree-certificate-" . strtolower(preg_replace('/[\*]+/', '', preg_replace("/[\s_]/", "-", $label)));
          break;
        case "Sender Display":
          $id_suffix = "-tree-certificate-" . strtolower(preg_replace('/[\*]+/', '', preg_replace("/[\s_]/", "-", $label)));
          break;

        case "Deliver Info Tree":
          $id_suffix = "-tree-certificate-email-behalf-" . strtolower(preg_replace('/[\*]+/', '', preg_replace("/[\s_]/", "-", $label)));
          break;
        case "Delivery Info":
          $id_suffix = "-special-" . strtolower(preg_replace('/[\*]+/', '', preg_replace("/[\s_]/", "-", $label)));
          break;
        case "Deliver To":
           $id_suffix = "-recipient-" . strtolower(preg_replace('/[\*]+/', '', preg_replace("/[\s_]/", "-", $label)));
          break;
        case "Bill To":
          $id_suffix = "-customer-" . strtolower(preg_replace('/[\*]+/', '', preg_replace("/[\s_]/", "-", $label)));
          break;
        case "Payment":
          $id_suffix = "-payment-" . strtolower(preg_replace('/[\*]+/', '', preg_replace("/[\s_]/", "-", $label)));
          break;
        case "Product":
          $id_suffix = "-product-" . strtolower(preg_replace('/[\*]+/', '', preg_replace("/[\s_]/", "-", $label)));
          break;
      }

      $fws_id = "florist-one-flower-delivery" . $id_suffix;

      if ($type != 'hidden'){
        echo '<label for="' . $fws_id . '" class="form-label">' . $input_label . '</label>';
      }

      switch ($type) {
        case "input":
          if ($label == "Postal Code*" && $section == "Bill To"){
            if (isset($_SESSION['florist-one-flower-delivery-customer-country'])){
              if($_SESSION['florist-one-flower-delivery-customer-country'] == "CA" || $_SESSION['florist-one-flower-delivery-customer-country'] == "US" ){
                echo '<input type="text" class="form-control p-3" name="' . $fws_id . '" id="' . $fws_id . '" placeholder="' . ($_SESSION['florist-one-flower-delivery-customer-country'] == "US"? "Zip Code*" : "Postal Code*") .'" value="' .  $_SESSION[$fws_id] . '">';
              } else {
                echo '<input type="text" class="form-control p-3" name="' . $fws_id . '" id="' . $fws_id . '" placeholder="Postal Code" value="' .  $_SESSION[$fws_id] . '">';
              }
            } else {
              echo '<input type="text" class="form-control p-3" name="' . $fws_id . '" id="' . $fws_id . '" placeholder="Zip Code*" value="' .  $_SESSION[$fws_id] . '">';
            }
          } else {
            echo '<input type="text" class="form-control p-3" name="' . $fws_id . '" id="' . $fws_id . '" placeholder="' . $label .'" value="' .  esc_html($_SESSION[$fws_id]) . '"' . ($section == "Deliver To" || $section == "Deliver Info Tree" ? 'autocomplete="no-fill"' : '') . '>';
          }
        break;
        case "select":
          if ($label == "State*" && $section == "Bill To") {
            if (isset($_SESSION['florist-one-flower-delivery-customer-country'])){
              if($_SESSION['florist-one-flower-delivery-customer-country'] == "CA" || $_SESSION['florist-one-flower-delivery-customer-country'] == "US" ){
                echo '<select class="form-select form-control p-3" name="' . $fws_id . '" id="' . $fws_id . '" aria-label="Select">';
              } else {
                echo '<select class="form-select form-control p-3" name="' . $fws_id . '" id="' . $fws_id . '" aria-label="Select" disabled>';
              }
            } else {
              echo '<select class="form-select form-control p-3" name="' . $fws_id . '" id="' . $fws_id . '" aria-label="Select">';
            }
          } else {
            echo '<select class="form-select form-control p-3" name="' . $fws_id . '" id="' . $fws_id . '" aria-label="Select"' . ($section == "Deliver To" || $section == "Deliver Info Tree" ? 'autocomplete="no-fill"' : '') . '>';
          }
          selectOptions($label, $delivery_dates, $fws_id, $section);
          echo '</select>';
          break;
        case "textarea":
          echo '<textarea class="form-control" style="height:100px" name="' . $fws_id . '"id="' . $fws_id . '" placeholder="' . $label .'" rows="3"  placeholder="' . $label . '">' .  $_SESSION[$fws_id] .'</textarea>';
          break;
        case "hidden":
          echo '<input type="hidden" name="' . $fws_id . '" id="' . $fws_id . '" value="' . $value . '" />';
          break;
        default:
          echo "no input";
      } ?>

      <?php if ($comment != null) {
        echo "<small class='fw-light'><p class='lh-sm'>" . $comment . "</p></small>";
      }


    ?>
  </div>

<?php } ?>

<?php $purchaseRecognition = '<div class="col-12 bg-light py-2"><div class="form-check">
                <input type="checkbox" class="form-check-input" name="florist-one-flower-delivery-purchase-recognition-check" id="florist-one-flower-delivery-purchase-recognition-check"  ' .   ($_SESSION["florist-one-flower-delivery-purchase-recognition-check"] === "on" ? "checked": "") . '>
                <label class="ms-2 form-check-label" id="florist-one-flower-delivery-purchase-recognition-label" for="florist-one-flower-delivery-purchase-recognition-check">Option 1</label>
              </div></div>'; ?>

<?php $allowSubstitutions = '<div class="col-12 bg-light py-2"><div class="form-check">
                <input type="checkbox" class="form-check-input" name="florist-one-flower-delivery-allow-substitutions-check" id="florist-one-flower-delivery-allow-substitutions-check"  ' .   ($_SESSION["florist-one-flower-delivery-allow-substitutions-check"] === "on" ? "checked": "") . '>
                <label class="ms-2 form-check-label" id="florist-one-flower-delivery-allow-substitutions-label" for="florist-one-flower-delivery-allow-substitutions-check">
                <strong>Allow Substitutions</strong><br/>All flowers, plants, or containers may not always be available. By checking this box, you give us permission to make reasonable substitutions to ensure we deliver your order in a timely manner. Substitutions will not affect the value or quality of your order.</label>
              </div></div>'; ?>

<div class="clearfix"></div>
<div class="row mt-5">
  <div class="col-12 col-md-7">
  <?php if($products_for_display != "" || $products_for_display != null  ) { ?>
      <!-- Form -->
      <form class="checkout-form">

        <?php  if ($products_for_display[0]['CODE'] == "TREES") { ?>
           <p class="mb-2 fw-bolder fs-5">Delivery Information</p>
           <div class="row mb-5 g-4">
             <?php
                //fws_create_row("Name of Loved One*","The name of your loved one that has passsed. This name will be used in the tree certificate.");
                 fws_create_input("col-12", "input", "Name of Loved One*", "The name of your loved one that has passsed. This name will be used in the tree certificate.", "Loved One", null, null);
                 fws_create_input("col-12", "input", "Sender Display Name*", "Who the trees are 'from'. This will be used in the tree certificate.", "Sender Display", null, null);
                 if($obituary == 1){ echo $purchaseRecognition; }

             ?>
            </div>
            <p class="my-3 fw-bolder">Select Delivery Method*</p>
            <div id="florist-one-flower-delivery-tree-certificate-info" class="row mb-4">
                <div class="col-12">
                  <div class="form-check">
                    <div style="width:1.5em">
                      <input class="form-check-input" <?php echo ($_SESSION["florist-one-flower-delivery-tree-certificate"] =='Cert-they-email')? 'checked' : ''; ?> type="radio" name="florist-one-flower-delivery-tree-certificate" id="florist-one-flower-delivery-tree-certificate-they-email" value="Cert-they-email">
                    </div>
                    <label class="form-check-label fw-bold ps-2" for="florist-one-flower-delivery-tree-certificate-they-email">
                       I will email the Tree Certificate to the family
                    </label>
                  </div>
                </div>
                <div class="col-12 ps-sm-5">
                  <ul class="mt-2 fw-light lh-sm ms-0">
                    <li>We will email you a digital copy of Tree Certificate when you have completed checkout.</li>
                    <li>Choosing this option means you will email the certificate to the family of the deceased.</li>
                  </ul>
                </div>
              </div>
            <div class="row mt-3">
                <div class="col-12">
                  <div class="form-check">
                  <div style="width:1.5em">
                    <input class="form-check-input" <?php echo ($_SESSION["florist-one-flower-delivery-tree-certificate"] =='Cert-email-behalf')? 'checked' : ''; ?> type="radio" name="florist-one-flower-delivery-tree-certificate" id="florist-one-flower-delivery-tree-certificate-email-behalf" value="Cert-email-behalf">
                  </div>
                    <label class="form-check-label fw-bold ps-2" for="florist-one-flower-delivery-tree-certificate-email-behalf">
                      Email the Tree Certificate on my behalf
                    </label>
                  </div>
                </div>
                <div class="col-12 ps-sm-5">
                  <ul class="mt-2 fw-light lh-sm ms-0">
                    <li>Choosing this option means you will email the certificate to the family of the deceased.</li>
                    <li>We will also email you the certificate (with the email address you provide on the next page)</li>
                    <li>You can optionally add a message to the family below.</li>
                  </ul>
                </div>
              </div>
            <div class="row mb-5 ps-3 ps-sm-5 g-4 pb-3">

              <?php
              fws_create_input("col-12", "input", "Recipient Name*", null , "Deliver Info Tree", null, null);
              fws_create_input("col-12", "input", "Recipient Email*", "The name and email of the person or family receiving the tree gift and certificate.", "Deliver Info Tree", null, null);
              fws_create_input("col-12", "textarea", "Message to Recipient", "Optional: (500 characters max)", "Deliver Info Tree", null, null);
              ?>

            </div>

            <?php
              $internationalTree = false;
              if (get_option('fhw-solutions-obituaries_1')['funeral_home_country'] != 'CA' && get_option('fhw-solutions-obituaries_1')['funeral_home_country'] != 'US') {
                $internationalTree = true;
                echo '<input name="international_tree" id="international_tree" type="hidden" value="1">';
              }
            ?>

         <?php } else { ?>


          <!-- Billing details -->
          <div class="row mb-5 g-4">

            <!-- Heading -->
            <p class="mb-1 fw-bolder fs-5">Delivery Information</p>

            <?php

              fws_create_input("col-12", "select", "Delivery Date", null, "Delivery Date", $delivery_dates, null);
              fws_create_input("col-12", "textarea", "Card Message", "(200 characters max) Please remember to include who the flowers are from in your message.", "Delivery Info", null, null);
              if($obituary == 1){ echo $purchaseRecognition; }
              fws_create_input("col-12", "textarea", "Special Instructions", "Optional: (100 characters max)" , "Delivery Info", null, null);

            ?>

          </div>


          <!-- Billing details -->
          <div class="row mb-5 g-4 ">

            <p class="mb-1 fw-bolder fs-5">Deliver To</p>

            <?php
              fws_create_input("col-12", "input", "Name*", null, "Deliver To", null, null);
              fws_create_input("col-12", "input", "Institution", null, "Deliver To", null, null);
              fws_create_input("col-12", "input", "Address 1*", null, "Deliver To", null, null);
              fws_create_input("col-12", "input", "Address 2", null, "Deliver To", null, null);
              fws_create_input("col-12", "input", "City*", null, "Deliver To", null, null);
              fws_create_input("col-sm-6", "select", "Country*", null, "Deliver To", null, null);
              fws_create_input("col-sm-6", "select", "State*", null, "Deliver To", null, null);
              fws_create_input("col-sm-6", "input", "Postal Code*", null, "Deliver To", null, null);
              fws_create_input("col-sm-6", "input", "Phone*", null, "Deliver To", null, null);
            ?>

          </div>

        <?php } ?>

        <!-- Billing details -->
        <div class="row mb-5 g-4 ">

        <!-- Heading -->
        <p class="mb-1 fw-bolder fs-5">Bill To</p>

          <?php
            fws_create_input("col-12", "input", "Name*", null, "Bill To", null, null);
            fws_create_input("col-12", "input", "Email*", null, "Bill To", null, null);
            fws_create_input("col-12", "input", "Address 1*", null, "Bill To", null, null);
            fws_create_input("col-12", "input", "Address 2", null, "Bill To", null, null);
            fws_create_input("col-12", "input", "City*", null, "Bill To", null, null);
            fws_create_input("col-sm-6", "select", "Country*", null, "Bill To", null, null);
            fws_create_input("col-sm-6 country-trigger", "select", "State*", null, "Bill To", null, null);
            fws_create_input("col-sm-6 country-trigger", "input", "Postal Code*", null, "Bill To", null, null);
            fws_create_input("col-sm-6", "input", "Phone*", null, "Bill To", null, null);
          ?>

        </div>

        <?php

          if (isSecure() && !$internationalTree) {

            echo '<!-- Payment details -->';
            echo '<div class="row mb-5 g-4">';

            echo '<p class="mb-1 fw-bolder fs-5">Payment</p>';

            fws_create_input("col-sm-6", "input", "Credit Card Number", null, "Payment", null, null);
            fws_create_input("col-sm-6", "input", "Security Code", null, "Payment", null, null);
            fws_create_input("col-sm-6", "select", "Expiration Month", null, "Payment", null, null);
            fws_create_input("col-sm-6", "select", "Expiration Year", null, "Payment", null, null);

            fws_create_input("col-12", "hidden", "Username", null, "Payment", null, $credentials["USERNAME"]);
            fws_create_input("col-12", "hidden", "Client Key", null, "Payment", null, $credentials["AUTHORIZENET_KEY"]);

            fws_create_input("col-12", "hidden", "Token", null, "Payment", null, null);

            echo '</div>';

          }

          else {

            echo '<input id="checkout-form-continue-next-step" name="checkout-form-continue-next-step" type="hidden" value="2">';

          }

        ?>



      </form>
      <?php

        if ($products_for_display[0]['CODE'] != "TREES"){
          echo $allowSubstitutions;
          fws_create_input("col-12", "hidden", "Product Type", null, "Product", null, 'FLOWERS');
        }
        else {
          fws_create_input("col-12", "hidden", "Product Type", null, "Product", null, 'TREES');
        }

        echo "<p>&nbsp;</p>";

        if (isSecure()) {
          echo '<button type="button" class="w-100 text-wrap btn btn-lg f1fd_primary checkout-form-continue-next-step"><svg viewBox="0 0 24 24" width="24" height="24" stroke="#ffffff" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg> Place Order</button>';
        }
        else {
          echo '<button type="button" class="w-100 text-wrap btn btn-lg f1fd_primary checkout-form-continue-next-step"><svg viewBox="0 0 24 24" width="24" height="24" stroke="#ffffff" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg> Continue to Payment</button>';
        }

      } else {
        echo '<p>Your shopping cart is empty</p>';
      }

    ?>

  </div>

  <?php if($products_for_display !="" || $products_for_display != null){ ?>
  	<div class="col-12 col-md-5 col-lg-4 offset-lg-1">
     <p class="mb-4 fw-bolder fs-5">Order Items (<?php echo count((array)$products_for_display) ?>)</p>
     <?php $product_modal = 1 ?>
     <?php include 'florist-one-flower-delivery-cart-body.php'; ?>
     <p class="my-4">
      <a class="text-decoration-none btn-link text-body fw-bold florist-one-flower-delivery-menu-cart-button" id="fws-update-my-cart" data-bs-toggle="modal" data-bs-target="#florist-one-flower-delivery-view-modal"  href="#">&#8592; Update My Cart</a>
     </p>
     <?php include 'florist-one-flower-delivery-cart-body-price.php'; ?>

    <?php

      if(count($products_for_display) > 0){

        if($validated){
          $config_options = get_option('fhw-solutions-obituaries_1');

          $amount = number_format($get_total_response_body['ORDERTOTAL'], 2);
          $redirect_url = $_SERVER['HTTP_REFERER'];
          $treeDeliveryMethod = $_SESSION['florist-one-flower-delivery-tree-certificate'];

          $products = array();

          $purchase_recognition = array(
            'obit_id' => $_SESSION['florist-one-flower-delivery-obit-id'],
            'celebration_type' => "PURCHASE_RECOGNITION",
            'order_id' => null,
            'email' => $_SESSION['florist-one-flower-delivery-customer-email'],
            'order_type' => ($products_for_display[0]['CODE'] == "TREES")? "T" : "F"
          );

          // check for trees
          if ($products_for_display[0]['CODE'] == "TREES"){ // just for trees

            $payload = createCheckoutPayload($obituary, false, null, null);

          }

          else { // all but trees

             $customer = array(
              'name' => $_SESSION["florist-one-flower-delivery-customer-name"],
              'address1' => $_SESSION["florist-one-flower-delivery-customer-address-1"],
              'address2' => $_SESSION["florist-one-flower-delivery-customer-address-2"],
              'city' => $_SESSION["florist-one-flower-delivery-customer-city"],
              'state' => ($_SESSION['florist-one-flower-delivery-customer-country'] == "CA" || $_SESSION['florist-one-flower-delivery-customer-country'] == "US") ? $_SESSION["florist-one-flower-delivery-customer-state"] : "NA",
              'zipcode' => ($_SESSION['florist-one-flower-delivery-customer-country'] == "CA" || $_SESSION['florist-one-flower-delivery-customer-country'] == "US")? $_SESSION["florist-one-flower-delivery-customer-postal-code"] : ($_SESSION["florist-one-flower-delivery-customer-postal-code"] != "" ? $_SESSION["florist-one-flower-delivery-customer-postal-code"] : 1),
              'country' => $_SESSION["florist-one-flower-delivery-customer-country"],
              'email' => $_SESSION["florist-one-flower-delivery-customer-email"],
              'phone' =>  preg_replace('~\D~', '', $_SESSION["florist-one-flower-delivery-customer-phone"]),
              'ip' => $_SERVER['REMOTE_ADDR']
            );

            $recipient = array(
              'name' => $_SESSION["florist-one-flower-delivery-recipient-name"],
              'institution' => $_SESSION['florist-one-flower-delivery-recipient-institution'],
              'address1' => $_SESSION["florist-one-flower-delivery-recipient-address-1"],
              'address2' => $_SESSION["florist-one-flower-delivery-recipient-address-2"],
              'city' => $_SESSION["florist-one-flower-delivery-recipient-city"],
              'state' => $_SESSION["florist-one-flower-delivery-recipient-state"],
              'zipcode' => $_SESSION["florist-one-flower-delivery-recipient-postal-code"],
              'country' => $_SESSION["florist-one-flower-delivery-recipient-country"],
              'phone' => preg_replace('~\D~', '', $_SESSION["florist-one-flower-delivery-recipient-phone"])
            );

            if ($_SESSION['florist-one-flower-delivery-purchase-recognition-check'] == "on"){
              $purchase_recognition['sender'] = $_SESSION["florist-one-flower-delivery-customer-name"];
              $purchase_recognition['message'] = $_SESSION["florist-one-flower-delivery-special-card-message"];
            }

            $purchase_recognition['product_name'] = $products_for_display[0]['NAME'];
            $purchase_recognition['product_image_url'] = $products_for_display[0]['IMG'];

            for ($i=0;$i<count($products_for_display);$i++){
              array_push(
                $products,
                array(
                  'code' => $products_for_display[$i]['CODE'],
                  'price' => $products_for_display[$i]['PRICE'],
                  'recipient' => $recipient,
                  'deliverydate' => $_SESSION["florist-one-flower-delivery-delivery-date"],
                  'cardmessage' => $_SESSION["florist-one-flower-delivery-special-card-message"],
                  'specialinstructions' => $_SESSION["florist-one-flower-delivery-special-special-instructions"]
                )
              );
            }

            $payload = array(
              'customer' => $customer,
              'products' => $products,
              'facilityid' => $_SESSION["florist-one-flower-delivery-facility-id"],
              'f1_aff_id' => $config_options["affiliate_id"],
              'f1_storefront_id' => (isset($config_options["flower_storefront_id"]) ? $config_options["flower_storefront_id"] : 0),
              'apikey' => OBITUARY_ASSISTANT_USERNAME,
              'allowsubstitutions' => isset($_SESSION["florist-one-flower-delivery-allow-substitutions-check"]) && $_SESSION["florist-one-flower-delivery-allow-substitutions-check"] == 'on' ? 1 : 0
            );

            //checking if from an obit
            if ($obituary == 1){
              $payload["purchase_recognition"] = $purchase_recognition;
            }

          }
          $fingerprint = createHostedForm($amount, $redirect_url, $payload, "authorizenet");
          $showToken = $fingerprint['body']['token'];

        } else {
          $showToken = "";
        }

        if (isSecure()) {
          echo '<button type="button" class="w-100 text-wrap btn btn-lg f1fd_primary checkout-form-continue-next-step"><svg viewBox="0 0 24 24" width="24" height="24" stroke="#ffffff" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg> Place Order</button>';
        }
        else {
          echo '<button type="button" class="w-100 text-wrap btn btn-lg f1fd_primary checkout-form-continue-next-step"><svg viewBox="0 0 24 24" width="24" height="24" stroke="#ffffff" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg> Continue to Payment</button>';
          ?>
            <form class="mt-5" method="post" action="https://accept.authorize.net/payment/payment">
              <input type="hidden" name="token" value="<?php echo $showToken ?>" />
              <div class="d-grid gap-2 p-1">
                <button id="fws-checkout-form-payment"type="submit" class="text-wrap btn btn-lg d-none">Continue To Payment</button>
              </div>
            </form>
          <?php
        }
      }
      else{
        echo '<table><tr><td><h5>Shopping Cart</h5></td></tr><tr><td>Your shopping cart is empty.</td></tr></table>';
      }

    ?>

    </div>
  <?php } ?>
  </div>
</div>
