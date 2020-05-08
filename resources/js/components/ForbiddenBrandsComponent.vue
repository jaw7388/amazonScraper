<template>
    <hot-table  licenseKey="non-commercial-and-evaluation"
        :settings="settings"
        ref="Brands"
    ></hot-table>
</template>

<script>
    import { HotTable } from '@handsontable/vue';
    import Handsontable from 'handsontable';

    export default {
        data () {
            return {
            settings:{
                data: null,
                colHeaders: ['ID', 'Nombre'],
                rowHeaders: false,
                colWidths: 70,
                stretchH: 'all',
                width: '100%',
                height: 160,
                rowHeights: 23,
                columns: [
                    {
                    readOnly: true
                    },
                    {   
                    },
                  
                ],
                
                columnSorting: {
                    // initialConfig: {
                    //     column: 0,
                    //     sortOrder: 'desc',
                    // },
                    headerAction: false,
                    indicator: false,
                },
                contextMenu: {
                    items: {
                        
                        'remove_row':{
                            name: 'Borrar fila',
                            disabled: function() {
                            // if first row, disable this option
                            return this.getSelectedRangeLast().to.row === this.countRows()-1
                            }
                        },
                        'separator': Handsontable.plugins.ContextMenu.SEPARATOR,
                    }
                },
                

                // beforeChange: function (changes, source) {
                //     let lastRow = this.countRows()-1
                //     let row = parseInt(changes[0][0])
                //     let col = parseInt(changes[0][1])
                //     let newVal = parseInt(changes[0][3])
                //     let cell = this.getDataAtCell(row,1)
                //     let prevCell = parseInt(this.getDataAtCell(row, 0))

                //     if (col === 1) {
                //         if(!Number.isInteger(newVal) || newVal <= this.getDataAtCell(row, 0)){
                //             changes[0][3] = prevCell+1
                //             this.setDataAtCell(row, 1, prevCell+1, 'edit' )
                //             return
                //         }
                //     }
                // },
                afterChange: this.changeCells,
            }
            }
        },

        methods: {
            changeCells(changes, source) {
                if(source != 'loadData'){
                    let data = this.settings.data
                    let lastRow = parseInt(data.length)
                    data[lastRow-1][0] = lastRow
                    data.push(['', ''])
                    console.log(data)
                    this.settings.data = data
                    this.$refs.Brands.hotInstance.render()
                    
                }
            },
            
            // update(data){
            //     let table = JSON.stringify(data)
            //     axios.put('profile/update',
            //     {
            //     'taxes_table':table
            //     })
            //     .then((response) => {
            //     })
            //     .catch(function(error){
            //     });
            // }
        },
        components: {
            HotTable
        },
        mounted() {
            this.settings.data = [['']]
        },
    }
</script>

<style src="../../../node_modules/handsontable/dist/handsontable.full.css">
</style>