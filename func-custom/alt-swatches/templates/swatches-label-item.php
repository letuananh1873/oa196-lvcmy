<?php
if (function_exists('cmp')) {
    usort($terms,"cmp");
}
?>
<ul>
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
            '<li id="alt-colorswatches-%s-item" class="%s" data-name="%s" data-label="%s"><span>%s</span></li>',
            $term->slug,
            $classes,
            $term->slug,
            $term->name,
            $term->name
        );
    }?>
</ul>