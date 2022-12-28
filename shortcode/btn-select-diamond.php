<?php
$product_id = get_the_ID();
$p_param = 'p_id='.$product_id;
$params = '';
if (function_exists('url_extral_diamond') && !empty(url_extral_diamond(''))) {
$params = 'select-diamond/'.url_extral_diamond('').'&'.$p_param;
} else {
	if (function_exists('url_extral_diamond')) {
		$params = 'select-diamond/'.url_extral_diamond('').'?'.$p_param;
	}
	
}

$url = home_url( $params );


?>
<div class="wrapper-select-diamond">
	<a data-url="<?php echo home_url( 'select-diamond' ); ?>" href="<?php echo $url; ?>" class="select-diamond">Select a diamond</a>
</div>