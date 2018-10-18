(function ( $ ) {

// Plugin definition.
$.fn.actionHandler = function( settings ) {

	var self = this;

	self.options =  $.extend({
    	list: $(this),
        titleAttr: "data-modal-title",
        parentGroupAttr: "data-parent-group",
        appModal: "#app_modal",
    }, settings );
    
    setup();       

	function setup () {
		self.options.list.find("a").each(function() {
			$(this).click(getContent);
		});
	};


	function getContent (event) {
		event.preventDefault();

		var target = $(event.currentTarget);

		//Prevent call for disabled link
		if ( target.parent('li').hasClass("disabled") ) {
			return false;
		}

		$.ajax({
			method: "GET",
			url: target.attr('href'),
		})
		.done(function(html) {
			showModal( html, target );
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			window.open("", "_self").document.write(jqXHR["responseText"]);
		});
	};

	function showModal(html, target) {
		$(self.options.appModal).append(html)
					.find(".modal")
					.modal("show")
					.find(".modal-title")
					.text(target.attr(self.options.titleAttr));

		$('input#parent_group').attr("value", target.attr(self.options.parentGroupAttr));
	};

};	
}( jQuery ));
