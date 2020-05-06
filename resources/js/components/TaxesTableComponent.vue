<template>
    <hot-table  licenseKey="non-commercial-and-evaluation"
        :settings="settings"
        ref="myTable"
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
                colHeaders: ['Desde $', 'Hasta $', 'Porcentaje'],
                colWidths: 70,
                stretchH: 'all',
                width: '100%',
                height: 200,
                rowHeights: 23,
                columns: [
                    {
                    readOnly: true
                    },
                    {   //Auto populate cells with consecutives intervales
                        //renderer: function(instance, td, row, col, prop, value, cellProperties) {
                            // Handsontable.renderers.TextRenderer.apply(this, arguments);
                            // let prevCell = parseInt(instance.getDataAtCell(row, 0))
                            // let currentCell = parseInt(instance.getDataAtCell(row, 1))
                            // let lastRow = instance.countRows()-1
                            
                            // if (col === 1) {
                            //     if (prevCell > currentCell){
                            //         setTimeout(function(){ instance.setDataAtCell(row,1, prevCell+1) }, 0.0005);
                            //     }
                            //     if(row < lastRow){
                            //         if (instance.getDataAtCell(parseInt(row)+1, 0) < currentCell) {
                            //             setTimeout(function(){ instance.setDataAtCell(parseInt(row)+1,0, instance.getDataAtCell(row, 1)) }, 0.005);
                            //         }
                            //     }
                            // }
                        //},
                    },
                    {
                    },
                ],
                
                columnSorting: {
                    initialConfig: {
                        column: 0,
                        sortOrder: 'asc',
                    },
                    headerAction: false,
                    indicator: false,
                },
                rowHeaders: true,
                contextMenu: {
                    items: {
                        'row_above': {
                            name: 'Insertar fila arriba',
                            disabled: function () { // `disabled` can be a boolean or a function
                            // Disable option when first row was clicked
                            return this.getSelectedLast()[0] === 0; // `this` === hot3
                            }
                        },
                        'row_below': {name: 'Insertar fila abajo'},
                        'remove_row':{name: 'Borrar fila'},
                        'separator': Handsontable.plugins.ContextMenu.SEPARATOR,
                    }
                },
                

                beforeChange: function (changes, source) {
                    let lastRow = this.countRows()-1
                    let row = parseInt(changes[0][0])
                    let col = parseInt(changes[0][1])
                    let newVal = parseInt(changes[0][3])
                    let cell = this.getDataAtCell(row,1)
                    let prevCell = parseInt(this.getDataAtCell(row, 0))

                    if (col === 1) {
                        if(!Number.isInteger(newVal) || newVal <= this.getDataAtCell(row, 0)){
                            changes[0][3] = prevCell+1
                            this.setDataAtCell(row, 1, prevCell+1, 'edit' )
                            return
                        }
                    }
                },
                afterChange: this.changeCells,
                afterCreateRow: this.createRow,
                afterRemoveRow: this.changeCells
            }
            }
        },

        methods: {
            changeCells(changes, source) {
                if(source != 'loadData'){
                    let data = this.settings.data
                    let lastRow = parseInt(data.length)
                    
                    for (var i = 0; i < lastRow; i++) {
                        if( parseInt(data[i][0]) > parseInt(data[i][1])){
                            data[i][1] = parseInt(data[i][0])+1
                        }
                        if( i < lastRow-1){
                            data[i+1][0] =  parseInt(data[i][1])
                        }
                    }
                    this.update(data)
                    this.settings.data = this.parseIntArray(data)
                    this.$refs.myTable.hotInstance.render()
                    
                }
            },
            createRow(index, amount, source){
                let data = this.settings.data
                let lastRow = parseInt(data.length)
                if(source == "ContextMenu.rowAbove"){
                    if (data[index+1][0] > data[index-1][1]){
                        data[index][0] = data[index-1][1]
                        data[index][1] = parseInt(data[index-1][1])+1
                        data[index][2] = 20
                    }
                    if (data[index+1][0] == data[index-1][1]){
                        data[index][0] = data[lastRow-1][1]
                        data[index][1] = parseInt(data[lastRow-1][1])+1
                        data[index][2] = 20
                        data.splice(lastRow, 0, data.splice(index, 1)[0])
                    }
                }
                if (source == "ContextMenu.rowBelow"){
                    if (index == lastRow-1) {
                        data[index][0] = data[index-1][1]
                        data[index][1] = parseInt(data[index-1][1])+1
                        data[index][2] = 20
                        this.update(data)
                        this.settings.data = this.parseIntArray(data)
                        return
                    }
                    if (data[index+1][0] == data[index-1][1]){
                        data[index][0] = data[lastRow-1][1]
                        data[index][1] = parseInt(data[lastRow-1][1])+1
                        data[index][2] = 20
                        data.splice(lastRow, 0, data.splice(index, 1)[0])
                    }
                    if (data[index+1][0] > data[index-1][1]) {
                        data[index][0] = data[index-1][1]
                        data[index][1] = parseInt(data[index-1][1])+1
                        data[index][2] = 20
                    }
                }
                this.update(data)
                this.settings.data = this.parseIntArray(data)
            },
            parseIntArray(array){ // Transform Array to Integer
                for (let i = 0; i < array.length; i++) {
                    for (let j = 0; j < array[i].length; j++) {
                        array[i][j] = parseInt(array[i][j])
                    }                
                }
                return array
            },
            update(data){
                let table = JSON.stringify(data)
                axios.put('profile/update',
                {
                'taxes_table':table
                })
                .then((response) => {
                })
                .catch(function(error){
                });
            }
        },
        components: {
            HotTable
        },
        async created() {
            const datos = await axios.get('profile')
            this.settings.data = JSON.parse(datos.data.taxes_table)
            setTimeout( this.changeCells, 0.005);
        },
    }
</script>

<style src="../../../node_modules/handsontable/dist/handsontable.full.css">

.htCore{
    height: 200px; 
    overflow: hidden; 
    width: 100%;
}

</style>