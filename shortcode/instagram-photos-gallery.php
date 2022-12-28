<?php 
	$args = array (
		'post_type'              => 'instagram_photos',
		'post_status'            => 'publish',
		'pagination'             => true,
		// 'posts_per_page'         => '20',
		'order'                  => 'DESC',
	);
	$query = new WP_Query( $args );
    if($query->have_posts()) :?>

    <ul class="instagram_photos">
        <?php
        while($query->have_posts()) : $query->the_post();        
        ?>
			<li>
                <a href="<?php the_field('instagram_image_url'); ?>" target="_blank">
                    <img src="<?php the_field('instagram_image'); ?>">
                </a>
			</li>
        <?php endwhile; ?>
	</ul>
	<?php wp_reset_postdata(); ?>

    <script>
    jQuery(document).ready(function($) {
        $('.instagram_photos').slick({
            autoplay: false,
            dots: false,
			prevArrow:"<div class='insta_arrows prev' ><img src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/arrow-left.svg'></div>",
            nextArrow:"<div class='insta_arrows next' ><img src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/arrow-right.svg'></div>",
            focusOnSelect: true,
			swipeToSlide: true,
			slidesToShow: 5,
			slidesToScroll: 5,
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
					centerMode: true
				  }
				}
			  ]
        });
    });
    </script>

<?php  endif;  ?>