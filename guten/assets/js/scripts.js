jQuery(document).ready(function($) {

    // nav trigger
    $('.nav-trigger').click(function(e) {
        e.preventDefault();
        $('body').toggleClass('nav-visible');
    });

    // header compact
    $(document).on('scroll', function() {
        if ( $('#header').offset().top > 5 ) {
            $('#header').addClass('compact');
        }
        else {
            $('#header').removeClass('compact');
        }
    });

});
