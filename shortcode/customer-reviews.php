<?php 
	$args = array (
	  'post_type'              => 'customer_review',
	  'post_status'            => 'publish',
	  'pagination'             => true,
	  'posts_per_page'         => '10',
	  'order'				   => 'DESC',
	);
	$query = new WP_Query( $args );
    if($query->have_posts()) :?>
	<div class="customer_review_wrap">
		<ul class="customer_reviews">
			<?php
			while($query->have_posts()) : $query->the_post();	
			?>
				<li>
					<div class="review_inner">
						<div class="customers_message"><?php the_field('customer_review_text'); ?></div>    
						<div class="customers_name">- <?php the_field('review_customer_name'); ?></div>
					</div>
				</li>
			<?php
			endwhile;
			?>
		</ul>
	</div>
<?php wp_reset_postdata(); ?>

<script>
jQuery(document).ready(function($) {
	$('.customer_reviews').slick({
		autoplay: true,
  		autoplaySpeed: 10000,
		dots: true,
		prevArrow:"<div class='c_review_arrows prev' ><img src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/arrow-left.svg'></div>",
		nextArrow:"<div class='c_review_arrows next' ><img src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/arrow-right.svg'></div>",
		swipeToSlide: false
	});
});
</script>

<?php  endif;  ?>




