(function($){
$(function(){

//Submit filter form data
$( ".filter select" ).change(function() {
	$( this ).closest('form').submit();
});

//Tooltip initialization
$('[data-toggle="tooltip"]').tooltip()


//Get name of selected item
$(".filter").each(function() {
	var selectedItem = $(this).find("li[data-selected='true']").text();
	$(this).find("div.selected").text(selectedItem);
});

$( ".filter li" ).click(function() {
	var data = $(this).attr('data-value');

	$(this).parent().siblings('input').attr('value', data);
	
	$(this).closest('form').submit();
});

//Handle sorting
$(".sort a").on("click", function(event){
	event.preventDefault();

	var parentElement = $(this).closest('th');
	
	//Reset sorting in over columns
	var onlyRelatedParents = parentElement.siblings().filter(".sort");
	onlyRelatedParents.find("a[href!='#']").addClass('hidden');
	onlyRelatedParents.find("a[href ='#']").removeClass('hidden');

	//Hide current element
	$(this).toggleClass('hidden');

	//Toggle links
	var nextElement = $(this).next("a[href!='#']");
	if (nextElement.length == 0) {
		nextElement = parentElement.find("a[href!='#']").first();
	}
	nextElement.toggleClass('hidden');

	//Make request
	location.href = nextElement.attr('href');
});

//Call the modal for file upload
$("#callupload").click(function(){
	$("#upload").modal();
});


});
})(jQuery);