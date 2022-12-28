(function($) {
    'use strict';
    $(function() {

        var ajax_url = ajax_cp_genre_params.ajax_url;

        function checkEmailValid(val) {
            var format = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if (format.test(val)) {
                return true;
            }
            return false;
        }



        function remove_coupon() {
            if ($(".auto_coupon").length && !$("body").hasClass("logged-in")) {
                var email = $("#billing_email").val();
                var checked = true;
                if (!$("#createaccount").prop('checked')) {
                    checked = false;
                }
                if (!checkEmailValid(email)) {
                    checked = false;
                }


                if (checked == false) {
                    $("body").find(".auto_coupon .woocommerce-remove-coupon").trigger('click');
                }

            }
        }
        setTimeout(
            function() {
                remove_coupon();
            }, 900);





        $(document).on('click', '.coupon_item', function(e) {
            $(".coupon_item").removeClass("active");
            $(this).addClass("active");
            var coupon_code = $(this).data("coupon");
            console.log(coupon_code);
            $("body").find(".checkout_coupon #coupon_code").addClass('abc').val(coupon_code);
            var $cart_form_coupon = $("form.woocommerce-form-coupon");
            $cart_form_coupon.find("input[name='coupon_code']").val(coupon_code);
        });
        $(document).on('keypress', '#billing_email', function(e) {
            $(this).parents(".form-row").removeClass('woocommerce-invalid');
            $(".error_email").text("");
        });
        $(document).on('change', '#createaccount', function(e) {

            var check = false;
            var email = $("#billing_email").val();
            if ($(this).prop('checked')) {
                check = true;
                if (checkEmailValid(email)) {

                } else {
                    check = false;
                     $("body").find("#billing_email").parents(".form-row").addClass('woocommerce-invalid');
                     jQuery("#createaccount").prop('checked', false);
                     $(".error_email").text("Email is invalid.").insertAfter("#billing_email");
                    // alert("Email is invalid.");
                    // jQuery(this).prop('checked', false);
                    // $("div.create-account").hide();

                }

            }
            var newuser_coupon = $("#btn_apply_coupon").data("newcustomer");

            if (check) {
                if ($(".list-coupon .auto_coupon").length) {
                    $(".list-coupon .auto_coupon").removeClass("hidden").addClass("active");
                }

                if ($(".list-coupon .auto_coupon").length) {
                    $("body").find(".input-coupon").val(newuser_coupon);
                }
                

                var data = {
                    action: 'auto_apply_coupon',
                    email: email

                };
                jQuery.ajax({
                        url: ajax_url,
                        data: data,
                    })
                    .done(function(result) {
                        if (result.data.error == '') {
                            // $( 'body' ).trigger( 'update_checkout' );                          
                        } else {
                            //alert(result.data.error);
                             $(".error_email").text(result.data.error).insertAfter("#billing_email");
                             $("body").find("#billing_email").parents(".form-row").addClass('woocommerce-invalid');
                            jQuery("#createaccount").prop('checked', false);
                            $("body").find(".input-coupon").val(newuser_coupon);
                            $("div.create-account").hide();

                        }

                    });
            } else {
                $("body").find(".input-coupon").val('');
                if ($(".auto_coupon").length) {
                    $("body").find(".auto_coupon .woocommerce-remove-coupon").trigger('click');
                    $('body').trigger('update_checkout');
                }
                if ($(".list-coupon .auto_coupon").length) {
                    $(".list-coupon .auto_coupon").addClass("hidden").removeClass("active");
                }
            }
            $( 'body' ).trigger( 'update_checkout' ); 
        });


        $(document).on("click", ".woocommerce-checkout .coupon-trigger button[name='apply_coupon']", function(event) {
            event.preventDefault();
            var newuser_coupon = $("#btn_apply_coupon").data("newcustomer");
            var $coupon_code = $(this).parents(".coupon-trigger").find(".input-coupon").val();
            var check = true;
            if ($("#createaccount").length) {               
                if (newuser_coupon.toLowerCase() == $coupon_code.toLowerCase()) {
                    if (!$("#createaccount").prop('checked')) {
                        check = false;
                        alert("You must create an account to use this coupon");

                    }
                }

            }


            if (check) {
                var $cart_form_coupon = $("form.woocommerce-form-coupon");
                $cart_form_coupon.find("input[name='coupon_code']").val($coupon_code);
                var $cart_form_coupon = $("form.woocommerce-form-coupon");
                $cart_form_coupon.find("button[name='apply_coupon']").click();
            }

        });

    }); // end document ready

})(jQuery); // end JQuery namespace