<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.obituary-assistant.com
 * @since      1.0.0
 *
 * @package    Fhw_Solutions_Obituaries
 * @subpackage Fhw_Solutions_Obituaries/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Fhw_Solutions_Obituaries
 * @subpackage Fhw_Solutions_Obituaries/includes
 * @author     Philip Perry <phil@fhwsolutions.com>
 */
class Fhw_Solutions_Obituaries_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		$options = array(
			'username' => 'fhws_sample',
			'password' => 'password',
			'first_name' => '',
      'last_name' => '',
      'funeral_home_name' => '',
      'funeral_home_address' => '',
      'funeral_home_city' => '',
      'funeral_home_state' => '',
      'funeral_home_zip' => '',
      'funeral_home_country' => '',
      'funeral_home_website' => '',
      'funeral_home_email' => '',
      'funeral_home_phone' => '',
      'affiliate_id' => '',
      'affiliate_pw' => ''
		);
		add_option( 'fhw-solutions-obituaries_1', $options );

		$options = array(
			'products' => 1,
			'navigation_style' => "default",
			'navigation_color' => '#8db6d9',
			'navigation_hover_color' => '#18477d',
			'navigation_text_color' => '#FFF',
			'navigation_hover_text_color' => '#000',
			'button_color' => '#8db6d9',
			'button_hover_color' => '#8db6d9',
			'button_text_color' => '#FFF',
			'button_hover_text_color' => '#000',
			'link_color' => '#18477d',
			'heading_color' => '#000',
			'text_color' => '#000',
			'products_per_page' => 12,
			'address_institution' => '',
			'address_1' => '',
			'address_city' => '',
			'address_state' => '',
			'address_zipcode' => '',
			'address_country' => '',
			'address_phone' => '',
			'currency' => 'u',
			'affiliate_id' => '0',
			'flower_storefront_id' => 0
		);
		add_option( 'fhw-solutions-obituaries_3', $options);

	}

}
