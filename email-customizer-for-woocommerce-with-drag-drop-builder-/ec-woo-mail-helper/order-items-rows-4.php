<?php
if (!defined('ABSPATH')) {
    exit;
}
$plain_text = "";
if (array_key_exists("plain_text", $args)) {
    $plain_text = $args['plain_text'];
}
$order = $GLOBALS['order'];
$row_index = 0;

$items = $order->get_items();
foreach ($items as $item_id => $item) :
    $_product = $item->get_product();
    $row_index++;
    if (apply_filters('woocommerce_order_item_visible', true, $item)) { ?>        
        <tr>           
                <td class="" width="120px"
                    style="text-align: left;  vertical-align: middle;font-family: inherit;font-size: 13px;word-wrap: break-word;border:none;padding-top: 15px;  padding-bottom: 15px;padding-left:0px;border-bottom:none;"><?php
                    echo '<table width="100%"><tr>';
                    echo '<td style="border:none;text-align: left; vertical-align: top;
                   border-bottom:none;">';
                    if ( ($_product instanceof WC_Product) && $_product->get_image_id()) {
                      echo apply_filters('woocommerce_order_item_thumbnail',
                      '<div class="product-image" style="display:inline-block;vertical-align:middle">'.
                      '<img src="' . ($_product->get_image_id() ? current(wp_get_attachment_image_src($_product->get_image_id(), 'thumbnail')) : wc_placeholder_img_src()) .'" alt="' . esc_attr__('Product Image', 'woocommerce') . '" height="'.esc_attr($args['image_height']).'" width="'.esc_attr($args['image_width']).'" style="height:'.esc_attr($args['image_height']).'px !important;width:'.esc_attr($args['image_width']).'px !important; vertical-align:middle; margin-right: 10px;" /></div>', $item);
                    }
                    echo '</td>';
                    echo '<td style="border:none;padding-left:15px;border-bottom:none;">';
                    echo '<div style="display:inline-block;vertical-align: middle;">';
                    echo apply_filters('woocommerce_order_item_name', '<div class="product-name">' .
                        '<a href="' . get_permalink($item->get_product_id()) . '">' . $item->get_name() . '</a>'
                        . '</div>', $item, false);

                    if ( is_object($_product) && $_product->get_sku()) {
                        echo ' <span class="product-sku"> (#' . $_product->get_sku() . ') </span>';
                    }

                    do_action('woocommerce_order_item_meta_start', $item_id, $item, $order, $plain_text);

                    echo '<br/><small class="product-meta">' . wc_display_item_meta($item) . '</small>';

                    if ($args['show_download_links']) {
                      echo wc_display_item_downloads( $item ,array('before' => "<div class='ec-download-item-list'><div class='ec-download-item'>", 'separator' => "</div><div class='ec-download-item'>", 'after' => "</div></div>", 'echo' => false));
                    }
                    echo '</div>';
                    do_action('woocommerce_order_item_meta_end', $item_id, $item, $order, $plain_text);
                    ?>
                    <div>
                        <?php _e('Quantity', 'woocommerce'); ?> :
                        <?php echo apply_filters('woocommerce_email_order_item_quantity', $item->get_quantity(), $item); ?>
                        </div>
                    <?php
                    echo '</td>';
                    echo '</tr></table>'; ?>
                </td>
               
                <td class="" width="15%"
                    style="text-align: right;vertical-align: middle;  font-family: inherit;font-size: 13px;  word-wrap: break-word;border:none;  padding-top: 15px;padding-bottom: 15px;padding-left:15px;padding-right: 0px;">
                    <?php echo $order->get_formatted_line_subtotal($item); ?>
                </td>
            

        </tr>
        
        <?php
    }

    if ( is_object($_product) && ($purchase_note = $_product->get_purchase_note())) : ?>
        <tr>
            <td colspan="2"
                style="text-align:left; vertical-align:middle;"><?php echo wpautop(do_shortcode(wp_kses_post($purchase_note))); ?></td>
        </tr>
    <?php endif; ?>

<?php endforeach; ?>
<tr><td colspan="2" style="padding-top:10px;padding-bottom:10px;"><hr></td></tr>