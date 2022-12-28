<ul class="store_email_btns">
	<li>
		<a href="mailto:<?php the_field('store_email'); ?>">
		<span class="store_email_icon"><img src="<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/icon-store-email.svg"></span>
			<span class="store_email_text">Email</span>
		</a>
	</li>
	<li>
		<a href="mailto:<?php the_field('store_email'); ?>">
			<span class="store_email_icon"><img src="<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/icon-store-book.svg"></span>
			<span class="store_email_text">Book an Appointment</span>
		</a>
	</li>
</ul>