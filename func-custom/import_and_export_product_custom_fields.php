<?php
require_once ABSPATH . 'wp-admin/includes/file.php';
/**
 * Import and export product hover thumbnail  
*/


class IAEProductHoverThumbnail {

    function __construct() {
        add_filter( 'woocommerce_product_export_product_default_columns', array($this, 'add_export_column') );
        add_filter( 'woocommerce_product_export_product_column_hover_image', array($this, 'woocommerce_product_export_product_column_hover_image'), 10, 2 );
        add_filter( 'woocommerce_product_export_product_column_variations_gallery', array($this, 'woocommerce_product_export_product_column_variations_gallery'), 10, 2 );

         add_filter( 'woocommerce_product_export_product_column_tempt_variations_gallery', array($this, 'woocommerce_product_export_product_column_tempt_variations_gallery'), 10, 2 );


        add_filter( 'woocommerce_csv_product_import_mapping_options', array($this, 'add_column_to_product_importer') );
        add_filter( 'woocommerce_csv_product_import_mapping_default_columns',array($this, 'add_column_to_product_mapping_screen') );
        add_filter( 'woocommerce_product_import_pre_insert_product_object', array($this, 'process_import'), 10, 2 );

    }
    
    // Add two export columns to the csv file
    public function add_export_column($columns) {
        $columns['hover_image'] = 'Hover Image Url';
        $columns['variations_gallery'] = "Variations Gallery";
        $columns['tempt_variations_gallery'] = 'Tempt Variations Gallery';
        return $columns;
    }

    // function upload_image_form_url($image_url) {
    //     // $image_url = "http://oanglelab.com/oa134-lvc/ebase-uploads/2021/05/Lifestyle_Silver_Girl_1-600x600.jpg";
    //     $tmp_file = download_url( $image_url );

    //     if(!is_wp_error($tmp_file)) {
    //         $basename = basename($image_url);
    //         $filepath = wp_upload_dir()['path'] . '/' . strtotime(date('Y-m-d h:i:s')) . '_' .$basename;
    //         preg_match( '/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $image_url, $matches );
    //         $time = current_time( 'mysql' );
    //         $file_array['name'] = basename($matches[0]);
    //         $file_array['tmp_name'] = $tmp_file;
    //         $file = wp_handle_sideload( $file_array, array('test_form'=>false), $time );
    //         @unlink( $tmp_file );
    //         $new_url = wp_upload_dir()['url'] .'/' . strtotime(date('Y-m-d h:i:s')) . '_' .$basename;
    //         $url = $file['url'];
    //         $type = $file['type'];
    //         $file = $file['file'];
    //         $title = preg_replace('/\.[^.]+$/', '', basename($file) );
    //         $attachment = array(
    //             'post_mime_type' => $type,
    //             'guid' => $url,
    //             'post_parent' => '',
    //             'post_title' => $title,
    //             'post_content' => '',
    //         );
    //         $upload_id = wp_insert_attachment( $attachment, $file );
    //         if ( !is_wp_error($id) ) {
    //             require_once ABSPATH . 'wp-admin/includes/image.php'; 
    //             $data = wp_generate_attachment_metadata( $upload_id, $file );
    //             wp_update_attachment_metadata( $upload_id, $data );
    //         }

    //         return $upload_id;
    //     }
    // }

    function upload_image_form_url($image_url) {
		//$image_url = str_replace(array('https://oanglelab.com/oa134-lvc', 'http://oanglelab.com/oa134-lvc'), home_url(), $image_url);
		$basename = basename($image_url);
		$filetype = wp_check_filetype( basename( $image_url ), null );
		$wp_upload_dir = wp_upload_dir();
		$attachment = array(
			'guid'           => $wp_upload_dir['url'] . '/' . basename( $image_url ), 
			'post_mime_type' => $filetype['type'],
			'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $image_url ) ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);
		
		$upload_id = wp_insert_attachment( $attachment, $image_url );
		if ( !is_wp_error($upload_id) ) {
			require_once ABSPATH . 'wp-admin/includes/image.php'; 
			$data = wp_generate_attachment_metadata( $upload_id, $image_url );
			wp_update_attachment_metadata( $upload_id, $data );
		}

		return $upload_id;
	}

    // Set the value of the Hover thumbnail column
    function woocommerce_product_export_product_column_tempt_variations_gallery($value, $product) {
       return get_post_meta($product->get_id(), 'tempt_variations_gallery', true) ?: '';      
    }


    // Set the value of the Hover thumbnail column
    public function woocommerce_product_export_product_column_hover_image($value, $product) {
        $product_gallery = $product->get_gallery_image_ids();
        $first_gallery_id = $product_gallery[0];

        $first_gallery_url = wp_get_attachment_url($first_gallery_id);
        if(!$first_gallery_url) return '';
        return $first_gallery_url;
    }

    // Create fields to import
    public function add_column_to_product_importer( $options ) {

        $options['hover_image'] = 'Hover Image';
        $options['variations_gallery'] = 'Variations Gallery';
        $options['tempt_variations_gallery'] = 'Tempt Variations Gallery';
        return $options;
    }

    // Set default selection for the column of the csv file and the field in the inport page
    public function add_column_to_product_mapping_screen( $columns ) {
	
        $columns['hover image url'] = 'hover_image';
        $columns['Hover Image Url'] = 'hover_image';
        $columns['Variations Gallery'] = 'variations_gallery';
        $columns['Tempt Variations Gallery'] = 'tempt_variations_gallery';
        return $columns;
    }

    function process_import( $object, $data ) {

        if ( !empty( $data['hover_image'] ) ) {
            $product_gallery_ids = $object->get_gallery_image_ids();
            $image_id = attachment_url_to_postid(str_replace('ebase-uploads', 'wp-content/uploads', $data['hover_image']));
            $new_product_gallery_ids = array();
            array_push($new_product_gallery_ids, $image_id);
            foreach($product_gallery_ids as $key => $itemmm) {
                if($key != 0) { 
                    array_push($new_product_gallery_ids, $itemmm);
                }
            }

            $object->set_gallery_image_ids($new_product_gallery_ids);
        }

        if ( !empty( $data['tempt_variations_gallery'] ) ) {
            update_post_meta($object->get_id(), 'tempt_variations_gallery', $data['tempt_variations_gallery']);
         }

        if(!empty($data['variations_gallery'])) {
        //     if($object->is_type('variable')) {
        //         $gallery_arr = explode(':::', $data['variations_gallery']);
        //         foreach($gallery_arr as $item) {
        //             $item_arr = explode('|', $item);
        //             $variation_id = explode('=', $item_arr[0]);
        //             $gallery_urls = explode('=', $item_arr[1]);
        //             $_id = trim($variation_id[1]);
        //             $_urls = str_replace('}', '', trim($gallery_urls[1]));
        //             $_urls_arr = explode('~',$_urls);
        //             $gallery_ids = [];
        //             foreach($_urls_arr as $url) {
        //                 $gallery_image_id = attachment_url_to_postid(str_replace('ebase-uploads', 'wp-content/uploads', $url));
        //                 $gallery_image_id = attachment_url_to_postid(str_replace(array('https://oanglelab.com/oa134-lvc', 'http://oanglelab.com/oa134-lvc'), 'https://phase2.love-and-co.com', $url));
        //                 if($gallery_image_id) {
        //                     array_push($gallery_ids, $gallery_image_id);
        //                 }
        //             }
        //             // if(count($gallery_ids) > 0) {
        //             //     update_post_meta($object->get_id(), 'rtwpvg_images', $gallery_ids);
        //             // } else {
        //             //     delete_post_meta($object->get_id(), 'rtwpvg_images');
        //             // }
        //             // update_post_meta($_id, 'rtwpvg_images', $gallery_ids);
        //         }
        //     }

            if($object->is_type('variation')) {
                $gallery_arr = explode(',', $data['variations_gallery']);
                $gallery_ids = [];
                foreach($gallery_arr as $item) {
					/*$rtwpvg_image = str_replace('ebase-uploads', 'wp-content/uploads', $rtwpvg_image);
                    $gallery_image_id = attachment_url_to_postid(str_replace(array('https://oanglelab.com/oa134-lvc', 'http://oanglelab.com/oa134-lvc'), home_url() , $rtwpvg_image));*/
                    if($gallery_image_id) {
                        array_push($gallery_ids, $gallery_image_id);
                    } else {
                       /* $image_url = str_replace('ebase-uploads', 'wp-content/uploads', $item);
                        $image_url = str_replace('https', 'http', $image_url);*/
                        $new_image_id = $this->upload_image_form_url($image_url);
                        array_push($gallery_ids, $new_image_id);
                    }
                }
                if(count($gallery_ids) > 0) {
                    update_post_meta($object->get_id(), 'rtwpvg_images', $gallery_ids);
                } else {
                    delete_post_meta($object->get_id(), 'rtwpvg_images');
                }
                
            }

        }

        return $object;
    }

    function woocommerce_product_export_product_column_variations_gallery($value, $product) {
        // if($product->is_type('variable')) {
        //     $variations = $product->get_available_variations();
        //     $variation_arr = [];
        //     $variation_str = '';
        //     $childrens = $product->get_children();
        //     foreach($childrens as $i => $children) {
        //         $gallery_arr = [];
        //         $_gallery = get_post_meta($children, 'rtwpvg_images', true) ?: array() ?? array();
        //         $urls_str = '';
        //         foreach($_gallery as $key => $item) {
        //             $media_url = wp_get_attachment_url($item);
        //             $urls_str .= sprintf('%s%s', $media_url, ($key < (count($_gallery) - 1)) ? '~' : '');
        //         }
        //         if(count($_gallery) > 0) {
        //             // $variation_str .= sprintf('{variation_id= %s | gallery_urls= %s}%s', $children, $urls_str, ($i < (count($childrens) - 1)) ? ',' : '');
        //             $variation_str .= '{variation_id= '.$children.' | gallery_urls= '.$urls_str.'}'.(($i < (count($childrens) - 1)) ? ':::' : '');
        //         }
        //     }
        //     return $variation_str;
        // }

        if($product->is_type('variation')) {
            $gallery_arr = get_post_meta($product->get_id(), 'rtwpvg_images', true) ?: array();
            $urls_str = '';
            foreach($gallery_arr as $key => $item) {
                $media_url = wp_get_attachment_url($item);
                $urls_str .= sprintf('%s%s', $media_url, ($key < (count($gallery_arr) - 1)) ? ',' : '');
            }
        
            return $urls_str;
        }

    }
  }
  
new IAEProductHoverThumbnail;




