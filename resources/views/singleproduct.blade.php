@extends('layouts.robot')

@section('content')

<div id="app">
    <singlesearch-component />
</div>

<div>
    <h1>HOLA</h1>
    <form action="search/one" method="post">
    @csrf
        <input type="text" name="sku">
        <input type="submit">
    </form>
</div>
@endsection