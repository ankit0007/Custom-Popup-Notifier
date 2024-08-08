jQuery(document).ready(function($) {
    function showPopup() {
        $('#custom-popup').fadeIn();
        $('body').css('overflow', 'hidden'); // Disable scrolling
    }
    $(window).on('load', function() {
        showPopup();
    });

    $('#custom-popup a').attr('target', '_blank'); // Open link in new window
});
