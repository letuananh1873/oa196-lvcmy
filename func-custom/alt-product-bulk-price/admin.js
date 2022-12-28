jQuery(document).ready(function($) {
    $(document).on('click', '.btn-bulk-import' ,function(e){
        e.preventDefault();

        $('.bulk_price_import_wrapper').slideToggle();

    });

    
    $(document).on('click', '.bulkprice-remove-button' ,function(e){
        e.preventDefault();

        var $btn = $(this);

        if (confirm("Are you sure remove this record?") == true) {
            jQuery.ajax({
                type: 'POST',
                url: bulk_admin.ajax_url,
                data: {
                    action: 'alt_product_remove',
                    id: $btn.attr('data-id')
                },
                beforeSend: function (response) {
                    $btn.prop('disabled', true).css('opacity', 0.5);
                },
                complete: function (response) {
                    $btn.prop('disabled', false).css('opacity', 1);
                    
                    
                },
                success: function (response) {
                    $btn.closest('tr').remove();
                },
            });
        }


    });

    $(document).on('click', '.button-bulk-start-import' ,function(e){
        e.preventDefault();

        var $btn = $(this),
            file = $('#bulk-import_file_input')[0].files[0];

        var formData = new FormData();
        formData.append("action", 'alt_product_import');
        formData.append("file", file);

        console.log(file);

        jQuery.ajax({
            type: 'POST',
            url: bulk_admin.ajax_url,
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function (response) {
                $btn.prop('disabled', true).css('opacity', 0.5);
            },
            complete: function (response) {
                $btn.prop('disabled', false).css('opacity', 1);
                
            },
            success: function (response) {
                if( typeof response.complete != 'undefined' ) {
                    $('.bulk_price_import_wrapper').slideToggle();
                    location.reload();
                }else {
                    $('#bulk_price_import_message').append(response.message);
                }
            },
        });
    });
    
    $(document).on('click', '.btn-bulk-export' ,function(e){
        e.preventDefault();

        var $btn = $(this);

        jQuery.ajax({
            type: 'POST',
            url: bulk_admin.ajax_url,
            data: {
                action: 'alt_product_export'
            },
            beforeSend: function (response) {
                $btn.prop('disabled', true).css('opacity', 0.5);
            },
            complete: function (response) {
                $btn.prop('disabled', false).css('opacity', 1);
                
            },
            success: function (response) {
                if( typeof response.complete != 'undefined' ) {
                    window.location.href = response.url;

                }
            },
        });
    });

    var _columns = [
        { "data": "product_name" },
        { "data": "sku" },
        { "data": "price" }
    ];

    $.each(bulk_admin.columns, function( index, value ) {
        _columns.push({'data': value});
    });

    _columns.push({'data': 'action'});

    $('#table-bulk-price').DataTable({
        // "responsive": true,
        "searching": true,
        "scrollX": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": bulk_admin.ajax_url,
            "type": "POST",
            "data": function ( d ) {
                var laraForm = {
                    'action': 'alt_bulk_price_listing'
                };

                return $.extend({}, laraForm, d);
            },
            "dataSrc": function ( json ) {
                $('.table-body').removeClass('loaded');
                $('.has-dataTable').removeClass('first-dataTable');

                return json.data;
            },
        },
        "columns": _columns
    });

    $(document).on('keyup', '.fixed_price, .fixed_attr_price' ,function(e){
        if(e.keyCode == 13) {
            var tr = $(this).closest('tr');

            tr.find('.bulkprice-save-button').trigger('click');
        }
    });

    function hide_result_bulk() {
        $('#result-bulk-price .result-bulk-price-content').empty();
        $('#result-bulk-price').removeClass('active');
        $('.modal-backdrop').remove();
    }

    $(document).on('click', function(e) {
        if( $(e.target).hasClass('modal-backdrop')) {
            hide_result_bulk();
        }
    });

    $(document).on('click', '.bulkprice-save-button', function(e) {
        e.preventDefault();

        var button = $(this),
            tr = $(this).closest('tr'),
            data = {
                'action': 'alt_bulk_price_update',
                'price': tr.find('.fixed_price').val(),
                'id': tr.find('.bulk_id').val(),
                'product_id': tr.find('.product_id').val()
            },
            combination = {};

        $.each(tr.find('.fixed_attr_price'), function( index, value ) {
            var value = $(this).val(),
                attribute = $(this).attr('data-attribute');
                combination[attribute] = value;
        });

        var data = $.extend({}, data, { attributes: combination});

        

        jQuery.ajax({
            type: 'POST',
            url: bulk_admin.ajax_url,
            data: data,
            beforeSend: function (response) {
                hide_result_bulk();
                button.prop('disabled', true);
                tr.addClass('alt-loading');
            },
            complete: function (response) {
                button.prop('disabled', false);
                tr.removeClass('alt-loading');
                
            },
            success: function (response) {
                tr.addClass('run-done');
                
                if( typeof response.complete != 'undefined' ) {
                    if( Object.keys(response.data).length > 0 ) {
                        if( typeof isDebug != 'undefined' ) {
                            $('#result-bulk-price').addClass('active');

                            var html = '<ul>';
                            $.each(response.data, function( index, value ) {
                                html += '<li>' + value + '</li>';
                            });
                            html += '</ul>';
        
                            $('.result-bulk-price-content').html(html);

                            $('body').append('<div class="modal-backdrop fade show"></div>');
                        }

                    }else {
                        if( typeof isDebug != 'undefined' ) {
                            $('#result-bulk-price').removeClass('active');
                            $('.modal-backdrop').remove();
                        }
                        // 
                        alert('Update succesful! Record not found.');
                        // 
                    }

                }else {
                    alert(response.message);
                }
            },
        });
    });
} );