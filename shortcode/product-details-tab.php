<div class="product_details_content <?php if( have_rows('product_details') ): ?>has__products_decs_options<?php endif; ?>">

  <div class="product_desc_box">
        <?php echo the_content(); ?>
  </div>

  <div class="products_decs_options">
    <?php if( have_rows('product_details') ): ?>
      <ul class="products_decs_optionList">
      <?php while( have_rows('product_details') ): the_row(); ?>
          <li>
              <h4><?php the_sub_field('product_detail_title') ?></h4>
              <div class="product_detail_option_text"><?php the_sub_field('product_detail_desc') ?></div>
          </li>
      <?php endwhile; ?>
      </ul>
  <?php endif; ?>
  </div>

</div>

