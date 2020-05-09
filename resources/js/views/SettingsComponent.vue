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
                                    <input type="text" class="form-control" 
                                        v-model="envioDescripcion" 
                                        @blur="update([envioDescripcion, 'shipping_description'])">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label">Valor</label>
                                    <div class="col-md-8">
                                    <input type="number" class="form-control" 
                                        v-model="envioValor"
                                        @blur="envioValor ? envioValor:envioValor=0, update([envioValor, 'shipping_cost'])">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-8">
                                    <button class="btn btn-primary">Guardar</button>
                                    </div>
                                </div>
                            
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <h4 class="text-primary">Comisión Mercadolibre</h4>
                        <div class="row p-3">
                            
                                <div class="form-group row">
                                    <label class="col-md-6 col-form-label">% Comisión</label>
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" 
                                         v-model="comisionValor"
                                        @blur="comisionValor ? comisionValor:comisionValor=0, update([comisionValor, 'mercadolibre_fee'])">
                                    </div>
                                </div>
                            
                        </div>
                        <h4 class="text-primary">Tipo de Publicación</h4>
                        <div class="row p-3">
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label">Tipo</label>
                                        <div class="col-md-8">
                                        <b-form-select 
                                            v-model="publicacionTipoSelected"
                                            :options="publicacionTipo"
                                            @input="update([publicacionTipoSelected, 'post_type'])">
                                        </b-form-select>
                                    </div>
                                </div>
                            
                        </div>
                    </div>
                <!-- STOCK -->
                    <div class="col-md-4 mb-2">
                        <h4 class="text-primary">Disponibilidad de stock</h4>
                        <div class="row p-3">
                            
                                <div class="form-group row d-flex align-items-center">
                                    <label class="col-md-3 col-form-label">Días</label>
                                    <div class="col-md-4">
                                        <input type="number" class="form-control" 
                                            v-model="stockDias"
                                            @blur="stockDias ? stockDias : stockDias = 0, update([stockDias, 'stock_days'])"
                                            :disabled="stockDisponibleCheck?false:true">
                                    </div>
                                    <div class="col-md-4">
                                        <b-form-checkbox  name="check-button" 
                                            v-model="stockDisponibleCheck" 
                                            @input="update([stockDisponibleCheck, 'stock_available'])" 
                                            switch>
                                            {{ stockDisponibleCheck ? 'Desactivar' : 'Activar' }}
                                        </b-form-checkbox>
                                    </div>
                                </div>
                            
                        </div>
                        <h4 class="text-primary">Garantía del producto</h4>
                        <div class="row p-3">
                            
                                <div class="form-group row d-flex align-items-center">
                                    <label class="col-md-3 col-form-label">Días</label>
                                    <div class="col-md-4">
                                        <input type="number" class="form-control"
                                            v-model="garantiaDias" 
                                            @blur="garantiaDias ? garantiaDias : garantiaDias = 0, update([garantiaDias, 'warranty_days'])"
                                            :disabled="garantiaDiasCheck?false:true">
                                    </div>
                                    <div class="col-md-4">
                                        <b-form-checkbox  name="check-button" 
                                            v-model="garantiaDiasCheck" 
                                            @input="update([garantiaDiasCheck, 'warranty_available'])" 
                                            switch>
                                            {{ garantiaDiasCheck ? 'Desactivar' : 'Activar' }}
                                        </b-form-checkbox>
                                    </div>
                                    
                                </div>
                            
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
                <h3>Descripción </h3>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                
                    <div class="col-md-8 mb-2">
                        <div class="row pl-3">
                            <b-form-textarea
                                id="textarea-rows"
                                placeholder="Descripcion"
                                rows="30"
                                v-model="descripcionTextArea"
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
                                        <h5><b>@Titulo</b></h5>
                                        <h6>Nombre del producto</h6>
                                        <h5><b>@peso</b></h5> 
                                        <h6>Peso del envío</h6>
                                        <h5><b>@descripcion</b></h5> 
                                        <h6>Descripción del producto</h6>
                                        <h5><b>@sku</b></h5> 
                                        <h6>Codigo SKU del producto</h6>
                                        <h5><b>@medidas</b></h5> 
                                        <h6>Medidas del envío</h6>
                                        <h5><b>@color</b></h5>
                                        <h6>Color del producto</h6> 
                                        <h5><b>@talla</b></h5>
                                        <h6>Talla del producto</h6> 
                                        <h5><b>@marca</b></h5> 
                                        <h6>Marca del producto</h6>
                                        <h5><b>@modelo</b></h5> 
                                        <h6>Modelo del producto</h6>
                                        <h5><b>@fabricante</b></h5> 
                                        <h6>Fabricante del producto</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-md-8">
                        <button class="btn btn-primary"
                            @click.prevent="update([descripcionTextArea, 'post_description'])"
                        >Guardar</button>
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
                            
                                <div class="form-group row d-flex align-items-center">
                                    <div class="col-md-4">
                                        <b-form-checkbox  name="check-button" 
                                            v-model="marcasProhibidasCheck" 
                                            @input="update([marcasProhibidasCheck, 'forbiden_brands_scanner'])" 
                                            switch>
                                            {{ marcasProhibidasCheck ? 'Desactivar' : 'Activar' }}
                                        </b-form-checkbox>
                                    </div>
                                    
                                </div>
                            
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
                                <input type="url" class="form-control mb-3" id="imageUrl1" placeholder="Url" 
                                    v-model="postImages[0]">
                                <input type="url" class="form-control mb-3" id="imageUrl1" placeholder="Url"
                                    v-model="postImages[1]">
                            </div>
                            <div class="col-md-8">
                                <button class="btn btn-primary"
                                    @click.prevent="update([JSON.stringify(postImages), 'post_images'])"
                                >Guardar</button>
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
                <a href="" @click.prevent="makeToast('primary')">TOAST</a>
            </div>
            

            
        </div>
    </section>
</div>
</template>

<script>
export default {
    data() {
        return {
            data: null,
            amazonTaxCheck: true,
            envioTipos: [
                {value: 'me2', text: 'Mercado Envíos'},
                {value: 'custom', text: 'Acordar con el vendedor'},
            ],
            envioTipoSelected: null,
            envioDescripcion: null,
            envioValor: null,
            comisionValor: null,
            publicacionTipo: [
                {value: "gold_pro", text: 'Premium'},
                {value:'gold_special', text: 'Clásica'},
            ],
            publicacionTipoSelected: null,
            stockDisponibleCheck: null,
            stockDias: null,
            garantiaDias: null,
            garantiaDiasCheck: null,
            marcasProhibidasCheck: null,
            descripcionTextArea: null,
            postImages: ["",""]
        }
    },
    methods: {
        //Update data in DB: Model = array[ Value, DB_Field ]
        update(model){
            const modelValue = model[0]
            const modelName = model[1].toString()
            const data = {[modelName]:modelValue}
            //IF updated value == mounted value, discard changes
            if (modelValue != this.data[modelName]) {
                axios.put('profile/update', data)
                .then((response) => {
                    this.makeToast('success')
                    console.log('si')
                })
                .catch(function(error){})
            }
        },

        getData(data){
            console.log(data)
        },
        makeToast(variant = null) {
            this.$bvToast.toast('Guardado con éxito', {
                title: `Variant ${variant || 'default'}`,
                variant: variant,
                solid: true
            })
        }
    

        // updateAmazonTax(){
        //     this.amazonTaxCheck ? this.amazonTaxCheck = false : this.amazonTaxCheck= true            
        //     axios.put('profile/update',
        //     {'taxes_amazon':this.amazonTaxCheck})
        //     .then((response) => {})
        //     .catch(function(error){});
        // }
    },
    async created() {
        const datos = await axios.get('profile')
        this.data = datos.data
        this.amazonTaxCheck = this.data.taxes_amazon == 1
        this.envioTipoSelected = this.data.shipping_type
        this.envioDescripcion = this.data.shipping_description
        this.envioValor = this.data.shipping_cost
        this.comisionValor = this.data.mercadolibre_fee
        this.publicacionTipoSelected = this.data.post_type
        this.stockDisponibleCheck = this.data.stock_available == 1
        this.stockDias = this.data.stock_days
        this.garantiaDias = this.data.warranty_days
        this.garantiaDiasCheck = this.data.warranty_available == 1
        this.marcasProhibidasCheck = this.data.forbiden_brands_scanner == 1
        this.descripcionTextArea = this.data.post_description
        this.postImages = JSON.parse(this.data.post_images)
    },
}
</script>

<style>

</style>