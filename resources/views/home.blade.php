@extends('layouts.robot')

@section('content')
    <div id="app">
        <home-component />
    </div>

    <pre>
    {{ Auth::user()->id ?? '' }}
    
    @isset($result)
        {{ print_r($result) }}    
    @endisset
    @isset($meliUser)
        {{ print_r($meliUser) }}    
    @endisset
    @isset($avatar)
        {{ print_r($avatar) }}    
    @endisset
    </pre>
@endsection