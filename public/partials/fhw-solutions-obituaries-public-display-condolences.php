<?php

/**
 * @link       https://www.obituary-assistant.com
 * @since      1.0.0
 *
 * @package    Fhw_Solutions_Obituaries
 * @subpackage Fhw_Solutions_Obituaries/public/partials
 */

	$obituaryDateFormat = array(
		1 => 'm/d/Y',
		2 => 'd/m/Y',
		3 => 'F d, Y'
	);

?>

<?php if ($add_new_condolence == 0){ ?>
<div class="row"><!--condelences container-->
  <div class="col-12 mt-3 mb-3"><!--condolences inner-->
   <?php } ?>
    <div class="obituary-condolences-display"><!--condolences list-->
      <ul class="list-group list-group-flush ml-0  ms-0">
        <!--create condolence-->
        <?php for ($i=0;$i<count($jsonString["OBITUARIES"]["CONDOLENCES"]);$i++){
			 //display in selected date format
			$condolence_date  = date($obituaryDateFormat[$jsonString['CLIENT_CONFIG']['FULL_OBITS_DATE']], strtotime($jsonString["OBITUARIES"]["CONDOLENCES"][$i]["DATE"]));
        ?>
        <li class="list-group-item d-flex flex-wrap py-5 px-0 px-md-3"><!--condolence-->
          <div class="d-flex me-3 mb-3 fhws-condolences-candle">
            <div style="width:100px!important;height:100px!important" class="bg-light me-3 flex-shrink-0">
              <?php if (isset($jsonString["OBITUARIES"]["CONDOLENCES"][$i]["CELEBRATION_INFORMATION"])) { ?>
                <img class="img-thumbnail"  src="<?php echo $jsonString["OBITUARIES"]["CONDOLENCES"][$i]["CELEBRATION_INFORMATION"]["IMAGE_2"]; ?>">
              <?php } else { ?>
                <svg class="w-50 h-50 d-block m-auto mt-3" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#cccccc" class="bi bi-chat-square-quote" viewBox="0 0 16 16">
                  <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-2.5a2 2 0 0 0-1.6.8L8 14.333 6.1 11.8a2 2 0 0 0-1.6-.8H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                  <path d="M7.066 4.76A1.665 1.665 0 0 0 4 5.668a1.667 1.667 0 0 0 2.561 1.406c-.131.389-.375.804-.777 1.22a.417.417 0 1 0 .6.58c1.486-1.54 1.293-3.214.682-4.112zm4 0A1.665 1.665 0 0 0 8 5.668a1.667 1.667 0 0 0 2.561 1.406c-.131.389-.375.804-.777 1.22a.417.417 0 1 0 .6.58c1.486-1.54 1.293-3.214.682-4.112z"/>
                </svg>
              <?php } ?>
            </div>
            <!--sender-->
            <div class="">
              <p class="mt-0"><?php echo $condolence_date?></p>
              <?php if ($jsonString["OBITUARIES"]["CONDOLENCES"][$i]["SENDER"] != 'na' && strlen($jsonString["OBITUARIES"]["CONDOLENCES"][$i]["SENDER"]) > 0){ ?>
                <p class="mt-0 blockquote-footer"><?php echo $jsonString["OBITUARIES"]["CONDOLENCES"][$i]["SENDER"]; ?></p>
              <?php } ?>
            </div>
          </div>
          <!--message info-->
          <div class="col fhws-condolences-message">
            <!--message-->
            <?php if (strlen($jsonString["OBITUARIES"]["CONDOLENCES"][$i]["MESSAGE"]) > 0){ ?>
              <p class="lh-sm mb-2"><?php echo $jsonString["OBITUARIES"]["CONDOLENCES"][$i]["MESSAGE"]; ?></p>
            <?php } ?>
            <!--delete-->
            <?php if (isset($_COOKIE['o-s-t']) && isset($_COOKIE['o-s-u']) && isset($_COOKIE['o-s-e'])){
              if ($_COOKIE['o-s-u'] == $jsonString["OBITUARIES"]["CONDOLENCES"][$i]["SENDER"] && $_COOKIE['o-s-e'] == htmlentities($jsonString["OBITUARIES"]["CONDOLENCES"][$i]["EMAIL"])) { ?>
                <div class=""><button href="#" class="obituary-delete-condolence btn-sm" id="obituary-delete-condolence-<?php echo $i;?>" data-p-i="<?php echo $jsonString["OBITUARIES"]["CONDOLENCES"][$i]["ID"];?>">delete</button></div>
              <?php }
            } else if (isset($jsonString['ost']) && isset($jsonString['osu']) && isset($jsonString['ose'])) {
              if ($jsonString['osu'] == $jsonString["OBITUARIES"]["CONDOLENCES"][$i]["SENDER"] && $jsonString['ose'] == htmlentities($jsonString["OBITUARIES"]["CONDOLENCES"][$i]["EMAIL"])) { ?>
                <div class=""><button href="#" class="obituary-delete-condolence btn-sm" id="obituary-delete-condolence-<?php echo $i;?>" data-p-i="<?php echo $jsonString["OBITUARIES"]["CONDOLENCES"][$i]["ID"];?>">delete</button></div>
              <?php }
            }
            ?>
          </div>
        </li><!--condolence end-->
        <?php } ?>
      </ul>
    </div><!--condolences list end-->
    <?php if ($add_new_condolence == 0){ ?>
  </div><!--condelences container end-->
</div><!--condelences container end-->
<?php }
if ($add_new_condolence == 0){
  if (count((array)$jsonString["OBITUARIES"]["TRIBUTES"]) > 0 ){ ?>
    <div class="row"><!--tributes container-->
      <div class="col-12 mt-5 mb-3"><!--tributes inner-->
        <div class="obituary-tributes-display"><!--tributes list-->
          <?php echo '<h3>' . $jsonString['CLIENT_ELEMENTS']['PURCHASE_RECOGNITION']['oa-copy-tributes-heading']['heading'] . '</h3>'; ?>
          <ul class="list-group list-group-flush ml-0  ms-0"><!--create tributes-->
            <?php
              $f_tribshown = false;
              $t_tribshown = false;
              for ($i=0;$i<count($jsonString["OBITUARIES"]["TRIBUTES"]);$i++){
                //display in selected date format
        			  $display = explode("-",$jsonString["OBITUARIES"]["TRIBUTES"][$i]["PURCHASE_RECOGNITION"]["DISPLAY"][0]);
        			  $displayDate = date($obituaryDateFormat[$jsonString['CLIENT_CONFIG']['FULL_OBITS_DATE']], strtotime($display[1]));
        			  $jsonString["OBITUARIES"]["TRIBUTES"][$i]["PURCHASE_RECOGNITION"]["DISPLAY"][0] = $display[0] . " - " . $displayDate;
            ?>
            <li class="list-group-item  py-5 px-0 px-md-3"><!--tribute-->
              <div class="d-flex flex-wrap"><!--product-->
                <div class="d-flex me-3 mb-3" style="flex:0 0 175px;">
                  <div style="width:150px!important;" class="me-3 flex-shrink-0 mb-3">
                     <?php if ($jsonString["OBITUARIES"]["TRIBUTES"][$i]["PURCHASE_RECOGNITION"]['TYPE'] == "F") { ?>
                        <img src="<?php echo $jsonString["OBITUARIES"]["TRIBUTES"][$i]["PURCHASE_RECOGNITION"]["PRODUCT"]["IMAGE"]; ?>" alt="<?php echo $jsonString["OBITUARIES"]["TRIBUTES"][$i]["PURCHASE_RECOGNITION"]["PRODUCT"]["NAME"]; ?>">
                     <?php } else { ?>
                       <img src="<?php echo $jsonString["OBITUARIES"]["TRIBUTES"][$i]["PURCHASE_RECOGNITION"]["PRODUCT"]["IMAGE"]; ?>" alt="<?php echo $jsonString["OBITUARIES"]["TRIBUTES"][$i]["PURCHASE_RECOGNITION"]["PRODUCT"]["NAME"]; ?>">
                    <?php } ?>
                  </div>
                </div>
                <div class="col fhws-condolences-message"><!--message-->
                  <p class="lh-sm mb-2"><?php echo $jsonString["OBITUARIES"]["TRIBUTES"][$i]["PURCHASE_RECOGNITION"]["DISPLAY"][0]; ?></p>
                  <p class="lh-sm mb-2"><?php echo $jsonString["OBITUARIES"]["TRIBUTES"][$i]["PURCHASE_RECOGNITION"]["DISPLAY"][1]; ?></p>
                </div>
              </div>
              <p>
                <?php
                  if ($jsonString["OBITUARIES"]["TRIBUTES"][$i]["PURCHASE_RECOGNITION"]['TYPE'] == "F" && !$f_tribshown) {
                    echo '<button data-tab="flowers" type="button" class="purchase-recognition-buttons lh-sm my-2">' .
                      $jsonString["OBITUARIES"]["TRIBUTES"][$i]["PURCHASE_RECOGNITION"]["DISPLAY"][2] .
                      '</button>';
                    $f_tribshown = true;
                  }
                  else if ($jsonString["OBITUARIES"]["TRIBUTES"][$i]["PURCHASE_RECOGNITION"]['TYPE'] == "T" && !$t_tribshown) {
                    echo '<button data-tab="trees" type="button" class="purchase-recognition-buttons lh-sm my-2">' .
                      $jsonString["OBITUARIES"]["TRIBUTES"][$i]["PURCHASE_RECOGNITION"]["DISPLAY"][2] .
                      '</button>';
                    $t_tribshown = true;
                  }
                ?>
              </p>
            </li><!--tribute end-->
            <?php } ?>
          </ul><!--create tributes end-->
        </div><!--end tributes list-->
      </div><!--tributes inner end-->
    </div><!--tributes container end-->
  <?php } ?>

  <?php if ($jsonString["OBITUARIES"]["ENABLE_CONDOLENCES"] == 1){ ?>
    <div id="obituary-share-memory-container" class="d-flex mb-2"><!--form condolences-->
      <div style="flex:0 1 450px">
        <h4 class="border-top border-3 condolence_honor pt-3 condolence_honor"></h4>
        <div><!--inner form condolences-->
          <label for="obituary-condolence-input" class="form-label lh-sm">
            <?php echo $jsonString["CLIENT_ELEMENTS"]["CONDOLENCE_EXPLANATION"];?>
          </label>
          <textarea class="input-new-condolence form-control mt-3" id="obituary-condolence-input" rows="4"></textarea>
          <input type="hidden" class="login_type">
          <input type="hidden" class="refresh_condolence_button">
          <input type="hidden" class="obituary-candle-choice" name="obituary-candle-choice" id="obituary-candle-choice" value="">
          <?php
            if ($jsonString["CLIENT_CONFIG"]["CANDLES"] == 1) { ?> <!--candles-->
            <h5 class="add-a-candle mt-4"><?php echo $jsonString["CLIENT_ELEMENTS"]["ADD_CANDLE"];?></h5>
            <p class="lh-sm"><?php echo $jsonString["CLIENT_ELEMENTS"]["ADD_CANDLE_DETAIL_MESSAGE"];?></p>
            <div class="row row-cols-1 row-cols-sm-3 row-cols-lg-4 g-3 mb-3">
              <?php for ($i=0;$i<count($jsonString["CANDLES"]);$i++){
                echo '<div class="col w-25"><img style="width:100px!important;" class="obituary-candle" role="button" tabindex="0" id="obituary-candle-' . $jsonString["CANDLES"][$i]["ID"] .
                '" src="' . $jsonString["CANDLES"][$i]["IMAGE"] . '" title="' . $jsonString["CANDLES"][$i]["NAME"] .
                '" data-image-1="' . $jsonString["CANDLES"][$i]["IMAGE"] . '" data-image-2="' . $jsonString["CANDLES"][$i]["IMAGE_2"] .
                '" data-candle-id="' . $jsonString["CANDLES"][$i]["NAME"] . '"></div>';
            } ?>
            </div><!--end candles-->
          <?php } ?>
          <div class="obituary-condolences-submit"><!--submit-->
            <button type="button" class="input-new-condolence-submit d-inline-block d-none" id="input-new-condolence-submit" data-bs-toggle="modal" data-bs-target="#fhw-solutions-obituries-modal">Submit</button>
          </div><!--end submit-->
        </div><!--end inner form condolences-->
      </div>
    </div><!--end form condolences-->
  <?php } ?>
<?php } ?>
