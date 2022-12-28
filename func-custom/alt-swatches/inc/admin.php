<?php
class ALT_Product_Swatches_Admin {

	public $color_swatches = 'color_swatches';

	/**
	 * Class constructor.
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'init_attribute_hooks' ) );
		add_action( 'admin_print_scripts', array( $this, 'enqueue_scripts' ) );

		add_action( 'nbt_cs_product_attribute_field', array( $this, 'attribute_fields' ), 10, 3 );
		add_action( 'woocommerce_product_option_terms', array( $this, 'product_option_terms' ), 10, 3 );



		/* Tab Settings */
		// add_filter('woocommerce_product_data_tabs', array($this, 'woocommerce_product_tabs'), 50, 1);
		// add_action( 'woocommerce_product_data_panels', array($this, 'woocommerce_product_panels') );
		// add_action('woocommerce_process_product_meta_variable', array($this, 'woocommerce_process_product_meta_variable'), 10, 1);

		/* Arribute Page */
		add_action( 'woocommerce_after_add_attribute_fields', array($this, 'woocommerce_after_add_attribute_fields'), 10, 0 );
		add_action( 'woocommerce_after_edit_attribute_fields', array($this, 'woocommerce_after_edit_attribute_fields'), 10, 0 );
		add_action( 'woocommerce_attribute_added', array($this, 'woocommerce_attribute_added'), 10, 2 );
		add_action( 'woocommerce_attribute_updated', array($this, 'woocommerce_attribute_updated'), 10, 3 );

		
		if(get_option('attribute_break')) {
			add_action('woocommerce_before_variations_form', array($this, 'woocommerce_before_variations_form'), 10, 0 );
			add_action('woocommerce_after_variations_form', array($this, 'woocommerce_after_variations_form'), 10, 0 );
		}	

	}

	public function woocommerce_after_add_attribute_fields(){?>
		<div class="form-field">
			<label for="attribute_style"><?php _e( 'Style', 'woocommerce' ); ?></label>
			<select name="attribute_style" id="attribute_orderby">
				<?php
				foreach (ALT_Product_Swatches::get_style() as $key => $value) {
					?>
					<option value="<?php echo $key;?>"><?php _e( $value, 'woocommerce' ); ?></option>
					<?php
				}?>
			</select>
		</div>
		<?php
	}

	public function woocommerce_after_edit_attribute_fields(){
		global $wpdb;

		$edit = absint( $_GET['edit'] );

		$attribute_to_edit = $wpdb->get_row( "SELECT attribute_type, attribute_label, attribute_name, attribute_orderby, attribute_public FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_id = '$edit'" );

		if($attribute_to_edit){
			$style = get_option('attribute_style_'.$edit);?>
		<tr class="form-field form-required">
			<th scope="row" valign="top">
				<label for="attribute_style"><?php _e( 'Style', 'woocommerce' ); ?></label>
			</th>
			<td>
				<select name="attribute_style" id="attribute_style">
					<?php
					foreach (ALT_Product_Swatches::get_style() as $key => $value) {
						?>
						<option value="<?php echo $key;?>"<?php if($key == $style){ echo ' selected';}?>><?php _e( $value, 'woocommerce' ); ?></option>
						<?php
					}?>
				</select>
			</td>
		</tr>

		<?php
		}
	}

	public function woocommerce_attribute_added($id, $attr){
		update_option( 'attribute_style_'.$id, $_REQUEST['attribute_style'] );
		update_option( 'attribute_break_'.$id, $_REQUEST['attribute_break'] );

	}

	public function woocommerce_attribute_updated($attribute_id, $attribute, $old_attribute_name){
		update_option( 'attribute_style_'.$attribute_id, $_REQUEST['attribute_style'] );
		update_option( 'attribute_break_'.$attribute_id, $_REQUEST['attribute_break'] );

	}

	public function woocommerce_product_tabs($product_data_tabs){
		$product_data_tabs[$this->color_swatches] = array(
			'label' => __( 'Color Swatches', 'nbt-woocommerce-price-matrix' ),
			'target' => $this->color_swatches,
			'class'  => array( 'hide show_if_variable' ),
		);

		return $product_data_tabs;
	}

	public function woocommerce_product_panels(){
		global $post;

		$product = wc_get_product( $post->ID );
		$attribute_taxonomies = wc_get_attribute_taxonomies();

		include_once( NBT_CS_PATH . 'tpl/admin/tabs.php');
	}

	public function woocommerce_process_product_meta_variable($post_id){
		if(isset($_POST['_color_swatches'])){
			update_post_meta( $post_id, '_color_swatches', $_POST['_color_swatches']);
		}else {
			update_post_meta( $post_id, '_color_swatches', false);
		}
	}



	public function init_attribute_hooks() {
		$attribute_taxonomies = wc_get_attribute_taxonomies();

		if ( empty( $attribute_taxonomies ) ) {
			return;
		}

		foreach ( $attribute_taxonomies as $tax ) {
			add_action( 'pa_' . $tax->attribute_name . '_add_form_fields', array( $this, 'add_attribute_fields' ) );
			add_action( 'pa_' . $tax->attribute_name . '_edit_form_fields', array( $this, 'edit_attribute_fields' ), 10, 2 );

			add_filter( 'manage_edit-pa_' . $tax->attribute_name . '_columns', array( $this, 'add_attribute_columns' ) );
			add_filter( 'manage_pa_' . $tax->attribute_name . '_custom_column', array( $this, 'add_attribute_column_content' ), 10, 3 );
		}

		add_action( 'created_term', array( $this, 'save_term_meta' ), 10, 2 );
		add_action( 'edit_term', array( $this, 'save_term_meta' ), 10, 2 );

	}

	public function woocommerce_before_variations_form(){
		echo '<div id="nbtcs-unlinebreak">';
	}
	public function woocommerce_after_variations_form(){
		echo '</div>';
	}
	/**
	 * Load stylesheet and scripts in edit product attribute screen
	 */
	public function enqueue_scripts() {
		$screen = get_current_screen();
		if ( strpos( $screen->id, 'edit-pa_' ) === false && strpos( $screen->id, 'product' ) === false ) {
			return;
		}

		wp_enqueue_media();

		wp_enqueue_style( 'color-swatches-admin', ALT_SWATCHES_URL . 'assets/admin.css', array( 'wp-color-picker' )  );
		wp_enqueue_script( 'color-swatches-admin', ALT_SWATCHES_URL . 'assets/admin.js', array( 'jquery', 'wp-color-picker', 'wp-util' ));

		wp_localize_script(
			'color-swatches-admin',
			'nbtcs',
			array(
				'i18n'        => array(
					'mediaTitle'  => esc_html__( 'Choose an image', 'wcvs' ),
					'mediaButton' => esc_html__( 'Use image', 'wcvs' ),
				),
				'placeholder' => WC()->plugin_url() . '/assets/images/placeholder.png'
			)
		);
	}


	/**
	 * Create hook to add fields to add attribute term screen
	 *
	 * @param string $taxonomy
	 */
	public function add_attribute_fields( $taxonomy ) {
		$attr = ALT_Product_Swatches::get_tax_attribute( $taxonomy );
		do_action( 'nbt_cs_product_attribute_field', $attr->attribute_type, '', 'add' );
	}

	/**
	 * Create hook to fields to edit attribute term screen
	 *
	 * @param object $term
	 * @param string $taxonomy
	 */
	public function edit_attribute_fields( $term, $taxonomy ) {
		$attr  = ALT_Product_Swatches::get_tax_attribute( $taxonomy );
		$value = get_term_meta( $term->term_id, $attr->attribute_type, true );
		do_action( 'nbt_cs_product_attribute_field', $attr->attribute_type, $value, 'edit' );
	}

	/**
	 * Print HTML of custom fields on attribute term screens
	 *
	 * @param $type
	 * @param $value
	 * @param $form
	 */
	public function attribute_fields( $type, $value, $form ) {
		// Return if this is a default attribute type
		if ( in_array( $type, array( 'select', 'text' ) ) ) {
			return;
		}

		// Print the open tag of field container
		if($type != 'radio'){
			printf(
				'<%s class="form-field">%s<label for="term-%s">%s</label>%s',
				'edit' == $form ? 'tr' : 'div',
				'edit' == $form ? '<th>' : '',
				esc_attr( $type ),
				ALT_Product_Swatches::$types[$type],
				'edit' == $form ? '</th><td>' : ''
			);
		}


		switch ( $type ) {
			case 'image':
				$image = $value ? wp_get_attachment_image_src( $value ) : '';
				$image = $image ? $image[0] : WC()->plugin_url() . '/assets/images/placeholder.png';
				?>
				<div class="nbtcs-wrap-image">
					<div class="nbtcs-term-image-thumbnail">
						<img src="<?php echo esc_url( $image ) ?>" width="60px" height="60px" />
					</div>
					<div class="azcs-type-image-right">
						<input type="hidden" class="nbtcs-term-image" name="image" value="<?php echo esc_attr( $value ) ?>" />
						<button type="button" class="nbtcs-upload-image-button button"><?php esc_html_e( 'Upload/Add image', 'wcvs' ); ?></button>
						<button type="button" class="nbtcs-remove-image-button button <?php echo $value ? '' : 'hidden' ?>"><?php esc_html_e( 'Remove image', 'wcvs' ); ?></button>
					</div>
				</div>
				<?php
				break;

			case 'color':
				?>
				<input type="text" id="term-<?php echo esc_attr( $type ) ?>" name="<?php echo esc_attr( $type ) ?>" value="<?php echo esc_attr( $value ) ?>" />
				<?php
				break;
			default:
				break;
		}

		if($type != 'radio'){
			echo 'edit' == $form ? '</td></tr>' : '</div>';
		}
	}

	public static function show_field($type, $key, $value){
		switch ( $type ) {
			case 'image':
				$image = $value ? wp_get_attachment_image_src( $value ) : '';
				$image = $image ? $image[0] : WC()->plugin_url() . '/assets/images/placeholder.png';
				?>
				<div class="nbtcs-wrap-image">
					<div class="nbtcs-term-image-thumbnail" style="float:left;margin-right:10px;">
						<img src="<?php echo esc_url( $image ) ?>" width="60px" height="60px" />
					</div>
					<div class="right-button-term" style="line-height:60px;">
						<input type="hidden" class="nbtcs-term-image" name="image" value="<?php echo esc_attr( $value ) ?>" />
						<button type="button" class="nbtcs-upload-image-button button"><?php esc_html_e( 'Upload/Add image', 'wcvs' ); ?></button>
						<button type="button" class="nbtcs-remove-image-button button <?php echo $value ? '' : 'hidden' ?>"><?php esc_html_e( 'Remove image', 'wcvs' ); ?></button>
					</div>
				</div>
				<?php
				break;

			case 'color':
				?>
				<input type="text" class="term-alt-color term-<?php echo esc_attr( $type ) ?>" name="<?php echo esc_attr( $type ) ?>" value="<?php echo esc_attr( $value ) ?>" />
				<?php
				break;
			default:
				break;
		}
	}

	/**
	 * Save term meta
	 *
	 * @param int $term_id
	 * @param int $tt_id
	 */
	public function save_term_meta( $term_id, $tt_id ) {
		foreach ( ALT_Product_Swatches::$types as $type => $label ) {
			if ( isset( $_POST[$type] ) ) {
				update_term_meta( $term_id, $type, $_POST[$type] );
			}
		}
	}

	/**
	 * Add selector for extra attribute types
	 *
	 * @param $taxonomy
	 * @param $index
	 */
	public function product_option_terms( $attribute_taxonomy, $i, $attribute ) {
		if ( array_key_exists( $attribute_taxonomy->attribute_type, ALT_Product_Swatches::$types ) ) {
			?>
			<select multiple="multiple" data-placeholder="<?php esc_attr_e( 'Select terms', 'woocommerce' ); ?>" class="multiselect attribute_values wc-enhanced-select" name="attribute_values[<?php echo esc_attr( $i ); ?>][]">
				<?php
				$args      = array(
					'orderby'    => ! empty( $attribute_taxonomy->attribute_orderby ) ? $attribute_taxonomy->attribute_orderby : 'name',
					'hide_empty' => 0,
				);
				$all_terms = get_terms( $attribute->get_taxonomy(), apply_filters( 'woocommerce_product_attribute_terms', $args ) );
				if ( $all_terms ) {
					foreach ( $all_terms as $term ) {
						$options = $attribute->get_options();
						$options = ! empty( $options ) ? $options : array();
						echo '<option value="' . esc_attr( $term->term_id ) . '"' . wc_selected( $term->term_id, $options ) . '>' . esc_html( apply_filters( 'woocommerce_product_attribute_term_name', $term->name, $term ) ) . '</option>';
					}
				}
				?>
			</select>
			<button class="button plus select_all_attributes"><?php esc_html_e( 'Select all', 'woocommerce' ); ?></button>
			<button class="button minus select_no_attributes"><?php esc_html_e( 'Select none', 'woocommerce' ); ?></button>
			<button class="button fr plus add_new_attribute"><?php esc_html_e( 'Add new', 'woocommerce' ); ?></button>
			<?php
		}
	}

	/**
	 * Add thumbnail column to column list
	 *
	 * @param array $columns
	 *
	 * @return array
	 */
	public function add_attribute_columns( $columns ) {
		$new_columns          = array();
		$new_columns['cb']    = $columns['cb'];
		$new_columns['thumb'] = '';
		unset( $columns['cb'] );

		return array_merge( $new_columns, $columns );
	}

	/**
	 * Render thumbnail HTML depend on attribute type
	 *
	 * @param $columns
	 * @param $column
	 * @param $term_id
	 */
	public function add_attribute_column_content( $columns, $column, $term_id ) {
		$attr  = ALT_Product_Swatches::get_tax_attribute( $_REQUEST['taxonomy'] );
		$value = get_term_meta( $term_id, $attr->attribute_type, true );

		switch ( $attr->attribute_type ) {
			case 'color':
				printf( '<div class="swatch-preview swatch-color" style="background-color:%s;"></div>', esc_attr( $value ) );
				break;

			case 'image':
				$image = $value ? wp_get_attachment_image_src( $value ) : '';
				$image = $image ? $image[0] : WC()->plugin_url() . '/assets/images/placeholder.png';
				printf( '<img class="swatch-preview swatch-image" src="%s" width="44px" height="44px">', esc_url( $image ) );
				break;

			case 'label':
				printf( '<div class="swatch-preview swatch-label">%s</div>', esc_html( $value ) );
				break;
		}
	}
}

new ALT_Product_Swatches_Admin();