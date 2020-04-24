<template>
    <div class="col-md-12">
        <h5 class="text-primary">Atributos</h5>
        <div class="row">
            <div class="col-md-3 mt-3" v-for="(item, index) in categoryAtributes" :key="index">
                <p class="mb-0">
                    {{item.label}}
                    <b-badge 
                    variant="danger" 
                    v-show="mandatoryAttribute(index)"
                    >Requerido
                    </b-badge>
                </p>
                <input 
                v-model="mlAttributes[index].value_name" 
                type="text">
            </div>
        </div>
    </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'
export default {
    data() {
        return {
            
        }
    },methods: {
        ...mapActions(['getAttributes']),
        mandatoryAttribute(index){
            if (this.categoryAtributes[index].attributes[0].tags[0]) {
                let tag = this.categoryAtributes[index].attributes[0].tags
                    if (tag.includes("required") || tag.includes("catalog_required")) {
                        return true
                    }
            } 
            //return tag.includes("required")                
        }
    },
    mounted() {
        //this.getAttributes(this.categorySelected.id, this.arraySearch)
    },
    
    computed: {
        ...mapState(['categorySelected', 'categoryAtributes', 'mlAttributes']),
    },
}
</script>
