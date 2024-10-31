<?php

  /**
   * @link       https://www.obituary-assistant.com
   * @since      7.2.0
   *
   * @package    Fhw_Solutions_Obituaries
   * @subpackage Fhw_Solutions_Obituaries/public/partials
   */

?>

<nav aria-label="bottomobitnav">
  <ul class="ps-3 ms-0 pagination">
    <li class="page-item ms-auto <?php if($page < 2){echo "disabled";}?>">
      <?php
        if ($page < 2) {
            echo '<a class="page-link" tabindex="-1" aria-disabled="true" href="' . $actual_link . '/">&laquo; ' . $previous . '</a>';
        } else {
            echo '<a class="page-link" aria-disabled="false" aria-label="Previous" href="' . $actual_link . '/' . ($page - 1) . '/">&laquo; ' .  $previous . '</a>';
        }
      ?>
    </li>
    <li class="page-item <?php if($totalpages <= $page){echo "disabled";}?>">
      <?php
        if ($totalpages < $page) {
          echo '<a class="page-link" tabindex="-1" aria-disabled="true" href="' . $actual_link . '/' . ($page + 1) . '/">' . $more . ' &raquo;</a>';
        } else {
          echo '<a class="page-link" aria-disabled="false" aria-label="next" href="' . $actual_link . '/' . ($page + 1) . '/">' . $more . ' &raquo;</a>';
        }
      ?>
    </li>
  </ul>
</nav>
