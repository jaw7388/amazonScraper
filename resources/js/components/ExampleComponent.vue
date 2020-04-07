<template>
<div class="container">

<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Buscar y Publicar</h1>
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
                            <input class="form-control form-control-navbar" v-model="sku"
                            type="search" placeholder="Search" aria-label="Search" name="sku" id="sku">
                            <div class="input-group-append">
                              <button class="btn btn-info btn-flat" @click.prevent="search(sku)"
                              type="button" name="search" id="search">
                                <i class="fas fa-search"></i> Buscar
                              </button>
                            </div>
                          </div>
                          <p class="text-center text-primary">Introduce un codigo SKU-ASIN valido ok</p>
                    </div>
                </div>
           

                <div class="row">
                    <div class="col-12">
                        <div id="array">
                            <pre>
                                {{array}}
                            </pre>
                        </div>
                    </div>
                </div>
                <div>
                    <b-form-select v-model="selected" :options="options" :select-size="4"></b-form-select>
                    <div class="mt-3">Selected: <strong>{{ selected }}</strong></div>
                </div>
                    

               
                <!-- <pre>
                    @isset($array)
                        {{ print_r($array) }}
                    @endisset
                
                </pre> -->
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
                info: null,
                sku :'',
                array: [],
                selected: ['b'],
                options: [
                    { value: null, text: 'Please select some item' },
                    { value: 'a', text: 'This is option a' },
                    { value: 'b', text: 'Default Selected Option b' },
                    { value: 'c', text: 'This is option c' },
                    { value: 'd', text: 'This one is disabled', disabled: true },
                    { value: 'e', text: 'This is option e' },
                    { value: 'e', text: 'This is option f' }
                ]  
            }
        },
        methods: {
            search(){
                let sku = {sku: this.sku}
                axios.post('search/one', sku)
                .then(res=>{
                    this.array = res.data.sku
                }).catch(error => {
                    console.log(error.response.data.error)
                })
            }
        },

        mounted() {
            axios
            .get('https://api.coindesk.com/v1/bpi/currentprice.json')
            .then(response => (this.info = response.data.bpi))
            console.log(this.info)
         }
            
        
    }
</script>