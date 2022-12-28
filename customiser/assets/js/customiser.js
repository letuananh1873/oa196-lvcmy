(function($) {
    const slideOptions = {
        autoPlay: false,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: false,
        dots: false,
        draggable: false,
        arrows: false,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    dots: true,
                }
            }
        ]
    };
    // Rewrite Url with Paramaster
    function changeUrl() {
        const productId = $('#product-id').val(),
              monthActive = $('.birthstone-product.active'),
              month = (monthActive.length > 0) ? monthActive.data('month') : 'january',
              name = $('#name').val(),
              productName = $('#customiser-product-name').val();

        var urlParam = `?id=${productId}&cus_name=${name}&month=${month}`;
        $('.share-fb').attr('href', 'https://www.facebook.com/sharer?u='+window.location.href)
        window.history.replaceState({}, '/', urlParam);
    }
    changeUrl();

    function get_cutomiser_url() {
        const productId = $('#product-id').val(),
              monthActive = $('.birthstone-product.active'),
              month = (monthActive.length > 0) ? monthActive.data('month') : 'january',
              name = $('#name').val(),
              productName = $('#customiser-product-name').val();

        return `${customiser_script.customiser_page}?id=${productId}&cus_name=${name}&month=${month}`;

    }

    // Get Customiser Product With month and name
    /**
     * @param {String} month Month name
     * @param {String} name Input name value
    */
    function get_customiser(month = 'january', name = '') {
        openModal('#loading-modal');
        $.ajax({
            url: customiser_script.ajax_url,
            method: 'post',
            dataType: 'json',
            data: {
                action: 'customiser_with_month',
                month: month,
                name: name
            }
        }).done(function(res) {
            if(res.success) {
                if( $('.product-image > ul').hasClass("slick-initialized")) {
                    $('.product-image > ul').slick('unslick');
                }
                $('.product-thumbnail img').attr('src', res.data.product_thumb);
                $('.product-image .product-gallery-item').remove();
                res.data.product_images.forEach(function(item) {
                $('.product-image ul').append(`<li class="product-gallery-item product-slide-img">
                    <img class="slide-img" src="${item}" alt="Product Gallery">
                </li>`);
                });
                if($(".product-slide-img").length > 1) {
                    $('.product-image > ul').slick(slideOptions);
                }
                $('.product-gallery').html(res.data.product_gallery);
                $('.product-price').html(res.data.product_price);
                $('.product-image').attr('data-id', res.data.product_id);
                $('#product-id').val(res.data.product_id);
                changeUrl();
                closeModal('#loading-modal');
                if(res.data.gallery_count > 0) {
                    $('.product-gallery').removeClass("hidden");
                } else {
                    $('.product-gallery').addClass("hidden");
                }
            }
        });
    }

    // Open Modal Function
    /**
     * @param {String} modalId Id of Modal open
     * @param {String} action Action name data
    */

    function openModal(modalIdent = '.customiser-modal', action = '') {
        $(modalIdent).addClass('active');
        $(modalIdent).attr('data-action', action);
        $('body, html').css('overflow', 'hidden');
    }

    function closeModal(modalIdent) {
        $(modalIdent).removeClass('active');
        $(modalIdent).attr('data-action', '');
        $('body, html').css('overflow', 'visible');
    }

    // Birthstones Image Click
    $(document).on('click', '.birthstone-product', function(e) {
        e.preventDefault();
        const month = $(this).data('month'),
              name = $('#name').val();

        $('.birthstone-product').removeClass('active');
        $(this).addClass('active');
        get_customiser(month, name);
        if(window.innerWidth < 768) {
            $("body, html").animate({
                scrollTop: 0
            }, 300);
        }

    });


    // Input Name Change
    var delayTimer;
    $('#name').bind('input', function() {
        const value = $(this).val(),
              monthActive = $('.birthstone-product.active'),
              month = (monthActive.length > 0) ? monthActive.data('month') : 'january';

        var temp = '';
        for(let i = 0; i < value.length; i++) {
            if(i < 15) {
                temp += value[i];
            }
        }

        $(this).val(temp);
        if(temp.length > 0) {
            clearTimeout(delayTimer);
        
            delayTimer = setTimeout(function() {
                $.ajax({
                    url: customiser_script.ajax_url,
                    method: 'post',
                    dataType: 'json',
                    data: {
                        action: 'alphabet_image',
                        name: temp
                    }
                }).done(function(res) {
                    console.log(res.success)
                    if(res.success) {
                        $('.alphabet').addClass('show');
                        if($("#name").val().length > 0) {
                            $('.alphabet img').css('display', 'flex');
                        } else {
                            $('.alphabet img').css('display', 'none');
                        }
                        $('.alphabet img').attr('src', res.data.image.url);
                        $('.customiser-atc').removeClass('disable');
                        console.log('dsdsd')
                    }
                });
                get_customiser(month, temp);
                changeUrl();
                $(".alphabet").addClass("show");
            }, 600);
        } else {
            $(".alphabet").removeClass("show");
            $('.customiser-atc').addClass('disable');
        }

        $('.name-amount .amount').text(temp.length);
        

    });

    // Open Product name input
    $(document).on('click', '.customiser-rename', function(e) {
        e.preventDefault();
        $('.customiser-title input').css({'pointer-events':'all'});
        $('.customiser-title input').focus();
    });

    // Create New Customiser Product
    $(document).on('click', '.customiser-new', function(e) {
        e.preventDefault();
        openModal('#nav-modal', 'new');
    });

    // Change url after input name change
    $(document).bind('input', '#customiser-product-name', function() {
        changeUrl();
    });

    // Modal close 
    $(document).on('click', '.modal-close', function(e) {
        e.preventDefault();
        $('.customiser-modal').removeClass('active');
        $('body, html').css('overflow', 'visible');
    });

    $('.creations-save').click(function(e) {
        e.preventDefault();
        openModal('#nav-modal', 'save');
    });

    $(document).on('click', '.save', function(e) {
        const productId = $('#product-id').val(),
              monthActive = $('.birthstone-product.active'),
              month = (monthActive.length > 0) ? monthActive.data('month') : 'january',
              name = $('#name').val(),
              productName = $('#customiser-product-name').val() || $('#customiser-product-name').data('default'),
              url = window.location.href;
        openModal('#loading-modal');
        $.ajax({
            url: customiser_script.ajax_url,
            dataType: 'json',
            method: 'post',
            data: {
                action: 'user_creations_save',
                month: month,
                name: name,
                productId: productId,
                productName: productName,
                url: url
            }
        }).done(function(res) {
            if(res.success) {
                window.location.href = res.data.url;
            } else {
                window.location.href = res.data.redirect;
            }
            closeModal('#loading-modal');
        });
    });

    // Open Add to cart modal
    $(document).on('click', '.customiser-atc', function(e) {
        e.preventDefault();
        if($('#name').val() ===  '') {
            $('.name-err').css('display', 'block');
        } else {
            $('.name-err').css('display', 'none');
            check_porduct_duplicate();
        }
        // openModal('#add-to-cart-modal');
    });

    function add_to_cart(duplicateKey = '') {
        const productId = $('#product-id').val(),
              monthActive = $('.birthstone-product.active'),
              month = (monthActive.length > 0) ? monthActive.data('month') : 'january',
              name = $('#name').val(),
              productName = $('#customiser-product-name').val() || $('#customiser-product-name').data('default'),
              url = window.location.href;

        openModal('#loading-modal');
        $.ajax({
            url: customiser_script.ajax_url,
            method: 'post',
            data: {
                action: 'customiser_add_to_cart',
                product_id: productId,
                product_name: productName,
                customer_name: name,
                product_url: url,
                product_month: month,
                duplicate_key: duplicateKey
            }
        }).done(function(res) {
            if(res.success) {
                window.location.href = res.data.redirect;
            }
            closeModal('#loading-modal');
        });
    }

    function check_porduct_duplicate() {
        const productId = $('#product-id').val(),
              monthActive = $('.birthstone-product.active'),
              month = (monthActive.length > 0) ? monthActive.data('month') : 'january',
              name = $('#name').val(),
              productName = $('#customiser-product-name').val() || $('#customiser-product-name').data('default'),
              url = window.location.href;   

        openModal('#loading-modal');
        $.ajax({
            url: customiser_script.ajax_url,
            method: 'post',
            data: {
                action: 'check_customiser_product_duplicate',
                product_id: productId,
                product_name: productName,
                customer_name: name,
                product_url: url,
                product_month: month
            }
        }).done(function(res) {
            closeModal('#loading-modal');
            if(res.success) {
                if(res.data.open) {
                    openModal('#add-to-cart-modal', 'add-to-cart');
                } else {
                    $('#duplicate-modal').find('.modal-main').html(res.data.html);
                    openModal('#duplicate-modal', 'duplicate');

                }
            } else {
                $('.name-err').css('display', 'block');
            }
        });
    }

    // Add to cart
    $(document).on('click', '.add-to-cart', function(e) {
        add_to_cart();
    });

    // Display Alphabet Image if Exits
    if($('.alphabet img').length > 0) {
        $('.alphabet').addClass('show');
    }

    $('.cancel').click(function(e) {
        e.preventDefault();
        const action = $(this).parents('.customiser-modal').data('action');
        if(action === 'save' || action === 'duplicate') {
            $(this).parents('.customiser-modal').removeClass('active');
        }
        if(action === 'new') {
            window.location.href = customiser_script.customiser_page;
        }
        if(action === 'duplicate') {
            add_to_cart();
            setTimeout(function() {
                $('#duplicate-modal').find('.modal-main').html('');
            }, 500);
        }

        if(action === 'add-to-cart') {
            closeModal('#add-to-cart-modal');
        }
        $('body, html').css('overflow', 'visible');
    });

    $(document).on('click', '.cart-replace', function(e) {
        e.preventDefault();
        const duplicateKey = $('#duplicate-key').val();
        add_to_cart(duplicateKey);
    })

    $('.share-email').click(function() {
       openModal('#share-modal', 'share'); 
    });

    $('.customiser-email').click(function(e) {
        e.preventDefault();
        const yourName = $('#cus-your-name').val(),
              yourEmail = $('#cus-your-email').val(),
              repName = $('#cus-recipient-name').val(),
              repEmail = $('#cus-recipient-email').val(),
              messageOptionals = $('#cus-mess-optionals').val();

        const regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        
        var errors = {
            yourName: {
                id: '#cus-your-name',
                error: (yourName === '') ? 'Please enter your name.' : ''
            },
            yourEmail: {
                id: '#cus-your-email',
                error: (yourEmail === '') ? 'Please enter your email.' : ((regex.test(yourEmail)) ? '' : 'Please enter a vaid email.')
            },
            repName: {
                id: '#cus-recipient-name',
                error: (repName === '') ? "Please enter recipient's name." : ''
            },
            repEmail: {
                id: '#cus-recipient-email',
                error: (repEmail === '') ? "Please enter recipient's email." : ((regex.test(repEmail)) ? '' : 'Please enter a vaid email.')
            }
        };

        var hasError = false;

        for(key in errors) {
            const val = errors[key];
            if(val.error !== '') {
                $(val.id).parents('.modal-field').find('.cus-err').html(val.error);
                hasError = true;
            } else {
                $(val.id).parents('.modal-field').find('.cus-err').html('');
            }
        }

        if(!hasError) {
            openModal('#loading-modal');
            $.ajax({
                url: customiser_script.ajax_url,
                method: 'post',
                dataType: 'json',
                data: {
                    action: 'customiser_email_share',
                    your_email: yourEmail,
                    your_name: yourName,
                    recipient_name: repName,
                    recipient_email: repEmail,
                    message: messageOptionals,
                    customiser_url: get_cutomiser_url(),
                    product_name: $('#customiser-product-name').val() || $('#customiser-product-name').data('default')
                }
            }).done(function(res) {
                if(res.success) {
                    $('#share-modal').find('.modal-main').html(`<p class="shared">You have shared this successfully with ${repName}</p>`);
                    $('#share-modal').find('.modal-actions').remove();
                    closeModal('#loading-modal');
                }
            })
        }
    });


    $('.tab-head').click(function() {
        const tabId = $(this).data('id');
        $('.tab-head').removeClass('active');
        $(this).addClass('active');
        $('.tab-main').removeClass('active');
        $(tabId).addClass('active');
    });

    $('.modal-overlay').click(function(e) {
        e.preventDefault();
        if($(this).parents('.customiser-modal').attr('id') !== 'loading-modal') {
            $(this).parents('.customiser-modal').removeClass('active');
            $('body, html').css('overflow', 'visible');
        }
    });

    $('.btn-sap').click(function() {
        $('.elementor-button[data-modal="68e5e4a"]').click();
    });
    if($(".product-slide-img").length > 1) {
        $('.product-image > ul').slick(slideOptions);
    }
    $(document).on('click', '.product-gallery li', function(e) {
        e.preventDefault();
        const items = document.querySelectorAll('.product-gallery li'),
              thisItemNum = Array.prototype.indexOf.call(items, this);

        $('.product-gallery li').removeClass('active');
        $(this).addClass('active');
        $('.product-image ul').slick('slickGoTo', thisItemNum);
    });
})(jQuery);


