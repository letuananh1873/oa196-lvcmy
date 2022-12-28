<?php
/**
 * Template Name: Template Ben
 */

 get_header();

?>
<?php
// global $wpdb;
// $str = "SELECT count(*) as rows_count  FROM wp_posts WHERE post_type = 'attachment' ";
// $query = $wpdb->get_results($str);
// $path = "/mnt/data/home/607657.cloudwaysapps.com/rarcvkkpen/public_html/wp-content/uploads/";
// $temp = 0;
// $files = glob($path . '2021/10/*.*');
// $start = 0;
// $in_array = "";
// $add_num = 100;
// $last_array = array_splice($files, $start, $start + $add_num);
// $path_array = [];
// foreach($last_array as $key => $item) {
//     if(!preg_match_all('/(?:[-_]?[0-9]+x[0-9]+)+/',   $item)) {
//         if($key === count($last_array) - 1) {
//             $in_array .= "'".str_replace($path, '',  $item)."'";
//         } else {
//             $in_array .= "'".str_replace($path, '',  $item)."',";
//         }
//         array_push($path_array, $item);
//     }
// }

// $query_str = "SELECT post_id, meta_value FROM {$wpdb->prefix}postmeta WHERE meta_key = '_wp_attached_file' AND meta_value IN (" .$in_array.")";
// $results = $wpdb->get_results($query_str);

// $result_array = [];
// foreach($results as $result) {
//     if($result->meta_value) {
//         array_push($result_array, $result->meta_value);
//     }
// }

// foreach($last_array as $key => $item) {
//     if(!in_array(str_replace($path, '',  $item), $result_array) && !preg_match_all('/(?:[-_]?[0-9]+x[0-9]+)+/',   $item)) {
        
//     }
// }


// if(!preg_match_all('/(?:[-_]?[0-9]+x[0-9]+)+/',  $files[$i])) {
//     $query_str = "SELECT post_id, meta_value FROM {$wpdb->prefix}postmeta WHERE meta_key = '_wp_attached_file' AND meta_value = '" .str_replace($path, '', $files[$i]) ."'";
//     $id = $wpdb->get_results($query_str);

//     // var_dump($id);
//     if(!$id) {
//         if(unlink($files[$i])) {
//             echo $files[$i] . 'Done <br />';
//         } else {
//             echo 'Fail <br />';
//         }  
//     }
// }
// foreach($abcd as $file) {
//     if($temp >= $start) {
//         $id = attachment_url_to_postid('https://phase2.love-and-co.com/wp-content/uploads/' . str_replace($path, '', $file));
//         if(!$id) {
//             if(unlink($file)) {
//                 echo 'Done <br />';
//             } else {
//                 echo 'Fail <br />';
//             }
//         }
//     }
//     $temp++;
//     if($temp >= ($start + 20)) 
//     break; 
// }
// var_dump(unlink('/mnt/data/home/607657.cloudwaysapps.com/rarcvkkpen/public_html/wp-content/uploads/2021/10/0.32HVS1Excellent-variation-UAT-2.csv-12.txt'));
$path = "/mnt/data/home/607657.cloudwaysapps.com/rarcvkkpen/public_html/wp-content/uploads/";
$files = glob($path . '2021/10/*.*');
$start_num = get_option('delete_media_start_number') ?? 0 ?: 0;
?>

<?php
$order = new WC_Order(848313);
$customer_id = $order->get_customer_id();

//this should return exactly the same number as the code above
$user_id = $order->get_user_id();

// Get the WP_User Object instance object
$user = $order->get_user();

// var_dump($customer_id, $user_id);

// $order_items = $order->get_items();
// $product_details = [];
// foreach( $order_items as $product ) {
//     $product_details[] = $product['product_id'];
// }
var_dump($order);
get_footer();