<?php if(get_field('accordion')): ?>
	<div class="accordionsWrap">
      <?php while(has_sub_field('accordion')): ?>
        <div class="accordion_items">
          <h3 class="accordion_item_title"><?php the_sub_field('accordion_title'); ?></h3>
          <div class="accordion_item_content">
            <div class="accordion_image_1col">
              <img src="<?php the_sub_field('accordion_image_1col'); ?>">
            </div>
            <div class="accordion_image_2col">
              <div class="accordion_2col_images">
               <img src="<?php the_sub_field('accordion_image_2col_1'); ?>">
              </div>
              <div class="accordion_2col_images">
                <img src="<?php the_sub_field('accordion_image_2col_2'); ?>">
              </div>
            </div>
            <div class="accordion_item_desc">
                <?php the_sub_field('accordion_desc'); ?>
              </div>
          </div>
        </div>
				
			<?php endwhile; ?>
  </div>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

  <script>
  jQuery(document).ready(function($) {
    // $(".accordion_item_title").click(function(){
    //   $(this).next(".accordion_item_content").slideToggle();
    // });
    $(".accordionsWrap").accordion({
      header: "h3.accordion_item_title",
      collapsible:true,
      heightStyle: "content",
      active:true
    });
  });
  </script>

<?php endif; ?>