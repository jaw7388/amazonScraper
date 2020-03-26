@extends('adminlte::page')

@section('content')

    <h1>Hola</h1>
    <pre>
    {{ Auth::user()->id ?? '' }}
    
    @isset($result)
        {{ print_r($result) }}    
    @endisset

    </pre>
@endsection