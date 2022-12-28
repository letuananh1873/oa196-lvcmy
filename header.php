<?php
/**
 * The header for Astra Theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?><!DOCTYPE html>
<?php astra_html_before(); ?>
<html <?php language_attributes(); ?> >
<head>

<?php astra_head_top(); ?>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="google-site-verification" content="lasz8YY3v7JNJehhDBjQoOhvlhYHFg8Z2sglztBWtRQ" />
<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0,user-scalable=no, maximum-scale=1.0, minimum-scale=1.0">
<link rel="profile" href="https://gmpg.org/xfn/11">
<!-- <script src="https://love-and-co.com/wp-content/plugins/product-video-for-woocommerce/front/js/froogaloop2.min.js"></script> -->
<!-- Hotjar Tracking Code for www.love-and-co.com -->
<!-- <script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:2540727,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script> -->

<?php wp_head(); ?>
<?php
    
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        $uid = $current_user->ID;
        $user_metas = get_user_meta($uid);
        $email = strtolower($current_user->user_email);
        $first_name = strtolower($current_user->user_firstname);
        $last_name=$current_user->user_lastname;
        $phone=$user_metas['billing_phone'][0];
        $phone_postcode=$user_metas['billing_phone_code'][0];

        $external_id=$uid;
        $gender='f';
        $birthday_date=mysql2date( 'Ymd',$user_metas['birthday'][0]);
        $city=strtolower($user_metas['billing_city'][0]??'');
        $post_code=$user_metas['billing_postcode'][0]??''; 
        $state_code=$user_metas['billing_state'][0]??''; 
        $country=strtolower($user_metas['billing_country'][0]??''); 
        if (get_user_meta('gender',$uid) == 'female') {
            $gender = 'f';
        }
    
    ?>
    <script>
        window.dataLayer = window.dataLayer || [];
            window.dataLayer.push({
            'em': '<?php echo $email; ?>',
            'fn': '<?php echo $first_name ; ?>',
            'ln': '<?php echo $last_name ; ?>',
            'ph': '<?php echo $phone_postcode.$phone; ?>',
            'external_id': '<?php echo $external_id ; ?>',
            'ge': '<?php echo $gender; ?>',
            'db': '<?php echo $birthday_date ; ?>',
            'ct': '<?php echo $city ; ?>',
            'st': '<?php echo $state_code; ?>',
            'zp': '<?php echo $post_code; ?>',
            'cn': '<?php echo $country; ?>',
            });
    </script>   
    <?php } ?>

<?php astra_head_bottom(); ?>

	<?php //bootstrap grid only css ?>
	<!-- <link rel='stylesheet'
		href='https://cdn.jsdelivr.net/npm/bootstrap-v4-grid-only@1.0.0/dist/bootstrap-grid.min.css' media='all' /> -->


	<!---slick slider-->	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
	
	<!---call custom css-->	

	<link rel='stylesheet' href='<?php echo get_template_directory_uri(); ?>/assets/css/custom-select.css?v=<?php echo strtotime("now"); ?>' media='all' />

	<!---call custom js-->	

	<script type='text/javascript' src='<?php echo get_template_directory_uri(); ?>/assets/js/custom-select.min.js?v=<?php echo strtotime("now"); ?>'></script>	

	<!---call custom css-->	
	<link rel='stylesheet'
		href='<?php echo get_template_directory_uri(); ?>/assets/css/base.css?v=<?php echo strtotime("now"); ?>' media='all' />
	<script type='text/javascript'
		src='<?php echo get_template_directory_uri(); ?>/assets/js/base.js?v=<?php echo strtotime("now"); ?>'></script>

	<!---call mon css-->	
	<link rel='stylesheet' href='<?php echo get_template_directory_uri(); ?>/assets/css/mon.css?v=<?php echo strtotime("now"); ?>' media='all' />
	<!---call mon js-->	
	

	<!---call custom css-->	

	<link rel='stylesheet' href='<?php echo get_template_directory_uri(); ?>/assets/css/custom.css?v=<?php echo date('h:m:i'); ?>' media='all' />

	<!---call custom js-->	

	<script type='text/javascript' src='<?php echo get_template_directory_uri(); ?>/assets/js/custom.js?v=<?php  echo date('h:m:i'); ?>'></script>
	
	<!---call den css-->	
	<link rel='stylesheet' href='<?php echo get_template_directory_uri(); ?>/assets/css/den.css?v=<?php echo strtotime("now"); ?>' media='all' />
	<!---call den js-->	
	<!-- <script type='text/javascript' src='<?php //echo get_template_directory_uri(); ?>/assets/js/den.js?v=<?php //echo strtotime("now"); ?>'></script> -->

	<!---call fly css-->	
	<link rel='stylesheet' href='<?php echo get_template_directory_uri(); ?>/assets/css/fly.css?v=<?php echo strtotime("now"); ?>' media='all' />
	<!---call fly js-->	
	<script type='text/javascript' src='<?php echo get_template_directory_uri(); ?>/assets/js/fly.js?v=<?php echo strtotime("now"); ?>'></script>

	<!---call selectize css-->	
	<link rel='stylesheet' href='<?php echo get_template_directory_uri(); ?>/assets/css/selectize.default.css?v=<?php echo strtotime("now"); ?>' media='all' />
	<!---call selectize js-->
	<script type='text/javascript' src='<?php echo get_template_directory_uri(); ?>/assets/js/selectize.js?v=<?php echo strtotime("now"); ?>'></script>

	<script async type="text/javascript" src="https://static.klaviyo.com/onsite/js/klaviyo.js?company_id=Y4KXtr"></script>
	<!-- SEO Scripts header -->
	<?php seo_script('header'); ?>
	<!-- End SEO SCripts header -->
<!-- seo -->
<script type="application/ld+json">
{"@context":"https://schema.org/","@type":"CreativeWorkSeries","name":"Engagement & Wedding Rings Singapore","aggregateRating":{"@type":"AggregateRating","ratingValue":"5","bestRating":"5","ratingCount":"370"}}
</script>
<!-- seo -->	
</head>

<?php
$the_page = sanitize_post( $GLOBALS['wp_the_query']->get_queried_object() );
//var_dump($the_page);
$slug = $the_page ? $the_page->post_name : '';

?>
<script>
	var popupTime = <?php echo get_field('cookie_expire', 'option'); ?>,
		popupDelayTime = <?php echo get_field('time_to_display_popup', 'option'); ?>,
		hardReload = <?php echo '"'.$_SERVER['HTTP_CACHE_CONTROL'].'"'; ?>;
</script>
<body <?php astra_schema_body(); ?> <?php body_class(); ?> id="<?php echo $slug?>">
<!-- SEO Scripts body  -->
<?php seo_script('body'); ?>
<!-- End SEO SCripts body -->
<?php
// klaviyo Popup
get_template_part( "template-parts/content", "klaviyo" );
// End klaviyo Popup
?>
<input type="hidden" name="consulation_minday" value="<?php echo intval(get_field('consulations_min_date','option')); ?>" id="consulation_minday">


<?php astra_body_top(); ?>
<?php wp_body_open(); ?>
<div 
	<?php
	echo astra_attr(
		'site',
		array(
			'id'    => 'page',
			'class' => 'hfeed site',
		)
	);
	?>
>
	<a class="skip-link screen-reader-text" href="#content"><?php echo esc_html( astra_default_strings( 'string-header-skip-link', false ) ); ?></a>

	<?php astra_header_before(); ?>

	<?php if(is_page_template( 'page-templates/template-ben.php' )):
	echo get_template_part('template-parts/header/header','v2');
	else: ?>
	<?php astra_header(); ?>
	<?php endif; ?>

	<?php astra_header_after(); ?>

	<?php astra_content_before(); ?>

	<div id="content" class="site-content">

		<div class="ast-container">

		<?php astra_content_top(); ?>

		

		<?php         
		if ( is_page() ) {
			echo do_shortcode( '[include slug="shortcode/pages-top-banner"]' );
		} else {

		}
		?>



