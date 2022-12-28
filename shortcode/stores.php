<?php 
	$args = array (
      'post_type'              => 'store_locator',
        'tax_query' => array(
            array (
                'taxonomy' => 'store_location',
                'field' => 'slug',
                'terms' => 'malaysia',
            )
        ),
	  'post_status'            => 'publish',
	  'pagination'             => true,
	  'order'				   => 'DESC',
	);
	$query = new WP_Query( $args );
    if($query->have_posts()) :?>

    <div class="text-popup-col-4 store-lists">
        <?php
        while($query->have_posts()) : $query->the_post();	
        ?>
            <div class="store-item">
                <a class="textBoxUrl" href="<?php echo get_permalink( $post->ID ); ?>">
                    <img src="<?php echo get_the_post_thumbnail_url($post->ID, 'full'); ?>">
                    <div class="textBox">
                        <h3><?php echo get_the_title(); ?></h3>
                    </div>
                </a>
            </div>
        <?php
        endwhile;
        ?>
	</div>

<?php wp_reset_postdata(); ?>


<script>
    jQuery(document).ready(function($) {
        $('.text-popup-col-4').slick({
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

<?php  endif;  ?>




