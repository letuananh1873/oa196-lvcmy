<?php
/**
 * Email Order Items
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-items.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

$text_align  = is_rtl() ? 'right' : 'left';
$margin_side = is_rtl() ? 'left' : 'right';

foreach ( $items as $item_id => $item ) :
	$product       = $item->get_product();
	$sku           = '';
	$purchase_note = '';
	$image         = '';




	if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
		continue;
	}

	if ( is_object( $product ) ) {
		$sku           = $product->get_sku();
		$purchase_note = $product->get_purchase_note(); 
		// $image         = $product->get_image( $image_size );
		$image         = $product->get_image( array("100","100") );
	}

	?>
	<tr  class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'order_item', $item, $order ) ); ?>">
		<td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>; 
		vertical-align: middle; 
		font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; 
		word-wrap:break-word; 
		border: none;
		">
		<?php

		// Show title/image etc.
		if ( $show_image ) {
			echo '<div style="border:solid 1px #cccccc;padding-left:10px">';
			echo wp_kses_post( apply_filters( 'woocommerce_order_item_thumbnail', $image, $item ) );
			echo '</div>';
		}
		?>
		</td>
		<td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>; vertical-align:middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; border:none; vertical-align: top;padding-right:15px;">
		<?php
		// Product name.
		echo wp_kses_post( apply_filters( 'woocommerce_order_item_name', $item->get_name(), $item, false ) );

		// SKU.
		if ( $sku ) {
			echo wp_kses_post( ' (' . $sku . ')' );
		}
		// allow other plugins to add additional product information here.
		do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, $plain_text );

		wc_display_item_meta(
			$item,
			array(
				'label_before' => '<strong class="wc-item-meta-label" style="float: ' . esc_attr( $text_align ) . '; margin-' . esc_attr( $margin_side ) . ': .25em; clear: both">',
			)
		);

		// allow other plugins to add additional product information here.
		do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, $plain_text );
		
		// process info
		// acf field show note of sale product
		$sale_note = get_field("sale_product_note","option") ? get_field("sale_product_note","option") : "";
		if($product->get_type() == "variation"){
			$temp_product_id = $product->get_id();
			$parent_id = $product->get_parent_id();
		}else{
			$temp_product_id = $parent_id = $product->get_id();
		}

		// if product customise 
		// check if customise 
		// check if product is gold bar custom | name necklace | charm necklace
		// show line "10 weeks lead line"
		// customise process
		$customise_product = get_field("customise_product",$temp_product_id);
		$has_customise_product = isset($customise_product) && !empty($customise_product) ? true : false;
		$customise_note = "";
		if($has_customise_product){
			$customise_product_type = get_post_meta($temp_product_id,"customise_product_type",true);
			if(have_rows("customise_product_note","option")):
				while(have_rows("customise_product_note","option")):
					the_row();
					$temp_type = get_sub_field("type");
					$temp_note = get_sub_field("note") ? get_sub_field("note") : "";
					if($temp_type == $customise_product_type){
						$customise_note = $temp_note;
					}
				endwhile;
			endif; 
		}


		// show info
		// customise note
		if(!empty($customise_note)){
			echo "<p><small><em>".$customise_note."</em></small></p>";
		}
		// sale note
		if(has_term("sale","product_cat",$parent_id)){
			echo "<p><small><em>".$sale_note."</em></small></p>";
		} 

		/**
		 * Check if this product is onbackorder or not, If correct, then add a text after showing the stock date.
		*/
		$product_last_id = $product->get_id();
		if($product->get_type() == 'variation') {
			$product_last_id = $product->get_parent_id();
		}

		$prd_stock = get_post_meta( $product_last_id, '_stock_status', true );

		if($prd_stock == 'onbackorder') {

			$prd_esd = strtr(apply_filters('get_esd_acf', $product->id), '/', '-');
			$prd = wc_get_product($product_last_id);
			$prd_stock_num = $prd->get_stock_quantity();
			$prd_stock = get_post_meta( $product_last_id, '_stock_status', true );
			$prd_manage_stock = $prd->managing_stock();
			$prd_type = $prd->get_type();
			if($prd_manage_stock) {
				if(!empty($prd_esd) && $prd_stock_num < 0) {
					echo "<p><b>Estimated Shipping Date: </b> <br>".date( 'M d, Y', strtotime($prd_esd))."</p>";
				}
			} else {
				if(!empty($prd_esd)) {
					echo "<p><b>Estimated Shipping Date: </b> <br>".date( 'M d, Y', strtotime($prd_esd))."</p>";
				}
			}

		}
		?>
			
		</td>
		<td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>; vertical-align:middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; border:none; vertical-align: bottom;padding-left:20px; text-align: right;">
			Quantity:
		<?php
			$qty          = $item->get_quantity();
			$refunded_qty = $order->get_qty_refunded_for_item( $item_id );

			if ( $refunded_qty ) {
				$qty_display = '<del>' . esc_html( $qty ) . '</del> <ins>' . esc_html( $qty - ( $refunded_qty * -1 ) ) . '</ins>';
			} else {
				$qty_display = esc_html( $qty );
			}
			echo wp_kses_post( apply_filters( 'woocommerce_email_order_item_quantity', $qty_display, $item ) );
			?>
			<br/>
			<?php echo 'Total:'.wp_kses_post( $order->get_formatted_line_subtotal( $item ) ); ?>
		</td>
		
	</tr>
	<?php

	if ( $show_purchase_note && $purchase_note ) {
		?>
		<tr>
			<td colspan="3" style="text-align:<?php echo esc_attr( $text_align ); ?>; vertical-align:middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">
				<?php
				echo wp_kses_post( wpautop( do_shortcode( $purchase_note ) ) );
				?>
			</td>
		</tr>
		<?php
	}
	?>

<?php endforeach; ?>
