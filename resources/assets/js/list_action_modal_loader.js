(function ( $ ) {

// Plugin definition.
$.fn.listActionModalLoader = function( settings ) {

	var self = this;

	self.options =  $.extend({
    	action: $(this).find("a[data-modal-title]"),
        titleAttr: "data-modal-title",
        parentFolderAttr: "data-parent-folder",
        appModal: "#app_modal",
    }, settings );
    
    setup();       

	function setup () {
		self.options.action.each(function() {
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
			data: {parent_folder: target.attr(self.options.parentFolderAttr)},
		})
		.done(function(html) {
			showModal( html, target );
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			window.open("", "_self").document.write(jqXHR["responseText"]);
		});
	};

	function showModal(html, target) {
		//Show modal
		$(self.options.appModal).append(html)
					.find(".modal")
					.modal("show")
					.find(".modal-title")
					.text(target.attr(self.options.titleAttr));

		$(self.options.appModal).on('hidden.bs.modal', deleteModal);
	};

	function deleteModal() {
		$(this).empty();
	};

};	
}( jQuery ));
