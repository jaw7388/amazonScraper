
// $.ajaxSetup({
//     headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     }
// })

// $(document).ready(function() {
//     $("#search").click(function(e) {
//         $("#search").attr("disabled", true);
//         e.preventDefault();    
    
//         $.ajax( {
//             // headers: {
//             //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             // },
//             url:'search/one',
//             method:'POST',
//             data: {
//                 sku: $("#sku").val()
//             },
            
//             success: function( response ) { 
//                 $("#search").attr("disabled", false);

//                 if( response ) { 
//                     array = JSON.stringify(response.sku,undefined, 2);
//                     $('#array').html('<pre>' + array);
//                     console.log(response.sku);
//                 }   
//             },  
//             fail: function() {
//                 $("#search").attr("disabled", false);

//                 alert('NO');
//             }   
//         }); 
//     })
// })