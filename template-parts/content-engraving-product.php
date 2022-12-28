<?php
global $product;
$font_type_terms = get_the_terms( $product->get_id(), "pa_font-type" );

$egv_attrs = $product->get_variation_attributes();
$egv_message = $egv_attrs["pa_your-engraving-message"] ?? array();
$egv_message = array_pop($egv_message);
$term_message = get_term_by("slug", $egv_message, "pa_your-engraving-message");
$term_message_label = $term_message ? get_field("placeholder",$term_message->taxonomy."_".$term_message->term_id) : "";
$text_of_button_edit_engraving = get_field("text_of_button_edit_engraving","option")?? "";
$text_placeholder_of_select_font_type = get_field("text_placeholder_of_select_font_type","option") ?? "";
$text_label_of_engraving_guide = get_field("text_label_of_engraving_guide","option") ?? "";
$text_link_of_engraving_guide = get_field("text_link_of_engraving_guide","option") ?? "/";
$max_length_of_message = $term_message ? get_field("max_length",$term_message->taxonomy."_".$term_message->term_id) : "";

?>
<div class="engraving">
    <div class="engraving-header">
        <button class="engraving-item engraving-button" id="edit-engraving" type="button">
            <span class="button--text"><?php echo $text_of_button_edit_engraving; ?></span>
        </button>
        <span class="text-demo"></span>
        <span class="mock--edit"><span class="mock--edit-text">
        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="7" viewBox="0 0 25 25" fill="none"><path d="M2.37106 0.406738L0.407089 2.37071L10.5362 12.4998L0.407089 22.629L2.37106 24.5929L12.5002 14.4638L22.6293 24.5929L24.5933 22.629L14.4642 12.4998L24.5933 2.37071L22.6293 0.406738L12.5002 10.5359L2.37106 0.406738Z" fill="black"></path></svg>
        Clear Engraving</span></span>
    </div>

    <div class="engraving-item engraving-item-edit engraving-item--canhide" >
        <select id="trigger_pa_font-type" name="pa_font_type"> 
            <option value="" disabled selected ><?php echo $text_placeholder_of_select_font_type; ?></option>
            <?php
            foreach($font_type_terms as $font_type_term){
                $slug = $font_type_term->slug;
                $font_type_term = get_term_by("slug", $slug, "pa_font-type");
                $acf_font_type_term_id = $font_type_term->taxonomy."_".$font_type_term->term_id;
                $term_current_font_familty = get_field("font_family",$acf_font_type_term_id)?? "";
                ?>
                <option data-font-family="<?php echo $term_current_font_familty; ?>" value="<?php echo urldecode($font_type_term->slug); ?>"><?php echo $font_type_term->name; ?></option>
                <?php
            }
            ?>
        </select>
        <!-- #70977 -->
        <?php
        $eng_font  = [];
        $cn_font = [];

        foreach($font_type_terms as $font_type_term) {
            $slug = $font_type_term->slug;
            $term = get_term_by("slug", $slug, "pa_font-type");  
            $is_cn = get_field('is_chinese', 'term_'.$font_type_term->term_id) ?? false;
            if($is_cn) {
                array_push($cn_font, $slug);
            } else {
                array_push($eng_font, $slug);
            }
        }
        ?>
        <div class="product-variable variable-language">
            <div class="container">
                <header>
                    <ul class="tab-head">
                        <?php 
                        // if($eng_font): 
                        
                        ?>
                        <li class="tab-choose active" data-tab="eng">English</li>
                        <?php //endif; ?>
                        <?php //if($cn_font): ?>
                        <li class="tab-choose" data-tab="cn">Chinese</li>
                        <?php //endif; ?>
                    </ul>
                    <input type="hidden" name="lag_active" id = "lag_active" value="eng">
                </header>
                <main>
                    <ul class="tab-font tab-eng active">                            
                        <?php
                        foreach($eng_font as $slug){
                            $term = get_term_by("slug", $slug, "pa_font-type");
                            $acf_font_type_term_id = $term->taxonomy."_".$term->term_id;
                            $term_current_font_familty = get_field("font_family",$acf_font_type_term_id)?? "";
                            ?>
                            <li data-font-family="<?php echo $term_current_font_familty; ?>" data-value="<?php echo $term->slug; ?>" style="font-family: <?php echo $term_current_font_familty; ?>"><?php echo $term->name; ?></li>
                            <?php
                        }
                        ?>
                    </ul>
                    <ul class="tab-font tab-cn">
                        <?php
                        foreach($cn_font as $slug){
                            $term = get_term_by("slug", $slug, "pa_font-type");
                            $acf_font_type_term_id = $term->taxonomy."_".$term->term_id;
                            $term_current_font_familty = get_field("font_family",$acf_font_type_term_id)?? "";
                            ?>
                            <li data-font-family="<?php echo $term_current_font_familty; ?>" data-value="<?php echo urldecode($term->slug); ?>" style="font-family: <?php echo $term_current_font_familty; ?>"><?php echo $term->name; ?></li>
                            <?php
                        }
                        ?>
                    </ul>
                </main>

            </div>
        </div>
        <!-- End #70977 -->
    </div>
    
    <div class="engraving-item engraving-item-edit engraving-item--message" >
        <input id="message" maxlength="<?php if($max_length_of_message){ echo $max_length_of_message; } else { echo '15'; }  ?>" data-select='<?php echo  $term_message->slug ?? ''; ?>' name="engraving_message" type="text" placeholder="<?php echo $term_message_label ?: 'Type Message...'; ?>" />
        <div class="engraving-footer">
            <p class="notice">Character limit: <span class="message-amount">0</span>/15</p>
            <button class="engraving-item engraving-button" id="edit-engraving" type="button">
                <span class="button--text"><?php echo $text_of_button_edit_engraving; ?></span>
            </button>
        </div>
    </div>
    <?php
    ?>
    <div class="engraving-item engraving-item--canhide" id="block-engraving-guide">
        <?php if(!empty($text_link_of_engraving_guide)): ?>
            <a href="<?php echo $text_link_of_engraving_guide; ?>"><?php echo $text_label_of_engraving_guide; ?></a>
        <?php else: ?>
            <p><?php echo $text_label_of_engraving_guide; ?></a></p>
        <?php endif; ?>
    </div>
</div>