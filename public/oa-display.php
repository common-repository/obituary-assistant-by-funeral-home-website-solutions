<?php

/**
 * @package    Fhw_Solutions_Obituaries
 * @since      7.2.0
 */

 class OA_Display {

   public function fhws_display_obits_card($link, $name, $obitDates, $image, $detail, $preview, $location, $extra_buttons, $trees_only_button, $flowers_only_button, $backgroundImage, $displayType) {

     $truncate = (strlen($preview) === 200) ? "..." : "";
     $obitDatesMobile = explode(' - ', $obitDates);

     if ($displayType == "grid"){
       include 'partials/oa-grid-view-card.php';
     }
     else {
       include 'partials/oa-list-view-card.php';
     }

     return;

   }

   public function fws_paging_all_obits($actual_link,$totalpages,$page,$previous,$more ){

     include 'partials/oa-paging.php';

     return;

   }

}

?>
