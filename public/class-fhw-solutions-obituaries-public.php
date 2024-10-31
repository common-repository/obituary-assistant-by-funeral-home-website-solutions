<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.obituary-assistant.com
 * @since      1.0.0
 *
 * @package    Fhw_Solutions_Obituaries
 * @subpackage Fhw_Solutions_Obituaries/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Fhw_Solutions_Obituaries
 * @subpackage Fhw_Solutions_Obituaries/public
 * @author     Philip Perry <phil@fhwsolutions.com>
 */
class Fhw_Solutions_Obituaries_Public {

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
   * @param      string    $plugin_name       The name of the plugin.
   * @param      string    $version    The version of this plugin.
   */
  public function __construct( $plugin_name, $version ) {

    $this->plugin_name = $plugin_name;
    $this->version = $version;

    update_option('oa-version', $version);

  }

  /**
   * Register the stylesheets for the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function enqueue_styles() {

    wp_enqueue_style( 'dashicons' );

    //wp_enqueue_style( 'wp-jquery-ui-dialog' );

    $oa_fws_boot = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'css/fhws-solutions-obituaries-public-bootstrap.css'));
    wp_enqueue_style( 'fhw-bootstrap-prefix', plugin_dir_url( __FILE__ ) . 'css/fhws-solutions-obituaries-public-bootstrap.css', array(), $oa_fws_boot, 'all' );
    $oa_fws_css_oa_ver = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'css/fhw-solutions-obituaries-public.css'));
    wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/fhw-solutions-obituaries-public.css', array(),  $oa_fws_css_oa_ver, 'all' );
    wp_enqueue_style( 'jquery-captcha', plugin_dir_url( __FILE__ ) . 'captcha/src/jquery.simpleCaptcha.css', array(), $this->version, 'all' );

    wp_enqueue_style( 'jquery-slick-nav', plugin_dir_url( __FILE__ ) . 'css/slicknav.css', array(), $this->version, 'all' );

    // only enqueue flower storefront specific files when storefront needed
    $options = get_option('fhw-solutions-obituaries_1');
    if (!(isset($options['account_type'])) ||
      (isset($options['account_type']) && (
          $options['account_type'] == 0 ||
          $options['account_type'] == 2 ||
          $options['account_type'] == 5 ||
          $options['account_type'] == 6 ||
          $options['account_type'] == 7)
      )){
        $oa_fws_css_flw_ver = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'css/florist-one-flower-delivery-public.css'));
        wp_enqueue_style( 'flower-storefront', plugin_dir_url( __FILE__ ) . 'css/florist-one-flower-delivery-public.css', array(),  $oa_fws_css_flw_ver, 'all' );
    }

    wp_enqueue_style( 'jquery-ui', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.css', array(), $this->version, 'all' );

    wp_enqueue_style('uppy', plugin_dir_url( __FILE__ ) . 'css/uppy.min.css', array(), $this->version, 'all' );

  }

  /**
   * Register the JavaScript for the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function enqueue_scripts() {

    wp_enqueue_script( 'jquery-ui-dialog' );
    wp_enqueue_script( 'jquery-ui-tooltip' );
    wp_enqueue_script( 'jquery-validate', plugin_dir_url( __FILE__ ) . 'js/jquery.validate.js', array( 'jquery' ), $this->version, false);
    $oa_fws_js_oa_ver = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'js/fhw-solutions-obituaries-main.js'));
    wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/fhw-solutions-obituaries-main.js', array( 'jquery', 'jquery-ui-dialog' ),$oa_fws_js_oa_ver . "-" . $this->version , false );
    wp_enqueue_script( 'uppy', plugin_dir_url( __FILE__ ) . 'js/uppy.min.js', null, $this->version, true );
    wp_enqueue_script( 'obituaries-photo-gallery', plugin_dir_url( __FILE__ ) . 'js/fhw-solutions-obituaries-photo-gallery.js', array( 'jquery', $this->plugin_name, 'uppy' ), $this->version, true );
    wp_enqueue_script( 'obituaries-condolences', plugin_dir_url( __FILE__ ) . 'js/fhw-solutions-obituaries-condolences.min.js', array( 'jquery', $this->plugin_name ), $this->version, false );
    wp_enqueue_script( 'jquery-history', plugin_dir_url( __FILE__ ) . 'js/jquery.history.js', array( 'jquery' ), $this->version, false);


    // only enqueue flower storefront specific files when storefront needed
    $options = get_option('fhw-solutions-obituaries_1');
    if (!(isset($options['account_type'])) ||
      (isset($options['account_type']) && (
          $options['account_type'] == 0 ||
          $options['account_type'] == 2 ||
          $options['account_type'] == 5 ||
          $options['account_type'] == 6 ||
          $options['account_type'] == 7)
      )){
        $oa_fws_js_flw_ver = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'js/florist-one-flower-delivery-public.js'));
        wp_enqueue_script( 'flower-storefront', plugin_dir_url( __FILE__ ) . 'js/florist-one-flower-delivery-public.js', array( 'jquery', $this->plugin_name, 'jquery-history' ), $oa_fws_js_flw_ver , false );

    }

    wp_enqueue_script( 'jquery-fhw-cookie', plugin_dir_url( __FILE__ ) . 'js/jquery.cookie.js', array( 'jquery' ), $this->version, false );
    $oa_fws__bs_js_oa_ver = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'js/fhws-bootstrap-5.js'));
    wp_enqueue_script( 'bootstrap-modal', plugin_dir_url( __FILE__ ) . 'js/fhws-bootstrap-5.js', null, $oa_fws__bs_js_oa_ver, false );

    wp_localize_script(
      $this->plugin_name,
      'oaInfo',
      array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'partials' => plugins_url( '' , __FILE__ ) . '/partials',
        'public' => plugins_url( '' , __FILE__ ) ,
        'captcha' => plugins_url( '' , __FILE__ ) . '/captcha/src',
        'flower_base_url' => get_permalink(),
        'version' => $this->version
      )
    );

  }

}
