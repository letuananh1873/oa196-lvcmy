<?php
/**
 * Gift Card product add to cart
 *
 * @author  Yithemes
 * @package YITH WooCommerce Gift Cards
 *
 */
if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( ! $product->is_purchasable () ) {
	return;
}
$product_id = yit_get_product_id ( $product );

?>
<div class="gift_card_template_button variations_button">
	
	<button type="submit" class="single_add_to_cart_button gift_card_add_to_cart_button button alt">ADD TO BAG</button>
	<input type="hidden" name="add-to-cart" value="<?php echo absint ( $product_id ); ?>" />
	<input type="hidden" name="product_id" value="<?php echo absint ( $product_id ); ?>" />
</div>