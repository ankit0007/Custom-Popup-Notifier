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
