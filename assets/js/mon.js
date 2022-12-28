jQuery(document).ready(function($) {

    /*Header Jet Menu*/ 
    $("li.jet-menu-item-has-children").hover(function () {
        $(this).children(".jet-sub-mega-menu").stop(true,true).fadeIn("fast");
    },function(){
        $(this).children(".jet-sub-mega-menu").fadeOut("fast");
    });

    /*SP Header Nav Menu*/
    $("ul#menu-main-header-menu-sp li.menu-item-has-children > a").click(function(){
      $(this).toggleClass("active");
      $(this).next("ul.sub-menu").slideToggle();
      return false;
    });

    /*Header Search dropdown*/
    $(".header-search-btn, .header-search-btn a").click(function(){
      $(".search-drop-box").prependTo("section#header-box > .elementor-container");
      $(".search-drop-box").slideToggle("fast").toggleClass("active");
      return false;
    });
    $(".search_dropdown_close_btn").click(function(){
      $(".search-drop-box").slideUp("fast").removeClass("active");
      return false;
    });


    /* add class name to footer menu */
    if( $("a:contains('Delivery & Shipping Policy')") ) {
		$("a:contains('Delivery & Shipping Policy')").addClass("deliveryPolicy");
    }
    if( $("a:contains('Financing Options')") ) {
		$("a:contains('Financing Options')").addClass("financingOptions");
    }
    
    $(".deliveryPolicy , .financingOptions").click(function(e){
        e.preventDefault();
    });

    //Education Side Menu Toggle 
    $("#menu-education > li.menu-item-has-children > a").click(function(e){
      $(this).parent("li").toggleClass("active");
      $(this).next("ul.sub-menu").slideToggle();
      e.preventDefault();
    });

    //Product detail page
    $(".review-form-button a").click(function(){
      $(this).parent().next("#review_form_wrapper").slideToggle();
    });
    // $('table.variations label[for="pa_size"]').append(' (<div class="size-guide-include"></div>)');
    $(".size-guide-wrap").appendTo(".size-guide-include");

    
    //my account page (change contribution to review)
    $("li.woocommerce-MyAccount-navigation-link.woocommerce-MyAccount-navigation-link--contributions a").text("Reviews");
    $("th.contributions-product > span").text("Reviews for");
    

    //Footer
    var spWidth = 767;
    if (spWidth >= $(window).width()) {
        $("#loveco-aboutus-title").click(function(){
          $(this).toggleClass("active");
          $("#loveco-aboutus-menu").slideToggle();
        });
        $("#loveco-terms-of-use-title").click(function(){
          $(this).toggleClass("active");
          $("#loveco-terms-of-use-menu").slideToggle();
        });
    }

    /*select option design change*/
    $(".elementor-field.elementor-select-wrapper select").not('#form-field-interest').selectize();
   
    $("select.orderby").selectize();

    $("select.facetwp-sort-select").selectize();
    $(document).on('facetwp-refresh', function() {
      setTimeout(function() { 
        $("select.facetwp-sort-select").selectize();
      }, 2000);
    });

    $(document).on('facetwp-refresh', function() {
      setTimeout(function() { 
        $("form.woocommerce-ordering select.orderby").selectize();
      }, 6000);
    });

    //Do not remove this(or we cannot add to cart for the products)
    // setTimeout(function() { 
    //    $("td.value select").selectize();
    // }, 2000);


    //Blog category changes
    $('a.elementor-post-info__terms-list-item:contains("All")').each(function(){
        $(this).remove();
    });
    var blog_cate_list = $('.elementor-element-07be411 span.elementor-post-info__terms-list:first-child').text();
    blog_cate_list = blog_cate_list.replace(',', ' ');
    $('.elementor-element-07be411 span.elementor-post-info__terms-list:first-child').text(blog_cate_list);


    //booking form page's booking form auto popup  edit by emma
    if ($("body#make-appointment").length) {
        //add modal popup for booking form when we click every booking button
        $("#make-appointment .elementor-2976").html('');

        /*var urlParams = window.location.search;
        if (urlParams == '?appointment') {
            scroll_to_apoiment();
        }*/

        function scroll_to_apoiment() {
            var h_header = parseInt($('.elementor-location-header').outerHeight());
            var offsettop = $(".loveco-bookingForm").offset().top;
            offsettop = offsettop - h_header ;
            if ($(window).width() < 768 ) {
                offsettop = offsettop + 100  ;
            }

            jQuery('html, body').animate({
                scrollTop: offsettop
            }, 'slow');
        }
        $(".call-booking-form a.elementor-button, .call-booking-form a").click(function(e) {
            e.preventDefault();
            scroll_to_apoiment();
        });

        $(window).load(function() {
            if ($(".to-apoinment").length) {
                $(".to-apoinment .elementor-button").click(function() {
                    scroll_to_apoiment();
                });
            }
            //$("#modal-68e5e4a").addClass("uael-show");
        });
    } else {
        /*if ($(".to-apoinment").length) {
            $(".to-apoinment .elementor-button").click(function() {
                window.location.href = "https://oanglelab.com/testlvc/make-appointment?appointment";
            });
        }*/
    }
    $(document).on('click', ".call-booking-form a.elementor-button, .call-booking-form a", function() {
        if( $(this).attr('href') === '#' || typeof $(this).attr('href') == "undefined") {
          $(this).data("href", $(this).attr("href")).removeAttr("href");
          $("#modal-68e5e4a").addClass("uael-show");
        }

    });

    if ($(".announcments").length) {
        $('.announcments').slick({
            autoplay: true,
            autoplaySpeed: 5000,
            dots: false,
           // autoplay: false,
            prevArrow: "<div type='button' class='slick-prev slick-arrow arrow-left'></div>",
            nextArrow: "<div type='button' class=' slick-next slick-arrow arrow-right'></div>",
            responsive: [
                {
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
    // end edit by emma

    //booking form calendar's mindate setup to Today

    setTimeout(function() {
        var mindate = 'today';
        if ($("#consulation_minday").length) {
            mindate = $("#consulation_minday").val();

        }


        flatpickr("input#form-field-select_day", {

            locale: {

                firstDayOfWeek: 1

            },
            minDate: new Date().fp_incr(mindate)

        });

    }, 4000);

    $(document).on("change", ".shipping_method", function() {
        var value = $(this).val();
        if (value != 'local_pickup:8') {
            $(".wrapper-stores").removeClass("active");
        } else {
            $(".wrapper-stores").addClass("active");
        }
        console.log(value);


    });
    if ($(".next_step_arrow").length) {
        $(".next_step_arrow img").click(function(){
            //$(this).parent().next().addClass("abc");
        var offset = $(this).parent().next().offset().top;
        $('html, body').animate({
            scrollTop: offset + 20
        }, 200);
    });
    }

    


    
    

});



