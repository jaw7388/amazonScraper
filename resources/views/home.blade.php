@extends('adminlte::page')

@section('content')

    <h1>Hola</h1>
    {{ Auth::user()->id ?? '' }}

@php
        //$result = Meli::withToken();    
        
        //$access_token = User::where('id', Auth::user()->id )->firstOrFail();
        //$params = array('access_token' => $access_token);
        $result = Meli::withToken()->get('/users/me', $params, true); 
        print_r($result);
@endphp

@endsection