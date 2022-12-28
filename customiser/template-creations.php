<?php
/**
 * Template Name: Creations 
*/

get_header();
$creations = json_decode(get_user_creations(), false);


?>
<div class="creations-container">
<header class="entry-header ast-no-thumbnail ast-no-meta">
    <h1 class="entry-title" itemprop="headline">My Creations</h1>
</header>
<?php do_action('woocommerce_account_navigation'); ?>
<div class="creations">
    <ul class="no-lst">
        <?php
        foreach($creations as $key => $creation):
            $product_id = $creation->product_id;
            $product = wc_get_product($product_id);
            $product_thumb = get_the_post_thumbnail_url($product_id, 'large', false);
        ?>
        <li class="creation" data-key="<?php echo $key; ?>">
            <div class="creation-remove" title="Remove Creation"><span>&times</span></div>
            <a href="<?php echo $creation->url; ?>" title="Go to creation.">
                <div class="container">
                    <img src="<?php echo $product_thumb; ?>" alt="Creation Image">    
                
                    <p class="creation-name"><?php echo $creation->product_name; ?></p>
                </div>
            </a>
        </li>
        <?php endforeach;  ?>
    </ul>
</div>
</div>
<script>
    if(jQuery('.page-template-template-creations').length > 0) {
        jQuery('.woocommerce-MyAccount-navigation-link').removeClass('is-active');
        jQuery('.woocommerce-MyAccount-navigation-link--my-creations').addClass('is-active');
    }

    jQuery(document).on('click', '.creation-remove', function(e) {
        e.preventDefault();
        const key = jQuery(this).parents('.creation').data('key');
        jQuery.ajax({
            url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
            method: 'post',
            dataType: 'json',
            data: {
                action: 'remove_creation',
                key: key
            }
        }).done(function(res) {
            if(res.success) {
                // jQuery(this).
            }
        })
    });
</script>
<?php
get_footer();
?>