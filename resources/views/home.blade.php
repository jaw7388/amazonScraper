@extends('layouts.robot')

@section('content')

    
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Principal</h1>
        </div>
      </div>
    </div>
</section>

<section>
    <div class="card">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-info"></i>Busqueda manual</h5>
                    Aca podras ingresar un numero de SKU-ASIN para ver la información del articulo.
                </div>
                
            </div>
        </div>

        
    </div>
</section>

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