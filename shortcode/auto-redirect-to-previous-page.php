<?php if ( get_field( 'redirect_to_previous_page' ) ): ?>
	<?php if (is_page(6896)) { ?>
		<script>
        setTimeout(function(){ window.location.href = 'https://love-and-co.com/';}, 30000);
    </script>
		<?php } else { ?>
			<script>
        setTimeout(function(){history.back();}, 30000);
    </script>
		<?php } ?>
    
<?php else: ?>

<?php endif; ?>