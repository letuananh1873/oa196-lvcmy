<?php
add_action('init', function() {
	global $wpdb;

	if( isset($_GET['altmodule']) && $_GET['altmodule'] == 'minmax' ) {
		//$product_id = $_GET['altdev'];


		$total_variations = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT COUNT(*) FROM {$wpdb->posts} as p LEFT JOIN {$wpdb->prefix}term_relationships as tr ON p.ID = tr.object_id LEFT JOIN {$wpdb->terms} as t ON tr.term_taxonomy_id = t.term_id WHERE p.post_status = %s AND p.post_type = %s AND t.slug = %s",
				'publish',
				'product',
				'variable'
			)
		);

		


		$items_per_page = 10;
		$totalPages  = ceil($total_variations/$items_per_page);
		$page  = isset($_GET['alt_page']) ? absint($_GET['alt_page']) : 1;
		$offset      = ($page - 1) * $items_per_page;

		echo '<h1>Total: ' . $total_variations .' (Total Page: '.$totalPages.')</h1>';

		echo '<ul style="list-style: none; margin: 0;padding: 0;">';
		for ($x = 1; $x <= $totalPages; $x++) {
			$style = '';
			if($x == $page) {
				$style = 'color: red;';
			}
			echo '<li style="display: inline-block;margin: 0 6px;">';
		echo sprintf('<a style="%3$s" href="%1s?altmodule=minmax&alt_page=%2$d">%2$d</a></li>', home_url(), $x, $style);
		}
		echo '</ul>';

		$results = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM {$wpdb->posts} as p LEFT JOIN {$wpdb->prefix}term_relationships as tr ON p.ID = tr.object_id LEFT JOIN {$wpdb->terms} as t ON tr.term_taxonomy_id = t.term_id WHERE p.post_status = %s AND p.post_type = %s AND t.slug = %s  LIMIT %d,%d",
				'publish',
				'product',
				'variable',
				$offset,
				$items_per_page
			)
		);

		if( ! empty($results) ) {
			foreach( $results as $result ) {
				echo '<h1>'.$result->post_title.' (' . $result->ID .')</h1>';
				$attributes = $wpdb->get_results(
					$wpdb->prepare(
						"SELECT p.ID, meta.meta_value FROM {$wpdb->posts} as p LEFT JOIN {$wpdb->postmeta} as meta ON meta.post_id = p.ID WHERE p.post_status = %s AND p.post_type = %s AND p.post_parent = %d AND meta.meta_key = %s",
						'publish',
						'product_variation',
						$result->ID,
						'_price'
					)
				);

				if( ! empty($attributes) ) {
					$prices = [];
					foreach ($attributes as $key => $variation) {
						$price = number_format($variation->meta_value, 2, '.', '');
						$lookup = $wpdb->get_row($wpdb->prepare(
							"SELECT * FROM {$wpdb->prefix}wc_product_meta_lookup WHERE product_id = %d",
							$variation->ID
						));

						$price = empty($price) ? 0 : $price;
                        $prices[] = $price;

						if( empty($lookup) ) {
							$wpdb->insert($wpdb->prefix . 'wc_product_meta_lookup', [
								'product_id' => $variation->ID,
								'sku' => get_post_meta($variation->ID, '_sku', true),
								'min_price' => $price,
								'max_price' => $price,
								'tax_status' => get_post_meta($variation->ID, '_tax_status', true),
								'stock_status' => get_post_meta($variation->ID, '_stock_status', true),
								'stock_quantity' => get_post_meta($variation->ID, '_stock', true),
								'tax_class' => 'parent'
							], array('%d','%s', '%s', '%s', '%s', '%s', '%s', '%s'));

							echo 'Insert variation ->' . $price .'<br />'; 
						}else {
							$wpdb->update( $wpdb->prefix . 'wc_product_meta_lookup', [
								'min_price' => $price,
								'max_price' => $price,
							], [
								'product_id' => $variation->ID
							] );
							echo 'Update variation ->' . $price .'<br />'; 
						}
					}


					$lookup_parent = $wpdb->get_row($wpdb->prepare(
						"SELECT * FROM {$wpdb->prefix}wc_product_meta_lookup WHERE product_id = %d",
						$result->ID
					));

					$min = min($prices);
					$max = max($prices);

                    $min = empty($min) ? 0 : $min;
                    $max = empty($max) ? 0 : $min;

					if( empty($lookup_parent) ) {
						$wpdb->insert($wpdb->prefix . 'wc_product_meta_lookup', [
							'product_id' => $result->ID,
							'sku' => get_post_meta($result->ID, '_sku', true),
							'min_price' => $min,
							'max_price' => $max,
							'tax_status' => get_post_meta($result->ID, '_tax_status', true),
							'stock_status' => get_post_meta($result->ID, '_stock_status', true),
							'stock_quantity' => get_post_meta($result->ID, '_stock', true),
							'tax_class' => ''
						], array('%d','%s', '%s', '%s', '%s', '%s', '%s', '%s'));

						echo 'Insert Parent';
					}else {
						$wpdb->update( $wpdb->prefix . 'wc_product_meta_lookup', [
							'min_price' => $min,
							'max_price' => $max,
						], [
							'product_id' => $parent->ID
						] );
					}



					echo '<h3>Min: ' . $min .' -- Max: '.$max .'</h3>';
				}

			}
		}

		die();
	}
});
