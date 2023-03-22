/* (function($) {

    "use strict";
    $(document).on('change', "#enable_subscription", function() {
        if($(this).is(':checked')){
            var checkval = 'checked';
        }else{
            var checkval = 'unchecked';
        }
        $.ajax({
            type: "POST",
            dataType: "json",
            url: wc_add_to_cart_params.ajax_url,
            data: { action: "make_woo_product_as_subscription", checkval: checkval},
            beforeSend: function() {
                $('.loader').show();
            },
            complete: function() {
                $('.loader').hide();
            },
            success: function(r) {
                if (r.response == 'success') {
                    location.reload();
                } else {
                    location.reload();
                }
            }
        });
    });

})(jQuery); */

jQuery(window).ready(function( $ ) {
    "use strict";
    $(document).on('change', "#enable_subscription", function() {
        if($(this).is(':checked')){
            var checkval = 'checked';
        }else{
            var checkval = 'unchecked';
        }
        $.ajax({
            type: "POST",
            dataType: "json",
            url: wc_add_to_cart_params.ajax_url,
            data: { action: "make_woo_product_as_subscription", checkval: checkval},
            beforeSend: function() {
                $('.loader').show();
            },
            complete: function() {
                $('.loader').hide();
            },
            success: function(r) {
                if (r.response == 'success') {
                    location.reload();
                } else {
                    location.reload();
                }
            }
        });
    });
 });