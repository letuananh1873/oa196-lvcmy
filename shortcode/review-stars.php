<?php
$terms = get_the_terms( get_the_ID(), 'review_stars' );
if( ! empty( $terms ) ) : ?>
<?php foreach( $terms as $term ) : ?>
  <div class="review_star"><img src="<?php the_field('star_image', $term); ?>"></div>
<?php endforeach; ?>
<?php endif; ?>