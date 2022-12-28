<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
class Add_New_Metabox_Variable_Product {
	public function __construct() {	
		
		// 1. Add custom field input @ Product Data > Variations > Single Variation
		add_action( 'woocommerce_variation_options',  array( $this,'oa_add_custom_field_to_variations' ),10,3 );

		// 2. Save custom field on product variation save
		add_action( 'woocommerce_save_product_variation', array( $this,'oa_save_custom_field_variations' ), 10 ,2);

		// 3. Store custom field value into variation data
		//add_action( 'woocommerce_available_variation',  array( $this,'oa_add_custom_field_variation_data') , 10, 3 );

		// add metabox for single product meterial
		
		add_action( 'woocommerce_process_product_meta', array( $this,'save_product_options_custom_fields'), 40, 1 );

		// Admin footer scripts for this product categories admin screen.
		//add_action( 'admin_footer', array( $this,'scripts_at_single_material_screen_footer')  );
		// Admin header style for this product categories admin screen.
		add_action('admin_head', array( $this,'labour_css'));
	}


	// 1. Add custom field input @ Product Data > Variations > Single Variation
	function oa_add_custom_field_to_variations( $loop, $variation_data, $variation ) {
		/*$post_id = $_GET['post'] ?? '';		
		$class = !empty($post_id)?'':'hidden_labour_cost';*/
		/*$class = '';
		$terms_product = get_term_product_in_diamond($product_id);
		if (count($terms_product) > 0 ) {
			if (get_field('is_parents',$product_id) != 1){
				$class = 'hidden_metabox';
			}
		} else {
			$class = 'hidden_metabox';
		}*/
		 
		
		//echo '++++++++++++++++++ term_id='.$term_id.'////////////////////////';	

		echo '<div class="wrapper-setting-labour-price" id="wrapper-setting-bestsellers">';

		    woocommerce_wp_text_input( array( // Checkbox.
		        'id'            => '_is_bestsellers' . $loop  ,
		        'name'            => '_is_bestsellers[' . $loop .']',
		        'label'         => __( 'Bestsellers', 'woocommerce' ),
		        'value'         => get_post_meta( $variation->ID, '_is_bestsellers', true ),
		        'description'   => __( '', 'woocommerce' ),
		        'type' =>'number',
		        'default' => 0,
		        'custom_attributes' => array(
									'step' 	=> 'any',
									'min'	=> '0'
								) 
		    ) );

		     woocommerce_wp_text_input( array( // Checkbox.
		        'id'            => '_is_order' . $loop  ,
		        'name'            => '_is_order[' . $loop .']',
		        'label'         => __( 'Order', 'woocommerce' ),
		        'value'         => get_post_meta( $variation->ID, '_is_order', true ),
		        'description'   => __( 'Only parent product', 'woocommerce' ),
		        'type' =>'number',
		        'default' => 0,
		        'custom_attributes' => array(
									'step' 	=> 'any',
									'min'	=> '0'
								) 
		    ) );

			
		echo '</div>';
	}
	// 2. Save custom field on product variation save
	function oa_save_custom_field_variations( $variation_id, $i ) {
	   $_is_bestsellers = $_POST['_is_bestsellers'][$i]??'';
	   if (empty($_is_bestsellers)) $_is_bestsellers=0;
	   if ( isset( $_POST['_is_bestsellers'][$i]) ) update_post_meta( $variation_id, '_is_bestsellers', esc_attr( $_is_bestsellers ) );

	   $_is_order = $_POST['_is_order'][$i]??'';
	   if (empty($_is_order)) $_is_order=0;
	   if ( isset( $_POST['_is_order'][$i]) ) update_post_meta( $variation_id, '_is_order', esc_attr( $_is_order ) );

	   
	   
	}
	// 3. Store custom field value into variation data
	/*function oa_add_custom_field_variation_data( $variations ) {
	   $variations['labour_cost'] = '<div class="woocommerce_custom_field">Labour Cost: <span>' . get_post_meta( $variations[ 'variation_id' ], 'labour_cost', true ) . '</span></div>';
	   
	   
	   return $variations;
	}*/

	// 
	

	//var_dump(get_post_meta(77725,'_weight',true));

	function save_product_options_custom_fields( $post_id ){ // remove late
		//if (!(check_product_in_taxonomy($post_id,'material')))  return;

	    // Saving custom field value
	    if( isset( $_POST['_is_bestsellers'] ) ){
	        update_post_meta( $post_id, '_is_bestsellers', sanitize_text_field( $_POST['_is_bestsellers'] ) );
	    } 
	    if( isset( $_POST['_is_order'] ) ){
	        update_post_meta( $post_id, '_is_order', sanitize_text_field( $_POST['_is_order'] ) );
	    } 
	    
	  
	    
	}

	function labour_css() {
		
		/*if (false === check_is_product()) {
			return ;
		}*/
		
	?>
	
	<?php
	}
	}
new Add_New_Metabox_Variable_Product();






	