<?php
/**
 * Template Name: Name Customiser
*/
get_header();
$_id = $_GET['id'] ?? '';
$_name = $_GET['cus_name'] ?? '';
$_prd_name = $_GET['product_name'] ?? '';
$_month = $_GET['month'] ?? '';


$args = array(
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => 1,
    'orderby' => 'id',
    'order' => "ASC"
);
if(!empty($_id)) {
    $args['post__in'] = array($_id);
} else {
    $args['tax_query']  = array(
        array(
            'taxonomy' => 'name_necklace',
            'field' => 'slug',
            'terms' => get_type_of_name($_name)
        )
    );
}

$wp_query = new WP_Query($args);


$post = $wp_query->posts[0];
$post_id = $post->ID;
$product = wc_get_product($post_id);

$product_gallery_ids = $product ? $product->get_gallery_image_ids():array();

?>
<div class="customiser customiser-content">
    <div class="container">
        <!-- <header>
            <h1 class="title">PERSONALISED NAME NECKLACE</h1>
        </header> -->
        <main class="customser-main">
            <input type="hidden" id="product-id" name="product_id" value="<?php echo $post_id; ?>">
            <header class="customiser-menu">
                <div class="container">
                    <div class="customiser-title">
                        <div class="customiser-breacrumb">
                            <nav class="no-lst">
                                <li><a href="<?php echo home_url(); ?>">Home</a></li>
                                <li><a href="<?php echo home_url('/gifts/'); ?>">Gifts</a></li>
                                <li><a href="<?php echo home_url('/'.PAGE_NAME .'/'); ?>">Necklace</a></li>
                            </nav>
                        </div>
                        <input type="hidden" id="customiser-product-name" data-default="LVC Signe Personalised Necklace" placeholder="My Personalised Name Necklace" name="product-title" value="<?php echo $_prd_name; ?>" autocomplete="off">
                    </div>
                    <div class="customiser-nav">
                        <ul class="no-lst">
                            <!-- <li><a class="customiser-rename" href="#">rename</a></li> -->
                            <li><a class="customiser-new" href="#">new</a></li>
                            <li><a class="customiser-mc" href="<?php echo home_url('/my-creations'); ?>">my creations</a></li>
                            <li>
                                <a class="icon creations-save" href="#">
                                    <img src="<?php echo CUSTOMISER_URI .'assets/images/customiser_save.webp'; ?>" alt="">
                                </a>
                            </li>
                            <li>
                                <a href="#" class="icon">
                                    <img src="<?php echo CUSTOMISER_URI .'assets/images/customiser_share.webp'; ?>" alt="">
                                </a>
                                <?php
                                $share_title = 'LVC Signe Persionalised Necklace';
                                $share_image = get_the_post_thumbnail_url($post_id, 'full');
                                ?>
                                <?php require  CUSTOMISER_PATH .'/template-parts/shares.php'; ?>   
                            </li>
                        </ul>
                    </div>
                </div>
            </header>
            <main class="d-flex ">
                <div class="product-left">
                    <div class="product-image" data-id="<?php echo $post_id; ?>">
                        <?php 
                           echo apply_filters('product_gallery_html', $post_id, true, 'no-lst', 'product-slide-img', 'slide-img')
                        ?>
                    </div>
                    <?php $hidden = (product_gallery_count($post_id) > 0) ? "" : " hidden"; ?>
                    <div class="product-gallery<?php echo $hidden; ?>" >
                        <?php 
                           echo apply_filters('product_gallery_html', $post_id, true, 'no-lst', 'gallery-wrap', 'gallery_img')
                        ?>
                    </div>
                </div>
                <div class="product-right">
                    <div class="container">
                        <div class="product-cat text-center">LVC 9TwentyFive</div>
                        <div class="product-name text-center">LVC Signe Personalised Necklace</div>
                        <div class="product-price text-center">
                            <?php echo $product->get_price_html(); ?>
                        </div>
                        <div class="color-line"></div>
                        <div class="product-month">
                            <ul class="no-lst">
                                <?php
                                $birthstones = new WP_Query(array(
                                    'post_type' => 'product',
                                    'post_status' => 'publish',
                                    'posts_per_page' => -1,
                                    'orderby' => 'id',
                                    'order' => "ASC",
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'name_necklace',
                                            'field' => 'slug',
                                            'terms' => 'birthstone'
                                        )
                                    )
                                ));
                                $sort_birthstones = array();
                                $sort_list = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

                                foreach($birthstones->posts as $birthstone) {
                                    $birthstone_key = array_search($birthstone->post_title, $sort_list);
                                    $sort_birthstones[$birthstone_key] = $birthstone;
                                }
                                ksort($sort_birthstones);
                                foreach($sort_birthstones as $birthstone):
                                    $product_id = $birthstone->ID;
                                    $product = wc_get_product($product_id);
                                    $month = get_field('month', 'post_' .$product_id);
                                    $outofstock = apply_filters('is_out_of_stock', $product);
                                    $enable = !$outofstock ? '' : ' disable';
                                    $active = ($_month === $month) ? ' active' : '';
                                ?>
                                <li class="birthstone-product<?php echo $enable.$active; ?>" data-month="<?php echo $month; ?>">
                                    <?php echo get_the_post_thumbnail($product_id, 'medium'); ?>
                                    <div class="meta">
                                        <div class="month-name"><?php echo $birthstone->post_title; ?></div>
                                    </div>
                                </li>
                                <?php
                                endforeach;
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="variations">
                        <div class="variation-name">
                            <div class="variation-left">
                                <label for="name">Name</label>
                                <input type="text" id="name" placeholder="Type Something..." value="<?php echo substr($_name, 0, 15); ?>" autocomplete="off">
                                <span class="name-err">Please Enter Your Name.</span>
                                <div class="name-amount">Character Limit: <span class="amount"><?php echo strlen(substr($_name, 0, 15)); ?></span>/15</div>
                            </div>
                            <div class="variation-right">
                                <div class="alphabet" data-alphabet="">
                                    <?php
                                    if(!empty($_name)):
                                        $alphabet = get_field('customiser_name', 'option');
                                        foreach($alphabet as $item) {
                                            if(strtolower($item['character']) == strtolower(substr($_name, 0, 1))) {
                                                ?>
                                                <img src="<?php echo $item['image']['url']; ?>" alt="<?php echo $item['image']['alt']; ?>">
                                                <?php 
                                            }
                                        }
                                    else:
                                    ?>
                                    <img style="display: none" src="<?php echo get_the_post_thumbnail_url($post_id, 'full'); ?>" alt="Alphabet">
                                    <?php
                                    endif;
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="actions">
                            <div class="action">
                                <div class="btn customiser-atc <?php echo !empty($_name) ? '' : 'disable'; ?>" type="submit" name="atb" value="add to bag">add to bag</div>
                            </div>
                            <div class="action">
                                <div class="btn btn-sap" type="submit" name="sap" value="schedule an appointment">schedule an appointment</div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php do_action('after_customiser_content'); ?>

        </main>
    </div>
</div>
<?php
require CUSTOMISER_PATH . '/template-parts/modal-nav.php';
require CUSTOMISER_PATH . '/template-parts/modal-add-to-cart.php';
require CUSTOMISER_PATH . '/template-parts/modal-duplicate-product.php';
require CUSTOMISER_PATH . '/template-parts/modal-share-email.php';
require CUSTOMISER_PATH . '/template-parts/modal-loading.php';

get_footer();
?>