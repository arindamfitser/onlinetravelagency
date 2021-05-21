@if(count($errors) > 0)
	@foreach($errors->all() as $error)
		<div class="alert alert-danger alert-dismissible">
    		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    		<strong>Error!</strong> {{ $error }}
    	</div>

	@endforeach
@endif

@if(session()->has('message'))
	<div class="alert alert-success alert-dismissible">
    		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    		<strong>Success!</strong> {{ session('message') }}
    </div>
@endif