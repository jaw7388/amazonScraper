
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
})

$(document).ready(function() {
    $("#search").click(function() {
        
    $.ajax( {
        // headers: {
        //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        // },
        url:'test',
        method:'POST',
        data: {
            sku: $("#sku").val()
        },
        
        success: function( bolUpdated ) { 
            if( bolUpdated ) { 
                console.log(bolUpdated);
            }   
        },  
        fail: function() {
            alert('NO');
        }   
    }); 
    })
})