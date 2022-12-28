<ul class="store_tel_directions">
	<?php if( get_field('store_phone_no') ): ?>
		<li><img src="<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/icon-store-tel.svg"><?php the_field('store_phone_no'); ?></li>
	<?php endif; ?>
	<?php if( get_field('store_direction') ): ?>
		<li><img src="<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/icon-store-direction.svg"><?php the_field('store_direction'); ?></li>
	<?php endif; ?>
</ul>