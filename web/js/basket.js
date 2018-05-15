$(document).on("click", ".buy", function(e) {
    $.ajax({
        url: $(this).attr('data-action'),
        type: 'GET',
        dataType: 'json',
        success:function(data){
            $('#count-product').text(data.count);
            console.log(data);
        }
    });
});

$(document).on("click", ".remove", function(e) {
    parent = $(this).parent('div');
    $.ajax({
        url: $(this).attr('data-action'),
        type: 'DELETE',
        dataType: 'json',
        success:function(data){
            $('#count-product').text(data.count);
            parent.hide();
            $('#sum').val(data.sum);
        }
    });
});