<?php

/**
 * @link       https://www.obituary-assistant.com
 * @since      1.0.0
 *
 * @package    Fhw_Solutions_Obituaries
 * @subpackage Fhw_Solutions_Obituaries/public/partials
 */
?>

 <style>
    .modal-backdrop {
      z-index:1 !important;
    }
</style>


<?php if (isset($jsonString["OBITUARIES"]["OBIT_THEME_INFO"]["THEME_NAME"]) && strlen($jsonString["OBITUARIES"]["OBIT_THEME_INFO"]["TOP_IMAGE_S3"]) > 0) : ?>
  <!-- FHWS Obituary Theme "<?php echo $jsonString["OBITUARIES"]["OBIT_THEME_INFO"]["THEME_NAME"]; ?>" -->
  <style>
    .obit_name_and_date h2, .obit_name_and_date h4 {
      color: <?php echo $jsonString["OBITUARIES"]["OBIT_THEME_INFO"]["HEADING_COLOR"]; ?>!important;
    }
  </style>
<?php endif; ?>

<?php
  $nameFull = $jsonString["OBITUARIES"]["FIRST_NAME"] . ' ' . $jsonString["OBITUARIES"]["MIDDLE_NAME"] . ' ' . $jsonString["OBITUARIES"]["LAST_NAME"];
  $nameSearch = '<NAME>';
?>

<div class="obit_main bootstrap-fhws-obituaries-container w-100" id="fhws-main-obit"><!--start of fhws-container-->
  <div class="fhws-fullscreen-container">
    <?php

      $fws_active_tab = true;
      $show_photo = "";
      $show_flowers = "";
      $show_trees = "";
      $show_condolences = "";
      $streamIcon = '<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>';

      if (isset($_GET['show_flowers'])) {
        $show_flowers = $_GET['show_flowers'];
        if ($show_flowers == 1){
          $fws_active_tab = false;
        }
      }

      if (isset($_GET['show_trees'])) {
        $show_trees = $_GET['show_trees'];
        if ($show_trees == 1){
          $fws_active_tab = false;
        }
      }

      if (isset($_GET['show_photo'])) {
        $show_photo = $_GET['show_photo'];
        if ($show_photo == 1){
          $fws_active_tab = false;
        }
      }

      if (isset($_GET['tab'])) {

        switch ($_GET['tab']) {
          case 2:
            $show_photo = 1;
            $fws_active_tab = false;
            break;
          case 3:
            $show_condolences = 1;
            $fws_active_tab = false;
            break;
          case 4:
            $show_flowers = 1;
            $fws_active_tab = false;
            break;
          case 5:
            $show_trees = 1;
            $fws_active_tab = false;
            break;
          default:
            $fws_active_tab = true;
        }

      }

      // menu
      $active_obit = ($fws_active_tab === true)? "active":"";
      $active_flower = ($show_flowers == 1)? "active":"";
      $active_tree = ($show_trees == 1) ? "active":"";
      $active_photo = ($show_photo == 1) ? "active":"";
      $active_condolence = ($show_condolences == 1) ? "active":"";

      $obit_name_and_date_class_string = 'obit_name_and_date';
      $haystack = $jsonString["OBITUARIES"]["OBIT_THEME_INFO"]["TOP_IMAGE_S3"];
      $needle = '/theme_top_image_200/';
      if( strpos( $haystack, $needle ) !== false) {
        $obit_name_and_date_class_string .= ' ' . 'obit_name_and_date_200';
      }
      $needle = '/theme_top_image_400/';
      if( strpos( $haystack, $needle ) !== false) {
        $obit_name_and_date_class_string .= ' ' . 'obit_name_and_date_400';
      }
      $needle = '/theme_top_image_600/';
      if( strpos( $haystack, $needle ) !== false) {
        $obit_name_and_date_class_string .= ' ' . 'obit_name_and_date_600';
      }
      if (strlen($jsonString["OBITUARIES"]["CUSTOM_CLASS"]) > 0) {
        $obit_name_and_date_class_string .= ' ' . $jsonString["OBITUARIES"]["CUSTOM_CLASS"];
      }

      $obitBornDate = $jsonString["OBITUARIES"]["BORN_DATE"];
      $obitPassedDate = $jsonString["OBITUARIES"]["DIED_DATE"];

      if ($obitBornDate && $obitPassedDate) {
        $obitDates = $obitBornDate.' - '.$obitPassedDate;
      } elseif ($obitBornDate && !$obitPassedDate) {
        $obitDates = sprintf(__($jsonString["CLIENT_ELEMENTS"]["BORN"] . ' %s'), $obitBornDate);
      } elseif (!$obitBornDate && $obitPassedDate) {
        $obitDates = sprintf(__($jsonString["CLIENT_ELEMENTS"]["DIED"] . ' %s'), $obitPassedDate);
      } else {
        $obitDates = '';
      }

      $obit_services = array();
      $photo_video = array();
      if (isset($jsonString["CLIENT_NAVIGATION"]["LIVE_STREAM"])){
        $fhwsLiveStream_heading = $jsonString["CLIENT_NAVIGATION"]["LIVE_STREAM"];
      }
      else {
        $fhwsLiveStream_heading = '';
      }
      // use to check for livestream and video changes

        // checking for fhwsLiveStream videos and links
        if (count($jsonString["OBITUARIES"]["LIVE_STREAM_LINK"]) > 0 ) {
          for ($v=0;$v<count($jsonString["OBITUARIES"]["LIVE_STREAM_LINK"]);$v++){
            if ($jsonString["OBITUARIES"]["LIVE_STREAM_LINK"][$v]["SHOW_ON_OBITUARY_AND_SERVICES"] == 1) {
              array_push($obit_services,$jsonString["OBITUARIES"]["LIVE_STREAM_LINK"][$v]);
            }
            if ($jsonString["OBITUARIES"]["LIVE_STREAM_LINK"][$v]["SHOW_ON_PHOTOS_AND_VIDEO"] == 1) {
              array_push($photo_video,$jsonString["OBITUARIES"]["LIVE_STREAM_LINK"][$v]);
            }
          }
        }
        if (!function_exists('fhwsLiveStream')) {
          function fhwsLiveStream($data, $section, $heading, $top_margin){
            switch ($section) {
              case "obit":
                $location = "SHOW_ON_OBITUARY_AND_SERVICES";
                break;
              case "photo":
                $location = "SHOW_ON_PHOTOS_AND_VIDEO";
                break;
            }
            array_multisort(array_column($data, "IS_EMBEDDED"), SORT_DESC, $data);
            if (count($data) > 0 ) {
              $streamIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cast" viewBox="0 0 16 16">' .
                                    '<path d="m7.646 9.354-3.792 3.792a.5.5 0 0 0 .353.854h7.586a.5.5 0 0 0 .354-.854L8.354 9.354a.5.5 0 0 0-.708 0z"/>' .
                                    '<path d="M11.414 11H14.5a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.5-.5h-13a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .5.5h3.086l-1 1H1.5A1.5 1.5 0 0 1 0 10.5v-7A1.5 1.5 0 0 1 1.5 2h13A1.5 1.5 0 0 1 16 3.5v7a1.5 1.5 0 0 1-1.5 1.5h-2.086l-1-1z"/>' .
                                    '</svg>';
              echo '<div id="stream" class="col-md-12 oa-section' . $top_margin . '">';
                echo '<h3>' . $heading . '</h3>';
                echo '<div class="d-grid w-100 gap-3 border p-3">';
                  for ($v=0;$v<count($data);$v++){
                    if ($data[$v][$location] == 1){
                      if ($data[$v]["IS_EMBEDDED"] == 0){
                        echo '<div class="col-md-6">';
                        echo '<button type="button" class="fhws-additioin-button w-100 mb-2" href="' . $data[$v]["LINK_HREF"] . '" target="_blank" title="'. $data[$v]["LINK_TEXT"] .  '" >'  . $streamIcon . ' ' . $data[$v]["LINK_TEXT"] . '</button>';
                        echo '</div>';
                      } else {
                        echo '<div class="ratio ratio-16x9">';
                          echo $data[$v]["EMBEDDED_HTML"];
                        echo '</div>';
                      }
                    }
                  }
                echo '</div>';
             echo '</div>';
            }
          }
        }

    ?>
    <div class="row"><!--start full row-->
      <div class="col-12 p-0"><!--start theme header / name and date-->
          <?php if ($jsonString["OBITUARIES"]["OBIT_THEME_INFO"]["TOP_IMAGE_S3"] != ""){ ?>
           <div class="text-center px-2 obit_name_and_date">
              <h2 class="text-dark"><?php echo $jsonString["OBITUARIES"]["FIRST_NAME"] . ' ' . $jsonString["OBITUARIES"]["MIDDLE_NAME"] . ' '.$jsonString["OBITUARIES"]["LAST_NAME"];?></h2>
              <h4 class="text-dark"><?php echo $obitDates;?></h4>
           </div>
          <?php } ?>
        <div class="card text-start">
          <?php if ($jsonString["OBITUARIES"]["OBIT_THEME_INFO"]["TOP_IMAGE_S3"] != ""){ ?>
            <img src="<?php echo $jsonString["OBITUARIES"]["OBIT_THEME_INFO"]["TOP_IMAGE_S3"]; ?>" class="card-img img-thumbnail" alt="...">
          <?php } else { ?>
            <div class="obit_name_and_date p-3 py-4 text-center text-md-start">
            <h2><?php echo $jsonString["OBITUARIES"]["FIRST_NAME"] . ' ' . $jsonString["OBITUARIES"]["MIDDLE_NAME"] . ' '.$jsonString["OBITUARIES"]["LAST_NAME"];?></h2>
            <h4><?php echo $obitDates;?></h4>
            </div>
          <?php } ?>
        </div>

      </div><!--end theme header / name and date-->
     <?php // show tab for flowers and trees list all obits
        $showObit = ($fws_active_tab === true)? "show active":"";
        $showFlower = ($show_flowers == 1)? "show active":"";
        $showTree = ($show_trees == 1)? "show active":"";
        $showPhoto = ($show_photo == 1)? "show active":"";
        $showCondolence = ($show_condolences == 1)? "show active":"";
        $tributeShow = (count((array)$jsonString["OBITUARIES"]["TRIBUTES"]) > 0) ? " & " . $jsonString['CLIENT_ELEMENTS']['PURCHASE_RECOGNITION']['oa-copy-tributes-heading']['heading'] : ""  ;
        $showTributes = $jsonString["CLIENT_NAVIGATION"]["CONDOLENCES"] . $tributeShow;
        $condolenceCount = count((array)$jsonString["OBITUARIES"]["CONDOLENCES"]) + count((array)$jsonString["OBITUARIES"]["TRIBUTES"]);
        $photsVideosCount = count((array)$jsonString["OBITUARIES"]["PHOTOS"]) + count((array)$jsonString["OBITUARIES"]["VIDEOS"]);

      ?>
      <div class="flex-row d-flex justify-content-end text-dark mt-1 mb-0"><!-- start of text size options-->
        <!--<button id="fhws-fullscreen-button" type="button" class="d-inline f1fd_secondary border border-light me-2" ><span id="fhws-fullscreen-button-icon"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg></span> View</button>-->
        <span class="d-flex align-items-center me-2" style="font-size:22px">Text:</span>
        <a class="active px-1 d-flex f1fd-size-ctl" id="f1fd-text-size-base" tabindex="0" role="button">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-type" viewBox="0 0 16 16">
            <path d="m2.244 13.081.943-2.803H6.66l.944 2.803H8.86L5.54 3.75H4.322L1 13.081h1.244zm2.7-7.923L6.34 9.314H3.51l1.4-4.156h.034zm9.146 7.027h.035v.896h1.128V8.125c0-1.51-1.114-2.345-2.646-2.345-1.736 0-2.59.916-2.666 2.174h1.108c.068-.718.595-1.19 1.517-1.19.971 0 1.518.52 1.518 1.464v.731H12.19c-1.647.007-2.522.8-2.522 2.058 0 1.319.957 2.18 2.345 2.18 1.06 0 1.716-.43 2.078-1.011zm-1.763.035c-.752 0-1.456-.397-1.456-1.244 0-.65.424-1.115 1.408-1.115h1.805v.834c0 .896-.752 1.525-1.757 1.525z"/>
          </svg>
        </a>
        <a class="px-1 d-flex align-items-center f1fd-size-ctl justify-content-center" id="f1fd-text-size-zoom1" tabindex="0" role="button">
          <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-type" viewBox="0 0 16 16">
            <path d="m2.244 13.081.943-2.803H6.66l.944 2.803H8.86L5.54 3.75H4.322L1 13.081h1.244zm2.7-7.923L6.34 9.314H3.51l1.4-4.156h.034zm9.146 7.027h.035v.896h1.128V8.125c0-1.51-1.114-2.345-2.646-2.345-1.736 0-2.59.916-2.666 2.174h1.108c.068-.718.595-1.19 1.517-1.19.971 0 1.518.52 1.518 1.464v.731H12.19c-1.647.007-2.522.8-2.522 2.058 0 1.319.957 2.18 2.345 2.18 1.06 0 1.716-.43 2.078-1.011zm-1.763.035c-.752 0-1.456-.397-1.456-1.244 0-.65.424-1.115 1.408-1.115h1.805v.834c0 .896-.752 1.525-1.757 1.525z"/>
          </svg>
        </a>
        <a class="px-1 d-flex align-items-center f1fd-size-ctl justify-content-center" id="f1fd-text-size-zoom2" tabindex="0" role="button">
          <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-type" viewBox="0 0 16 16">
            <path d="m2.244 13.081.943-2.803H6.66l.944 2.803H8.86L5.54 3.75H4.322L1 13.081h1.244zm2.7-7.923L6.34 9.314H3.51l1.4-4.156h.034zm9.146 7.027h.035v.896h1.128V8.125c0-1.51-1.114-2.345-2.646-2.345-1.736 0-2.59.916-2.666 2.174h1.108c.068-.718.595-1.19 1.517-1.19.971 0 1.518.52 1.518 1.464v.731H12.19c-1.647.007-2.522.8-2.522 2.058 0 1.319.957 2.18 2.345 2.18 1.06 0 1.716-.43 2.078-1.011zm-1.763.035c-.752 0-1.456-.397-1.456-1.244 0-.65.424-1.115 1.408-1.115h1.805v.834c0 .896-.752 1.525-1.757 1.525z"/>
          </svg>
        </a>
      </div><!-- end of text size options-->
      <div class="col-12">
        <ul class="lh-sm nav nav-pills justify-content-center text-center flex-nowrap flex-column flex-md-row mt-3 mb-4 mb-lg-5" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link py-md-3 h-100 fw-normal <?php echo $active_obit;?>" id="pills-obit" data-bs-toggle="pill" data-bs-target="#obit" role="tab" aria-controls="pills-obit" aria-selected="true"><?php echo $jsonString["CLIENT_NAVIGATION"]["OBITUARY"];?></a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link py-md-3 h-100 fw-normal <?php echo $active_photo;?>" id="pills-photo" data-bs-toggle="pill" data-bs-target="#photo" role="tab" aria-controls="pills-photo" aria-selected="false"><?php echo (count($photo_video) > 0 ) ? $jsonString["CLIENT_NAVIGATION"]["LIVE_STREAM"] . ", " . $jsonString["CLIENT_NAVIGATION"]["PHOTOS"]: $jsonString["CLIENT_NAVIGATION"]["PHOTOS"] ?><span id="photo_counter"><?php echo (count($jsonString["OBITUARIES"]["PHOTOS"]) > 0 || count($jsonString["OBITUARIES"]["VIDEOS"]) > 0) ? " (" . $photsVideosCount . ")" : "" ?></span></a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link py-md-3 h-100 fw-normal <?php echo $active_condolence;?>" id="pills-condolence" data-bs-toggle="pill" data-bs-target="#condolence" role="tab" aria-controls="pills-condolence" aria-selected="false"><?php echo $showTributes ?><span class="condolence_counter"><?php echo (count($jsonString["OBITUARIES"]["CONDOLENCES"]) > 0 || count($jsonString["OBITUARIES"]["TRIBUTES"]) > 0) ? " (" . $condolenceCount . ")" : "" ?></span></a>
        </li>
        <?php
        if (($jsonString["CLIENT_CONFIG"]["FHWS_A_T"] == 0 || $jsonString["CLIENT_CONFIG"]["FHWS_A_T"] == 2) && $jsonString["OBITUARIES"]["DISABLE_FLOWERS"] == 0) {
        ?>
          <li class="nav-item" role="presentation">
            <a class="nav-link py-md-3 h-100 fw-normal <?php echo $active_flower;?>" id="pills-flowers" data-bs-toggle="pill" data-bs-target="#flowers" role="tab" aria-controls="pills-flowers" aria-selected="false"><?php echo  $jsonString["CLIENT_NAVIGATION"]["FLOWERS"] ?></a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link py-md-3 h-100 fw-normal <?php echo $active_tree;?>" id="pills-tree" data-bs-toggle="pill" data-bs-target="#flowers" role="tab" aria-controls="pills-tree" aria-selected="false">Plant Trees</a>
          </li>
        <?php
        }
        else if ($jsonString["CLIENT_CONFIG"]["FHWS_A_T"] == 6 && $jsonString["OBITUARIES"]["DISABLE_FLOWERS"] == 0){
        ?>
          <li class="nav-item" role="presentation">
            <a class="nav-link py-md-3 h-100 fw-normal <?php echo $active_flower;?>" id="pills-flowers" data-bs-toggle="pill" data-bs-target="#flowers" role="tab" aria-controls="pills-flowers" aria-selected="false"><?php echo  $jsonString["CLIENT_NAVIGATION"]["FLOWERS"] ?></a>
          </li>
        <?php
        }
        else if ($jsonString["CLIENT_CONFIG"]["FHWS_A_T"] == 5 || $jsonString["CLIENT_CONFIG"]["FHWS_A_T"] == 7) {
        ?>
          <li class="nav-item" role="presentation">
            <a class="nav-link py-md-3 h-100 fw-normal <?php echo $active_tree;?>" id="pills-tree" data-bs-toggle="pill" data-bs-target="#trees" role="tab" aria-controls="pills-tree" aria-selected="false">Plant Trees</a>
          </li>
        <?php }
          if (count($jsonString["CLIENT_INFO"]["USEFULLINKS"]) > 0 || $jsonString["OBITUARIES"]["DISPLAY_USEFUL_LINKS"]) {
            echo '<li class="nav-item" role="presentation">' .
              '<a class="nav-link py-md-3 h-100 fw-normal" id="pills-useful_links" data-bs-toggle="pill"  data-bs-target="#useful_links" role="tab" aria-controls="pills-useful_links" aria-selected="false">Useful Links</span></a>' .
              '</li>';
          }
        ?>



        </ul><!--end of nav main section-->
      </div>
      <div id="fws-sidebar" class="col-md-3 mb-sm-3 ps-md-4 obit_body "><!--start row sidebar-->
        <div class="row"><!--start row side bar-->
          <div class="col-12 pt-3 col-md-12 bg-light text-center d-flex flex-wrap"><!--photo side bar--->
            <div class="mx-auto pt-2" style="flex:0 1 300px">
              <?php
                echo "<img class='img-fluid img-thumbnail' src=\""  . $jsonString["OBITUARIES"]["IMAGE_S3"] . "\" />";
              ?>
            </div>
            <div class="mx-auto p-2">
              <!--share icons-->
              <div class="share text-center">
                <h3 class="my-1 p-0"><?php echo $jsonString["CLIENT_ELEMENTS"]["SHARE"];?></h3>
                <div class="row mb-2">
                  <div class="col my-3">
                    <a id="obituary-share-icon-facebook" role="button" class="obituary-share-icon facebook oa-share-popup" data-href="https://facebook.com/sharer/sharer.php?u=<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']?>" data-share-type="facebook" data-obit-id="<?php echo $jsonString['OBITUARIES']['ID'];?>" data-obit-url="<?php echo $jsonString['OBITUARIES']['OBIT_URL_REWRITE'];?>&related=" title="Share this <?php echo $jsonString['CLIENT_ELEMENTS']['OBITUARY_SINGULAR'];?> on Facebook">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
                      </svg>
                    </a>
                  </div>
                  <div class="col my-3">
                    <a id="obituary-share-icon-twitter" role="button" class="obituary-share-icon twitter oa-share-popup" data-href="https://twitter.com/intent/tweet?text=<?php echo htmlspecialchars(str_replace('|',' ', $jsonString['OBITUARIES']['FUNERAL_HOME_NAME']) . ' - ' . $jsonString['OBITUARIES']['FIRST_NAME'] . ' ' . $jsonString['OBITUARIES']['LAST_NAME']) . "'s " . $jsonString['CLIENT_ELEMENTS']['OBITUARY_SINGULAR'] . ' Page ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '&related=';?>" data-share-type="twitter" data-obit-id="<?php echo $jsonString['OBITUARIES']['ID'];?>" data-obit-url="<?php echo $jsonString['OBITUARIES']['OBIT_URL_REWRITE'];?>" title="Tweet this <?php echo $jsonString['CLIENT_ELEMENTS']['OBITUARY_SINGULAR'];?>">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
                        <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>
                      </svg>
                    </a>
                  </div>
                  <?php if ($jsonString["CLIENT_INFO"]["CLIENT_ACCOUNT_TYPE"] != 3 && $jsonString["CLIENT_INFO"]["CLIENT_ACCOUNT_TYPE"] != 4 && $jsonString["CLIENT_INFO"]["CLIENT_ACCOUNT_TYPE"] != 7){ ?>
                    <div class="col my-3">
                      <a id="obituary-share-icon-text" role="button" data-modal-action="Share Text" data-bs-toggle="modal" data-bs-target="#fhws-share-subscribe-modal" class="obituary-share-icon text" data-share-type="text" data-obit-id="<?php echo $jsonString['OBITUARIES']['ID'];?>" data-obit-url="<?php echo $jsonString['OBITUARIES']['OBIT_URL_REWRITE'];?>" title="Share this <?php echo $jsonString['CLIENT_ELEMENTS']['OBITUARY_SINGULAR'];?> via text message">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-chat-dots" viewBox="0 0 16 16">
                          <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                          <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9 9 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.4 10.4 0 0 1-.524 2.318l-.003.011a11 11 0 0 1-.244.637c-.079.186.074.394.273.362a22 22 0 0 0 .693-.125m.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6-3.004 6-7 6a8 8 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a11 11 0 0 0 .398-2"/>
                        </svg>
                      </a>
                    </div>
                  <?php } ?>
                  <div class="col my-3">
                    <a id="obituary-share-icon-email" role="button" id="obituary-share-icon-email" data-modal-action="Share Email" data-bs-toggle="modal" data-bs-target="#fhws-share-subscribe-modal"  class="obituary-share-icon email" data-share-type="email" data-obit-id="<?php echo $jsonString['OBITUARIES']['ID'];?>" data-obit-url="<?php echo $jsonString['OBITUARIES']['OBIT_URL_REWRITE'];?>" title="Share this <?php echo $jsonString['CLIENT_ELEMENTS']['OBITUARY_SINGULAR'];?> via email">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-envelope-at" viewBox="0 0 16 16">
                        <path d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2zm3.708 6.208L1 11.105V5.383zM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2z"/>
                        <path d="M14.247 14.269c1.01 0 1.587-.857 1.587-2.025v-.21C15.834 10.43 14.64 9 12.52 9h-.035C10.42 9 9 10.36 9 12.432v.214C9 14.82 10.438 16 12.358 16h.044c.594 0 1.018-.074 1.237-.175v-.73c-.245.11-.673.18-1.18.18h-.044c-1.334 0-2.571-.788-2.571-2.655v-.157c0-1.657 1.058-2.724 2.64-2.724h.04c1.535 0 2.484 1.05 2.484 2.326v.118c0 .975-.324 1.39-.639 1.39-.232 0-.41-.148-.41-.42v-2.19h-.906v.569h-.03c-.084-.298-.368-.63-.954-.63-.778 0-1.259.555-1.259 1.4v.528c0 .892.49 1.434 1.26 1.434.471 0 .896-.227 1.014-.643h.043c.118.42.617.648 1.12.648m-2.453-1.588v-.227c0-.546.227-.791.573-.791.297 0 .572.192.572.708v.367c0 .573-.253.744-.564.744-.354 0-.581-.215-.581-.8Z"/>
                      </svg>
                    </a>
                  </div>
                  <div class="col my-3">
                    <a id="obituary-share-icon-print" role="button" class="obituary-share-icon print" data-share-type="print" data-obit-id="<?php echo $jsonString['OBITUARIES']['ID'];?>" data-obit-url="<?php echo $jsonString['OBITUARIES']['OBIT_URL_REWRITE'];?>" title="Print a pdf of this <?php echo $jsonString['CLIENT_ELEMENTS']['OBITUARY_SINGULAR'];?>">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                        <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/>
                        <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1"/>
                      </svg>
                    </a>
                  </div>
                </div>
              </div>
              <!--end share icons-->
              <?php
                $display_lm_btn_client = (is_numeric($jsonString["CLIENT_INFO"]["DISPLAY_LM_LINK"]) != 1) ? 1 : $jsonString["CLIENT_INFO"]["DISPLAY_LM_LINK"];
                $display_lm_btn_obituary = (is_numeric($jsonString["OBITUARIES"]["DISPLAY_LM_LINK"]) != 1) ? 1 : $jsonString["OBITUARIES"]["DISPLAY_LM_LINK"];
                $display_lm_btn_text = $jsonString["OBITUARIES"]["LM_ANCHOR_TEXT"];
                $display_lm_btn_link = $jsonString["OBITUARIES"]["LM_LINK"];
              ?>
              <div class="d-grid mb-4 gap-4"><!--sidebar buttons-->
                <button id="share_memory" data-tab="condolence" class="" type="button"><?php echo $jsonString["CLIENT_ELEMENTS"]["SHARE_MEMORY"]?></button>
                <?php
                if (($jsonString["CLIENT_CONFIG"]["FHWS_A_T"] == 0 || $jsonString["CLIENT_CONFIG"]["FHWS_A_T"] == 2) && $jsonString["OBITUARIES"]["DISABLE_FLOWERS"] == 0) {
                ?>
                  <button id="send_flowers" data-tab="flowers" class="<?php echo $active_flower;?>" type="button"><?php echo $jsonString["CLIENT_NAVIGATION"]["FLOWERS"]?></button>
                  <button id="plant_a_tree" data-tab="trees" class="<?php echo $active_tree;?>" type="button"><?php echo "Plant Trees"?></button>
                <?php
                }
                else if ($jsonString["CLIENT_CONFIG"]["FHWS_A_T"] == 6 && $jsonString["OBITUARIES"]["DISABLE_FLOWERS"] == 0 ) {
                ?>
                  <button id="send_flowers" data-tab="flowers" class="<?php echo $active_flower;?>" type="button"><?php echo $jsonString["CLIENT_NAVIGATION"]["FLOWERS"]?></button>
                <?php
                }
                else if (($jsonString["CLIENT_CONFIG"]["FHWS_A_T"] == 5 || $jsonString["CLIENT_CONFIG"]["FHWS_A_T"] == 7) && $jsonString["OBITUARIES"]["DISABLE_FLOWERS"] == 0 ) {
                ?>
                  <button id="plant_a_tree" data-tab="trees" class="<?php echo $active_tree;?>" type="button"><?php echo "Plant Trees"?></button>
                <?php
                }
                ?>
                <button id="subscribe_to_obit" data-modal-action="Subscribe to Obit" data-bs-toggle="modal" data-bs-target="#fhws-share-subscribe-modal" class="" type="button"><?php echo $jsonString["CLIENT_ELEMENTS"]["SUBSCRIBE"];?></button>
                <?php
                  foreach ($jsonString["OBITUARIES"]["ADDITIONAL_LINKS"] as $additional_link) {
                  echo '<button type="button" class="fhws-additioin-button" href="' . $additional_link["LINK_HREF"] . '"target="_blank" id="additional_link_' . $additional_link["ID"] . '" data-tab="" title="' . $additional_link["LINK_ALT_TEXT"] . '" target="_blank" >' . $additional_link["LINK_TEXT"] . '</button>';
                 }
                ?>
                <?php if ($display_lm_btn_client != 0 ) {
                  if ($display_lm_btn_obituary != 0) { ?>
                    <button type="button" class="fhws-additioin-button" href="<?php echo $display_lm_btn_link;?>" target="_blank" title="<?php echo $display_lm_btn_text;?>"><?php echo $display_lm_btn_text;?></button>
                    <?php $show_lm_link = '<a class="fhw-solutions-obituaries_company-link" href="https://www.lovingmemorials.com/" target="_blank" >LM</a>';
                  }
                } ?>
              </div>
            </div><!--end sidebar buttons-->
         </div>
        </div><!--end photo sidebar-->
      </div><!--end sidebar-->
      <div id="fws-mainbar" class="col-md-9"><!--start main section-->
        <div class="obit_body px-md-3 px-lg-4 px-xl-5"><!-- main section inside -->
          <!--start of nav main section-->

          <div class="tab-content lh-base d-block pt-3" id="pills-tabContent"><!--tabs container-->
            <div class="tab-pane fade <?php echo $showObit;?>" id="obit" role="tabpanel" aria-labelledby="pills-obit-tab"><!-- start obit tab-->

              <?php if (strlen($jsonString["OBITUARIES"]["OBIT_TEXT_OG_META"]) > 0){ ?>
              	<div class="oa-section">
        					<h3><?php echo $jsonString["CLIENT_ELEMENTS"]["OBITUARY_HEADING"] . ' ' . $jsonString["OBITUARIES"]["FIRST_NAME"] . ' ' . $jsonString["OBITUARIES"]["MIDDLE_NAME"] . ' ' . $jsonString["OBITUARIES"]["LAST_NAME"] ?></h3>
        					<div><?php echo wpautop($jsonString["OBITUARIES"]["OBIT_TEXT"], true) ?></div><!--obit text-->
              	</div>
              <?php } ?>
              <?php fhwsLiveStream($obit_services, "obit",$fhwsLiveStream_heading, "");
              if (strlen($jsonString["OBITUARIES"]["OBIT_PROGRAM_URL"]) > 0) { ?>
				  <div class="col-md-6 oa-section"><!--program-->
					<div class="d-grid w-100"><!--inner program-->
					  <!-- funeral program -->
					  <?php
						$programIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-arrow-down" viewBox="0 0 16 16">' .
									   '<path d="M8.5 6.5a.5.5 0 0 0-1 0v3.793L6.354 9.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293V6.5z"/>' .
									   '<path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>' .
									   '</svg>';
						echo '<h3 id="program">Program</h3>';
						echo '<form action="' . $jsonString["OBITUARIES"]["OBIT_PROGRAM_URL"] . '"><button class="w-100" type="submit">'  . $programIcon . ' Download funeral program</button></form>';
					  ?>
					</div><!--end inner stream and program-->
				  </div><!--program-->
              <?php }
                if (count($jsonString["OBITUARIES"]["EVENTS"]) > 0) {
                	echo '<div class="oa-section">';
                    echo '<h3 id="service">' .  $jsonString["CLIENT_ELEMENTS"]["SERVICES"] . '</h3>';
                    for ($i=0;$i<count($jsonString["OBITUARIES"]["EVENTS"]);$i++) {
                    	include 'fhw-solutions-obituaries-public-display-events.php';
                	}
                	echo '<a class="fhw-solutions-obituaries_company-link" href="https://www.obituary-assistant.com/" target="_blank" >by Obituary Assistant</a>' . (isset($show_lm_link) ? " " . $show_lm_link : "" );
                	echo '</div>';
                }
             ?>
            </div><!-- end obit tab-->
            <div class="tab-pane fade <?php echo $showPhoto;?>" id="photo" role="tabpanel" aria-labelledby="pills-photo-tab"><!--photo & video tab-->
                <?php fhwsLiveStream($photo_video, "photo" ,$fhwsLiveStream_heading, "");
                echo '<h3 class="mb-0 ' . (count($photo_video) > 0 ? "mt-4" : "" )  . '">' . $jsonString["CLIENT_NAVIGATION"]["PHOTOS"] . '</h3>';
                /* video stream link */
                if (strlen($jsonString["OBITUARIES"]["OBIT_STREAM_URL"]) > 0){
                  echo '<div class="col-md-6 mt-4">';
                  echo '<form action="' . $jsonString["OBITUARIES"]["OBIT_STREAM_URL"] . '"><button class="w-100" type="submit">'  . $streamIcon . ' ' . $jsonString["OBITUARIES"]["OBIT_STREAM_URL_DESCRIPTION"] . '</button></form>';
                  echo '</div>';
                }
                /* additional video links */
                if (count($jsonString["OBITUARIES"]["VIDEO_LINKS"]) > 0){
                  foreach ($jsonString["OBITUARIES"]["VIDEO_LINKS"] as $additional_link) {
                    echo '<p><a href="' . $additional_link["LINK_HREF"] . '" target="_new" title="' . $additional_link["LINK_ALT_TEXT"] . '">' . $additional_link["LINK_TEXT"] . '</a></p>';
                  }
                }
              ?>
              <div id="fws-gallery-container"><!--gallery-->
                <?php include 'fhw-solutions-obituaries-public-display-photo-gallery.php' ?>
              </div><!--end gallery-->
              <div class="obituary-photo-upload mb-4"><!--add photo or video-->
                <?php
                  if ($jsonString["OBITUARIES"]["ENABLE_PHOTOS"] == 1){
                    echo '<h3>' . $jsonString["CLIENT_ELEMENTS"]["PHOTO_EXPLANATION"] . '</h3>';
                    $upload_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 16">' .
                                   '<path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>' .
                                   '<path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>' .
                                   '</svg>';

                    echo '<div class="col-md-6 mt-4 mb-3">';
                    echo '<button class="w-100" data-bs-toggle="modal" data-bs-target="#fhw-solutions-obituries-modal" id="upload_photo">' . $upload_icon . " " . $jsonString["CLIENT_ELEMENTS"]["ADD_PHOTOS_PC"] . '</button>';
                    echo '</div>';
                  }
                ?>
              </div><!--end photo or video-->
            </div><!--end photo & video tab-->
            <div class="tab-pane fade <?php echo $showCondolence;?>" id="condolence" role="tabpanel" aria-labelledby="pills-condolence-tab"><!--condolences tab-->
              <?php echo '<h3>' . $jsonString["CLIENT_NAVIGATION"]["CONDOLENCES"] . '</h3>'; ?>

              <?php $add_new_condolence = 0;
              include 'fhw-solutions-obituaries-public-display-condolences.php' ?>

            </div><!--end condolences tab-->
            <div class="tab-pane fade" id="useful_links" role="tabpanel" aria-labelledby="pills-useful_links-tab"><!--useful links tab-->
              <?php
                echo '<h3>Useful Links</h3>';
                for ($i=0;$i<count($jsonString["CLIENT_INFO"]["USEFULLINKS"]);$i++){
                  echo '<p>' .
                    '<a href="' . $jsonString["CLIENT_INFO"]["USEFULLINKS"][$i]["LINK"] . '">' .
                    $jsonString["CLIENT_INFO"]["USEFULLINKS"][$i]["LINK_TEXT"] .
                    '</a>' .
                    '</p>';
                  echo '<p>' . $jsonString["CLIENT_INFO"]["USEFULLINKS"][$i]["DESCRIPTION"] . '</p>';
                  echo '<p>&nbsp;</p>';
                }
              ?>
              <h5>Add Your Useful Link</h5>
              <p><a href="#submit_useful_link_div" class="oa-useful-link-contact-us">Contact Us</a> to have your link and message added here.</p>

              <p>&nbsp;</p>

              <div id="submit_useful_link_div" class="d-none">
                <p>Please fill out the form below. We will contact suitable submissions with further details.</p>
                <form id="oa-send-useful-link-form" class="oa-send-useful-link-form" method="post" action="">
                  <table>
                    <tr>
                      <td>Your Name:</td>
                      <td><input type="text" name="useful_link_name" id="useful_link_name"></td>
                    </tr>
                    <tr>
                      <td>Phone Number:</td>
                      <td><input type="text" name="useful_link_phone_number" id="useful_link_phone_number"></td>
                    </tr>
                    <tr>
                      <td>Email Address:</td>
                      <td><input type="text" name="useful_link_email_address" id="useful_link_email_address"></td>
                    </tr>
                    <tr>
                      <td>Business Name:</td>
                      <td><input type="text" name="useful_link_business_name" id="useful_link_business_name"></td>
                    </tr>
                    <tr>
                      <td colspan="2">Description of Useful Link / Service:</td>
                    </tr>
                    <tr>
                      <td colspan="2"><textarea name="useful_link_description" id="useful_link_description" rows="8"></textarea></td>
                    </tr>
                    <tr>
                      <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2" align="center"><input type="submit" value="Submit" class="oa-useful-link-contact-us-submit"></td>
                    </tr>
                  </table>
                </form>
              </div>

              <div id="success_message" class="d-none"></div>

            </div><!--end useful links tab-->
            <div class="tab-pane fade <?php echo $showFlower;?><?php echo $showTree;?>" id="flowers" role="tabpanel" aria-labelledby="pills-flowers-tab"><!--flowers tab-->
              <?php
                if (
                    (
                      $jsonString["CLIENT_CONFIG"]["FHWS_A_T"] == 0 ||
                      $jsonString["CLIENT_CONFIG"]["FHWS_A_T"] == 2 ||
                      $jsonString["CLIENT_CONFIG"]["FHWS_A_T"] == 6
                    )
                    && $jsonString["OBITUARIES"]["DISABLE_FLOWERS"] == 0
                  ) {
                  echo obituary_assistant_create_flower_storefront();
                }
              ?>
            </div><!--end flowers tab-->
            <div class="tab-pane fade <?php echo $showTree;?>" id="trees" role="tabpanel" aria-labelledby="pills-flowers-tab"><!--trees tab-->
              <?php
                  if ($jsonString["CLIENT_CONFIG"]["FHWS_A_T"] == 5 || $jsonString["CLIENT_CONFIG"]["FHWS_A_T"] == 7) {
                      echo obituary_assistant_create_flower_storefront();
                  }
              ?>
            </div><!--end trees tab-->
          </div><!--end tabs container-->
          <?php
              if ($jsonString["CLIENT_CONFIG"]["SHOW_QR_CODE"] == 1 && isset($_SERVER['SCRIPT_URI'])) {
                  echo '<div class="row"><div class="mx-auto" style="width:175px">' . get_qr_code($_SERVER['SCRIPT_URI']). '</div></div>';
              }
              else if ($jsonString["CLIENT_CONFIG"]["SHOW_QR_CODE"] == 1) {
                  $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                  echo '<div class="row"><div class="mx-auto" style="width:175px">' . get_qr_code($url). '</div></div>';
              }
              if (count($jsonString["OBITUARIES"]["MUSIC"]["SONGS"]) > 0) {
                  echo '<p style="text-align: center;"><audio controls><source src="' . $jsonString["OBITUARIES"]["MUSIC"]["SONGS"][0]["FILE"] . '" type="audio/mpeg">Your browser does not support the audio element.</audio></p>';
              }
          ?>
        </div><!--end main section inside -->
      </div><!--end main section-->

    </div><!--end full row -->

  </div>

  <input type="hidden" id="obit_url_rewrite" value='<?php echo $jsonString["OBITUARIES"]["OBIT_URL_REWRITE"]; ?>'>
  <input type="hidden" id="f1_purchase_recognition" value='<?php echo $jsonString['CLIENT_ELEMENTS']['PURCHASE_RECOGNITION']['oa-purchase-recognition-input-label']['heading'] ; ?>'>
  <input type="hidden" id="client_type" value="<?php echo $jsonString["CLIENT_CONFIG"]["FHWS_A_T"]; ?>">
  <input type="hidden" id="client_id" value="<?php echo $jsonString["OBITUARIES"]["CLIENT_ID"]; ?>">
  <input type="hidden" id="obit_id" value="<?php echo $jsonString["OBITUARIES"]["ID"]; ?>">
  <input type="hidden" id="facility_id" value="<?php echo $jsonString['CLIENT_INFO']['CLIENT_FACILITY_ID']; ?>">
  <input type="hidden" id="popup_submit" value="<?php echo $jsonString["CLIENT_ELEMENTS"]["PHOTO_BUTTON_1"]; ?>">
  <input type="hidden" id="popup_cancel" value="<?php echo $jsonString["CLIENT_ELEMENTS"]["PHOTO_BUTTON_2"]; ?>">
  <input type="hidden" id="popup_subscribe_explanation" value="<?php echo $jsonString["CLIENT_ELEMENTS"]["SUBSCRIBE_POPUP_EXPLANATION"]; ?>">
  <input type="hidden" id="popup_subscribe_header" value="<?php echo $jsonString["CLIENT_ELEMENTS"]["SUBSCRIBE_POPUP_HEADER"]; ?>">
  <input type="hidden" id="fhws_input_placeholder" value="<?php echo $jsonString["CLIENT_ELEMENTS"]["POPUP_PLACEHOLDER"]; ?>">
  <input type="hidden" name="placeholder" id="placeholder" value="<?php echo $jsonString["CLIENT_ELEMENTS"]["SUBSCRIBE_TO_CLIENT_POPUP_EXPLANATION"]; ?>">
  <input type="hidden" name="condolence_honor" id="condolence_honor" value="<?php echo esc_html(str_replace($nameSearch, $nameFull, $jsonString["CLIENT_ELEMENTS"]["CONDOLENCE_HONOR"])); ?>">
  <input type="hidden" name="enter_your_phone_number" id="enter_your_phone_number" value="<?php echo $jsonString["CLIENT_ELEMENTS"]["ENTER_YOUR_PHONE_NUMBER"]; ?>">
  <input type="hidden" name="enter_your_email_address" id="enter_your_email_address" value="<?php echo $jsonString["CLIENT_ELEMENTS"]["ENTER_YOUR_EMAIL_ADDRESS"]; ?>">
  <input type="hidden" name="allow_condolences_message" id="allow_condolences_message" value="<?php echo $jsonString["CLIENT_CONFIG"]["USER_CONTENT_AUTO_ALLOW"] == 1 ? $jsonString["CLIENT_ELEMENTS"]["AUTO_ALLOW_CONDOLENCES_MESSAGE"] : $jsonString["CLIENT_ELEMENTS"]["MANUAL_ALLOW_CONDOLENCES_MESSAGE"]; ?>">
  <input type="hidden" class="login" value="">

  <div class="bootstrap-fhws-obituaries-container bootstrap-fhws-obituaries-container-1"><!--modal container-->
    <div class="modal fhws-modal fade" id="fws-gallery-modal" tabindex="-1" aria-labelledby="fws-gallery-modal" aria-hidden="true" data-bs-backdrop="false" style="background-color: rgba(0, 0, 0, 0.3);"><!-- gallery modal-->
      <div class="modal-dialog fhws-modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
          </div>
          <div class="modal-footer">
            <button type="button" id="florist-one-flower-delivery-view-modal-close" class="" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div><!--end of gallery modal-->
  </div><!--end modal container-->

</div><!-- end fhws-container -->

<?php include 'fhw-solutions-obituaries-dialog-box-1.php'; ?><!--Subscribe/share-->
<?php include 'fhw-solutions-obituaries-dialog-box-2.php'; ?><!--Pictures/Condolences-->
