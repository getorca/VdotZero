$(document).ready(function () {
    sidebarScroll();
    
    //menu toggle
    $('.menu-switch').click(function(event) {
        $('.menu-wrap').toggleClass( 'show' );
    });
});

$(window).resize(function(){
    sidebarScroll();
});
    

function sidebarScroll() {
    if( $(window).width() > 768 ) {
        /* Allow the sidebar to scroll untill it is all shown */
        var window_height = $(window).height();
        var sidebar_height = $('.sidebar-content').height(); 

        if ( window_height > sidebar_height ) {
            
            $('#sidebar').css({
                'position': 'fixed',
            });
            
        } else {
            $(window).scroll(function () {
                var scroll = $(this).scrollTop();
                var difference = sidebar_height - window_height + 70;
                
                if(scroll > difference ) {
                    $('#sidebar').css({
                        'top': '-'+difference+'px',
                        'position': 'fixed',
                        'overflow':'hidden',
                        'height':'9000px'
                    });
                } else {
                    $('#sidebar').removeAttr( 'style' );
                }
            });
            
        } 
    } else {
        $('#sidebar').removeAttr( 'style' );
    }
}


