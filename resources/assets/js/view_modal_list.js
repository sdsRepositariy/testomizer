(function ( $ ) {

// Plugin definition.
$.fn.viewModalList = function( settings ) {

	var self = this;

	self.options =  $.extend({
    	modalList: $(this),
    	upward: ".app-header a",
    	folder: "a.list-primary-action",
        submitButton: "#app_modal_submit",
    }, settings );

	var submitButton = $(self.options.submitButton);
	var upwardLink = $(self.options.modalList).find(self.options.upward);
	var folders = $(self.options.modalList).find(self.options.folder);

    setup();       

	function setup () {
		if(submitButton.attr("name") == "move_folder") {
			var targetFolder = getTargetFolder(submitButton.attr("data-target"), folders);
		
			if (targetFolder != false) {
				$(targetFolder).addClass("disabled-link");
				submitButton.attr("disabled", "disabled");
			} else {
				submitButton.removeAttr("disabled");
			}
		} else if (submitButton.attr("name") == "move_item") {
			//For root folder the "currentItemFolder" is undefined
			if (upwardLink.length == 0) {
				var currentFolder = "";
			} else {
				currentFolder = upwardLink.attr("data-current-folder");
			}

			if (submitButton.attr("data-task-folder") == currentFolder) {
				submitButton.attr("disabled", "disabled");
			} else {
				submitButton.removeAttr("disabled");
			}
		}

		//Add event handler
		if ( upwardLink.length !=0 ) {
			upwardLink.on("click", getContent);
		}

		if ( folders.length !=0 ) {
			folders.on("click", getContent);
		}
	};

	function getTargetFolder (targetFolder, folders) {
		var foundFolder = "";

		folders.each(function( index ) {
			if ( getFolderId(this.pathname)==targetFolder ) {
				foundFolder = this;
				return false;
			}
		});

		if (foundFolder != "") {
			return foundFolder;
		} else {
			return false;
		}
	};

	function getFolderId (pathname) {
		var regexp = /(\d+)\/list$/;

		var folderId = pathname.match(regexp);

		if ( folderId != null ) {
			return folderId[1];
		} else {
			return "";
		}
	};

	function getContent (event) {
		event.preventDefault();

		var target = $(event.currentTarget);
		
		//Prevent call for disabled link
		if ( target.parent('li').hasClass("disabled") || target.hasClass("disabled-link")) {
			return false;
		}

		$.ajax({
			method: "GET",
			url: target.attr('href'),
		})
		.done(function(html) {
			$(self.options.modalList).empty().append(html);
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			window.open("", "_self").document.write(jqXHR["responseText"]);
		});
	};
};	
}( jQuery ));
