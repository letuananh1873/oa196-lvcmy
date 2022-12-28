<!-- <div class="filter_popup_wrap">
	<div class="filter_popup_inner">
		<div class="modal__close"><img src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/icon-close.svg'></div>
		<div class="filter_item_popup">
			<div class="filter_left_box">
				<img src="https://p1.iconceptdigital.com/love-co/ebase-uploads/2020/06/Product.jpg" alt="">
				<h2 class="filter_item_title">Lorem ipsum dolor sit amet, consectetur adipiscing elit</h2>
				<div class="filter_item_style">Style #123456</div>
				<div class="filter_item_certificate">
					<img src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/diamond-icon.svg'>
					<a href="">Love & Co. Diamond Certificate</a>
					<img src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/icon-question.svg'>
				</div>
				<ul class="filter_item_attr">
					<li>
						<div class="item_attr_value filter_item_carat_value">1.5</div>
						<div class="item_attr_label">Carat</div>
					</li>
					<li>
						<div class="item_attr_value filter_item_carat_value">D</div>
						<div class="item_attr_label">Color</div>
					</li>
					<li>
						<div class="item_attr_value filter_item_carat_value">VS1</div>
						<div class="item_attr_label">Clarity</div>
					</li>
					<li>
						<div class="item_attr_value filter_item_carat_value">Triple EX</div>
						<div class="item_attr_label">Cut</div>
					</li>
				</ul>
			</div>

			<div class="filter_right_box">
				<h2 class="filter_right_bigTitle">Beautiful choice!</h2>
				<div class="filter_item_desc">To purchase this ring or learn more, book an appointment with our Diamond Concierge.</div>
				<div class="need_help">
					<p>Need help?</p>
					<div class="booking_form_btn">
						<a href="https://p1.iconceptdigital.com/love-co/book-an-appointment/">
							<img src="https://p1.iconceptdigital.com/love-co/ebase-theme/assets/images/icon-store-book.svg">Book an Appointment
						</a>
					</div>
				</div>
				<div class="filter_popup_cart_wrap">
					<div class="filter_item_price">$14,000</div>
					<div class="filter_popup_cart_btn">Add to Bag</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
/*Engagement ring popup*/
jQuery( document ).ready(function($) {
	var scrollPos;

	if ($(window).width() > 768) {
		var headerHeight = $("#header-box").height();
	}
	else {
		var headerHeight = 50;
	}
	
	var windowHeight =  $(window).height();
	var boxHeight = windowHeight - headerHeight;
	$('.adv_single_container:not(.needhelp) ').click(function() {
		scrollPos = $(window).scrollTop();
		$('.filter_popup_wrap').height(boxHeight);
		$('.filter_popup_wrap').slideToggle("slow");
		$('body').addClass('fixed').css({ top: -scrollPos });
		return false;
	});
	$('.modal__close').click(function() {
		$('.filter_popup_wrap').slideToggle("slow");
		$('body').removeClass('fixed').css({ top: 0 });
		$(window).scrollTop(scrollPos);
		return false;
	});
});
</script> -->