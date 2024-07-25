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
define('CUSTOM_POPUP_VERSION', '1.0');
define('CUSTOM_POPUP_PLUGIN_DIR', plugin_dir_path(__FILE__));

// Include the necessary files
require_once CUSTOM_POPUP_PLUGIN_DIR . 'includes/class-custom-popup-admin.php';
require_once CUSTOM_POPUP_PLUGIN_DIR . 'includes/class-custom-popup-frontend.php';

// Initialize the plugin
function custom_popup_initialize() {
    new Custom_Popup_Admin();
    new Custom_Popup_Frontend();
}
add_action('plugins_loaded', 'custom_popup_initialize');
?>
