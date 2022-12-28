<?php
defined( 'ABSPATH' ) || exit;
add_action('add_list_coupon','html_list_coupon');
function html_list_coupon() {
	global $woocommerce;
	global $WC_Coupon;
	$coupons = get_all_coupons_valid('');
	$counpon_exits = $woocommerce->cart->get_applied_coupons()??array();
	if (count($coupons)): ?>		
		<ul class="list-coupon">
			<?php
			foreach ($coupons as $key => $coupon_code) { ?>
				<?php
				$class_auto_coupon = strtolower($coupon_code) == strtolower(coupon_code_order_first()) ? 'auto_coupon hidden' : '';
				$img_url = get_template_directory_uri().'/func-custom/custom-coupon/imgs/icon-discount.png';
				$img = '<img src="'.$img_url.'"  alt="" />';
				if (!in_array(strtolower($coupon_code),$counpon_exits)): ?>
				<li class="coupon_item <?php echo $class_auto_coupon; ?>" data-coupon="<?php echo $coupon_code; ?>">
					<div class="part-coupon"><?php echo $img; ?> Discount Code: </div>
					<div class="part-coupon code-coupon"><?php echo $coupon_code; ?></div>
				</li>
			<?php  endif;} ?>				
		</ul>		
	<?php endif;
}

