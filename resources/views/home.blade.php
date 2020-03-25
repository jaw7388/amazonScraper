@extends('adminlte::page')

@section('content')

    <h1>Hola</h1>
    {{ Auth::user()->id ?? '' }}

@php
        $result = Meli::withToken();    
        print_r($result);
@endphp

@endsection