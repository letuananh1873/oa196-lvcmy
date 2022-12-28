<?php
global $product;
$price = $product->get_price();
echo '<div class="from-price">';
echo 'Starting at '.wc_price($price);
echo '</div>';