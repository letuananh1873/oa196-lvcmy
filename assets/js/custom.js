jQuery(document).ready(function($) {
    $(window).scroll(function() {
        var scroll = $(window).scrollTop()

        if( scroll > 0 ) {
            $('section.elementor-element-b099c39').hide();
            if ($(".announcments").length) {
                $('.announcments').slick('unslick');
            }
        }else {
            $('section.elementor-element-b099c39').show();
            if ($(".announcments").length) {
                $('.announcments').slick({
                    autoplay: true,
                    autoplaySpeed: 5000,
                    dots: false,
                    // autoplay: false,
                    prevArrow: "<div type='button' class='slick-prev slick-arrow arrow-left'></div>",
                    nextArrow: "<div type='button' class=' slick-next slick-arrow arrow-right'></div>",
                    responsive: [{
                            breakpoint: 768,
                            settings: {
                                arrows: false
                            }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                    ]
                });
            }
        }
    });
    
    // $("#trigger_pa_font-type").customSelect();
    $(document).on("click", function(event) {
        var target = event.target;
        var container = $(".custom-select-container");
        if (!container.is(target) && container.has(target).length == 0) {

            container.find(".custom-select-options.opened").hide();
            container.find(".custom-select-options.opened").closest(".custom-select-container").find(".custom-select-current.expanded").removeClass("expanded");
            container.find(".custom-select-options.opened").removeClass("opened");
        }
    });
    $(".engraving-item .custom-select-container .custom-select-options").on("click", function() {
        $(this).closest(".engraving-item").find("select").change();
    });

     $(".engraving #message").on("change", function() {
        $(this).closest(".engraving-item-edit").addClass("engraving-item-edit--edited");
        if(!$('#trigger_pa_font-type').val() == '') {
            $('.button--text').text('Modify Engraving');
        }
        if($(this).val() === '') {
            $('.button--text').text('Add Engraving');
            
        } 
        let messeage_option = $(this).attr("data-select");
        $("#pa_your-engraving-message-selectized").click();
        $("#pa_your-engraving-message-selectized").closest(".selectize-control").find(".selectize-dropdown .option[data-value='" + messeage_option + "']").click();
        check_to_do_engraving_finish();
        $(".engraving #edit-engraving .mock--edit").show();
    });
    
    $("#trigger_pa_font-type option").each(function() {
        let font_type = $(this).val();
        let font_family = $(this).attr("data-font-family");
        if (font_family != undefined) {
            $(this).css("font-family", font_family);
            if ($("#trigger_pa_font-type ~ .custom-select-container .custom-select-options li[data-option='" + font_type + "']").length > 0) {
                $("#trigger_pa_font-type ~ .custom-select-container .custom-select-options li[data-option='" + font_type + "']").css("font-family", font_family);
            }
        }
    });
    var messageBox = document.querySelector('.engraving #message');
    if(messageBox !== null) {
        messageBox.addEventListener('input', function() {
            $(this).closest(".engraving-item-edit").addClass("engraving-item-edit--edited");
            let messeage_option = $(this).attr("data-select");
            $("#pa_your-engraving-message-selectized").click();
            $("#pa_your-engraving-message-selectized").closest(".selectize-control").find(".selectize-dropdown .option[data-value='" + messeage_option + "']").click();
            check_to_do_engraving_finish();
            $(".engraving #edit-engraving .mock--edit").show();
            if(this.value.length <= 0) {
                $('.mock--edit').css({display: 'none'});
            } else {

                $('.mock--edit').css({display: 'block'});
            }
        })
    }
  $("select#trigger_pa_font-type").on("change", function() {
        $("#pa_font-type-selectized").click();
        $("#pa_font-type-selectized").closest(".selectize-control").find(".selectize-dropdown .option[data-value='" + $(this).val() + "']").click();

        // $("#pa_font-type").val($(this).val());   
        $(this).closest(".engraving-item-edit").addClass("engraving-item-edit--edited");
        let font_type = $("#trigger_pa_font-type").val();
        let font_family = $("#trigger_pa_font-type option[value='" + font_type + "']").attr("data-font-family");
        if (font_family != undefined) {
            $("#trigger_pa_font-type").css("font-family", font_family);
            $("#trigger_pa_font-type option[value='" + font_type + "']").css("font-family", font_family);
            $("#trigger_pa_font-type ~ .custom-select-container").css("font-family", font_family);
            $(".engraving .engraving-item-edit").css("font-family", font_family);
        }
        check_to_do_engraving_finish();
    });
   $('.mock--edit').click(function(e) {
        e.preventDefault();
        $('.tab-font').find('li').removeClass('selected');
        $('input#message').val('');
        $('.text-demo').text('');
        $('.button--text').text('Add Engraving');
        $(this).hide();
    });
   function check_to_do_engraving_finish() {
        let message_val = $(".engraving #message").val();
        let font_type = $("#trigger_pa_font-type").val();
        let is_valid = true;
        if (message_val.length == 0) {
            is_valid = false;
        }
        if (!(font_type && font_type.length > 0)) {
            is_valid = false;
        }


        // do
        if (is_valid) {
            let finish_text = "";
            let maxlength = parseInt($("#message").attr("maxlength"));
            if (maxlength > 0) {
                finish_text += message_val.substr(0, maxlength);
            } else {
                finish_text += message_val;
            }
            finish_text += ", " + $("#trigger_pa_font-type option[value='" + font_type + "']").text();
            $(".text-demo").text(finish_text);
            if (!$(".engraving .engraving-button").hasClass("engraving-button--edited")) {
                $(".engraving .engraving-button").addClass("engraving-button--edited");
            }
            if ($(".engraving .engraving-item-edit").length == $(".engraving .engraving-item-edit.engraving-item-edit--edited").length) {
                $(".engraving .engraving-item-edit").removeClass("engraving-item-edit--edited");
                $(".engraving .engraving-item--canhide").toggleClass("active");
                $(".engraving .engraving-item--message").toggleClass("active"); // #70977
            }
        }
    }

     $(".engraving .engraving-button").on("click", function() {
        // $(".engraving .engraving-item-edit").removeClass("engraving-item-edit--edited");
        // $(this).closest(".engraving").find(".engraving-item--canhide").toggleClass("active");
        if($(this).hasClass('clicked')) {
            $('.engraving-button').removeClass('clicked');
            $('.engraving-header').find('#edit-engraving').css('display', 'block'); 
            $('.engraving-item-edit').css('display', 'none');
            if($('#trigger_pa_font-type').val() != '' && $('.engraving-item #message').val() != '') {
                $('.button--text').text('Modify Engraving');
            }
        } else {
            $('.engraving-button').addClass('clicked'); 
            $('.engraving-header').find('#edit-engraving').css('display', 'none'); 
            $('.engraving-item-edit').css('display', 'block');
        }

    });




    // 16/12/20 
    if ($("#billing_nationality").length > 0) {
        var billing_others_nationality = "";
        if ($("#billing_others_nationality").length > 0) {
            var billing_others_label = "";
            if ($("#billing_others_nationality").attr("data-label") != undefined) {
                billing_others_label = $("#billing_others_nationality").attr("data-label");
            }
            billing_others_nationality = $("#billing_others_nationality").get(0);
        }

        $("#billing_nationality").on("change", function() {
            console.log($(this).val());
            if ($(this).val() == "Others") {
                if ($(document).find("#billing_nationality_field .woocommerce-input-wrapper .billing-others-nationality").length == 0) {
                    $(this).closest(".woocommerce-input-wrapper").append("<div class='billing-others-nationality'></div>");
                    if (billing_others_label != "") {
                        $(document).find("#billing_nationality_field .woocommerce-input-wrapper .billing-others-nationality").append("<span>" + billing_others_label + "</span>");
                    }
                    $(document).find("#billing_nationality_field .woocommerce-input-wrapper .billing-others-nationality").append(billing_others_nationality);
                }
                $(document).find("#billing_nationality_field .billing-others-nationality").show();
            } else {
                $(document).find("#billing_nationality_field .billing-others-nationality").hide();
            }
        });
        // run if billing nationality is others to show field others
        if ($("#billing_nationality").length > 0 && $("#billing_nationality").val() == "Others") {
            $("#billing_nationality").change();
        }
    }
    if ($("#shipping_nationality").length > 0) {
        var shipping_others_nationality = "";
        if ($("#shipping_others_nationality").length > 0) {
            shipping_others_nationality = $("#shipping_others_nationality").get(0);
            $("#shipping_others_nationality").remove();
        }
        $("#shipping_nationality").on("change", function() {
            console.log($(this).val());
            if ($(this).val() == "Others") {
                if ($(this).closest(".woocommerce-input-wrapper #shipping_others_nationality").length == 0) {
                    $(this).closest(".woocommerce-input-wrapper").append(shipping_others_nationality);
                }
                $(document).find("#shipping_nationality_field .billing-others-nationality").show();
            } else {
                $(document).find("#shipping_nationality_field .billing-others-nationality").hide();
            }
        });
        if ($("#shipping_nationality").length > 0 && $("#shipping_nationality").val() == "Others") {
            $("#shipping_nationality").change();
        }
    }
    // end 16/12/20

    /* ------------------ add by emma ------------------- */
    
    var cookie_notice_accepted = localStorage.getItem("cookie_notice_accepted");
    if (!cookie_notice_accepted) {
        setTimeout(function() {
            $("#cookie-notice").removeClass("cookie-notice-hidden");
        }, 8000);
    }
    $('.accept-cookie').click(function() {
        $("#cookie-notice").addClass("cookie-notice-hidden");
        localStorage.setItem("cookie_notice_accepted", true);
    });

    // Sticky Header Menu
    var stickyScroll = 0;
    
    function stickyMenu() {
        const header = $('.elementor-location-header'),
              headerheight = header.height(),
              pageY = $(window).scrollTop();
        $('body').css({'padding-top': headerheight});
        if(pageY > stickyScroll && pageY >= headerheight) {
            header.addClass('sticky-menu--hidden');
        } else {
            header.removeClass('sticky-menu--hidden');
        }

        stickyScroll = pageY;
    }

    stickyMenu();

    window.addEventListener('load', function() {
        stickyMenu();
    });


    $(window).on('scroll', function(e) {
        stickyMenu();
    });
    // if ($("ul.products").length) { 
    //     $(document).ajaxComplete(function(event, xhr, settings) {
    //         if (settings.url.indexOf("_paged") != -1) {
    //             var h_header = parseInt($('.elementor-location-header').outerHeight());
    //             var offsettop = $("ul.products").offset().top - h_header - 100;
    //             jQuery('html, body').animate({
    //                 scrollTop: offsettop
    //             }, 'slow');
    //         }

    //     });
    // }

    // $(document).on('facetwp-refresh', function() {
    //     if($('.filterByWrap').length > 0) {
    //         const $top = $('.filterByWrap').offset().top;
    //         document.querySelector('html').classList.add('fast-scroll');
    //         setTimeout(function() {
    //             window.scroll(0, $top - 200);
    //         }, 100);
    //     }
    // });



    // $(document).on('facetwp-loaded', function() {
    //     document.querySelector('html').classList.remove('fast-scroll');
    // });

    // End Sticky Header Menu

// Checkout Phone Number
    const bp = document.getElementById('billing_phone');
    const sp = document.getElementById('shipping_phone');
    const registerPhone = document.getElementById('contact');
    const checkoutPhones = [bp, sp, registerPhone];

    function createMbCtCodeSelect(el) {
        const dataWrap = document.getElementById('country-mobile-code'),
            data = JSON.parse(dataWrap.textContent),
            dataCode = JSON.parse(dataWrap.getAttribute('data-code')),
            slWrap = document.createElement('div'),
            sl = document.createElement('ul'),
            slOptionResult = document.createElement('div'),
            slRelativeWrap = document.createElement('div'),
            inputCode = document.createElement('input'),
            elId = el.getAttribute('id');

        el.parentNode.classList.add('country_code');
        slOptionResult.classList.add('country_code_result');
        slWrap.classList.add('country_code_select');
        slRelativeWrap.classList.add('relative_wrap');
        sl.classList.add('sl');
        inputCode.setAttribute('type', 'hidden');
        inputCode.setAttribute('name', elId + '_customcode');

        for (var i = 0; i < data.length; ++i) {
            const slOption = document.createElement('li'),
                slOptionSpan = document.createElement('span'),
                slOptionIcon = document.createElement('span'),
                slOptionNumber = document.createElement('span');

            slOption.classList.add('sl_li');
            slOptionSpan.classList.add('sl_span');
            slOptionIcon.classList.add('sl_icon');
            slOptionNumber.classList.add('sl_number');

            slOptionSpan.textContent = data[i]['country_name'];
            slOptionNumber.textContent = '+' + data[i]['country_mobile_code'];
            slOptionIcon.textContent = '+' + data[i]['country_mobile_code'];

            if(elId === 'billing_phone' && Number(data[i]['country_mobile_code']) ===  Number(dataCode.billing)) {
                const cpSpan = slOptionSpan.cloneNode(true),
                cpIcon = slOptionIcon.cloneNode(true);
                
                slOptionResult.appendChild(cpSpan);
                slOptionResult.appendChild(cpIcon);  
                inputCode.value = dataCode.billing;
                el.style.paddingLeft = (dataCode.billing.length * 16 + 10) + 'px'; 
            } 

            if(elId === 'shipping_phone' && Number(data[i]['country_mobile_code']) ===  Number(dataCode.shipping)) {
                const cpSpan = slOptionSpan.cloneNode(true),
                cpIcon = slOptionIcon.cloneNode(true);
                
                slOptionResult.appendChild(cpSpan);
                slOptionResult.appendChild(cpIcon);  
                inputCode.value = dataCode.shipping;
                el.style.paddingLeft = (dataCode.shipping.length * 16 + 10) + 'px';
            } 
            if(elId === 'contact' && Number(data[i]['country_mobile_code']) ===  Number(dataCode.billing)) {
                const cpSpan = slOptionSpan.cloneNode(true),
                cpIcon = slOptionIcon.cloneNode(true);
                
                slOptionResult.appendChild(cpSpan);
                slOptionResult.appendChild(cpIcon);  
                inputCode.value = dataCode.billing;
                el.style.paddingLeft = (dataCode.billing.length * 16 + 10) + 'px';
            }

            
            slOption.appendChild(slOptionIcon);
            slOption.appendChild(slOptionSpan);
            slOption.appendChild(slOptionNumber);
            sl.appendChild(slOption);
        }

        slOptionResult.appendChild(inputCode);
        slRelativeWrap.appendChild(slOptionResult);
        slRelativeWrap.appendChild(sl);
        slWrap.appendChild(slRelativeWrap);

        el.parentNode.appendChild(slWrap);

    }

    var phoneLimit = 8;

    for (var j = 0; j < checkoutPhones.length; ++j) {
        if (checkoutPhones[j] !== null) {

            // Create Country Code Select
            createMbCtCodeSelect(checkoutPhones[j]);
            checkoutPhones[j].addEventListener('input', function(e) {

                const bpValue = e.target.value,
                    pr = this.parentNode,
                    rs = pr.querySelector('.country_code_result'),
                    num = rs.querySelector('.sl_icon');

                if (num.textContent === '+65') {
                    phoneLimit = 8;
                } else {
                    phoneLimit = 15;
                }
                var temp = '';

                if (isNaN(Number(bpValue))) {
                    for (var i = 0; i < bpValue.length; ++i) {
                        if (!isNaN(Number(bpValue[i]))) {
                            temp += bpValue[i];
                        }
                    }
                    this.value = temp;

                } else {
                    if (bpValue.length >= phoneLimit) {
                        for (var i = 0; i < bpValue.length; ++i) {
                            if (i < phoneLimit) {
                                temp += bpValue[i];
                            }
                        }
                        this.value = temp;
                    }
                }
            });
        }

    }

    const ctMbCodes = document.querySelectorAll('.sl_li');

    for (var i = 0; i < ctMbCodes.length; ++i) {
        const ctMbCode = ctMbCodes[i];
        if (ctMbCode !== null) {
            ctMbCode.addEventListener('click', function() {
                const icon = this.querySelector('.sl_icon'),
                    span = this.querySelector('.sl_span'),
                    number = this.querySelector('.sl_number'),
                    iconSrc = icon.textContent,
                    spanName = span.textContent.replace('+', ''),
                    numberData = number.textContent,
                    parent = this.closest('.country_code_select'),
                    resultBox = parent.querySelector('.country_code_result');

                resultBox.querySelector('.sl_span').textContent = spanName;
                resultBox.querySelector('.sl_icon').textContent = numberData;
                resultBox.querySelector('input[type="hidden"]').value = numberData.replace('+', '');

                const parentWidth = parent.offsetWidth,
                    tel = this.closest('.country_code').querySelector('input'),
                    telVal = tel.value;

                tel.style.paddingLeft = (parentWidth + 3) + 'px';
                if (numberData === '+65' && telVal.length > 8) {
                    tel.value = '';
                }

                this.parentNode.style.display = 'none';
                const self = this;
                setTimeout(function() {
                    self.parentNode.setAttribute('style', '');
                }, 100);

            });
        }
    }

    $(document).on('facetwp-refresh', function() {
        if($('.filterByWrap').length > 0) {
            const $top = $('.filterByWrap').offset().top;
            document.querySelector('html').classList.add('fast-scroll');
            setTimeout(function() {
                window.scroll(0,$top - 200);
                removeImageIfHaveVideo();
            }, 100);
        }

    });

    $(document).on('facetwp-loaded', function() {
        document.querySelector('html').classList.remove('fast-scroll');
        removeImageIfHaveVideo();
    });

    // Hidden Image If Product have video
    function removeImageIfHaveVideo() {
        const wcLoopProductLink = document.querySelectorAll('.woocommerce-LoopProduct-link');

        for(var i = 0; i < wcLoopProductLink.length; ++i) {
            const productVideo = wcLoopProductLink[i].querySelector('.woocommerce-product-gallery'),
                  productImg  = wcLoopProductLink[i].querySelector('.first-gallery-img');

            if(productImg !== null && productVideo !== null) {
                wcLoopProductLink[i].closest('li.product').classList.add('has-video');
                productImg.remove();
                if(productVideo.querySelector('iframe') !== null) {
                    productVideo.querySelector('iframe').style.height = productVideo.offsetWidth + 'px';
                }
                if(productVideo.querySelector('video') !== null) {
                    productVideo.querySelector('video').style.height = productVideo.offsetWidth + 'px';
                }
            }
        }
    }

    removeImageIfHaveVideo();

    window.addEventListener('resize', function() {
        removeImageIfHaveVideo();
    });

    // E-Gift Card Select Type

    $('#purchasing_for').on('change', function() {
        const $value = $(this).val();
        console.log($value)
        if($value === 'for_myself') {
            $('#ywgc-recipient-name').attr("disabled", true);
            $('#ywgc-recipient-email').attr("disabled", true);
        } else {
            $('#ywgc-recipient-name').removeAttr('disabled');
            $('#ywgc-recipient-email').removeAttr('disabled')
        }
    });
    // Book apointment page
    function createEle(tag = null, classes = null) {
        if(tag === null) return;
        const ele = document.createElement(tag);
        if(classes !== '')
            ele.setAttribute('class', classes);
       
        return ele;
    }

    function createCheckboxGrroup(specifyName) {
        const ele = document.querySelectorAll(specifyName);
        if(ele.length <= 0) return;

        for(let k = 0; k < ele.length; k++) {
            // Add Checkbox
            const options = ele[k].querySelectorAll('option'),
                  cbWrap = createEle('div', 'gcb_wrap'),
                  cbClass = 'interested-viewing_cb';
    
            for(var i = 0; i < options.length; ++i) {

                const cb = createEle('input', cbClass),
                      optionValue = options[i].value,
                      optionText = options[i].textContent,
                      cbLabel = createEle('label', 'gcb_label');
                      cbLabelSpan = createEle('span');
    
                cb.setAttribute('value', optionValue);
                cb.setAttribute('type', 'checkbox');
                cb.setAttribute('name', 'gcb_value[]');
                cbLabelSpan.textContent = optionText;
    
    
                cbLabel.appendChild(cb);
                cbLabel.appendChild(cbLabelSpan);
                cbWrap.appendChild(cbLabel);
            }
            ele[k].style.cssText = 'position: absolute;';
            ele[k].classList.add('block-invisible');
            ele[k].parentNode.appendChild(cbWrap);
    
            // Add Checkbox Event
            const cbs = document.querySelectorAll('.'+ cbClass);
            
            for(var i = 0; i < cbs.length; ++i) {
                cbs[i].addEventListener('click', function() {
                    const cbValue = this.value,
                          parent = this.closest('.gcb_wrap'),
                          grandParent = parent.parentNode,
                          selectOptions = grandParent.querySelectorAll('option');
                    if(this.checked) {
                        grandParent.querySelector('option[value="'+cbValue+'"]').selected = true;
                    } else {
                        grandParent.querySelector('option[value="'+cbValue+'"]').selected = false;
                    }
                    ele[k].dispatchEvent(new Event('change'));
    
                })
            }
            ele[k].addEventListener('change', function() {
                const options = this.querySelectorAll('option');
                const checkeds = this.querySelectorAll('option:checked');
                var listVal = [];   
                for(var j = 0; j < checkeds.length; ++j) {
                    const checked = checkeds[j];
                    listVal.push(checked.getAttribute('value'));
                }
    
                for(var j = 0; j < options.length; ++j) {
                    if(listVal.includes(options[j].getAttribute('value'))) {
                        options[j].selected = true;
                    } else {
                        options[j].selected = false;
                    }
                }
    
                for(var j = 0; j < cbs.length; ++j) {
                    if(listVal.includes(cbs[j].value)) {
                        cbs[j].checked = true;
                    } else {
                        cbs[j].checked = false;
                    }
                }
            });
        }
        

    }
    createCheckboxGrroup('#form-field-interest');


    function ctGetCookie(cname) {
        const cookieStr = decodeURIComponent(document.cookie),
              cookieArr = cookieStr.split(';'),
              name = cname + '=';

        for(var i = 0; i < cookieArr.length; i++) {

            var ckie = cookieArr[i];

            if(ckie.charAt(0) == ' ') {
                ckie = ckie.substring(1);
            }

            if(ckie.indexOf(name) == 0) {
                return ckie.substring(name.length, ckie.length);
            }
        }
        return '';
    }

    const popupCookieTime = popupTime,
          popupDisplayDelay = popupDelayTime;


    function refreshPopupAfterHardReload() {
        if(hardReload === 'no-cache') {
            const popups = document.querySelectorAll('.uael-modal-parent-wrapper'); 
            
            popups.forEach(popup => {
                const modal = popup.querySelector('.uael-modal'),
                    popupId = popup.getAttribute('id').replace('-overlay', ''),
                    cName = 'uael-modal-popup-' + popupId,
                    popupHiddenCookie = ctGetCookie(`modal-hidden-time-${popupId}`),
                    popupTrigger = popup.getAttribute('data-trigger-on');

                if(popupTrigger === 'automatic') {
                    document.cookie = `modal-hidden-time-${popupId}=`;
                }

            });
        }
    }
    var ii = 0;
    function checkPopup() {
        const popups = document.querySelectorAll('.uael-modal-parent-wrapper');

        var popupShow = [];

        popups.forEach(popup => {
            const modal = popup.querySelector('.uael-modal'),
                  popupId = popup.getAttribute('id').replace('-overlay', ''),
                  cName = 'uael-modal-popup-' + popupId,
                  popupCookie = ctGetCookie(cName),
                  popupTrigger = popup.getAttribute('data-trigger-on');

            if(popupTrigger === 'automatic' ) {

                const popupClosed = ctGetCookie(`modal-closed-${popupId}`),
                      popupHiddenTime = ctGetCookie(`modal-hidden-time-${popupId}`);

                if(!popupShow.includes(popupId)) {
                    if(popupHiddenTime === '') {
                        popupShow.push(popupId);
                    } else {
                        if((new Date(popupHiddenTime)).getTime() < (new Date()).getTime()) {
                            popupShow.push(popupId);
                        }
                    }
                }
            }

        });
        popupShow.forEach((id, key) => {

            const modal = document.querySelector(`#modal-${id}`);
            
            if(key === (popupShow.length - 1)) {
                setTimeout(function() {
                    modal.classList.add('modal--show');
                    modal.parentNode.querySelector('.uael-overlay').classList.add('overlay--show');
                    document.cookie = `modal-closed-${id}=false;`;

                }, popupDisplayDelay * 1000);
            }

        });

    }

    function popupClose() {
        const closes = document.querySelectorAll('.uael-modal-close');
        
        closes.forEach(button => {
            button.addEventListener('click', function() {
                const parent = this.closest('.uael-modal-parent-wrapper'),
                      id = parent.getAttribute('id').replace('-overlay', '');

                const now = new Date(),
                      time = now.getTime(),
                      expireTime = time + (popupCookieTime * 60 * 60 * 1000);

                document.cookie = `modal-closed-${id}=true;`;
                document.cookie = `modal-hidden-time-${id}=${new Date(expireTime)}; expires=${new Date(expireTime)}`;

                this.closest('.uael-modal').classList.remove('modal--show');
                this.closest('.uael-modal-parent-wrapper').querySelector('.uael-overlay').classList.remove('overlay--show');

            });
        })

        const overlays = document.querySelectorAll('.uael-overlay');

        overlays.forEach(ovelay => {
            ovelay.addEventListener('click', function(e) {
                e.preventDefault();
                const parent = this.closest('.uael-modal-parent-wrapper'),
                      id = parent.getAttribute('id').replace('-overlay', '');

                const now = new Date(),
                      time = now.getTime(),
                      expireTime = time + popupCookieTime * 1000;

                document.cookie = `modal-closed-${id}=true;`;
                document.cookie = `modal-hidden-time-${id}=${new Date(expireTime)}; expires=${new Date(expireTime)}`;

                this.closest('.uael-modal-parent-wrapper').querySelector('.uael-modal').classList.remove('modal--show');
                this.classList.remove('overlay--show');
            });
        });
    }

    setTimeout(function() {
        refreshPopupAfterHardReload();
        checkPopup();
    
        popupClose();
    }, 200);


    // Image Hover Transition
    function createProaductsHoverEffect() {
        const imageWrap = document.querySelectorAll('.astra-shop-thumbnail-wrap');
        for(var i = 0; i < imageWrap.length; ++i) {
            const images = imageWrap[i].querySelectorAll('img');
            imageWrap[i].classList.add(`product-${images.length}-image`);
        }
    }

    createProaductsHoverEffect();

    var touched = false;

    if(window.innerWidth <= 1024) {
        touched = true;
    }
    
    window.addEventListener('resize', function() {
        if(window.innerWidth <= 1024) {
            touched = true;
        }  else {
            touched = false;
        }
    });
    function prdContextMenu(e) {
        e.preventDefault();
    }

    function addMbHoverClass() {
        const prd = document.querySelectorAll('li.product');
        prd.forEach(item => {
            if(window.innerWidth < 768) {
                item.addEventListener('contextmenu', prdContextMenu, false);
            } else {
                item.removeEventListener('contextmenu', prdContextMenu, false);
            }

        });
    }
    window.addEventListener('resize', function() {
        addMbHoverClass();
    });
    function createProaductsHoverEffect() {
        const imageWrap = document.querySelectorAll('.astra-shop-thumbnail-wrap');
        for(var i = 0; i < imageWrap.length; ++i) {
            const images = imageWrap[i].querySelectorAll('img');
            imageWrap[i].classList.add(`product-${images.length}-image`);
        }
    }

    createProaductsHoverEffect();

    var touched = false;

    if(window.innerWidth <= 1024) {
        touched = true;
    }
    
    window.addEventListener('resize', function() {
        if(window.innerWidth <= 1024) {
            touched = true;
        }  else {
            touched = false;
        }

        productListMobileHover();
    });

    function productListMobileHover() {
        const prd = document.querySelectorAll('li.product');
        prd.forEach(item => {

            if(touched) {
                item.classList.add('product-touchend');
            } else {
                item.classList.remove('product-touchend');
            }

            item.addEventListener('touchstart', function(e) {
                touched = true;
                prd.forEach(el => {
                    el.classList.remove('product-touchstart');
                    el.classList.add('product-touchend');
                });
                this.classList.add('product-touchstart');
                this.classList.remove('product-touchend');
                console.log('touchstart' );

            });
            // item.querySelector('.woocommerce-LoopProduct-link').addEventListener('contextmenu', function(e) {
            //     e.preventDefault();
            // });

            item.addEventListener('touchend', function(e) {
                this.classList.remove('product-touchstart');
                this.classList.add('product-touchend');

                console.log('touchend' );
            });

            // item.addEventListener('contextmenu', function(e) {
            //     e.preventDefault();
            // });
            item.addEventListener('click', function(e) {
                if (e.ctrlKey) return;
            }, false);
            item.addEventListener('mouseenter', function() {
                if(!touched) {
                    console.log('mouseenter' + touched );
                    this.classList.remove('product-touchstart');
                    this.classList.remove('product-touchend');
                }
            });
            
        });
        addMbHoverClass();
    }

    productListMobileHover();
    $( document ).ajaxComplete(function( event, xhr, settings ) {
        const regex = /action=filter_diamond_by_att/gm;
        if( m = regex.exec(settings.data) !== null ) {
            productListMobileHover();
        }
    });

    const $store = document.querySelectorAll('.elementor-field-group-store_choose');

    $store.forEach((item, key) => {
        const $typeOfAppoitment = item.parentNode.querySelector('.elementor-field-group-type_choose'),
              $typeOfAppoitmentOptions = $typeOfAppoitment.querySelectorAll('option');
              
        if($typeOfAppoitment === null) {
            item.style.display = 'flex';
        } else {
            if($typeOfAppoitmentOptions[0].getAttribute('value') === "In-Store Consultation") {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        }

    })

    $(document).on('change', '#form-field-type_choose', function(e) {
        const self = this;
        setTimeout(function() {
            if($(self).find(':selected').val() === 'In-Store Consultation') {
                $('.elementor-field-group-store_choose').css({display: 'flex'});
                $('#form-field-store_choose').prop('required', true);
            } else {
                $('.elementor-field-group-store_choose').css({display: 'none'});
                $('#form-field-store_choose').prop('required', false);
            }
        }, 200);

    });


    // Size Guide Click
    $(document).on('click', '.uael-modal-action', function(e) {
        const id = this.getAttribute('data-modal');
        console.log(`modal-${id}`);
        $(`#modal-${id}`).toggleClass('modal--show');
        $(`#modal-${id}`).next().toggleClass('overlay--show');

    })

    $(document).on('click', '.tab-choose', function(e) {
        const tab = $(this).attr('data-tab');
        $('.tab-choose').removeClass('active');
        $(this).addClass('active');
        $('.tab-font').removeClass('active');
        $(`.tab-${tab}`).addClass('active');
    });

    $(document).on('click', '.tab-font > li', function(e) {
        e.preventDefault();
        const font = $(this).attr('data-value'),
              fontFamily = $(this).attr('data-font-family');

        $('.engraving-item--message').addClass('active');
        $('.tab-font > li').removeClass('selected');
        $(this).addClass('selected');
        $('#trigger_pa_font-type').find('option').prop('selected', false);
        $('#trigger_pa_font-type').find(`option[value="${font}"]`).prop('selected', true);
        $('#trigger_pa_font-type').change();
        $('.text-demo').css({
            'font-family': fontFamily,
            'display': 'block'
        });
    });

    function diamondProductPage() {
        var isDiamondPage = $('.single-product.product_diamond');
        if(isDiamondPage) {
            var shape = $('.diamond_pa_shapes').find('.attribute-item-name').text().toLowerCase();
            var metalType = $('#pa_metal-type').val();
            var casing = $('#pa_casing').val();
            var productSlug = $('#product-slug').val();
            var parentProductName = $('#parent-product-name').val();
            // var productThumbnail = $('#product-thumbnail').val();
            
            $('#form-field-diamond_name').val(parentProductName);
            $('#form-field-diamond_slug').val(`${productSlug}?_dianmond_shapes=${shape}&_metal_type=${metalType}&_casing=${casing}&p_id=${$('.variations_form.cart').attr('data-product_id')}`);
            // $('#form-field-diamond_thumbnail').val(productThumbnail);
            variationProduct()
        }
    }
    diamondProductPage();
    $('.variation_item').on('change', function() {
        if($(this).parents('.engraving-variation-row').length === 0) 
            diamondProductPage()
    });

    var diamondEmail = document.getElementById('form-field-diamond_email');
    if(diamondEmail !== null) {
        diamondEmail.addEventListener('input', function() {
            diamondProductPage()
        });
    }

    function variationProduct() {
        const variationDom = $('.variations_form');
        if(variationDom.length <= 0) return;

        const variationData = variationDom.data('product_variations'),
              sizesDom = $('.list_pa_ring-size').find('.item-att'),
              shape = $('select#pa_shapes').val(),
              metaType = $('select#pa_metal-type').val(),
              casing = $('select#pa_casing').val(),
              size = $('select#pa_ring-size').val(),
              diamondType = $('#pa_diamond-type').val();

              
        let sizes = [];

        for(let i = 0; i < variationData.length; i++) {
            const attrs = variationData[i].attributes;
            if( attrs['attribute_pa_casing'] === casing 
            && attrs['attribute_pa_metal-type'] === metaType 
            && attrs['attribute_pa_shapes'] === shape
            && attrs['attribute_pa_ring-size'] === size
            && attrs['attribute_pa_diamond-type'] === diamondType ) {
                $('#form-field-diamond_thumbnail').val(variationData[i].image['full_src']);
            }
        }
    }

    variationProduct();

    $(window).load(function() {
        const options = $('.variation_item.not-empty');
        for(let i = 0; i < options.length; i++) {
            const firstOption = $(options[i]).find('option')[$(options[i]).find('option').length - 1];
            $(firstOption).prop('selected', true);
            $(options[i]).val(firstOption.getAttribute('value')).trigger('change')
        }
    });

    const isAddtocart = $('#is_add_to_cart');
    if(isAddtocart.length > 0) {
        for(let key in JSON.parse(isAddtocart.val())) {
            setTimeout(() => {
                if($(`.item-att[data-slug="${JSON.parse(isAddtocart.val())[key]}"]`).length > 0) {
                    $(`.item-att[data-slug="${JSON.parse(isAddtocart.val())[key]}"]`).click();
                } else {
                    const options = $(`.variation_item`).find('option');
                    options.map(function(index, item) {
                        if(item.getAttribute('value') === JSON.parse(isAddtocart.val())[key]) {
                            item.setAttribute('selected', 'selected');
                            $(item.parentNode).trigger('change');
                        }
                    });
                }

            }, 1000);
        }
    }

    $(document).on('click', '.menu-button > a', function(e) {
        if(['#',''].includes($(this).attr('href'))) {
            $('.to-apoinment').find('a').trigger('click');
        }
    });
    if ($("body.woocommerce-checkout").length) {
        $("#dob").flatpickr({
            dateFormat: 'm/d/Y'
        });
    }

});