<?php
class NBT_Color_Swatches_Ajax{

	protected static $initialized = false;
	
    /**
     * Initialize functions.
     *
     * @return  void
     */
    public static function initialize() {
        if ( self::$initialized ) {
            return;
        }

	    self::admin_hooks();
        self::$initialized = true;
    }


    public static function admin_hooks(){
		add_action( 'wp_ajax_nopriv_cs_load_variations', array( __CLASS__, 'cs_load_variations') );
		add_action( 'wp_ajax_cs_load_variations', array( __CLASS__, 'cs_load_variations') );

		add_action( 'wp_ajax_nopriv_cs_load_style', array( __CLASS__, 'cs_load_style') );
		add_action( 'wp_ajax_cs_load_style', array( __CLASS__, 'cs_load_style') );

		add_action( 'wp_ajax_nopriv_cs_save', array( __CLASS__, 'cs_save') );
		add_action( 'wp_ajax_cs_save', array( __CLASS__, 'cs_save') );
    }

    public static function cs_load_variations(){
		$nonce = $_REQUEST['security'];

		if ( ! wp_verify_nonce( $nonce, 'load-variations' ) ) {

		     die( 'Security check' ); 

		} else {
			$json = array();
			global $wpdb, $woocommerce;

			$product_id = isset( $_POST['product_id'] ) ? wc_clean( $_POST['product_id'] ) : '';
			$attributes = isset( $_POST['attributes'] ) ? wc_clean( $_POST['attributes'] ) : '';
		

			$product = wc_get_product($product_id);

			$html = '';
    		$json['complete'] = true;

    		if($attributes):
    			
     			foreach ($attributes as $key_tax => $attribute) :
     				if($attribute['is_taxonomy']){
						$attribute_id = intval($attribute['id']);
						$attribute_label = $wpdb->get_var( "SELECT attribute_label FROM {$wpdb->prefix}woocommerce_attribute_taxonomies WHERE attribute_id = $attribute_id" );
     				}else{
     					$attribute_label = $attribute['name'];
     				}


     				



    				ob_start();
    				$attr = NBT_Solutions_Color_Swatches::get_tax_attribute( $key_tax);
    				$_cs_type = get_post_meta($product->get_id(), '_cs_type', TRUE);
    				if($_cs_type){
    					$cs_type = $_cs_type[$key_tax]['type'];
    				}else{
    					$cs_type = $attr->attribute_type;
    				}
    				?>
					<div data-taxonomy="<?php echo $key_tax;?>" class="woocommerce_attribute wc-metabox taxonomy <?php echo $key_tax;?> <?php echo $cs_type;?> closed" rel="0">
						<h3>
							<a href="#" class="remove_row delete">Remove</a>
							<div class="handlediv" title="Click to toggle" aria-expanded="true"></div>
							<strong class="attribute_name"><?php echo $attribute_label;?></strong>
						</h3>
						
						<div class="woocommerce_attribute_data wc-metabox-content" style="display: none;">
							<table class="global-table" cellpadding="0" cellspacing="0">
								<tbody>
									<tr class="first-row">
										<td>
											<label>Type</label>
											<select data-id="<?php echo $key_tax;?>" name="type_<?php echo $key_tax;?>[]" class="cs-type-tax">
												<option value="0">(select a type)</option>
												<?php
												foreach (NBT_Solutions_Color_Swatches::$types as $k_types => $value) {
													$selected = '';
													if($attr->attribute_type == $k_types || isset($_cs_type[$key_tax]['type']) && $_cs_type[$key_tax]['type'] == $k_types){
														$selected = ' selected';
													}
													printf('<option value="%s"%s>%s</option>', $k_types, $selected, $value);
												}?>
											</select>
										</td>
										<td>
											<label>Style</label>
											<ul class="list-style">
											<?php
											foreach (NBT_Solutions_Color_Swatches::get_style() as $k_style => $style) {
												$selected = '';
												$checked = '';
												if(isset($_cs_type[$key_tax]['style']) && $_cs_type[$key_tax]['style'] == $k_style){
													$selected = ' selected';
													$checked = ' checked';
												}?>

												<li class="<?php echo $k_style;?><?php echo $selected;?>">
													<input type="radio" class="input-radio" name="<?php echo $key_tax;?>" id="<?php echo $key_tax;?>_<?php echo $k_style;?>" value="<?php echo $k_style;?>"<?php echo $checked;?>>
													<div class="cs-radio">
														<span></span>
													</div>
												</li>
												<?php
											}?>
											</ul>
										</td>
									</tr>
									<?php

									if( $cs_type != 'radio' && $cs_type != 'label' ){?>
									<tr>
										<td colspan="2">
											<table class="<?php if(empty($cs_type)){ echo 'no-selected ';}?>pm_repeater<?php echo $selected;?>">
												<thead>
													<tr>
														<th class="pm-row-zero" style="width: 5%"></th>
														<th class="pm-th" style="width: 50%">Value</th>
														<th class="pm-th" style="width: 45%">Display</th>
													</tr>
												</thead>
												<tbody>
												<?php $get_attributes = $product->get_attributes( 'edit' );
												if( isset($get_attributes[$key_tax]) ){
													$_attribute = $get_attributes[$key_tax];
													$terms = array();
													if ( $_attribute->is_taxonomy() ) :
														$terms = json_decode(json_encode($_attribute->get_terms()), true);
													else :

														$value_array = $_attribute->get_options();
													
														$terms = array();
														foreach ($value_array as $key => $value) {
															$terms[] = array(
																'term_id' => $key,
																'taxonomy' => $attr_id,
																'name' => trim($value),
																'slug' => trim($value),
																'is_taxonomy' => false
															);
														}
													endif;

													if($terms){

														foreach ($terms as $key => $term) {
															$value = get_term_meta( $term['term_id'], $cs_type, true );
											    			if(isset($_cs_type[$key_tax]['value'])){
											    				$value = $_cs_type[$key_tax]['value'][$key];
												    		}
															?>
													<tr class="pm-row">
														<td class="pm-row-zero order">
															<span><?php echo ($key+1);?></span>
														</td>

														<td class="pm-field">
															<div class="pm-input">
																<div class="pm-input-wrap">
																	<select class="pm-attributes-field" name="term_child[]" data-option="0">
																		<option value="<?php echo $term['name'];?>"><?php echo $term['name'];?></option>
																	</select>
																</div>
															</div>
														</td>
														<td class="pm-field">
															<div class="pm-input">
																<div class="pm-input-wrap">
																	<?php NBT_Color_Swatches_Admin::show_field($cs_type, $key_tax, $value);?>
																</div>
															</div>
														</td>
													</tr>
													<?php }
													}?>
												</tbody>
												<?php }?>
											</table>

										</td>
									</tr>
									<?php }else{?>
									<tr>
										<td colspan="2">
											<table class="pm_repeater" style="display: none"></table>
										</td>
									</tr>
									<?php }?>
								</tbody>
							</table>
						</div>
					</div>
    			<?php
    				$html .= ob_get_clean();
    			endforeach;

    		endif;

    		$json['html'] = $html;
    	}

    	echo wp_json_encode($json);
    	wp_die();
    }

    public function cs_load_style(){
		$nonce = $_REQUEST['security'];

		if ( ! wp_verify_nonce( $nonce, 'load-variations' ) ) {

		     die( 'Security check' ); 

		} else {
			$json = array();
			global $wpdb, $woocommerce;

			$product_id = isset( $_POST['product_id'] ) ? wc_clean( $_POST['product_id'] ) : '';
			$attributes = isset( $_POST['attributes'] ) ? wc_clean( $_POST['attributes'] ) : '';
			$row = $_POST['row'];
			$key_tax = $_POST['tax'];
			$type = $_POST['type'];


			$product = wc_get_product($product_id);



			$html = '';
    		$json['complete'] = true;

    		if($attributes):
    			

    
    				ob_start();?>

									<?php if($type != 'radio'){?>
											<table class="pm_repeater<?php echo $selected;?>">
												<thead>
													<tr>
														<th class="pm-row-zero" style="width: 5%"></th>
														<th class="pm-th" style="width: 50%">Value</th>
														<th class="pm-th" style="width: 45%">Display</th>
													</tr>
												</thead>
												<tbody>
												<?php $get_attributes = $product->get_attributes( 'edit' );
												if( isset($get_attributes[$key_tax]) ){
													$_attribute = $get_attributes[$key_tax];
													$terms = array();

													$_cs_type = get_post_meta($product->get_id(), '_cs_type', TRUE);
 	

    	
				if ( $_attribute->is_taxonomy() ) :
					$terms = json_decode(json_encode($_attribute->get_terms()), true);
				else :

					$value_array = $_attribute->get_options();
					$terms = array();

					foreach ($value_array as $key => $value) {
						$terms[] = array(
							'term_id' => $key,
							'taxonomy' => $attr_id,
							'name' => trim($value),
							'slug' => trim($value),
							'is_taxonomy' => false
						);
					}
				endif;

				





													if($terms){
														foreach ($terms as $key => $term) {
															$value = get_term_meta( $term['term_id'], $type, true );
											    			if(isset($_cs_type[$key_tax]['value'])){
											    				$value = $_cs_type[$key_tax]['value'][$key];
												    		}
															?>
													<tr class="pm-row">
														<td class="pm-row-zero order">
															<span><?php echo ($key+1);?></span>
														</td>

														<td class="pm-field">
															<div class="pm-input">
																<div class="pm-input-wrap">
																	<select class="pm-attributes-field" name="term_child[]" data-option="0">
																		<option value="<?php echo $term['name'];?>"><?php echo $term['name'];?></option>
																	</select>
																</div>
															</div>
														</td>
														<td class="pm-field">
															<div class="pm-input">
																<div class="pm-input-wrap">
																	<?php NBT_Color_Swatches_Admin::show_field($type, $key_tax, $value);?>
																</div>
															</div>
														</td>
													</tr>
													<?php }
													}?>
												</tbody>
												<?php }?>
											</table>
									<?php }?>
    			<?php



    				$html .= ob_get_clean();

    		endif;

    		$json['html'] = $html;
 
    	}

    	echo wp_json_encode($json);
    	wp_die();
    }


    public function cs_save(){
    	$product_id = intval($_REQUEST['product_id']);
    	$product = wc_get_product($product_id);

    	$types = $_REQUEST['type'];
    	$tax = $_REQUEST['tax'];
    	$style = $_REQUEST['style'];
    	$custom = $_REQUEST['custom'];


    	$new_array = array();
    	foreach ($types as $key => $type) {
    		$value = $custom[$key][1][$type];
    		$new_array[$tax[$key]] = array(
    			'type' => $type,
    			'style' => $style[$key],
    			'value' => $value
    		);
    	}

    	update_post_meta($product->get_id(), '_cs_type', $new_array);

    	$json['complete'] = true;
 	
        echo wp_json_encode($json);
    	wp_die();	
    }
}