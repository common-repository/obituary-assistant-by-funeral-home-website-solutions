<?php
/**
 * @link       https://www.obituary-assistant.com
 * @since      1.0.0
 *
 * @package    Fhw_Solutions_Obituaries
 * @subpackage Fhw_Solutions_Obituaries/public/partials
 */
?>
<?php if (count($jsonString["OBITUARIES"]["PHOTOS"]) > 0 || count($jsonString["OBITUARIES"]["VIDEOS"]) > 0){ ?>
  <div class="row mt-5">
    <div class="col-md-12 fws-main-gallery">
        <div class="d-flex flex-row justify-content-center p-1 mt-3">
          <!-- prev button -->
          <div class="d-flex align-items-center my-auto justify-content-center d-none d-md-block">
            <button class="bg-dark" type="button" data-bs-target="#fwsPhotosVideosCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            </div>
          <!-- caroursel -->
          <div id="fwsPhotosVideosCarousel" class="fhws-carousel carousel-dark border slide carousel-fade w-100" data-bs-ride="carousel" data-bs-wrap="true" data-bs-interval="false">
            <div class="carousel-inner p-4 bg-light">
              <!--add videos -->
              <?php $thumbnails = array();
                if (count($jsonString["OBITUARIES"]["VIDEOS"]) > 0) {
                  for ($v=0;$v<count($jsonString["OBITUARIES"]["VIDEOS"]);$v++){
                  $videoImageUrlPoster = $jsonString["OBITUARIES"]["VIDEOS"][$v]["THUMBNAIL_URL_S3"];
                  $videoImageUrl = $jsonString["OBITUARIES"]["VIDEOS"][$v]["THUMBNAIL_URL_S3"];
                  $videoUrl =  $jsonString["OBITUARIES"]["VIDEOS"][$v]["PHOTO_URL_S3"];
                  array_push($thumbnails, $videoImageUrl);
                  ?>
                 <div class="carousel-item <?php if($v == 0) { echo "active";} ?>" data-video-num="<?php echo $v;?>">
                    <video id="fws-memory-video-<?php echo $v;?>" width="100%" controls controlsList='nodownload' poster='<?php echo $videoImageUrlPoster;?>'>
                      <source src='<?php echo $videoUrl;?>' type='video/mp4'>
                      Your browser does not support the video tag."
                    </video>
                </div>
              <?php }
              } ?>
             <!-- add images to carousel -->
              <?php
              if (count($jsonString["OBITUARIES"]["PHOTOS"]) > 0) {
                for ($t=0;$t<count($jsonString["OBITUARIES"]["PHOTOS"]);$t++) {
                  $photoUrl = $jsonString["OBITUARIES"]["PHOTOS"][$t]["PHOTO_URL_S3"];
                  $thumbnailUrl = $jsonString["OBITUARIES"]["PHOTOS"][$t]["THUMBNAIL_URL_S3"];
                  array_push($thumbnails, $thumbnailUrl);
                ?>
                <div class="carousel-item <?php if($t == 0 && count($jsonString["OBITUARIES"]["VIDEOS"]) < 1){ echo "active";} ?>" >
                  <img src="<?php echo $photoUrl?>" class="d-block w-100" alt="...">
                </div>
                <?php }
              } ?>
            </div>
          </div>
          <!-- end carousel -->
         <!-- next button -->
          <div class="d-flex align-items-center my-auto justify-content-center d-none d-md-block">
            <button class="bg-dark" type="button" data-bs-target="#fwsPhotosVideosCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
        </div>
      </div>
    </div>
     <!-- next and previous buttons mobile -->
    <div class="d-flex align-items-center justify-content-center d-md-none">
      <button class="bg-dark" type="button" data-bs-target="#fwsPhotosVideosCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="bg-dark" type="button" data-bs-target="#fwsPhotosVideosCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
    <div class="col-md-12" id="florist-one-gallery-indicators">
      <!-- thumbnails / indicators -->
      <?php
    if (count($jsonString["OBITUARIES"]["VIDEOS"]) > 0) {
?>
       <h3 class="mt-5 mb-0">Videos</h3>
        <div class="row row-cols-3 row-cols-sm-5 row-cols-lg-5 g-2 mt-3 mb-5 p-1">
          <?php
        for ($z = 0; $z < count($jsonString["OBITUARIES"]["VIDEOS"]); $z++) {
            $video_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffffff" class="bi bi-camera-reels" viewBox="0 0 16 16">' . '<path d="M6 3a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM1 3a2 2 0 1 0 4 0 2 2 0 0 0-4 0z"/>' . '<path d="M9 6h.5a2 2 0 0 1 1.983 1.738l3.11-1.382A1 1 0 0 1 16 7.269v7.462a1 1 0 0 1-1.406.913l-3.111-1.382A2 2 0 0 1 9.5 16H2a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h7zm6 8.73V7.27l-3.5 1.555v4.35l3.5 1.556zM1 8v6a1 1 0 0 0 1 1h7.5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1z"/>' . '<path d="M9 6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM7 3a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"/></svg>';
            $thumbnail_type = "video";
            $videoNumber    = $z;
            $videoNumShow   = 'data-video-num="' . $videoNumber . '"';
?>
         <!-- videos -->
            <div class="position-relative <?php
            if ($z == 0) {
                echo "active-img";
            }
?> p-2">
              <a class="h-100" data-thumbnail-type="<?php
            echo $thumbnail_type;
?>" role="button" data-bs-target="#fwsPhotosVideosCarousel" data-bs-slide-to="<?php
            echo $z;
?>" aria-current="true" aria-label="Slide <?php
            echo ($z + 1);
?>">
                <img data-bs-toggle="modal" data-bs-target="#fws-gallery-modal" <?php
            echo $videoNumShow;
?> class="w-100 img-thumbnail" src="<?php
            echo $thumbnails[$z];
?>" onerror="imgError(this);" />
              </a>
          </div>
          <?php
        }
?>
       </div><!-- end videos thumbnails -->
      <?php
    }
    if (count($jsonString["OBITUARIES"]["PHOTOS"]) > 0) {
?>
        <h3 class="mt-5 mb-0">Photos</h3>
        <div class="row row-cols-3 row-cols-sm-5 row-cols-lg-5 g-2 mt-3 mb-5 p-1">
          <?php
        for ($z = count($jsonString["OBITUARIES"]["VIDEOS"]); $z < count($jsonString["OBITUARIES"]["PHOTOS"]) + count($jsonString["OBITUARIES"]["VIDEOS"]); $z++) {
            $image_icon     = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffffff" class="bi bi-image" viewBox="0 0 16 16">' . '<path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>' . '<path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"/>' . '</svg>';
            $thumbnail_type = "photo";
            $img_number     = $z - count($jsonString["OBITUARIES"]["VIDEOS"]);
?>
         <div class="position-relative <?php
            if ($z == 0) {
                echo "active-img";
            }
?> p-2">
            <a class="h-100" data-image-number="<?php
            echo $img_number;
?>" data-thumbnail-type="<?php
            echo $thumbnail_type;
?>" role="button" data-bs-target="#fwsPhotosVideosCarousel" data-bs-slide-to="<?php
            echo $z;
?>" aria-current="true" aria-label="Slide <?php
            echo $z;
?>">
              <img data-bs-toggle="modal" data-bs-target="#fws-gallery-modal" class="w-100 img-thumbnail" src="<?php
            echo $thumbnails[$z];
?>"/>
            </a>
          </div>
          <?php
        }
?>
       </div><!-- end photos thumbnails -->
      <?php
    }
?>
    </div>
  </div>
<?php
}
?>
