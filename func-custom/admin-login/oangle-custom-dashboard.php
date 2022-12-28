<?php
/*
Plugin Name: Oangle Custom Dashboard
Plugin URL: https://oangle.com/
Description: A little plugin to modify default dashboard contents
Version: 0.1
Author: Oangle
Author URI: https://oangle.com
Contributors: Yi Qi
*/

/**
 * Hide default welcome dashboard message and and create a custom one
 *
 * @access      public
 * @since       1.0
 * @return      void
*/



if (!function_exists('rc_my_welcome_panel')) {
	function rc_my_welcome_panel() { ?>
    <script type="text/javascript">
    	//  Hide default welcome message
    	jQuery(document).ready(function ($) {
    		$('div.welcome-panel-content').hide();
    	});
    </script>
    <style type="text/css">
    	.welcome-panel-left {
    		float: left;
    		width: 15%;
    		padding-right: 30px;
    	}
    	.welcome-panel-left img {
    		max-width: 100%;
    	}
    	.welcome-panel-right {
    		float: left;
    		margin-top: 15px;
    		width: 70%;
    	}
    	.welcome-panel .welcome-panel-close {
    		display: none;
    	}
    	a.oanglelinks {
    		color: #ffa16c;
    	}
    	a.oanglelinks:hover {
    		color: #e87b24;
    	}
    </style>
    <div class="custom-welcome-panel-content">
    	<div class="welcome-panel-left"><img src="<?php the_field('logo_login', 'option'); ?>"></div>
    	<div class="welcome-panel-right">
    		<h2><?php _e( 'Welcome to the Web Admin Dashboard!' ); ?></h2>
    		<p class="about-description">
    			<?php _e( 'From the Admin Panel (at the left sidebar), you can access everything you may need in order to update and maintain the content of your website.' ); ?>
    		</p>
    	</div>
    	<div class="welcome-panel-column-container">
    		<div class="welcome-panel-column">
    			<h4><?php _e( "Let's Get Started" ); ?></h4>
    			<?php printf( '<a href="%s" class="welcome-icon welcome-view-site">' . __( 'View your site' ) . '</a>', home_url( '/' ) ); ?>
    			<?php if( have_rows('list_started','option') ): ?>
    			<?php while( have_rows('list_started','option') ): the_row();
              $title = get_sub_field('title');
              $link = get_sub_field('link');
            ?>
			<p class="hide-if-no-customize">
				<?php printf( __( 'or, <a href="%s">'.$title.'</a>' ), admin_url( $link ) ); ?></p>
			<?php endwhile; ?>
			<?php endif; ?>
		</div>
		<div class="welcome-panel-column">
			<h4><?php _e( 'Next Steps' ); ?></h4>
			<ul>
				<?php if ( 'page' == get_option( 'show_on_front' ) && ! get_option( 'page_for_posts' ) ) : ?>
				<?php if( have_rows('next_steps','option') ): ?>
				<?php while( have_rows('next_steps','option') ): the_row();
	                  $icon = get_sub_field('icon');
	                  $title = get_sub_field('title');
	                  $link = get_sub_field('link');
	                  ?>
				<li><?php printf( '<a href="%s" class="welcome-icon '.$icon.'">' . __( $title ) . '</a>', admin_url( $link ) ); ?>
				</li>
				<?php endwhile; ?>
				<?php endif; ?>
				<?php elseif ( 'page' == get_option( 'show_on_front' ) ) : ?>
				<?php if( have_rows('next_steps','option') ): ?>
				<?php while( have_rows('next_steps','option') ): the_row();
	                  $icon = get_sub_field('icon');
	                  $title = get_sub_field('title');
	                  $link = get_sub_field('link');
	                  ?>
				<li><?php printf( '<a href="%s" class="welcome-icon '.$icon.'">' . __( $title ) . '</a>', admin_url( $link ) ); ?>
				</li>
				<?php endwhile;
				endif;

				 else :
         endif; ?>
			</ul>
		</div>
		<div class="welcome-panel-column welcome-panel-last">
			<h4><?php _e( 'More Actions' ); ?></h4>
			<ul>
				<?php if( have_rows('more_actions','option') ): ?>
				<?php while( have_rows('more_actions','option') ): the_row();
	                  $icon = get_sub_field('icon');
	                  $title = get_sub_field('title');
	                  $link = get_sub_field('link');
	                  ?>
				<li><?php printf( '<a href="%s" class="welcome-icon '.$icon.'">' . __( $title ) . '</a>', admin_url( $link ) ); ?>
				</li>
				<?php endwhile; ?>
				<?php endif; ?>
			</ul>
		</div>
		<p>This website was developed by <a class="oanglelinks" href="https://oangle.com" target="_blank">Oangle</a>.
			For technical support, please contact <a class="oanglelinks"
				href="mailto:support@oangle.com">support@oangle.com</a>.</p>
	</div>
</div><?php
	}
}
add_action( 'welcome_panel', 'rc_my_welcome_panel' );
//remove unwanted dashboard widgets for relevant users
if (!function_exists('example_remove_dashboard_widgets')) {
	function example_remove_dashboard_widgets() {
		// Globalize the metaboxes array, this holds all the widgets for wp-admin
	 	global $wp_meta_boxes;

		// Remove the incomming links widget
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);

		// Remove right now
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);

		// Remove WooCommerce Recent Reviews
		remove_meta_box( 'woocommerce_dashboard_recent_reviews', 'dashboard', 'normal');
	}
}
// Hoook into the 'wp_dashboard_setup' action to register our function
add_action('wp_dashboard_setup', 'example_remove_dashboard_widgets' );
//Remove the wordpress logo and its subsequent links
if (!function_exists('annointed_admin_bar_remove')) {
	function annointed_admin_bar_remove() {
	        global $wp_admin_bar;

	        /* Remove their stuff */
	        $wp_admin_bar->remove_menu('wp-logo');
	}
}
add_action('wp_before_admin_bar_render', 'annointed_admin_bar_remove', 0);
//end remove the wordpress logo and its subsequent links
//Change Wordpress footer
if (!function_exists('remove_footer_admin')) {
	function remove_footer_admin () {
	    echo "Developed by <a class='oanglelinks' href='https://oangle.com' alt='Visit Oangle's website' target='_blank'>Oangle</a>. Contact us at <a class='oanglelinks' href='mailto:support@oangle.com'>support@oangle.com</a> for technical support.";
	}
}
add_filter('admin_footer_text', 'remove_footer_admin');
add_action('login_footer', 'add_js');
if (!function_exists('add_js')) {
	function add_js(){
		$homepageLink = get_home_url();
		echo"<script type='text/javascript'>
		document.getElementById('user_login').placeholder = 'Username/Email';
		if (document.body.contains(document.getElementById('user_pass'))) {
			document.getElementById('user_pass').placeholder = 'Password';
		}
		document.getElementById('login').getElementsByTagName('a')[0].innerHTML = '';
	    document.querySelector('body.login div#login h1 a').setAttribute('href', '$homepageLink');
</script>";
	}
}
// add_action('login_footer', 'footer_right');
if (!function_exists('footer_right')) {
	function footer_right() {
		$logoRight = "https://oanglelab.com/login/oangle_logo.png";
		echo "<div class='designby'>
			<p>Developed by <a href='https://oangle.com'><img src='$logoRight' alt=''></a></p>
		</div>";
	}
}
// Remove Customise Submenu
if (!function_exists('remove_customize')) {
	function remove_customize() {
	    $customize_url_arr = array();
	    $customize_url_arr[] = 'customize.php'; // 3.x
	    $customize_url = add_query_arg( 'return', urlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ), 'customize.php' );
	    $customize_url_arr[] = $customize_url; // 4.0 & 4.1
	    if ( current_theme_supports( 'custom-header' ) && current_user_can( 'customize') ) {
	        $customize_url_arr[] = add_query_arg( 'autofocus[control]', 'header_image', $customize_url ); // 4.1
	        $customize_url_arr[] = 'custom-header'; // 4.0
	    }
	    if ( current_theme_supports( 'custom-background' ) && current_user_can( 'customize') ) {
	        $customize_url_arr[] = add_query_arg( 'autofocus[control]', 'background_image', $customize_url ); // 4.1
	        $customize_url_arr[] = 'custom-background'; // 4.0
	    }
	    foreach ( $customize_url_arr as $customize_url ) {
	        remove_submenu_page( 'themes.php', $customize_url );
	    }
	}
}
//add_action( 'admin_menu', 'remove_customize', 999 );
// REMOVE ADMIN MENUS
if (!function_exists('remove_menus')) {
	function remove_menus(){
	  remove_menu_page( 'tools.php' );                  //Tools
	}
}
add_action( 'admin_menu', 'remove_menus' );
// Custom login style
function my_custom_login() {
	echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/func-custom/admin-login/custom-login-styles.css" />';
}
 add_action('login_head', 'my_custom_login');
// Replace Login Logo
if (!function_exists('my_login_logo')) {
	function my_login_logo() {
		$logoLogin = get_field('logo_login','option');
		$color = get_field("login_button_color","option");

	 echo "
<style type='text/css'>
	body.login div#login h1 {
		background-image: url($logoLogin);
		background-position: top center;
		background-repeat: no-repeat;
		height: 160px !important;
		background-size: contain;
	}
	body.login div#login h1 a {
		background-image: none;
		width: 100%;
		height: 100%;
	}
	.login #login .button-primary {
		background: $color  !important;
		border-color: $color  !important;
		box-shadow: 0 0 0 transparent !important;
	}
	#login #lostpasswordform .button-primary{
		margin-top: 24px;
	}
</style>";
	}
}
add_action( 'login_enqueue_scripts', 'my_login_logo' );

function theme_icons() {
	echo '<link rel="icon" sizes="192x192" href="'.get_field('app_icon','option').'">';
	echo '<link rel="apple-touch-icon-precomposed" sizes="152x152" href="'.get_field('app_icon','option').'">';
	echo '<link rel="icon" href="'.get_field('favicon','option').'">';
}
add_action('wp_head', 'theme_icons');