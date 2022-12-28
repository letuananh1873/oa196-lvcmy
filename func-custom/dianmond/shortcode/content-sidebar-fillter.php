<?php
$product_id = $GLOBALS['product_id'] ;
$filter_main_display = get_field('filter_main_display',$product_id);
$filter_main_display = true;
$attr_filter = array();
if($filter_main_display){
            // Attribute Collection
              
$attr_filter['collection'] = array(
    "lab_diamond" => "Lab Diamond",
    "mined_diamond"  => "Mined Diamond"
);       
//attributes cut
$_dianmond_shapes = $_GET['_dianmond_shapes']??'';
if ($_dianmond_shapes == 'round') {
    $attr_filter['cut']=arr_attribute_meta_child_product('pa_cut');
}

$attr_filter['clarity']=arr_attribute_meta_child_product('pa_clarity');

//attributes clarity           
$attr_filter['carats'] = array(0.01,5.7);   
$attr_filter['price'] =  array(1000,70000);

}

//var_dump($attr_filter);

/*
Echo Restructure Sidebar to HTML
*/
if(!empty($attr_filter)){
    /*$post__in = $GLOBALS['post__in'];    
    $thumbs_variation = array();
    if ($post__in) {
        foreach ($post__in as $key => $p_id) {
            $thumbs_variation[$p_id] = get_id_thumbnail($p_id);
        }
    }*/
    $filters = slug_attribute();
    $str_filter = '';
    foreach ($filters as $key => $value) { 
    if (isset($_GET[$value])) {
        $text = $key.'='.$_GET[$value].'&';
        $str_filter .= $text;        
    }
}

 $post_exclude = $GLOBALS['post_exclude'];
    
    echo '<div id="sidebar-filter" class="adv-sidebar-wrapper">';    
    echo '<form id="filter-child" name="filter-child" >';
    echo '<input type="hidden" id="product_id" name="product_id" value="'.$product_id.'" />';
   echo '<input type="hidden" id="post_exclude" name="post_exclude" value="'.implode(',', $post_exclude).'" />';
    ?>
    <input type="hidden" id="filters" name="filters" value="<?php echo $str_filter;?>" />
    <?php
     
    foreach($attr_filter as $key=>$filter){

        if($key == "collection") {
            $learnmore = "";
        }
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
        

        echo '<div class="adv-sidebar-container" data-group="'.$key.'">';
            echo    '<div class="sidebar-title">'.$key.$learnmore.' </div>';
        if($key == "collection") {
            foreach($filter as $key_collect => $item) {
                
                $sanitized_value = sanitize_title($item);
                ?>
                <div class="sidebar-filter filter-collection">
                    <input type="checkbox" value="<?php echo $key_collect; ?>" id="<?php echo $sanitized_value; ?>" name="<?php echo $key; ?>[]" />
                    <label for="<?php echo $sanitized_value; ?>"><?php echo $item; ?></label>  
                </div>

                <?php
            }
        }
        //Cut 
        if($key == 'cut'){

            foreach($filter as $key_item=>$value){

                $sanitized_value = sanitize_title($value);
                echo    '<div class="sidebar-filter filter-cut">
                            <input type="checkbox" value="'.$key_item.'" id="'.$sanitized_value.'" name="'.$key.'[]" />
                            <label for="'.$sanitized_value.'">'.$value.'</label>
                        </div>';

            }        
        }

        //min max range - Carats and Price
         
        if($key == 'carats' || $key == 'price' ){
            $min = $filter[0]; 
            $max = $filter[1]; 
            $presetmin = $min ?: 1;
            $presetmax = $max;

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
            <div class="slider-range" >
                <span class="min-range">Min</span>
                <span class="max-range">Max</span>
                <div id="range-for-<?php echo $key; ?>" data-max="<?php echo $max;?>" data-min="<?php echo $min;?>"></div>
            </div>
            <div class="sidebar-filter slider-range-input input-for-<?php echo $key; ?>">
                <div class="slider-range-input-label label-min">
                    <label for="<?php echo $key; ?>-min"><?php echo $currencyLabel; ?>Min</label>
                    <input type="<?php echo $inputformat; ?>" step="<?php echo $step ; ?>" id="<?php echo $key; ?>-min" value="<?php echo $min; ?>" min="<?php echo $min; ?>" max="<?php echo $max; ?>" price-extra-min="<?php echo $min; ?>" name="<?php echo $key; ?>-min" >
                </div>
                <p class="">to</p>
                <div class="slider-range-input-label label-max">
                    <label for="<?php echo $key; ?>-max" class=""><?php echo $currencyLabel; ?>Max</label>
                    <input type="<?php echo $inputformat; ?>" step="<?php echo $step ; ?>" id="<?php echo $key; ?>-max" class="" value="<?php echo $max; ?>" max="<?php echo $max; ?>" min="<?php echo $min; ?>" price-extra-max="<?php echo $max; ?>" name="<?php echo $key; ?>-max">
                </div>
            </div>

 <script>
     
                jQuery(document).ready(function ($) {
                    <?php if($key == 'price'): ?>

                        $( "#range-for-<?php echo $key; ?>" ).slider({
                                range: true,
                                min: <?php echo ($min ?: 1); ?>,
                                max: <?php echo $max; ?>,
                                values: [ <?php echo $presetmin; ?>, <?php echo $presetmax; ?> ],
                                step: 1,
                                    stop: function( event, ui ) {
                                        $( "#<?php echo $key; ?>-min" ).attr("price-extra-min",ui.values[0]);
                                        $( "#<?php echo $key; ?>-max" ).attr("price-extra-max",ui.values[1]);
                                        $( "#<?php echo $key; ?>-min" ).val( "$" + addCommas(ui.values[0].toString()) ).trigger("change");
                                        $( "#<?php echo $key; ?>-max" ).val( "$" + addCommas(ui.values[1].toString()) ).trigger("change");
                                    },
                                          slide: function( event, ui ) {
                                     $( "#<?php echo $key; ?>-min" ).val(ui.values[0]);
                                        $( "#<?php echo $key; ?>-max" ).val(ui.values[1]);
                                  }
                            });

                            $( "#<?php echo $key; ?>-min" ).val( "" + addCommas( $( "#range-for-<?php echo $key; ?>" ).slider( "values", 0 ) ) );
                            $( "#<?php echo $key; ?>-max" ).val( "" + addCommas( $( "#range-for-<?php echo $key; ?>" ).slider( "values", 1 ) ) );
                    <?php else: ?>

                        $( "#range-for-<?php echo $key; ?>" ).slider({
                                range: true,
                                min: <?php  echo ($min ?: 1); ?>,
                                max: <?php echo $max ?>,
                                values: [ <?php echo $presetmin; ?>, <?php echo $presetmax; ?> ],
                                step: <?php echo $step; ?>,
                                    stop: function( event, ui ) {
                                        $( "#<?php echo $key; ?>-min" ).val( ui.values[ 0 ] ).trigger("change");
                                        $( "#<?php echo $key; ?>-max" ).val( ui.values[ 1 ] ).trigger("change");
                                    },
                                    slide: function( event, ui ) {
                                     $( "#<?php echo $key; ?>-min" ).val(ui.values[0]);
                                        $( "#<?php echo $key; ?>-max" ).val(ui.values[1]);
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

            // sort($filter);
            foreach($filter as $key_item =>$value){

                if( $break_count%4 == 0 ){
                    $noborder = 'noborder';
                }else{
                    $noborder = '';
                }

                $sanitized_value = sanitize_title($value);

                echo    '<div class="sidebar-filter filter-standard-checkbox '.$noborder.'">
                            <input type="checkbox" value="'.$key_item.'" id="'.$sanitized_value.'" name="'.$key.'[]" />
                            <label for="'.$sanitized_value.'">'.$value.'</label>
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
    echo '</form>';

    echo '</div>'; //adv-sidebar-wrapper
}