<div class="wrap">
    <div id="icon-tools" class="icon32"></div>
    <h2>Bulk Price<a href="<?php echo admin_url('admin.php?page=bulk-price-page&act=new');?>" class="page-title-action">Add New</a></h2>
    
    <div class="bulk-price-form">
        <form action="" method="POST">
            <div class="bulk-price-row">
                <label>Product ID</label>
                <input type="text" name="product_id" value="<?php echo isset($data['product_id']) ? sanitize_text_field($data['product_id']) : '';?>" />
            </div>

            <div class="bulk-price-row">
                <label>Fixed Price</label>
                <input type="text" name="price" value="<?php echo isset($data['fixed_price']) ? sanitize_text_field($data['fixed_price']) : '';?>"/>
            </div>

            <div class="bulk-price-attributes">
                <div>
                    <?php
                    $total = count(bulk_price_attributes());
                    foreach( bulk_price_attributes() as $key => $attribute ) {
                        $rkey = ($key % 10);
                        if( $rkey == 0) {
                            echo '<div class="bulk-attribute-row">'."\n";
                        }

                        $value = 0;
                        if( isset($data['attributes'][$attribute]) ) {
                            $value = sanitize_text_field($data['attributes'][$attribute]);
                        }
                    

                        echo '<div class="bulk-attribute-item"><div class="bulk-attribute-content"><label>' . implode(',', $attribute).'</label>';
                            echo '<input type="text" name="attributes['.$key.']" value="'.$value.'"/>';
                        echo '</div></div>'."\n";

                        if( $rkey == 9 || $key == ($total - 1) ) {
                           echo '</div>' . "\n";
                        }
                    }?>
                </div>
            </div>
            
            <div class="bulk-price-action">
                <button type="submit" class="components-button editor-post-publish-button editor-post-publish-button__button is-primary">Add New</button>
            </div>
        </form>
    </div>
</div>