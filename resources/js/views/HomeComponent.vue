<template>
    <div class="container">
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

        <section>
        <div class="card">
            <div class="card-header">
                <h3>Márgenes de ganancias </h3>
            </div>
            
            <div class="card-body">
                
                <div class="row mb-2">
                    
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                        <div class="info-box-content  pt-4 pb-3">
                            <h6 class="font-weight-bold">ACTIVOS</h6>
                            <span class="info-box-number text-success">
                            0
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-shopping-cart"></i></span>

                        <div class="info-box-content  pt-4 pb-3">
                            <h6 class="font-weight-bold">PAUSADOS</h6>
                            <span class="info-box-number text-danger">
                            0
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-thumbs-up"></i></span>

                        <div class="info-box-content">
                            <h6 class="mb-0 font-weight-bold">Ventas completadas</h6>
                            <span class="info-box-number text-primary">
                            0
                            </span>
                            <i>Histórico</i>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-down"></i></span>

                        <div class="info-box-content">
                            <h6 class="mb-0 font-weight-bold">Ventas canceladas</h6>
                            <span class="info-box-number text-danger">
                            0
                            </span>
                            <i>Histórico</i>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>

                </div>


                 <div class="row mb-2">
                    
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-chart-line"></i></span>

                        <div class="info-box-content">
                            <h6 class="mb-0 font-weight-bold"> Total Ventas</h6>
                            <span class="info-box-number text-info">
                            0 
                            </span>
                            <i>Histórico</i>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-star"></i></span>

                        <div class="info-box-content">
                            <h6 class="mb-0 font-weight-bold"> Ventas</h6>
                            <span class="info-box-number text-info">
                            0 
                            </span>
                            <i>Últimos 4 meses</i>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1 text-white"><i class="fas fa-exclamation-circle"></i></span>

                        <div class="info-box-content">
                            <h6 class="mb-0 font-weight-bold"> Porcentaje de Reclamos</h6>
                            <span class="info-box-number text-warning">
                            0 %
                            </span>
                            <i>Últimos 4 meses</i>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-percent"></i></span>

                        <div class="info-box-content">
                            <h6 class="mb-0 font-weight-bold"> Tasa de Conversión</h6>
                            <span class="info-box-number text-info">
                            0
                            </span>
                            <i>Últimos 4 meses</i>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>

                </div>


                 <div class="row mb-2">
                    
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-chart-line"></i></span>

                        <div class="info-box-content">
                            <h6 class="mb-0 font-weight-bold"> Ventas</h6>
                            <span class="info-box-number text-info">
                            0
                            </span>
                            <i>Hoy</i>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-star"></i></span>

                        <div class="info-box-content">
                            <h6 class="mb-0 font-weight-bold"> Ventas</h6>
                            <span class="info-box-number text-info">
                            0
                            </span>
                            <i>Último mes</i>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-exclamation-circle"></i></span>

                        <div class="info-box-content">
                            <h6 class="mb-0 font-weight-bold">Porcentaje ventas canceladas</h6>
                            <span class="info-box-number text-danger">
                            0
                            </span>
                            <i>Últimos 4 meses</i>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-percent"></i></span>

                        <div class="info-box-content">
                            <h6 class="mb-0 font-weight-bold">Tasa de Conversión</h6>
                            <span class="info-box-number text-info">
                            0
                            </span>
                            <i>Última semana</i>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>

                </div>


               

            </div>
        </div>    
    </section>

    </div>
</template>

<script>
export default {

}
</script>

<style>

</style>



