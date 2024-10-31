<?php
/**
 * @link       https://www.floristone.com
 * @since      1.0.0
 *
 * @package    Florist_One_Flower_Delivery
 * @subpackage Florist_One_Flower_Delivery/public
 */

  if ( ! defined('ABSPATH') ) exit;

  define('OBITUARY_ASSISTANT_F1_API', (!OBITUARY_ASSISTANT_DEBUG_MODE ? 'https://www.floristone.com/api/rest' : 'https://dev.floristone.com/api/rest'));
  define('OBITUARY_ASSISTANT_F1_PPP', 12);
  $config_options = get_option('fhw-solutions-obituaries_1');
  define('OBITUARY_ASSISTANT_LANGUAGE', 'ENGLISH');

    if(isset($config_options['funeral_home_country'])){
      if ($config_options['funeral_home_country'] == 'US'){
        define('OBITUARY_ASSISTANT_USERNAME', '999993');
        define('OBITUARY_ASSISTANT_PASSWORD', 'flowers');
      }
      else {
        define('OBITUARY_ASSISTANT_USERNAME', '999994');
        define('OBITUARY_ASSISTANT_PASSWORD', 'flowers');
    }
  }

  if (isset($_REQUEST['action'])){

    if (!session_id()) {
      session_start();
    }

    if (!(array_key_exists('facility_id', $_REQUEST))){
      $_REQUEST['facility_id'] = 0;
    }

    if ($_REQUEST['action'] == "getProducts"){
      getProducts($_REQUEST['category'], $_REQUEST['page'], $_REQUEST['facility_id']);
    }
    else if ($_REQUEST['action'] == "getProduct"){
      getProduct($_REQUEST['code'], $_REQUEST['facility_id']);
    }
    elseif ($_REQUEST['action'] == "getProductsMore") {
      getProductsMore($_REQUEST['category'], $_REQUEST['page'],$_REQUEST['facility_id']);
    }
    else if ($_REQUEST['action'] == "getTree"){
      getTree($_REQUEST['code'], $_REQUEST['facility_id']);
    }
    else if ($_REQUEST['action'] == "getTreesTotal") {
      getTreesTotal($_REQUEST['code'], $_REQUEST['number'], $_REQUEST['price'], $_REQUEST['client_id']);
    }
    else if ($_REQUEST['action'] == "addToCart"){
      addToCart($_REQUEST['code'], $_REQUEST['num']);
    }
    else if ($_REQUEST['action'] == "removeFromCart"){
      removeFromCart($_REQUEST['code']);
    }
    else if ($_REQUEST['action'] == "getCart"){
      getCart($_REQUEST['code']);
    }
    else if ($_REQUEST['action'] == "getCustomerService"){
      getCustomerService();
    }
    else if ($_REQUEST['action'] == "checkout"){
      checkout($_REQUEST['page'], $_REQUEST['formdata'], $_REQUEST['obituary'], $_REQUEST['validated']);
    }
    else if ($_REQUEST['action'] == "createHostedForm") {
      createHostedForm($_REQUEST['amount'], $_REQUEST['redirect_url'], $_REQUEST['payload'], $_REQUEST['payment_type']);
    }
    else if ($_REQUEST['action'] == "setFlowerSessionData"){
      setFlowerSessionData($_REQUEST);
    }
    else if ($_REQUEST['action'] == "getCartCount"){
      getCartCount($_REQUEST);
    }
    else if ($_REQUEST['action'] == "createPaymentLink"){
      createPaymentLink();
    }
    else if ($_REQUEST['action'] == "placeOrder"){
      placeOrder($_REQUEST['formdata'], $_REQUEST['flowers'], $_REQUEST['ordertotal'], $_REQUEST['token']);
    }


  }

 function getProducts($category, $page, $facilityid){

    $count = OBITUARY_ASSISTANT_F1_PPP;

    if ($category == 'default'){
      $category = 'fbs';
    }

    if ($page == 1){
      $start = 1;
    }
    else{
      $start = 1 + (($page - 1) * $count);
    }

    $_SESSION['florist-one-flower-delivery-facility-id'] = $facilityid;

    $url = OBITUARY_ASSISTANT_F1_API . '/flowershop/getproducts?category=' . $category . '&start=' . $start . '&count=' . $count . '&facilityid=' . $facilityid;
    $headers = array(
      'Authorization: Basic '.base64_encode( OBITUARY_ASSISTANT_USERNAME . ':' . OBITUARY_ASSISTANT_PASSWORD)
    );

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, OBITUARY_ASSISTANT_VERIFYPEER);
    curl_setopt($curl, CURLOPT_FORBID_REUSE, false);
    curl_setopt($curl, CURLOPT_FRESH_CONNECT, false);

    $response = curl_exec($curl);
    curl_close($curl);

    $api_response_body = json_decode($response, true);

    $loadmore = false;

    // if best sellers category
    if ($category == 'fbs' && $page == 1 && get_option('fhw-solutions-obituaries_1')['account_type'] != 6){

      // get tree
      $treeProductApi = getTreeItem('TREES', 0);

      // create item object similar to regular product
      $treeProduct = Array(
        'NAME' => $treeProductApi['itemName'],
        'CODE' => 'TREES',
        'PRICE' => $treeProductApi['price'],
        'SMALL' => $treeProductApi['productURL'],
        'MINIMUM_TREES' => $treeProductApi['minimumNumberOfTrees']
      );

      // insert tree as first item
      array_unshift($api_response_body["PRODUCTS"] , $treeProduct);

      // remove last item
      unset($api_response_body["PRODUCTS"][12]);

    }
    // end if best sellers category

    include 'partials/florist-one-flower-delivery-many-products.php';

    die();

 }

 function getProductsMore($category, $page,$facilityid){

    $config_options = get_option('florist-one-flower-delivery');
    $count = OBITUARY_ASSISTANT_F1_PPP;

    $start = 1 + (($page - 1) * $count);

    if ($category == 'fbs' && $page > 1){
      // start fbs start at item - 1 on pages greater than 1
      // on Best Sellers (fbs) page 1, we manually add an extra item as the first index of the array
      // we then remove the item at the 12 index
      // page 2 needs to start with this removed item
      // so the item that used to be the final item on page 1 is first item on page 2
      $start--;
    }

    $url = OBITUARY_ASSISTANT_F1_API . '/flowershop/getproducts?category=' . $category . '&start=' . $start . '&count=' . $count . '&facilityid=' . $facilityid;
    $headers = array(
      'Authorization: Basic '.base64_encode( OBITUARY_ASSISTANT_USERNAME . ':' . OBITUARY_ASSISTANT_PASSWORD)
    );

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, OBITUARY_ASSISTANT_VERIFYPEER);

    $response = curl_exec($curl);
    curl_close($curl);

    $api_response_body = json_decode($response, true);
    $loadmore = true;

    include 'partials/florist-one-flower-delivery-many-products.php';

    die();

 }

function getProduct($code, $facilityid){

    $_SESSION['florist-one-flower-delivery-facility-id'] = $facilityid;

    $url = OBITUARY_ASSISTANT_F1_API . '/flowershop/getproducts?code=' . $code . '&facilityid=' . $facilityid;
    $headers = array(
      'Authorization: Basic '.base64_encode( OBITUARY_ASSISTANT_USERNAME . ':' . OBITUARY_ASSISTANT_PASSWORD)
    );

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, OBITUARY_ASSISTANT_VERIFYPEER);

    $response = curl_exec($curl);
    curl_close($curl);

    $api_response_body = json_decode($response, true);

    include 'partials/florist-one-flower-delivery-single-product.php';

    die();

}

function getTree($code, $facilityid) {

    $clientId = get_option('fhw-solutions-obituaries_1')['id'];

    $_SESSION['florist-one-flower-delivery-facility-id'] = $facilityid;

    $url = OBITUARY_ASSISTANT_F1_API . '/trees/gettree?code=' . $code . '&language=' . OBITUARY_ASSISTANT_LANGUAGE . '&clientId=' .  $clientId . '&facilityid=' . $facilityid;
    $headers = array(
      'Authorization: Basic '.base64_encode( OBITUARY_ASSISTANT_USERNAME . ':' . OBITUARY_ASSISTANT_PASSWORD)
    );

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, OBITUARY_ASSISTANT_VERIFYPEER);

    $response = curl_exec($curl);
    curl_close($curl);

    $api_response_body = json_decode($response, true);


    include 'partials/florist-one-flower-delivery-plant-a-tree.php';

    die();

}


function getTreeItem($code, $facilityid) {

    $clientId = get_option('fhw-solutions-obituaries_1')['id'];

    $_SESSION['florist-one-flower-delivery-facility-id'] = $facilityid;

    $url = OBITUARY_ASSISTANT_F1_API . '/trees/gettree?code=' . $code . '&language=' . OBITUARY_ASSISTANT_LANGUAGE . '&clientId=' .  $clientId . '&facilityid=' . $facilityid;
    $headers = array(
      'Authorization: Basic '.base64_encode( OBITUARY_ASSISTANT_USERNAME . ':' . OBITUARY_ASSISTANT_PASSWORD)
    );

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, OBITUARY_ASSISTANT_VERIFYPEER);

    $response = curl_exec($curl);
    curl_close($curl);

    $api_response_body = json_decode($response, true);

    return $api_response_body;

}


 function getTreesTotal($code,$number,$price,$client_id){

    $url = OBITUARY_ASSISTANT_F1_API . '/trees/getprice?code=' . $code . '&number='.$number . '&clientId='. $client_id;
    $headers = array(
      'Authorization: Basic '.base64_encode( OBITUARY_ASSISTANT_USERNAME . ':' . OBITUARY_ASSISTANT_PASSWORD)
    );

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, OBITUARY_ASSISTANT_VERIFYPEER);

    $response = curl_exec($curl);
    curl_close($curl);

    $get_total_response_body = json_decode($response, true);

    echo $get_total_response_body['price'];
    die();

 }

 function createCart(){

    $headers = array(
      'Authorization: Basic '.base64_encode( OBITUARY_ASSISTANT_USERNAME . ':' . OBITUARY_ASSISTANT_PASSWORD)
    );
    $url = OBITUARY_ASSISTANT_F1_API . '/shoppingcart';

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, OBITUARY_ASSISTANT_VERIFYPEER);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($curl, CURLOPT_POSTFIELDS, '');


    $response = curl_exec($curl);
    curl_close($curl);

    $sessionid = json_decode($response)->{"SESSIONID"};

    $_SESSION['sesh'] = $sessionid;

    return $sessionid;

 }

function getCartCount(){

  if (!isset($_SESSION['sesh'])) {
    echo 0;
  }

  else {

    $sessionid = $_SESSION['sesh'];

    $url = OBITUARY_ASSISTANT_F1_API . '/shoppingcart?sessionid=' . $sessionid;
    $headers = array(
      'Authorization: Basic '.base64_encode( OBITUARY_ASSISTANT_USERNAME . ':' . OBITUARY_ASSISTANT_PASSWORD)
    );

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, OBITUARY_ASSISTANT_VERIFYPEER);

    $response = curl_exec($curl);
    curl_close($curl);

    $api_response_body = json_decode($response, true);

    echo is_array($api_response_body) ? (isset($api_response_body['products']) ? count((array)$api_response_body['products']) :0):0;

  }

  die();

}


function getCartData(){

   if (!isset($_SESSION['sesh'])){
     $sessionid = createCart();
   }
   else {
     $sessionid = $_SESSION['sesh'];

   }

   $clientId = get_option('fhw-solutions-obituaries_1')['id'];

   $url = OBITUARY_ASSISTANT_F1_API . '/shoppingcart?sessionid=' . $sessionid . '&language=' . OBITUARY_ASSISTANT_LANGUAGE . '&clientId=' .  $clientId;
    $headers = array(
      'Authorization: Basic '.base64_encode( OBITUARY_ASSISTANT_USERNAME . ':' . OBITUARY_ASSISTANT_PASSWORD)
    );

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,OBITUARY_ASSISTANT_VERIFYPEER);

    $api_response = curl_exec($curl);
    curl_close($curl);

    $api_response_body = json_decode($api_response, true);

   if (is_array($api_response_body)){
      if(isset($api_response_body['products'][0]['CODE'])){
		 if (substr($api_response_body['products'][0]['CODE'], 0, 4) == "TREE"){

			// return in cart
			$treeProduct = array();
			$tree = array(
			  "CODE" =>  $api_response_body['products'][0]['CODE'],
			  "NUMBER" => intval(preg_replace('/[^0-9.]+/', '', $api_response_body['products'][0]['NAME'])),
			  "PRICE" =>  $api_response_body['products'][0]['PRICE'],
			  "STRIPE_PRICE_ID" =>  $api_response_body['products'][0]['STRIPE_PRICE_ID']
			);

			array_push($treeProduct,$tree);

			$url_tree = OBITUARY_ASSISTANT_F1_API . '/trees/gettree?code=TREES' . '&facilityid=' . $_SESSION['florist-one-flower-delivery-facility-id'] . '&language=ENGLISH&clientId=' . $clientId;
			$curl = curl_init($url_tree);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, OBITUARY_ASSISTANT_VERIFYPEER);

			$api_response_tree = curl_exec($curl);
			curl_close($curl);

			$api_response_body_tree = json_decode($api_response_tree, true);

			$url  = OBITUARY_ASSISTANT_F1_API . '/trees/gettotal?products=' . json_encode($treeProduct) . '&facilityid=' . $_SESSION['florist-one-flower-delivery-facility-id'] . '&clientId=' . $clientId;
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, OBITUARY_ASSISTANT_VERIFYPEER);

			$api_response = curl_exec($curl);
			curl_close($curl);

			$get_total_response_body = json_decode($api_response, true);

			 $products = array();

			 $products_for_display = array(

				array(

					"IMG" => $api_response_body_tree["productURL"],
					"CODE" => $api_response_body['products'][0]['CODE'],
					"PRICE" => number_format($api_response_body['products'][0]['PRICE'], 2, '.', ''),
					"NAME" =>  $api_response_body['products'][0]['NAME'],
					"STRIPE_PRICE_ID" => $api_response_body_tree['stripePriceId'],
					"CURRENCY" => $api_response_body_tree['currency'],
					"CURRENCY_SYMBOL" => $api_response_body_tree['currency_symbol'],
					"DESCRIPTION" => "Plant " .
					     $treeProduct[0]["NUMBER"] .
               " " .
					     ( $treeProduct[0]["NUMBER"] == 1 ?
					     $api_response_body_tree["productSingularTree"] :
					     $api_response_body_tree["productPluralTree"] )
				)

			 );
			 $products = $products_for_display;

			 $errors = array();
			 $errors = isset($get_total_response_body['errors']) ? $get_total_response_body['errors'] : "" ;


		 } else {
		   $errors = array();
		   $errors = isset($api_response_body["errors"]) ? isset($api_response_body["errors"]) : '';

		   $products = array();
		   $products_for_display = array();

		   $config_options = get_option('fhw-solutions-obituaries_3');
		   if (isset($_SESSION['florist-one-flower-delivery-recipient-postal-code'])){
			 $zipcode = $_SESSION['florist-one-flower-delivery-recipient-postal-code'];
		   }
		   else if (isset($config_options['address_zipcode']) && strlen($config_options['address_zipcode']) > 0){
			 $zipcode = $config_options['address_zipcode'];
		   }
		   else {
			 $zipcode = '11779';
		   }

		   $zipcode = str_replace( ' ', '%20', $zipcode);

		   for($i=0;$i<count((array)$api_response_body["products"]);$i++){
			  $code = $api_response_body["products"][$i]['CODE'];
			  $url  = OBITUARY_ASSISTANT_F1_API . '/flowershop/getproducts?code=' . $code . '&facilityid=' . $_SESSION['florist-one-flower-delivery-facility-id'];

			  $curl = curl_init($url);
			  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, OBITUARY_ASSISTANT_VERIFYPEER);

			  $response = curl_exec($curl);
			  curl_close($curl);

			  $get_products_response_body = json_decode($response, true);

			  $product = array(
			   "CODE" =>  $get_products_response_body["PRODUCTS"][0]['CODE'],
			   "PRICE" => $get_products_response_body["PRODUCTS"][0]['PRICE'],
			   "IMG" =>  $get_products_response_body["PRODUCTS"][0]['LARGE'],
			   "RECIPIENT" => array(
				 "ZIPCODE" => $zipcode
			   )
			  );
			  array_push($products, $product);
			  $product = array(
			   "CODE" =>  $get_products_response_body["PRODUCTS"][0]['CODE'],
			   "PRICE" => $get_products_response_body["PRODUCTS"][0]['PRICE'],
			   "NAME" => $get_products_response_body["PRODUCTS"][0]['NAME'],
			   "IMG" => $get_products_response_body["PRODUCTS"][0]['LARGE']
			  );
			  array_push($products_for_display, $product);
		  }

		  $url    = OBITUARY_ASSISTANT_F1_API . '/flowershop/gettotal?products=' . json_encode($products) . '&facilityid=' . $_SESSION['florist-one-flower-delivery-facility-id'];
		  $curl = curl_init($url);
		  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, OBITUARY_ASSISTANT_VERIFYPEER);

		  $response = curl_exec($curl);
		  curl_close($curl);
		  $get_total_response_body = json_decode($response, true);

	    }
   	 }
   }

  $vars = array(
    'get_total_response_body' => isset($get_total_response_body)? $get_total_response_body : "" ,
    'products_for_display' => isset($products_for_display) ? $products_for_display : "" ,
    'products' => isset($products) ? $products : "" ,
    'errors' => isset($errors) ? $errors : "",
  );

  return $vars;

 }

 function getCart($code){

    $vars = getCartData();
    $get_total_response_body = $vars['get_total_response_body'];
    $products_for_display = $vars['products_for_display'];
    $products = $vars['products'];
    $errors = $vars['errors'];

    if(isset($products_for_display[0]['CODE'])){
		if($products_for_display[0]['CODE'] == "TREES"){

			  //$display_tree_message_seperate = "Flowers and trees cannot be purchased together and need to be purchased separately.";

			  if(strpos($code, 'Trees') === false ){
				if($code != null || $code == "Not a TREE" ){
				  $display_tree_message_seperate = "Sorry but flowers and trees cannot be purchased together and need to be purchased separately";
				}
			  }

		}
    }

    $dont_show_remove_button=0;
    include 'partials/florist-one-flower-delivery-cart.php';
    die();
 }

 function createCheckoutPayload($obituary, $flowers, $ordertotal, $token){

   $vars = getCartData();
   $products_for_display = $vars["products_for_display"];
   $products = $vars["products"];
   $config_options = get_option('fhw-solutions-obituaries_1');
   $treeDeliveryMethod = $_SESSION['florist-one-flower-delivery-tree-certificate'];

   if (!$flowers){

     $customer = array(
      'first_name' => $_SESSION['florist-one-flower-delivery-customer-name'],
      'last_name' => "",
      'address' => $_SESSION['florist-one-flower-delivery-customer-address-1'] . " " . $_SESSION['florist-one-flower-delivery-customer-address-2'] ,
      'city' => $_SESSION['florist-one-flower-delivery-customer-city'],
      'state' => ($_SESSION['florist-one-flower-delivery-customer-country'] == "CA" || $_SESSION['florist-one-flower-delivery-customer-country'] == "US") ? $_SESSION["florist-one-flower-delivery-customer-state"] : "NA",
      'zipcode' => ($_SESSION['florist-one-flower-delivery-customer-country'] == "CA" || $_SESSION['florist-one-flower-delivery-customer-country'] == "US")? $_SESSION["florist-one-flower-delivery-customer-postal-code"] : ($_SESSION["florist-one-flower-delivery-customer-postal-code"] != "" ? $_SESSION["florist-one-flower-delivery-customer-postal-code"] : 1),
      'country' => $_SESSION['florist-one-flower-delivery-customer-country'],
      'phone' => preg_replace('~\D~', '', $_SESSION['florist-one-flower-delivery-customer-phone']),
      'email' => $_SESSION['florist-one-flower-delivery-customer-email'],
      'ip' => $_SERVER['REMOTE_ADDR']
     );

     $recipient = array(
      'message' => ($treeDeliveryMethod == "Cert-email-behalf") ? $_SESSION['florist-one-flower-delivery-tree-certificate-email-behalf-message-to-recipient'] : "",
      'first_name' => ($treeDeliveryMethod == "Cert-email-behalf") ?$_SESSION['florist-one-flower-delivery-tree-certificate-email-behalf-recipient-name'] : "",
      'last_name' => "",
      'email' => ($treeDeliveryMethod == "Cert-email-behalf") ? $_SESSION['florist-one-flower-delivery-tree-certificate-email-behalf-recipient-email']:"",
      'send_certificate' => ($treeDeliveryMethod == "Cert-email-behalf") ? 1 : 0
     );

     $product = array(
      'code' => $products_for_display[0]['CODE'],
      'amount' => $products_for_display[0]['PRICE'],
      'number' =>    intval(preg_replace('/[^0-9.]+/', '', $vars["products"][0]["NAME"])),
      'currency' => $products_for_display[0]['CURRENCY'],
      'stripe_price_id' => $products_for_display[0]['STRIPE_PRICE_ID'],
     );

     $purchase_recognition = array(
       'obit_id' => $_SESSION['florist-one-flower-delivery-obit-id'],
       'celebration_type' => "PURCHASE_RECOGNITION",
       'order_id' => null,
       'email' => $_SESSION['florist-one-flower-delivery-customer-email'],
       'order_type' => ($products_for_display[0]['CODE'] == "TREES")? "T" : "F"
     );

     $metadata = array(
       'product' => $products_for_display[0]['NAME'],
       'customer_name' => $customer['first_name'],
       'customer_email' => $customer['email'],
       'deceased_name' => $_SESSION["florist-one-flower-delivery-tree-certificate-name-of-loved-one"],
       'funeral_home_name' => 'The Funeral Home'
     );

     $payload = array(
       'customer' => $customer,
       'recipient' => $recipient,
       'product' => $product,
       'facilityid' => $_SESSION["florist-one-flower-delivery-facility-id"],
       'referring_affiliate_id' => $config_options["affiliate_id"],
       'referring_client_id' => $config_options["id"],
       'f1_storefront_id' => $config_options["flower_storefront_id"],
       'deceased_display_name' => $_SESSION["florist-one-flower-delivery-tree-certificate-name-of-loved-one"],
       'apikey' => OBITUARY_ASSISTANT_USERNAME,
       'sender_display_name' => $_SESSION["florist-one-flower-delivery-tree-certificate-sender-display-name"],
       'ordertotal' => $ordertotal
     );

     // authorize net token checkout
     if (!is_null($token)){
       $ccinfo = array(
        'authorizenet_token' => $token
       );
       $payload['customer'] = json_encode($payload['customer']);
       $payload['recipient'] = json_encode($payload['recipient']);
       $payload['product'] = json_encode($payload['product']);
       $payload['ccinfo'] = json_encode($ccinfo);
     }

     // stripe connect checkout
     else {
       $payload['stripe_connect_account_id'] = $config_options["stripe_connect_account_id"];
       $payload['metadata'] = $metadata;
     }

   }

   else {

     // flower order with tokenization

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

    $products = array();
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

    $ccinfo = array(
      'authorizenet_token' => $token
    );

    $customer = json_encode($customer);
    $products = json_encode($products);
    $ccinfo = json_encode($ccinfo);

    $payload = array(
      'customer' => $customer,
      'products' => $products,
      'ordertotal' => $ordertotal,
      'ccinfo' => $ccinfo,
      'facilityid' => $_SESSION["florist-one-flower-delivery-facility-id"],
      'f1_aff_id' => $config_options["affiliate_id"],
      'allowsubstitutions' => isset($_SESSION["florist-one-flower-delivery-allow-substitutions-check"]) && $_SESSION["florist-one-flower-delivery-allow-substitutions-check"] == 'on' ? 1 : 0
    );

   }

   //checking if from an obit and ourchase recognition is requested
   if ($obituary == 1 && $_SESSION['florist-one-flower-delivery-purchase-recognition-check'] == "on"){
     $purchase_recognition['status'] = $_SESSION['florist-one-flower-delivery-purchase-recognition-check'];
     $purchase_recognition['sender'] = $_SESSION["florist-one-flower-delivery-customer-name"];
     $purchase_recognition['message'] = $_SESSION["florist-one-flower-delivery-special-card-message"];
     $purchase_recognition['obit_id'] = $_SESSION['florist-one-flower-delivery-obit-id'];
     $purchase_recognition['celebration_type'] = "PURCHASE_RECOGNITION";
     $purchase_recognition['product_name'] = $products_for_display[0]['NAME'];
     $purchase_recognition['product_image_url'] = $products_for_display[0]['IMG'];
     if (!is_null($token)){
       $payload["purchase_recognition"] = json_encode($purchase_recognition);
     }
     else {
       $payload["purchase_recognition"] = $purchase_recognition;
     }
   }

   return $payload;

 }

 function createPaymentLink(){

  if (isset($_SESSION['florist-one-flower-delivery-obit-id']) && $_SESSION['florist-one-flower-delivery-obit-id'] > 0){
    $obituary = 1;
  }
  else {
    $obituary = 0;
  }

  $payload = createCheckoutPayload($obituary, false, null, null);

  $total_price = $payload["product"]["amount"];

  $redirect_url = $_SERVER['HTTP_REFERER'];
  $hostedForm = createHostedForm($total_price, $redirect_url, $payload, "stripe");

  die(
    json_encode(
      $hostedForm
    )
  );

 }

 function placeOrder($formdata, $flowers, $ordertotal, $token){

   storeCheckoutData($formdata);

   if (isset($_SESSION['florist-one-flower-delivery-obit-id']) && $_SESSION['florist-one-flower-delivery-obit-id'] > 0){
     $obituary = 1;
   }
   else {
     $obituary = 0;
   }

   $payload = createCheckoutPayload($obituary, filter_var($flowers, FILTER_VALIDATE_BOOLEAN), $ordertotal, $token);

    $headers = array(
      'Authorization: Basic '.base64_encode( OBITUARY_ASSISTANT_USERNAME . ':' . OBITUARY_ASSISTANT_PASSWORD)
    );
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => OBITUARY_ASSISTANT_F1_API . (filter_var($flowers, FILTER_VALIDATE_BOOLEAN) == true ? '/flowershop/placeorder' : '/trees/placeorder'),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => http_build_query($payload),
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_SSL_VERIFYPEER => OBITUARY_ASSISTANT_VERIFYPEER
    ));
    $api_response = curl_exec($curl);
    curl_close($curl);

    $api_response_body = json_decode($api_response, true);

    if (isset($api_response_body["errors"])){
      // api errors, send user back
      die(json_encode($api_response_body["errors"]));
    }
    else {
      // good order, send user to confirmation page
      $formdata["order_id"] = $api_response_body["ORDERNO"];
      checkout(5, $formdata, null, null);
      die();
    }

 }

 function addToCart($code, $num){

     if (!isset($_SESSION['sesh'])){
       $sessionid = createCart();
     }
     else {
       $sessionid = $_SESSION['sesh'];
       if (checkCartStillExists() == false){
         $sessionid = createCart();
       }
     }

     //check if adding tree to flower
     $messageTree = false;

     if (strpos($code, 'Trees') !== false ){
       $checkCart = getCartData();

       if($checkCart['products_for_display'] != null){

		   if (count($checkCart['products_for_display']) != 0){

			  if($checkCart['products_for_display'][0]["CODE"] != "TREES"){// not adding tree

				$messageTree = true;

			  }
		   }
       	}
    }

    $headers = array(
      'Authorization: Basic '.base64_encode( OBITUARY_ASSISTANT_USERNAME . ':' . OBITUARY_ASSISTANT_PASSWORD)
    );
    $clientId = get_option('fhw-solutions-obituaries_1')['id'];

     for ($i=0;$i< (int)$num;$i++){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => OBITUARY_ASSISTANT_F1_API . '/shoppingcart?action=add&sessionid=' . $sessionid . '&productcode=' . str_replace( ' ', '%20', $code) . '&language=' . OBITUARY_ASSISTANT_LANGUAGE . '&clientId=' .  $clientId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS =>'',
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER => OBITUARY_ASSISTANT_VERIFYPEER
        ));
        $api_response = curl_exec($curl);
        curl_close($curl);
     }

     if ($messageTree){

      $code = "Not a TREE";

     }
     getCart($code);

 }

 function checkCartStillExists(){
   $vars = getCartData();
   $errors = $vars['errors'];

   if ($errors == 'invalid sessionid' || $errors == 'The sessionid does not exist'){
     return false;
   }
   return true;
 }

 function removeFromCart($code){

     if (!isset($_SESSION['sesh'])){
       $sessionid = createCart();
     }
     else {
       $sessionid = $_SESSION['sesh'];
       if (checkCartStillExists() == false){
         $sessionid = createCart();
       }
     }

     $clientId = get_option('fhw-solutions-obituaries_1')['id'];

      $headers = array(
        'Authorization: Basic '.base64_encode( OBITUARY_ASSISTANT_USERNAME . ':' . OBITUARY_ASSISTANT_PASSWORD)
      );
      $curl = curl_init();
      curl_setopt_array($curl, array(
          CURLOPT_URL => OBITUARY_ASSISTANT_F1_API . '/shoppingcart?action=remove&sessionid=' . $sessionid . '&productcode=' . $code . '&language=' . OBITUARY_ASSISTANT_LANGUAGE . '&clientId=' .   $clientId,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'PUT',
          CURLOPT_POSTFIELDS =>'',
          CURLOPT_HTTPHEADER => $headers,
          CURLOPT_SSL_VERIFYPEER => OBITUARY_ASSISTANT_VERIFYPEER
      ));
      $api_response = curl_exec($curl);
      curl_close($curl);


     getCart(null);

 }

 function getCustomerService(){

    $config_options = get_option('fhw-solutions-obituaries_3');

    $url = OBITUARY_ASSISTANT_F1_API . '/flowershop/customerservice?currency' . $config_options['currency'];
    $headers = array(
      'Authorization: Basic '.base64_encode( OBITUARY_ASSISTANT_USERNAME . ':' . OBITUARY_ASSISTANT_PASSWORD)
    );

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, OBITUARY_ASSISTANT_VERIFYPEER);

    $response = curl_exec($curl);
    curl_close($curl);

    $api_response_body = json_decode($response, true);

    include 'partials/florist-one-flower-delivery-customer-service.php';
    die();

 }

 function createHostedForm($amount, $redirect_url, $payload, $paymentType)
 {

    $data = array(
       'amount' => $amount,
       'redirect_url' => strtok($redirect_url, '?'),
       'payload' => json_encode($payload, JSON_UNESCAPED_UNICODE),
       'plugin' => 'oa',
       'payment_type' => $paymentType
     );

    $headers = array(
      'Authorization: Basic '.base64_encode( OBITUARY_ASSISTANT_USERNAME . ':' . OBITUARY_ASSISTANT_PASSWORD)
    );
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => OBITUARY_ASSISTANT_F1_API . '/wordpress/paymentForm',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => http_build_query($data),
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_SSL_VERIFYPEER => OBITUARY_ASSISTANT_VERIFYPEER
    ));
    $api_response = curl_exec($curl);
    curl_close($curl);

    $api_response_body = json_decode($api_response, true);

    return $api_response_body;
 }


function clearCart(){

    if (!isset($_SESSION['sesh'])){
      $sessionid = createCart();
    }
    else {
      $sessionid = $_SESSION['sesh'];
      if (checkCartStillExists() == false){
        $sessionid = createCart();
      }
    }

    $headers = array(
      'Authorization: Basic '.base64_encode( OBITUARY_ASSISTANT_USERNAME . ':' . OBITUARY_ASSISTANT_PASSWORD)
    );

    $curl = curl_init();
      curl_setopt_array($curl, array(
          CURLOPT_URL => OBITUARY_ASSISTANT_F1_API . '/shoppingcart?action=clear&sessionid=' . $sessionid,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'PUT',
          CURLOPT_POSTFIELDS =>'',
          CURLOPT_HTTPHEADER => $headers,
          CURLOPT_SSL_VERIFYPEER => OBITUARY_ASSISTANT_VERIFYPEER
      ));
      $api_response = curl_exec($curl);
      curl_close($curl);

}

 function getDeliveryDates($zipcode){

    $headers = array(
      'Authorization: Basic '.base64_encode( OBITUARY_ASSISTANT_USERNAME . ':' . OBITUARY_ASSISTANT_PASSWORD)
    );

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => OBITUARY_ASSISTANT_F1_API . '/flowershop/checkdeliverydate?zipcode=' . str_replace( ' ', '%20', $zipcode),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_POSTFIELDS => '',
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_SSL_VERIFYPEER => OBITUARY_ASSISTANT_VERIFYPEER
    ));
    $response = curl_exec($curl);
    curl_close($curl);

    return json_decode($response, true);

 }

 function getCredentials(){

    $headers = array(
      'Authorization: Basic '.base64_encode( OBITUARY_ASSISTANT_USERNAME . ':' . OBITUARY_ASSISTANT_PASSWORD)
    );

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => OBITUARY_ASSISTANT_F1_API . '/flowershop/getauthorizenetkey',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_POSTFIELDS => '',
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_SSL_VERIFYPEER => OBITUARY_ASSISTANT_VERIFYPEER
    ));
    $response = curl_exec($curl);
    curl_close($curl);

    return json_decode($response, true);

 }

 function checkout($page, $formdata, $obituary, $validated){

     storeCheckoutData($formdata);

     $config_options = get_option('fhw-solutions-obituaries_3');
     if (isset($_SESSION['florist-one-flower-delivery-recipient-postal-code'])){
       $zipcode = $_SESSION['florist-one-flower-delivery-recipient-postal-code'];
     }
     else if (isset($config_options['address_zipcode']) && strlen($config_options['address_zipcode']) > 0){
       $zipcode = $config_options['address_zipcode'];
     }
     else {
       $zipcode = '11779';
     }

     switch($page){
      case 4:
        $delivery_dates = getDeliveryDates($zipcode);
        $vars = getCartData();

        $get_total_response_body = $vars["get_total_response_body"];

        $products_for_display = $vars["products_for_display"];
        $products = $vars["products"];

		if(isset($products[0]["NAME"])){
        	preg_match_all('/[0-9]+/', $products[0]["NAME"], $matches);
        	$tree_quantity = $matches[0][0];
        }

        $errors = $vars["errors"];
        include 'partials/florist-one-flower-delivery-checkout-4.php';
        break;
      case 5:
        $vars = getCartData();
        $get_total_response_body = $vars["get_total_response_body"];
        $products_for_display = $vars["products_for_display"];
        $products = $vars["products"];
        $errors = $vars["errors"];
        $orderno = $formdata['order_id'];
        include 'partials/florist-one-flower-delivery-checkout-5.php';
        break;
      case 6:
        include 'partials/florist-one-flower-delivery-ssl-warning.php';
        break;
     }

     die();

 }

 function storeCheckoutData($formdata){

   if(isset($formdata)){

     // remove check box types because they won't be overwritten if unchecked
     unset($_SESSION["florist-one-flower-delivery-purchase-recognition-check"]);
     unset($_SESSION["florist-one-flower-delivery-allow-substitutions-check"]);

     // loop through and store
     for($i=0;$i<count($formdata);$i++){
       if(isset($formdata[$i])){
        $_SESSION[''.$formdata[$i]['name'].''] = $formdata[$i]['value'];
       }
     }

   }

 }

 function init_flower_delivery($obit) {

    if (!(isset($_SESSION['florist-one-flower-delivery-recipient-postal-code']))){
      $options = get_option('fhw-solutions-obituaries_1');
      $_SESSION['florist-one-flower-delivery-recipient-institution'] = $options['funeral_home_name'];
      $_SESSION['florist-one-flower-delivery-recipient-address-1'] = $options['funeral_home_address'];
      $_SESSION['florist-one-flower-delivery-recipient-city'] = $options['funeral_home_city'];
      $_SESSION['florist-one-flower-delivery-recipient-state'] = $options['funeral_home_state'];
      $_SESSION['florist-one-flower-delivery-recipient-country'] = $options['funeral_home_country'];
      $_SESSION['florist-one-flower-delivery-recipient-phone'] = $options['funeral_home_phone'];
      $_SESSION['florist-one-flower-delivery-recipient-postal-code'] = $options['funeral_home_zip'];
    }

    $htmlString = '';
    // $htmlString .= '<div class="florist-one-flower-delivery-container bootstrap-fhws-obituaries-container" id="flowers">';
    $htmlString .= init_flower_delivery_menu($obit);
    $htmlString .= '<div class="bootstrap-fhws-obituaries-container">';
    $htmlString .= '<div class="florist-one-flower-delivery"></div>';
    $htmlString .= '</div>';
    $htmlString .= '<div class="bootstrap-fhws-obituaries-container bootstrap-fhws-obituaries-container-1">';
    $htmlString .= '<div id="florist-one-flower-delivery-loader" class="d-none d-flex justify-content-center position-fixed top-50 start-50">';
    $htmlString .= '<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>';
    $htmlString .= '</div>';
    $htmlString .= '</div>';
    // $htmlString .= '</div>';

    // pre-pop values from obit session
    $htmlString .= '<input type="hidden" id="florist-one-flower-delivery-recipient-name" value="' . (isset($_SESSION['florist-one-flower-delivery-recipient-name']) ? esc_html($_SESSION['florist-one-flower-delivery-recipient-name']) :  "" ) . '">';
    $htmlString .= '<input type="hidden" id="florist-one-flower-delivery-recipient-institution" value="' . $_SESSION['florist-one-flower-delivery-recipient-institution'] . '">';
    $htmlString .= '<input type="hidden" id="florist-one-flower-delivery-recipient-address-1" value="' . $_SESSION['florist-one-flower-delivery-recipient-address-1'] . '">';
    $htmlString .= '<input type="hidden" id="florist-one-flower-delivery-recipient-city" value="' . $_SESSION['florist-one-flower-delivery-recipient-city'] . '">';
    $htmlString .= '<input type="hidden" id="florist-one-flower-delivery-recipient-state" value="' . $_SESSION['florist-one-flower-delivery-recipient-state'] . '">';
    $htmlString .= '<input type="hidden" id="florist-one-flower-delivery-recipient-country" value="' . $_SESSION['florist-one-flower-delivery-recipient-country'] . '">';
    $htmlString .= '<input type="hidden" id="florist-one-flower-delivery-recipient-phone" value="' . $_SESSION['florist-one-flower-delivery-recipient-phone'] . '">';
    $htmlString .= '<input type="hidden" id="florist-one-flower-delivery-recipient-postal-code" value="' . $_SESSION['florist-one-flower-delivery-recipient-postal-code'] . '">';
    $htmlString .= '<input type="hidden" id="florist-one-flower-delivery-facility-id" value="' . (isset($_SESSION['florist-one-flower-delivery-facility-id']) ? $_SESSION['florist-one-flower-delivery-facility-id'] : "" ) . '">';

    // add only for flower_delivery shortcode
    if ($obit != "obit"){
    $htmlString .= '<input type="hidden" id="client_type" value="' .  $options["account_type"] . '">';
    }

    return $htmlString;

  }

  function init_flower_delivery_menu($obit) {
      ob_start();
      echo '<div class="bootstrap-fhws-obituaries-container">';
      include 'partials/florist-one-flower-delivery-menu.php';
      echo '</div>';
      $buffer = ob_get_clean();
      return $buffer;
  }

  function setFlowerSessionData($data){

    // select tree certificate delivery Method
    $_SESSION['florist-one-flower-delivery-tree-certificate-name-of-loved-one'] = isset($data['florist-one-flower-delivery-tree-certificate-name-of-loved-one']) ?  ($data['florist-one-flower-delivery-tree-certificate-name-of-loved-one'] == null)? $data['tree-tree-name-of-loved-one'] : $data['florist-one-flower-delivery-tree-certificate-name-of-loved-one']: "";
    $_SESSION['florist-one-flower-delivery-tree-certificate-sender-display-name'] = isset($data['florist-one-flower-delivery-tree-certificate-sender-display-name']) ? $data['florist-one-flower-delivery-tree-certificate-sender-display-name'] : "";
    $_SESSION['florist-one-flower-delivery-tree-certificate'] = isset($data['florist-one-flower-delivery-tree-certificate']) ? $data['florist-one-flower-delivery-tree-certificate'] : "";
    $_SESSION['florist-one-flower-delivery-tree-certificate-email-behalf-recipient-name'] = isset($data['florist-one-flower-delivery-tree-certificate-email-behalf-recipient-name']) ? $data['florist-one-flower-delivery-tree-certificate-email-behalf-recipient-name'] : "";
    $_SESSION['florist-one-flower-delivery-tree-certificate-email-behalf-recipient-email'] = isset($data['florist-one-flower-delivery-tree-certificate-email-behalf-recipient-email']) ? $data['florist-one-flower-delivery-tree-certificate-email-behalf-recipient-email'] : "";
    $_SESSION['florist-one-flower-delivery-tree-certificate-email-behalf-message-to-recipient'] = isset($data['florist-one-flower-delivery-tree-certificate-email-behalf-message-to-recipient']) ? $data['florist-one-flower-delivery-tree-certificate-email-behalf-message-to-recipient'] : "";

    // bill to
    $_SESSION['florist-one-flower-delivery-customer-name'] = isset($data['florist-one-flower-delivery-customer-name']) ? $data['florist-one-flower-delivery-customer-name'] : "" ;
    $_SESSION['florist-one-flower-delivery-customer-email'] = isset($data['florist-one-flower-delivery-customer-email']) ? $data['florist-one-flower-delivery-customer-email'] : "";
    $_SESSION['florist-one-flower-delivery-customer-address-1'] = isset($data['florist-one-flower-delivery-customer-address-1']) ? $data['florist-one-flower-delivery-customer-address-1'] : "";
    $_SESSION['florist-one-flower-delivery-customer-address-2'] = isset($data['florist-one-flower-delivery-customer-address-2']) ? $data['florist-one-flower-delivery-customer-address-2'] : "";
    $_SESSION['florist-one-flower-delivery-customer-state'] = isset($data['florist-one-flower-delivery-customer-state']) ? $data['florist-one-flower-delivery-customer-state'] : "";
    $_SESSION['florist-one-flower-delivery-customer-city'] = isset($data['florist-one-flower-delivery-customer-city']) ? $data['florist-one-flower-delivery-customer-city'] : "";
    $_SESSION['florist-one-flower-delivery-customer-country'] = isset($data['florist-one-flower-delivery-customer-country']) ? $data['florist-one-flower-delivery-customer-country'] : "" ;
    $_SESSION['florist-one-flower-delivery-customer-postal-code'] = isset($data['florist-one-flower-delivery-customer-postal-code']) ? $data['florist-one-flower-delivery-customer-postal-code'] : "" ;
    $_SESSION['florist-one-flower-delivery-customer-phone'] = isset($data['florist-one-flower-delivery-customer-phone']) ? $data['florist-one-flower-delivery-customer-phone'] : "" ;

    // deliver info
    $_SESSION['florist-one-flower-delivery-delivery-date'] = isset($data['florist-one-flower-delivery-delivery-date']) ? $data['florist-one-flower-delivery-delivery-date'] : "";
    $_SESSION['florist-one-flower-delivery-special-card-message'] = isset($data['florist-one-flower-delivery-special-card-message']) ? $data['florist-one-flower-delivery-special-card-message'] : "";
    $_SESSION['florist-one-flower-delivery-special-special-instructions'] = isset($data['florist-one-flower-delivery-special-special-instructions']) ?$data['florist-one-flower-delivery-special-special-instructions'] : "" ;

    // deliver to
    $_SESSION['florist-one-flower-delivery-recipient-name'] = isset($data['florist-one-flower-delivery-recipient-name']) ? $data['florist-one-flower-delivery-recipient-name'] : (isset($data['name']) ? $data['name'] : "") ;
    $_SESSION['florist-one-flower-delivery-recipient-institution'] = isset($data['florist-one-flower-delivery-recipient-institution']) ? $data['florist-one-flower-delivery-recipient-institution'] : (isset($data['institution']) ? $data['institution'] : "" );
    $_SESSION['florist-one-flower-delivery-recipient-address-1'] = isset($data['florist-one-flower-delivery-recipient-address-1']) ?  $data['florist-one-flower-delivery-recipient-address-1'] : (isset($data['address1']) ? $data['address1'] : "" );
    $_SESSION['florist-one-flower-delivery-recipient-city'] = isset($data['florist-one-flower-delivery-recipient-city']) ? $data['florist-one-flower-delivery-recipient-city'] : (isset($data['city']) ? $data['city'] : "" );
    $_SESSION['florist-one-flower-delivery-recipient-state'] = isset($data['florist-one-flower-delivery-recipient-state']) ? $data['florist-one-flower-delivery-recipient-state'] : (isset($data['state']) ? $data['state'] : "");
    $_SESSION['florist-one-flower-delivery-recipient-country'] = isset($data['florist-one-flower-delivery-recipient-country']) ? $data['florist-one-flower-delivery-recipient-country'] : (isset($data['country']) ? $data['country'] : "");
    $_SESSION['florist-one-flower-delivery-recipient-phone'] = isset($data['florist-one-flower-delivery-recipient-phone']) ? $data['florist-one-flower-delivery-recipient-phone'] : (isset($data['phone']) ? $data['phone'] : "");
    $_SESSION['florist-one-flower-delivery-recipient-postal-code'] = isset($data['florist-one-flower-delivery-recipient-postal-code']) ?  $data['florist-one-flower-delivery-recipient-postal-code'] : (isset($data['zip']) ? $data['zip'] : "");
    $_SESSION['florist-one-flower-delivery-facility-id'] = isset($data['facility_id']) ? $data['facility_id'] : "";
    $_SESSION['florist-one-flower-delivery-obit-id'] = isset($data['obit_id']) ?  $data['obit_id'] : "";

    $_SESSION['florist-one-flower-delivery-recipient-address-2'] = isset($data['florist-one-flower-delivery-recipient-address-2']) ? $data['florist-one-flower-delivery-recipient-address-2'] : "";

    // purchase recognition

    $_SESSION['florist-one-flower-delivery-purchase-recognition-check'] = isset($data['florist-one-flower-delivery-purchase-recognition-check']) ? $data['florist-one-flower-delivery-purchase-recognition-check'] : "" ;
    $_SESSION['florist-one-flower-delivery-allow-substitutions-check'] = isset($data['florist-one-flower-delivery-allow-substitutions-check']) ? $data['florist-one-flower-delivery-allow-substitutions-check'] : "";


    die();

  }

  function isSecure() {
    return
      (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
      || $_SERVER['SERVER_PORT'] == 443;
  }

  add_shortcode('flower-delivery','init_flower_delivery');

?>
