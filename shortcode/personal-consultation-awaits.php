<?php if(get_field('personal_consultation_awaits')): ?>
	<ul class="personal_consultation_awaits">
		<?php while(has_sub_field('personal_consultation_awaits')): ?>
			<li>
                <div class="shop_imageBox">
                    <a class="textBoxUrl" href="<?php the_sub_field('personal_consultation_await_url'); ?>">
                        <img src="<?php the_sub_field('personal_consultation_await_img'); ?>">
                        <div class="textBox">
                            <h3><?php the_sub_field('personal_consultation_await_title'); ?></h3>
                        </div>
                    </a>
                </div>
                <div class="book_consultation"><a href="mailto:<?php the_sub_field('email_for_booking'); ?>">Book a Consultation</a></div>
                <div class="get_direction"><a href="<?php the_sub_field('personal_consultation_location_url'); ?>" target="_blank">Get Directions</a></div>
			</li>
		<?php endwhile; ?>
    </ul>
    <script>
    jQuery(document).ready(function($) {
        $('.personal_consultation_awaits').slick({
            autoplay: false,
            dots: false,
            prevArrow:"<div class='slider_arrows prev' ><img src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/arrow-left.svg'></div>",
            nextArrow:"<div class='slider_arrows next' ><img src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/arrow-right.svg'></div>",
            focusOnSelect: true,
			swipeToSlide: true,
			slidesToShow: 4,
			slidesToScroll: 4,
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