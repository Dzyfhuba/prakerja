@extends('layouts.app')

@section('content')
  <div class='p-3'>
    <h1>{{$item->title}}</h1>
    <p>{{$item->content}}</p>
  </div>
@endsection
