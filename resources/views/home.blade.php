@extends('adminlte::page')

@section('content')

    <h1>Hola</h1>
    <pre>
    {{ Auth::user()->id ?? '' }}
    {{ print_r($result) ?? '' }}
    </pre>
@endsection