<?php
$queried_object = get_queried_object();  
$shape_slug = $_GET['_dianmond_shapes'] ??'';
if (!empty($shape_slug)) {
    $shape_term = get_term_by('slug', $shape_slug, 'pa_shapes');
    if (!is_wp_error( $shape_term )) {
        $queried_object = 'term_'.$shape_term -> term_id;  
    }
}
echo '<div class="wrapper-banner-lvc">';       
    echo lvc_banner($queried_object);
echo '</div>';