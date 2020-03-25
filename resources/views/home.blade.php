@extends('adminlte::page')

@section('content')

    <h1>Hola</h1>
    {{ Auth::user()->id ?? '' }}
    {{ print_r($result) ?? '' }}
    
@endsection