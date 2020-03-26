@extends('adminlte::page')

@section('content')

    <h1>Hola</h1>
    <pre>
    {{ Auth::user()->id ?? '' }}
    
    @if($result)
        {{ print_r($result) }}    
    @endif
    
    </pre>
@endsection