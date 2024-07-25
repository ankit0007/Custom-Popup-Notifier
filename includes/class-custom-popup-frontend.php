<?php
if (!class_exists('Custom_Popup_Frontend')) {
    class Custom_Popup_Frontend {
        public function __construct() {
            add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
            add_action('wp_footer', array($this, 'display_popup'));
            add_action('wp_head', array($this, 'apply_custom_css'));
            add_action('wp_footer', array($this, 'apply_custom_js'), 20);
        }

        public function enqueue_scripts() {
            wp_enqueue_script('jquery');
            wp_enqueue_script('custom-popup-frontend', plugins_url('../assets/js/frontend.js', __FILE__), array('jquery'), false, true);
            wp_enqueue_style('custom-popup-frontend', plugins_url('../assets/css/frontend.css', __FILE__), array(), CUSTOM_POPUP_VERSION);
            // Enqueue Tailwind CSS
            wp_enqueue_style('tailwindcss', 'https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css', array(), '2.2.19');
            // Enqueue Animate.css
            wp_enqueue_style('animate-css', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css', array(), '4.1.1');
        }

        public function display_popup() {
            if (!get_option('custom_popup_enabled')) {
                return;
            }
            $bg_color = esc_attr(get_option('custom_popup_bg_color', '#f8f8f8'));
            $font_color = esc_attr(get_option('custom_popup_font_color', 'rgb(37, 39, 43)'));
            $font_size = esc_attr(get_option('custom_popup_font_size', '1'));
            $content = wp_kses_post(get_option('custom_popup_content', 'Default popup content'));
            $open_animation = esc_attr(get_option('custom_popup_open_animation', 'bounce'));
            $close_animation = esc_attr(get_option('custom_popup_close_animation', 'fadeOut'));
            ?>
            <div id="custom-popup" class="custom-popup fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 animate__animated animate__fadeIn">
                <div id="custom-popup-content" class="custom-popup-content relative bg-white rounded-lg shadow-lg overflow-auto max-w-lg max-h-screen p-8 animate__animated animate__<?php echo $open_animation; ?>" style="background-color: <?php echo $bg_color; ?>; color: <?php echo $font_color; ?>; font-size: <?php echo $font_size; ?>rem;">
                    <button class="custom-popup-close absolute top-2 right-2 text-black text-2xl font-bold">&times;</button>
                    <div class="popup-content">
                        <?php echo $content; ?>
                    </div>
                </div>
            </div>
            <script>
                jQuery(document).ready(function($) {
                    $('.custom-popup-close').click(function() {
                        $('#custom-popup-content').removeClass('animate__<?php echo $open_animation; ?>').addClass('animate__<?php echo $close_animation; ?>');
                        setTimeout(function() {
                            $('#custom-popup').fadeOut();
                            $('body').css('overflow', 'auto'); // Enable scrolling
                        }, 1000); // Adjust the timing if necessary
                    });
                });
            </script>
            <?php
        }

        public function apply_custom_css() {
            $custom_css = get_option('custom_popup_custom_css', '');
            if (!empty($custom_css)) {
                echo '<style>' . $custom_css . '</style>';
            }
        }

        public function apply_custom_js() {
            $custom_js = get_option('custom_popup_custom_js', '');
            if (!empty($custom_js)) {
                echo '<script>' . $custom_js . '</script>';
            }
        }
    }
}
?>
