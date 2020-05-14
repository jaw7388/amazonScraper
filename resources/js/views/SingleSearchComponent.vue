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

                    </div>
                </div>
            </div>
              
        </section>

        <section v-if="productHidden">
            <div class="card" >
                <div class="container">
                    
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h4 class="text-primary">Titulo del producto</h4> 
                            <div class="input-group mb-3">
                            <input type="text" class="form-control" v-model="array.title">
                            <div class="input-group-append">
                                <button class="btn btn-success" type="button">Predecir categoría</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row" v-if="categorySelected">
                        <div class="col-md-12">
                            <h4 class="text-primary">Categoría</h4>
                            <div class="d-flex align-items-baseline">
                            <p class="mr-3">
                            <span 
                            v-for="(item, index) in categorySelected.path" 
                            :key="index">
                            {{item.name}} >
                            </span>
                            <strong> {{categorySelected.name}} ( {{categorySelected.id}} )</strong>
                            </p> 
                            <b-button  variant="primary" v-if="categoriesHidden" v-on:click="toggleCategories(false)">Cambiar</b-button>    
                            <b-button  v-if="!categoriesHidden" v-on:click="toggleCategories(true)">Cancelar</b-button> 
                            </div>
                        </div>
                    </div>

                    <div class="row pb-3" v-if="!categoriesHidden">
                        <div class="col-12">
                            <categories-component />
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <h4  class="text-primary">Descripción</h4>
                            <b-form-textarea
                                id="textarea-rows"
                                rows="11"
                                v-model="userData.post_description"
                            ></b-form-textarea>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-3">
                            <h5 class="text-primary">Tipo de publicación</h5>
                            <b-form-select 
                                v-model="publicacionTipoSelected"
                                :options="publicacionTipo">
                            </b-form-select>
                        </div>
                        <div class="col-md-3">
                            <h5 class="text-primary">Peso del envío</h5>
                            <input type="text" v-model="array.weight">
                        </div>
                        <div class="col-md-3">
                            <h5 class="text-primary">Precio final</h5>
                            <input type="text">
                        </div>
                        <div class="col-md-3">
                            <ul class="list-unstyled">
                                <li><strong>SKU: </strong><a target="_blank" :href="`https://www.amazon.com/dp/${sku}`">{{sku}}</a></li>
                                <li><strong>PRIME: </strong></li>
                                <li><strong>PRECIO: </strong>$ {{array.price}} USD</li>
                                <li><strong>PESO: </strong>{{array.weight}} lb</li>
                            </ul>
                        </div>
                    </div>
                    <hr>

                    <div class="row" v-if="categorySelected">
                        <categoryatributes-component />
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-primary">Medidas(cm)</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text" v-model="array.dimensions[0]">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" v-model="array.dimensions[1]">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" v-model="array.dimensions[2]">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <button @click.prevent="logAttributes"></button>
        </section>
    </div>
</template>

<script>
    import { mapState, mapActions, mapMutations } from 'vuex'
    export default {
        data() {
            return {
                sku :'',
                array: [],
                categoryAtributes: null,
                userData: null,
                publicacionTipo: [
                    {value: "gold_pro", text: 'Premium'},
                    {value:'gold_special', text: 'Clásica'},
                ],
                publicacionTipoSelected: null,
            }
        },
        methods: {
            logAttributes(){
               console.log(this.mlAttributes)
            },
            ...mapActions(['categorySelect', 'toggleCategories', 'toggleProduct', 'getAttributes', 'setSearchArray']),
           async search(){
               let sku = {sku: this.sku}
               axios.post('search/one', sku)
               .then(res=>{
                   this.array = res.data.sku
                   this.categorySelect(this.array.categoryID)
                   this.toggleProduct(true)
                   this.getAttributes({category:this.array.categoryID, array:this.array })
                   this.setSearchArray(this.array)
               }).catch(error => {
                   console.log(error.response.data.error)
               })
           },
            
            async getAtributes($id){
                try {
                const datos = await axios.get('categoryatributes/' + $id)      
                const atributes = datos.data.groups[0].components
                this.categoryAtributes = atributes
                } catch (error) {
                    console.log(error)
                } 
            },
            mandatoryAttribute(index){
                if (this.categoryAtributes[index].attributes[0].tags[0]) {
                    let tag = this.categoryAtributes[index].attributes[0].tags[0]
                    if (tag.includes("required")) {
                        return true
                    }
                } 
            }
            
        },
        computed: {
            ...mapState(['categorySelected', 'categoriesHidden','productHidden', 'mlAttributes']),
        },
        async created() {
            const datos = await axios.get('profile')
            this.userData = datos.data
            this.publicacionTipoSelected = datos.data.post_type
        },
    }
    


    
        

</script>