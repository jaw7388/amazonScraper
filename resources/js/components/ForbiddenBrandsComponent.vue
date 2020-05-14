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
                                    // if last row, disable this option
                                    return this.getSelectedRangeLast().to.row === this.countRows()-1
                                }
                            },
                            'separator': Handsontable.plugins.ContextMenu.SEPARATOR,
                        }
                    },
                    afterChange: this.changeCells,
                    afterRemoveRow: this.removeRows
                }
            }
        },

        methods: {
            //changes[row, prop, oldVal, newVal]
            changeCells(changes, source) 
            {
                if(source != 'loadData')
                {
                    let oldVal = changes[0][2]
                    let newVal = changes[0][3]
                    let data = this.settings.data
                    let lastRow = parseInt(data.length)
                    if(oldVal != newVal)
                    {
                        this.update(data)
                        if (lastRow-1 == changes[0][0]) 
                        {
                            data[lastRow-1][0] = lastRow
                            data.push(['', ''])
                            this.update(data)
                        }
                    }
                }
            },

            removeRows(index,amount,physicalRows,source)
            {
                let data = this.settings.data
                let lastRow = parseInt(data.length)
                data.splice(index, amount-1)
                for (let i = 0; i < data.length-1; i++) 
                {
                    data[i][0] = i+1                    
                }
                this.update(data)
            },
            
            update(data)
            {
                let table = JSON.stringify(data)
                axios.put('profile/update',
                {
                'forbiden_brands_list':table
                })
                .then((response) => {
                    this.settings.data = data
                    this.$refs.Brands.hotInstance.render()
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
            //console.log (datos.data.forbiden_brands_list)
            this.settings.data = JSON.parse(datos.data.forbiden_brands_list)
            //setTimeout( this.changeCells, 0.005);
        },
    }
</script>

<style src="../../../node_modules/handsontable/dist/handsontable.full.css">
</style>