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
                
                <div class="mt-3">Selected: <strong>{{ selected }}</strong></div>
                
                <div class="container">
                    <div id="categories" class="row d-flex flex-nowrap" style="overflow-x: auto">
                        
                        <div class="col-3">
                            <b-form-select 
                                v-model="selected[0]" 
                                :options="categories[0]" 
                                :select-size="11" 
                                @change="onchange(selected[0]); showForm = 1"
                            ></b-form-select>
                        </div>
                        <!-- 1 -->
                        <div class="col-3"  v-if="showForm >= 1 && endCategory[selected[0]] == true">
                            <b-form-select
                                v-model="selected[1]" 
                                :options="categories[selected[0]]" 
                                :select-size="11" 
                                @input="onchange(selected[1]); showForm = 2"
                            ></b-form-select>
                        </div>
                        <!-- 2 -->
                        <div class="col-3"  v-if="showForm >= 2 && endCategory[selected[1]] == true">
                            <b-form-select 
                                v-model="selected[2]" 
                                :options="categories[selected[1]]" 
                                :select-size="11" 
                                @input="onchange(selected[2]); showForm = 3"
                            ></b-form-select>
                        </div>
                        <!-- 3 -->
                        <div class="col-3"  v-if="showForm >= 3 && endCategory[selected[2]] == true">
                            <b-form-select 
                                v-model="selected[3]" 
                                :options="categories[selected[2]]"
                                :select-size="11" 
                                @input="onchange(selected[3]); showForm = 4"
                            ></b-form-select>
                        </div>
                        <!-- 4 -->
                        <div class="col-3"  v-if="showForm >= 4 && endCategory[selected[3]] == true">
                            <b-form-select 
                                v-model="selected[4]" 
                                :options="categories[selected[3]]" 
                                :select-size="11" 
                                @input="onchange(selected[4]); showForm = 5"
                            ></b-form-select>
                        </div>
                        <!-- 5 -->
                        <div class="col-3"  v-if="showForm >= 5 && endCategory[selected[4]] == true">
                            <b-form-select 
                                v-model="selected[5]" 
                                :options="categories[selected[4]]" 
                                :select-size="11" 
                                @input="onchange(selected[5]); showForm = 6"
                            ></b-form-select>
                        </div>
                        <!-- 6 -->
                        <div class="col-3"  v-if="showForm >= 6 && endCategory[selected[5]] == true">
                            <b-form-select 
                                v-model="selected[6]" 
                                :options="categories[selected[5]]" 
                                :select-size="11" 
                                @input="onchange(selected[6]); showForm = 7"
                            ></b-form-select>
                        </div>
                        <!-- 7 -->
                        <div class="col-3"  v-if="showForm >= 7 && endCategory[selected[6]] == true">
                            <b-form-select 
                                v-model="selected[7]" 
                                :options="categories[selected[6]]" 
                                :select-size="11" 
                                @input="onchange(selected[7]); showForm = 8"
                            ></b-form-select>
                        </div>
                        
                        <div class="col-3 w-100     bg-success"  v-if="endCategory[0] == true">
                            HELOOOO
                        </div>

                    </div>
                </div>

                {{provChildren}}
                <button class="btn btn-info btn-flat" @click.prevent="scrollToEnd"
                    type="button" name="search" id="search">  <i class="fas fa-search"></i> Buscar
                </button>
                            
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
                provChildren: null,
                provArray: [],
                endCategory: [],
                showForm: 0,
                categories: [],
                sku :'',
                array: [],
                selected: [],
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
            },
            mlCategories(){
                console.log(this.categories)
            },
            printId(index){
                console.log(index)
            },
            scrollToEnd() {    	
                let container = document.getElementById("categories")
                setTimeout(()=>container.scrollLeft = container.scrollWidth,50)
                console.log('scrolled')
            },
            async onchange(index){
                this.provArray=[]
                try {
                    let datos = await axios.get('mlcategory/' + index)
                    this.provChildren = await datos.data.children_categories     
                    if (this.provChildren.length == 0) {
                        this.endCategory[index] = false
                        this.endCategory[0] = true
                        this.scrollToEnd()
                    }else{
                    this.provChildren.forEach(element => {
                        this.provArray.push({value: element.id, text: element.name})
                    })
                    this.endCategory[index] = true
                    this.endCategory[0] = false
                    this.categories[index] = this.provArray
                    this.scrollToEnd()
                    }
                    //console.log(this.provChildren.length)

               } catch (error) {
                   //console.log(error)
               }
                

            //    this.provArray = []
            //     axios.get('mlcategory/' + index)
            //     .then(res =>{
            //         //console.log(res.data.children_categories)
            //         res.data.children_categories.forEach(element => {
            //             this.provArray.push({value: element.id, text: element.name})
            //         })
            //         this.categories[index] = this.provArray
            //     })
            //     console.log(this.categories[index])
            }
        },
        mounted () {
            axios.get('mlCategories')
                .then(res =>{
                    //this.provArray = res.data
                    res.data.forEach(element => {
                    this.provArray.push({value: element.id, text: element.name})
                });
            })
            this.categories.push(this.provArray)
            this.endCategory[0] = false
            console.log(this.endCategory)
            
        }
    }


    
</script>