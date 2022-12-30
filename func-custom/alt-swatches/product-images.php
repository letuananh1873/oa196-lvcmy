<?php
global $product;
$thumbnail_id = $product->get_image_id();
$_attachment_ids = $product->get_gallery_image_ids();
$_attachment_ids = empty($_attachment_ids) ? [] : $_attachment_ids;

$attachment_ids = array();
if( ! empty($thumbnail_id) ) {
    $attachment_ids[] = $thumbnail_id;
}

$attachment_ids = array_merge($attachment_ids, $_attachment_ids);

$totalImage = count($attachment_ids);

//$parentClass = ($totalImage > 3) ? ' class="alt-gallery-image-preloading"' : '';
$parentClass = '';

?>
<div id="alt-product-image-container"<?php echo $parentClass;?> data-total_image="<?php echo absint($totalImage);?>">
    <div class="alt-product-image-primary">
        <?php if( ! empty($attachment_ids) ) {
            $extra_class = 'alt-product-image-one-col';
            // || $product->get_type() == 'variable' && $totalImage > 3
            if( $totalImage > 3 ) {
                $extra_class = 'alt-product-image-two-col';

                // echo '<div class="waitMe_content">
                //     <div class="waitMe_box">
                //         <div class="waitMe_progress bounce">
                //             <div class="waitMe_progress_elem1" style="background: #000;"></div>
                //             <div class="waitMe_progress_elem2" style="background: #000;"></div>
                //             <div class="waitMe_progress_elem3" style="background: #000;"></div>
                //         </div>
                //         <div class="waitMe_text" style="color: #000;">Please waiting...</div>
                //     </div>
                // </div>';

                $images = array();
                foreach( $attachment_ids as $attachment_id) {
                    $src = wp_get_attachment_image_src($attachment_id, 'full');

                    $images[] = array(
                        'full_src' => $src[0]
                    );
                }

                // if( ! empty($images) ) {
                //     printf("<script>var galleryImages = '%s';</script>", json_encode($images));
                // }
            }

                printf('<div class="alt-product-image-wrapper %s">', $extra_class);
                foreach( $attachment_ids as $attachment_id) {
                    echo '<div class="alt-product-image-item">';
                    echo wp_get_attachment_image($attachment_id, 'full', false, ["class" => "ez-plus-image"]);
                    echo '</div>';
                }
                echo '</div>';

        }
        ?>
    </div>

    <?php if( $totalImage > 100 ) { ?>
    <div id="alt-product-image-thumbnail">
        <div class="alt-product-image-thumbnail-wrapper">
            <?php
            foreach( $attachment_ids as $attachment_id) {
                echo '<div class="alt-product-image-item">';
                echo wp_get_attachment_image($attachment_id, 'full', false);
                echo '</div>';
            }?>
        </div>
    </div>
    <?php }?>
</div>

<script id="tpl-product-image-loading" type="text/html">
    <div class="waitMe_content">
        <div class="waitMe_box">
            <div class="waitMe_progress bounce">
                <div class="waitMe_progress_elem1" style="background: #000;"></div>
                <div class="waitMe_progress_elem2" style="background: #000;"></div>
                <div class="waitMe_progress_elem3" style="background: #000;"></div>
            </div>
            <div class="waitMe_text" style="color: #000;">Please waiting...</div>
        </div>
    </div>
</script>