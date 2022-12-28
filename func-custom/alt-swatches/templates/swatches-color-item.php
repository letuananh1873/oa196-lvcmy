<?php
$obj_term = get_queried_object() ??'';
$slug = '';
if (!empty($obj_term)) $slug = $obj_term -> slug??'';
?>
<ul>
    <?php
    foreach( $terms as $k => $term ) {
        $color = get_term_meta( $term->term_id, 'color', true );
        $is_outstock = alt_check_attribute_outstock($product->get_id(), $term->taxonomy, $term->slug);

        $classes = ($selected == $term->slug) ? ' selected' : '';
        if( ! empty($is_outstock) && $total_attribute == 1) {
            $classes .= ' alt-colorswatche-disable-item';
        }

        if( ! empty($extra_class) && $k == 0 ) {
            $classes .= ' selected';
        }
        $pos = strpos($term->slug,$slug);
        $active = $pos !== false ? 'selected' :'';
        
        printf(
            '<li id="alt-colorswatches-%s-item" class="%s %s" data-name="%s" data-label="%s"><span style="background-color: %s"></span></li>',
            $term->slug,
            $classes,
            $active,
            $term->slug,
            $term->name,
            $color
        );
    }?>
</ul>