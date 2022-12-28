<?php  

    global $post;
    if (function_exists('get_term_product_in_diamond')) {
      $term_type1 = get_term_product_in_diamond($post->ID);
    } else $term_type1=array();
    
if (count($term_type1) == 0):
    $terms = wp_get_post_terms( $post->ID, 'product_cat' );
    foreach ( $terms as $term ) $cats_array[] = $term->term_id;

    $args = array( 
      'orderby' => 'DESC', 
      'post__not_in' => array( $post->ID ), 
      'posts_per_page' => 20, 
      'no_found_rows' => 1, 
      'post_status' => 'publish', 
      'post_type' => 'product', 
      'tax_query' => array(
        array(
        'taxonomy' => 'product_cat',
        'field' => 'id',
        'terms' => $cats_array
        )
      )
    );

    $loop = new WP_Query( $args );
?>

<?php if($loop->have_posts()) :?>
<h3 class="elementor-heading-title elementor-size-default" style="text-align: center; margin-bottom: 1em;">You May Also Like</h3>
<ul class="new_products">
    <?php while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
        <li class="<?php if ( !$product->is_in_stock() ) { echo 'outofstock'; }?>">
            <div class="item_imgBox">
                <a href="<?php echo get_permalink(); ?>">
                  <div class="item_imgBox_featured_img"><?php echo woocommerce_get_product_thumbnail($size = 'shop_catalog'); ?></div>
                  <div class="item_imgBox_first_gallery_img">
                  <?php
                      $image_id = wc_get_product()->get_gallery_image_ids()[0] ; 
                      if ( $image_id ) {
                          // echo wp_get_attachment_image( $image_id , 300, 300, array( 'center', 'center' )) ;
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
    endwhile;

    wp_reset_query();
    ?>
</ul>

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
<?php endif; ?>
<?php endif;