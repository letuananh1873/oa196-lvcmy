(function($) {
    'use strict';
    $(function() {
        $(".filterBy_dianmond .fs-label-wrap").click(function() {
            $(this).parents(".filterByBoxes").find(".wrapper-list-filter").slideToggle();
        });

        function parseQueryString() {
            var parsedParameters = {},
                uriParameters = location.search.substr(1).split('&');

            for (var i = 0; i < uriParameters.length; i++) {
                var parameter = uriParameters[i].split('=');
                parsedParameters[parameter[0]] = decodeURIComponent(parameter[1]);
            }

            return parsedParameters;
        }

        function fym() {
            const formCart = $('.variations_form.cart'),
                formCartData = formCart.data('product_variations');
        }

        function disable_variation() {

            $(".list-att").each(function() {
                var check_item = false;
                var selectArr = [];
                $(this).parents(".diamon-type").find("select option.attached.enabled").each(function() {
                    selectArr.push($(this).val());
                });
                $(this).find(".item-att").each(function() {
                    var value = $(this).data("slug").toString();
                    if (jQuery.inArray(value, selectArr) < 0) {
                        $(this).addClass("disable");
                    } else {
                        $(this).removeClass("disable");
                        check_item = true;
                    }
                });

            });

        }
        setTimeout(function() {
            disable_variation();
        }, 1000);

        $(document).on('click', '.item-att:not(.disable)', function(e) {
            $(this).parents(".list-att").find(".item-att").removeClass("active");
            $(this).addClass("active");
            var slug = $(this).data("slug");
            var label = $(this).data("nameatt");
            $(this).parents(".diamon-type").find("select").val(slug).addClass("dfd").trigger('change');
            $(this).parents(".wrapper-item-attr").find(".attribute-item-name").text(label);

            setTimeout(function() {
                disable_variation();
            }, 1000);

            if ($("body").hasClass("product_diamond")) {

                fym();
                var i = 0;
                var p_id = $("#p_id").val();
                var param = '?p_id=' + p_id;
                $(".item-att.active").each(function() {
                    i++;
                    var pa = $(this).parents(".wrapper-item-attr").data("params");
                    var slug = $(this).data("slug");
                    param += '&' + pa + '=' + slug;
                });
                var diamondTypeDom = $('#pa_diamond-type');
                if (diamondTypeDom.length > 0) {
                    param += `&_diamond_type=${diamondTypeDom.val()}`;
                }
                var pathname = window.location.pathname;
                var url = pathname + param;

                if (history.pushState) {
                    history.pushState({}, document.title, url);
                }
                var url_select_diamond = $("a.select-diamond").data('url') + param;
               

                $("a.select-diamond").attr("href", url_select_diamond);
                if ($("#centerstone_link").length) {
                    var link = $("#centerstone_link").data("link")+param;
                     console.log(link);
                    $("#centerstone_link").attr("href",link);
                }
            }

            // show casing by metal
            var pa_metal_type = $(this).data("att");
            if (pa_metal_type == 'pa_metal-type') {
                var id = 'term_' + $(this).data("id");
                $(".item-att img").each(function() {
                    $(this).removeClass("show");
                    if ($(this).hasClass(id)) {
                        $(this).addClass("show");
                    }
                })
            }

            // reload title 
            setTimeout(function() {
                if (!$(this).hasClass("item_pa_ring-size")) {
                    $(".variations_form.cart").addClass("diamond-loading");
                    var variation_id = $(".variation_id").val();
                    var product_id = $("input[name='product_id']").val();
                    var data = {
                        product_id: product_id,
                        variation_id: variation_id,
                        action: 'replace_title_product_diamond',
                        nonce: nonce,
                    };
                    jQuery.ajax({
                            url: ajax_url,
                            type: 'POST',
                            data: data,
                            beforeSend: function() {
                                $(".loader-wrapper").show();
                            },
                        })

                        .done(function(result) {
                            $(".variations_form.cart").removeClass("diamond-loading");
                            console.log(result.data.new_title);
                            if (result.data.new_title != '') {
                                $("body").find("h1.product_title").html(result.data.new_title);
                            }



                        });
                }
            }, 500);
        });

        function url_parameter() {
            var parsedParameters = {},
                url = '',
                u2 = location.search,
                uriParameters = location.search.substr(1).split('&');

            for (var i = 0; i < uriParameters.length; i++) {
                var parameter = uriParameters[i].split('=');
                var a = '?';
                if (i == 0) {
                    a = '&';
                }
                url += a + parameter[0] + "=" + parameter[1];
            }
            return u2;
        }

        // emma note

        jQuery(document).on('click', ' .adv_single_container  a', function(e) {
            e.preventDefault();
            var u2 = location.search;
            var href = $(this).attr("href").split('?')[0] + u2;
            window.location.href = href;

        });

        $(".collection-filter ul li").click(function() {
            const checkedNum = $(".wrapper-filter-collection input:checked").length;
            $(".collection-filter ul li").removeClass('active');
            $(this).addClass("active");
            $(".wrapper-filter-collection input").prop("checked", false);
            var data_id = "#" + $(this).data("id");
            $(data_id).prop("checked", 'checked');
            if (checkedNum === 0) {
                $(data_id).trigger("change");
            } else {
                $(".wrapper-filter-collection input").trigger("change");
            }

        });

        $(".modyfy-select").click(function() {
            if (!$(this).hasClass("active")) {
                $(".modyfy-select").not(this).removeClass("active");
                $(".modyfy-select").not(this).parents(".wrapper-item-attr").removeClass("active").find(".single_diamond_type1_child").slideUp();
                $(this).addClass("active");
                $(this).parents(".wrapper-item-attr").find(".single_diamond_type1_child").slideDown();

            } else {
                $(this).parents(".wrapper-item-attr").find(".single_diamond_type1_child").slideUp();
                $(this).removeClass("active");
            }

        });
        $(".more-size span").click(function() {
            $(this).parents(".wrapper-item-attr").find(".wrapper-more-size").slideToggle();
            $(this).hide();
        });

        function move_shortby() {
            var form_sort = $(".woocommerce-ordering");
            if ($(window).width() < 768) {
                $(form_sort).appendTo('.order-by-mb');
            } else {
                $(form_sort).insertAfter('.woocommerce-result-count');
                $(form_sort).appendTo('');
            }
        }
        move_shortby();
        window.addEventListener('resize', function() {
            move_shortby();
        });

        if ($("body").hasClass("product_diamond")) {
            $(".wrapper-select-diamond").addClass("disable");
            setTimeout(function() {
                console.log($('.woocommerce-variation-price .woocommerce-Price-amount').html());
                $('#price-varition').empty();
                $('#price-varition').html($('.woocommerce-variation-price .woocommerce-Price-amount').html());
                if ($('.woocommerce-variation-price .woocommerce-Price-amount').length) {
                    $(".wrapper-select-diamond").removeClass("disable");
                }
            }, 5000);
        }

        function move_price_variation() {
            if ($("body").hasClass("product_diamond")) {
                $('.variations_form').on('woocommerce_variation_has_changed', function() {
                    if (typeof $('.woocommerce-variation-price .woocommerce-Price-amount').html() !== 'undefined') {
                        if ($('.woocommerce-variation-price .woocommerce-Price-amount').html().length) {

                            $('#price-varition').empty();
                            $('#price-varition').html($('.woocommerce-variation-price .woocommerce-Price-amount').html());
                        }
                    }

                });
            }
        }
        move_price_variation();
        $(".size-guide span").click(function() {
            $("#guide-side-diamond,.overlay").addClass("active");
            $("html").addClass("sroll");
        });
        $(".guide-side-diamond .modal__close").click(function() {
            $("#guide-side-diamond,.overlay").removeClass("active");
            $("html").removeClass("sroll");
        });

        // filter shop
        if ($(".filterByWrap_type1").length) {
            $(".fs-label-wrap").click(function() {
                if (!$(this).hasClass("active")) {
                    $(".fs-label-wrap").not(this).removeClass("active");
                    $(".fs-label-wrap").not(this).parents(".filterByBoxes").removeClass("active").find(".wrapper-list-filter").slideUp();
                    $(this).addClass("active");
                    $(this).parents(".filterByBoxes").find(".wrapper-list-filter").slideDown();

                } else {
                    $(this).parents(".filterByBoxes").find(".wrapper-list-filter").slideUp();
                    $(this).removeClass("active");
                }

            });

        }


        jQuery(document).on('click contextmenu', '.adv_single_container  a', function(e) {

            // If the right mouse button is used 
            if (e.which === 3) {
                var u2 = location.search;
                var href = $(this).attr("href").split('?')[0] + u2;
                $(this).attr("href", href);
            }

        });


        // only enter chinese or english
        function isChn(str) {
            return /^[\u4E00-\u9FA5]+$/.test(str);
        }

        function only_enter_lang(value) {
            var lag = $(".tab-choose.active").data("tab");
            if (lag == 'eng') {
                value = value.replace(/[^A-Za-z -]/g, '');

                value = value.replace(/(\..*)\./g, '$1');
                value = value.replace(/\s+$/g, ' ');
                if (/^\s*$/.test(value)) {
                    value = '';
                }
                if (value == '') {
                    $(".message-amount").html('0');
                } else {
                    $(".message-amount").html(value.length);
                }
            }

            return value;
        }

        function detectBrowser() {
            if ((navigator.userAgent.indexOf("Opera") || navigator.userAgent.indexOf('OPR')) != -1) {
                return 'Opera';
            } else if (navigator.userAgent.indexOf("Chrome") != -1) {
                return 'Chrome';
            } else if (navigator.userAgent.indexOf("Safari") != -1) {
                return 'Safari';
            } else if (navigator.userAgent.indexOf("Firefox") != -1) {
                return 'Firefox';
            } else if ((navigator.userAgent.indexOf("MSIE") != -1) || (!!document.documentMode == true)) {
                return 'IE'; //crap
            } else {
                return 'Unknown';
            }
        }
        $('#message').bind('input', function() {
            var lag = $(".tab-choose.active").data("tab");
            if (lag == 'eng') {
                var value = $(this).val();
                value = only_enter_lang(value);
                $(this).val(value);

            }
        });


        function return_value_cn(value) {
            value = value.replace(/[^\u4E00-\u9FA5 -]/g, '');
            value = value.replace(/(\..*)\./g, '$1');
            value = value.replace(/\s+$/g, ' ');
            if (/^\s*$/.test(value)) {
                value = '';
            }
            if (value == '') {
                $(".message-amount").html('0');
            } else {
                $(".message-amount").html(value.length);
            }
            return value;
        }

        const inputElement = document.getElementById("message");

        function handleEvent(event) {

            var lang = $("#lag_active").val();
            if (lang == 'cn') {
                var data2 = event.data;
                var value = $("#message").val();
                value = return_value_cn(value);
                $("#message").val(value);
            }

        }


        $(".tab-font").click(function() {
            var value = $('#message').val();
            value = only_enter_lang(value);
            $('#message').val(value);
            if (value == '') {
                $(".button--text").html('Add Engraving');
            }
        });
        $(".tab-head li").click(function() {
            var lag = $(this).data("tab");
            $("#lag_active").val(lag);
        });

        /* enter chinese or eng */


        ///////////////////////////////////
        ///// filter diamond
        var ajax_url = dianmond_params.ajax_url;
        var home_url = dianmond_params.home_url;
        var home_page = home_url + '/home';
        var nonce = dianmond_params.nonce;

        $(".diamond-shorty label").click(function() {
            $(this).parents(".diamond-shorty").find(".sort_by_diamond").slideToggle();
            $(".diamond-shorty").toggleClass("active");
        });
        $(".sort_by_diamond li").click(function() {
            $(".sort_by_diamond li").removeClass("active");
            $(this).addClass("active");
            var value = $(this).data("value");
            var label = $(this).data("label");
            var text = $(this).html();
            $(".diamond-shorty strong").html(text);
            $(".sort_by_diamond").slideUp();
            $(".diamond-shorty").removeClass("active");
            filter_diamond_by_att(1, '');
        });



        function move_active_last() {
            $(".wrapper-att").each(function() {
                var name = $(this).data("name");
                $(this).find(".value_active .dianmond-title").html('');
                var html_active = $(this).find(".wrapper-att.active .dianmond-title").html();
                $(this).find(".value_active .dianmond-title").html(html_active);
            });
        }

        function filter_diamond_by_att(page, shape_id) {
            var array = [];
            $(".att-diamond.active").each(function() {
                var taxonomy_name = $(this).data("value");
                var att_name = $(this).data("attribute");
                array.push(encodeURIComponent(att_name) + "=" + encodeURIComponent(taxonomy_name));

            });
            var str_filter = array.join("&");
            var url_current = $("#url_current").val();
            var sortby = '';
            if ($(".sort_by_diamond li.active").length) {
                sortby = $(".sort_by_diamond li.active").data("value");
            }

            var data = {
                str_filter: str_filter,
                url_current: url_current,
                page: page,
                sortby: sortby,
                shape_id: shape_id,
                action: 'filter_diamond_by_att',
                nonce: nonce,
            };
            jQuery.ajax({
                    url: ajax_url,
                    type: 'POST',
                    data: data,
                })
                .done(function(result) {
                    $("body").find(".diamond-products ul").html(result.data.products_variation);
                    $("body").find(".pavi-variation").html(result.data.page_variation);
                    $("body").find(".result-count").html(result.data.result);
                    if (shape_id != '') {
                        $("body").find(".wrapper-banner-lvc").html(result.data.lvc_banner);
                    }

                    var link = url_current + result.data.url;
                    if (history.pushState) {
                        history.pushState({}, document.title, link);
                    }

                });
        }

        $(".att-diamond:not(.value_active)").click(function() {
            $(this).parents(".wrapper-att").find(".att-diamond").removeClass('active');
            $(this).addClass("active");
            var html_active = $(this).find(".dianmond-title").html();
            $(this).parents(".wrapper-att").find(".value_active .dianmond-title").html(html_active);
            var shape_id = $(this).data("id");
            filter_diamond_by_att(1, shape_id);
        });
        $(".att-diamond.value_active").click(function() {
            $(this).find(".dianmond-title").html('');
            $(this).parents(".wrapper-att").find(".att-diamond").removeClass('active');
            filter_diamond_by_att(1, 474);
        });

        $(document).on('click', '.pavi-variation a', function(e) {
            e.preventDefault();
            var page = $(this).text();
            if ($(this).hasClass("next")) {
                page = parseInt($("body").find("span.current").text()) + 1;
            }
            if ($(this).hasClass("prev")) {
                page = parseInt($("body").find("span.current").text()) - 1;
            }
            filter_diamond_by_att(page, '');
        });
        setTimeout(function() {
            if ($(".parent_0").length) {
                //$(".item-att").removeClass("active");
                //$(".attribute-item-name:not(.centerstone_item)").html("");
            } else {
                if ($("body").hasClass("product_diamond_type1_child")) {
                    console.log('mk');

                    //  var b = [];
                    //   var a = location.search.substr(1).split('&');
                    //   if (location.search.substr(1) != '') {
                    //  $(".item-att").removeClass("active");
                    //  $(".attribute-item-name:not(.centerstone_item)").html("");
                    //  console.log(a);
                    // console.log(a.length);
                    //  a.forEach(function(item, index) {
                    //     b.push(item.split('=')[1]);
                    //  });
                    //  b.forEach(function(item, index) {
                    //      var class_item = "." + item;
                    //     $(class_item).trigger("click");
                    //  });
                    //  if ($("#pa_ring-size").length) {
                    //   var ring_size = "." + $("#pa_ring-size .attached.enabled:first").val();
                    //  $(ring_size).trigger("click");
                    //  }
                    //}
                }
            }
        }, 1000);



        // filter child product
        $(".sidebar-filter input").change(function() {
            filter_child_diamond_by_att(1);
        });
        $(document).on('click', '.page-select-diamond a', function(e) {
            e.preventDefault();
            var page = $(this).text();
            if ($(this).hasClass("next")) {
                page = parseInt($("body").find("span.current").text()) + 1;
            }
            if ($(this).hasClass("prev")) {
                page = parseInt($("body").find("span.current").text()) - 1;
            }
            filter_child_diamond_by_att(page);
        });

        function filter_child_diamond_by_att(page) {
            $(".loader-wrapper").show();
            var data = jQuery('#filter-child').serialize() + '&action=filter_child_product&page=' + page + '&nonce=' + nonce;
            jQuery.ajax({
                    url: ajax_url,
                    type: 'POST',
                    data: data,
                    beforeSend: function() {
                        $(".loader-wrapper").show();
                    },
                })

                .done(function(result) {
                    $(".loader-wrapper").hide();
                    $("body").find("#filter-container2").html(result.data.products_child);
                    $("body").find(".page-select-diamond").html(result.data.page_child);
                });
        }
        var players = $(".list_pa_ring-size div");
        var temp = players.sort(function(a, b) {
            return parseInt($(a).attr("data-slug")) - parseInt($(b).attr("data-slug"));
        });
        $(".list_pa_ring-size").html(temp);

        $(window).load(function() {
            $('#pa_casing').trigger('change');
        });
    }); // end document ready

})(jQuery); // end JQuery namespace