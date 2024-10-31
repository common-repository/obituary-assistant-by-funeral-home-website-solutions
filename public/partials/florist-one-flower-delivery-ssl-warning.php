<?php

  if(get_option('fhw-solutions-obituaries_1') !== null ){

    $config_options = get_option('fhw-solutions-obituaries_1');

    if ($config_options['affiliate_id'] == 0 && $config_options_aff['account_type'] != 7){
      echo '<div class="florist-one-flower-delivery-ssl-warning">&#9888; A valid Florist One AffiliateID is required for the Florist One Flower Delivery plugin to work!</div>';
    }

  }


?>
