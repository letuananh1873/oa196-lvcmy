<?php
 $items =$GLOBALS['items'];
 $product_id = $items['product_id'];
?>
<div data-p-id="<?php echo $product_id; ?>" class="adv_single_container product_child" >
            <a href="<?php echo $items['product_url']; ?>"><div class="pruchase-online">Purchase Online</div></a>  
            <div class="adv_single_img"><a href="<?php echo $items['product_url']; ?>">
                <?php 
                /*var_dump(get_post_meta(36439));
               var_dump($product_id);

               var_dump(get_id_variation_valid($product_id,'white-gold','double-pave','round' ,'6-prong'));*/
               /*echo '<pre>';
                var_dump( get_post_meta(34982));  
                 echo '</pre>'; */             
               $thumb_url = $items['product_thumb_url'];
               if (isset($items['thumb_varaition_id'])) {
                $thumbnail_id = $items['thumb_varaition_id'];
                $thumb_url = get_the_post_thumbnail_url($thumbnail_id);
               }
                ?>
                <img src="<?php echo $thumb_url; ?>" alt="">
            </a></div>
            <div class="adv_single_price fgfgf" data-attr-price="<?php echo $items['product_price'] ?>">
                <?php echo $items['product_price_html'] ?></div>
            <div class="adv_single_attr_container">


                <div class="attr_wrapper_single">
                    <div class="attr_carats attr_value" data-attr-carats="<?php echo $items['product_carats'] ?>">
                        <?php echo $items['product_carats'] ?>
                    </div>
                    <div class="attr_label">Carats</div>
                </div>
                <div class="attr_wrapper_single">
                    <div class="attr_color attr_value">
                        <?php echo $items['product_color']->name ?>
                    </div>
                    <div class="attr_label">Color</div>
                </div>
                <div class="attr_wrapper_single">
                    <div class="attr_clarity attr_value">
                        <?php
                        $clarity_names = '';
                        foreach($items['product_clarity'] as $key => $clarity) {
                            $comma = ($key > 0) ? ', ' : '';
                            $clarity_names .= $comma.$clarity->name;
                        }
                        ?>
                        <?php echo $clarity_names ?>
                    </div>
                    <div class="attr_label">Clarity</div>
                </div>
                <?php if (!empty($items['product_cut'])): ?>
                <div class="attr_wrapper_single">
                    <div class="attr_cut attr_value">
                    <?php echo $items['product_cut']->name ?? '&nbsp;';?>
                </div>
                    <div class="attr_label">Cut</div>
                </div>
                <?php endif; ?>
                <div class="attr_wrapper_single">
                    <div class="attr_collection attr_value">
                    <?php echo $items['product_collection'] ?? "Lab Diamond"; ?>
                </div>
                    <div class="attr_label">Collection</div>
                </div>
            </div> <!-- adv_single_attr_container --> 
        </div><!-- adv_single_container -->