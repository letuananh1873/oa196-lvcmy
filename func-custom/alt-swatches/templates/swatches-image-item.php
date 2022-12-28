<ul>
    <?php
    foreach( $terms as $k => $term ) {
        $image_id = get_term_meta( $term->term_id, 'image', true );

        $attachment_image = wp_get_attachment_url($image_id, 'full');
        $is_outstock = alt_check_attribute_outstock($product->get_id(), $term->taxonomy, $term->slug);

        $classes = ($selected == $term->slug) ? ' selected' : '';
        if( ! empty($is_outstock) && $total_attribute == 1 ) {
            $classes .= ' alt-colorswatche-disable-item';
        }

        if( ! empty($extra_class) && $k == 0 ) {
            $classes .= ' selected';
        }
        
        printf(
            '<li id="alt-colorswatches-%s-item" class="%s" data-name="%s" data-label="%s"><span style="background-image: url(%s)"></span></li>',
            $term->slug,
            $classes,
            $term->slug,
            $term->name,
            esc_url($attachment_image)
        );
    }?>
</ul>