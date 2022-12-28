<?php
    wp_nav_menu( array( 
            'theme_location' => 'header-menu-v2', 
            'container_class' => 'header-menu-v2',
            'walker' => new HeaderMenuV2
        ) 
    ); 
?>