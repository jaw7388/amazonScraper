
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
})

$(document).ready(function() {
    $("#search").click(function() {
    e.preventDefault();    
    $.ajax( {
        // headers: {
        //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        // },
        url:'test',
        method:'POST',
        data: {
            sku: $("#sku").val()
        },
        
        success: function( response ) { 
            if( response ) { 
                array = JSON.stringify(response.sku,undefined, 2);
                $('#array').html('<pre>' + array);
                console.log(response.sku);
            }   
        },  
        fail: function() {
            alert('NO');
        }   
    }); 
    })
})