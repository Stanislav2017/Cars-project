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
});