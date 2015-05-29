@extends('app')

@section('content')

@foreach($entries as $entry) 
  <div class="container">
    {{ $entry->data }}
    <a class="btn" onClick="if (Math.random()<.5) {alert('it\'s good!')} else {alert('this is not ok')}">validate</a>
    <a class="btn" href="/upload/{{ $entry->id }}">upload</a>
  </div>
@endforeach
@endsection
