
// jQuery, bind an event handler or use some other way to trigger ajax call.
$('form').submit(function( event ) {
    event.preventDefault();
    $.ajax({
        url: 'http://myserver.dev/myAjaxCallURI',
        type: 'post',
        data: $('form').serialize(), // Remember that you need to have your csrf token included
        dataType: 'json',
        success: function( _response ){
            // Handle your response..
        },
        error: function( _response ){
            // Handle error
        }
    });
});