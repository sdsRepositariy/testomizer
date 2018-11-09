(function ( $ ) {

// Plugin definition.
$.fn.submitModalList = function( settings ) {

	var self = this;

	self.options =  $.extend({
    	submitButton: $(this),
		upward: ".app-header a",
		action: "moveto",
    }, settings );

    setup();       

	function setup () {
		$(self.options.submitButton).on("click", submit);
	};

	function submit(event) {
		event.preventDefault();

		var target = self.options.submitButton.attr("data-target");

		var moveTo = self.options.submitButton
										.parent()
										.siblings(".modal-body")
										.find(self.options.upward);

		var url = self.options.submitButton.attr("data-path")+"/"+target+"/"+self.options.action;

		if (moveTo.length != 0) {
			url += "/"+moveTo.attr("data-current-folder");
		}

		$.ajax({
			method: "POST",
			url: url,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		})
		.done(function(response) {
			location.reload();
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			window.open("", "_self").document.write(jqXHR["responseText"]);
		});
	};
};	
}( jQuery ));
