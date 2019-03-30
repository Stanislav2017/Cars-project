$(function () {
    $(document).on("change", "select[name='Car[brand_id]']", function () {
        var id = $(this).val();
        var token = $('meta[name=csrf-token]').attr("content");
        $.ajax({
            'url': '/car/types',
            'method': 'post',
            'data': {
                '_csrf': token,
                'id': id
            },
            success: function(data){
                $("#car-type_id").html(data);
            },
            error: function(data) {
                console.log("Error" + JSON.parse(data));
            }
        });
    });

    $(document).on("click", "#small-image", function () {
        var image = $(this);
        var name = image.data('name').replace('_small', '_large');
        var src = image.attr('src');
        $("#large-image").attr("src", src.substr(0, src.lastIndexOf('/')) + '/' +  name);
    });
});