@extends('adminlte::page')

@section('content')

    <h1>Hola</h1>
    {{ Auth::user()->id ?? '' }}

@php
        $result = Meli::withToken();    
        print_r($result);
        $access_token = User::where('id', Auth::user()->id )->firstOrFail();
        $params = array('access_token' => $access_token->token);
        $result = Meli::get('/users/me', $params, true); 
@endphp

@endsection