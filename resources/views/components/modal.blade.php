<div class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">
				@yield('form')
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">@lang('common.close')</button>

				@if(explode('@', \Route::currentRouteAction())[1] == 'edit' || explode('@', \Route::currentRouteAction())[1] == 'create' )
				<button id="app_modal_submit" type="submit" class="btn btn-primary">@lang('common.save')</button>
				@elseif(explode('@', \Route::currentRouteAction())[1] == 'delete')
				<button id="app_modal_submit" type="submit" class="btn btn-primary">@lang('common.delete')</button>
				@elseif(explode('@', \Route::currentRouteAction())[1] == 'moveFolder' || explode('@', \Route::currentRouteAction())[1] == 'moveItem')
				<button id="app_modal_submit" type="submit" class="btn btn-primary" disabled="disabled">@lang('common.move_here')</button>
				@endif
			</div>
		</div>
	</div>
</div>
<script>
var modalHandler = {

	init: function( options ) {
        this.options = {
            modal: "#app_modal",
            submitButton: "#app_modal_submit",
            submitFormHidden: "#submit_form_hidden",
        };
 
        // Allow overriding the default options
        $.extend( this.options, options );

        this.setup();
    },

	setup: function() {
		var self = this;

		$(this.options.modal).find(this.options.submitButton).on("click", { self: self }, self.submit);

		$(this.options.modal).find('.modal').on('hidden.bs.modal', self.delete);
	},

	submit: function(event) {
		event.preventDefault();
		
		var self = event.data.self;

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
				beforeSend: function() {
					modal.find(".form-group")
						.removeClass("has-error")
						.find(".help-block")
						.remove();
				},
			})
			.done(function(response) {
				location.reload();
			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				if (jqXHR['status'] == '422') {
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
	},

	delete: function(event) {
		$(event.target).parent().empty();
	}

}

//Run handler
$(function(){
	modalHandler.init();
});

</script>