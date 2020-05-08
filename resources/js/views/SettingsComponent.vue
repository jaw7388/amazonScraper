<template>
<div class="container">
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Configuración</h1>
            </div>
        </div>
        </div>
    </section>
    <div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-info"></i>Busqueda manual</h5>
        Aca podras ingresar un numero de SKU-ASIN para ver la información del articulo.
    </div>
    <section>
        <div class="card">
            <div class="card-header">
                <h3>Márgenes de ganancias </h3>
            </div>
            
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        <div class="row p-3">
                            <h4 class="text-primary">Por precio</h4>
                            <pricetable-component />
                        </div>
                    </div>

                    <div class="col-md-4 mb-2">
                        <div class="row p-3">
                            <h4 class="text-primary">Por peso</h4>
                            <weighttable-component />
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="row mb-2 p-3">
                            <h4 class="text-primary">Por impuestos nacionales</h4>
                            <taxestable-component />
                        </div>
                        <div class="row mb-2 p-3">
                            <h4 class="text-primary">Impuestos (Amazon)</h4>
                            <div class="form-group">
                                <div class="col-md-4">
                                    <b-form-checkbox 
                                    v-model="amazonTaxCheck" 
                                    name="check-button" 
                                    @input="update([amazonTaxCheck, 'taxes_amazon'])" 
                                    switch>
                                    {{ amazonTaxCheck ? 'Desactivar' : 'Activar' }}
                                    </b-form-checkbox>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </section>

    <section>
        <div class="card">
            <div class="card-header">
                <h3>Publicaciones </h3>
            </div>
            
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                            <h4 class="text-primary">Tipo de envío</h4>
                        <div class="row p-3">
                            
                            <form>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label">Tipo</label>
                                    <div class="col-md-8">
                                    <b-form-select 
                                        v-model="envioTipoSelected"
                                        :options="envioTipos"
                                        @input="update([envioTipoSelected, 'shipping_type'])">
                                    </b-form-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label">Descripción</label>
                                    <div class="col-md-8">
                                        {{envioDescripcion}}
                                    <input type="text" class="form-control" 
                                        v-model="envioDescripcion" 
                                        @blur="getData(envioDescripcion)">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label">Valor</label>
                                    <div class="col-md-8">
                                    <input type="number" class="form-control" v-model="envioValor">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-8">
                                    <button class="btn btn-primary">Guardar</button>
                                    </div>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <h4 class="text-primary">Comisión Mercadolibre</h4>
                        <div class="row p-3">
                            <form>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label">% Comisión</label>
                                    <div class="col-md-4">
                                        <input type="number" class="form-control" >
                                    </div>
                                    <div class="col-md-4">
                                    <button class="btn btn-primary">Guardar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <h4 class="text-primary">Tipo de Publicación</h4>
                        <div class="row p-3">
                            <form>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label">Tipo</label>
                                    <div class="col-md-4">
                                        <select class="form-control" id="exampleFormControlSelect1">
                                            <option>1</option>
                                            <option>2</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                    <button class="btn btn-primary">Guardar</button>
                                    </div>
                                </div>
                               
                            </form>
                            
                        </div>
                    </div>
                <!-- STOCK -->
                    <div class="col-md-4 mb-2">
                        <h4 class="text-primary">Disponibilidad de stock</h4>
                        <div class="row p-3">
                            <form>
                                <div class="form-group row d-flex align-items-center">
                                    <label class="col-md-3 col-form-label">Días</label>
                                    <div class="col-md-4">
                                        <input type="number" class="form-control" >
                                    </div>
                                    <div class="col-md-4">
                                        <b-form-checkbox  name="check-button" v-model="stockDisponible[0]" @change="checkBoxUpdate(stockDisponible)" switch>
                                        Activar<b>(Checked: {{ stockDisponible[0] }})</b> -->
                                        </b-form-checkbox>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                        <h4 class="text-primary">Garantía del producto</h4>
                        <div class="row p-3">
                            <form>
                                <div class="form-group row d-flex align-items-center">
                                    <label class="col-md-3 col-form-label">Días</label>
                                    <div class="col-md-4">
                                        <input type="number" class="form-control" >
                                    </div>
                                    <div class="col-md-4">
                                        <b-form-checkbox  name="check-button" switch>
                                        Activar<!-- <b>(Checked: {{ checked }})</b> -->
                                        </b-form-checkbox>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>    
    </section>

    <section>
        <div class="card">
            <div class="card-header">
                <h3>Otras opciones</h3>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                <!-- Marcas vetadas -->
                    <div class="col-md-4 mb-2">
                        <h4 class="text-primary">Escaner de marcas vetadas</h4>
                        <div class="row p-3">
                            <form>
                                <div class="form-group row d-flex align-items-center">
                                    <div class="col-md-4">
                                        <b-form-checkbox  name="check-button" switch>
                                        Activar<!-- <b>(Checked: {{ checked }})</b> -->
                                        </b-form-checkbox>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>    
    </section>
<!-- Descripcion -->
    <section>
        <div class="card">
            <div class="card-header">
                <h3>Publicaciones </h3>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                
                    <div class="col-md-8 mb-2">
                        <div class="row pl-3">
                            <b-form-textarea
                                id="textarea-rows"
                                placeholder="Descripcion"
                                rows="30"
                            ></b-form-textarea>
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="row pl-3">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3>Etiquetas</h3>
                                    </div>    
                                    <div class="card-body">
                                        <h5>@Titulo</h5>
                                        <h6>Nombre del producto</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>    
    </section>

    <section>
        <div class="card">
            <div class="card-header">
                <h3>Otras opciones</h3>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                <!-- Marcas vetadas -->
                    <div class="col-md-4 mb-2">
                        <h4 class="text-primary">Escaner de marcas vetadas</h4>
                        <div class="row p-3">
                            <form>
                                <div class="form-group row d-flex align-items-center">
                                    <div class="col-md-4">
                                        <b-form-checkbox  name="check-button" switch>
                                        Activar<!-- <b>(Checked: {{ checked }})</b> -->
                                        </b-form-checkbox>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>    
    </section>
<!-- Descripcion -->
    <section>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3>Imagenes</h3>
                    </div> 
                    <div class="card-body">
                        <div class="card border-danger mb-3" style="max-width: 18rem;">
                            <div class="card-bodyr">
                                <p class="card-text p-2">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                        </div>
                            <div class="form-group">
                                <input type="url" class="form-control mb-3" id="imageUrl1" placeholder="Url" >
                                <input type="url" class="form-control mb-3" id="imageUrl1" placeholder="Url">
                            </div>
                    </div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3>Sinónimos</h3>
                    </div> 
                    <div class="card-body">
                        
                    </div>       
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3>Marcas Vetadas</h3>
                    </div> 
                    <div class="card-body">
                        <div class="row">
                            <forbiddenbrands-component />
                        </div>
                    </div>       
                </div>
            </div>
            

            
        </div>
    </section>
</div>
</template>

<script>
export default {
    data() {
        return {
            stockDisponible: [true, 'stock_available'],
            amazonTaxCheck: true,
            envioTipos: [
                {value: 'me2', text: 'Mercado Envíos'},
                {value: 'custom', text: 'Acordar con el vendedor'},
            ],
            envioTipoSelected: null,
            envioDescripcion: null,
            envioValor: null
        }
    },
    methods: {

        update(model){
            
            const modelValue = model[0]
            const modelName = model[1].toString()
            const data = {[modelName]:modelValue}
            axios.put('profile/update', data)
            .then((response) => {})
            .catch(function(error){});
        },

        getData(data){
            console.log(data)
            
            
            
            
        }

        // updateAmazonTax(){
        //     this.amazonTaxCheck ? this.amazonTaxCheck = false : this.amazonTaxCheck= true            
        //     axios.put('profile/update',
        //     {'taxes_amazon':this.amazonTaxCheck})
        //     .then((response) => {})
        //     .catch(function(error){});
        // }
    },
    async mounted() {
        const datos = await axios.get('profile')
        const data = datos.data
        this.amazonTaxCheck = data.taxes_amazon == 1
        this.envioTipoSelected = data.shipping_type
    },

    

}
</script>

<style>

</style>