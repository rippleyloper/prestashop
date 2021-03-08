/**
* 2012 - 2020 HiPresta
*
* MODULE Popup Notification
*
* @author    HiPresta <support@hipresta.com>
* @copyright HiPresta 2020
* @license   Addons PrestaShop license limitation
* @link      http://www.hipresta.com
*
* NOTICE OF LICENSE
*
* Don't use this module on several shops. The license provided by PrestaShop Addons
* for all its modules is valid only once for a single shop.
*/

function update_helper_list(action){
    $.ajax({
        type: 'POST',
        dataType: "JSON",
        url: pnt_admin_controller_dir,
        data: {
            ajax : true,
            action : action,
            secure_key : pnt_secure_key,
            psv: psv,
        },
        success: function(response){
            $("#form-hipopupnotification").replaceWith(response.content);
        }
    });
};

function show_form(th, action, action_type, id){
    $.ajax({
            type: 'POST',
            dataType: "JSON",
            url: pnt_admin_controller_dir,
            data: {
                ajax : true,
                action : action,
                action_type : action_type,
                id : id,
                secure_key : pnt_secure_key,
                psv: psv,
            },
            beforeSend: function(){
                if (th.hasClass("edit")){
                    th.find('i').removeClass('icon-pencil').addClass('icon-refresh icon-spin');
                } else {
                    th.find('i').removeClass('process-icon-new').addClass('process-icon-refresh icon-spin');
                }
            },
            success: function(response){
                if (th.hasClass("edit")){
                    th.find('i').removeClass('icon-refresh icon-spin').addClass('icon-pencil');
                } else {
                    th.find('i').removeClass('process-icon-refresh icon-spin').addClass('process-icon-new');
                }
                $("#modal_form .content").html(response.content);
                $('#modal_form').modal('show');
                var page_content_type = $('[name=content_type]').val();
                $('.page_content').hide();
                $('.popup_type_content').hide();
                $('.page_content.type_'+page_content_type).show();

                if (page_content_type == 'newsletter' ||
                    page_content_type == 'login' ||
                    page_content_type == 'register' ||
                    page_content_type == 'login_and_register') {
                    $('.page_content_size').hide();
                } else {
                    $('.page_content_size').show();
                }
                $( "#start_date, #end_date").datepicker({dateFormat: 'yy-mm-dd'});
                $('[name=popup_type]').parent().find('.help-block').hide();
                if ($('[name=popup_type]').val() == 'product') {
                    $('.search_product').show();
                    $('[name=popup_type]').parent().find('.help-block').show();
                } else if ($('[name=popup_type]').val() == 'category') {
                    $('.category_tree').show();
                    $('[name=popup_type]').parent().find('.help-block').show();
                }
            }
        });
}

function save_form(form, action, helper_action){
    var formdata = new FormData($(form)[0])
    formdata.append("action", action);
    formdata.append("secure_key", pnt_secure_key);
    formdata.append("psv", psv);
    formdata.append("ajax", true);
    $.ajax({
        type: 'POST',
        dataType: "JSON",
        url: pnt_admin_controller_dir,
        data: formdata,
        contentType: false,
        processData: false,
        beforeSend: function(){
            form.find('i.process-icon-save').removeClass('process-icon-save').addClass('process-icon-refresh icon-spin');
        },
        success: function(response){
            form.find('i.process-icon-refresh').removeClass('process-icon-refresh icon-spin').addClass('process-icon-save');
            if (response.error != '') {
                showErrorMessage(response.error);
            } else {
                showSuccessMessage('Successful Save');
                $('#modal_form').modal('hide');
                update_helper_list(helper_action);
            }
        }
    });
    return false;
}

function delete_list_item(th, action, id){
    $.ajax({
            type: 'POST',
            dataType: "JSON",
            url: pnt_admin_controller_dir,
            data: {
                ajax : true,
                action : action,
                id : id,
                secure_key : pnt_secure_key,
                psv: psv,
            },
            success: function(response){
                showSuccessMessage('Successful delete');
                th.closest('tr').remove();
            }
        });
}

$(document).ready(function() {
    $('.fake_desc').closest('form').hide();
    $('.hinewslettervoucher .delete').attr('onclick','').unbind('click');

    $(document).on('click', '[name=submit_cancel]', function(){
        $('#modal_form').modal('hide');
        return false;
    });

    $(document).on('change', '[name=popup_type]', function(){
        $('.popup_type_content').hide();
        $(this).parent().find('.help-block').hide();
        if ($(this).val() == 'product') {
            $('.search_product').show();
            $(this).parent().find('.help-block').show();
        } else if ($(this).val() == 'category') {
            $('.category_tree').show();
            $(this).parent().find('.help-block').show();
        }
        return false;
    });
    $(document).on('change', '[name=content_type]', function(){
        var page_content_type = $(this).val();
        if (page_content_type == 'newsletter' || page_content_type == 'login' || page_content_type == 'register' || page_content_type == 'login_and_register') {
            $('.page_content_size').hide();
        } else {
            $('.page_content_size').show();
        }
        $('.page_content').hide();
        $('.page_content.type_'+page_content_type).show();
        return false;
    });
    $(document).on('click', '#desc-hipopupnotification-new', function(e){
        e.preventDefault();
        show_form($(this), 'show_form', 'add', '');
    });

    $(document).on('submit', '#modal_form form.popup_form', function(e){
        e.preventDefault();
        save_form($(this), 'save_list', 'update_helper_list');
    });

    $(document).on('click', '.hipopupnotification .edit', function(e){
        e.preventDefault();
        var id = $(this).attr("href").match(/id_hipopupnotification=([0-9]+)/)[1];
        show_form($(this), 'show_form', 'update', id);
    });
    $(document).on('click', '.hipopupnotification .delete', function(e){
        e.preventDefault();
        var id = $(this).attr("href").match(/id_hipopupnotification=([0-9]+)/)[1];
        delete_list_item($(this), 'delete_list_item', id)
    });

    /*Delete popup background image*/
    $(document).on('click', '.remove_popup_bg', function(e){
        e.preventDefault();
        var th = $(this);
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: pnt_admin_controller_dir,
            data:{
                ajax : true,
                action : "delete_list_item_bg",
                id : $(this).attr('data-id'),
                secure_key : pnt_secure_key,
            },
            beforeSend: function(){
                th.find('i').removeClass('icon-trash').addClass('icon-refresh icon-spin');
            },
            success: function(response){
                th.find('i').removeClass('icon-refresh icon-spin').addClass('icon-trash');
                th.closest('p').remove();
            }
        });
    });

    /*Status change*/
    $(document).on('click', '.popup-status', function(e){
        e.preventDefault();
        var th = $(this);
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: pnt_admin_controller_dir,
            data:{
                ajax : true,
                action : "update_status",
                id : $(this).attr('data-id'),
                status : $(this).attr('data-status'),
                secure_key : pnt_secure_key,
            },
            beforeSend: function(){
                if (th.hasClass('btn-success')){
                    th.find('i').removeClass('icon-check').addClass('icon-refresh icon-spin');
                } else {
                    th.find('i').removeClass('icon-remove').addClass('icon-refresh icon-spin');
                }
            },
            success: function(response){
                if (th.hasClass('btn-success')){
                    th.find('i').removeClass('icon-refresh icon-spin').addClass('icon-check');
                } else {
                    th.find('i').removeClass('icon-refresh icon-spin').addClass('icon-remove');
                }
                var form = th.closest('form').attr('id');
                $('#'+form).replaceWith(response.content);
            }
        });
    });
    /*Status end*/

    /*Popup Product add*/
    $(document).on('click', '#add-popup-product', function(){
        var id_product = $("#product_search").val();
        var product_ids = $("#inputBlockProducts").val();
        $.ajax({
            type: 'POST',
            dataType : "json",
            url: pnt_admin_controller_dir,
            data: {
                ajax : true,
                action : "add_popup_product",
                secure_key : pnt_secure_key,
                id_product: id_product,
                product_ids: product_ids,
                psv: psv
            },
            success: function(response){
                if(response.error){
                    showErrorMessage(response.error);
                } else {
                    
                    $('#popup_products').append("<div class='form-control-static'><button type='button' class='btn btn-default delete_popup_product' data-id-product='"+response.id_product+"'><i class='icon-remove text-danger'></i></button> "+response.id_product + ' - ' +response.product_name+"</div>");
                    $("#inputBlockProducts").val(response.ids);
                    $("#product_search").val("");
                    showSuccessMessage('Successfully add ');
                }
            }
        });
    });

    // Popup product delete
    $(document).on('click', '.delete_popup_product', function(){
        var  th = $(this);
        var id_product = $(this).attr('data-id-product');
        var product_ids = $("#inputBlockProducts").val();
        $.ajax({
            type: 'POST',
            dataType : "json",
            url: pnt_admin_controller_dir,
            data: {
                ajax : true,
                action : "delete_popup_product",
                secure_key : pnt_secure_key,
                id_product: id_product,
                product_ids: product_ids,
                psv: psv
            },
            success: function(response){
                th.parent().remove();
                $("#inputBlockProducts").val(response.ids);
               
                showSuccessMessage('Successfully delete ');
            }
        });
    });


    // Newsletter user delete
    $(document).on('click', '.hinewslettervoucher .delete', function(e){
        e.preventDefault();
        var th = $(this);
        var id = th.attr("href").match(/id_hinewslettervoucher=([0-9]+)/)[1];
        $.ajax({
            type:'POST',
            url:pnt_admin_controller_dir,
            data:{
                ajax: true,
                action: 'delete-newsletter',
                id: id,
                secure_key : pnt_secure_key,
            },
            beforeSend: function(){
                th.find('i').removeClass('icon-trash').addClass('icon-refresh icon-spin');
            },
            success: function(response){
                th.find('i').removeClass('icon-refresh icon-spin').addClass('icon-trash');
                th.closest('tr').hide();
            }
        });
        return false;
    });

    /*Socila connect user delete*/
    $('.hipopupsocialconnectuser .delete').attr('onclick','').unbind('click');
    $(".hipopupsocialconnectuser .delete").click(function(){
        var id = $(this).attr("href").match(/id_hipopupsocialconnectuser=([0-9]+)/)[1];
        $('.delete_table').attr('data-id', id);
        $('.delete_full').attr('data-id', id);
        $(this).closest('tr').addClass('delete_'+id);
        $('#sc-modal_form').modal('show');
        return false;
    });
    $(document).on('click', '.delete_table, .delete_full', function(e){
        var action = $(this).attr("data-delete-type");
        var table_id = $(this).attr("data-id");
        $.ajax({
            type:'POST',
            url:pnt_admin_controller_dir,
            data:{
                ajax: true,
                secure_key : pnt_secure_key,
                action: action,
                table_id: table_id,
            },
            beforeSend: function(){
                $(".sc_loader").show();
            },
            success: function(response){
                $('#sc-modal_form').modal('hide');
                $(".delete_"+table_id).hide();
            }
        });
    });
});