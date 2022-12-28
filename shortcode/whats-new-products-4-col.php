<?php
    $choose_related_products = get_field( 'choose_related_products' );
    if ( $choose_related_products ) : 
?>

<div class="new_products_4_col_wrap">
    <div class="greenBlock"></div>
    <ul class="new_products new_products-4-col">
        <?php
            global $post; 
            foreach ( $choose_related_products as $post ) : 
                $product = get_product($post->ID);
                setup_postdata( $post ); 
                // woocommerce_get_template_part( 'content', get_post_type() );
        ?>
            <li class="<?php if ( !$product->is_in_stock() ) { echo 'outofstock'; }?>">
                <div class="item_imgBox">
                    <a href="<?php echo get_permalink(); ?>">
                        <div class="item_imgBox_featured_img"><?php echo woocommerce_get_product_thumbnail($size = 'shop_catalog'); ?></div>
                        <div class="item_imgBox_first_gallery_img">
                        <?php
                            $image_id = wc_get_product()->get_gallery_image_ids()[0] ; 
                            if ( $image_id ) {
                                echo wp_get_attachment_image( $image_id, array('300', '300') );
                            } else {  //assuming not all products have galleries set
                                echo woocommerce_get_product_thumbnail($size = 'shop_catalog');
                            }
                        ?>
                        </div>
                    </a>
                    <div class="wishlistBtn"><?php echo do_shortcode( "[yith_wcwl_add_to_wishlist]" ); ?></div>
                </div>
                <div class="p_textBox">
                    <h4 class="p_textBox_title"><?php echo the_title(); ?></h4>
                    <p class="p_textBox_price"><?php echo $product->get_price_html(); ?></p>
                    <div class="p_viewmore"><a href="<?php echo get_permalink(); ?>">VIEW MORE</a></div>
                </div>
                <h4 class="p_title"><?php echo the_title(); ?></h4>
                <p class="p_price"><?php echo $product->get_price_html(); ?></p>
            </li>

        <?php 
            endforeach;
            wp_reset_postdata();
        ?>
    </ul>
</div>
<?php endif; ?>
 
<script>
    jQuery(document).ready(function($) {
        $('.new_products').slick({
            autoplay: false,
            dots: false,
            prevArrow:"<div class='new_products_arrows prev' ><img src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/arrow-left.svg'></div>",
            nextArrow:"<div class='new_products_arrows next' ><img src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/arrow-right.svg'></div>",
            swipeToSlide: true,
            slidesToShow: 4,
            slidesToScroll: 4,
            responsive: [
              {
                breakpoint: 992,
                settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                }
              },
              {
                breakpoint: 767,
                settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
                centerMode: true,
                centerPadding: '20px',
                dots: true
                }
              }
            ]
        });
    });
</script>
