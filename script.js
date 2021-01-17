jQuery(function($){
    jQuery('input[type=checkbox]').change(function(){
        var filter = $('#filter');
        $.ajax({
            url:filter.attr('action'),
            data:filter.serialize(), // form data
            type:filter.attr('method'), // POST
            success:function(data){
                $('#response').html(data); // insert data
            }
        });
        return false;
    });
});