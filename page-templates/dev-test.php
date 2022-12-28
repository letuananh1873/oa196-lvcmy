<?php
/**
 * Template Name: Dev Test 
*/
get_header();

?>

<?php
// global $wpdb;
// $prefix = $wpdb->prefix;
// $query_str = "SELECT ID FROM {$prefix}posts INNER JOIN {$prefix}postmeta ON {$prefix}posts.ID = {$prefix}postmeta.post_id WHERE {$prefix}postmeta.meta_key = '_wp_attached_file'";
// $res = $wpdb->get_results($query_str);
$path = "/mnt/data/home/607657.cloudwaysapps.com/rarcvkkpen/public_html/wp-content/uploads/";
$files = glob($path . '2021/10/*.*');
var_dump(count($files));
?>

<?php
get_footer();