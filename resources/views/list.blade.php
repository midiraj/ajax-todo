<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Ajax Todo Project</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	{{-- <link rel="stylesheet" href=""> --}}
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col d-flex justify-content-center mt-4">
				<div class="card">
					<div class="card-header">
						<h5>Ajax Todo List <a href="#" id="addNew" class="pull-right" data-toggle="modal" data-target=" #loginModal" style="margin-left: 250px;"><i class="fa fa-plus ml-5" aria-hidden="true"></i></a></h5>
					</div>
				    <div class="card-block">
						<div class="card-text" id="item">
							<ul class="list-group">
					            @foreach ($items as $item)
					            	<li class="list-group-item ourItem" data-toggle="modal" data-target=" #loginModal">{{ $item->item }}
									<input type="hidden" id="itemId" value="{{ $item->id }}">
					            	</li>
					            @endforeach
					        </ul>
				        </div>
				    </div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal" id="loginModal">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="title">Add New Item</h5>
	        <button class="close" data-dismiss="modal">&times;</button>
	      </div>
	      <div class="modal-body">
	        <form>
	          <div class="form-group">
	          	<input type="hidden" id="id">
	            <input type="text" placeholder="Add new item" class="form-control" id="AddItem">
	          </div>
	        </form>
	      </div>
	      <div class="modal-footer">
	        <button class="btn btn-warning" id="delete" data-dismiss="modal" style="display: none">Delete</button>
	        <button class="btn btn-primary" id="Addbutton" data-dismiss="modal">Add Item</button>
	        <button class="btn btn-primary" id="savechanges" data-dismiss="modal" style="display: none">Save Change</button>
	      </div>
	    </div>
	  </div>
	</div>
	{{ csrf_field() }}
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"
	  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
	  crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <script>
    	$(document).ready(function() {
    		$(document).on('click', '.ourItem', function(event) {
    				// After Click The List the text field and id will grab this two variable 
    				var text = $(this).text();
    				var id = $(this).find('#itemId').val();
    				// It will change the title 
    				$('#title').text('Edit Item');
    				// This will trim the text of input box
    				var text = $.trim(text);
    				// It will grab the text of input field 
    				$('#AddItem').val(text);
    				// It will show the delete button
    				$('#delete').show('400');
    				// It will show the save Change button
    				$('#savechanges').show('400');
    				// It will hide the Add New Button
    				$('#Addbutton').hide();
    				// It Will grab the input field id 
    				$('#id').val(id);
    				// It will show the text of li box
    				console.log(text);
    		});

    		$(document).on('click', '#addNew', function(event) {
    			// After click plus icon title will be changed. 
    			$('#title').text('Add New Item');
    			// Clear the input field.
				$('#AddItem').val('');
				// Hide delete Button 
				$('#delete').hide();
				// Hide Save Button
				$('#savechanges').hide();
				// Show Add Button 
				$('#Addbutton').show('400');
    		});

    		$('#Addbutton').click(function(event) {
    			// After Click Add Button the text variable grab the value of input field.
    			var text = $('#AddItem').val();
    			// Condition if input equal nothing the alert a message. 
    			if (text == "") {
    				alert('Please Type Anything');
    			}
    			// otherwise it will pass a post request to the server. first parameter is the route. second parameter is the text field. and third it send csrf token.
    			else
    			$.post('list', {'text': text,'_token':$('input[name=_token]').val()}, function(data) {
    				console.log(data);
    				// it refresh the list box. 
    				$('#item').load(location.href + ' #item');
    			});
    		});
    		// After click delete function also send a post request for delete the item 
    		$('#delete').click(function(event) {
    			// it will grab the hidden id of input box.
    			var id = $('#id').val();
    			// first parameter is the route.second one is the id whose we want to pass in the controller. and then csrf token.
    			$.post('delete', {'id': id,'_token':$('input[name=_token]').val()}, function(data) {
    				// it will refresh the list box.
    				$('#item').load(location.href + ' #item');
    			    console.log(data);
    			});
    		});
    		// After click save changes it will also send a post request for update the value
    		$('#savechanges').click(function(event) {
    			// it will grab the hidden id of input box
    			var id = $('#id').val();
    			// it will grab the value of input field and also trip the value.
    			var value = $.trim($('#AddItem').val());
    			// first parameter is the path, second is id and third is value of text field and last is csrf token.
    			$.post('update', {'id': id,'value': value,'_token':$('input[name=_token]').val()}, function(data) {
    				// it will refresh the list box
    				$('#item').load(location.href + ' #item');
    			    console.log(data);
    			});
    		});
    	});
    </script>
	
</body>
</html>