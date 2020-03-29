@extends('layouts.robot')

@section('content')

<pre>
    @isset($array)
        {{ print_r($array) }}
    @endisset

</pre>

@endsection