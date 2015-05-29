@extends('app')

@section('content')
<div class="container">
	{!! Form::open(array('method' => 'POST', 'enctype' => 'multipart/form-data')) !!}

		<div class="form-group">
			This is thing uploader
			<input type="file" class="form-control" id="file" name="fileupload">
		</div>

		<input type="submit" class="btn" value="upload">
		
  {!! Form::close() !!}
</div>
@endsection
