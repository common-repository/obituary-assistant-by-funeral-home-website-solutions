<?php

/**
 * @package    Fhw_Solutions_Obituaries
 * @since      1.0.0
 */

 if (! defined('ABSPATH')) {
     exit;
 }

/******Obituaries-subscription-widget*******/

include 'partials/obituaries-subscription-widget.php';

        /**************EnD**************/

 if (isset($_REQUEST['action'])) {
     if ($_REQUEST['action'] == "obituary_assistant_share_obituary") {
         obituary_assistant_share_obituary(sanitize_text_field($_REQUEST['client_id']), sanitize_text_field($_REQUEST['obit_id']), sanitize_text_field($_REQUEST['type']), sanitize_text_field($_REQUEST['address']), sanitize_text_field($_REQUEST['url']));
     } elseif ($_REQUEST['action'] == "obituary_assistant_add_photo") {
         obituary_assistant_add_photo(sanitize_text_field($_REQUEST['photos_data']), sanitize_text_field($_REQUEST['obit_id']));
     } elseif ($_REQUEST['action'] == "obituary_assistant_add_condolence") {
         obituary_assistant_add_condolence(sanitize_text_field($_REQUEST['obit_id']), sanitize_text_field($_REQUEST['type']), sanitize_text_field($_REQUEST['sender']), sanitize_text_field($_REQUEST['message']), sanitize_email($_REQUEST['email']), sanitize_text_field($_REQUEST['celebration_type']), sanitize_text_field($_REQUEST['o-s-t']), sanitize_text_field($_REQUEST['o-s-u']), sanitize_text_field($_REQUEST['o-s-e']));
     } elseif ($_REQUEST['action'] == "obituary_assistant_delete_condolence") {
         obituary_assistant_delete_condolence(sanitize_text_field($_REQUEST['obit_id']), $_REQUEST['post_id'], sanitize_text_field($_REQUEST['o-s-t']), sanitize_text_field($_REQUEST['o-s-u']), sanitize_text_field($_REQUEST['o-s-e']));
     } elseif ($_REQUEST['action'] == "obituary_assistant_refresh_condolences") {
         obituary_assistant_refresh_condolences(sanitize_text_field($_REQUEST['obit_id']), sanitize_text_field($_REQUEST['o-s-t']), sanitize_text_field($_REQUEST['o-s-u']), sanitize_text_field($_REQUEST['o-s-e']));
     } elseif ($_REQUEST['action'] == "obituary_assistant_check_captcha") {
         obituary_assistant_check_captcha(sanitize_text_field($_REQUEST['captchaSelection']));
     } elseif ($_REQUEST['action'] == "obituary_assistant_send_directions") {
         obituary_assistant_send_directions(sanitize_text_field($_REQUEST['address']), sanitize_text_field($_REQUEST['location']));
     } elseif ($_REQUEST['action'] == "obituary_assistant_subscribe_to_obituary") {
         obituary_assistant_subscribe_to_obituary(sanitize_text_field($_REQUEST['obit_id']), sanitize_text_field($_REQUEST['address']));
     } elseif ($_REQUEST['action'] == "obituary_assistant_subscribe_to_client") {
         obituary_assistant_subscribe_to_client(sanitize_text_field($_REQUEST['address']));
     } elseif ($_REQUEST['action'] == "obituary_assistant_search_for_obit") {
         obituary_assistant_search_for_obit(sanitize_text_field($_REQUEST['search_string']));
     } elseif ($_REQUEST['action'] == "refresh_photos_and_videos") {
         refresh_photos_and_videos(sanitize_text_field($_REQUEST['obit_id']));
     } elseif ($_REQUEST['action'] == "obituary_assistant_submit_useful_link") {
         obituary_assistant_submit_useful_link($_REQUEST);
     }
 }

 function obituary_assistant_get_obituaries_from_api($page)
 {
    $options = get_option('fhw-solutions-obituaries_1');
    $username = $options['username'];
    $password = $options['password'];

    $headers = array(
      'Authorization: Basic '.base64_encode($username . ':' . $password),
      'OA-Version: ' . get_option('oa-version')
    );

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => (!OBITUARY_ASSISTANT_DEBUG_MODE ? 'https://www.obituary-assistant.com/api/rest/' : 'http://dev.obituary-assistant.com/api/rest/') . 'obituaries?page=' . $page . '&_r=' . rand(),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => $headers,
      CURLOPT_SSL_VERIFYPEER => OBITUARY_ASSISTANT_VERIFYPEER,
      CURLOPT_FORBID_REUSE => false,
      CURLOPT_FRESH_CONNECT =>  false,
      CURLOPT_HTTP_VERSION =>  CURL_HTTP_VERSION_1_1
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    $decoded_api_response = json_decode($response, true);

    update_option('fhw-solutions-elements', $decoded_api_response["CLIENT_ELEMENTS"]);

    if (isset($decoded_api_response['UPDATE_PW'])) {
       $options_1 = get_option('fhw-solutions-obituaries_1');
       $options_1['password'] = $decoded_api_response['UPDATE_PW'];
       update_option('fhw-solutions-obituaries_1', $options_1);
    }

    return $decoded_api_response;
 }

 function obituary_assistant_get_recent_obits()
 {
    $options = get_option('fhw-solutions-obituaries_1');
    $username = $options['username'];
    $password = $options['password'];

    $page = 1;
    $headers = array(
      'Authorization: Basic '.base64_encode($username . ':' . $password),
      'OA-Version: ' . get_option('oa-version')
    );

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => (!OBITUARY_ASSISTANT_DEBUG_MODE ? 'https://www.obituary-assistant.com/api/rest/' : 'http://dev.obituary-assistant.com/api/rest/') . 'obituaries?page=' . $page . '&_r=' . rand(),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => $headers,
      CURLOPT_SSL_VERIFYPEER => OBITUARY_ASSISTANT_VERIFYPEER,
      CURLOPT_FORBID_REUSE => false,
      CURLOPT_FRESH_CONNECT =>  false,
      CURLOPT_HTTP_VERSION =>  CURL_HTTP_VERSION_1_1
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    $decoded_api_response = json_decode($response, true);

    return $decoded_api_response;


 }

 function obituary_assistant_show_recent_obits($attr)
 {

    $count = (is_array($attr) && array_key_exists('count', $attr)) ? $attr['count'] : 5;
    $position = (is_array($attr) && array_key_exists('position', $attr)) ? $attr['position'] : 'left';
    $orientation = (is_array($attr) && array_key_exists('orientation', $attr)) ? $attr['orientation'] : 'vertical';
    $obits = obituary_assistant_get_recent_obits();

    if (is_array($obits) && array_key_exists('OBITUARIES' ,$obits)){
      $obits['OBITUARIES'] = array_slice($obits['OBITUARIES'], 0, $count);

      $obituaryDateFormat = array(
        1 => 'm/d/Y',
        2 => 'd/m/Y',
        3 => 'F d, Y'
        );

      ob_start();
      include 'partials/fhw-solutions-obituaries-public-display-recent-obituaries.php';
      $buffer = ob_get_clean();
      return $buffer;
    }
 }

 //wpseo title override
 function remove_wpseo() {
   global $post;

   if (is_null($post)){
	   return;
   }

   $options = get_option('fhw-solutions-obituaries_2');
   if (has_shortcode( $post->post_content, 'obituaries')) {
     remove_filter( 'pre_get_document_title', 'elegant_titles_filter' );
   }
 }

 // all in one seo title and meta override
 function aioseo_disable_page_output( $disabled ) {
   global $post;

   if (is_null($post)){
	   return;
   }

   if (has_shortcode( $post->post_content, 'obituaries')) {
     return true;
   }
   return false;
}

 // divi meta override
 function aioseo_disable_term_title_rewrites( $disabled ) {
   global $post;

   if (is_null($post)){
	   return;
   }

   if (has_shortcode( $post->post_content, 'obituaries')) {
     return true;
   }
   return false;
 }

 // the7 theme meta and title override
 function presscore_opengraph_tags() {
   return;
 }

 // yoast meta override
 function fhw_disable_yoast_seo_frontend() {
   $get_page = explode('/', trim( $_SERVER[ 'REQUEST_URI' ], '/' ));
   $options = get_option('fhw-solutions-obituaries_2');
   if(isset($options['obituary_page_name'])){
     if ($get_page[0] == $options['obituary_page_name']){
       if( is_admin() || !defined('WPSEO_VERSION') ) return;
       $loader = \YoastSEO()->classes->get( \Yoast\WP\SEO\Loader::class );
       remove_action( 'init', [ $loader, 'load_integrations' ] );
       remove_action( 'rest_api_init', [ $loader, 'load_routes' ] );
    }
  }
}

function obituary_assistant_get_obituary_from_api($obit_id) {

    if ($obit_id == 'obituary-submission') {
        return true;
    }

    $options = get_option('fhw-solutions-obituaries_1');
    $username = $options['username'];
    $password = $options['password'];

    if (session_status() == PHP_SESSION_ACTIVE) {
        if(!isset($_SESSION)) {
            session_start();
        }
    }

    $headers = array(
        'Authorization: Basic '.base64_encode($username . ':' . $password),
        'OA-Version: ' . get_option('oa-version')
    );
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => (!OBITUARY_ASSISTANT_DEBUG_MODE ? 'https://www.obituary-assistant.com/api/rest/' : 'http://dev.obituary-assistant.com/api/rest/') . 'obituaries?obit_string=' . $obit_id . '&_r=' . rand(),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => $headers,
      CURLOPT_SSL_VERIFYPEER => OBITUARY_ASSISTANT_VERIFYPEER,
      CURLOPT_FORBID_REUSE => false,
      CURLOPT_FRESH_CONNECT =>  false,
      CURLOPT_HTTP_VERSION =>  CURL_HTTP_VERSION_1_1
    ));
    $response = curl_exec($curl);
    curl_close($curl);

    $jsonString = json_decode($response, true);

    if (isset($jsonString["CLIENT_ELEMENTS"])) {
      update_option('fhw-solutions-elements', $jsonString["CLIENT_ELEMENTS"]);
    }

    if (!isset($jsonString["OBITUARIES"])) {
        obituary_assistant_throw_404();
        die();
    } else {
        $headers = array(
            'Authorization: Basic '.base64_encode($username . ':' . $password),
            'OA-Version: ' . get_option('oa-version')
        );
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => (!OBITUARY_ASSISTANT_DEBUG_MODE ? 'https://www.obituary-assistant.com/api/rest/' : 'http://dev.obituary-assistant.com/api/rest/') . 'music?obit_id='.$jsonString["OBITUARIES"]["ID"],
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => $headers,
          CURLOPT_SSL_VERIFYPEER => OBITUARY_ASSISTANT_VERIFYPEER,
          CURLOPT_FORBID_REUSE => false,
          CURLOPT_FRESH_CONNECT =>  false,
          CURLOPT_HTTP_VERSION =>  CURL_HTTP_VERSION_1_1
        ));
        $music_api_response = curl_exec($curl);
        curl_close($curl);

        $jsonString["OBITUARIES"]["MUSIC"] = json_decode($music_api_response, true);

        remove_action('wp_head', 'rel_canonical');

        add_action('wp_head', function () use ($jsonString) {
            obituary_assistant_rel_canonical_with_custom_tag_override($jsonString);
        }, 10);

        add_action('wp_head', function () use ($jsonString) {
            obituary_assistant_my_facebook_tags($jsonString);
        }, 11);

        // delivery address for flowers
        $_SESSION['florist-one-flower-delivery-recipient-name'] = $jsonString['OBITUARIES']['FIRST_NAME'] . ' ' . $jsonString['OBITUARIES']['MIDDLE_NAME'] . ' ' . $jsonString['OBITUARIES']['LAST_NAME'];
        $_SESSION['florist-one-flower-delivery-tree-certificate-name-of-loved-one'] = $jsonString['OBITUARIES']['FIRST_NAME'] . ' ' . $jsonString['OBITUARIES']['MIDDLE_NAME'] . ' ' . $jsonString['OBITUARIES']['LAST_NAME'];
        $_SESSION['florist-one-flower-delivery-recipient-institution'] = $jsonString['OBITUARIES']['FUNERAL_HOME_NAME'];
        $_SESSION['florist-one-flower-delivery-recipient-address-1'] = $jsonString['OBITUARIES']['FUNERAL_HOME_ADDR1'];
        $_SESSION['florist-one-flower-delivery-recipient-city'] = $jsonString['OBITUARIES']['FUNERAL_HOME_CITY'];
        $_SESSION['florist-one-flower-delivery-recipient-state'] = $jsonString['OBITUARIES']['FUNERAL_HOME_STATE'];
        $_SESSION['florist-one-flower-delivery-recipient-country'] = $jsonString['OBITUARIES']['FUNERAL_HOME_COUNTRY'];
        $_SESSION['florist-one-flower-delivery-recipient-phone'] = $jsonString['OBITUARIES']['FUNERAL_HOME_PHONE'];
        if (preg_match("(^\d{5}$)", $jsonString['OBITUARIES']['FUNERAL_HOME_ZIPCODE']) > 0 || preg_match("(^[A-Za-z]{1}\d{1}[A-Za-z]{1} *\d{1}[A-Za-z]{1}\d{1}$)", $jsonString['OBITUARIES']['FUNERAL_HOME_ZIPCODE']) > 0){
            $_SESSION['florist-one-flower-delivery-recipient-postal-code'] = $jsonString['OBITUARIES']['FUNERAL_HOME_ZIPCODE'];
        }
        else {
            $_SESSION['florist-one-flower-delivery-recipient-postal-code'] = '11779';
        }
        $_SESSION['florist-one-flower-delivery-facility-id'] = $jsonString['CLIENT_INFO']['CLIENT_FACILITY_ID'];
    }

    return $jsonString;
}

 function obituary_assistant_search_for_obit($searchString)
 {
    $options = get_option('fhw-solutions-obituaries_1');
    $username = $options['username'];
    $password = $options['password'];

    if (strlen($searchString) != 0) {

      $headers = array(
      'Authorization: Basic '.base64_encode($username . ':' . $password),
      'OA-Version: ' . get_option('oa-version')
      );

      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => (!OBITUARY_ASSISTANT_DEBUG_MODE ? 'https://www.obituary-assistant.com/api/rest/' : 'http://dev.obituary-assistant.com/api/rest/') . 'obituaries?_r=' . rand() . '&search=' . rawurlencode($searchString),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_SSL_VERIFYPEER => OBITUARY_ASSISTANT_VERIFYPEER,
        CURLOPT_FORBID_REUSE => false,
        CURLOPT_FRESH_CONNECT =>  false,
        CURLOPT_HTTP_VERSION =>  CURL_HTTP_VERSION_1_1
      ));

      $response = curl_exec($curl);
      curl_close($curl);

      $jsonString = json_decode($response, true);

    } else {
      $jsonString = obituary_assistant_get_obituaries_from_api(1);
    }

    include 'partials/oa-all-obituaries.php';

    die();
 }

 function obituary_assistant_add_custom_font_css($font){

   switch($font){
     case 0:
      $font_family = "";
      $custom_css = "";
      break;
     case 1:
      $font_family = "'Georgia, serif";
      $custom_css = "<style>" .
        ".obit_listing .obit_name, .obit_main .obit_name_and_date h2, .obit_main .obit_body h3, .obit_main .obit_name_and_date h4 { font-family: " . $font_family . " }" .
        "</style>";
      break;
     case 2:
      $font_family = "\"Palatino Linotype\", \"Book Antiqua\", Palatino, serif";
      $custom_css = "<style>" .
        ".obit_listing .obit_name, .obit_main .obit_name_and_date h2, .obit_main .obit_body h3, .obit_main .obit_name_and_date h4 { font-family: " . $font_family . " }" .
        "</style>";
      break;
     case 3:
      $font_family = "\"Times New Roman\", Times, serif";
      $custom_css = "<style>" .
        ".obit_listing .obit_name, .obit_main .obit_name_and_date h2, .obit_main .obit_body h3, .obit_main .obit_name_and_date h4 { font-family: " . $font_family . " }" .
        "</style>";
      break;
     case 4:
      $font_family = "Arial, Helvetica, sans-serif";
      $custom_css = "<style>" .
        ".obit_listing .obit_name, .obit_main .obit_name_and_date h2, .obit_main .obit_body h3, .obit_main .obit_name_and_date h4 { font-family: " . $font_family . " }" .
        "</style>";
      break;
     case 5:
      $font_family = "\"Arial Black\", Gadget, sans-serif";
      $custom_css = "<style>" .
        ".obit_listing .obit_name, .obit_main .obit_name_and_date h2, .obit_main .obit_body h3, .obit_main .obit_name_and_date h4 { font-family: " . $font_family . " }" .
        "</style>";
      break;
     case 6:
      $font_family = "\"Comic Sans MS\", cursive, sans-serif";
      $custom_css = "<style>" .
        ".obit_listing .obit_name, .obit_main .obit_name_and_date h2, .obit_main .obit_body h3, .obit_main .obit_name_and_date h4 { font-family: " . $font_family . " }" .
        "</style>";
      break;
     case 7:
      $font_family = "Impact, Charcoal, sans-serif";
      $custom_css = "<style>" .
        ".obit_listing .obit_name, .obit_main .obit_name_and_date h2, .obit_main .obit_body h3, .obit_main .obit_name_and_date h4 { font-family: " . $font_family . " }" .
        "</style>";
      break;
     case 8:
      $font_family = "\"Lucida Sans Unicode\", \"Lucida Grande\", sans-serif";
      $custom_css = "<style>" .
        ".obit_listing .obit_name, .obit_main .obit_name_and_date h2, .obit_main .obit_body h3, .obit_main .obit_name_and_date h4 { font-family: " . $font_family . " }" .
        "</style>";
      break;
     case 9:
      $font_family = "Tahoma, Geneva, sans-serif";
      $custom_css = "<style>" .
        ".obit_listing .obit_name, .obit_main .obit_name_and_date h2, .obit_main .obit_body h3, .obit_main .obit_name_and_date h4 { font-family: " . $font_family . " }" .
        "</style>";
      break;
     case 10:
      $font_family = "\"Trebuchet MS\", Helvetica, sans-serif";
      $custom_css = "<style>" .
        ".obit_listing .obit_name, .obit_main .obit_name_and_date h2, .obit_main .obit_body h3, .obit_main .obit_name_and_date h4 { font-family: " . $font_family . " }" .
        "</style>";
      break;
     case 11:
      $font_family = "Verdana, Geneva, sans-serif";
      $custom_css = "<style>" .
        ".obit_listing .obit_name, .obit_main .obit_name_and_date h2, .obit_main .obit_body h3, .obit_main .obit_name_and_date h4 { font-family: " . $font_family . " }" .
        "</style>";
      break;
     case 12:
      $font_family = "\"Courier New\", Courier, monospace";
      $custom_css = "<style>" .
        ".obit_listing .obit_name, .obit_main .obit_name_and_date h2, .obit_main .obit_body h3, .obit_main .obit_name_and_date h4 { font-family: " . $font_family . " }" .
        "</style>";
      break;
     case 13:
      $font_family = "\"Lucida Console\", Monaco, monospace";
      $custom_css = "<style>" .
        ".obit_listing .obit_name, .obit_main .obit_name_and_date h2, .obit_main .obit_body h3, .obit_main .obit_name_and_date h4 { font-family: " . $font_family . " }" .
        "</style>";
      break;
     case 14:
      $font_family = "'Great Vibes', cursive";
      $custom_css = "<link href=\"https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap\" rel=\"stylesheet\">".
        "<style>" .
        ".obit_listing .obit_name, .obit_main .obit_name_and_date h2, .obit_main .obit_body h3 { font-family: " . $font_family . " }" .
        "</style>";
      break;
     default:
      $font_family = "";
      $custom_css = "";
      break;
   }

   echo $custom_css;

 }

 function obituary_assistant_share_obituary($client_id, $obit_id, $type, $address, $url){

    $options = get_option('fhw-solutions-obituaries_1');
    $username = $options['username'];
    $password = $options['password'];

    $data = array(
        'client_id' => sanitize_text_field($client_id),
        'obit_id' => sanitize_text_field($obit_id),
        'type' => sanitize_text_field($type),
        'address' => sanitize_text_field($address),
        'url' => sanitize_text_field($url)
    );

    $headers = array(
        'Authorization: Basic '.base64_encode($username . ':' . $password),
        'OA-Version: ' . get_option('oa-version')
    );
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => (!OBITUARY_ASSISTANT_DEBUG_MODE ? 'https://www.obituary-assistant.com/api/rest/' : 'http://dev.obituary-assistant.com/api/rest/') . 'shareObituary',
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
    $response = curl_exec($curl);
    curl_close($curl);

    echo $response;

    die();

 }

 function obituary_assistant_add_photo($photosData, $obit_id){

    $options = get_option('fhw-solutions-obituaries_1');
    $username = $options['username'];
    $password = $options['password'];

    $data = array(
      'photosData' => sanitize_text_field($photosData)
    );

    $headers = array(
        'Authorization: Basic '.base64_encode($username . ':' . $password),
        'OA-Version: ' . get_option('oa-version')
    );
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => (!OBITUARY_ASSISTANT_DEBUG_MODE ? 'https://www.obituary-assistant.com/api/rest/' : 'http://dev.obituary-assistant.com/api/rest/') . 'addPhoto',
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
    $response = curl_exec($curl);
    curl_close($curl);

    // reload obit
    $headers = array(
      'Authorization: Basic '.base64_encode($username . ':' . $password),
      'OA-Version: ' . get_option('oa-version')
    );

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => (!OBITUARY_ASSISTANT_DEBUG_MODE ? 'https://www.obituary-assistant.com/api/rest/' : 'http://dev.obituary-assistant.com/api/rest/') . 'obituaries?obit_id=' . $obit_id . '&_r=' . rand(),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => $headers,
      CURLOPT_SSL_VERIFYPEER => OBITUARY_ASSISTANT_VERIFYPEER,
      CURLOPT_FORBID_REUSE => false,
      CURLOPT_FRESH_CONNECT =>  false,
      CURLOPT_HTTP_VERSION =>  CURL_HTTP_VERSION_1_1
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    $jsonString = json_decode($response, true);

    include 'partials/fhw-solutions-obituaries-public-display-photo-gallery.php';

    die();
 }

 function refresh_photos_and_videos($obit_id)
 {
     $options = get_option('fhw-solutions-obituaries_1');
     $username = $options['username'];
     $password = $options['password'];

     $headers = array(
       'Authorization: Basic '.base64_encode($username . ':' . $password),
       'OA-Version: ' . get_option('oa-version')
     );

     $curl = curl_init();
     curl_setopt_array($curl, array(
       CURLOPT_URL => (!OBITUARY_ASSISTANT_DEBUG_MODE ? 'https://www.obituary-assistant.com/api/rest/' : 'http://dev.obituary-assistant.com/api/rest/') . 'obituaries?obit_id=' . $obit_id . '&_r=' . rand(),
       CURLOPT_RETURNTRANSFER => true,
       CURLOPT_ENCODING => '',
       CURLOPT_MAXREDIRS => 10,
       CURLOPT_TIMEOUT => 0,
       CURLOPT_FOLLOWLOCATION => true,
       CURLOPT_CUSTOMREQUEST => 'GET',
       CURLOPT_HTTPHEADER => $headers,
       CURLOPT_SSL_VERIFYPEER => OBITUARY_ASSISTANT_VERIFYPEER,
       CURLOPT_FORBID_REUSE => false,
       CURLOPT_FRESH_CONNECT =>  false,
       CURLOPT_HTTP_VERSION =>  CURL_HTTP_VERSION_1_1
     ));

     $api_response = curl_exec($curl);
     curl_close($curl);

     $jsonString = json_decode($api_response, true);

     include 'partials/fhw-solutions-obituaries-public-display-photo-gallery.php';

     die();
}

function obituary_assistant_refresh_tributes($obit_id) {

    $options = get_option('fhw-solutions-obituaries_1');
    $username = $options['username'];
    $password = $options['password'];

    $headers = array(
      'Authorization: Basic '.base64_encode($username . ':' . $password),
      'OA-Version: ' . get_option('oa-version')
    );

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => (!OBITUARY_ASSISTANT_DEBUG_MODE ? 'https://www.obituary-assistant.com/api/rest/' : 'http://dev.obituary-assistant.com/api/rest/') . 'obituaries?obit_string=' . $obit_id . '&_r=' . rand(),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => $headers,
      CURLOPT_SSL_VERIFYPEER => OBITUARY_ASSISTANT_VERIFYPEER,
      CURLOPT_FORBID_REUSE => false,
      CURLOPT_FRESH_CONNECT =>  false,
      CURLOPT_HTTP_VERSION =>  CURL_HTTP_VERSION_1_1
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    $jsonString = json_decode($response, true);


    $tributeShow = (count((array)$jsonString["OBITUARIES"]["TRIBUTES"]) > 0) ? " & " . $jsonString['CLIENT_ELEMENTS']['PURCHASE_RECOGNITION']['oa-copy-tributes-heading']['heading'] : ""  ;
    $showTributes = $jsonString["CLIENT_NAVIGATION"]["CONDOLENCES"] . $tributeShow;
    $condolenceCount = count((array)$jsonString["OBITUARIES"]["CONDOLENCES"]) + count((array)$jsonString["OBITUARIES"]["TRIBUTES"]);

    $add_new_condolence = 0;

    echo '<span>' . $showTributes;
    echo '<span class="condolence_counter">' . (count($jsonString["OBITUARIES"]["CONDOLENCES"]) > 0) ? " (" . $condolenceCount . ")" : "" . '</span>';
    echo '<span></span>';
    echo '<h3>' . $jsonString["CLIENT_NAVIGATION"]["CONDOLENCES"] . '</h3>';
    include 'partials/fhw-solutions-obituaries-public-display-condolences.php';

    die();


}

 function obituary_assistant_add_condolence($obit_id, $type, $sender, $message, $email, $celebration_type, $ost, $osu, $ose){

    $options = get_option('fhw-solutions-obituaries_1');
    $username = $options['username'];
    $password = $options['password'];

    $data = array(
      'obit_id' => sanitize_text_field($obit_id),
       'type' => sanitize_text_field($type),
       'sender' => sanitize_text_field($sender),
       'message' => sanitize_text_field($message),
       'email' => sanitize_text_field($email),
       'celebration_type' => sanitize_text_field($celebration_type)
    );

    $headers = array(
        'Authorization: Basic '.base64_encode($username . ':' . $password),
        'OA-Version: ' . get_option('oa-version')
    );
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => (!OBITUARY_ASSISTANT_DEBUG_MODE ? 'https://www.obituary-assistant.com/api/rest/' : 'http://dev.obituary-assistant.com/api/rest/') . 'condolences',
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
    $response = curl_exec($curl);
    curl_close($curl);

    $headers = array(
      'Authorization: Basic '.base64_encode($username . ':' . $password),
      'OA-Version: ' . get_option('oa-version')
    );

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => (!OBITUARY_ASSISTANT_DEBUG_MODE ? 'https://www.obituary-assistant.com/api/rest/' : 'http://dev.obituary-assistant.com/api/rest/') . 'obituaries?obit_id=' . $obit_id . '&_r=' . rand(),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => $headers,
      CURLOPT_SSL_VERIFYPEER => OBITUARY_ASSISTANT_VERIFYPEER,
      CURLOPT_FORBID_REUSE => false,
      CURLOPT_FRESH_CONNECT =>  false,
      CURLOPT_HTTP_VERSION =>  CURL_HTTP_VERSION_1_1
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    $jsonString = json_decode($response, true);

    $userinfo = array(
     'ost' => $ost,
     'osu' => $osu,
     'ose' => $ose
    );

    $jsonString = array_merge($jsonString, $userinfo);
    $add_new_condolence = 1;

    include 'partials/fhw-solutions-obituaries-public-display-condolences.php';

    die();
 }

 function obituary_assistant_delete_condolence($obit_id, $post_id, $ost, $osu, $ose) {

      $options = get_option('fhw-solutions-obituaries_1');
      $username = $options['username'];
      $password = $options['password'];

      $data = array(
        'obit_id' => sanitize_text_field($obit_id),
        'post_id' => sanitize_text_field($post_id)
      );
      $headers = array(
        'Authorization: Basic '.base64_encode($username . ':' . $password),
        'OA-Version: ' . get_option('oa-version')
      );

      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => (!OBITUARY_ASSISTANT_DEBUG_MODE ? 'https://www.obituary-assistant.com/api/rest/' : 'http://dev.obituary-assistant.com/api/rest/') . 'condolences?obit_id=' . $obit_id . '&post_id=' . $post_id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FORBID_REUSE => false,
        CURLOPT_FRESH_CONNECT => false,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'DELETE',
        CURLOPT_POSTFIELDS => http_build_query($data),
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_SSL_VERIFYPEER => OBITUARY_ASSISTANT_VERIFYPEER
      ));
      $response = curl_exec($curl);
      curl_close($curl);

      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => (!OBITUARY_ASSISTANT_DEBUG_MODE ? 'https://www.obituary-assistant.com/api/rest/' : 'http://dev.obituary-assistant.com/api/rest/') . 'obituaries?obit_id=' . $obit_id . '&_r=' . rand(),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_SSL_VERIFYPEER => OBITUARY_ASSISTANT_VERIFYPEER,
        CURLOPT_FORBID_REUSE => false,
        CURLOPT_FRESH_CONNECT =>  false,
        CURLOPT_HTTP_VERSION =>  CURL_HTTP_VERSION_1_1
      ));

      $response = curl_exec($curl);
      curl_close($curl);

      $jsonString = json_decode($response, true);

      $userinfo = array(
        'ost' => $ost,
        'osu' => $osu,
        'ose' => $ose
      );

      $jsonString = array_merge($jsonString, $userinfo);

      $add_new_condolence = 1;
      include 'partials/fhw-solutions-obituaries-public-display-condolences.php';

      die();
 }

 function obituary_assistant_send_directions($address, $location){


      $options = get_option('fhw-solutions-obituaries_1');
      $username = $options['username'];
      $password = $options['password'];

      $headers = array(
        'Authorization: Basic '.base64_encode($username . ':' . $password),
        'OA-Version: ' . get_option('oa-version')
      );

      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => (!OBITUARY_ASSISTANT_DEBUG_MODE ? 'https://www.obituary-assistant.com/api/rest/' : 'http://dev.obituary-assistant.com/api/rest/') . 'sendDirections?address=' . str_replace( ' ', '%20', $address) . '&location='.str_replace( ' ', '%20', $location),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_SSL_VERIFYPEER => OBITUARY_ASSISTANT_VERIFYPEER,
        CURLOPT_FORBID_REUSE => false,
        CURLOPT_FRESH_CONNECT =>  false,
        CURLOPT_HTTP_VERSION =>  CURL_HTTP_VERSION_1_1
      ));

      $api_response = curl_exec($curl);
      curl_close($curl);

      $jsonString = json_decode($api_response, true);

      echo $api_response;

      die();

 }

 function obituary_assistant_refresh_condolences($obit_id, $ost, $osu, $ose)
 {
    $options = get_option('fhw-solutions-obituaries_1');
    $username = $options['username'];
    $password = $options['password'];

    $headers = array(
      'Authorization: Basic '.base64_encode($username . ':' . $password),
      'OA-Version: ' . get_option('oa-version')
    );

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => (!OBITUARY_ASSISTANT_DEBUG_MODE ? 'https://www.obituary-assistant.com/api/rest/' : 'http://dev.obituary-assistant.com/api/rest/') . 'obituaries?obit_id=' . $obit_id . '&_r=' . rand(),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => $headers,
      CURLOPT_SSL_VERIFYPEER => OBITUARY_ASSISTANT_VERIFYPEER,
      CURLOPT_FORBID_REUSE => false,
      CURLOPT_FRESH_CONNECT =>  false,
      CURLOPT_HTTP_VERSION =>  CURL_HTTP_VERSION_1_1
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    $jsonString = json_decode($response, true);
     $userinfo = array(
     'ost' => $ost,
     'osu' => $osu,
     'ose' => $ose
   );

     $jsonString = array_merge($jsonString, $userinfo);

     $add_new_condolence = 1;
     include 'partials/fhw-solutions-obituaries-public-display-condolences.php';

     die();
 }

 function obituary_assistant_create_obituaries($jsonString)
 {
     include 'partials/oa-all-obituaries.php';
     include 'partials/fhw-solutions-obituaries-dialog-box-1.php';
     include 'partials/fhw-solutions-obituaries-dialog-box-2.php';
 }

function obituaries_email_subscription()
{

	ob_start();
    $jsonString = obituary_assistant_get_obituaries_from_api(1);

    echo '<div style="text-align:center">';
    echo '<form id="fhws-subscribe-widget">';
    echo '<h3>' . $jsonString["CLIENT_ELEMENTS"]["SUBSCRIBE_TO_CLIENT_LINK"] . '</h3>';
    echo '<p>' . $jsonString["CLIENT_ELEMENTS"]["SUBSCRIBE_TO_CLIENT_POPUP_EXPLANATION"] . '</p>';
    echo '<div id="fhws-subscrbe-inner" style="display:flex; align-items: center; justify-content: center; gap: 10px; flex-wrap:wrap;">';
    echo '<input style="max-width:350px;" type="email" name="fhws-subscribe-widget-email" id="fhws-subscribe-widget-email" aria-describedby="nameInput" placeholder="' . $jsonString["CLIENT_ELEMENTS"]["EMAIL"] . '" >';
    echo '<div id="fhws-subscribe-captcha"></div>';
    echo '<button type="button" id="fhws-subscribe-widget-submit">' . $jsonString["CLIENT_ELEMENTS"]["PHOTO_BUTTON_1"] . '</button>';
    echo '</div>';
    echo '</form>';
    echo '<div id="fhws-subscribe-widget-message"></div>';
    echo '</div>';

	$buffer = ob_get_clean();
    return $buffer;
}

 function obituary_assistant_create_flower_storefront()
 {
     $htmlString = '';
     $htmlString = $htmlString . init_flower_delivery('obit');
     return $htmlString;
 }


 function obituary_assistant_create_obituary($jsonString)
 {
     include 'partials/fhw-solutions-obituaries-public-display.php';

 }

 function obituary_assistant_submit_obituary($client_id)
 {

    $fh_info = get_option('fhw-solutions-obituaries_1');

    $visitorIdentifyingId = base64_encode(
      json_encode(
        array(
          'client_id' => $client_id,
          'email_address' => '',
          'whiteLabel' => true,
          'mode' => $fh_info['mode']
        )
      )
    );
    include 'partials/fhw-solutions-obituaries-obituary-submission.php';

 }

 function obituary_assistant_show_obituaries($attr)
 {
     ob_start();
     $options = get_option('fhw-solutions-obituaries_1');

     $obituaryDateFormat = array(
          1 => 'm/d/Y',
          2 => 'd/m/Y',
          3 => 'F d, Y'
    );
     $htmlString = '';

     if ($options['username'] != '' && $options['username'] != 'fhws_sample') {
         if (get_query_var('id') != '' && ! is_numeric(get_query_var('id'))) {
           if (get_query_var('id') == 'obituary-submission'){
             $jsonString = obituary_assistant_get_obituaries_from_api(get_option('fhw-solutions-obituaries_1')["id"]);
             $htmlString .= obituary_assistant_submit_obituary(get_option('fhw-solutions-obituaries_1')["id"]);
           }
           else {
             $jsonString = obituary_assistant_get_obituary_from_api(get_query_var('id'));
             $jsonString['OBITUARIES']['BORN_DATE'] = $jsonString['OBITUARIES']['BORN_DATE']?date($obituaryDateFormat[$jsonString['CLIENT_CONFIG']['FULL_OBITS_DATE']], strtotime($jsonString['OBITUARIES']['BORN_DATE'])):'';
             $jsonString['OBITUARIES']['DIED_DATE'] = $jsonString['OBITUARIES']['DIED_DATE']?date($obituaryDateFormat[$jsonString['CLIENT_CONFIG']['FULL_OBITS_DATE']], strtotime($jsonString['OBITUARIES']['DIED_DATE'])):'';
             $htmlString .= obituary_assistant_add_custom_font_css($jsonString["CLIENT_CONFIG"]["FONT"]);
             $htmlString .= obituary_assistant_create_obituary($jsonString);
           }
         } elseif (get_query_var('id') != '' && is_numeric(get_query_var('id'))) {
             $page = get_query_var('id');
             $jsonString = obituary_assistant_get_obituaries_from_api($page);
             foreach ($jsonString['OBITUARIES'] as $key => $obituary) {
                 $jsonString['OBITUARIES'][$key]['BORN_DATE'] = $obituary['BORN_DATE']?date($obituaryDateFormat[$jsonString['CLIENT_CONFIG']['FULL_OBITS_DATE']], strtotime($obituary['BORN_DATE'])):'';
                 $jsonString['OBITUARIES'][$key]['DIED_DATE'] = $obituary['DIED_DATE']?date($obituaryDateFormat[$jsonString['CLIENT_CONFIG']['FULL_OBITS_DATE']], strtotime($obituary['DIED_DATE'])):'';
             }
             $jsonString["current_page"] = $page;
             $htmlString .= obituary_assistant_add_custom_font_css($jsonString["CLIENT_CONFIG"]["FONT"]);
             $htmlString .= obituary_assistant_create_obituaries($jsonString);
         } else {
             $page = 1;
             $jsonString = obituary_assistant_get_obituaries_from_api($page);

             foreach ($jsonString['OBITUARIES'] as $key => $obituary) {
                 $jsonString['OBITUARIES'][$key]['BORN_DATE'] = $obituary['BORN_DATE']?date($obituaryDateFormat[$jsonString['CLIENT_CONFIG']['FULL_OBITS_DATE']], strtotime($obituary['BORN_DATE'])):'';
                 $jsonString['OBITUARIES'][$key]['DIED_DATE'] = $obituary['DIED_DATE']?date($obituaryDateFormat[$jsonString['CLIENT_CONFIG']['FULL_OBITS_DATE']], strtotime($obituary['DIED_DATE'])):'';
             }
             $jsonString["current_page"] = $page;
             $htmlString .= obituary_assistant_add_custom_font_css($jsonString["CLIENT_CONFIG"]["FONT"]);
             $htmlString .= obituary_assistant_create_obituaries($jsonString);
         }

         if (get_query_var('id') != 'obituary-submission'){
           // update fh info from fhws and put in options ( in case it changed )
           $updated_fh_info = get_option('fhw-solutions-obituaries_1');
           $updated_fh_info['id'] = $jsonString["CLIENT_INFO"]["ID"];
           $updated_fh_info['funeral_home_name'] = $jsonString["CLIENT_INFO"]["NAME"];
           $updated_fh_info['funeral_home_address'] = $jsonString["CLIENT_INFO"]["ADDRESS1"];
           $updated_fh_info['funeral_home_city'] = $jsonString["CLIENT_INFO"]["CITY"];
           $updated_fh_info['funeral_home_state'] = $jsonString["CLIENT_INFO"]["STATE"];
           $updated_fh_info['funeral_home_zip'] = $jsonString["CLIENT_INFO"]["ZIP"];
           $updated_fh_info['funeral_home_country'] = $jsonString["CLIENT_INFO"]["COUNTRY"];
           $updated_fh_info['funeral_home_phone'] = $jsonString["CLIENT_INFO"]["PHONE"];
           $updated_fh_info['mode'] = $jsonString["CLIENT_INFO"]["MODE"];
           $updated_fh_info['funeral_home_locations'] = $jsonString["CLIENT_INFO"]["LOCATIONS"];
           $updated_fh_info['account_type'] = $jsonString["CLIENT_INFO"]["CLIENT_ACCOUNT_TYPE"];
           $updated_fh_info['stripe_connect_account_id'] = $jsonString["CLIENT_INFO"]["STRIPE_CONNECT_ACCOUNT_ID"];
           $updated_fh_info['affiliate_id'] = $jsonString["CLIENT_INFO"]["AFFILIATE_ID"];
           update_option('fhw-solutions-obituaries_1', $updated_fh_info);
         }

     } else {
         // no username
         $htmlString .= '<p>Please Sign In To Obituary Assistant Plugin</p>';
     }

     echo $htmlString;

     $output = ob_get_clean();

     $title = array();
     $title['site'] = $jsonString["CLIENT_INFO"]["NAME"];

     if (get_query_var('id') != '' && !is_numeric(get_query_var('id')) && get_query_var('id') != 'obituary-submission') {
       $title['title'] = $jsonString['CLIENT_ELEMENTS']['INDIVIDUAL_OBITUARY_TITLE'];
       $title['title'] = str_replace(
         "<NAME>",
         $jsonString["OBITUARIES"]["FIRST_NAME"] . ' ' .
         $jsonString["OBITUARIES"]["MIDDLE_NAME"] . ' ' .
         $jsonString["OBITUARIES"]["LAST_NAME"],
         $title['title']
       );
     }
     else {
       $title['title'] = $jsonString['CLIENT_ELEMENTS']['MAIN_OBITUARIES_TITLE'];
     }

     $title['title'] = str_replace(
       "<CITY>",
       $jsonString["CLIENT_INFO"]["CITY"],
       $title['title']
     );

     $title['title'] = str_replace(
       "<FH_NAME>",
       $jsonString["CLIENT_INFO"]["NAME"],
       $title['title']
     );

     $result = array(
       "output" => $output,
       "title" => $title['title']
     );

     return $result;
 }

  function obituary_assistant_check_captcha($captchaSelection)
  {
      session_start();

      if (isset($_SESSION['simpleCaptchaAnswer']) && $captchaSelection == $_SESSION['simpleCaptchaAnswer']) {
          echo json_encode(
            array(
              "human" => true
          )
        );
      } else {
          echo json_encode(
            array(
              "human" => false
          )
        );
      }

      die();
  }

  function obituary_assistant_my_facebook_tags($jsonString)
  {
      ?>
        <meta property="og:title" content="<?php echo htmlspecialchars($jsonString["OBITUARIES"]["FIRST_NAME"] . ' ' . $jsonString["OBITUARIES"]["MIDDLE_NAME"] . ' ' . $jsonString["OBITUARIES"]["LAST_NAME"] . ' ' . $jsonString["CLIENT_ELEMENTS"]["OBITUARY_SINGULAR"]) ?>" />
        <meta property="og:site_name" content="<?php htmlspecialchars($jsonString["CLIENT_INFO"]["NAME"]) ?>" />
        <meta property="og:description" content="<?php echo htmlspecialchars(strip_tags($jsonString["OBITUARIES"]["OBIT_TEXT_OG_META"])) ?>" />
        <meta property="og:type" content="article" />
        <meta property="og:image" content="<?php echo $jsonString["OBITUARIES"]["IMAGE_S3"]; ?>" />
        <meta property="og:image:alt" content="<?php echo htmlspecialchars($jsonString["OBITUARIES"]["FIRST_NAME"] . ' ' . $jsonString["OBITUARIES"]["MIDDLE_NAME"] . ' ' . $jsonString["OBITUARIES"]["LAST_NAME"]) ?>" />
        <meta property="og:image:width" content="200" />
        <meta property="og:image:height" content="300" />
        <meta property="og:url" content="<?php echo (substr(get_permalink(), -1) == '/' ? get_permalink() : get_permalink() . '/' ) . $jsonString["OBITUARIES"]["OBIT_URL_REWRITE"] . '/'; ?>" />
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:title" content="<?php echo htmlspecialchars($jsonString["OBITUARIES"]["FIRST_NAME"] . ' ' . $jsonString["OBITUARIES"]["MIDDLE_NAME"] . ' ' . $jsonString["OBITUARIES"]["LAST_NAME"] . ' ' . $jsonString["CLIENT_ELEMENTS"]["OBITUARY_SINGULAR"]) ?>" />
        <meta name="twitter:description" content="<?php echo htmlspecialchars(strip_tags($jsonString["OBITUARIES"]["OBIT_TEXT_OG_META"])) ?>" />
        <meta name="twitter:image" content="<?php echo $jsonString["OBITUARIES"]["IMAGE_S3"]; ?>" />
      <?php
  }

  function obituary_assistant_rel_canonical_with_custom_tag_override($jsonString)
  {
      $link = get_permalink() . $jsonString["OBITUARIES"]["OBIT_URL_REWRITE"] . '/';
      echo "<link rel='canonical' href='" . esc_url($link) . "' />\n";
  }

  function obituary_assistant_create_obituaries_rule()
  {
      $config_options = get_option('fhw-solutions-obituaries_2');
      $outputString = '';

      if (isset($config_options['obituary_page_name'])){

        for ($i=0; $i < strlen($config_options['obituary_page_name']); $i++) {
            $outputString = $outputString . '['. strtoupper($config_options['obituary_page_name'][$i]) . strtolower($config_options['obituary_page_name'][$i]) . ']';
        }
        add_rewrite_rule('' . $outputString . '/([^/]+)/?$', 'index.php?pagename=' . $config_options['obituary_page_name'] . '&id=$matches[1]', 'top');
      }

  }


  function obituary_assistant_add_to_query_params($query_vars)
  {
      $query_vars[] = 'id';
      return $query_vars;
  }

  function get_qr_code($url)
  {
      $options = get_option('fhw-solutions-obituaries_1');
      $username = $options['username'];
      $password = $options['password'];

      $headers = array(
      'Authorization: Basic '.base64_encode($username . ':' . $password),
      'OA-Version: ' . get_option('oa-version')
      );

      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => (!OBITUARY_ASSISTANT_DEBUG_MODE ? 'https://www.obituary-assistant.com/api/rest/' : 'http://dev.obituary-assistant.com/api/rest/') . 'qrCode?url=' . $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_SSL_VERIFYPEER => OBITUARY_ASSISTANT_VERIFYPEER,
        CURLOPT_FORBID_REUSE => false,
        CURLOPT_FRESH_CONNECT =>  false,
        CURLOPT_HTTP_VERSION =>  CURL_HTTP_VERSION_1_1
      ));

      $response = curl_exec($curl);
      curl_close($curl);

      $jsonString = json_decode($response, true);

      if (!isset($jsonString['errors']) && isset($jsonString['IMAGELINK'])) {
          return '<img src="' . $jsonString['IMAGELINK'] . '" class="w-100" title="This is a QR code. It can be scanned by your smartphone and will take you directly to this obituary. You can also save this QR code image for later use (adding to print documents, sending to friends &amp; family, etc) by clicking on it." />';
      } else {
          return false;
      }
  }

  function obituary_assistant_subscribe_to_obituary($obit_id, $address)
  {
      $options = get_option('fhw-solutions-obituaries_1');
      $username = $options['username'];
      $password = $options['password'];

      $data = array(
        'subscription_type' => 'obit',
        'subscription_id' => sanitize_text_field($obit_id),
        'value' => sanitize_text_field($address)
      );

      $headers = array(
        'Authorization: Basic '.base64_encode($username . ':' . $password),
        'OA-Version: ' . get_option('oa-version')
      );

      $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => (!OBITUARY_ASSISTANT_DEBUG_MODE ? 'https://www.obituary-assistant.com/api/rest/' : 'http://dev.obituary-assistant.com/api/rest/') . 'subscriptions',
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

      $jsonString = json_decode($api_response, true);

      echo $api_response;

      die();

  }

  function obituary_assistant_subscribe_to_client($address)
  {
      $options = get_option('fhw-solutions-obituaries_1');
      $username = $options['username'];
      $password = $options['password'];

      $data = array(
		  'subscription_type' => 'client',
		  'value' => sanitize_text_field($address)
      );

      $headers = array(
        'Authorization: Basic '.base64_encode($username . ':' . $password),
        'OA-Version: ' . get_option('oa-version')
      );

      $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => (!OBITUARY_ASSISTANT_DEBUG_MODE ? 'https://www.obituary-assistant.com/api/rest/' : 'http://dev.obituary-assistant.com/api/rest/') . 'subscriptions',
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

      $jsonString = json_decode($api_response, true);

      echo $api_response;

      die();

  }

  function obituary_assistant_submit_useful_link($data)
  {
      $options = get_option('fhw-solutions-obituaries_1');
      $username = $options['username'];
      $password = $options['password'];

      $headers = array(
        'Authorization: Basic '.base64_encode($username . ':' . $password),
        'OA-Version: ' . get_option('oa-version')
      );

      $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => (!OBITUARY_ASSISTANT_DEBUG_MODE ? 'https://www.obituary-assistant.com/api/rest/' : 'http://dev.obituary-assistant.com/api/rest/') . 'useful_links/contact',
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

      $jsonString = json_decode($api_response, true);

      echo $api_response;

      die();

  }

  function obituary_assistant_new_obituary_alerts_button()
  {
      include 'partials/fhw-solutions-obituaries-dialog-box-1.php';
      return '<a href="#" id="subscribe_to_client" class="subscribe_to_client">Subscribe to New Obituary Alerts</a>';
  }

  function obituary_assistant_throw_404()
  {
      global $wp_query;
      $wp_query->set_404();
      add_action('wp_title', function () {
          return '404: Not Found';
      }, 9999);
      status_header(404);
      nocache_headers();
      exit;
  }

  function setObitData($value) {
      global $obitData;
      $obitData = $value;
      return true;
  }

  function getObitData() {
      global $obitData;
      return $obitData;
  }

  add_action( 'template_redirect', 'remove_wpseo' );
  add_filter( 'aioseo_disable', 'aioseo_disable_page_output' );
  add_filter( 'aioseo_disable_title_rewrites', 'aioseo_disable_term_title_rewrites' );
  add_action( 'wp_head', 'presscore_opengraph_tags' );
  add_action( 'plugins_loaded', 'fhw_disable_yoast_seo_frontend' );
  add_action('init', 'obituary_assistant_create_obituaries_rule');
  add_action('query_vars', 'obituary_assistant_add_to_query_params');

  // obituaries shortcode rewritten to run before title tag is rendered
  add_filter( 'pre_get_document_title', function( $title ) {
      global $post;
      if ( ! $post || ! $post->post_content ) {
          return $title;
      }
      if ( preg_match( '#\[obituaries.*\]#', $post->post_content, $matches ) !== 1 ) {
          return '';
      }
      return do_shortcode( '[obituaries]' );
  } );

  add_shortcode( 'obituaries', function( $atts ) {

      global $post;

      if (is_null($post)){
        return $title;
      }

      if (has_shortcode( $post->post_content, 'obituaries')) {

        if ( ! doing_filter( 'pre_get_document_title' ) ) {
            // return obituary page content from variable

            if (strlen(getObitData()["output"]) == 0){
              $obitDatab = obituary_assistant_show_obituaries($atts);
              setObitData($obitDatab);
            }

            return getObitData()["output"];
        }

        else {
          // get obits via api and set variable for use in title without running api twice

          if (strlen(getObitData()["output"]) == 0){
            $obitDatab = obituary_assistant_show_obituaries($atts);
            setObitData($obitDatab);
          }

          // return custom title
          return getObitData()["title"];
        }

      }

  } );

  add_shortcode('OBITUARY_SUBSCRIPTION', 'obituaries_email_subscription');
  add_shortcode('recent-obituaries', 'obituary_assistant_get_recent_obits');
  add_shortcode('obituary-assistant-subscribe-to-client', 'obituary_assistant_new_obituary_alerts_button');
  add_shortcode('obituary-assistant-show-recent-obituaries', 'obituary_assistant_show_recent_obits');

 ?>
