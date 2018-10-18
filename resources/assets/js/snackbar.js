/* ========================================================================
 * Dmitriy Serov: snacbar.js v0.0.1
 * 
 * ========================================================================
 * Licensed under MIT
 * ========================================================================
 * Details:
 * CSS: require _snackbar.scss
 *
 * Html:  <div class="snackbar-toggle" data-snackbar-type="error"></div>
 * data-snackbar-type="error" or "success"
 *
 * The plugin triggers in the line 216
 * Trigger $(".snackbar-toggle").snackbar();
 *
 * Options:
 * If FAB has a positioned wrapper indicate it in "fabWrapper" option
 *
 * Option "container" - use app root element
 * ======================================================================== */

(function ( $ ) {
'use strict';

// Create the defaults once
var pluginName = "snackbar";

// key using in $.data()
var dataKey = "plugin_" + pluginName;

var defaults = {
		type: "snackbar-success", //"snackbar-error"
		delay: 3000,
		duration: 400,
		container: "#app",
		fab: "#action_menu",
		fabWrapper: ".action-menu-fab", //in case if wrapper positioned 
		template: '<div class="snackbar">'+
					'<div class="snackbar-content"></div>'+
				  '</div>',
    };

// The actual plugin constructor
function Plugin( element, options ) {
    this.element = element;

    this.options = $.extend( {}, defaults, options);

    this.$template = $(this.options.template);

    this.content = this.element.text();

    this.$fab = $(this.options.fab);

    this.$container = $(this.options.container);

    this.init();
}

function getContentHeight ($this) {
	//Get content height and calculate lines quantity
	var $contentBlock = $this.$template.find(".snackbar-content");

	var lineHeight = parseInt($contentBlock.css("line-height"));

	$this.$template.css({
		"display": "block",
		"z-index": -1
	})

	$this.$template.appendTo($this.$container);

	var lines = ($contentBlock.height()/lineHeight).toFixed();

	$this.$template.attr('style', '').remove();

	if (lines > 1) {
		return "snackbar-two-line";
	} else {
		return "snackbar-one-line";
	}
};

function fabShiftUp($this) {
	var $fab = $("body").find($this.$fab);

	var $fabWrapper = $fab.parent($this.options.fabWrapper);

	//Check if FAB exists
	if ($fab.lenght == 0) {
		return
	}

	//Check if FAB displayed
	if (($fab.css("display") == "none") || ($fabWrapper.css("display") == "none")) {
		return
	}

	//Check if FAB overlaps snackbar
	var fabLeft = $fab.offset().left;

	var templateWidth = $this.$template.outerWidth();

	var viewportWidth = window.innerWidth;

	var templateLeft = (viewportWidth - templateWidth)/2;

	if ((templateLeft+templateWidth) < fabLeft) {
		return
	}

	//Define what we will move
	if ($fabWrapper.lenght !=0) {
		$this.bottom = window.innerHeight - $fabWrapper.offset().top;
		$this.$el = $fabWrapper;
	} else {
		$this.bottom = window.innerHeight - $fab.offset().top;
		$this.$el = $fab;
	}

	//Move it up
	$this.$el.animate({
			bottom: $this.bottom + $this.$template.outerHeight()
		}, $this.options.duration, 
		function () {
			fabShiftDown($this); 
		}
	);
};

function fabShiftDown ($this) {
	if ($this.$el) {
		$this.$el.delay($this.options.delay).animate({
			bottom: $this.bottom
		}, $this.options.duration);
	}
}

function getContentType ($this) {
	var contentType;

	switch($this.element.attr("data-snackbar-type")) {

  		case 'success': contentType = "snackbar-success";

    	break

  		case 'error':  contentType = "snackbar-error";

    	break

  		default: contentType = $this.options.type;

    	break
	}

	return contentType;
}

Plugin.prototype = {

    init: function() {
		this.$template.find(".snackbar-content").text(this.content);

		this.show();
    },

    show: function() {
    	var contentHeight = getContentHeight(this);

    	this.$container
    			.append(this.$template)
    			.find(".snackbar-content")
    			.addClass(contentHeight+" "+getContentType(this));

    	fabShiftUp(this);

    	var self = this;

    	this.$template
    			.slideDown(this.options.duration)
    			.delay(this.options.delay)
    			.slideUp(this.options.duration, function () {self.destroy()});
    },

    destroy: function () {
    	this.$template.remove();
    	this.element.remove();
    }
};

/*
 * Plugin wrapper, preventing against multiple instantiations and
 * return plugin instance.
 */
$.fn[pluginName] = function (options) {

    var plugin = this.data(dataKey);

    // has plugin instantiated ?
    if (plugin instanceof Plugin) {
        // if have options arguments, call plugin.init() again
        if (typeof options !== 'undefined') {
            // plugin.init(options);
        }
    } else {
        plugin = new Plugin(this, options);
        this.data(dataKey, plugin);
    }
    
    return plugin;
};

//Call plugin

if ($(".snackbar-toggle").length !== 0) {
	$(".snackbar-toggle").snackbar(); 
}

}( jQuery ));

