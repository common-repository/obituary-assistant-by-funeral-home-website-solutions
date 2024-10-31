<?php

  /**
   * @link       https://www.obituary-assistant.com
   * @since      7.2.0
   *
   * @package    Fhw_Solutions_Obituaries
   * @subpackage Fhw_Solutions_Obituaries/public/partials
   */

    $page = $jsonString["current_page"];

    include plugin_dir_path( dirname( __FILE__ ) ) . 'oa-display.php';
    $oa_display = new OA_Display();

    ?>

<style>
  .modal-backdrop {
    z-index:1 !important;
 }
</style>

<?php
  $searchIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
  <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
</svg></span>';

  $elements = get_option('fhw-solutions-elements');
  $fh_info = get_option('fhw-solutions-obituaries_1');

  $obituarySubmissionLink = '<a href="' . home_url() . '/' . get_option('fhw-solutions-obituaries_2')['obituary_page_name'] . '/obituary-submission">' . $elements["SUBMIT_AN_OBITUARY"] . '</a>';

?>

<div class="fhw-solutions-obituaries_all-obituary-listings bootstrap-fhws-obituaries-container p-2">
  <!-- subscribe and search -->
  <div class="row mb-4 justify-content-end">
    <div class="col-md-6 text-end">
      <a href="#" id="subscribe_to_client" data-modal-action="Subscribe to Obits" data-bs-toggle="modal" data-bs-target="#fhws-share-subscribe-modal"  class="subscribe_to_client text-decoration-none mb-2"><?php echo $jsonString["CLIENT_ELEMENTS"]["SUBSCRIBE_TO_CLIENT_LINK"];?></a>
      <div class="input-group mt-3">
        <input type="text" class="form-control fhw-solutions-obituaries_search-all-obits" name="fhw-solutions-obituaries_search-all-obits" id="fhw-solutions-obituaries_search-all-obits" placeholder="<?php echo $jsonString["CLIENT_ELEMENTS"]["SEARCH_PLACEHOLDER"]; ?>" aria-label="Recipient's username" aria-describedby="button-addon2">
        <button class="fhw-solutions-obituaries_search-all-obits-button" name="fhw-solutions-obituaries_search-all-obits-button" id="fhw-solutions-obituaries_search-all-obits-button" type="button"><?php echo $searchIcon . '<span class="d-none d-md-inline-block ps-1">' . $jsonString["CLIENT_ELEMENTS"]["SEARCH"] . '</span>';?></button>
      </div>
      <div class="pt-4">
        <?php echo (array_key_exists('OBITUARY_SUBMISSION', $elements) && $jsonString["CLIENT_CONFIG"]['SUBMISSION_BY_FAMILY_ALLOW'] == 1 ?  $obituarySubmissionLink : '') ?>
      </div>
    </div>
  </div>

  <?php

    $actual_link = home_url() . "/" . get_option('fhw-solutions-obituaries_2')['obituary_page_name'];

    echo '<div class="row no-gutters">';

    // generate each obits
    for ($i=0;$i<count($jsonString["OBITUARIES"]);$i++) {

      $obit_link = $actual_link . "/" . $jsonString["OBITUARIES"][$i]["OBIT_URL_REWRITE"];
      $name = $jsonString["OBITUARIES"][$i]["FIRST_NAME"].' '.$jsonString["OBITUARIES"][$i]["MIDDLE_NAME"].' '.$jsonString["OBITUARIES"][$i]["LAST_NAME"];
      $detail = $jsonString["CLIENT_ELEMENTS"]["VIEW_DETAILS"];
      $obitBornDate = $jsonString["OBITUARIES"][$i]["BORN_DATE"];
      $obitPassedDate = $jsonString["OBITUARIES"][$i]["DIED_DATE"];
      $preview = ($jsonString["CLIENT_CONFIG"]["MAIN_OBITS_TEXT_PREVIEW"] == 1) ? substr(strip_tags($jsonString["OBITUARIES"][$i]["OBIT_TEXT_OG_META"]), 0, 200) : "";
      $location = ($jsonString["CLIENT_CONFIG"]["CLIENT_SHOW_OBITUARY_LOCATION_TAG"] == 1) ? $jsonString["OBITUARIES"][$i]["FUNERAL_HOME_NAME"] : "";
      $extra_buttons = ($jsonString["CLIENT_CONFIG"]["FHWS_A_T"] == 0 && $jsonString["OBITUARIES"][$i]["DISABLE_FLOWERS"] == 0 || $jsonString["CLIENT_CONFIG"]["FHWS_A_T"] == 2 && $jsonString["OBITUARIES"][$i]["DISABLE_FLOWERS"] == 0) ? $jsonString["CLIENT_NAVIGATION"]["FLOWERS"] : "" ;
      $trees_only_button = ($jsonString["CLIENT_CONFIG"]["FHWS_A_T"] == 5 || $jsonString["CLIENT_CONFIG"]["FHWS_A_T"] == 7) ? "Plant Trees" : "" ;
      $flowers_only_button = ($jsonString["CLIENT_CONFIG"]["FHWS_A_T"] == 6) ? "Send Flowers" : "" ;

      if ($obitBornDate && $obitPassedDate) {
          $obitDates = $obitBornDate.' - '.$obitPassedDate;
      } elseif ($obitBornDate && !$obitPassedDate) {
          $obitDates = sprintf(__($jsonString["CLIENT_ELEMENTS"]["BORN"] . ' %s'), $obitBornDate);
      } elseif (!$obitBornDate && $obitPassedDate) {
          $obitDates = sprintf(__($jsonString["CLIENT_ELEMENTS"]["DIED"] . ' %s'), $obitPassedDate);
      } else {
          $obitDates = '';
      }

      $backgroundImage = "";
      if (isset($jsonString["OBITUARIES"][$i]["OBIT_THEME_INFO"]) && $jsonString["OBITUARIES"][$i]["OBIT_THEME_INFO"]["SHOW_ON_RECENT_OBITS"] == 1){
        $backgroundImage = $jsonString["OBITUARIES"][$i]["OBIT_THEME_INFO"]["TOP_IMAGE"];
      }

      $displayType = "";
      switch ($jsonString["CLIENT_CONFIG"]["MAIN_OBITS_GRID_VIEW"]){
        case 0:
          $displayType = "list";
          $image = $jsonString["OBITUARIES"][$i]["IMAGE_S3"];
          break;
        case 1:
          $displayType = "grid";
          $image = $jsonString["OBITUARIES"][$i]["IMAGE_S3_FACE_GRAVITY"];
          break;
        default:
          $displayType = "list";
          $image = $jsonString["OBITUARIES"][$i]["IMAGE_S3"];
          break;
      }

      $oa_display->fhws_display_obits_card($obit_link, $name, $obitDates, $image, $detail, $preview, $location, $extra_buttons, $trees_only_button, $flowers_only_button, $backgroundImage, $displayType);

    }

    echo '</div>';

    if ((!(count($jsonString["OBITUARIES"]))) && isset($searchString)){
      echo '<div class="row">';
      echo '<div class="obit_listing" style="border-bottom: 0; min-height: 100px;">';
      echo '<p>No results were found. Please try the last name or first name only.</p>';
      echo '</div>';
      echo '</div>';
    }
    else if (!(count($jsonString["OBITUARIES"]))){
      echo '<div class="row">';
      echo '<div class="obit_listing" style="border-bottom: 0; min-height: 100px;">';
      echo '<p>No obituaries have been added yet.</p>';
      echo '</div>';
      echo '</div>';
    }

    echo '<div class="row">';

    //link
    if (count($jsonString["OBITUARIES"])) {
        echo '<div class="obit_listing" style="border-bottom: 0; min-height: 20px;"><a class="fhw-solutions-obituaries_company-link" href="https://www.obituary-assistant.com/" target="_blank" >by Obituary Assistant</a></div>';
    }
    echo '</div>';
    echo '<div class="row">';
    //paging

    $oa_display->fws_paging_all_obits($actual_link,$jsonString['TOTAL_PAGES'],$page, $jsonString["CLIENT_ELEMENTS"]["PREVIOUS_OBITUARIES"], $jsonString["CLIENT_ELEMENTS"]["MORE_OBITUARIES"]);
    echo '</div>';

    if ($jsonString['CLIENT_INFO']['OBITUARY_ARCHIVE'] != ""){
      echo '<div id="id="fhws-obituary-archive" class="row text-center text-decoration-none"><a class="fs-5 text-decoration-none" href="' . $jsonString['CLIENT_INFO']['OBITUARY_ARCHIVE'] . '">Obituary Archive</a></div>';
    }
    ?>

  <?php
    echo '<input type="hidden" name="subscribe_to_client_popup_explanation" id="subscribe_to_client_popup_explanation" value="' . $jsonString["CLIENT_ELEMENTS"]["SUBSCRIBE_TO_CLIENT_POPUP_EXPLANATION"] . '">';
    echo '<input type="hidden" name="placeholder" id="placeholder" value="' . $jsonString["CLIENT_ELEMENTS"]["SUBSCRIBE_TO_CLIENT_POPUP_EXPLANATION"] . '">';
    echo '<input type="hidden" name="enter_your_phone_number" id="enter_your_phone_number" value="' . $jsonString["CLIENT_ELEMENTS"]["ENTER_YOUR_PHONE_NUMBER"] . '">';
    echo '<input type="hidden" name="enter_your_email_address" id="enter_your_email_address" value="' . $jsonString["CLIENT_ELEMENTS"]["ENTER_YOUR_EMAIL_ADDRESS"] . '">';
    echo '<input type="hidden" name="fhws_input_placeholder" id="fhws_input_placeholder" value="' . $jsonString["CLIENT_ELEMENTS"]["POPUP_PLACEHOLDER"] . '">';
    echo '<input type="hidden" id="popup_submit" value="' . $jsonString["CLIENT_ELEMENTS"]["PHOTO_BUTTON_1"] . '">';
    echo '<input type="hidden" id="popup_cancel" value="' . $jsonString["CLIENT_ELEMENTS"]["PHOTO_BUTTON_2"] . '">';
  ?>

 </div>
