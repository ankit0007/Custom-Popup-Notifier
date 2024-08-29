<?php
if (!class_exists('CPN_Frontend')) {
    class CPN_Frontend {
        public function __construct() {
            add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
            add_action('wp_footer', array($this, 'display_popup'));
            add_action('wp_head', array($this, 'apply_custom_css'));
            add_action('wp_footer', array($this, 'apply_custom_js'), 20);
        }

        public function enqueue_scripts() {
            wp_enqueue_script('jquery');
            wp_enqueue_script('cpn-frontend', plugins_url('../assets/js/frontend.js', __FILE__), array('jquery'), false, true);
            wp_enqueue_style('cpn-frontend', plugins_url('../assets/css/frontend.css', __FILE__), array(), CPN_VERSION);

            // Include local version of Animate.css
            wp_enqueue_style('cpn-animate-css', plugins_url('../assets/css/animate.min.css', __FILE__), array(), '4.1.1');
        }

        public function display_popup() {
            if (!get_option('cpn_enabled')) {
                return;
            }
            $bg_color = esc_attr(get_option('cpn_bg_color', '#f8f8f8'));
            $font_color = esc_attr(get_option('cpn_font_color', 'rgb(37, 39, 43)'));
            $font_size = esc_attr(get_option('cpn_font_size', '1'));
            $content = wp_kses_post(get_option('cpn_content', 'Default popup content'));
            $open_animation = esc_attr(get_option('cpn_open_animation', 'bounce'));
            $close_animation = esc_attr(get_option('cpn_close_animation', 'fadeOut'));
            ?>
            <div id="cpn-popup" class="cpn-popup fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 animate__animated animate__fadeIn">
                <div id="cpn-popup-content" class="cpn-popup-content relative bg-white rounded-lg shadow-lg overflow-auto max-w-lg max-h-screen p-8 animate__animated animate__<?php echo $open_animation; ?>" style="background-color: <?php echo $bg_color; ?>; color: <?php echo $font_color; ?>; font-size: <?php echo $font_size; ?>rem;">
                    <button class="cpn-popup-close absolute top-2 right-2 text-black text-2xl font-bold">&times;</button>
                    <div class="popup-content">
                        <?php echo $content; ?>
                    </div>
                </div>
            </div>
            <script>
                jQuery(document).ready(function($) {
                    $('.cpn-popup-close').click(function() {
                        $('#cpn-popup-content').removeClass('animate__<?php echo $open_animation; ?>').addClass('animate__<?php echo $close_animation; ?>');
                        setTimeout(function() {
                            $('#cpn-popup').fadeOut();
                            $('body').css('overflow', 'auto'); // Enable scrolling
                        }, 1000); // Adjust the timing if necessary
                    });
                });
            </script>
            <?php
        }

        public function apply_custom_css() {
            $custom_css = get_option('cpn_custom_css', '');
            if (!empty($custom_css)) {
                wp_add_inline_style('cpn-frontend', $custom_css);
            }
        }

        public function apply_custom_js() {
            $custom_js = get_option('cpn_custom_js', '');
            if (!empty($custom_js)) {
                wp_add_inline_script('cpn-frontend', $custom_js);
            }
        }
    }
}
?>
