@extends('adminlte::page')

@section('content')

    <h1>Hola</h1>
    {{ Auth::user()->id ?? '' }}

@php
      $params = array('access_token' => $access_token);
$result = $meli->get('/users/me', $params, true); 
@endphp

@endsection