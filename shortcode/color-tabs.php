
<?php if(get_field('diamond_color_tab')): ?>
	<div class="diamondColorTabBox">
		<div class="color-image-wrap">
			<?php while ( have_rows('diamond_color_tab') ) : the_row();  ?>
				<div class="color-image-boxes">
					<div class="color-img"><img src="<?php the_sub_field('color_image'); ?>"></div>
				</div>
			<?php endwhile;  ?>
		</div>

		<ul class="tab js-tab color-title-tab">
			<?php while(has_sub_field('diamond_color_tab')): ?>
				<li class="tab__unit"><?php the_sub_field('color_title'); ?></li>
			<?php endwhile; ?>
		</ul>
		

		<div class="tabCBoxs js-tabCBoxs color-contentBox">
			<?php while ( have_rows('diamond_color_tab') ) : the_row();  ?>
				<div class="tabCBox">
					<h5 class="color-title"><?php the_sub_field('color_title'); ?></h5>
					<div class="color-desc"><?php the_sub_field('color_description'); ?></div>
				</div>
			<?php endwhile;  ?>
		</div>
	</div>

	<style>
	.dnone {
		display: none;
	}
	</style>

    <script>
    jQuery(document).ready(function($) {

		$(".js-tab .tab__unit:nth-of-type(1)").addClass("active");

		$(".tabCBoxs .tabCBox").addClass("dnone");
		$(".tabCBoxs .tabCBox:nth-of-type(1)").removeClass("dnone");

		$(".color-image-boxes").addClass("dnone");
		$(".color-image-boxes:nth-of-type(1)").removeClass("dnone");

		$(".js-tab .tab__unit").click(function() {
			if(!$(this).hasClass('active')){
				$(this).parents(".js-tab").find(".tab__unit").removeClass('active');
				$(this).addClass('active');

				var tabNum = $(this).index();
				$(this).parents(".js-tab").next(".js-tabCBoxs").find(".tabCBox").hide();
				$(this).parents(".js-tab").next(".js-tabCBoxs").find(".tabCBox").eq(tabNum).fadeIn("500");

				$(this).parents(".diamondColorTabBox").find(".color-image-wrap").find(".color-image-boxes").hide();
				$(this).parents(".diamondColorTabBox").find(".color-image-wrap").find(".color-image-boxes").eq(tabNum).show();

			}
		});
    });
    </script>

<?php endif; ?>
