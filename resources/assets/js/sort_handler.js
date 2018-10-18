(function ( $ ) {
 
    $.fn.sortHandler = function( options ) {
 

        var settings = $.extend({
        	asc: "glyphicon-menu-up",
        	desc: "glyphicon-menu-down"
        }, options );
 
        var link = this.find("a:not([data-sorted=false])");

        if (link.attr("data-sorted") == "desc") {
			link.find("span").removeClass(settings.asc).addClass(settings.desc);
		} else {
			link.find("span").removeClass(settings.desc).addClass(settings.asc);
		}

        return this;
 
    };
 
}( jQuery ));

$( ".subheader" ).sortHandler();

