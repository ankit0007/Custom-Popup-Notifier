<?php
if (!class_exists('Custom_Popup_Admin')) {
    class Custom_Popup_Admin {
        public function __construct() {
            add_action('admin_menu', array($this, 'add_settings_menu'));
            add_action('admin_init', array($this, 'register_settings'));
            add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        }

        public function add_settings_menu() {
            add_options_page('Custom Popup Settings', 'Custom Popup', 'manage_options', 'custom-popup-settings', array($this, 'settings_page'));
        }

        public function register_settings() {
            register_setting('custom_popup_settings_group', 'custom_popup_enabled');
            register_setting('custom_popup_settings_group', 'custom_popup_bg_color');
            register_setting('custom_popup_settings_group', 'custom_popup_font_color');
            register_setting('custom_popup_settings_group', 'custom_popup_font_size');
            register_setting('custom_popup_settings_group', 'custom_popup_content');
            register_setting('custom_popup_settings_group', 'custom_popup_open_animation');
            register_setting('custom_popup_settings_group', 'custom_popup_close_animation');
            register_setting('custom_popup_settings_group', 'custom_popup_custom_css');
            register_setting('custom_popup_settings_group', 'custom_popup_custom_js');
        }

        public function enqueue_admin_scripts($hook) {
            if ($hook != 'settings_page_custom-popup-settings') {
                return;
            }
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_script('custom-popup-admin', plugins_url('../assets/js/admin.js', __FILE__), array('wp-color-picker'), false, true);
            wp_enqueue_style('custom-popup-admin', plugins_url('../assets/css/admin.css', __FILE__), array(), CUSTOM_POPUP_VERSION);
            // Enqueue Tailwind CSS
            wp_enqueue_style('tailwindcss', 'https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css', array(), '2.2.19');
            // Enqueue CodeMirror
            wp_enqueue_style('codemirror', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.css', array(), '5.65.5');
            wp_enqueue_script('codemirror', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.js', array(), '5.65.5', true);
            wp_enqueue_script('codemirror-css', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/css/css.min.js', array('codemirror'), '5.65.5', true);
            wp_enqueue_script('codemirror-js', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/javascript/javascript.min.js', array('codemirror'), '5.65.5', true);
        }

        public function settings_page() {
            $open_animations = array(
                'Attention seekers' => array(
                    'bounce', 'flash', 'pulse', 'rubberBand', 'shakeX', 'shakeY', 'headShake', 'swing', 'tada', 'wobble', 'jello', 'heartBeat'
                ),
                'Back entrances' => array(
                    'backInDown', 'backInLeft', 'backInRight', 'backInUp'
                ),
                'Bouncing entrances' => array(
                    'bounceIn', 'bounceInDown', 'bounceInLeft', 'bounceInRight', 'bounceInUp'
                ),
                'Fading entrances' => array(
                    'fadeIn', 'fadeInDown', 'fadeInDownBig', 'fadeInLeft', 'fadeInLeftBig', 'fadeInRight', 'fadeInRightBig', 'fadeInUp', 'fadeInUpBig', 'fadeInTopLeft', 'fadeInTopRight', 'fadeInBottomLeft', 'fadeInBottomRight'
                ),
                'Flippers' => array(
                    'flip', 'flipInX', 'flipInY'
                ),
                'Lightspeed' => array(
                    'lightSpeedInRight', 'lightSpeedInLeft'
                ),
                'Rotating entrances' => array(
                    'rotateIn', 'rotateInDownLeft', 'rotateInDownRight', 'rotateInUpLeft', 'rotateInUpRight'
                ),
                'Specials' => array(
                    'hinge', 'jackInTheBox', 'rollIn'
                ),
                'Zooming entrances' => array(
                    'zoomIn', 'zoomInDown', 'zoomInLeft', 'zoomInRight', 'zoomInUp'
                ),
                'Sliding entrances' => array(
                    'slideInDown', 'slideInLeft', 'slideInRight', 'slideInUp'
                )
            );

            $close_animations = array(
                'Attention seekers' => array(
                    'bounce', 'flash', 'pulse', 'rubberBand', 'shakeX', 'shakeY', 'headShake', 'swing', 'tada', 'wobble', 'jello', 'heartBeat'
                ),
                'Back exits' => array(
                    'backOutDown', 'backOutLeft', 'backOutRight', 'backOutUp'
                ),
                'Bouncing exits' => array(
                    'bounceOut', 'bounceOutDown', 'bounceOutLeft', 'bounceOutRight', 'bounceOutUp'
                ),
                'Fading exits' => array(
                    'fadeOut', 'fadeOutDown', 'fadeOutDownBig', 'fadeOutLeft', 'fadeOutLeftBig', 'fadeOutRight', 'fadeOutRightBig', 'fadeOutUp', 'fadeOutUpBig', 'fadeOutTopLeft', 'fadeOutTopRight', 'fadeOutBottomRight', 'fadeOutBottomLeft'
                ),
                'Flippers' => array(
                    'flipOutX', 'flipOutY'
                ),
                'Lightspeed' => array(
                    'lightSpeedOutRight', 'lightSpeedOutLeft'
                ),
                'Rotating exits' => array(
                    'rotateOut', 'rotateOutDownLeft', 'rotateOutDownRight', 'rotateOutUpLeft', 'rotateOutUpRight'
                ),
                'Specials' => array(
                    'hinge', 'rollOut'
                ),
                'Zooming exits' => array(
                    'zoomOut', 'zoomOutDown', 'zoomOutLeft', 'zoomOutRight', 'zoomOutUp'
                ),
                'Sliding exits' => array(
                    'slideOutDown', 'slideOutLeft', 'slideOutRight', 'slideOutUp'
                )
            );
            ?>
            <div class="wrap">
                <h1 class="text-3xl font-bold mb-6">Custom Popup Settings</h1>
                <h2 class="nav-tab-wrapper">
                    <a href="#general-settings" class="nav-tab nav-tab-active">General Settings</a>
                    <a href="#additional-settings" class="nav-tab">Additional Settings</a>
                </h2>
                <form method="post" action="options.php" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    <?php settings_fields('custom_popup_settings_group'); ?>
                    <?php do_settings_sections('custom_popup_settings_group'); ?>
                    <div id="general-settings" class="tab-content" style="display: block;">
                        <div class="space-y-4">
                            <div class="flex items-center mb-4">
                                <label class="w-1/4 text-gray-700 font-bold" for="custom_popup_enabled">Enable Popup</label>
                                <input type="checkbox" name="custom_popup_enabled" id="custom_popup_enabled" value="1" <?php checked(1, get_option('custom_popup_enabled'), true); ?> class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
                            </div>
                            <div class="flex items-center mb-4">
                                <label class="w-1/4 text-gray-700 font-bold" for="custom_popup_bg_color">Background Color</label>
                                <input type="text" name="custom_popup_bg_color" id="custom_popup_bg_color" value="<?php echo esc_attr(get_option('custom_popup_bg_color', '#f8f8f8')); ?>" class="custom-popup-color-field w-1/2 bg-white border border-gray-300 text-gray-700 py-2 px-3 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                            </div>
                            <div class="flex items-center mb-4">
                                <label class="w-1/4 text-gray-700 font-bold" for="custom_popup_font_color">Font Color</label>
                                <input type="text" name="custom_popup_font_color" id="custom_popup_font_color" value="<?php echo esc_attr(get_option('custom_popup_font_color', 'rgb(37, 39, 43)')); ?>" class="custom-popup-color-field w-1/2 bg-white border border-gray-300 text-gray-700 py-2 px-3 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                            </div>
                            <div class="flex items-center mb-4">
                                <label class="w-1/4 text-gray-700 font-bold" for="custom_popup_font_size">Font Size (rem)</label>
                                <input type="number" step="0.1" name="custom_popup_font_size" id="custom_popup_font_size" value="<?php echo esc_attr(get_option('custom_popup_font_size', '1')); ?>" class="w-1/2 bg-white border border-gray-300 text-gray-700 py-2 px-3 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                            </div>
                            <div class="flex items-center mb-4">
                                <label class="w-1/4 text-gray-700 font-bold" for="custom_popup_open_animation">Open Animation</label>
                                <select name="custom_popup_open_animation" id="custom_popup_open_animation" class="w-1/2 bg-white border border-gray-300 text-gray-700 py-2 px-3 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <?php
                                    foreach ($open_animations as $group => $group_animations) {
                                        echo '<optgroup label="' . esc_attr($group) . '">';
                                        foreach ($group_animations as $animation) {
                                            echo '<option value="' . esc_attr($animation) . '" ' . selected(get_option('custom_popup_open_animation'), $animation, false) . '>' . esc_html($animation) . '</option>';
                                        }
                                        echo '</optgroup>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="flex items-center mb-4">
                                <label class="w-1/4 text-gray-700 font-bold" for="custom_popup_close_animation">Close Animation</label>
                                <select name="custom_popup_close_animation" id="custom_popup_close_animation" class="w-1/2 bg-white border border-gray-300 text-gray-700 py-2 px-3 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <?php
                                    foreach ($close_animations as $group => $group_animations) {
                                        echo '<optgroup label="' . esc_attr($group) . '">';
                                        foreach ($group_animations as $animation) {
                                            echo '<option value="' . esc_attr($animation) . '" ' . selected(get_option('custom_popup_close_animation'), $animation, false) . '>' . esc_html($animation) . '</option>';
                                        }
                                        echo '</optgroup>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2" for="custom_popup_content">Popup Content</label>
                                <?php
                                $content = get_option('custom_popup_content', 'Default popup content');
                                $editor_id = 'custom_popup_content';
                                $settings = array(
                                    'textarea_name' => 'custom_popup_content',
                                    'textarea_rows' => 10,
                                    'media_buttons' => true,
                                    'tinymce'       => array(
                                        'toolbar1' => 'bold,italic,underline,|,bullist,numlist,|,link,unlink,|,undo,redo',
                                    ),
                                );
                                wp_editor($content, $editor_id, $settings);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div id="additional-settings" class="tab-content" style="display: none;">
                        <div class="space-y-4">
                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2" for="custom_popup_custom_css">Custom CSS</label>
                                <textarea name="custom_popup_custom_css" id="custom_popup_custom_css" rows="10" class="codemirror-textarea w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?php echo esc_textarea(get_option('custom_popup_custom_css', '')); ?></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2" for="custom_popup_custom_js">Custom JS</label>
                                <textarea name="custom_popup_custom_js" id="custom_popup_custom_js" rows="10" class="codemirror-textarea w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?php echo esc_textarea(get_option('custom_popup_custom_js', '')); ?></textarea>
                            </div>
                        </div>
                    </div>
                    <?php submit_button('Save Settings', 'primary', 'submit', true, array('class' => 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline')); ?>
                </form>
            </div>
            <script>
                jQuery(document).ready(function($) {
                    $('.nav-tab').click(function(e) {
                        e.preventDefault();
                        $('.nav-tab').removeClass('nav-tab-active');
                        $(this).addClass('nav-tab-active');
                        $('.tab-content').hide();
                        $($(this).attr('href')).show();
                    });

                    // Initialize CodeMirror
                    $('.codemirror-textarea').each(function() {
                        var editor = CodeMirror.fromTextArea(this, {
                            lineNumbers: true,
                            mode: this.id === 'custom_popup_custom_css' ? 'css' : 'javascript'
                        });
                        editor.on('change', function(cm) {
                            cm.save();
                        });
                    });

                    // Initialize color picker
                    $('.custom-popup-color-field').wpColorPicker();
                });
            </script>
            <?php
        }
    }
}
?>
