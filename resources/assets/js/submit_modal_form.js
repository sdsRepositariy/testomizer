(function ( $ ) {

// Plugin definition.
$.fn.submitModalForm = function( settings ) {

	var self = this;

	self.options =  $.extend({
        modal: "#app_modal",
        submitButton: $(self),
        submitFormHidden: "#submit_form_hidden",
    }, settings );

    setup();

	function setup() {
		$(self.options.submitButton).on("click", submit);
	};

	function submit(event) {
		event.preventDefault();
		var modal = $(self.options.modal);

    	// A hack to force the browser to display the native HTML5 error messages.
		if (!$(modal).find("form")[0].checkValidity()) {
			// The form won't actually submit		
			$(modal).find("form "+self.options.submitFormHidden+"").click();
		} else {
			$.ajax({
				method: modal.find("input[name=\'_method\']").val(),
				url: modal.find("form").attr('action'),
				data: modal.find("input[type=\'text\'], textarea"),
				dataType: 'json',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			})
			.done(function(response) {
				location.reload();
			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				if (jqXHR['status'] == '422') {
					modal.find(".form-group").removeClass("has-error");

					var response = jqXHR['responseJSON'];

					for (var prop in response) {
						var errorBlock = $("<span></span>").addClass("help-block").append($("<strong>"+response[prop]+"</strong>"));

						modal.find("input[name="+prop+"], textarea[name="+prop+"]")
							.parents(".form-group")
							.addClass("has-error")
							.children("div")
							.append(errorBlock);
					}
				} else if (jqXHR['status'] == '400') {
					modal.find(".help-block").remove();

					var response = jqXHR['responseJSON'];

					var errorBlock = $("<span></span>").addClass("help-block").append($("<strong>"+response["error"]+"</strong>"));

					modal.find(".modal-body")
							.addClass("has-error")
							.append(errorBlock);

				} else if (jqXHR['status'] == '500' || jqXHR['status'] == '404') {
					window.open("", "_self").document.write(jqXHR["responseText"]);
				} else {
					console.log(jqXHR);
				}
			});
		}
	};
};	
}( jQuery ));