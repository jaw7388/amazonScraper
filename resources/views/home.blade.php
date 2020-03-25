@extends('adminlte::page')

@section('content')

    <h1>Hola</h1>
    {{ Auth::user()->id ?? '' }}
    {{ $result ?? '' }}
    {{ $access_token ?? '' }}
    {{ $abc}}
    
@endsection