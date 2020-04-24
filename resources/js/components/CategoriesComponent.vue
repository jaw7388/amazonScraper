<template>
    <div>
        <div id="categories" class="row flex-row flex-sm-nowrap pt-3 mr-3" style="overflow-x: auto">
            
            <div class="col-md-3 col-sm-6 mt-3">
                <b-form-select 
                    v-model="selected[0]" 
                    :options="categories[0]" 
                    :select-size="11" 
                    @input="onchange(selected[0]); showForm = 1"
                ></b-form-select>
            </div>
            <!-- 1 -->
            <div class="col-md-3 col-sm-6 mt-3"  v-if="showForm >= 1 && endCategory[selected[0]] == true">
                <b-form-select
                    v-model="selected[1]" 
                    :options="categories[selected[0]]" 
                    :select-size="11" 
                    @input="onchange(selected[1]); showForm = 2"
                ></b-form-select>
            </div>
            <!-- 2 -->
            <div class="col-md-3 col-sm-6 mt-3"  v-if="showForm >= 2 && endCategory[selected[1]] == true">
                <b-form-select 
                    v-model="selected[2]" 
                    :options="categories[selected[1]]" 
                    :select-size="11" 
                    @input="onchange(selected[2]); showForm = 3"
                ></b-form-select>
            </div>
            <!-- 3 -->
            <div class="col-md-3 col-sm-6 mt-3"  v-if="showForm >= 3 && endCategory[selected[2]] == true">
                <b-form-select 
                    v-model="selected[3]" 
                    :options="categories[selected[2]]"
                    :select-size="11" 
                    @input="onchange(selected[3]); showForm = 4"
                ></b-form-select>
            </div>
            <!-- 4 -->
            <div class="col-md-3 col-sm-6 mt-3"  v-if="showForm >= 4 && endCategory[selected[3]] == true">
                <b-form-select 
                    v-model="selected[4]" 
                    :options="categories[selected[3]]" 
                    :select-size="11" 
                    @input="onchange(selected[4]); showForm = 5"
                ></b-form-select>
            </div>
            <!-- 5 -->
            <div class="col-md-3 col-sm-6 mt-3"  v-if="showForm >= 5 && endCategory[selected[4]] == true">
                <b-form-select 
                    v-model="selected[5]" 
                    :options="categories[selected[4]]" 
                    :select-size="11" 
                    @input="onchange(selected[5]); showForm = 6"
                ></b-form-select>
            </div>
            <!-- 6 -->
            <div class="col-md-3 col-sm-6 mt-3"  v-if="showForm >= 6 && endCategory[selected[5]] == true">
                <b-form-select 
                    v-model="selected[6]" 
                    :options="categories[selected[5]]" 
                    :select-size="11" 
                    @input="onchange(selected[6]); showForm = 7"
                ></b-form-select>
            </div>
            <!-- 7 -->
            <div class="col-md-3 col-sm-6 mt-3"  v-if="showForm >= 7 && endCategory[selected[6]] == true">
                <b-form-select 
                    v-model="selected[7]" 
                    :options="categories[selected[6]]" 
                    :select-size="11" 
                    @input="onchange(selected[7]); showForm = 8"
                ></b-form-select>
            </div>
            
            <div class="col-md-3 col-sm-6 border rounded text-center pt-5 mt-3 w-100" v-if="endCategory[0] == true">
                <span class="d-block display-4 text-success">
                    <i class="fas fa-check"></i>
                </span>
                <h1>{{provCategory}}</h1>
                <button 
                    type="button" class="btn btn-block btn-primary btn-lg" 
                    @click.prevent="changeCategory"
                    v-on:click="toggleCategories(true)"
                    >Seleccionar</button>
            </div>

            <div class="d-none">
            {{provChildren}}
            </div>
        </div>
    </div>
</template>

<script>

    import { mapActions, mapState } from 'vuex'
    export default {
        data() {
            return {
                provChildren: null, //Array provisional, guarda json de mlibre API
                provArray: [], // Array provisional, guarda options de categorias 
                endCategory: [], //Guarda true/false para mostrar div final de categoria 
                showForm: 0, // Guarda el orden en que se van mostranto los pickList de categorias
                categories: [], // Guarda categorias por pickList 
                selected: [],
                provCategory: null,
            }
        },
        methods: {
            ...mapActions(['categorySelect', 'toggleCategories', 'getAttributes']),
        
            scrollToEnd() {    	
                let container = document.getElementById("categories")
                setTimeout(()=>container.scrollLeft = container.scrollWidth,50)
                setTimeout(()=>container.scrollTop = container.scrollHeigth,50)
            },
            async getCategory(id){
                let datos = await axios.get('mlcategory/' + id)
                return datos.data
            },
            async onchange(index){
                this.provArray=[]
                this.provChildren=[]
                try {
                    let datos = await this.getCategory(index)
                    this.provChildren = await datos.children_categories 
                    if (this.provChildren.length == 0) {
                        this.endCategory[index] = false
                        this.endCategory[0] = true
                        this.provCategory = this.selected[this.selected.length - 1]
                        this.scrollToEnd()
                    }else{
                        this.provChildren.forEach(element => {
                            this.provArray.push({value: element.id, text: element.name})
                        })
                        this.endCategory[index] = true
                        this.endCategory[0] = false
                        this.categories[index] = this.provArray
                        this.provCategory = this.selected[this.selected.length - 1]
                        this.scrollToEnd()
                    }
               } catch (error) {
                   console.log(error)
               }
            },
            changeCategory(){
                this.categorySelect(this.selected[this.selected.length - 1])
                this.getAttributes({category:this.selected[this.selected.length - 1], array:this.searchArray})
            },
        },
        mounted () {
            try {
                axios.get('mlCategories')
                    .then(res =>{
                        //this.provArray = res.data
                        res.data.forEach(element => {
                        this.provArray.push({value: element.id, text: element.name})
                    });
                })
                this.categories.push(this.provArray)
                this.endCategory[0] = false
            } catch (error) {
                console.log(error)
            }
        },
        computed: {
            ...mapState(['categorySelected', 'categoriesHidden', 'searchArray'])
        },
    }


    
</script>