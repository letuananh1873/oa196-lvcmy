<?php if( get_field('sale_page_top_banner',14) ): ?>
    <div  id="sale_top_banner">
        <div class="proudct_overview_top_banner">
            <div class="top_banner_bg"><img src="<?php the_field('sale_page_top_banner',14); ?>"></div>
            <div class="top_banner_textBox" style="align-items: <?php
                    if( get_field('sale_text_box_vertical_alignment', 14) == 'Top' ) { 
                        echo "flex-start";
                    }else if( get_field('sale_text_box_vertical_alignment', 14) == 'Bottom' ) { 
                        echo "flex-end";
                    } else if( get_field('sale_text_box_vertical_alignment', 14) == 'Middle' ) { 
                        echo "center";
                    }
                ?> ; justify-content: <?php
                    if( get_field('sale_text_box_horizontal_alignment', 14) == 'Left' ) { 
                        echo "flex-start";
                    }else if( get_field('sale_text_box_horizontal_alignment', 14) == 'Right' ) { 
                        echo "flex-end";
                    } else if( get_field('sale_text_box_horizontal_alignment', 14) == 'Middle' ) { 
                        echo "center";
                    }
                ?> ;">
                <div class="textbox_moving">
                    <h1 class="top_banner_title"><?php the_field('sale_top_banner_title', 14); ?></h1>
                    <div class="top_banner_description"><?php the_field('sale_top_banner_description', 14); ?></div>
                </div>
            </div>
        </div>

        <div class="proudct_overview_top_banner_sp">
            <div class="top_banner_bg_sp"><img src="<?php the_field('sale_page_top_banner_mobile', 14); ?>"></div>
            <div class="top_banner_textBox_sp">
                <h1 class="top_banner_title_sp"><?php the_field('sale_top_banner_title', 14); ?></h1>
                <div class="top_banner_desc_sp"><?php the_field('sale_top_banner_description', 14); ?></div>
            </div>
        </div>
    </div>
<?php endif; ?>
