<?php if ( get_field( 'redirect_to_home_page' ) ): ?>
    <script>
        var redirect_timer = setTimeout(function() {
            window.location='<?php echo get_home_url(); ?>'
        }, 5000);
    </script>
<?php else: ?>

<?php endif; ?>