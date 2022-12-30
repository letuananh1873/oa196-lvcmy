<select name="alt">
    <?php
    foreach( $terms as $k => $term ) {
        $is_outstock = alt_check_attribute_outstock($product->get_id(), $term->taxonomy, $term->slug);

        $classes = ($selected == $term->slug) ? ' selected' : '';
        if( ! empty($is_outstock) && $total_attribute == 1 ) {
            $classes .= ' alt-colorswatche-disable-item';
        }

        
        if( ! empty($extra_class) && $k == 0 ) {
            $classes .= ' selected';
        }

        printf(
            '<option id="alt-colorswatches-%1$s-item" value="%1$s" data-name="%1$s" data-label="%3$s"%2$s>%3$s</option>',
            $term->slug,
            $classes,
            $term->name
        );
    }?>
</select>