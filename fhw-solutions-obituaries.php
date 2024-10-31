<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.obituary-assistant.com
 * @since             1.0.0
 * @package           Fhw_Solutions_Obituaries
 *
 * @wordpress-plugin
 * Plugin Name:       Obituary Assistant by Obituary Assistant
 * Plugin URI:        https://wordpress.org/plugins/obituary-assistant-by-funeral-home-website-solutions/
 * Description:       This is the obituaries module for funeral home websites
 * Version:           7.2.3
 * Author:            fhwsolutions
 * Author URI:        https://www.obituary-assistant.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       obituary-assistant-by-funeral-home-website-solutions
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
        die;
}

define('OBITUARY_ASSISTANT_VERIFYPEER', true);
define('OBITUARY_ASSISTANT_DEBUG_MODE', false);

$file_fhws   = basename( __FILE__ );
$folder_fhws = basename( dirname( __FILE__ ) );
$hook_fhws = "in_plugin_update_message-{$folder_fhws}/{$file_fhws}";
add_action( $hook_fhws, 'update_message_fhws', 10, 2 );

function update_message_fhws( $plugin_data, $r )
{

  printf(
		'<hr>%s',__( '<strong>The new version is a recommended update</strong><br>' .
    '* Enable auto-updates for best performance' , 'text-domain' )
	);
}

require_once plugin_dir_path( __FILE__ ) . 'public/obituaries.php';

require_once plugin_dir_path( __FILE__ ) . 'public/flower-delivery.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-fhw-solutions-obituaries-activator.php
 */
function activate_fhw_solutions_obituaries() {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-fhw-solutions-obituaries-activator.php';
        Fhw_Solutions_Obituaries_Activator::activate();
}



/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-fhw-solutions-obituaries-deactivator.php
 */
function deactivate_fhw_solutions_obituaries() {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-fhw-solutions-obituaries-deactivator.php';
        Fhw_Solutions_Obituaries_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_fhw_solutions_obituaries' );
register_deactivation_hook( __FILE__, 'deactivate_fhw_solutions_obituaries' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-fhw-solutions-obituaries.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-fhw-shortcode-button-add.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_fhw_solutions_obituaries() {

        $plugin = new Fhw_Solutions_Obituaries();
        $fhws_shortcode_btn = new fhws_shortcode_button_add();
        $plugin->run();

}
run_fhw_solutions_obituaries();
