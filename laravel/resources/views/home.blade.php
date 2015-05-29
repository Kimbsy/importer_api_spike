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
<div class="container">
  <table>
    <thead>
      <tr>
        <td>
          Name
        </td>
        <td>
          Records
        </td>
      </tr>
    </thead>
    <tbody>
      @foreach ($imports as $import)
        <tr>
          <td>{{ $import->name }}</td>
          <td><a class="btn" href="/entries/{{ $import->id }}">Entries</a></td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
