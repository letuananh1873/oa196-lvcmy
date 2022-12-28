<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
			<?php astra_content_bottom(); ?>

			</div> <!-- ast-container -->

		</div><!-- #content -->

	<?php astra_content_after(); ?>

	<?php astra_footer_before(); ?>

	<?php astra_footer(); ?>

	<?php astra_footer_after(); ?>

	</div><!-- #page -->

	<?php astra_body_bottom(); ?>
	<?php wp_footer(); ?>

	<script type='text/javascript' src='<?php echo get_template_directory_uri(); ?>/assets/js/mon.js?v=<?php echo strtotime("now"); ?>'></script>





		<!--Scroll To TOp-->
		<a href="#" id="back-to-top" title="Back to top">&#xf106;</a>

		<!-- <script>
			/* PC header sticky scroll */
			var pc_header = document.getElementById("header-box");
   	 		var pc_elemStyle = window.getComputedStyle(pc_header, null);
			var pc_h_height = pc_elemStyle.getPropertyValue("height");

			var prevScrollpos = window.pageYOffset;
			window.onscroll = function() {
			var currentScrollPos = window.pageYOffset;
			if (prevScrollpos > currentScrollPos) {
				document.getElementById("header-box").style.top = "0";
			} else {
				document.getElementById("header-box").style.top = "-" + pc_h_height ;
			}
			prevScrollpos = currentScrollPos;
			}
		</script> -->



		<!-- <script>
			jQuery(document).ready(function($){
				var headerHeight =  $(".header-box").outerHeight();
				var lastScrollTop = 0;
				$(window).scroll(function(event){

				var scrolltop = $(this).scrollTop();
				if (scrolltop <= headerHeight){
					$('#header-box').addClass("unfixed");
				} else {
					$('#header-box').removeClass("unfixed");
				}
				if (scrolltop > lastScrollTop){
					//console.log('scrollDown');
					$('#header-box').css("top", "-" + headerHeight + "px");
					//console.log(headerHeight);
				} else {
					//console.log('scrollUp');
					$('#header-box').css("top","0");
				}
				lastScrollTop = scrolltop;
				});
			});
		</script> -->


		<script>
			jQuery(document).ready(function($){

				//after submit booking form, close the modal automatically after 3seconds
				$(".elementor-field-type-submit").click(function(){
					setTimeout(function() { 
						//$("#modal-68e5e4a").removeClass("uael-show");
						$(".elementor-message.elementor-message-success").fadeOut();
						$("html").removeClass("uael-html-modal");
					}, 7000);
				});
				//When click booking form button inside mobile side menu, auto close the mobile side menu
				$(".elementor-element-2012266 a").click(function(){
					$("#offcanvas-ee6d8dc").removeClass("uael-offcanvas-show");
					$("html").removeClass("uael-offcanvas-enabled, uael-off-canvas-overlay");
				});
				

				//hide booking form's "choose store" and show when we only select "In Store Consultation"
				$(".elementor-field-group-field_9a17cda").hide();
				$('.elementor-field-group-booking_option input[name="form_fields[booking_option]"]').change(function() { 
					if ( $('input[value="In Store Consultation"]').is(':checked') ) {
						$(".elementor-field-group-field_9a17cda").show();
					} else {
						$(".elementor-field-group-field_9a17cda").hide();
					}
				})

				//product page prefill sku in appointment
				$(".product .call-booking-form a.elementor-button").click(function(){
					$('textarea#form-field-other').val('I am interested in <?php the_title();?>.');
					var sku = $(".sku").html();
					$('input#form-field-product_code').val(sku);
				});


				//Newsletter Pop-up automatically close after successful subscription.
				// $("form#sib_signup_form_3").on('submit', function(e) {
				$(".sib_signup_form").on('submit', function(e) {
					setTimeout(function() { 
						$("#modal-ad2cefb").removeClass("uael-show");
					}, 8000);
				});

				
				

			});
		</script>



		<?php
		//Add Categories Images Banner -- edit ACF in Shop Page
		$taxonomy = 'product_cat';
		$term_id = get_queried_object()->term_id;

			$first_banner_image = get_field('image_banner', $taxonomy . '_' . $term_id);
			if($first_banner_image){
				$first_banner_image = $first_banner_image['sizes'][ 'medium_large' ];
			}
			$first_banner_title = get_field('image_title', $taxonomy . '_' . $term_id);
			$first_banner_description = get_field('image_description', $taxonomy . '_' . $term_id);
			$first_banner_link = get_field('image_link', $taxonomy . '_' . $term_id);
			$text_color_1 = get_field('text_color_1', $taxonomy . '_' . $term_id);
			$text_box_vertical_alignment_1 = get_field('first_banner_text_box_vertical_alignment', $taxonomy . '_' . $term_id);
			if($text_box_vertical_alignment_1 == 'Top' ){
				$text_box_vertical_alignment_1 = 'flex-start';
			}else if($text_box_vertical_alignment_1 == 'Bottom' ){
				$text_box_vertical_alignment_1 = 'flex-end';
			}else if($text_box_vertical_alignment_1 == 'Middle' ){
				$text_box_vertical_alignment_1 = 'center';
			}
			$text_box_horizontal_alignment_1 = get_field('first_banner_text_box_horizontal_alignment', $taxonomy . '_' . $term_id);
			if($text_box_horizontal_alignment_1 == 'Left' ){
				$text_box_horizontal_alignment_1 = 'flex-start';
			}else if($text_box_horizontal_alignment_1 == 'Right' ){
				$text_box_horizontal_alignment_1 = 'flex-end';
			}else if($text_box_horizontal_alignment_1 == 'Middle' ){
				$text_box_horizontal_alignment_1 = 'center';
			}


			$second_banner_image = get_field('image_banner_copy', $taxonomy . '_' . $term_id);
			if($second_banner_image){
				$second_banner_image = $second_banner_image['sizes'][ 'medium_large' ];
			}
			$second_banner_title = get_field('image_title_copy', $taxonomy . '_' . $term_id);
			$second_banner_description = get_field('image_description_copy', $taxonomy . '_' . $term_id);
			$second_banner_link = get_field('image_link_copy', $taxonomy . '_' . $term_id);
			$text_color_2 = get_field('text_color_2', $taxonomy . '_' . $term_id);
			$text_box_vertical_alignment_2 = get_field('second_banner_text_box_vertical_alignment', $taxonomy . '_' . $term_id);
			if($text_box_vertical_alignment_2 == 'Top' ){
				$text_box_vertical_alignment_2 = 'flex-start';
			}else if($text_box_vertical_alignment_2 == 'Bottom' ){
				$text_box_vertical_alignment_2 = 'flex-end';
			}else if($text_box_vertical_alignment_2 == 'Middle' ){
				$text_box_vertical_alignment_2 = 'center';
			}
			$text_box_horizontal_alignment_2 = get_field('second_banner_text_box_horizontal_alignment', $taxonomy . '_' . $term_id);
			if($text_box_horizontal_alignment_2 == 'Left' ){
				$text_box_horizontal_alignment_2 = 'flex-start';
			}else if($text_box_horizontal_alignment_2 == 'Right' ){
				$text_box_horizontal_alignment_2 = 'flex-end';
			}else if($text_box_horizontal_alignment_2 == 'Middle' ){
				$text_box_horizontal_alignment_2 = 'center';
			}

		?>



		<?php if($first_banner_image || $second_banner_image): ?>
			<script>
				jQuery(document).ready(function ($) {
					add_categories_images();
					$(document).on('facetwp-loaded', function() {
						add_categories_images();
					});
					function add_categories_images(){

						if( $("ul.products li").length ){
							var products_count = $("ul.products li").length;
							// console.log(products_count);

							//First Image Banner
							<?php if($first_banner_image): ?>
							if(products_count >= 10){
								var banner_number = 'first';
								var banner_image = '<?php echo $first_banner_image; ?>';
								var banner_title = '<?php echo $first_banner_title; ?>';
								var banner_description = '<?php echo $first_banner_description; ?>';
								var banner_link = '<?php echo $first_banner_link; ?>';
								var banner_text_color = '<?php echo $text_color_1; ?>';
								var text_box_vertical = '<?php echo $text_box_vertical_alignment_1; ?>';
								var text_box_horizontal = '<?php echo $text_box_horizontal_alignment_1; ?>';


								$( category_banner(banner_number,banner_image,banner_title,banner_description,banner_link,banner_text_color,text_box_vertical,text_box_horizontal) ).insertAfter('ul.products li:nth-child(8)');
							}
							<?php endif; ?>

							//Second Image Banner
							<?php if($second_banner_image): ?>
							if(products_count >= 16){
								var banner_number = 'second';
								var banner_image = '<?php echo $second_banner_image; ?>';
								var banner_title = '<?php echo $second_banner_title; ?>';
								var banner_description = '<?php echo $second_banner_description; ?>';
								var banner_link = '<?php echo $second_banner_link; ?>';
								var banner_text_color = '<?php echo $text_color_2; ?>';
								var text_box_vertical = '<?php echo $text_box_vertical_alignment_2; ?>';
								var text_box_horizontal = '<?php echo $text_box_horizontal_alignment_2; ?>';


								$( category_banner(banner_number,banner_image,banner_title,banner_description,banner_link,banner_text_color,text_box_vertical,text_box_horizontal) ).insertAfter('ul.products li:nth-child(10)');
							}
							<?php endif; ?>
						}


					}
					function category_banner(banner_number,banner_image,banner_title,banner_description,banner_link,banner_text_color,text_box_vertical,text_box_horizontal){
						var html = '<li class="categories_images_banner '+banner_number+'_banner"><div class="background-image" style="background:url('+banner_image+'); align-items: '+text_box_vertical+' ; justify-content: '+text_box_horizontal+' ;" ><img class="img-mobile" src="'+banner_image+'" alt="" /><div class="text-box" style="color: '+banner_text_color+' ">'+banner_title+'<a href="'+banner_link+'" class="button-box" style="color:'+banner_text_color+' ; border-color:'+banner_text_color+' ">'+banner_description+'</a></div></div><div class="sp-text-box" style="color: '+banner_text_color+' ">'+banner_title+'<a href="'+banner_link+'" class="button-box" style="color:'+banner_text_color+' ; border-color:'+banner_text_color+' ">'+banner_description+'</a></div></li>';

						return html;
					}
				});
			</script>
		<?php endif; ?>
	<!-- SEO Scripts Footer -->
	<?php seo_script('footer'); ?>
	<!-- End SEO SCripts Footer s -->
	<script>
		jQuery(document).ready(function() {
			jQuery(document).on('click', '#vertical_blog_btn .elementor-button-link', function(e) {
				console.log('Open Popup');
				jQuery('html').addClass('uael-html-modal');
				jQuery('.uael-show').addClass('uael-modal-scroll');
			});
		});
	</script>
	</body>
</html>
