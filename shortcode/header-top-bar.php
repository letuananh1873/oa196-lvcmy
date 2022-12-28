<?php if( have_rows('header_top_bar',58) ):?>
	<style>
		.header_top_bar p {
			cursor: pointer;
		}
	</style>
	<div class="header_top_bar">
		<div class="header_top_bar_inner">  	
			<div class="announcments">
			<?php
			while( have_rows('header_top_bar',58) ) : the_row();
				$sub_value = get_sub_field('announcment_item');
				$sub_url = get_sub_field('announcment_redirect');
			?>
				<?php
				$onclick = "";
				if(get_sub_field("class") == "klaviyo") : 
					$onclick = "KlaviyoSubscribe.attachToModalForm('#k_id_modal', {
						delay_seconds: 0.01, 
						hide_form_on_success: true,
						ignore_cookie: true, 
						success_message: false, 
						success: function (&#36;form) {
							&#36;form.find('.hidden-after-success').hide();
						},
					})";
				endif;
				?>
				<div class="item"  onclick="<?php echo $onclick; ?>">
					<p>
						<?php if(is_array($sub_url) && !empty($sub_url['url'])) echo '<a href="'.$sub_url['url'].'" target="'.$sub_url['target'].'" title="'.$sub_url['title'].'" class="announcments-url">'; ?>
						<?php //echo esc_html($sub_value); ?>
						<?php echo strip_tags($sub_value); ?>
						<?php if(is_array($sub_url) && !empty($sub_url['url'])) echo '</a>'; ?>
					</p>
				</div>
			<?php endwhile; ?>
			</div>
		</div>
		<span class="header_top_bar_close"><img width="15" height="15" src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/icon-close-black.svg'></span>
	</div>
	<script>
		jQuery(document).ready(function($) { 
			$(".header_top_bar_close").click(function () {
				$(this).prev(".header_top_bar_inner").fadeOut("fast");
				$(this).fadeOut("fast");
			});
		});
	</script>
<?php endif;