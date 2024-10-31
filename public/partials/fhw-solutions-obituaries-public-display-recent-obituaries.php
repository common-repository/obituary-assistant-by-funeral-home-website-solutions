<?php

/**
 * @link       https://www.obituary-assistant.com
 * @since      1.0.0
 *
 * @package    Fhw_Solutions_Obituaries
 * @subpackage Fhw_Solutions_Obituaries/public/partials
 */


?>

<div id="fhw-solutions-obituaries-recent-obituaries" class="<?php echo ($orientation == 'horizontal' ? 'fhw-horizontal' : 'fhw-vertical')  ?>">
    <?php foreach ($obits["OBITUARIES"] as $obit){
      $obitPassedDate = $obit["DIED_DATE"]?date($obituaryDateFormat[$obits['CLIENT_CONFIG']['FULL_OBITS_DATE']], strtotime($obit["DIED_DATE"])):'';
      $obitBornDate = $obit["BORN_DATE"]?date($obituaryDateFormat[$obits['CLIENT_CONFIG']['FULL_OBITS_DATE']], strtotime($obit["BORN_DATE"])):'';
      $obitDates = sprintf(__('%s'), $obitPassedDate);
      $backgroundImage = "";
      if (isset($obit["OBIT_THEME_INFO"]) && $obit["OBIT_THEME_INFO"]["SHOW_ON_RECENT_OBITS"] == 1){
        $backgroundImage = $obit["OBIT_THEME_INFO"]["TOP_IMAGE"];
      }
    ?>
      <a href="<?php echo home_url() . "/" . get_option('fhw-solutions-obituaries_2')['obituary_page_name'] . '/' . $obit["OBIT_URL_REWRITE"] . '/' ?>" class="fhw-solutions-obituaries-recent-obituaries-listing" style="background-image: url(<?php echo $backgroundImage; ?>); background-size: cover;">
        <div>
          <div style="width:<?php echo  $obits['CLIENT_CONFIG']['RECENT_OBITS_PHOTO_SIZE'] * 3.5 ?>px">
            <img src="<?php echo $obit["IMAGE_S3_RECENT_OBITS"] ?>" />
          </div>
        </div>
        <div class="fhw-solutions-obituaries-recent-obituaries-listing-text">
          <h4 class=""><?php echo $obit["FIRST_NAME"] . " " . $obit["MIDDLE_NAME"] . " " . $obit["LAST_NAME"] ?></h4>
          <p><?php echo sprintf(__('%s'), $obitPassedDate) ?></p>
        </div>
      </a>

    <?php } ?>
</div>
