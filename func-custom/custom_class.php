<?php
/**
 * Write log after save term
*/

class write_log {

    private $file_url = __DIR__ . '/custom_logs.log';

    function __construct() {
        add_action( 'edit_term', array($this, 'write_log_after_edit_term'), 90, 3 );
    }

    public function write_log_after_edit_term($term_id, $tt_id, $taxonomy) {
        $user_id = get_current_user_id();
        if($taxonomy == 'designer_collections') {	
            $field = get_field('lvc_banner_title_text', 'term_'.$term_id);
            $log_text = 'Write Logs: (' .(empty($field) ? 'Empty Field Content.' : $field) . ') has changed by user id: '. $user_id .', Time: ' . date("Y-m-d H:i:s") .'|| Term id: '.$term_id;
            $this->add_logs($log_text);
        }
        if($taxonomy == 'product_cat' || $taxonomy == 'designer_collections') {
            $log_text  .= 'Description updated: (' .(empty($_REQUEST['description']) ? 'Description Empty.' : $_REQUEST['description']) . ') has changed by user id: '. $user_id .', Time: ' . date("Y-m-d H:i:s") .'|| Term id: '.$term_id;
            $this->add_logs($log_text);
        }
    }


    public function add_logs($text) {
        $file = file_get_contents($this->file_url);
        file_put_contents($this->file_url, $text. PHP_EOL, FILE_APPEND | LOCK_EX);
    }
}

new write_log;



class WooCustomHook {

    function __construct() {
        add_filter( 'loop_shop_per_page', array($this, 'new_loop_shop_per_page'), 20 );
    }

    /**
     * Change number of products
    */

    function new_loop_shop_per_page( $cols ) {
        $cat = get_queried_object();

        if(is_product_taxonomy() && $cat->taxonomy === 'product_cat') {
            $first_banner_image = get_field('image_banner', $cat->taxonomy . '_' . $cat->term_id);
            if($first_banner_image) {
                $cols -= 2;
            }
        }
        
        return $cols;
    }
}

new WooCustomHook;