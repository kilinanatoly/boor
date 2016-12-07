$(document).ready(function () {
    if ($("div").is(".alert-success")) {
        setTimeout(function () {
            $('.alert-success').fadeOut()
        }, 3000);
    }
    $(".pjax2").on("pjax:end", function () {
        setTimeout(function () {
            $('.alert-success').fadeOut()
        }, 3000);
    });

    $(document).on('click','.add_char_data',function(){
        html = '<div class="form-group"> <p> <label> <input type="text" class="form-control" name="characteristics_data[]" placeholder="Опция"></label><label><input type="text" class="form-control" name="characteristics_data_sort[]" placeholder="Сортировка"></label> </p> </div>';
        $('.characteristics-form .inputs').append(html);
        return false;
    });
    $(document).on('change','.characteristics-form .type',function(){
        if ($(this).val()!=0){
            $('.navtab1 .options').show();
        }else{
            $('.navtab1 .options').hide();
        }
    });
    $(document).on('click','#attributesList option',function(e){
        e.preventDefault();
        th = $(this);
        th.remove();
        $('#attributes').append(th);
        return false;
    });

    $(document).on('click','#attributes option',function(e){
        e.preventDefault();
        th = $(this);
        th.remove();
        $('#attributesList').append(th);
        return false;
    });
    $(document).on('change','.products-form .product_types',function(){
        th = $(this);
        $.ajax({
            type: "POST",
            url: "/ajax/getcharacteristics",
            data: ({product_type_id: th.val()}),
            success: function (html) {
                console.log(html);
                $('.products-form #characteristics').html(html);

            }
        });
    });
    $(document).on('change','.products-form .product_types',function(){
        th = $(this);
        $.ajax({
            type: "POST",
            url: "/ajax/getcats",
            data: ({product_type_id: th.val()}),
            success: function (html) {
                $('.products-form .cats').html(html);

            }
        });

    });
    $(document).on('click','.cats_down',function(){
        th = $(this);
        th.addClass('cats_up').removeClass('cats_down');
        th.parent().find('>ul').removeClass('closed');
        th.find('>span.glyphicon').addClass('glyphicon-chevron-up').removeClass('glyphicon-chevron-down');
        return false;
    });
    $(document).on('click','.cats_up',function(){
        th = $(this);
        th.addClass('cats_down').removeClass('cats_up');
        th.parent().find('>ul').addClass('closed');
        th.find('>span.glyphicon').addClass('glyphicon-chevron-down').removeClass('glyphicon-chevron-up');
        return false;
    });

    $('.cats>ul').removeClass('closed');
    $('.product-types-update button[type="submit"]').click(function(){
        $('.product-types-update #attributes').children('option').prop('selected', true);
    });

    $(document).on('submit','.product_sort_form',function(){
            th = $(this);
            data = th.serialize();
            $.ajax({
                type: "POST",
                url: "/ajax/productsort",
                data: (data),
                success: function (response) {
                    if (response=='success'){
                        th.find('p').text('успех').addClass('green');
                    }
                }
            });
            return false;
        });

});