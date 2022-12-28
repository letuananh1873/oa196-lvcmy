<?php
$id = get_prefix_block();
$type = get_field("template",$id)?? 'default';
?>
<?php if ( $type ==  'type1') { ?>
  

<?php  } else { ?>
<div class="filterByWrap filterByWrapShop">
  <div class="filterByInner">
        <div class="filterBy_box1">
        <div class="filterByTitle">Filter By: 
            <!-- <div class="filterByBoxes filterByBoxes_resetBtn">
              <button onclick="FWP.reset()">Clear Filters</button>
            </div> -->
          </div>
          <div class="filterBoxesWrap">
            <?php if( ! empty(alt_get_count_tax('product_cat')) ) { ?>
            <div class="filterByBoxes"><?php echo do_shortcode( '[facetwp facet="product_categories"]' ); ?></div>
            <?php }
            if( ! empty(alt_get_count_tax('designer_collections')) ) { ?>
            <div class="filterByBoxes"><?php echo do_shortcode( '[facetwp facet="designer_collections"]' ); ?></div>
            <?php }
            if( ! empty(alt_get_count_tax('material')) ) { ?>
            <div class="filterByBoxes"><?php echo do_shortcode( '[facetwp facet="material"]' ); ?></div>
            <?php }
            if( ! empty(alt_get_count_tax('colour')) ) { ?>
              <div class="filterByBoxes"><?php echo do_shortcode( '[facetwp facet="colour"]' ); ?></div>
            <?php }
            if( ! empty(alt_get_count_tax('occasions')) ) { ?>
            <div class="filterByBoxes"><?php echo do_shortcode( '[facetwp facet="occasions"]' ); ?></div>
            <?php }
            if( ! empty(alt_get_count_tax('pa_ring-size')) ) { ?>
              <div class="filterByBoxes"><?php echo do_shortcode( '[facetwp facet="ring_size"]' ); ?></div>
            <?php }
            if( ! empty(alt_get_count_tax('pa_carat-weight')) ) { ?>
            <div class="filterByBoxes"><?php echo do_shortcode( '[facetwp facet="carat_weight"]' ); ?></div>
            <?php }?>
            <div class="filterByBoxes">
              <div class="filterBy_label">Price</div>
              <div class="filterBy_lists"><?php echo do_shortcode( '[facetwp facet="product_price"]' ); ?></div>
            </div>
            
             <div class="fillter-dianmond" style="width:0; height: 0;overflow-y: hidden;display: inline-block;">
              <div class="filterByBoxes"><?php echo do_shortcode( '[facetwp facet="looking_for"]' ); ?></div>
             <div class="filterByBoxes"><?php echo do_shortcode( '[facetwp facet="that_is"]' ); ?></div>
            <div class="filterByBoxes">
              <div class="filterBy_label">Price</div>
              <div class="filterBy_lists"><?php echo do_shortcode( '[facetwp facet="my_price_point_is"]' ); ?></div>
           </div>
            </div>

            <div class="filterByBoxes filterByBoxes_resetBtn">
              <button onclick="FWP.reset()">Clear Filters</button>
            </div>
          </div>
        </div>
        
  </div>
  <!-- sorby -->
  <div class="dht-sortby"> 
    <?php $catalog_orderby_options    =  woocommerce_catalog_ordering() ; ?>
  </div>
   <!-- end sorby -->
</div>
<script>
  jQuery(document).ready(function($) {
    $(".filterBy_label").click(function(){
      $(this).next(".filterBy_lists").fadeToggle("fast");
      $(this).toggleClass("active");
    });
    $(".fs-label, .filterBy_lists *").click(function(){
      $(".filterBy_lists").fadeOut("fast");
      $(".filterBy_lists").prev(".filterBy_label").removeClass("active");
    });

  });
</script>
<?php } ?>






