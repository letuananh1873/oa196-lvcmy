<?php
$id = get_prefix_block();
$type = get_field("template",$id)?? 'default';
?>
<?php if ( $type ==  'type1') { ?>
  

<?php  } else { ?>
<div class="filterByWrap filterByWrapShop">
  <div class="filterByInner">
        <div class="filterBy_box1">
          <div class="filterByTitle">Filter By</div>
          <div class="filterBoxesWrap">
            <div class="filterByBoxes"><?php echo do_shortcode( '[facetwp facet="product_categories"]' ); ?></div>
            <div class="filterByBoxes"><?php echo do_shortcode( '[facetwp facet="designer_collections"]' ); ?></div>
            <div class="filterByBoxes"><?php echo do_shortcode( '[facetwp facet="material"]' ); ?></div>
            <div class="filterByBoxes"><?php echo do_shortcode( '[facetwp facet="colour"]' ); ?></div>
            <div class="filterByBoxes"><?php echo do_shortcode( '[facetwp facet="occasions"]' ); ?></div>
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






