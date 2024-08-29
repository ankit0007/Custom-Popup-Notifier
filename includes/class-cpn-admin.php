<?php
if (!class_exists('CPN_Admin')) {
    class CPN_Admin {
        public function __construct() {
            add_action('admin_menu', array($this, 'add_settings_menu'));
            add_action('admin_init', array($this, 'register_settings'));
            add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        }

        public function add_settings_menu() {
            add_options_page('Custom Popup Settings', 'Custom Popup', 'manage_options', 'cpn-settings', array($this, 'settings_page'));
        }

        public function register_settings() {
            register_setting('cpn_settings_group', 'cpn_enabled');
            register_setting('cpn_settings_group', 'cpn_bg_color');
            register_setting('cpn_settings_group', 'cpn_font_color');
            register_setting('cpn_settings_group', 'cpn_font_size');
            register_setting('cpn_settings_group', 'cpn_content');
            register_setting('cpn_settings_group', 'cpn_open_animation');
            register_setting('cpn_settings_group', 'cpn_close_animation');
            register_setting('cpn_settings_group', 'cpn_custom_css');
            register_setting('cpn_settings_group', 'cpn_custom_js');
        }

        public function enqueue_admin_scripts($hook) {
            if ($hook != 'settings_page_cpn-settings') {
                return;
            }
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_script('cpn-admin', plugins_url('../assets/js/admin.js', __FILE__), array('wp-color-picker'), false, true);
            wp_enqueue_style('cpn-admin', plugins_url('../assets/css/admin.css', __FILE__), array(), CPN_VERSION);

            // Include local versions of Tailwind and CodeMirror
            wp_enqueue_style('cpn-tailwindcss', plugins_url('../assets/css/tailwind.min.css', __FILE__), array(), '2.2.19');
            wp_enqueue_style('cpn-codemirror', plugins_url('../assets/css/codemirror.min.css', __FILE__), array(), '5.65.5');
            wp_enqueue_script('cpn-codemirror', plugins_url('../assets/js/codemirror.min.js', __FILE__), array(), '5.65.5', true);
            wp_enqueue_script('cpn-codemirror-css', plugins_url('../assets/js/css.min.js', __FILE__), array('cpn-codemirror'), '5.65.5', true);
            wp_enqueue_script('cpn-codemirror-js', plugins_url('../assets/js/javascript.min.js', __FILE__), array('cpn-codemirror'), '5.65.5', true);
        }

        public function settings_page() {
            // The rest of your settings_page method remains the same
        }
    }
}
?>
