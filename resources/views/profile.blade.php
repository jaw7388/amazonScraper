@extends('layouts.robot')

@section('content')

    
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Perfil</h1>
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
                    <h5><i class="icon fas fa-info"></i>Datos de la cuenta</h5>
                    Aca podras ver y modificar los datos de tu cuenta.
                </div>

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