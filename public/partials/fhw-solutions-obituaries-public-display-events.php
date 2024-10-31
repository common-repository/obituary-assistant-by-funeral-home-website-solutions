<?php

/**
 * @link       https://www.obituary-assistant.com
 * @since      1.0.0
 *
 * @package    Fhw_Solutions_Obituaries
 * @subpackage Fhw_Solutions_Obituaries/public/partials
 */

$timeIcon = '<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>';
$directionIcon = '<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>';
?>
<div class="border mb-4 pb-3">
  <!--date-->
  <div class="d-flex justify-content-start align-self-stretch mb-3">
    <div class="badge bg-dark text-white d-flex align-items-center">
      <div class="d-flex flex-column mx-auto" style="width:70px;">
        <span class="fs-3"><?php echo date_parse($jsonString["OBITUARIES"]["EVENTS"][$i]["START_TIME"])["day"]; ?></span>
        <span class="fs-5 <?php if (strlen($jsonString["OBITUARIES"]["EVENTS"][$i]["START_TIME"]) == 0) { echo "mx-auto"; } ?>">
          <?php
            if (strlen($jsonString["OBITUARIES"]["EVENTS"][$i]["START_TIME"]) == 0){
              echo "TBD";
            }
            else {              
              $monthNum = date_parse($jsonString["OBITUARIES"]["EVENTS"][$i]["START_TIME"])["month"];
              $monthName = date("M", mktime(0, 0, 0, $monthNum, 10));
              echo $monthName;
            }
          ?>
        </span>
      </div>
    </div>
    <!--title-->
    <h4 class="my-2 ms-3 fw-bold"><?php echo $jsonString["OBITUARIES"]["EVENTS"][$i]["TITLE"] ?></h4>
  </div>
  <div class="d-flex flex-wrap">
    <div style="flex:1 1 275px">
      <div class="ps-5">
        <!--time-->
        <?php
          if ($jsonString["OBITUARIES"]["EVENTS"][$i]["HOURS"] != 0 || $jsonString["OBITUARIES"]["EVENTS"][$i]["END_HOURS"] != 0 ) { ?>
            <div class="d-flex justify-content-start">
              <p class="me-2"><?php echo $timeIcon;?></p>
              <p class="card-text">
                <?php
                  if ($jsonString["OBITUARIES"]["EVENTS"][$i]["HOURS"] != 0){
                    //check format
                    if($jsonString["CLIENT_CONFIG"]["TIME_FORMAT"] == 1){
                      echo sprintf("%02d", $jsonString["OBITUARIES"]["EVENTS"][$i]["HOURS"]) . ':' . sprintf("%02d", $jsonString["OBITUARIES"]["EVENTS"][$i]["MINS"]) . ' ';
                      if ($jsonString["OBITUARIES"]["EVENTS"][$i]["AMPM"] == 0){
                        echo 'AM';
                      }
                      else{
                        echo 'PM';
                      }
                    }
                    if($jsonString["CLIENT_CONFIG"]["TIME_FORMAT"] == 2){
                      $time_format = ($jsonString["OBITUARIES"]["EVENTS"][$i]["AMPM"] == 0) ? 0 : 12;
                      echo sprintf("%02d", $jsonString["OBITUARIES"]["EVENTS"][$i]["HOURS"] + $time_format) . ':' . sprintf("%02d", $jsonString["OBITUARIES"]["EVENTS"][$i]["MINS"]) . ' ';

                    }
                  }
                ?>
                <?php
                  if ($jsonString["OBITUARIES"]["EVENTS"][$i]["END_HOURS"] != 0){
                    if($jsonString["CLIENT_CONFIG"]["TIME_FORMAT"] == 1){
                       echo ' - '.sprintf("%02d", $jsonString["OBITUARIES"]["EVENTS"][$i]["END_HOURS"]) . ':' . sprintf("%02d", $jsonString["OBITUARIES"]["EVENTS"][$i]["END_MINS"]) . ' ';
                       if ($jsonString["OBITUARIES"]["EVENTS"][$i]["END_AMPM"] == 0){
                         echo 'AM';
                       }
                       else{
                         echo 'PM';
                       }
                    }
                    if($jsonString["CLIENT_CONFIG"]["TIME_FORMAT"] == 2){
                      $time_format = ($jsonString["OBITUARIES"]["EVENTS"][$i]["AMPM"] == 0) ? 0 : 12;
                       echo ' - '.sprintf("%02d", $jsonString["OBITUARIES"]["EVENTS"][$i]["END_HOURS"] +  $time_format) . ':' . sprintf("%02d", $jsonString["OBITUARIES"]["EVENTS"][$i]["END_MINS"]) . ' ';
                    }
                  }
                ?>
              </p>
            </div>
        <?php } ?>
          <!--live stream-->
        <?php
          // add live stream
          if (isset($jsonString["OBITUARIES"]["EVENTS"][$i]["ADDITIONAL_LINKS"])){
            if(count($jsonString["OBITUARIES"]["EVENTS"][$i]["ADDITIONAL_LINKS"]) > 0){
              if($jsonString["OBITUARIES"]["EVENTS"][$i]["ADDITIONAL_LINKS"]["TYPE"] == "LIVE_STREAM"){
                echo '<div class="d-flex justify-content-start">';
                echo '<p class="me-2">' . $streamIcon . '</p>';
                echo '<p>';
                echo '<a type="button" class="fhws-additioin-button w-100 mb-2" href="' . $jsonString["OBITUARIES"]["EVENTS"][$i]["ADDITIONAL_LINKS"]["LINK_HREF"] . '" target="_blank" title="'. $jsonString["OBITUARIES"]["EVENTS"][$i]["ADDITIONAL_LINKS"]["LINK_TEXT"] .  '" >' . $jsonString["OBITUARIES"]["EVENTS"][$i]["ADDITIONAL_LINKS"]["LINK_TEXT"] . '</a>';
                echo '</p>';
                echo '</div>';
              }
            }
          }
        ?>
        <!--address-->
        <div class="d-flex justify-content-start">
          <div class="me-2"><?php echo $directionIcon . ' '; ?>
          </div>
          <div class="card-text d-flex flex-column">
            <?php echo '<span>' . $jsonString["OBITUARIES"]["EVENTS"][$i]["VENUE_NAME"] . '</span>'  ?>
            <?php echo '<span>' . $jsonString["OBITUARIES"]["EVENTS"][$i]["ADDRESS"] . '</span>'  ?>
            <?php echo '<span>' . $jsonString["OBITUARIES"]["EVENTS"][$i]["CITY"] ?>, <?php echo $jsonString["OBITUARIES"]["EVENTS"][$i]["STATE"] . '</span>'  ?>
            <?php echo '<span>' . $jsonString["OBITUARIES"]["EVENTS"][$i]["ZIP"] . '</span>'  ?>
            <!--directions-->
            <?php $directions = $jsonString["OBITUARIES"]["EVENTS"][$i]["VENUE_NAME"] . ' ' . $jsonString["OBITUARIES"]["EVENTS"][$i]["ADDRESS"] . ' ' . $jsonString["OBITUARIES"]["EVENTS"][$i]["CITY"] . ', ' . $jsonString["OBITUARIES"]["EVENTS"][$i]["STATE"] . ' ' . $jsonString["OBITUARIES"]["EVENTS"][$i]["ZIP"]; ?>
            <small class="text-muted mt-3"><?php echo  $jsonString["CLIENT_ELEMENTS"]["DIRECTIONS"] . ' »'; ?></small>
            <div class="btn-toolbar pb-3" role="toolbar" aria-label="Toolbar with button groups">
              <div class="btn-group pt-2 me-2" role="group" aria-label="First group">
                <?php
                  if ($jsonString["CLIENT_INFO"]["CLIENT_ACCOUNT_TYPE"] != 3 && $jsonString["CLIENT_INFO"]["CLIENT_ACCOUNT_TYPE"] != 4 && $jsonString["CLIENT_INFO"]["CLIENT_ACCOUNT_TYPE"] != 7){
                ?>
                  <button type="button" data-modal-action="Text Direction" id="text-directions<?php echo '-' . $i;?>" data-bs-toggle="modal" data-bs-target="#fhws-share-subscribe-modal" data-address="<?php echo $directions; ?>" class="btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-dots-fill" viewBox="0 0 16 16">
                      <path d="M16 8c0 3.866-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7zM5 8a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                    </svg>
                    <?php echo $jsonString["CLIENT_ELEMENTS"]["TEXT"]; ?>
                  </button>
                <?php
                  }
                ?>
              </div>
              <div class="btn-group pt-2 me-2" role="group" aria-label="Second group">
                <button type="button"  data-modal-action="Email Direction" id="email-directions<?php echo '-' . $i;?>" data-bs-toggle="modal" data-bs-target="#fhws-share-subscribe-modal" data-address="<?php echo $directions; ?>" class="btn-sm">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                    <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555zM0 4.697v7.104l5.803-3.558L0 4.697zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757zm3.436-.586L16 11.801V4.697l-5.803 3.546z"/>
                  </svg>
                  <?php echo $jsonString["CLIENT_ELEMENTS"]["EMAIL"]; ?>
                </button>
              </div>
              <div class="btn-group pt-2" role="group" aria-label="Third group">
                <a href="http://maps.google.com/maps?saddr=&daddr=<?php echo $jsonString["OBITUARIES"]["EVENTS"][$i]["VENUE_NAME"] . ' ' . $jsonString["OBITUARIES"]["EVENTS"][$i]["ADDRESS"] . ' ' . $jsonString["OBITUARIES"]["EVENTS"][$i]["CITY"] . ', ' . $jsonString["OBITUARIES"]["EVENTS"][$i]["STATE"] . ' ' . $jsonString["OBITUARIES"]["EVENTS"][$i]["ZIP"];?>" target="_blank">
                  <button class="btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-google" viewBox="0 0 16 16">
                      <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z"/>
                    </svg>
                    <?php echo $jsonString["CLIENT_ELEMENTS"]["MAPS"]; ?>
                  </button>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--map-->
    <div class="ps-5" style="flex:1 1 250px">
      <div>
        <?php echo '<img class="img-fluid" src="https://www.obituary-assistant.com/api/rest/map/?v=' . trim($jsonString["OBITUARIES"]["EVENTS"][$i]["VENUE_NAME"]) . '&a=' . trim($jsonString["OBITUARIES"]["EVENTS"][$i]["ADDRESS"]) . '&c=' . trim($jsonString["OBITUARIES"]["EVENTS"][$i]["CITY"]) . '&s=' . trim($jsonString["OBITUARIES"]["EVENTS"][$i]["STATE"]) . '&z=' . trim($jsonString["OBITUARIES"]["EVENTS"][$i]["ZIP"]) . '&x=300x300" />'; ?>
      </div>
    </div>
  </div>
</div>
