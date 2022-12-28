<div class="wrapper-fillter-diamond">
  <div class="filterByWrap filterByWrap_type1">
  <div class="filterByInner">
        <div class="filterBy_box1 filterBy_dianmond">
          <div class="filterByTitle">Filter By</div><!-- end filterByTitle -->
          <?php 
          $selected_atts = get_selected_variation();
            $atts_filter = array (
              'shapes' => 'Shapes',
              'metal-type' => 'Metal Type'
            );      
            $i = 0; 
            foreach ($atts_filter as $key => $att) {
              $taxonomy = 'pa_'.$key;
              $selected = $selected_atts[$taxonomy]??'';
              $i++;
              $terms = get_terms( array(
                  'taxonomy' => $taxonomy,
                  'hide_empty' => false,
              ) );
              if (!is_wp_error( $terms ) && count($terms) > 0) { 
                $style = $i == '1' ? 'style="display: block;"' : ''; 
            ?>

          <!-- begin filterBoxesWrap -->
          <div class="filterBoxesWrap">
             <div class="filterByBoxes">
              <div class="fs-label-wrap"><div class="fs-label"><?php echo $att; ?></div><span class="fs-arrow"></span></div>

              <div class="wrapper-list-filter <?php echo $taxonomy; ?>" <?php echo $style; ?>>
                <div class="wrapper-att" data-name="<?php echo $key; ?>">
                <?php
                $tile_slectect = ''; 
                foreach ($terms as $key => $term) {
                  $active = $term->slug == $selected  ? 'active' :'';
                  $active_title = $term->slug == $selected  ? $term->name :'';

                  $term_id = $term->term_id;
                   $icon_shate = get_field('icon_shate','term_'.$term_id) ?? '';
                   $html_icon_shape = '';

                    if (!empty($icon_shate)) {
                        $html_icon_shape.= '<span class="shape-icon"><img src="'.$icon_shate.'" alt=""/></span>';
                      } else {
                         $html_icon_shape.= '<span class="shape-icon">'.$term->name.'</span>';
                      }

                       $clolse = '<svg xmlns="http://www.w3.org/2000/svg" width="7" height="7" viewBox="0 0 25 25" fill="none"><path d="M2.37106 0.406738L0.407089 2.37071L10.5362 12.4998L0.407089 22.629L2.37106 24.5929L12.5002 14.4638L22.6293 24.5929L24.5933 22.629L14.4642 12.4998L24.5933 2.37071L22.6293 0.406738L12.5002 10.5359L2.37106 0.406738Z" fill="black"></path></svg> ';

                      if (!empty($active)) {
                          $tile_slectect = $clolse.$active_title;
                        }
                  ?>
                
                  <div  data-id="<?php echo $term->term_id; ?>" id="<?php echo $term->slug; ?>" class="att-diamond <?php echo $active; ?>" data-value="<?php echo $term->slug; ?>" data-attribute="<?php echo $taxonomy; ?>">
                    <?php echo $html_icon_shape; ?>
                  <span class="dianmond-title"><?php echo $clolse.$term->name; ?> </span></div>
                   <?php } ?>    
                   <div data-order="" id="" class="value_active att-diamond" data-value=""><span class="dianmond-title"><?php echo $tile_slectect; ?></span></div>
                  </div>                            
                </div>
            </div><!-- end filterByBoxes -->
            
          </div> <!-- end filterBoxesWrap -->
          <?php
       
          }
            }
          ?>
        </div>
      </div>
</div>
</div>
<input type="hidden" id="url_current" name="url_current" value="<?php echo get_term_link(get_queried_object()); ?>">

<?php
$limit = posts_per_page_variation();
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
$str_filter = str_filter_variation_diamond_selected();
$parent_product = get_parents_engagement() ;
//var_dump($parent_product);
$sortby_url = $_GET['_price']??'';
$sortby_bestsellers = $_GET['_bestsellers']??'';
$sortby = '';
$lable = 'Default sorting';
if (!empty($sortby_url)) {
  if ($sortby_url == 'low-to-high') {
    $sortby = 'price';
    $lable = 'Low to high';
  } else {
    $sortby = 'price-desc';
    $lable = 'High to low';
  }
}
if (!empty($sortby_bestsellers)) {
  if ($sortby_bestsellers =='bestsellers' ){
    $sortby = 'bestsellers';
    $lable = 'Bestsellers';
  }
}
$query_variation = products_diamond_variation($str_filter,$sortby,$paged,$limit,$parent_product);
if (!empty($query_variation) && !empty($parent_product)){
$total = $query_variation -> found_posts;
$result = result_filter_diamin_html($total,$paged);
$variations = $query_variation->posts;
?>
  <div class="wrapper-result">
     <p class="result-count"><?php echo $result; ?></p>
  <div class="diamond-shorty">

    <label for="">Sort by: <strong><?php echo $lable; ?></strong></label>
     <ul class="sort_by_diamond">
          <li data-value="" data-label="Default sorting">Default sorting</li>        
          <li class="<?php echo class_active_selected($sortby,'price'); ?>" data-value="price" data-label="Low to high" >Low to high</li>
          <li class="<?php echo class_active_selected($sortby,'price-desc'); ?>" data-value="price-desc" data-label="High to low">High to low</li>
          <li class="<?php echo class_active_selected($sortby,'bestsellers'); ?>" data-value="bestsellers" data-label="Bestsellers">Bestsellers</li>
      </ul>
  </div> 
  </div>

 
<?php
if (count($variations) > 0) { 
    echo '<div class="diamond-products">';
    echo '<ul class="products columns-4">';
    foreach ($variations as $key => $variation) { 
      variation_product_html($variation);    
   }
echo '</ul></div>';
}
?>
<div class="pavi-variation">
  <?php custom_nav($query_variation,get_term_link(get_queried_object()),$paged); ?>
</div>
<?php
}