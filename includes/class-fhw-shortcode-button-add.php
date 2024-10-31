<?php 
if ( ! class_exists( 'fhws_shortcode_button_add' ) ) {
        /**
         * Class fhws_shortcode_button_add
         */
        class fhws_shortcode_button_add {
                /**
                 * fhws_shortcode_button_add constructor.
                 */
                function __construct() {
                        if ( is_admin() ) {
                                add_action( 'admin_head', array( &$this, 'fhws_shortcode_button_init' ) );
                        }
                        
                }

                /**
                 * Add button in TinyMCE
                 */
                function fhws_shortcode_button_init() {
                        global $typenow;

                        if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
                                return;
                        }

                        if ( ! in_array( $typenow, array( 'post', 'page' ) ) ) {
                                return;
                        }

                        // Check if WYSIWYG is enabled
                        if ( 'true' === get_user_option( 'rich_editing' ) ) {
                                //Add a callback to regiser our TinyMCE plugin
                                add_filter( 'mce_external_plugins', array( &$this, 'fhws_register_tinymce_plugin' ) );

                                // Add a callback to add our button to the TinyMCE toolbar
                                add_filter( 'mce_buttons', array( &$this, 'fhws_add_tinymce_button' ) );
                        }

                }

                /**
                 * Declare script for button
                 *
                 * @param $plugin_array
                 *
                 * @return mixed
                 */
            function fhws_register_tinymce_plugin( $plugin_array ) {
            $plugin_array['fhws_add_shortcode_button'] = plugins_url( 'js/fhs-shortcode-button.js', __FILE__ );
            $plugin_array['green_button_plugin'] = plugins_url( 'js/fhs-shortcode-button.js', __FILE__ );
            return $plugin_array;
            }

                /**
                 * Register button
                 *
                 * @param $buttons
                 *
                 * @return array
                 */
                function fhws_add_tinymce_button( $buttons ) {
                        array_push( $buttons, 'fhws_add_shortcode_button' );
						array_push($buttons, "OBITUARY_SUBSCRIPTION_BTN");
						return $buttons;
                }
        }
}