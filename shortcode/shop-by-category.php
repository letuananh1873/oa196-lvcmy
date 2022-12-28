<?php if(get_field('shop_by_category')): ?>
	<div class="shop_by_category">
        <?php while(has_sub_field('shop_by_category')): ?>
            <div class="shop_by_cate_list">
                <img src="<?php the_sub_field('shop_by_cate_image'); ?>">
                <h4 class=""><?php the_sub_field('shop_by_cate_title'); ?></h4>
                <a class="shop_by_cate_btn" href="<?php the_sub_field('shop_by_cate_url'); ?>"><?php the_sub_field('shop_by_cate_btn_text'); ?></a>
            </div>
        <?php endwhile; ?>
    </div>
  
<script>
    jQuery(document).ready(function($) {
        var spWidth = 767;
        if (spWidth >= $(window).width()) {
                $('.shop_by_category').slick({
                autoplay: false,
                dots: false,
                arrows: false,
                // prevArrow:"<div class='new_products_arrows prev' ><img src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/arrow-left.svg'></div>",
                // nextArrow:"<div class='new_products_arrows next' ><img src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/arrow-right.svg'></div>",
                focusOnSelect: true,
                swipeToSlide: true
            });
        }
    });
</script>
<?php endif; ?>