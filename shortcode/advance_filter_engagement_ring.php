<!-- Range Slider Jquery cdn -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 


<!-- Filter -->
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/packery-mode.pkgd.min.js"></script>

<!-- Loader -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.5.3/lottie.js"></script>


<div class="loader-wrapper">
    <div id="loader"></div>
</div>

<div id="myfilter-adv">


<?php 

/*
Predefine Varaibles for Products
*/

global $product; //main product object


$filter_main_display = get_field('filter_main_display');
$similar_product_selection = get_field('similar_product_selection');
$enable_advanced_filter = get_field('enable_advanced_filter');
$share_image = 0; // to use same product image of main display;
$results = array();
$attr_filter = array();
$currentProductPage = get_the_permalink($product->get_id());




/*
Restructure Varaibles
*/
if($filter_main_display){

    if( $similar_product_selection ):
        
        foreach( $similar_product_selection as $key=>$sps_product ):
             
                // $i++;
                // if($i==4) break;


            //product image
            $share_image_link = '';
            if($share_image){
                $share_image_link = get_the_post_thumbnail_url( $product->get_id() );
            }else{
                $share_image_link = get_the_post_thumbnail_url( $sps_product->ID );
            }



            //attributes cut
            // $attr_filter['cut'] = array("Excellent","VG – EX");
            $product_cut = get_field('attribute_cut',$sps_product->ID);
            if(!in_array($product_cut->name, $attr_filter['cut'])){
                $attr_filter['cut'][$key] = $product_cut->name;
            }

            //attributes carats
            $product_carats = get_field('attribute_carats',$sps_product->ID);
            $attr_filter['carats'][$key] = $product_carats;


            //attributes color
             $product_color = get_field('attribute_color',$sps_product->ID);
             if(!in_array($product_color->name, $attr_filter['color'])){
                $attr_filter['color'][$key] = $product_color->name;
            }


            //attributes clarity
            $attr_filter['clarity'] = array("FL/IF","VVS1", "VVS2", "VS1", "VS2", "SI1","SI");
            $product_claritys = get_field('attribute_clarity',$sps_product->ID);
            /*echo '<div class="abc" style="display:none:">';
            echo '</div>';
            if (isset($_GET['abc'])) {
                var_dump( $product_clarity->name);
            }*/
           // 
            if(!in_array($product_clarity->name, $attr_filter['clarity'])){
                $attr_filter['clarity'][$key] = $product_clarity->name;
            }


            //convert to woocommerce product obj
            $product_obj = wc_get_product( $sps_product->ID );
            $product_price = $product_obj->get_price();
            $product_price_html = $product_obj->get_price_html();
            $attr_filter['price'][$key] = $product_price;


            //reassign to array
            $results[$key] = array(
                'product_id' => $sps_product->ID,
                'product_image' => $share_image_link,
                'product_price' => $product_price,
                'product_price_html' => $product_price_html,
                'product_carats' => $product_carats,
                'product_color' => $product_color,
                'product_clarity' => $product_clarity,
                'product_cut' => $product_cut,
            );


        endforeach;

    endif;

}







/*
Echo Restructure Sidebar to HTML
*/
if(!empty($attr_filter)){
    // echo '<div style="display:none;">';
    // debug($attr_filter);
    // echo '</div>';

    echo '<div id="sidebar-filter" class="adv-sidebar-wrapper"></p>';


    foreach($attr_filter as $key=>$filter){

        if($key == 'cut'){
            $learnmore = '<a class="learnmore" target="_blank" href="' . site_url() . '/education-center/diamond-knowledges-the-4cs/cut/">Learn more</a>';
        }
        if($key == 'carats'){
            $learnmore = '<a class="learnmore" target="_blank" href="' . site_url() . '/education-center/diamond-knowledges-the-4cs/carat/">Learn more</a>';
        }
        if($key == 'price'){
            $learnmore = '';
        }
        if($key == 'clarity'){
            $learnmore = '<a class="learnmore" target="_blank" href="' . site_url() . '/education-center/diamond-knowledges-the-4cs/clarity/">Learn more</a>';
        }
        if($key == 'color'){
            $learnmore = '<a class="learnmore" target="_blank" href="' . site_url() . '/education-center/diamond-knowledges-the-4cs/color/">Learn more</a>';
        }

        echo '<div class="adv-sidebar-container" data-group="'.$key.'">';


            echo    '<div class="sidebar-title">'.$key.$learnmore.' </div>';



        //Cut 
        if($key == 'cut'){

            foreach($filter as $value){

                $sanitized_value = sanitize_title($value);


                echo    '<div class="sidebar-filter filter-cut">
                            <input type="checkbox" value=".data_attr_'.$key.'_'.$sanitized_value.'" id="data_attr_'.$key.'_'.$sanitized_value.'" />
                            <label for="data_attr_'.$key.'_'.$sanitized_value.'">'.$value.'</label>
                        </div>';

            }        
        }





        //min max range - Carats and Price
        if($key == 'carats' || $key == 'price'){
            
            $min = min($filter); 
            $max = max($filter); 

            $presetmin = $min;
            $presetmax = $max;

            // $presetmin = $max * 80 / 100;
            // $presetmax = $max * 95 / 100;

            if($key == 'carats'){
                $inputformat = 'number';
                $step = '0.01';
                $currencyLabel = '';
            }

            if($key == 'price'){
                $inputformat = 'text';
                $step = '100';
                $currencyLabel = 'RM ';
            }

            ?>


            <div class="slider-range">
                <span class="min-range">Min</span>
                <span class="max-range">Max</span>
                <div id="range-for-<?php echo $key; ?>"></div>
            </div>



            <div class="slider-range-input input-for-<?php echo $key; ?>">


                <div class="slider-range-input-label label-min">
                    <label for="<?php echo $key; ?>-min"><?php echo $currencyLabel; ?>Min</label>
                    <input type="<?php echo $inputformat; ?>" step="<?php echo $step ; ?>" id="<?php echo $key; ?>-min" value="<?php echo $min; ?>" min="<?php echo $min; ?>" max="<?php echo $max; ?>" price-extra-min="<?php echo $min; ?>">


                </div>


                <p class="">to</p>


                <div class="slider-range-input-label label-max">
                    <label for="<?php echo $key; ?>-max" class=""><?php echo $currencyLabel; ?>Max</label>
                    <input type="<?php echo $inputformat; ?>" step="<?php echo $step ; ?>" id="<?php echo $key; ?>-max" class="" value="<?php echo $max; ?>" max="<?php echo $max; ?>" min="<?php echo $min; ?>" price-extra-max="<?php echo $max; ?>">
                </div>


            </div>

 

            <script>
                jQuery(document).ready(function ($) {
                    <?php if($key == 'price'): ?>
                        $( "#range-for-<?php echo $key; ?>" ).slider({
                                range: true,
                                min: <?php echo $min; ?>,
                                max: <?php echo $max; ?>,
                                values: [ <?php echo $presetmin; ?>, <?php echo $presetmax; ?> ],
                                step: 1,
                                    stop: function( event, ui ) {
                                        $( "#<?php echo $key; ?>-min" ).attr("price-extra-min",ui.values[0]);
                                        $( "#<?php echo $key; ?>-max" ).attr("price-extra-max",ui.values[1]);
                                        $( "#<?php echo $key; ?>-min" ).val( "$" + addCommas(ui.values[0].toString()) ).trigger("change");
                                        $( "#<?php echo $key; ?>-max" ).val( "$" + addCommas(ui.values[1].toString()) ).trigger("change");
                                    }
                            });

                            $( "#<?php echo $key; ?>-min" ).val( "" + addCommas( $( "#range-for-<?php echo $key; ?>" ).slider( "values", 0 ) ) );
                            $( "#<?php echo $key; ?>-max" ).val( "" + addCommas( $( "#range-for-<?php echo $key; ?>" ).slider( "values", 1 ) ) );
                            

                    <?php else: ?>
                        $( "#range-for-<?php echo $key; ?>" ).slider({
                                range: true,
                                min: <?php echo $min; ?>,
                                max: <?php echo $max ?>,
                                values: [ <?php echo $presetmin; ?>, <?php echo $presetmax; ?> ],
                                step: <?php echo $step; ?>,
                                    stop: function( event, ui ) {
                                        $( "#<?php echo $key; ?>-min" ).val( ui.values[ 0 ] ).trigger("change");
                                        $( "#<?php echo $key; ?>-max" ).val( ui.values[ 1 ] ).trigger("change");
                                    }
                            });

                            $( "#<?php echo $key; ?>-min" ).val( $( "#range-for-<?php echo $key; ?>" ).slider( "values", 0 ) );
                            $( "#<?php echo $key; ?>-max" ).val( $( "#range-for-<?php echo $key; ?>" ).slider( "values", 1 ) );


                    <?php endif; ?>

                        //Bound to Input - share to all slider range
                        $("body").on("keyup", "#<?php echo $key; ?>-min", function() {
                            $(this).attr("price-extra-min",toNumber( $(this).val() ) );
                            $( "#range-for-<?php echo $key; ?>" ).slider( "values", 0, toNumber( $(this).val() ) );
                        });
                        $("body").on("keyup", "#<?php echo $key; ?>-max", function() {
                            $(this).attr("price-extra-max",toNumber( $(this).val() ) );
                            $( "#range-for-<?php echo $key; ?>" ).slider( "values", 1, toNumber( $(this).val() ) );
                        });  


                });
            </script>


        <?php
        }


        //Color and Clarity
        if($key == 'color' || $key == 'clarity'){

            echo '<div class="filter-standard-checkbox-wrapper">';
            $break_count = 1;

            if($key == 'color' ){
                sort($filter);
            }

            // if($key == 'clarity' ){
            //     sort($filter);
            // }
            

            // sort($filter);
            foreach($filter as $value){

                if( $break_count%4 == 0 ){
                    $noborder = 'noborder';
                }else{
                    $noborder = '';
                }

                $sanitized_value = sanitize_title($value);

                echo    '<div class="sidebar-filter filter-standard-checkbox '.$noborder.'">
                            <input type="checkbox" value=".data_attr_'.$key.'_'.$sanitized_value.'" id="data_attr_'.$key.'_'.$sanitized_value.'" />
                            <label for="data_attr_'.$key.'_'.$sanitized_value.'">'.$value.'</label>
                        </div>';


                if( $break_count%4 == 0 ){
                    echo '<div class="sidebar-filter filter-standard-checkbox breakclass"></div>';
                }        


                $break_count++;
            }
            echo '</div>';

        }




        echo '</div>'; //adv-sidebar-container

    }


    echo '</div>'; //adv-sidebar-wrapper


}




/*
Echo Restructure Varaibles to HTML
*/





if(!empty($results)){

    //Sort Result to by lowest Price
    usort($results, function($a, $b) {
        return $a['product_price'] <=> $b['product_price'];
    });

    echo '<div class="filter-container-outter">';
    echo '<div class="re-container-result-title">Results</div>';
    echo '<div id="filter-container" class="adv-wrapper">';
        // echo '<div class="adv-sidebar-sizer"></div>';
        echo '<div class="adv-sidebar-gutter"></div>';


    foreach($results as $result){
        $colorname = $result['product_color']->name;
                
                //3799,3913,3917,4087,4088,4249,4250
                // $test = array(4250);
                // if( !in_array($result['product_id'], $test) ) continue;
                
        ?>
        <div class="adv_single_container 
            data_attr_color_<?php echo sanitize_title($result['product_color']->name); ?>
            data_attr_cut_<?php echo sanitize_title($result['product_cut']->name); ?>
            data_attr_clarity_<?php echo sanitize_title($result['product_clarity']->name); ?>" data-to-pop="<?php echo $result['product_id']; ?>">


            <a href="#"><div class="pruchase-online">Purchase Online</div></a>
            

            <div class="adv_single_img"><a href="#"><img src="<?php echo $result['product_image'] ?>" alt=""></a></div>

            <div class="adv_single_price" data-attr-price="<?php echo $result['product_price'] ?>">


                <?php echo $result['product_price_html'] ?></div>


            <div class="adv_single_attr_container">


                <div class="attr_wrapper_single">
                    <div class="attr_carats attr_value" data-attr-carats="<?php echo $result['product_carats'] ?>">
                        <?php echo $result['product_carats'] ?>
                    </div>
                    <div class="attr_label">Carats</div>
                </div>
                



                <div class="attr_wrapper_single">
                    <div class="attr_color attr_value">
                        <?php echo $result['product_color']->name; ?>
                    </div>
                    <div class="attr_label">Color</div>
                </div>
                

 <?php 
 $child_p_id = $result['product_id'];
                            $clarities = get_field('attribute_clarity',$child_p_id)??array();
                            /*if (isset($_GET['abcd'])) {
                                var_dump($clarities);
                            }*/
                            $clarities_str = array();
                            if (is_array($clarities) && count($clarities) > 0) {
                                foreach ($clarities as $key => $item) {
                                    $clarities_str[] = $item->name;
                                }
                            }
                            if (count($clarities_str) > 0):
                        ?>

                <div class="attr_wrapper_single">
                    <div class="attr_clarity attr_value">
                       
                        <?php echo implode(",",$clarities_str ); ?>
                    </div>
                    <div class="attr_label">Clarity</div>
                </div>
            <?php endif; ?>
                


                            <?php 
                           $product_cuts = get_field('attribute_cut',$child_p_id);
                            $cts_str = array();
                            if (is_array($clarproduct_cutsities) && count($product_cuts) > 0) {
                                foreach ($product_cuts as $key => $item) {
                                    $cts_str[] = $item->name;
                                }
                            }
                            if (count($cts_str) > 0) :
                        ?> 
                <div class="attr_wrapper_single">
                    <div class="attr_cut attr_value">
                    <?php echo implode(",",$cts_str ); ?>
                </div>
                    <div class="attr_label">Cut</div>
                </div>
            <?php endif; ?>
                


            </div> <!-- adv_single_attr_container -->
            

        </div><!-- adv_single_container -->



    <?php
    }
        echo '<div class="adv_single_container needhelp">
                <div class="needhelp-attr" data-attr-all="1">
                    <p>Need help?</p>
                    <div class="call-booking-form"><a href="#"><b>Schedule an appointment now!</b></a></div>
                </div>
            </div>';

        echo '</div>'; //-adv-wrapper
    echo '</div>'; //-filter-container-outer


    echo '<div class="mobileneedhelp needhelp">
            <div class="needhelp-attr" data-attr-all="1">
                <p>Need help?</p>
                <div class="call-booking-form"><a href="#"><b>Schedule an appointment now!</b></a></div>
            </div>
        </div>';

}else{
    echo 'no result found';
}








?>

</div><!-- myfilter-adv -->





<!-- No Result -->
<div id="filter-noresult" class="noresult">
    <div class="class-noresult">
        <h3>There are no diamonds with your last filter criteria. Please remove your last filter or restart.</h3>
        <a class="learnmore resetfilter" href="#">Reset Filters</a>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/noresult.jpg" alt="">
    </div>
</div>




<?php
// <!-- Slide UP section -->

if(!empty($results)){
    $terms = wp_get_post_terms( $product->get_id(), 'product_cat', array( 'fields' => 'ids' ) );
    $style = "";
if ('hidden' === $product->get_catalog_visibility() && count($results) === 1 && in_array(123, $terms)) {
    $style = "show";
}
    foreach($results as $result){
        ?> 
        <div class="filter_popup_wrap <?php echo $style; ?>" style=""  data-product-pop="<?php echo $result['product_id']; ?>">
            
            <div class="filter_popup_inner">
                <div class="modal__close"><img src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/icon-close.svg'></div>
                <div class="filter_item_popup">
                    <div class="filter_left_box">
                        <div class="filter_item_image_slider">
                            <div><img src="<?php echo $result['product_image'] ?>" alt=""></div>
                            <?php 
                            //mon edit here
                            $pObject = wc_get_product( $result['product_id'] );
                            $gallery_images = $pObject->get_gallery_image_ids();
                            foreach( $gallery_images as $images ) 
                                {
                                    // Display the image URL
                                    $images_url = wp_get_attachment_url( $images );
                                    echo '<div><image src="' . $images_url . '"></div>';
                                }
                            ?>
                        </div>

                        <h2 class="filter_item_title"><?php echo get_the_title($result['product_id']); ?></h2>

                        <!-- <div class="filter_item_style">Style #123456</div> -->
                        <?php if( get_field('diamond_certificate_url' , $result['product_id']) ) { ?>
                        <div class="filter_item_certificate">
                            <img src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/diamond-icon.svg?v=1'>
                            <a href="<?php the_field('diamond_certificate_url', $result['product_id'])?>" target="_blank">Love & Co. Diamond Certificate</a>
                            <span class="about_certificate"><img src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/icon-question.svg' ></span>
                        </div>
                        <?php } else { ?>

                        <?php } ?>
                        
                        <ul class="filter_item_attr">
                            <li>
                                <div class="item_attr_value filter_item_carat_value"><?php echo $result['product_carats'] ?></div>
                                <div class="item_attr_label">Carat</div>
                            </li>
                            <li>
                                <div class="item_attr_value filter_item_carat_value"><?php echo $result['product_color']->name; ?></div>
                                <div class="item_attr_label">Color</div>
                            </li>
                           <?php if (count($clarities_str) > 0): ?>
                            <li>
                                <div class="item_attr_value filter_item_carat_value">
                                   <?php echo implode(",",$clarities_str ); ?>
                                        
                                    </div>
                                <div class="item_attr_label">Clarity</div>
                            </li>
                        <?php endif; ?>
                        <?php if (count($cts_str) > 0) : ?>
                            <li>
                                <div class="item_attr_value filter_item_carat_value">
                                   <?php echo implode(",",$cts_str ); ?>
                                        
                                    </div>
                                <div class="item_attr_label">Cut</div>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <div class="filter_right_box">
                        <h2 class="filter_right_bigTitle">Beautiful choice!</h2>

                        <?php
                        //whishlist
                          echo do_shortcode('[yith_wcwl_add_to_wishlist product_id="'.$result['product_id'].'"]'); 
                        ?>
                        
                        <div class="filter_item_desc"><?php echo do_shortcode( '[elementor-template id="13942"]' ); ?></div>
                        <div class="need_help">
                            <p>Need help?</p>
                            <div class="booking_form_btn">
                                <a href="<?php echo site_url(); ?>/make-appointment/">
                                    <img src="<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/icon-store-book.svg">Book an Appointment
                                </a>
                            </div>
                        </div>

                        <?php 
                            //add to cart variation
                          echo do_shortcode('[add_to_cart_form id='.$result['product_id'].']');  
                        ?>
                        
                        <!-- <div class="filter_popup_cart_wrap">
                            <a href="<?php echo $currentProductPage; ?>/?add-to-cart=<?php echo $result['product_id'] ?>&quantity=1">
                                <div class="filter_item_price"><?php echo $result['product_price_html'] ?></div>
                                <div class="filter_popup_cart_btn">Add to Bag</div>
                            </a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>





<script>

    function addCommas(nStr){
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
        return x1 + x2;
    }

    function toNumber(nStr){
        return Number(nStr.replace(/[^0-9.-]+/g,""));
    }

jQuery(document).ready(function ($) {

        //Loader
        var animation = bodymovin.loadAnimation({
        container: document.getElementById('loader'),
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: '<?php echo get_template_directory_uri(); ?>/assets/js/loader.json'
        })
        


        //product images slider inside filter popup
        $('.filter_item_image_slider').slick({
            autoplay: false,
            dots: false,
            prevArrow:"<div class='slider_arrows prev' ><img src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/arrow-left.svg'></div>",
            nextArrow:"<div class='slider_arrows next' ><img src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/arrow-right.svg'></div>",
            swipeToSlide: true
        });

        



        //Slide Pop up
        var scrollPos;
        $( window ).resize(function() {
            var headerHeight = $("#header-box").outerHeight();
            var windowHeight =  $(window).height();
            var boxHeight = windowHeight - headerHeight;
            $('.filter_popup_wrap').height(boxHeight);
        });
      
        $('.adv_single_container:not(.needhelp) ').click(function() {
            var headerHeight = $("#header-box").height();
            var windowHeight =  $(window).height();
            var boxHeight = windowHeight - headerHeight;

            var product_id = $(this).attr('data-to-pop');
            var that = $('.filter_popup_wrap[data-product-pop='+product_id+']');
            scrollPos = $(window).scrollTop();
            that.height(boxHeight);
            that.slideToggle("slow");
            $('body').addClass('fixed').css({ top: -scrollPos });

            $('.filter_item_image_slider').slick("refresh");

            return false;
        });

        $('.modal__close').click(function() {
            var parent_pop = $(this).closest('.filter_popup_wrap');
            parent_pop.slideToggle("slow");
            $('body').removeClass('fixed').css({ top: 0 });
            $(window).scrollTop(scrollPos);
            return false;
        });





        


});
</script>



