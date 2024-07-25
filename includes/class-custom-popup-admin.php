<?php
if (!class_exists('Custom_Popup_Admin')) {
    class Custom_Popup_Admin {
        public function __construct() {
            add_action('admin_menu', array($this, 'add_settings_menu'));
            add_action('admin_init', array($this, 'register_settings'));
            add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        }

        public function add_settings_menu() {
            add_options_page(
                __('Custom Popup Settings', 'custom-popup-notifier'),
                __('Custom Popup', 'custom-popup-notifier'),
                'manage_options',
                'custom-popup-settings',
                array($this, 'settings_page')
            );
        }

        public function register_settings() {
            register_setting('custom_popup_settings_group', 'custom_popup_enabled', 'intval');
            register_setting('custom_popup_settings_group', 'custom_popup_bg_color', 'sanitize_hex_color');
            register_setting('custom_popup_settings_group', 'custom_popup_font_color', 'sanitize_hex_color');
            register_setting('custom_popup_settings_group', 'custom_popup_font_size', 'floatval');
            register_setting('custom_popup_settings_group', 'custom_popup_content', 'wp_kses_post');
            register_setting('custom_popup_settings_group', 'custom_popup_open_animation', 'sanitize_text_field');
            register_setting('custom_popup_settings_group', 'custom_popup_close_animation', 'sanitize_text_field');
            register_setting('custom_popup_settings_group', 'custom_popup_custom_css', 'wp_strip_all_tags');
            register_setting('custom_popup_settings_group', 'custom_popup_custom_js', 'wp_strip_all_tags');
        }

        public function enqueue_admin_scripts($hook) {
            if ($hook != 'settings_page_custom-popup-settings') {
                return;
            }
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_script('custom-popup-admin', plugins_url('../assets/js/admin.js', __FILE__), array('wp-color-picker'), false, true);
            wp_enqueue_style('custom-popup-admin', plugins_url('../assets/css/admin.css', __FILE__), array(), CUSTOM_POPUP_VERSION);
            wp_enqueue_style('tailwindcss', 'https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css', array(), '2.2.19');
            wp_enqueue_style('codemirror', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.css', array(), '5.65.5');
            wp_enqueue_script('codemirror', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.js', array(), '5.65.5', true);
            wp_enqueue_script('codemirror-css', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/css/css.min.js', array('codemirror'), '5.65.5', true);
            wp_enqueue_script('codemirror-js', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/javascript/javascript.min.js', array('codemirror'), '5.65.5', true);
        }

        public function settings_page() {
            // ... (rest of your settings_page function remains the same)
        }
    }
}
?>
