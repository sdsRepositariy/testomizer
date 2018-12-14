<form class="form-horizontal">
	<div class="form-group">
		<label for="testName" class="col-sm-2 control-label">
		@lang('admin/tests.test_name')
		</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" id="testName" placeholder="@lang('admin/tests.test_name')">
		</div>
	</div>
	<div class="form-group">
		<label for="testDescription" class="col-sm-2 control-label">@lang('admin/tests.test_description')</label>
		<div class="col-sm-8">
			<textarea rows="3" class="form-control" id="testDescription" placeholder="@lang('admin/tests.test_description')"></textarea>
		</div>
	</div>
	<div class="form-group">
		<label for="quantity" class="col-xs-12 col-sm-2 control-label">
		@lang('admin/tests.quantity')
		</label>
		<div class="col-xs-3 col-sm-2 col-lg-1">
			<input type="text" class="form-control" id="quantity">
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<div class="checkbox">
				<label>
	  				<input type="checkbox">@lang('admin/tests.skip_question')
				</label>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<div class="checkbox">
				<label>
	  				<input id="showUniformVariants" type="checkbox">@lang('admin/tests.uniform_variants')
				</label>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-xs-12 col-sm-offset-2 col-sm-8">
			<table class="table app-table-collapse">
				<tr>
					<th class="col-sm-1">&#x02116;</th>
					<th class="col-sm-5">@lang('admin/tests.variant')</th>
					<th class="col-sm-2">@lang('admin/tests.score')</th>
					<th class="col-sm-2">@lang('admin/tests.order')</th>
					<th class="col-sm-2">@lang('common.action')</th>
				</tr>
				<tr class="app-input-section">
					<td data-number-header="@lang('admin/tests.variant')&#x02116;&nbsp;">1</td>
					<td>
						<label for="variant_1" class="control-label visible-xs-block">@lang('admin/tests.variant')</label>
						<select class="form-control" id="variant_1">
							<option value="add_uniform_variant">@lang('admin/tests.add_variant')</option>
							<option disabled>_________</option>
							<option name="uniform_variant">Yes</option>
							<option>No</option>
							<option>May be</option>
							<option>Higly likely</option>
						</select>
					</td>
					<td class="cell-xs-6">
						<label for="score_1" class="control-label visible-xs-block">@lang('admin/tests.score')</label>
						<input type="number" min="0" value="1" class="form-control" id="score_1" placeholder="@lang('admin/tests.score')">
					</td>
					<td class="cell-xs-6">
						<label for="order_1" class="control-label visible-xs-block">@lang('admin/tests.order')
						</label>
						<input type="number" min="0" class="form-control" id="order_1" placeholder="@lang('admin/tests.order')">
					</td>
					<td>
						<button type="button" class="btn btn-danger">@lang('common.delete')</button>
					</td>
				</tr>
				<tr>
					<td colspan="5">
						<button id="addVariant" type="button" class="btn btn-primary">@lang('common.add')</button>
					</td>
				</tr>
			</table>
		</div>
	</div>
</form>
<script>
var uniformVariants = {

    setup: function() {
    	// $( "#showUniformVariants" ).change(uniformVariants.toggleVariants);
    	// $( "#addVariant" )
    	// $( "#deleteVariant" )
    },

    toggleInput: function() {
    	//Get variant
    	var variant = $(this).parents('div[data-uniform-variant]').get(0);

    	//Get variant number
    	var variantNumber = $(variant).attr("data-uniform-variant");

    	//Make input tag
    	var inputTag = $("<input>")
    						.addClass("form-control")
    						.attr("id", "selectVariant_"+variantNumber)
    						.attr("type", "text")
    						.attr("name", "uniform_variant_"+variantNumber);

    	//Get select tag
    	var selectTag = $(variant).find("select");

    	//Get parent of the select tag
    	var selectParent = selectTag.parent();

    	//Remove select tag
    	selectTag.remove();

    	//Insert input tag
    	selectParent.append(inputTag);
    },

    addVariant: function() {

 	},

    deleteVariant: function() {

    },

    toggleVariants: function() {
    	if (this.checked) {
    		$("div[data-uniform-variant]").show();
    		$("div[data-uniform-variant] option[value=add_uniform_variant]").click(uniformVariants.toggleInput);
    	} else {
    		$("div[data-uniform-variant]").hide();
    		$("div[data-uniform-variant] option[value=add_uniform_variant]").unbind();
    	}
    }, 
};

$( document ).ready( uniformVariants.setup );
</script>