@extends('layouts.robot')

@section('content')

    
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Configuración</h1>
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
                
                <div class="row justify-content-center">
                    <div class="text-center">
                        <img src="https://logosmarcas.com/wp-content/uploads/2018/05/Amazon-Logo.png" alt="" style="max-width:30%">
                        
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4 offset-md-4">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                            <div class="input-group-append">
                              <button class="btn btn-info btn-flat" type="button">
                                <i class="fas fa-search"></i> Buscar
                              </button>
                            </div>
                          </div>
                          <p class="text-center text-primary">Introduce un codigo SKU-ASIN valido</p>
                    </div>
                </div>

                <pre>
                    @isset($array)
                        {{ print_r($array) }}
                    @endisset
                
                </pre>
            </div>
        </div>
    </div>
</section>






<h1>Hola</h1>
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