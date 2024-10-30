<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://iogly.com
 * @since             1.0.0
 * @package           Iogly
 *
 * @wordpress-plugin
 * Plugin Name:       Iogly
 * Description:       This plugin hanldles the integration of the Iogly intrusion detection system into WP.
 * Version:           1.0.2
 * Author:            Iogly.com
 * Author URI:        https://iogly.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die();
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('IOGLY_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-iogly-activator.php
 */
function activate_iogly()
{
    require_once plugin_dir_path(__FILE__) .
        'includes/class-iogly-activator.php';
    Iogly_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-iogly-deactivator.php
 */
function deactivate_iogly()
{
    require_once plugin_dir_path(__FILE__) .
        'includes/class-iogly-deactivator.php';
    Iogly_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_iogly');
register_deactivation_hook(__FILE__, 'deactivate_iogly');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-iogly.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_iogly()
{
    $plugin = new Iogly();
    $plugin->run();
}
run_iogly();
