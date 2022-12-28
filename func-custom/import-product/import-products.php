<?php
require __DIR__ . '/vendor/autoload.php';
use Automattic\WooCommerce\Client;

function abcdef() {
    $file_path = __DIR__ .'/products.json';
    $woocommerce = new Client(
        'https://phase2.love-and-co.com/', // Your store URL
        'ck_75faad6babf29d02247b2383406060bc82c8bba6', // Your consumer key
        'cs_4e6bf42701e1f0ffdddf44e4cf95cda456cdb06c', // Your consumer secret
        [
            'wp_api' => true, // Enable the WP REST API integration
            'version' => 'wc/v3', // WooCommerce WP REST API version
            'timeout' => 400
        ]
    );
    $json = json_decode(file_get_contents($file_path));
    $newjson = array();
    foreach($json as $key => $item) {
        unset($item->id);
        unset($item->sku);
        $product_images = array();
        foreach($item->images as $image) {
            array_push($product_images, ['src' => str_replace('https', 'http', $image->src)]);
        }
        $item->images = $product_images;
        array_push($newjson, $item);
        if($key === 0) {
            $abcd = $woocommerce->post('products', $item);
            var_dump($abcd);
        }

    }
    // $data = [
    //     'create' => $newjson
    // ];

    // $abcd = $woocommerce->post('products/batch', $data);
    // return $abcd;
}
?>