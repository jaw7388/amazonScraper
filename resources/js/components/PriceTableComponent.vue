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
            afterRenderer: function (td, row, col, prop, value, cellProperties) {
                       // console.log('cambio')
                    },
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
                this.settings.data = data
                this.$refs.myTable.hotInstance.render()
                console.log('cambio')
            }
        },
        createRow(index, amount, source){
            //let data = this.settings.data
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
                    console.log('cambio')
                    this.settings.data = data
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
            this.settings.data = data
            console.log('cambio')
        }
    },
    components: {
      HotTable
    },
    computed: {
        
    },
    mounted() {
        this.settings.data= [
                [ 0, 10, 100],
                [ 11, 20, 90],
                [ 21, 30, 80],
                [ 21, 20, 80],
            ]
    },
  }
</script>
<style src="../../../node_modules/handsontable/dist/handsontable.full.css">



</style>

