<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.5
 */

defined( 'ABSPATH' ) || exit;

global $product,$post;
$product_id = $product->get_id();
/*$str_filter = str_filter_variation_diamond_selected();
$variation_query = products_diamond_variation($str_filter,'',1,-1,array($product_id));
$total = $variation_query -> found_posts;*/

//// end test 

$class_child = class_child_product($product_id);
//$parent_0 = !empty($class_child) && $total==0 ?'parent_0' : '';
$cate_dimond = get_term_product_in_diamond($product_id);

$class_dimond = count($cate_dimond) > 0 ? 'diamon-type' : '';
$available_variations = $product->get_available_variations();
$attribute_keys  = array_keys( $attributes ) ?? array();
$variations_json = wp_json_encode( $available_variations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );
$tr_variation_class = "";
$option_class = '';
$engraving_class = "";
if(is_allow_engraving($product)){
	$engraving_class = "engraving-product";
}	
do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart <?php echo $engraving_class; ?>" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>">
	<input type="hidden" name="p_id" id="p_id" value="<?php echo get_the_ID(); ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'woocommerce' ) ) ); ?></p>
	<?php else : ?>
		<table class="variations variations_<?php echo $class_dimond; ?>" cellspacing="0">
			<tbody>
				<?php
				$attributes1 = $attributes;
				$variation_selected = get_selected_variation();
				
				$i = 0;
				?>
				<?php foreach ( $attributes1 as $attribute_name => $options ) : ?>
				<?php 
				$i++;
				if ($i == 2 && !empty($class_child)) { ?>
					<tr>						
						<td colspan=2 class="value">
							<div class="tax-attribute-item" style="text-align: left;">
							<div class="taxonomy-name"><strong>Centerstone:</strong></div>
							<div class="attribute-item-name centerstone_item">
								<?php echo get_meta_centerstone ($product_id); ?>
							</div>	
							<?php
							$_diamond_shapes = $_GET['_dianmond_shapes'] ?? '';
							$_metal_type = $_GET['_metal_type'] ?? '';
							$_casing = $_GET['_casing'] ?? '';
							$_diamond_type = $_GET['_diamond_type'] ?? '';
							$p_id = $_GET['p_id'] ?? '';
							$url = sprintf('/select-diamond/?_dianmond_shapes=%s&_metal_type=%s&_casing=%s&_diamond_type=%s&p_id=%d', $_diamond_shapes, $_metal_type, $_casing,$_diamond_type, $p_id);
							?>	
							<a id="centerstone_link" data-link = "<?php echo home_url( '/select-diamond'); ?>"  href="<?php echo home_url($url); ?>"><div class="extral-attr modyfy-select">Modify</div></a>
							
						</td>
					</tr>
				<?php } // end centerstone

				if (array_key_exists($attribute_name,$variation_selected)) {					
				 $selected =  wc_clean( urldecode( $variation_selected[$attribute_name] ) ) ;
				}	else{
					$selected = $product->get_variation_default_attribute( $attribute_name );
				}		
				if (empty($selected)) {					
				//	$selected = array_shift(array_values($options));
					$selected = reset($options);
					
				} 
				//echo $selected;

				/*if ( $total == 0) {
					$selected = '';
				}*/
				if(is_allow_engraving($product)){
					$engraving_taxonomy = engraving_taxonomy();
				
					if(in_array($attribute_name,$engraving_taxonomy)){
						$tr_variation_class = "class='engraving-variation-row'";
						$option_class = ' not-empty';
					}
				}
				?>
				<?php
					// #92696
					$attr_td = count($cate_dimond) > 0 ? "colspan=2":'';
					$style = ($attribute_name !== 'pa_diamond-type') ? "" : 'style="display: none !important;"';
					// End #92696
				?>
					<tr <?php echo $tr_variation_class; ?>  <?php echo $style; ?>>
						<?php if (count($cate_dimond) == 0) { ?>
						<td class="label">							
							<label for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>"><?php echo wc_attribute_label( $attribute_name ); // WPCS: XSS ok. ?></label>						
						</td>
						<?php } ?>

						<td <?php echo $attr_td; ?> class="value <?php echo $class_dimond; ?>">
							<?php							
							if (count($cate_dimond) > 0) { 								
								$default = get_term_by('slug', $selected, $attribute_name);
								
								$name_default = '';
								if (is_object($default)) 
									$name_default = $default->name;


								echo diamond_custom_variable($attributes,$product,$attribute_name,$class_child,$name_default,$selected,$options);
							} ?>
							<?php
							if (count($cate_dimond) > 0) {  echo '<div class="wrapper-variation">'; }	
								wc_dropdown_variation_attribute_options(
									array(
										'options'   => $options,
										'attribute' => $attribute_name,
										'product'   => $product,
										'selected' => $selected,
										'class'    => 'variation_item' . $option_class,
									)
								);
								if (count($cate_dimond) > 0) { echo '</div>'; }
								echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'woocommerce' ) . '</a>' ) ) : '';
							?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<div class="single_variation_wrap">
			<?php
				/**
				 * Hook: woocommerce_before_single_variation.
				 */
				do_action( 'woocommerce_before_single_variation' );

				/**
				 * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
				 *
				 * @since 2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				do_action( 'woocommerce_single_variation' );

				/**
				 * Hook: woocommerce_after_single_variation.
				 */
				do_action( 'woocommerce_after_single_variation' );
			?>
		</div>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php
do_action( 'woocommerce_after_add_to_cart_form' );
///endif;
