.<template>
    
    <section class="content-header">
            
            <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-12">
                    <h1>Configuracion</h1>
                </div>
                
                <div class="col-md-4 mb-2">
                    <pricetable-component />
                </div>

                <div class="col-md-4 mb-2">
                    <weighttable-component />
                </div>

                <div class="col-md-4 mb-2">
                    <taxestable-component />
                </div>
            </div>
            <div class="row mb-2"></div>
            </div>
            
    </section>

</template>

<script>
export default {
    data() {
        return {
            
        }
    },
    methods: {
    },
    async created() {
        const datos = await axios.get('profile')
    },

    

}
</script>

<style>

</style>