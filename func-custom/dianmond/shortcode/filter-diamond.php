<?php
$product_id = $_GET['p_id'] ?? '';
if (!empty($product_id)):

?>
<!-- Range Slider Jquery cdn -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 


<!-- Filter -->

<!-- Loader -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.5.3/lottie.js"></script>

<div class="loader-wrapper">
    <div id="loader"></div>
</div>

    <nav class="woocommerce-breadcrumb">
        <a href="<?php echo get_home_url(); ?>">Home</a>&nbsp;/&nbsp;
        <a href="<?php echo home_url(); ?>/category/engagement-rings">Engagement Rings</a>
    &nbsp;/&nbsp;Select Diamond</nav>
    <header class="header-filter">
        <h3>Select Diamond</h3>
        <p>Price indicated is applicable to diamond only.</p>
    </header>

<div id="myfilter-adv">
<?php 

/*
Predefine Varaibles for Products
*/
$GLOBALS['product_id'] = $product_id ;
global $product,$product_id; //main product object
//$product = new WC_Product($product_id);
 $filters = slug_attribute();
 $filter_value = array();
 $child_products = get_field('similar_product_selection',$product_id)??'';
 $_metal_type = $_GET['_metal_type'] ?? '';
$_casing = $_GET['_casing'] ?? '';
$_dianmond_shapes = $_GET['_dianmond_shapes'] ?? '';
$_diamond_type = $_GET['_diamond_type'] ?? '';
foreach ($filters as $key => $value) {
    if (isset($_GET[$value]) ){
        $filter_value[$key] = $_GET[$value];
        }
    }
    /*



$args2 = array(
    'post_type'       => 'product',
    'post_status'     => 'publish',
    'posts_per_page'  => -1,  
    'fields' => 'ids',      
    'post__not_in'     => get_parents_engagement(),

      'tax_query' => array(
        'relation' => 'AND',
    )
) ;
$post_exclude2 = array();
 $args2['tax_query'][]=return_tax_query_diamond($filter_value);
  $query = new WP_Query( $args2);
 
if($query->have_posts()) :
    while($query->have_posts()) : $query->the_post();
        $id_variation = get_id_variation_valid($post,$_metal_type,$_casing,$_dianmond_shapes,$_diamond_type);       
       
        if (empty($id_variation)) {          
            $post_exclude2[] = $post;
          } 
         
    endwhile;        
endif;*/
$post_exclude2 = array();
$post_exclude = array_merge($post_exclude2,get_parents_engagement());
//var_dump($post_exclude); exit;
$GLOBALS['post_exclude'] = $post_exclude;

get_template_part( 'func-custom/dianmond/shortcode/content','sidebar-fillter' );
wp_reset_query();


echo '<div class="filter-container-outter">';
    echo '<div id="filter-container2" class="adv-wrapper">'; 
//if (!empty($child_products )):
        wp_reset_query();
        $args = array(
            'post_type'       => 'product',
            'post_status'     => 'publish',
            'posts_per_page'  => limit_child_product(),  
            'fields' => 'ids',      
            'post__not_in'     => $post_exclude,
              'tax_query' => array(
                'relation' => 'AND',
            )
        ) ;
         $args['tax_query'][]=return_tax_query_diamond($filter_value);
          $query = new WP_Query( $args);
          
        if($query->have_posts()) :
            while($query->have_posts()) : $query->the_post();
                $items = get_meta_product_child($post,$_metal_type,$_casing,$_dianmond_shapes,$_diamond_type);
               
                $GLOBALS['items'] = $items ;        
                get_template_part( 'func-custom/dianmond/shortcode/content','child-product' ); 
            endwhile;
        endif;
        ?>
    </div>
        <div class="page-select-diamond clearfix">
        <?php
            $base2 = 'http://oanglelab.com/oa134-lvc/select-diamond/page/999999999';
            custom_nav_child($query,$base2,'1');
        ?>
        </div>  

    <?php
    else:
        echo '<h3>no result found</h3>';
endif;// end total
?>

<?php
       // echo '</div>';
            echo '<div class="adv_single_container needhelp">
                    <div class="needhelp-attr" data-attr-all="1">
                        <p>Need help? Our professional store consultants can aid in your diamond choosing process.</p>
                        <div class="call-booking-form"><a href="'.home_url( 'make-appointment/?utm_source=LVC+website&utm_campaign=Bespoke_Diamondbuilder_saved_email' ).'"><b>Schedule an appointment now!</b></a></div>
                    </div>
                </div>';

            echo '</div>'; //-adv-wrapper
        echo '</div>'; //-filter-container-outer
    ////////////////////////////////////////////////////////////////////////////////


        echo '<div class="mobileneedhelp needhelp">
                <div class="needhelp-attr" data-attr-all="1">
                    <p>Need help? Our professional store consultants can aid in your diamond choosing process.</p>
                    <div class="call-booking-form"><a href="'.home_url( 'make-appointment/?utm_source=LVC+website&utm_campaign=Bespoke_Diamondbuilder_saved_email' ).'"><b>Schedule an appointment now!</b></a></div>
                </div>
            </div>';

    /*else:
        echo 'no result found';
    endif;*/
?>
<?php 
/*else:
        echo 'no result found';
endif;*/
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

        //Slide Pop up
        var scrollPos;
        $( window ).resize(function() {
            var headerHeight = $("#header-box").outerHeight();
            var windowHeight =  $(window).height();
            var boxHeight = windowHeight - headerHeight;
            $('.filter_popup_wrap').height(boxHeight);
        });      
        

});
</script>