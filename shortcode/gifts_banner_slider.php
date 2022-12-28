<?php if(get_field('gift_banner_slider')): ?>
	<ul class="gift_banner_slider">
		<?php while(has_sub_field('gift_banner_slider')): ?>
			<li>
                <a href="<?php the_sub_field('gift_target_url'); ?>" target="_blank">
                    <img src="<?php the_sub_field('gift_banner_image'); ?>">
					<div class="gift_target_title"><?php the_sub_field('gift_target_title'); ?></div>
                </a>
			</li>
		<?php endwhile; ?>
	</ul>

    <script>
    jQuery(document).ready(function($) {
        $('.gift_banner_slider').slick({
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
					slidesToShow: 1,
					slidesToScroll: 1,
					centerMode: false
				  }
				}
			  ]
        });
    });
    </script>
<?php endif; ?>