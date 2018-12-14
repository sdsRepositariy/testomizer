<div class="row question-header">
	<div class="col-xs-7 col-sm-8 col-xs-offset-2 text-center"><strong>New question</strong></div>
	<div class="col-sm-2 hidden-xs">
		<a class="close" href="#">Exit</a>
	</div>
	<div class="col-xs-3 visible-xs-block">
		<a class="btn btn-app-round-icon btn-app-icon-default round-icon-xs pull-right" href="#"><span class="glyphicon glyphicon-remove"></span></a>
	</div>
</div>

<form class="form-horizontal">
	<div class="form-group">
		<label for="form_1" class="control-label col-xs-12 col-sm-2">Question form</label>
		<div class="col-xs-12 col-sm-8">
			<select class="form-control" id="form_1">
				<option>Single answer</option>
				<option>Multiply answer</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="question_1" class="control-label col-xs-12 col-sm-2">Question</label>
		<div class="col-xs-12 col-sm-8">
			<textarea class="form-control" id="question_1" placeholder="Question"></textarea>
		</div>
	</div>
	<div class="form-group">
		<div class="col-xs-12 col-sm-offset-2">
			<button class="btn btn-default">Add image</button>
		</div>
	</div>
	<div class="form-group">
		<label for="weight" class="col-xs-12 col-sm-2 control-label">Weight</label>
		<div class="col-xs-4 col-sm-2 col-lg-1">
			<input type="number" min="1" value="1" class="form-control" id="weight">
		</div>
	</div>
	<div class="answer-block">
		<div class="form-group">
			<div class="col-xs-7 col-sm-8 col-xs-offset-2 text-center">
				<h4>
					<strong>Answer&#x02116;</strong>
					<strong>1</strong>
				</h4>
			</div>
			<div class="col-sm-2 hidden-xs">
				<button class="btn btn-sm btn-danger pull-right">Delete</button>
			</div>
			<div class="col-xs-3 visible-xs-block">
				<button class="btn btn-app-round-icon btn-app-icon-default round-icon-xs pull-right" href="#"><span class="glyphicon glyphicon-remove"></span></button>
			</div>
		</div>
		<div class="form-group">
			<label for="answer_1" class="control-label col-xs-12 col-sm-2">Answer</label>
			<div class="col-xs-12 col-sm-8">
				<textarea rows="2" class="form-control" id="answer_1" placeholder="Answer"></textarea>
			</div>
		</div>
		<div class="form-group">
			<div class="col-xs-12 col-sm-offset-2">
				<button class="btn btn-default">Add image</button>
			</div>
		</div>
		<div class="form-group">
			<div class="col-xs-6 col-sm-6">
				<div class="row">
					<label for="answer_score_1" class="control-label col-sm-2 col-sm-offset-2">Score</label>
					<div class="col-sm-6">
						<input type="number" min="0" value="1" class="form-control" id="answer_score_1" placeholder="Score">
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-sm-6">
				<div class="row">
					<label for="answer_order_1" class="control-label col-sm-2">Order</label>
					<div class="col-sm-6">
						<input type="number" min="0" value="1" class="form-control" id="answer_order_1" placeholder="Order">
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="control-label col-sm-2">
				<strong>Scales</strong>
			</div>
			<div class="col-xs-12 col-sm-8">
				<table class="table">
					<tr>
						<td>Lorem ipsum dolor</td>
						<td>
							<input type="checkbox" name="answer_scale_1" value="">
						</td>
					</tr>
					<tr>
						<td>Lorem ipsum dolor</td>
						<td>
							<input type="checkbox" name="answer_scale_2" value="">
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div id="add_answer">
		<button class="btn btn-default">Add answer</button>
	</div>
	<div id="save_question">
		<button class="btn btn-primary pull-right">Save</button>
	</div>
</form>
<script>
$(function(){
	// $('textarea').autosize();
 }); 
</script>