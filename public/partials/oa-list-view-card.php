<?php

  /**
   * @link       https://www.obituary-assistant.com
   * @since      7.2.0
   *
   * @package    Fhw_Solutions_Obituaries
   * @subpackage Fhw_Solutions_Obituaries/public/partials
   */

?>

<div class="row no-gutters">
  <div class="col-12" style="background-image: url(<?php echo $backgroundImage; ?>); background-size: cover;">
    <div class="obit_listing d-sm-flex border-0 text-center text-sm-start pt-5">
      <!-- mobile name and date -->
      <div class="d-sm-none">
        <div class="obit_name lh-l">
          <a class="text-decoration-none" href="<?php echo $link; ?>/"><?php echo $name; ?></a>
        </div>
        <?php if(isset($obitDatesMobile[0])){ ?>
        <p class="mb-0"><?php echo $obitDatesMobile[0];?></p>
        <?php } ?>
        <?php if(isset($obitDatesMobile[1])){ ?>
        <p class="mb-0"><?php echo " - " . $obitDatesMobile[1];?></p>
        <?php } ?>
      </div>
      <!--  image -->
      <div class="order-1 my-3 my-sm-0" style="flex: 0 0 200px;">
        <a href="<?php echo $link;?>/">
          <img src="<?php echo $image;?>" style="width:150px;" alt="<?php echo $name; ?>" />
        </a>
      </div>
      <!-- info -->
      <div class="order-2 flex-fill">
        <div class="d-none d-sm-block">
          <div class="obit_name lh-l">
            <a class="text-decoration-none" href="<?php echo $link; ?>/"><?php echo $name; ?></a>
          </div>
          <p class="mb-3"><?php echo $obitDates;?></p>
        </div>
        <div class="order-3">
          <?php if($preview != ""){ ?> <p class="lh-base"><?php echo $preview . $truncate; ?></p><?php }?>
          <?php if($location != ""){ ?> <p>@ <?php echo $location;?></p> <?php }?>
        </div>
      </div>
    </div>
    <ul class="lh-sm nav nav-pills mb-2 nav-sm-fill ms-0 flex-column flex-sm-row text-center justify-content-end" role="tablist">
      <li class="nav-item py-1 mx-sm-1" role="presentation">
        <a class="border nav-link py-1 h-100 fw-normal" href="<?php echo $link;?>/" aria-current="page"><?php echo $detail; ?></a>
        <?php if ($flowers_only_button != "") { ?>
      <li class="nav-item py-1 mx-sm-1" role="presentation">
        <a class="border nav-link py-1 h-100 fw-normal" href="<?php echo $link;?>/?show_flowers=1"><?php echo $flowers_only_button;?></a>
      </li>
      <?php } else if ($extra_buttons != "") { ?>
      <li class="nav-item py-1 mx-sm-1" role="presentation">
        <a class="border nav-link py-1 h-100 fw-normal" href="<?php echo $link;?>/?show_flowers=1"><?php echo $extra_buttons;?></a>
      </li>
      <li class="nav-item py-1 mx-sm-1" role="presentation">
        <a class="border nav-link py-1 h-100 fw-normal" href="<?php echo $link;?>/?show_trees=1">Plant Trees</a>
      </li>
      <?php } else if ($trees_only_button != "") { ?>
      <li class="nav-item py-1 mx-sm-1" role="presentation">
        <a class="border nav-link py-1 h-100 fw-normal" href="<?php echo $link;?>/?show_trees=1"><?php echo $trees_only_button;?></a>
      </li>
      <?php } ?>
    </ul>
    <div class="d-none d-sm-block" style="padding:5px 0 5px 225px">
      <hr>
    </div>
    <div class="d-block d-sm-none" style="padding:5px 10px 5px 10px">
      <hr>
    </div>
  </div>
</div>
