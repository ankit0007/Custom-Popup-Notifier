jQuery(document).ready(function($) {
    function showPopup() {
        $('#custom-popup').fadeIn();
        $('body').css('overflow', 'hidden');
    }
    $(window).on('load', function() {
        showPopup();
    });

    $('#custom-popup a').attr('target', '_blank');
});
