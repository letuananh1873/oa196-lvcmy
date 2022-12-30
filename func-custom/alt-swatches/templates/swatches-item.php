<div id="alt-colorswatches-<?php echo esc_attr($attribute_name);?>" class="alt-colorswatches-item alt-colorswatches-<?php echo esc_attr($attr->attribute_type);?>-type alt-colorswatches-<?php echo esc_attr($style);?>-style<?php echo empty($extra_class) ? '' : ' '. $extra_class;?>" data-attribute="<?php echo esc_attr($attribute_name);?>">
    <div class="alt-colorswatches-item-label">
        <label><?php echo $name;?>: </label>
        <div class="alt-colorswatches-item-label-selected"></div>
    </div>

    <?php
        echo '<div class="alt-colorswatches-item-attributes">';
        include ALT_SWATCHES_PATH . 'templates/swatches-' . $attr->attribute_type .'-item.php';
        echo '</div>';

?>
</div>