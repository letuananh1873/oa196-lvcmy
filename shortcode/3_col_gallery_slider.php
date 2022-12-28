<?php if(get_field('3_col_gallery_slider')): ?>
	<ul class="3_col_gallery_slider">
		<?php while(has_sub_field('3_col_gallery_slider')): ?>
			<li>
                <a href="<?php the_sub_field('col_slider_img_url'); ?>" target="_blank">
                    <img src="<?php the_sub_field('col_slider_img'); ?>">
                </a>
			</li>
		<?php endwhile; ?>
	</ul>

    <script>
    jQuery(document).ready(function($) {
        $('.3_col_gallery_slider').slick({
            autoplay: false,
            dots: false,
            prevArrow:"<div class='slider_arrows prev' ><img src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/arrow-left.svg'></div>",
            nextArrow:"<div class='slider_arrows next' ><img src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/arrow-right.svg'></div>",
			swipeToSlide: true,
			slidesToShow: 3,
			slidesToScroll: 3,
			responsive: [
				{
				  breakpoint: 992,
				  settings: {
					slidesToShow: 3,
					slidesToScroll: 3,
				  }
				},
				{
				  breakpoint: 767,
				  settings: {
					slidesToShow: 2,
					slidesToScroll: 2,
					centerMode: false
				  }
				}
			  ]
        });
    });
    </script>
<?php endif; ?>