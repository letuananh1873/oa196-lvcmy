<?php
// Template Name: Thumb gen
get_header();
wp_reset_query();
global $post;
function products_diamond_variation2($size,$str_filter,$sortby,$paged,$posts_per_page,$parent_product) { 
    $args = array(
        'post_type'       => 'product_variation',
        'post_status'     => 'publish',
        'posts_per_page'  => $posts_per_page,
        'paged' => $paged,
        'post_parent__in' => array($parent_product),
    ) ;
    $args['ignore_custom_sort'] = true;
        $args['meta_key'] = 'attribute_pa_diamond-type';
        //$args['orderby'] = 'meta_value';    
        $args['order'] = 'DESC';
  
     $args['meta_query']['relation'] = 'AND';
     if (!empty($size)) {
        $args['meta_query'][] = array(
        'key'     => 'attribute_pa_ring-size',
        'value'   => $size,
    );
     }
    

    
if (!empty($str_filter)) {  
    $filters = explode("&",$str_filter);   
    foreach ($filters as $key => $filter) {
        $filter_item = explode("=",$filter);
        $args['meta_query'][] = array(
            'key'     => 'attribute_pa'.$filter_item[0],
            'value'   => $filter_item[1],
        );
    }
}

$query = new WP_Query( $args);
return $query;
}
?>
<style>
    #a {
        width: 100%;
        display: block;
        height: 50px;
    }
    .elementor-location-header[data-elementor-type="header"] {
        display: none;
    }
    ul {
        display: table;
        margin: 0;
        padding: 0;
        list-style: none;
    }
    li {
        display: table-row;
    }
    li div {
        display: table-cell;
        padding: 5px 20px 5px 5px;
        font-size: 14px;
    }
    
</style>
<?php
$parent_product = $_POST['p_id'];
$str_filter = trim($_POST['a']);
$size = $_POST['size'];
?>
<form action="https://phase2.love-and-co.com/thumbnail/" method="POST">
    _shapes=round&_metal-type=yellow-gold&_casing=double-pave&_diamond-type=halo<br/>
    yellow-gold - white-gold  - rose-gold <br/>
    6-Prong - Halo - 4-prong-square - 4-prong-nsew
    <?php
    ?>

	<textarea name="a" id="a" cols="30" rows="10"><?php echo $str_filter; ?>
    </textarea>
	<input type="text" name="p_id" id="p_id" placeholder="product_id" value="<?php echo $parent_product; ?>">
    <input type="text" name="size" id="size" placeholder="size" value="<?php echo $size; ?>">
    <input type="submit" name="emma" id="emma" value="Submit" >
</form>
<?php
//p_id=401496&_dianmond_shapes=round&_metal_type=yellow-gold&_casing=double-pave&_diamond_type=halo
/*echo '<pre>';
var_dump(get_post_meta(648623));
echo '</pre>';*/

$query_variation = products_diamond_variation2($size,$str_filter,$sortby,1,100,$parent_product);
/*echo '<pre>';
var_dump($query_variation->query);
echo '</pre>';*/
$total = $query_variation -> found_posts;
echo 'Total: '.$total;
if (!empty($size)):
$variations = $query_variation->posts;

echo '<ul>';
foreach ($variations as $key => $variation) {
    $id = $variation -> ID;
    $shape = get_post_meta($id,'attribute_pa_shapes',true);
    $_metal_type = get_post_meta($id,'attribute_pa_metal-type',true);
    $_casing = get_post_meta($id,'attribute_pa_casing',true);
    $_diamond_type = get_post_meta($id,'attribute_pa_diamond-type',true);
    $size = get_post_meta($id,'attribute_pa_ring-size',true);

   echo '<li>';
   echo '<div>'.$id.'</div>';
   echo '<div>'.$_metal_type.'</div>';
   echo '<div>'.$shape.'</div>';
   echo '<div>'.$_diamond_type.'</div>';
   echo '<div>'.$_casing.'</div>';   
   echo '<div>'.$size.'<br/>';
   echo '</li>';
}
echo '</ul>';
endif;
?>
<br/><br/><br/><br/><br/><br/><br/><br/><br/>
<?php
get_footer();