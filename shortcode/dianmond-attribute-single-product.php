<div class="tax-wrapper-attribute">
<?php
global $woocommerce;
$taxonomies_att = array('pa_shapes','pa_metal-type','pa_casing');
foreach ($taxonomies_att as $key => $taxonomy_slug) {
	$terms = get_terms(
		$taxonomy_slug,
		array(
			'hide_empty' => 1
		)
	);

	if (!is_wp_error( $terms ) && count($terms) > 0) { ?>
		<?php
		$tax = get_taxonomy($taxonomy_slug);
		/*echo '<pre>';
		var_dump($tax);
		echo '</pre>';*/
		?>
		<div class="wrapper-item-attr">
			<div class="tax-attribute-item">
				<div class="taxonomy-name"><strong><?php echo $tax->labels->singular_name; ?>:</strong></div>
				<div class="attribute-item-name"></div>
			</div>
			<div class="list-att">
				<?php foreach ($terms as $key => $term) { ?>
					<?php
					$name = $term->name;
					$term_id = $term->term_id;
					$icon_shape = get_field('icon_shate','term_'.$term_id) ?? '';
					if (!empty($icon_shape)) {
						$name = '<img src="'.$icon_shape.'"/>';
					}
					?>
					<div data-nameAtt="<?php echo $term->name; ?>" data-id = "<?php echo $term_id; ?>" class="item-att" id="term_<?php echo $term->term_id; ?>" ><?php echo $name; ?></div>
				<?php } ?>
			</div>
		</div><!-- end wrapper-item-attr -->
	<?php }
}
echo 'abcdef';
?>
</div>