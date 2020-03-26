@extends('adminlte::page')

@section('content')

    <h1>Hola</h1>
    <pre>
    {{ Auth::user()->id ?? '' }}
    
    @isset($result)
        {{ print_r($result) }}    
    @endisset
    @isset($meliUser)
        {{ print_r($meliUser) }}    
    @endisset
    
    </pre>
@endsection