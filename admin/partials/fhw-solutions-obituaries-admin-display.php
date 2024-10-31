<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.obituary-assistant.com
 * @since      1.0.0
 *
 * @package    Fhw_Solutions_Obituaries
 * @subpackage Fhw_Solutions_Obituaries/admin/partials
 */
?>


<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php


?>

<h1><?php echo esc_html(get_admin_page_title()); ?></h1>

  <?php


        // Grab all options
        $options_1 = get_option($this->plugin_name . '_1');
        $options_2 = get_option($this->plugin_name . '_2');
        $options_3 = get_option($this->plugin_name . '_3');
        $validation_messages = get_option($this->plugin_name . '_validation_messages');
    		if ($validation_messages == false){
    			$this->update_validation_messages(array(), '');
        }
        
       

        // Set fhws values
        $username = (isset($options_1['username'])) ? $options_1['username'] : "";
        $password = (isset($options_1['password'])) ? $options_1['password']: "";
        $first_name = (isset($options_1['first_name'])) ? $options_1['first_name'] : "";
        $last_name = (isset($options_1['last_name'])) ? $options_1['last_name'] : "";
        $funeral_home_name = (isset($options_1['funeral_home_name'])) ? $options_1['funeral_home_name'] : "" ;
        $funeral_home_address = (isset($options_1['funeral_home_address'])) ? $options_1['funeral_home_address'] : "";
        $funeral_home_city = (isset($options_1['funeral_home_city'])) ? $options_1['funeral_home_city'] : "";
        $funeral_home_state = (isset($options_1['funeral_home_state'])) ? $options_1['funeral_home_state'] : "";
        $funeral_home_zip = (isset($options_1['funeral_home_zip'])) ? $options_1['funeral_home_zip'] : "";
        $funeral_home_country = (isset($options_1['funeral_home_country'])) ? $options_1['funeral_home_country'] : "";
        $funeral_home_website = (isset($options_1['funeral_home_website'])) ? $options_1['funeral_home_website'] : "";
        $funeral_home_email = (isset($options_1['funeral_home_email'])) ? $options_1['funeral_home_email'] : "";
        $funeral_home_phone = (isset($options_1['funeral_home_phone'])) ? $options_1['funeral_home_phone'] : "" ;
        $affiliate_id = (isset($options_1['affiliate_id'])) ? $options_1['affiliate_id']: "";
        $affiliate_pw = (isset($options_1['affiliate_pw'])) ? $options_1['affiliate_pw'] : "";

        // Config
        $obituary_page_name = (isset($options_2['obituary_page_name'])) ? $options_2['obituary_page_name'] : "" ;

        // for existing installs set default storefront colours
        if (!isset($options_3['navigation_style'])){

          $current = get_option($this->plugin_name . '_3');
          $add_style = array('navigation_style' => 'default');
          $new_array = $current + $add_style;
          update_option( $this->plugin_name . '_3', $new_array );
          $options_3['navigation_style'] = "default";

        }

        // Set flower storefront values
        $products = $options_3['products'];
        $navigation_style = $options_3['navigation_style'];
        $navigation_color = $options_3['navigation_color'];
        $navigation_hover_color = $options_3['navigation_hover_color'];
        $navigation_text_color = $options_3['navigation_text_color'];
        $navigation_hover_text_color = $options_3['navigation_hover_text_color'];
        $button_color = $options_3['button_color'];
        $button_hover_color = $options_3['button_hover_color'];
        $button_text_color = $options_3['button_text_color'];
        $button_hover_text_color = $options_3['button_hover_text_color'];
        $link_color = $options_3['link_color'];
        $heading_color = $options_3['heading_color'];
        $text_color = $options_3['text_color'];
        $products_per_page = $options_3['products_per_page'];
        $address_institution = $options_3['address_institution'];
        $address_1 = $options_3['address_1'];
        $address_city = $options_3['address_city'];
        $address_state = $options_3['address_state'];
        $address_country = $options_3['address_country'];
        $address_zipcode = $options_3['address_zipcode'];
        $address_phone = $options_3['address_phone'];
        $currency = $options_3['currency'];

        $errors = isset($validation_messages['errors']) ? $validation_messages['errors'] : "";
        $success_message = isset($validation_messages['success_message']) ? $validation_messages['success_message'] : "";

  ?>



  <div id="fhw-solutions-obituaries-admin-accordion">
   <!--<div>-->

  <h3><?php esc_html_e( 'Sign Up and Account Information', 'obituary-assistant-by-funeral-home-website-solutions' );?></h3>
  <div>

    <!-- signed in -->
    <table class="" style="<?php echo strlen($username) > 0 && $username != 'fhws_sample' ? 'display: block;' : 'display: none;' ?>">
      <tr>
        <td><h3>Welcome <?php echo $funeral_home_name ?><h3></td>
      </tr>
      <tr>
        <td>Username</td>
        <td><?php echo $username ?></td>
      </tr>
      <tr>
        <td>Password</td>
        <td><?php echo $password ?></td>
      </tr>
      <tr>
        <td>
          <form method="post" name="options_4" action="options.php" class="sign-out" style="<?php echo strlen($username) > 0 ? 'display: block;' : 'display: none;' ?>">
            <?php
              settings_fields($this->plugin_name . '_4');
              do_settings_sections($this->plugin_name . '_4');
            ?>
            <?php submit_button('Sign Out', 'secondary','submit_4', TRUE); ?>
          </form>
        </td>
      </tr>
    </table>

    <form method="post" name="options_1" action="options.php" class="options_1" id="options_1">
      <?php
        settings_fields($this->plugin_name . '_1');
        do_settings_sections($this->plugin_name . '_1');
      ?>
      <table class="sign-up-form" width="100%" style="<?php echo strlen($username) < 1 || $username == 'fhws_sample'  ? 'display: block;' : 'display: none;' ?>">
        <tr>
          <td width="250"><h3>Sign Up</h3></td>
          <td><a href="#" class="sign-in button button-secondary">Already have an account?</a></td>
        </tr>
        <tr>
          <td>Your First Name *</td>
          <td>
            <fieldset>
              <input type="text" id="<?php echo $this->plugin_name . '_1'; ?>-first_name" name="<?php echo $this->plugin_name . '_1'; ?>[first_name]" value="<?php // echo($first_name); ?>" />
            </fieldset>
          </td>
        </tr>
        <tr>
          <td>Your Last Name *</td>
          <td>
            <fieldset>
              <input type="text" id="<?php echo $this->plugin_name . '_1'; ?>-last_name" name="<?php echo $this->plugin_name . '_1'; ?>[last_name]" value="<?php // echo($last_name); ?>" />
            </fieldset>
          </td>
        </tr>
        <tr>
          <td>Funeral Home Name *</td>
          <td>
            <fieldset>
              <input type="text" id="<?php echo $this->plugin_name . '_1'; ?>-funeral_home_name" name="<?php echo $this->plugin_name . '_1'; ?>[funeral_home_name]" value="<?php // echo($funeral_home_name); ?>" />
            </fieldset>
          </td>
        </tr>
        <tr>
          <td>City *</td>
          <td>
            <fieldset>
              <input type="text" id="<?php echo $this->plugin_name . '_1'; ?>-funeral_home_city" name="<?php echo $this->plugin_name . '_1'; ?>[funeral_home_city]" value="<?php // echo($funeral_home_city); ?>" />
            </fieldset>
          </td>
        </tr>
        <tr>
          <td>State / Province *</td>
          <td>
            <fieldset>
              <select id="<?php echo $this->plugin_name . '_1'; ?>-funeral_home_state" name="<?php echo $this->plugin_name . '_1'; ?>[funeral_home_state]">
                <?php include 'admin-state-list.php'; ?>
              </select>
            </fieldset>
          </td>
        </tr>
        <tr>
          <td>Country *</td>
          <td>
            <fieldset>
              <select id="<?php echo $this->plugin_name . '_1'; ?>-funeral_home_country" name="<?php echo $this->plugin_name . '_1'; ?>[funeral_home_country]">
                <?php include 'admin-country-list.php'; ?>
              </select>
            </fieldset>
          </td>
        </tr>
        <tr>
          <td>Zip / Postal Code *</td>
          <td>
            <fieldset>
              <input type="text" id="<?php echo $this->plugin_name . '_1'; ?>-funeral_home_zip" name="<?php echo $this->plugin_name . '_1'; ?>[funeral_home_zip]" value="<?php // echo($funeral_home_zip); ?>" />
            </fieldset>
          </td>
        </tr>
        <tr>
          <td>Website *</td>
          <td>
            <fieldset>
              <input type="text" id="<?php echo $this->plugin_name . '_1'; ?>-funeral_home_website" name="<?php echo $this->plugin_name . '_1'; ?>[funeral_home_website]" value="<?php // echo($funeral_home_website); ?>" />
            </fieldset>
          </td>
        </tr>
        <tr>
          <td>Email *</td>
          <td>
            <fieldset>
              <input type="text" id="<?php echo $this->plugin_name . '_1'; ?>-funeral_home_email" name="<?php echo $this->plugin_name . '_1'; ?>[funeral_home_email]" value="<?php // echo($funeral_home_website); ?>" />
            </fieldset>
          </td>
        </tr>
        <tr>
          <td>Description Of Plugin Use *</td>
          <td>
            <fieldset>
              <textarea id="<?php echo $this->plugin_name . '_1'; ?>-funeral_home_description" name="<?php echo $this->plugin_name . '_1'; ?>[funeral_home_description]" rows="8" cols="40"><?php // echo($funeral_home_description_display); ?></textarea>
            </fieldset>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <?php submit_button('Create Account', 'primary','submit_1', TRUE); ?>
          </td>
        </tr>
      </table>
    </form>

    <form method="post" name="options_5" action="options.php" class="options_5" id="options_5">
      <?php
        settings_fields($this->plugin_name . '_1');
        do_settings_sections($this->plugin_name . '_1');
      ?>
      <table class="sign-in-form" style="display: none">
        <tr>
          <td><h3>Sign In</h3></td>
          <td><a href="#" class="sign-up button button-secondary">Create A New Account</a></td>
        </tr>
        <tr>
          <td>Username</td>
          <td>
            <fieldset>
              <input type="text" id="<?php echo $this->plugin_name . '_1'; ?>-username" name="<?php echo $this->plugin_name . '_1'; ?>[username]" value="<?php echo $username != 'fhws_sample' ? $username :  ''; ?>" />
            </fieldset>
          </td>
        </tr>
        <tr>
          <td>Password</td>
          <td>
            <fieldset>
              <input type="password" id="<?php echo $this->plugin_name . '_1'; ?>-password" name="<?php echo $this->plugin_name . '_1'; ?>[password]" value="<?php echo $username != 'fhws_sample' ? $password : ';' ?>" />
            </fieldset>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <?php submit_button('Sign In', 'primary','submit_5', TRUE); ?>
          </td>
        </tr>
      </table>
    </form>

  </div>


  <?php if ( strlen( $username ) > 0 && $username != 'fhws_sample' ) : ?>

  <h3><?php esc_html_e( 'Setup', 'obituary-assistant-by-funeral-home-website-solutions' );?></h3>
  <div>
    <form method="post" name="options_2" action="options.php">
      <?php
        settings_fields($this->plugin_name . '_2');
        do_settings_sections($this->plugin_name . '_2');
      ?>
      <table>
        <tr>
          <td colspan="2">
            <h3><?php esc_html_e( 'Overview', 'obituary-assistant-by-funeral-home-website-solutions' );?></h3>
            <ol>
              <li><?php esc_html_e( 'Create Your Main Obituaries Page', 'obituary-assistant-by-funeral-home-website-solutions' );?></li>
              <li><?php esc_html_e( 'Let Us Know About Your Obituaries Page', 'obituary-assistant-by-funeral-home-website-solutions' );?></li>
            </ol>
            <h3><?php esc_html_e( 'Create Your Main Obituaries Page', 'obituary-assistant-by-funeral-home-website-solutions' );?></h3>
            <ul class="fhw-solutions-obituaries-admin-list">
              <li><?php esc_html_e( 'Create Your Main Obituaries Page', 'obituary-assistant-by-funeral-home-website-solutions' );?></li>
              <li><?php esc_html_e( 'We recommend naming this page “obituaries”', 'obituary-assistant-by-funeral-home-website-solutions' );?></li>
              <li><?php esc_html_e( 'Your page name will be used in your obituary url structure', 'obituary-assistant-by-funeral-home-website-solutions' );?></li>
              <li><?php esc_html_e( 'Example:', 'obituary-assistant-by-funeral-home-website-solutions' );?></li>
              <ul>
                <li><?php esc_html_e( 'Your page is named “obituaries”', 'obituary-assistant-by-funeral-home-website-solutions' );?></li>
                <li><?php esc_html_e( 'http://[your site]/obituaries/', 'obituary-assistant-by-funeral-home-website-solutions' );?></li>
                <li><?php esc_html_e( 'http://[your site]/obituaries/name-of-deceased/', 'obituary-assistant-by-funeral-home-website-solutions' );?></li>
              </ul>
              <li><?php esc_html_e( "Add the short code '[obituaries]' to the body of your page", 'obituary-assistant-by-funeral-home-website-solutions' );?></li>
              <li><?php esc_html_e( "Create your page ", 'obituary-assistant-by-funeral-home-website-solutions' ) ;?><a href="post-new.php?post_type=page"><?php esc_html_e( "here", 'obituary-assistant-by-funeral-home-website-solutions' ) ;?></a></li>
            </ul>
            <h3><?php esc_html_e( 'Let Us Know About Your Obituaries Page', 'obituary-assistant-by-funeral-home-website-solutions' );?></h3>
          </td>
        </tr>
        <tr>
          <td><?php esc_html_e( 'Which of your pages will be used for obituaries?', 'obituary-assistant-by-funeral-home-website-solutions' );?></td>
          <td>
            <p>
              <select id="<?php echo $this->plugin_name . '_2'; ?>-obituary_page_name" name="<?php echo $this->plugin_name . '_2'; ?>[obituary_page_name]">
                <option value=""> <?php echo esc_attr( __( 'Select Page' ) ); ?></option>
                <?php
                  $pages = get_pages();
                  foreach ( $pages as $page ) {
                    $option = '<option value="' . $page->post_name .'"';
                    if ($obituary_page_name == $page->post_name){
                      $option .=  ' selected="selected"';
                    }
                    $option .=  '">';
                    $option .= $page->post_title;
                    $option .= '</option>';
                    echo $option;
                  }
                ?>
              </select>
            </p>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <?php submit_button('Save all changes', 'primary','submit_2', TRUE); ?>
          </td>
          <td></td>
        </tr>
      </table>
    </form>
  </div>

  <h3>Manage Obituaries</h3>
  <div>
    <table>
      <tr>
        <td colspan="2">
          <p>To add, modify, or delete obituaries - <a href="https://www.obituary-assistant.com/login" target="_new">click here</a> and log in with your Obituary Assistant credentials.</p>
        </td>
      </tr>
      <tr>
        <td>Username</td>
        <td><?php echo $username != 'fhws_sample' ? $username  : '' ?></td>
      </tr>
      <tr>
        <td>Password</td>
        <td><?php echo $username != 'fhws_sample' ? $password : '' ?></td>
      </tr>
    </table>
  </div>

  <!-- flower storefront settings -->
  <?php if ($client_account_type == 0 || $client_account_type == 2) : ?>
    <h3>Flower Storefront Settings</h3>
    <div>
      <form method="post" name="options_3" action="options.php">
        <?php
          settings_fields($this->plugin_name . '_3');
          do_settings_sections($this->plugin_name . '_3');
        ?>
        <table>
          <tr>
            <td><h3>Affiliate</h3></td>
            <td></td>
          </tr>
          <tr>
            <td>Affiliate ID</td>
            <td>
              <!-- <fieldset>
                <input type="text" id="<?php echo $this->plugin_name . '_3'; ?>-affiliate_id" name="<?php echo $this->plugin_name . '_3'; ?>[affiliate_id]" value="<?php echo $affiliate_id ?>" />
              </fieldset> -->
              <?php echo $affiliate_id ?>
            </td>
          </tr>
          <tr>
            <td>Password</td>
            <td>
              <?php echo $affiliate_pw ?>
            </td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">
              To check your commissions, <a href="https://www.floristone.com/affiliate/aff_manager/" target="_new">login at Florist One</a>.
            </td>
          </tr>
          <tr>
            <td colspan="2"><hr /></td>
          </tr>
          <tr class="autopop-address">
            <td colspan="2"><h3>Flower Delivery Address</h3></td>
          </tr>
          <tr class="autopop-address">
            <td colspan="2">
              The delivery address for flowers is controlled by the obituary at Obituary-Assistant.com <a href="https://www.obituary-assistant.com/login" target="_new">Click here</a> and log in with your Obituary Assistant credentials.
            </td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>Username</td>
            <td><?php echo $username != 'fhws_sample' ? $username  : '' ?></td>
          </tr>
          <tr>
            <td>Password</td>
            <td><?php echo $username != 'fhws_sample' ? $password : '' ?></td>
          </tr>
          <tr class="autopop-address">
            <td colspan="2"><hr /></td>
          </tr>
          <tr>
            <td colspan="2"><h3>Flower Storefront Colors</h3></td>
          </tr>
          <tr>
            <td colspan="2">
              <h4><input type="radio" onclick="changeStorefrontColors(this);"  name="<?php echo $this->plugin_name . '_3';?>[navigation_style]" value="default" <?php checked("default", $navigation_style, true); ?>>Use default storefront colors</h4>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <h4 style="margin-top:0"><input type="radio" onclick="changeStorefrontColors(this);" name="<?php echo $this->plugin_name . '_3';?>[navigation_style]" value="custom" <?php checked("custom", $navigation_style, true); ?>>Choose your own storefront colors</h4>
            </td>
          </tr>
        </table>
        <table id="flower-navigation-colors-options" style="<?php if($navigation_style == 'default') echo 'display:none';?>">
          <tr>
            <td colspan="2"><h4>Navigation</h4></td>
          </tr>
          <tr>
            <td>Color 1</td>
            <td>
              <fieldset class="<?php echo $this->plugin_name . '_3';?>-admin-colors">
                <label for="<?php echo $this->plugin_name . '_3';?>-navigation_color">
                  <!-- <span class="florist-one-delivery-admin-config-label"><?php esc_attr_e('Background', $this->plugin_name . '_3');?></span> -->
                  <input type="text" class="<?php echo $this->plugin_name . '_3';?>-color-picker" id="<?php echo $this->plugin_name . '_3';?>-navigation_color" name="<?php echo $this->plugin_name . '_3';?>[navigation_color]" value="<?php echo $navigation_color;?>" />
                </label>
              </fieldset>
            </td>
          </tr>
          <tr>
            <td>Color 2</td>
            <td>
              <fieldset class="<?php echo $this->plugin_name . '_3';?>-admin-colors">
                <label for="<?php echo $this->plugin_name . '_3';?>-navigation_hover_color">
                  <!-- <span class="florist-one-delivery-admin-config-label"><?php esc_attr_e('Background', $this->plugin_name . '_3');?></span> -->
                  <input type="text" class="<?php echo $this->plugin_name . '_3';?>-color-picker" id="<?php echo $this->plugin_name . '_3';?>-navigation_hover_color" name="<?php echo $this->plugin_name . '_3';?>[navigation_hover_color]" value="<?php echo $navigation_hover_color;?>" />
                </label>
              </fieldset>
            </td>
          </tr>
          <tr>
            <td>Text Color</td>
            <td>
              <fieldset class="<?php echo $this->plugin_name . '_3';?>-admin-colors">
                <label for="<?php echo $this->plugin_name . '_3';?>-navigation_text_color">
                  <!-- <span class="florist-one-delivery-admin-config-label"><?php esc_attr_e('Text', $this->plugin_name . '_3');?></span> -->
                  <input type="text" class="<?php echo $this->plugin_name . '_3';?>-color-picker" id="<?php echo $this->plugin_name . '_3';?>-navigation_text_color" name="<?php echo $this->plugin_name . '_3';?>[navigation_text_color]" value="<?php echo $navigation_text_color;?>" />
                </label>
              </fieldset>
            </td>
          </tr>
          <tr>
            <td>Hover Text Color</td>
            <td>
              <fieldset class="<?php echo $this->plugin_name . '_3';?>-admin-colors">
                <label for="<?php echo $this->plugin_name . '_3';?>-navigation_hover_text_color">
                  <!-- <span class="florist-one-delivery-admin-config-label"><?php esc_attr_e('Text', $this->plugin_name . '_3');?></span> -->
                  <input type="text" class="<?php echo $this->plugin_name . '_3';?>-color-picker" id="<?php echo $this->plugin_name . '_3';?>-navigation_hover_text_color" name="<?php echo $this->plugin_name . '_3';?>[navigation_hover_text_color]" value="<?php echo $navigation_hover_text_color;?>" />
                </label>
              </fieldset>
            </td>
          </tr>
          <tr>
            <td colspan="2"><h4>Buttons</h4></td>
          </tr>
          <tr>
            <td>Color 1</td>
            <td>
              <fieldset class="<?php echo $this->plugin_name . '_3';?>-admin-colors">
                <label for="<?php echo $this->plugin_name . '_3';?>-button_color">
                  <!-- <span class="florist-one-delivery-admin-config-label"><?php esc_attr_e('Background', $this->plugin_name . '_3');?></span> -->
                  <input type="text" class="<?php echo $this->plugin_name . '_3';?>-color-picker" id="<?php echo $this->plugin_name . '_3';?>-button_color" name="<?php echo $this->plugin_name . '_3';?>[button_color]" value="<?php echo $button_color;?>" />
                </label>
              </fieldset>
            </td>
          </tr>
          <tr>
            <td>Color 2</td>
            <td>
              <fieldset class="<?php echo $this->plugin_name . '_3';?>-admin-colors">
                <label for="<?php echo $this->plugin_name . '_3';?>-button_hover_color">
                  <!-- <span class="florist-one-delivery-admin-config-label"><?php esc_attr_e('Background', $this->plugin_name . '_3');?></span> -->
                  <input type="text" class="<?php echo $this->plugin_name . '_3';?>-color-picker" id="<?php echo $this->plugin_name . '_3';?>-button_hover_color" name="<?php echo $this->plugin_name . '_3';?>[button_hover_color]" value="<?php echo $button_hover_color;?>" />
                </label>
              </fieldset>
            </td>
          </tr>
          <tr>
            <td>Text Color</td>
            <td>
              <fieldset class="<?php echo $this->plugin_name . '_3';?>-admin-colors">
                <label for="<?php echo $this->plugin_name . '_3';?>-button_text_color">
                  <!-- <span class="florist-one-delivery-admin-config-label"><?php esc_attr_e('Text', $this->plugin_name . '_3');?></span> -->
                  <input type="text" class="<?php echo $this->plugin_name . '_3';?>-color-picker" id="<?php echo $this->plugin_name . '_3';?>-button_text_color" name="<?php echo $this->plugin_name . '_3';?>[button_text_color]" value="<?php echo $button_text_color;?>" />
                </label>
              </fieldset>
            </td>
          </tr>
          <tr>
            <td>Hover Text Color</td>
            <td>
              <fieldset class="<?php echo $this->plugin_name . '_3';?>-admin-colors">
                <label for="<?php echo $this->plugin_name . '_3';?>-button_hover_text_color">
                  <!-- <span class="florist-one-delivery-admin-config-label"><?php esc_attr_e('Text', $this->plugin_name . '_3');?></span> -->
                  <input type="text" class="<?php echo $this->plugin_name . '_3';?>-color-picker" id="<?php echo $this->plugin_name . '_3';?>-button_hover_text_color" name="<?php echo $this->plugin_name . '_3';?>[button_hover_text_color]" value="<?php echo $button_hover_text_color;?>" />
                </label>
              </fieldset>
            </td>
          </tr>
          <tr>
            <td colspan="2"><h4>Other Color Options</h4></td>
          </tr>
          <tr>
            <td>Link Color</td>
            <td>
              <fieldset class="<?php echo $this->plugin_name . '_3';?>-admin-colors">
                <input type="text" class="<?php echo $this->plugin_name . '_3';?>-color-picker" id="<?php echo $this->plugin_name . '_3';?>-link_color" name="<?php echo $this->plugin_name . '_3';?>[link_color]" value="<?php echo $link_color;?>" />
              </fieldset>
            </td>
            <td></td>
          </tr>
          <tr>
            <td>Heading Color</td>
            <td>
              <fieldset class="<?php echo $this->plugin_name . '_3';?>-admin-colors">
                <input type="text" class="<?php echo $this->plugin_name . '_3';?>-color-picker" id="<?php echo $this->plugin_name . '_3';?>-heading_color" name="<?php echo $this->plugin_name . '_3';?>[heading_color]" value="<?php echo $heading_color;?>" />
              </fieldset>
            </td>
            <td></td>
          </tr>
          <tr>
            <td>Text Color</td>
            <td>
              <fieldset class="<?php echo $this->plugin_name . '_3';?>-admin-colors">
                <input type="text" class="<?php echo $this->plugin_name . '_3';?>-color-picker" id="<?php echo $this->plugin_name . '_3';?>-text_color" name="<?php echo $this->plugin_name . '_3';?>[text_color]" value="<?php echo $text_color;?>" />
              </fieldset>
            </td>
            <td></td>
          </tr>
        </table>
        <table>
          <tr>
            <td colspan="2">
              <?php submit_button('Save all changes', 'primary','submit_3', TRUE); ?>
            </td>
            <td></td>
          </tr>
        </table>

      </form>
    </div>
  <?php endif; ?>

  <h3><?php esc_html_e( 'Optional Setup', 'obituary-assistant-by-funeral-home-website-solutions' );?></h3>
  <div>
  <p><?php esc_html_e("The following widgets are optional and do not need to be installed for you to use Obituary Assistant", 'obituary-assistant-by-funeral-home-website-solutions')?></p>
  <h3><?php esc_html_e( 'Recent Obituaries', 'obituary-assistant-by-funeral-home-website-solutions' );?></h3>
  <ul class="fhw-solutions-obituaries-admin-list">
    <li><?php esc_html_e( 'These are obituary snippets that can appear on your homepage in addition to your main obituaries page', 'obituary-assistant-by-funeral-home-website-solutions' );?></li>
    <li><?php esc_html_e( 'Use the generator below to create a shortcode, copy it, then paste it into the page where you want Recent Obituaries to appear', 'obituary-assistant-by-funeral-home-website-solutions' );?></li>
  </ul>
  <div style="padding-left:25px">
    <form>
      <table class="fhw-solutions-obituaries-admin-shortcode">
        <tbody>
          <tr>
            <td>
              <p><?php esc_html_e( 'Position', 'obituary-assistant-by-funeral-home-website-solutions' );?></p>
              <select name="recent-obit-shortcode" id="recent-obit-pos">
                <option value="left">left</option>
                <option value="right">right</option>
              </select>
            </td>
            <td>
              <p><?php esc_html_e( 'Orientation', 'obituary-assistant-by-funeral-home-website-solutions' );?></p>
              <select name="recent-obit-shortcode" id="recent-obit-ori">
                <option value="horizontal">horizontal</option>
                <option value="vertical">vertical</option>
              </select>
            </td>
            <td>
            <p><?php esc_html_e( 'Number', 'obituary-assistant-by-funeral-home-website-solutions' );?></p>
              <select name="recent-obit-shortcode" id="recent-obit-count">
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
              </select>
            </td>
          </tr>
          </tbody>
        </table>
      </form>
      <pre id="p1" class="short-code"><?php esc_html_e( '[obituary-assistant-show-recent-obituaries position="left" orientation="horizontal" count="5"]', 'obituary-assistant-by-funeral-home-website-solutions' );?></pre>
      <button class="copy-short-code button button-secondary" onclick="copyToClipboard('#p1')">Copy Shortcode</button>
    </div>
 <hr style="margin:25px 0;">

  <h3><?php esc_html_e( 'Obituary Subscription', 'obituary-assistant-by-funeral-home-website-solutions' );?></h3>
  <div style="padding-left:25px">
    <ul class="fhw-solutions-obituaries-admin-list">
      <li><?php esc_html_e( 'Your main obituaries page automatically contains a subscription button', 'obituary-assistant-by-funeral-home-website-solutions' );?></li>
      <li><?php esc_html_e( 'Obituary Subscription allows visitors to receive notifications when new obituaries are added to your website', 'obituary-assistant-by-funeral-home-website-solutions' );?></li>
      <li><?php esc_html_e( 'Copy the shortcode below, then paste it into the page where you want your additional subscription button to appear', 'obituary-assistant-by-funeral-home-website-solutions' );?></li>
    </ul>
    <pre id="p2" class="short-code"><?php esc_html_e( '[OBITUARY_SUBSCRIPTION]', 'obituary-assistant-by-funeral-home-website-solutions' );?></pre>
    <button class="copy-short-code button button-secondary" onclick="copyToClipboard('#p2')">Copy Shortcode</button>
  </div>
  <hr style="margin:25px 0;">
  <h3><?php esc_html_e( 'Standalone Flower Storefront', 'obituary-assistant-by-funeral-home-website-solutions' );?></h3>
  <div style="padding-left:25px">
    <ul class="fhw-solutions-obituaries-admin-list">
      <li><?php esc_html_e( 'A flower storefront is automatically created and connected to each obituary when you install Obituary Assistant', 'obituary-assistant-by-funeral-home-website-solutions' );?></li>
      <li><?php esc_html_e( 'This standalone flower storefront is separate and not connected to any obituaries', 'obituary-assistant-by-funeral-home-website-solutions' );?></li>
      <li><?php esc_html_e( 'Link to it from any page on your site to encourage visitors to send flowers without visiting an obituary', 'obituary-assistant-by-funeral-home-website-solutions' );?></li>
      <li><?php esc_html_e( 'Copy the shortcode below and then paste it into the page where you want your standalone flower storefront to appear', 'obituary-assistant-by-funeral-home-website-solutions' );?></li>
    </ul>
    <pre id="p3" class="short-code"><?php esc_html_e( '[flower-delivery] ', 'obituary-assistant-by-funeral-home-website-solutions' );?></pre>
    <button class="copy-short-code button button-secondary" onclick="copyToClipboard('#p3')">Copy Shortcode</button>
  </div>
</div>




  <?php endif; ?>

  <input type="hidden" name="<?php echo $this->plugin_name . '_1'; ?>[errors]" id="<?php echo $this->plugin_name . '_1'; ?>-errors" value="<?php echo htmlspecialchars(json_encode($errors)); ?>" />
  <input type="hidden" name="<?php echo $this->plugin_name . '_1'; ?>[success_message]" id="<?php echo $this->plugin_name . '_1'; ?>-success_message" value="<?php echo htmlspecialchars(json_encode($success_message)); ?>" />
  <?php
    $this->update_validation_messages(array(), '');
  ?>

</div>

  <!----------->


<script type="text/javascript">

  function changeStorefrontColors(buttonOption) {
    var optionTable = document.getElementById("flower-navigation-colors-options");
    if (buttonOption.value == "default"){
      optionTable.style.display = "none"
    } else {
      optionTable.style.display = "block"
    }
  }

</script>
