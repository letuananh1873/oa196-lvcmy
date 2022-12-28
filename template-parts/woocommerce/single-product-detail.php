<?php
$text_shippings = get_field('text_shipping', 'option');
$return_policy = get_field('return_policy', 'option');
if( ! empty($return_policy['title']) ) {
    printf(
        '<a href="%s" class="link-return-policy"%s>%s</a>',
        esc_url($return_policy['url']),
        empty($return_policy['target']) ? '' : ' target="_blank"',
        esc_attr($return_policy['title'])
    );
}?>

<ul class="alt-single-shipping-text">
    <?php if( ! empty($text_shippings) ) {
        foreach( $text_shippings as $shiping) {?>
    <li>
        <div class="alt-single-shipping-icon">
            <img src="<?php echo esc_url( $shiping['image']);?>" />
        </div>
        <span><?php echo wp_kses($shiping['text'], array(
            'a' => array(
                'href' => array(),
                'title' => array()
            ),
            'img' => array(
                'width' => array(),
                'src' => array()
            )
        ));?></span>
    </li>
    <?php }
    }?>
</ul>

<?php $product_tabs = apply_filters( 'woocommerce_product_tabs', array() );
if ( ! empty( $product_tabs ) ) { ?>
<div class="alt-single-product-tabs">
    <ul class="alt-single-product-tab-items" role="tablist">
        <?php
        $i = 0;
        foreach ( $product_tabs as $key => $product_tab ) : ?>
            <li class="alt-single-product-tab-item<?php echo ($i == 0) ? ' active': '';?>" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
                <a href="#tab-<?php echo esc_attr( $key ); ?>" class="alt-single-product-tab-title">
                    <?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
                </a>

                <div class="alt-single-product-tab-content"<?php echo ($i == 0) ? ' style="display: block;"' : '';?>>
                    <?php
                        if ( isset( $product_tab['callback'] ) ) {
                            call_user_func( $product_tab['callback'], $key, $product_tab );
                        }
                    ?>
                </div>
            </li>
        <?php $i++;
        endforeach; ?>
    </ul>
</div>
<?php }?>