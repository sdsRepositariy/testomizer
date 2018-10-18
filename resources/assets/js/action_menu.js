(function ( $ ) {
 
    $.fn.getIcons = function( options ) {
 

        var settings = $.extend({
        	create_folder: "glyphicon-folder-close",
        	create_item: "glyphicon-file",
        }, options );
        
        var that = this;

        this.find("a[data-action-name]").each(function() {
            var actionName = $(this).attr("data-action-name");

            if(settings.hasOwnProperty(actionName)) {
                $(this).find("span").addClass(settings[actionName]);
            }
        });

        return this;
 
    };
 
}( jQuery ));

$( ".action-menu" ).getIcons();

