<?php
/**
 * Taxonomy API: Walker_Category_FaceWP class
 *
 * @package WordPress
 * @subpackage Administration
 * @since 4.4.0
 */

/**
 * Core walker class to output an unordered list of category checkbox input elements.
 *
 * @since 2.5.1
 *
 * @see Walker
 * @see wp_category_checklist()
 * @see wp_terms_checklist()
 */
class Walker_Category_FaceWP extends Walker {
	public $tree_type = 'category';
	public $db_fields = array(
		'parent' => 'parent',
		'id'     => 'term_id',
	); // TODO: Decouple this.

	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker:start_lvl()
	 *
	 * @since 2.5.1
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 * @param int    $depth  Depth of category. Used for tab indentation.
	 * @param array  $args   An array of arguments. @see wp_terms_checklist()
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent  = str_repeat( "\t", $depth );
		//$output .= "";
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @see Walker::end_lvl()
	 *
	 * @since 2.5.1
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 * @param int    $depth  Depth of category. Used for tab indentation.
	 * @param array  $args   An array of arguments. @see wp_terms_checklist()
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent  = str_repeat( "\t", $depth );
		//$output .= "";
	}

	/**
	 * Start the element output.
	 *
	 * @see Walker::start_el()
	 *
	 * @since 2.5.1
	 *
	 * @param string  $output   Used to append additional content (passed by reference).
	 * @param WP_Term $category The current term object.
	 * @param int     $depth    Depth of the term in reference to parents. Default 0.
	 * @param array   $args     An array of arguments. @see wp_terms_checklist()
	 * @param int     $id       ID of the current term.
	 */
	public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		$item = array();
		if ( empty( $args['taxonomy'] ) ) {
			$taxonomy = 'category';
		} else {
			$taxonomy = $args['taxonomy'];
		}

		if ( 'category' === $taxonomy ) {
			$name = 'post_category';
		} else {
			$name = 'tax_input[' . $taxonomy . ']';
		}

		$args['popular_cats'] = ! empty( $args['popular_cats'] ) ? array_map( 'intval', $args['popular_cats'] ) : array();

		$class = in_array( $category->term_id, $args['popular_cats'], true ) ? ' class="popular-category"' : '';

		$args['selected_cats'] = ! empty( $args['selected_cats'] ) ? array_map( 'intval', $args['selected_cats'] ) : array();

		if ( ! empty( $args['list_only'] ) ) {
			$aria_checked = 'false';
			$inner_class  = 'category';

			if ( in_array( $category->term_id, $args['selected_cats'], true ) ) {
				$inner_class .= ' selected';
				$aria_checked = 'true';
			}

			$output .= "\n" . '<li' . $class . '>' .
				'<div class="' . $inner_class . '" data-term-id=' . $category->term_id .
				' tabindex="0" role="checkbox" aria-checked="' . $aria_checked . '">' .
				/** This filter is documented in wp-includes/category-template.php */
				esc_html( apply_filters( 'the_category', $category->name, '', '' ) ) . '</div>';
		} else {
			$is_selected = in_array( $category->term_id, $args['selected_cats'], true );
			//$item['term_id'] = $category->term_id;
			$is_disabled = ! empty( $args['disabled'] );
			$item['facet_value'] = $category->slug;
			$item['facet_display_value'] = $category->name;
			$item['term_id'] = $category->term_id;
			$item['parent_id'] = $category->parent;
			$item['depth'] = $depth;
			$item['counter'] = $category->count;
			//$output .= '<option value="'.$category->slug.'" class="d'.$depth.'">'.$category->name.' </option>';
			$output[] = $item;

			/*$output .= '
				<input value="' . $category->term_id . '" type="checkbox" name="' . $name . '[]" id="in-' . $taxonomy . '-' . $category->term_id . '"' .
				checked( $is_selected, true, false ) .
				disabled( $is_disabled, true, false ) . ' /> ';*/
		}
		//return $item;
	}

	public function walk( $elements, $max_depth, ...$args ) {
		$output = array();

		// Invalid parameter or nothing to walk.
		if ( $max_depth < -1 || empty( $elements ) ) {
			return $output;
		}
		

		$parent_field = $this->db_fields['parent'];

		// Flat display.
		if ( -1 == $max_depth ) {
			$empty_array = array();
			foreach ( $elements as $e ) {
				$this->display_element( $e, $empty_array, 1, 0, $args, $output );
			}
			return $output;
		}
		

		/*
		 * Need to display in hierarchical order.
		 * Separate elements into two buckets: top level and children elements.
		 * Children_elements is two dimensional array, eg.
		 * Children_elements[10][] contains all sub-elements whose parent is 10.
		 */
		$top_level_elements = array();
		$children_elements  = array();
		foreach ( $elements as $e ) {
			if ( empty( $e->$parent_field ) ) {
				$top_level_elements[] = $e;
			} else {
				$children_elements[ $e->$parent_field ][] = $e;
			}
		}

		/*
		 * When none of the elements is top level.
		 * Assume the first one must be root of the sub elements.
		 */
		if ( empty( $top_level_elements ) ) {

			$first = array_slice( $elements, 0, 1 );
			$root  = $first[0];

			$top_level_elements = array();
			$children_elements  = array();
			foreach ( $elements as $e ) {
				if ( $root->$parent_field == $e->$parent_field ) {
					$top_level_elements[] = $e;
				} else {
					$children_elements[ $e->$parent_field ][] = $e;
				}
			}
		}

		foreach ( $top_level_elements as $e ) {
			$this->display_element( $e, $children_elements, $max_depth, 0, $args, $output );
		}

		/*
		 * If we are displaying all levels, and remaining children_elements is not empty,
		 * then we got orphans, which should be displayed regardless.
		 */
		if ( ( 0 == $max_depth ) && count( $children_elements ) > 0 ) {
			$empty_array = array();
			foreach ( $children_elements as $orphans ) {
				foreach ( $orphans as $op ) {
					$this->display_element( $op, $empty_array, 1, 0, $args, $output );
				}
			}
		}
		

		return $output;
	}


	/**
	 * Ends the element output, if needed.
	 *
	 * @see Walker::end_el()
	 *
	 * @since 2.5.1
	 *
	 * @param string  $output   Used to append additional content (passed by reference).
	 * @param WP_Term $category The current term object.
	 * @param int     $depth    Depth of the term in reference to parents. Default 0.
	 * @param array   $args     An array of arguments. @see wp_terms_checklist()
	 */
	public function end_el( &$output, $category, $depth = 0, $args = array() ) {
		//$output .= "";
	}
}
function wp_terms_wp_select2( $post_id = 0, $args = array(),$taxonomy_slug ) {
    $defaults = array(
        'descendants_and_self' => 0,
        'selected_cats'        => false,
        'popular_cats'         => false,
        'walker'               => null,
        'taxonomy'             => $taxonomy_slug,
        'checked_ontop'        => true,
        'echo'                 => false,
    );
    
    $params = apply_filters( 'wp_terms_checklist_args', $args, $post_id );

    $parsed_args = wp_parse_args( $params, $defaults );

    if ( empty( $parsed_args['walker'] ) || ! ( $parsed_args['walker'] instanceof Walker ) ) {
        $walker = new Walker_Category_FaceWP;
    } else {
        $walker = $parsed_args['walker'];
    }

    $taxonomy             = $parsed_args['taxonomy'];
    $descendants_and_self = (int) $parsed_args['descendants_and_self'];

    $args = array( 'taxonomy' => $taxonomy );

    $tax              = get_taxonomy( $taxonomy );
    $args['disabled'] = ! current_user_can( $tax->cap->assign_terms );

    $args['list_only'] = ! empty( $parsed_args['list_only'] );

    if ( is_array( $parsed_args['selected_cats'] ) ) {
        $args['selected_cats'] = array_map( 'intval', $parsed_args['selected_cats'] );
    } elseif ( $post_id ) {
        $args['selected_cats'] = wp_get_object_terms( $post_id, $taxonomy, array_merge( $args, array( 'fields' => 'ids' ) ) );
    } else {
        $args['selected_cats'] = array();
    }

    if ( is_array( $parsed_args['popular_cats'] ) ) {
        $args['popular_cats'] = array_map( 'intval', $parsed_args['popular_cats'] );
    } else {
        $args['popular_cats'] = get_terms(
            array(
                'taxonomy'     => $taxonomy,
                'fields'       => 'ids',
                'orderby'      => 'count',
                'order'        => 'DESC',
                'number'       => 10,
                'hierarchical' => false,
            )
        );
    }

    if ( $descendants_and_self ) {
        $categories = (array) get_terms(
            array(
                'taxonomy'     => $taxonomy,
                'child_of'     => $descendants_and_self,
                'hierarchical' => 0,
                'hide_empty'   => true,
            )
        );
        $self       = get_term( $descendants_and_self, $taxonomy );
        array_unshift( $categories, $self );
    } else {
        $categories = (array) get_terms(
            array(
                'taxonomy' => $taxonomy,
                'get'      => 'all',
                'hide_empty'   => true,
            )
        );
    }

    $output = array();
   // var_dump($walker->walk( $categories, 0, $args ));
    

   
    // Then the rest of them.
    $as = $walker->walk( $categories, 0, $args );
    foreach ($as as $key => $a) {
    	if ($a['counter'] == 0) unset($as[$key]);
    }
    $output = $as;

    if ( $parsed_args['echo'] ) {
        //echo $output;
    }

    return $output;
}