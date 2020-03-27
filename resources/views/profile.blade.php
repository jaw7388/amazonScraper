@extends('adminlte::page')

@section('content')

    <h1>Profile</h1>
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