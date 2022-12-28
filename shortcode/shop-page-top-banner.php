<?php if ( is_shop() ) { ?>

        <?php if( get_field('page_top_banner',14) ): ?>
                <div class="proudct_overview_top_banner shop-page-top-banner">
                    <div class="top_banner_bg"><img src="<?php the_field('page_top_banner',14); ?>"></div>
                    <div class="top_banner_textBox" style="align-items: <?php
                            if( get_field('text_box_vertical_alignment', 14) == 'Top' ) { 
                                echo "flex-start";
                            }else if( get_field('text_box_vertical_alignment', 14) == 'Bottom' ) { 
                                echo "flex-end";
                            } else if( get_field('text_box_vertical_alignment', 14) == 'Middle' ) { 
                                echo "center";
                            }
                        ?> ; justify-content: <?php
                            if( get_field('text_box_horizontal_alignment', 14) == 'Left' ) { 
                                echo "flex-start";
                            }else if( get_field('text_box_horizontal_alignment', 14) == 'Right' ) { 
                                echo "flex-end";
                            } else if( get_field('text_box_horizontal_alignment', 14) == 'Middle' ) { 
                                echo "center";
                            }
                        ?> ;">
                        <div class="textbox_moving">
                            <h1 class="top_banner_title" style="color: <?php the_field('lvc_banner_title_color'); ?> !important; "><?php the_field('top_banner_title', 14); ?></h1>
                            <div class="top_banner_description"><?php the_field('top_banner_description', 14); ?></div>

                            <?php if( get_field('top_banner_button_text', 14) ): ?>
                                <?php if( get_field('check_if_the_button_is_for_popup_booking_form')) {  echo '<div class="call-booking-form">'; } ?>
                                    <a href="<?php the_field('top_banner_button_link', 14); ?>" class="top_banner_button" style="color: <?php the_field('top_banner_button_color'); ?> ; border-color: <?php the_field('top_banner_button_color'); ?> ; ">
                                        <?php the_field('top_banner_button_text', 14); ?>
                                    </a>
                                <?php if( get_field('check_if_the_button_is_for_popup_booking_form', 14)) {  echo '</div>'; } ?>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>

                <div class="proudct_overview_top_banner_sp">
                    <div class="top_banner_bg_sp"><img src="<?php the_field('page_top_banner_mobile', 14); ?>"></div>
                    <div class="top_banner_textBox_sp">
                        <h1 class="top_banner_title_sp alt-listing-heading"><?php the_field('top_banner_title', 14); ?></h1>
                        <div class="top_banner_desc_sp"><?php the_field('top_banner_description', 14); ?></div>

                        <?php if( get_field('top_banner_button_text', 14) ): ?>
                            <?php if( get_field('check_if_the_button_is_for_popup_booking_form', 14)) {  echo '<div class="call-booking-form">'; } ?>
                                <a href="<?php the_field('top_banner_button_link', 14); ?>" class="top_banner_button">
                                    <?php the_field('top_banner_button_text', 14); ?>
                                </a>
                            <?php if( get_field('check_if_the_button_is_for_popup_booking_form', 14)) {  echo '</div>'; } ?>
                        <?php endif; ?>

                        <?php do_action('shop_before_heading');?>

                    </div>
                </div>

        <?php endif; ?>

<?php } ?>
