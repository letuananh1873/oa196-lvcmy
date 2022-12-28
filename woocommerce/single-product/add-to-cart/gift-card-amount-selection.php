<?php
/**
 * Gift Card product add to cart
 *
 * @author  Yithemes
 * @package YITH WooCommerce Gift Cards
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

?>
    <h3 class="ywgc_select_amount_title"><?php echo get_option( 'ywgc_select_amount_title' , esc_html__( "Set an amount", 'yith-woocommerce-gift-cards') ); ?></h3>


    <?php if ( $amounts ) : ?>


    <?php do_action( 'yith_gift_card_amount_selection_first_option', $product ); ?>
    <div class="giftcard_amount_wrap">
    <?php foreach ( $amounts as $value => $item ) : ?>
        <button class="ywgc-predefined-amount-button ywgc-amount-buttons" value="<?php echo $item['amount']; ?>"
                data-price="<?php echo $item['price']; ?>"
                data-wc-price="<?php echo strip_tags(wc_price($item['price'])); ?>">
            <?php echo apply_filters( 'yith_gift_card_select_amount_values' , $item['title'], $item ); ?>
        </button>

        <input type="hidden" class="ywgc-predefined-amount-button ywgc-amount-buttons" value="<?php echo $item['amount']; ?>"
               data-price="<?php echo $item['price']; ?>"
               data-wc-price="<?php echo strip_tags(wc_price($item['price'])); ?>" >

    <?php endforeach; ?>
    </div>
<?php
endif;

do_action( 'yith_gift_card_amount_selection_last_option', $product );
do_action( 'yith_gift_cards_template_after_amounts', $product ); ?>


<table class="variations" cellspacing="0">
    <tr>
        <td class="label"><label>Who am I purchasing this for? </label></td>
        <td class="value">
            <select id="purchasing_for">
                <option value="someone_else">Someone else</option>
                <option value="for_myself">For myself</option>
            </select>
        </td>
    </tr>
</table>


<?php if ( ! $product->is_sold_individually () ) : ?>
    <?php woocommerce_quantity_input ( array( 'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount ( $_POST['quantity'] ) : 1 ) ); ?>
<?php endif; ?>

<script>
    jQuery(function($){
        $("#purchasing_for").on('change',function(){
            if( $(this).val() == "for_myself" ) {
                $(".giftInfoBox, h3.ywgc_delivery_info_title").fadeOut();
            } else {
                $(".giftInfoBox, h3.ywgc_delivery_info_title").fadeIn();
            }
        });
    });
</script>