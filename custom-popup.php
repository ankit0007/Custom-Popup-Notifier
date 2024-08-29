<?php
/**
 * Plugin Name:       Custom Popup Notifier
 * Plugin URI:        https://seomasterteam.com/plugins/custom-popup-notifier/
 * Description:       Display customizable popups on your WordPress site with animations, colors, and custom CSS/JS.
 * Version:           1.0.0
 * Requires at least: 5.0
 * Requires PHP:      7.0
 * Author:            Team seomasterteam
 * Author URI:        https://seomasterteam.com
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       custom-popup-notifier
 * Domain Path:       /languages
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('CPN_VERSION', '1.0');
define('CPN_PLUGIN_DIR', plugin_dir_path(__FILE__));

// Include the necessary files
require_once CPN_PLUGIN_DIR . 'includes/class-cpn-admin.php';
require_once CPN_PLUGIN_DIR . 'includes/class-cpn-frontend.php';

// Initialize the plugin
function cpn_initialize() {
    $admin = new CPN_Admin();
    $frontend = new CPN_Frontend();
}
add_action('plugins_loaded', 'cpn_initialize');
?>
