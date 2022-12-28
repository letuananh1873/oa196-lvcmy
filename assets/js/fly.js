jQuery(document).ready(function ($) {

					

                //Filter Mobile Size Control
                filter_resize_control();
                function filter_resize_control(){
                    calculate_width();
                    $( window ).resize(function() {
                        calculate_width();
                    });
                }



                function calculate_width(){
                    var totalWidth = 5;
                    if ($(window).width() < 768) {
                        $('div.adv_single_container:visible:not(".needhelp")').each(function(index) {
                            totalWidth += parseFloat($(this).outerWidth(true));
                        });
    
                        $('#filter-container').css({
                            'width': totalWidth
                        });
                    }else{
                        $('#filter-container').css({
                            'width': 'auto'
                        });
                    }
                }











                //Range Slider Input Field
                $('.slider-range-input input').focus(function() {
                   $(this).val( toNumber( $(this).val() )  ).attr('type','number');
                   
                }).blur(function(){
                    var currentvalue = parseFloat($(this).val());
                    var targetvalueMin = parseFloat($(this).attr('min'));
                    var targetvalueMax = parseFloat($(this).attr('max'));
                    var priceFlag = 0;

                    //if is Price 
                    if( $(this).parents('.input-for-price').length ){
                        priceFlag = 1;
                    }

                    var theInput = (priceFlag) ? $(this).attr('type','text') : $(this).attr('type','number');
                    
                    if( $(this).parent('.label-min').length  ){

                        if( currentvalue < targetvalueMin || currentvalue > targetvalueMax || !currentvalue ){
                            (priceFlag) ? theInput.val( "$" + addCommas( targetvalueMin ) ) : theInput.val( targetvalueMin );
                        }else{
                            (priceFlag) ? theInput.val( "$" + addCommas( currentvalue ) ) : theInput.val( currentvalue );
                        }
                       
                    }else if( $(this).parent('.label-max').length  ){
                        
                        if( currentvalue > targetvalueMax || currentvalue < targetvalueMin || !currentvalue ){
                            (priceFlag) ? theInput.val( "$" + addCommas( targetvalueMax ) ) : theInput.val( targetvalueMin );
                        }else{
                            (priceFlag) ? theInput.val( "$" + addCommas( currentvalue ) ) : theInput.val( currentvalue );
                        }

                    }

                });

                


                //Show Loader
                function showLoader(){
                    $('.loader-wrapper').show();
                }
                //Hide Loader
                function hideLoader(){
                    $('.loader-wrapper').hide();
                    calculate_width();
                }














                    //Filter Start
                    var $container = $('#filter-container'),
                        filters = {},
                        comboFilter;






                    //Reset
                    $(document).on('click','.resetfilter',function(e){
                        e.preventDefault();

                        // //refresh isotope
                        filters = {};
                        comboFilter = getComboFilter(filters);
                        $container.isotope({
                            filter: multipleFilter
                        });

                        //reset checkboxes
                        $('#sidebar-filter input[type=checkbox]').removeAttr('checked').trigger('change');


                        //reset range slider + min / max value
                        $('.slider-range').each(function() {
                            var parentEle = $(this).parent(),
                                min = parentEle.find('.label-min input').attr('min'),
                                max = parentEle.find('.label-max input').attr('max');

                            parentEle.find('.label-min input').val(min).attr('price-extra-min',min);
                            parentEle.find('.label-max input').val(max).attr('price-extra-max',max);

                            parentEle.find('.ui-slider').slider( "values", 0, min );
                            parentEle.find('.ui-slider').slider( "values", 1, max );
                        });
                       

                        // reset price format
                        $('.input-for-price input').each(function() {
                            $(this).val("$" + addCommas($(this).val()) );
                        });
                       

                        
                    });







                    
                    function hide3after(){
                        //Hide 3 after
                        $('.adv_single_container').removeClass('display3 hide3');
                        var total_items = $('.adv_single_container:visible').length;
                        for(var ite = 0; ite < total_items; ite++ ){
                            if(ite < 3){
                                // console.log('index '+ite);
                                // console.log('if '+$('.adv_single_container:not(".needhelp"):visible').eq(ite).attr('data-to-pop'));
                                $('.adv_single_container:not(".needhelp"):visible').eq(ite).addClass('display3');
                                
                            }else{
                                // console.log('index '+ite);
                                // console.log('else '+$('.adv_single_container:not(".needhelp"):visible').eq(3).attr('data-to-pop'));
                                $('.adv_single_container:not(".needhelp"):visible').eq(3).addClass('hide3');
                            }
                        }
                        $container.isotope('layout');
                    }
                                               




                    //Clear Empty Result Div
                    function clearEmptyResult(){
                        $('#myfilter-adv .class-noresult').remove();
                    }













                    //Isotope Declare
                    if($container.length){
                        $container.isotope({
                            itemSelector: '.adv_single_container',
                            layoutMode: 'packery',
                            transitionDuration: 0,
                            packery: {
                                gutter: '.adv-sidebar-gutter',
                            },
                            filter: multipleFilter
                        });
                        hide3after();
                    }












                    //If empty
                    $container.on( 'arrangeComplete', function( event, filteredItems ) {
                        clearEmptyResult();
                        var resultCount = filteredItems.length;
                        
                        if(resultCount <= 1) {
                            $container.hide();
                            $('#filter-noresult .class-noresult').clone().insertAfter($container);
                        }


                    });













                    // do stuff when checkbox change
                    // $('#sidebar-filter').on('change', function (jQEvent) {
                    //     clearEmptyResult();
                    //     $container.show();

                    //     //slight loader duration
                    //     showLoader();
                    //     setTimeout(function(){

                    //         var $checkbox = $(jQEvent.target);
                    //         manageCheckbox($checkbox);
                    //         comboFilter = getComboFilter(filters);
                    //         console.log(comboFilter)
                    //         $container.isotope({
                    //             filter: multipleFilter
                    //         });

                            
                    //         hide3after();
                    //         hideLoader();
                    //     },1000); // 0.3sec

                    // });
                    





                    


                    function multipleFilter() {
                        var that = this;

                        function checkCarat() {
                            var carat = parseFloat($(that).find('.attr_carats').attr('data-attr-carats')),
                            caratMin = parseFloat($('#carats-min').val()),
                            caratMax = parseFloat($('#carats-max').val());

                            return carat >= caratMin && carat <= caratMax;
                        }

                        function checkPrice() {
                            var price = parseFloat($(that).find('.adv_single_price').attr('data-attr-price')),
                            priceMin = parseFloat($('#price-min').attr('price-extra-min')),
                            priceMax = parseFloat($('#price-max').attr('price-extra-max'));

                            return price >= priceMin && price <= priceMax;
                        }

                       

                        function needhelp(){
                            var data_attr_all = $(that).find('.needhelp-attr').attr('data-attr-all')
                            return data_attr_all;
                        }
                        
                        return checkCarat() && checkPrice() && $(this).is(comboFilter || '*') || needhelp();
                    }

















                    function getComboFilter(filters) {
                        var i = 0;
                        var comboFilters = [];
                        var message = [];
                        for (var prop in filters) {
                            message.push(filters[prop].join(' '));
                            var filterGroup = filters[prop];
                            // skip to next filter group if it doesn't have any values
                            if (!filterGroup.length) {
                                continue;
                            }
                            if (i === 0) {
                                // copy to new array
                                comboFilters = filterGroup.slice(0);
                            } else {
                                var filterSelectors = [];
                                // copy to fresh array
                                var groupCombo = comboFilters.slice(0); // [ A, B ]
                                // merge filter Groups
                                for (var k = 0, len3 = filterGroup.length; k < len3; k++) {
                                    for (var j = 0, len2 = groupCombo.length; j < len2; j++) {
                                        filterSelectors.push(groupCombo[j] + filterGroup[k]); // [ 1, 2 ]
                                    }
                                }
                                // apply filter selectors to combo filters for next group
                                comboFilters = filterSelectors;
                            }
                            i++;
                        }
                        var comboFilter = comboFilters.join(', ');
                        return comboFilter;
                    }












                    function manageCheckbox($checkbox) {
                        var checkbox = $checkbox[0];
                        var group = $checkbox.parents('.adv-sidebar-container').attr('data-group');
                        // create array for filter group, if not there yet
                        var filterGroup = filters[group];
                        if (!filterGroup) {
                            filterGroup = filters[group] = [];
                        }
                        var isAll = $checkbox.hasClass('all');
                        // reset filter group if the all box was checked
                        if (isAll) {
                            delete filters[group];
                            if (!checkbox.checked) {
                                checkbox.checked = 'checked';
                            }
                        }
                        // index of
                        var index = $.inArray(checkbox.value, filterGroup);
                        if (checkbox.checked) {
                            var selector = isAll ? 'input' : 'input.all';
                            $checkbox.siblings(selector).removeAttr('checked');
                            if (!isAll && index === -1) {
                                // add filter to group
                                filters[group].push(checkbox.value);
                            }
                        } else if (!isAll) {
                            // remove filter from group
                            filters[group].splice(index, 1);
                            // if unchecked the last box, check the all
                            if (!$checkbox.siblings('[checked]').length) {
                                $checkbox.siblings('input.all').attr('checked', 'checked');
                            }
                        }
                    }

                    // Filter End






















});