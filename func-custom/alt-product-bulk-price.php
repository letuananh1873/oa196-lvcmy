<?php

class ALT_Product_Bulk_Price {
	private $slug = 'func-custom';

	function __construct() {
		add_action('admin_menu', array( $this, 'add_menu' ) );
		add_action('wp_ajax_alt_bulk_price_listing', array( $this, 'alt_bulk_price_listing') );
		add_action('wp_ajax_alt_bulk_price_update', array( $this, 'alt_bulk_price_update') );

		add_action('wp_ajax_alt_product_import', array( $this, 'alt_product_import') );
		add_action('wp_ajax_alt_product_export', array( $this, 'alt_product_export') );

		add_action('wp_ajax_alt_product_remove', array( $this, 'alt_product_remove') );
		
		
		add_action('admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

		require_once get_template_directory() .'/'. $this->slug .'/alt-product-bulk-price/helper.php';

		$this->install();
	}

	public function add_menu() {
		add_submenu_page(
			'woocommerce',
			'Bulk Price',
			'Bulk Price',
			'manage_options',
			'bulk-price-page',
			array( $this, 'page_callback' )
		);
	}

	function page_callback() {
		global $wpdb;

		if( isset($_GET['act']) ) {
			if( $_GET['act'] == 'new' || $_GET['act'] == 'edit' ) {
				// if( $_GET['act'] == 'edit' && ! empty($_GET['id']) ) {
				// 	$data = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bulk_prices WHERE product_id = %d", $_GET['id']), 'ARRAY_A');
				// 	if( ! empty($data) ) {
				// 		$data['fixed_price'] = $data['price'];
				// 		$data['attribute_price'] = json_decode($data['attributes'], true);
				// 	}
				// }

				if( ! empty($_POST['product_id']) ) {
					$data = $_POST;
					$this->save();
				}
				
				include_once get_template_directory() .'/'. $this->slug .'/alt-product-bulk-price/add.php';
			}
		}else {

			//$lists = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bulk_prices WHERE product_id = %d", $product_id));

			include_once get_template_directory() .'/'. $this->slug .'/alt-product-bulk-price/list.php';
		}
	}

	public function alt_product_remove() {
		global $wpdb;
		$json = array();
		$id = absint($_POST['id']);

		$wpdb->delete(
			$wpdb->prefix . 'bulk_prices',      // table name with dynamic prefix
			['id' => $id],                       // which id need to delete
			['%d'],                             // make sure the id format
		);

		wp_send_json($json);
	}

	public function alt_product_import() {
		$json = array();
		$file = $_FILES['file'];

		if( isset($file['type']) && $file['type'] == 'application/octet-stream' ) {
			$sql = file_get_contents($file['tmp_name']);
			$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 

			if ($con->multi_query($sql) === TRUE) {
				$json['complete'] = true;
				$json['message'] = "New record created successfully";
			  } else {
				  $extra = '';
				if( preg_match('/_bulk_prices\' doesn\'t exist/', mysqli_error($con), $output_array) ) {
					$extra = sprintf('Please <a href="%s">click here</a> to create table', admin_url('?bulk_price_install=1'));
				}
				$json['message'] =  "Error: " . mysqli_error($con);
			  }
		}

		wp_send_json($json);
	}

	public function alt_product_export() {
		global $wpdb;

		$return = '';

		$json = array();
		$table = $wpdb->prefix . 'bulk_prices';

		$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 
        $result = $db->query("SELECT * FROM $table");
        $numColumns = $result->field_count;


		// $result2 = $db->query("SHOW CREATE TABLE $table");
        // $row2 = $result2->fetch_row();

        // $return .= "\n\n".$row2[1].";\n\n";

        for($i = 0; $i < $numColumns; $i++) { 
            while($row = $result->fetch_row()) { 
                $return .= "INSERT INTO $table (product_id, product_title, product_sku, price, attributes, created_at) VALUES(";
                for($j=0; $j < $numColumns; $j++) { 
					if( $j > 0 ) {
						$row[$j] = addslashes($row[$j]);
						$row[$j] = $row[$j];
						if (isset($row[$j])) { 
							$return .= '"'.$row[$j].'"' ;
						} else { 
							$return .= '""';
						}
						if ($j < ($numColumns-1)) {
							$return.= ',';
						}
					}
                }
                $return .= ");\n";
            }
        }

		$upload_dir = wp_upload_dir();
		$file_name = '/bulk_prices_'.date('dmY', time()).'.sql';


		$handle = fopen($upload_dir['path'] . $file_name,'w+');
		fwrite($handle,$return);
		fclose($handle);

		$json['complete'] = true;
		$json['message'] = "Database Export Successfully!";
		$json['url'] = $upload_dir['url'] . $file_name;

		wp_send_json($json);
	}

	public function alt_bulk_price_listing() {
		global $wpdb;

		$data = array();

		$totalRow = $wpdb->get_var($this->raw_sql(true));

		$results = $wpdb->get_results($this->raw_sql());
		if( ! empty($results) ) {
			foreach( $results as $key => $result ) {
				$value = $result->price;

				$result_attributes = json_decode($result->attributes, true);

				$attributes = [];
				foreach( bulk_price_attributes() as $_key => $attribute ) {

					$attribute = implode(',', $attribute);
					$value_price = isset($result_attributes[$_key]) ? $result_attributes[$_key] : '';

					$attributes[ 'attribute_'. $_key ] = sprintf(
						'<div class="alt-bp-table-price-attribute"><input type="text" class="fixed_attr_price" name="attribute[%1$s]" value="%2$s" data-attribute="%1$s"></div>',
						$_key,
						$value_price
					);
				}

				$before_col = [
					'product_name' => $result->product_title . '<br /><button class="button-secondary bulkprice-remove-button" type="button" data-id="'.$result->id.'">Remove</button>',
					'sku' => $result->product_sku,
					'price' => sprintf(
						'<div class="alt-bp-table-price-input">%1$s<input type="text" class="fixed_price" name="fixed_price[%2$s]" value="%3$s"></div>',
						'<strong>SGD</strong> ',
						$result->id,
						$value
					)
				];

				$data[] = $before_col + $attributes + [
					'action' => sprintf('<input type="hidden" class="bulk_id" name="bulk_id" value="%d"><input type="hidden" class="product_id" name="product_id" value="%d"><button name="save" class="button-primary bulkprice-save-button" type="button">Update</button>', $result->id, $result->product_id)
				];
			}
		}

		wp_send_json( array(
			'draw' => absint($_POST['draw']),
			'recordsTotal' => absint($totalRow),
			'recordsFiltered' => absint($totalRow),
			'data' => $data
		) );
	}

	function alt_bulk_price_update() {
		global $wpdb;

		$json = [];

		$id = absint($_POST['product_id']);
		$price = sanitize_text_field($_POST['price']);

		$check = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bulk_prices WHERE product_id = %d", $id));

		if( ! empty($check) ) {
			$product = wc_get_product($check->product_id);

			if( ! empty($product) ) {
				$data = array(
					'product_title' => $product->get_title(),
					'product_sku' => $product->get_sku(),
					'price' => sanitize_text_field($_POST['price']),
					'attributes' => json_encode($_POST['attributes'])
				);
				$format = array('%s', '%s', '%s', '%s');
				$where = [ 'id' => $check->id ];
				$wpdb->update( $wpdb->prefix . 'bulk_prices', $data, $where, $format );
	
				$json['complete'] = true;
				$json['data'] = $this->update_price();
			}else {
				$json['message'] = sprintf('This product with ID: %d not exists', $id );
			}
		}

		wp_send_json($json);
	}

	function raw_sql($count = false) {
		global $wpdb;

		$query = array();

		$query['select'] = "SELECT * FROM {$wpdb->prefix}bulk_prices";
		if( $count ) {
			$query['select'] = "SELECT COUNT(*) FROM {$wpdb->prefix}bulk_prices";
		}

		if( ! empty($_POST['search']['value']) ) {
			$keyword = sanitize_text_field($_POST['search']['value']);
			$query['where'] = "WHERE product_sku = '{$keyword}' OR product_title LIKE '%{$keyword}%'";
		}
		
		$query['orderby'] = "ORDER BY id DESC";

		if( ! $count ) {
			$start = absint($_POST['start']);
			$limit = absint($_POST['length']);

			$query['limit'] = "LIMIT {$limit} OFFSET " . $start;
		}

		return implode(" ", $query);
	}

	function admin_enqueue_scripts() {
		wp_enqueue_style( 'datatables', get_template_directory_uri() . '/'. $this->slug .'/alt-product-bulk-price/datatables.min.css', false, '1.0.0' );
		wp_enqueue_style( 'style', get_template_directory_uri() . '/'. $this->slug .'/alt-product-bulk-price/admin.css', false, '1.0.0.0' );
		wp_enqueue_script( 'datatables', get_template_directory_uri() . '/'. $this->slug .'/alt-product-bulk-price/datatables.min.js', array(), '1.0' );
		wp_enqueue_script( 'datatables-main', get_template_directory_uri() . '/'. $this->slug .'/alt-product-bulk-price/admin.js', array(), time() );
		wp_localize_script( 'datatables-main', 'bulk_admin',
			array( 
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'columns' => bulk_price_col_attributes()
			)
		);
	}

	public function save() {
		global $wpdb;

		$product_id = absint($_POST['product_id']);
		$product = wc_get_product($product_id);

		if( empty($product) ) {
			return;
		}

		$check = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bulk_prices WHERE product_id = %d", $product_id));

		if( empty($check) ) {
			$table = $wpdb->prefix.'bulk_prices';
			$data = array(
				'product_id' => $product_id,
				'product_title' => $product->get_title(),
				'product_sku' => $product->get_sku(),
				'price' => sanitize_text_field($_POST['price']),
				'attributes' => json_encode($_POST['attributes'])
			);
			$format = array('%d','%s', '%s', '%s', '%s');
			$wpdb->insert($table,$data,$format);
			$my_id = $wpdb->insert_id;

			$this->update_price();

			wp_redirect(admin_url('admin.php?page=bulk-price-page') );
			die();
		}
	}

	public function update_price() {
		global $wpdb;
		
		$data = [];
		if( ! empty($_POST['attributes']) ) {
			$fixed_price = absint($_POST['price']);
			$config = bulk_price_attributes();
			$post_ids = $this->get_meta_id();

			foreach( $_POST['attributes'] as $key => $price ) {
				if( isset($config[$key]) ) {
					$post_ids = $this->get_meta_id($config[$key]);

					if( ! empty($post_ids) ) {
						foreach( $post_ids as $post ) {
							$final_price = ! is_numeric($price) ? '' : absint($price) + $fixed_price;

			
							$data[] = sprintf('<strong>#%d:</strong> <a href="%s" target="_blank">%s</a> - Price: %s', $post->ID, get_permalink($post->ID), $post->post_title, $final_price);
							update_post_meta($post->ID, '_regular_price', $final_price * 3.1);
						}
					}
				}
			}
		}

		return $data;
	}

	private function get_meta_id( $attributes = array() ) {
		global $wpdb;

		$product_id = absint($_POST['product_id']);

		$query = array();
		$query['select'] = "SELECT p.ID, p.post_excerpt as post_title FROM {$wpdb->posts} as p";
		//$query['select'] = "SELECT meta1.post_id FROM {$wpdb->postmeta} as meta1";

		$i = 1;
		$query['left_join'] = "";
		foreach( $attributes as $attribute => $value ) {
			$query['left_join'] .= " LEFT JOIN {$wpdb->postmeta} as meta{$i} ON p.ID = meta{$i}.post_id";
			$i++;
		}

		

		$i = 1;
		$query['where'] = "WHERE p.post_parent = {$product_id}";
		foreach( $attributes as $attribute => $value ) {
			$query['where'] .= " AND meta{$i}.meta_key = 'attribute_pa_{$attribute}' AND meta{$i}.meta_value = '{$value}'";
			$i++;
		}

		return $wpdb->get_results(implode(' ', $query));
	}
	
	public function install() {
		if( isset($_GET['bulk_price_install']) ) {
			global $wpdb;

			$wpdb->hide_errors();
	
			$collate = '';
			if ($wpdb->has_cap('collation')) {
				$collate = $wpdb->get_charset_collate();
			}

			$tables = "
			CREATE TABLE {$wpdb->prefix}bulk_prices (
				id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
				product_id INT(15) NOT NULL,
				product_title VARCHAR(250) NOT NULL,
				product_sku VARCHAR(50) NOT NULL,
				price VARCHAR(50) NOT NULL,
				attributes TEXT NOT NULL,
				created_at TIMESTAMP NOT NULL,
				PRIMARY KEY  (id)
			) $collate;";


			if ( ! $wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}bulk_prices';") ) {
				//$wpdb->hide_errors();
	
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
				dbDelta($tables);
			}
		}
	}
}

new ALT_Product_Bulk_Price();

