<?php

/**
 * The admin_specific functionality of the plugin.
 *
 * @link       https://www.obituary-assistant.com
 * @since      1.0.0
 *
 * @package    Fhw_Solutions_Obituaries
 * @subpackage Fhw_Solutions_Obituaries/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Fhw_Solutions_Obituaries
 * @subpackage Fhw_Solutions_Obituaries/admin
 * @author     Philip Perry <phil@fhwsolutions.com>
 */
class Fhw_Solutions_Obituaries_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style('jquery-ui', plugin_dir_url(__FILE__) . 'css/jquery-ui.css', array(), $this->version, 'all');
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/fhw-solutions-obituaries-admin.css', array( 'wp-color-picker', 'jquery-ui' ), $this->version, 'all');
    }

    /**
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script('jquery-ui-accordion');
        wp_enqueue_script('jquery-validate', plugin_dir_url(__FILE__) . 'js/jquery.validate.js', array( 'jquery' ), $this->version, false);
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/fhw-solutions-obituaries-admin.js', array( 'jquery', 'wp-color-picker' ), $this->version, false);
    }

    public function add_plugin_admin_menu()
    {


        add_menu_page(  __( 'Obituary Assistant', 'obituary-assistant-by-funeral-home-website-solutions' ),   __( 'Obituary Assistant', 'obituary-assistant-by-funeral-home-website-solutions' ), 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page'), 'dashicons-id-alt', 65);

        array($this, 'initialize_option_variables');



    }

    public function initialize_option_variables()
    {
        delete_option('fhw-solutions-obituaries_1');

        $options_1 = array(
            'username' => 'fhws_sample',
            'password' => 'password',
            'currency' => 'u',
            'affiliate_id' => '0',
            'account_type' => 0,
            'stripe_connect_account_id' => ''
        );
        add_option('fhw-solutions-obituaries_1', $options_1);

        if (get_option('fhw-solutions-obituaries_2') == false) {
            $options_2 = array(
                'obituary_page_name' => ''
            );
            add_option('fhw-solutions-obituaries_2', $options_2);
        }

        if (get_option('fhw-solutions-obituaries_3') == false) {
                $options_3 = array(
                    'navigation_style' => 'default',
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
                    'address_country' => ''
                );
            add_option('fhw-solutions-obituaries_3', $options_3);
        }

    }

    public function add_action_links($links)
    {
        $settings_link = array(
    '<a href="' . admin_url('options-general.php?page=' . $this->plugin_name) . '">' . __('Settings', $this->plugin_name) . '</a>',
   );
        return array_merge($settings_link, $links);
    }



    public function display_plugin_setup_page()
    {
        $options_1 = get_option($this->plugin_name . '_1');
        $username = $options_1['username'];
        $password = $options_1['password'];
        if ($username != 'fhws_sample'){
          $client_account_type = $this->getAccountType($username, $password);
        }
        include_once('partials/fhw-solutions-obituaries-admin-display.php');
    }


    // sign up
    public function options_update_1()
    {
        register_setting($this->plugin_name . '_1', $this->plugin_name . '_1', array($this, 'validate_1'));
    }

    // main obit page config
    public function options_update_2()
    {
        register_setting($this->plugin_name . '_2', $this->plugin_name . '_2', array($this, 'validate_2'));
        flush_rewrite_rules();
    }

    // flower options
    public function options_update_3()
    {
        register_setting($this->plugin_name . '_3', $this->plugin_name . '_3', array($this, 'validate_3'));
    }

    // sign out
    public function options_update_4()
    {
        register_setting($this->plugin_name . '_4', $this->plugin_name . '_4', array($this, 'initialize_option_variables'));
    }

    // sign in
    public function options_update_5()
    {
        register_setting($this->plugin_name . '_1', $this->plugin_name . '_1', array($this, 'validate_1'));
    }

    public function update_validation_messages($errors, $success_message)
    {
        $validation_messages = get_option($this->plugin_name . '_validation_messages');
        if ($validation_messages == false) {
            add_option($this->plugin_name . '_validation_messages', array());
            $validation_messages = get_option($this->plugin_name . '_validation_messages');
        }
        $validation_messages['errors'] = $errors;
        $validation_messages['success_message'] = $success_message;
        update_option($this->plugin_name . '_validation_messages', $validation_messages);
    }

    public function validate_1($input)
    {
        $valid = array();
        $errors = array();
        $success_message = '';

          error_log(print_r("yes",true));

        if (isset($input['first_name']) && strlen($input['first_name']) > 0) {

            // user sign up

            $username = 'fhws_sample';
            $password = 'password';
            $affiliateid = $input['affiliate_id'];

            $data = array(
                'first_name' => sanitize_text_field($input['first_name']),
                'last_name' => sanitize_text_field($input['last_name']),
                'funeral_home_name' => sanitize_text_field($input['funeral_home_name']),
                'funeral_home_city' => sanitize_text_field($input['funeral_home_city']),
                'funeral_home_state' => sanitize_text_field($input['funeral_home_state']),
                'funeral_home_zipcode' => sanitize_text_field($input['funeral_home_zip']),
                'funeral_home_website' => sanitize_text_field($input['funeral_home_website']),
                'funeral_home_email' => sanitize_email($input['funeral_home_email']),
                'funeral_home_country' => sanitize_text_field($input['funeral_home_country']),
                'funeral_home_description' => sanitize_text_field($input['funeral_home_description']),
                'version' => '7.2.3'
            );

            $args = array(
                    'method' => 'POST',
                    'httpversion' => '1.1',
                    'sslverify' => true,
                    'headers' => array(
                        'Authorization' => 'Basic '.base64_encode($username . ':' . $password)
                    ),
                    'body' => $data
            );
            $headers = array(
              'Authorization: Basic '.base64_encode($username . ':' . $password)
            );
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => (!OBITUARY_ASSISTANT_DEBUG_MODE ? 'https://www.obituary-assistant.com/api/rest/' : 'http://dev.obituary-assistant.com/api/rest/') . 'signUp',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => http_build_query($data),
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_SSL_VERIFYPEER => OBITUARY_ASSISTANT_VERIFYPEER
            ));

            $api_response = curl_exec($curl);
            $httpcode=curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            $api_response_body = json_decode( $api_response, true);

            $valid['username'] = sanitize_text_field($api_response_body['USERNAME']);
            $valid['password'] = sanitize_text_field($api_response_body['PASSWORD']);

            $status_code = $httpcode;
            if ($status_code == 403) {
                $valid['username'] = '';
                $valid['password'] = '';
                array_push($errors, 'Invalid username / Password combination.');
            } elseif ($status_code == 200) {
                if (isset($api_response_body['errors']) || $api_response_body['SUCCESS'] == false) {
                    $valid['username'] = '';
                    $valid['password'] = '';
                    for ($i=0;$i<count($api_response_body['errors']);$i++) {
                        array_push($errors, $api_response_body['errors'][$i]);
                    }
                } else {

                    // automatically log user in as sign up arroval no longer required

                    $log_in = $this->log_in($valid['username'], $valid['password']);

                    $valid = $log_in['valid'];
                    $errors = $log_in['errors'];
                    $success_message = $log_in['success_message'];

                }
            } else {
                $errors = array_push($errors, "An error occurred.");
            }
        } else {

            // existing user log in

            $valid['username'] = sanitize_text_field($input['username']);
            $valid['password'] = sanitize_text_field($input['password']);

            $log_in = $this->log_in($valid['username'], $valid['password']);

            $valid = $log_in['valid'];
            $errors = $log_in['errors'];
            $success_message = $log_in['success_message'];

        }

        $this->update_validation_messages($errors, $success_message);

        return $valid;
    }

    public function log_in($username, $password){

        // function that does the log in, used by regular log in and now after successful sign up as well (approval no longer needed)

        $valid = array();
        $errors = array();
        $success_message = '';

        $headers = array(
          'Authorization: Basic '.base64_encode($username . ':' . $password)
        );

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => (!OBITUARY_ASSISTANT_DEBUG_MODE ? 'https://www.obituary-assistant.com/api/rest/' : 'http://dev.obituary-assistant.com/api/rest/') . 'client',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER => OBITUARY_ASSISTANT_VERIFYPEER,
            CURLOPT_FORBID_REUSE => false,
            CURLOPT_FRESH_CONNECT =>  false,
            CURLOPT_HTTP_VERSION =>  CURL_HTTP_VERSION_1_1
        ));

        $api_response = curl_exec($curl);
        $httpcode=curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $api_response_body = json_decode($api_response, true);

        $status_code = $httpcode;
        if ($status_code == 403) {
            $valid['username'] = '';
            $valid['password'] = '';
            array_push($errors, 'Invalid username / Password combination');
        } elseif ($status_code == 401) {
            $valid['username'] = '';
            $valid['password'] = '';
            array_push($errors, 'Your account is not yet active. You will receive an email when it becomes active.');
        } elseif ($status_code == 200) {
            $valid['username'] = $username;
            $valid['password'] = $password;
            if ($valid['username'] != 'fhws_sample') {
                $success_message = "You have successfully signed in as " . $api_response_body['CLIENT_INFO']['CLIENT_NAME'] . ".";
            } else {
                $success_message = "You are now signed out.";
            }
        } else {
            $errors = array_push($errors, "An error occurred.");
        }

        $valid['first_name'] = '';
        $valid['last_name'] = '';
        $valid['funeral_home_name'] =  $api_response_body['CLIENT_INFO']['CLIENT_NAME'];
        $valid['funeral_home_city'] = $api_response_body['CLIENT_INFO']['CLIENT_CITY'];
        $valid['funeral_home_state'] = $api_response_body['CLIENT_INFO']['CLIENT_STATE'];
        $valid['funeral_home_zip'] = $api_response_body['CLIENT_INFO']['CLIENT_ZIP'];
        $valid['funeral_home_website'] = $api_response_body['CLIENT_INFO']['CLIENT_URL'];
        $valid['funeral_home_email'] = $api_response_body['CLIENT_INFO']['CLIENT_EMAIL'];
        $valid['affiliate_id'] = $api_response_body['CLIENT_INFO']['CLIENT_AFFILIATE_ID'];
        $valid['affiliate_pw'] = $api_response_body['CLIENT_INFO']['CLIENT_AFFILIATE_PW'];
        $valid['funeral_home_country'] = $api_response_body['CLIENT_INFO']['CLIENT_COUNTRY'];
        $valid['funeral_home_address'] = $api_response_body['CLIENT_INFO']['CLIENT_ADDRESS1'];
        $valid['funeral_home_phone'] = $api_response_body['CLIENT_INFO']['CLIENT_PHONE'];
        $valid['id'] = $api_response_body['CLIENT_INFO']['CLIENT_ID'];
        $valid['funeral_home_locations'] = $api_response_body['CLIENT_INFO']['LOCATIONS'];
        $valid['account_type'] = $api_response_body['CLIENT_INFO']['CLIENT_ACCOUNT_TYPE'];


        return array(
          "valid" => $valid,
          "errors" => $errors,
          "success_message" => $success_message
        );

    }

    public function validate_2($input)
    {
        $valid = array();
        $valid['obituary_page_name'] = sanitize_text_field($input['obituary_page_name']);
        return $valid;
    }

    public function validate_3($input)
    {
        $valid = array();

        $valid['products'] = sanitize_text_field($input['products']);
        $valid['navigation_style'] = sanitize_text_field($input['navigation_style']);
        $valid['navigation_color'] = sanitize_text_field($input['navigation_color']);
        $valid['navigation_hover_color'] = sanitize_text_field($input['navigation_hover_color']);
        $valid['navigation_text_color'] = sanitize_text_field($input['navigation_text_color']);
        $valid['navigation_hover_text_color'] = sanitize_text_field($input['navigation_hover_text_color']);
        $valid['button_color'] = sanitize_text_field($input['button_color']);
        $valid['button_hover_color'] = sanitize_text_field($input['button_hover_color']);
        $valid['button_text_color'] = sanitize_text_field($input['button_text_color']);
        $valid['button_hover_text_color'] = sanitize_text_field($input['button_hover_text_color']);
        $valid['link_color'] = sanitize_text_field($input['link_color']);
        $valid['heading_color'] = sanitize_text_field($input['heading_color']);
        $valid['text_color'] = sanitize_text_field($input['text_color']);
        $valid['products_per_page'] = sanitize_text_field($input['products_per_page']);
        $valid['address_institution'] = sanitize_text_field($input['address_institution']);
        $valid['address_1'] = sanitize_text_field($input['address_1']);
        $valid['address_city'] = sanitize_text_field($input['address_city']);
        $valid['address_state'] = sanitize_text_field($input['address_state']);
        $valid['address_country'] = sanitize_text_field($input['address_country']);
        $valid['address_zipcode'] = sanitize_text_field($input['address_zipcode']);
        $valid['address_phone'] = sanitize_text_field($input['address_phone']);

        //validate affiliateid
        $username = '999993';
        $password = 'flowers';
        $affiliateid = $input['affiliate_id'];

        $url  = 'https://www.floristone.com/api/rest/wordpress/flowershop_getcurrency?affiliate_id=' . $affiliateid;
        $headers = array(
          'Authorization: Basic '.base64_encode($username . ':' . $password)
        );

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, OBITUARY_ASSISTANT_VERIFYPEER);

        $response = curl_exec($curl);
        curl_close($curl);

        $api_response_body = json_decode($response, true);

        $valid['errors'] = (is_array($api_response_body) && !array_key_exists('errors', $api_response_body)) ? $api_response_body['errors'] : '';
        $valid['affiliate_id'] = (is_array($api_response_body) && !array_key_exists('errors', $api_response_body)) ? sanitize_text_field($input['affiliate_id']) : '0';
        $valid['currency'] = (is_array($api_response_body) && array_key_exists('CURRENCY', $api_response_body)) ? sanitize_text_field($api_response_body['CURRENCY']) : 'u';

        return $valid;
    }

    public function getAccountType($username, $password){

        // function that does the log in, used by regular log in and now after successful sign up as well (approval no longer needed)

        $valid = array();
        $errors = array();
        $success_message = '';

        $headers = array(
          'Authorization: Basic '.base64_encode($username . ':' . $password)
        );

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => (!OBITUARY_ASSISTANT_DEBUG_MODE ? 'https://www.obituary-assistant.com/api/rest/' : 'http://dev.obituary-assistant.com/api/rest/') . 'client',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER => OBITUARY_ASSISTANT_VERIFYPEER,
            CURLOPT_FORBID_REUSE => false,
            CURLOPT_FRESH_CONNECT =>  false,
            CURLOPT_HTTP_VERSION =>  CURL_HTTP_VERSION_1_1
        ));

        $api_response = curl_exec($curl);
        $httpcode=curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $api_response_body = json_decode($api_response, true);

        $status_code = $httpcode;

        $client_account_type = null;
        if ($status_code == 200) {
          $client_account_type = sanitize_text_field($api_response_body['CLIENT_INFO']['CLIENT_ACCOUNT_TYPE']);
          return $client_account_type;
        }

    }
}
