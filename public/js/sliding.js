(function($){
$(function(){
    //Handle bars sliding
    $( ".app-navbar-toggle" ).click(function() {
        sidebarLeftPos = $( ".app-sidebar" ).offset().left;

        if (sidebarLeftPos == 0) {
            sidebarLeftPos = -layoutSettings.sidebarWidth;
        } else {
            sidebarLeftPos = 0;
        }

        if (window.innerWidth >= layoutSettings.breackpoint) {
            navbarLeftPos = $( ".app-navbar" ).offset().left;

            if (navbarLeftPos == 0) {
                navbarLeftPos = layoutSettings.sidebarWidth;
            } else {
                navbarLeftPos = 0;
            }

            animateNavbar (navbarLeftPos, layoutSettings.duration);
            setCookie("navbarLeftPos", navbarLeftPos, 0);
        } else {
            $('#sidebarModal').modal('show');

            $('#sidebarModal').on('click.dismiss.bs.modal', function () {
                animateSidebar (-layoutSettings.sidebarWidth, layoutSettings.duration);
            });

        }

        animateSidebar (sidebarLeftPos, layoutSettings.duration);
        setCookie("sidebarLeftPos", sidebarLeftPos, 0);
    });

    //Set initial statment for certain breakpoint
    $(window).on('resize', function() {
        if (window.innerWidth >= layoutSettings.breackpoint) {
            if (layoutSettings.desktop == false) {
                $('.app-sidebar').css("left", 0);

                $('.app-navbar, .app-container').css("left", layoutSettings.sidebarWidth);

                $('#sidebarModal').modal('hide');

                layoutSettings.desktop = true;
            }
        } else {
            if (layoutSettings.desktop == true) {
                $('.app-sidebar').css("left", - layoutSettings.sidebarWidth);

                $('.app-navbar, .app-container').css("left", 0);

                layoutSettings.desktop = false;
            }
        }
    });

    function animateNavbar (navbarLeftPos, duration) {
        $( ".app-navbar, .app-container" ).animate({
            left: navbarLeftPos,
        }, {
            duration: duration,
            complete: function() {
                //
            }
        });
    }

    function animateSidebar (sidebarLeftPos, duration) {
        $( ".app-sidebar" ).animate({
            left: sidebarLeftPos,
        }, {
            duration: duration,
            complete: function() {
                //
            }
        });
    }

    function setCookie(name, val, month) {
        var cook = name+"="+encodeURIComponent(val);
        //The cookies set for sesion only and for all site pages
        cook+="; expires="+month+"; path=/";
        document.cookie = cook;
    }
});
})(jQuery); 