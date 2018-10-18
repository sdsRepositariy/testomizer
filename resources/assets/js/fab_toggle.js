(function($){
$(function(){
$("#action_menu").on("click", function(){

    var actionMenu = $(this).parent();

    if ( !actionMenu.children().is(".transforming-box") ) {
         var dropdownMenu = $(".action-menu").find(".dropdown-menu").clone();

        actionMenu.append(dropdownMenu)
                .find(".dropdown-menu")
                .wrap('<div class="transforming-box">'+
                        '<div class="content-wrapper" id="action_menu_target">'+
                      '</div></div>');
    }

    //Set grid for the list
    var listLenght = dropdownMenu.children("li").length;
    dropdownMenu.children("li:not(:first-child)").css({
        "width": (100/(listLenght-1)-1)+"%" //less on 1% due to shaking in Firefox
    });

    //Get button position
    var buttonRight = parseInt($(this).css("right"));
    var buttonBottom = parseInt($(this).css("bottom"));

    //Get button size
    var buttonHeight = $(this).outerHeight();
    var buttonWidth = $(this).outerWidth();

    //Get initial block size
    var initialHeight = actionMenu.find(".transforming-box").outerHeight();
    var initialWidth = actionMenu.find(".transforming-box").outerWidth();

    //Get dropdown menu size
    var height =  actionMenu.find(".dropdown-menu").outerHeight()-(buttonBottom+initialHeight+buttonHeight/2);
    var width =  actionMenu.find(".dropdown-menu").outerWidth()-(buttonRight+initialWidth+buttonWidth/2);

    var diagonal = Math.sqrt(Math.pow(height, 2) + Math.pow(width, 2));

    actionMenu.find( ".transforming-box" ).animate({
        height: diagonal*2,
        width: diagonal*2,
        bottom: -diagonal+(buttonBottom+initialHeight+buttonHeight/2), 
        right: -diagonal+(buttonRight+initialWidth+buttonWidth/2)
    }, 200, function() {
        actionMenu.find(".content-wrapper")
                                        .unwrap()
                                        .find(".dropdown-menu")
                                        .addClass("fab-open")
                                        .actionHandler();
    });


    actionMenu.find("#action_menu_target").on('hide.bs.dropdown', function () {
        actionMenu.find(".transforming-box").stop( true, true ).remove();
        $(this).remove();
    })

});

});
})(jQuery); 