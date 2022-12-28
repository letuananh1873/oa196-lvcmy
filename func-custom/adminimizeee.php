<?php
// $user_id = get_current_user_id();
// $user_meta = get_userdata($user_id);
// $user_role = $user_meta->roles[0];
/**
 * administrator
 * author
 * contributor
 * customer
 * editor
 * shop_manager
 * subscriber
 * vip
 */

// Admin Bar Back End Options
function remove_admin_bar_option($include, $role) {
    global $wp_admin_bar;
    $nodes = $wp_admin_bar->get_nodes();
    foreach($nodes as $item) {
        if(in_array($item->id, $include)) {
            $wp_admin_bar->remove_menu($item->id);
        }  
    }
}

function admin_bar_backend_option() {

    global $wp_admin_bar;

    $user_id = get_current_user_id();
    $user_meta = get_userdata($user_id);
    $user_role = $user_meta->roles[0];

    $nodes = $wp_admin_bar->get_nodes();
    $includes = array(
        'administrator' => ['menu-toggle','about', 'wporg', 'documentation', 'support-forums', 'feedback', 'comments', 'new-content','elementor-license' ],
        'editor' => ['menu-toggle','about', 'wporg', 'documentation', 'support-forums', 'feedback', 'updates', 'comments', 'new-content','ecwoo_csc'],
        'author' => [  'about', 'documentation', 'support-forum', 'feedback', 'site-name', 'view-site', 'view-store',
                    'updates','comments','new-content', 'new-post', 'new-media','new-page','new-elementor_library','new-product','new-shop_order','new-shop_coupon','new-ecwoo_csc','new-user','wp-logo-external'],
        'contributor' => ['mw-account', 'user-info', 'edit-profile', 'menu-toggle', 'about', 'wporg', 'documentation', 'support-forum', 'feedback', 'site-name', 'view-site', 'view-store',
                         'updates','comments','new-content', 'new-post', 'new-media','new-page','new-elementor_library','new-product','new-shop_order','new-shop_coupon','new-ecwoo_csc','new-user','wp-logo-external'],
        'subscriber' => ['mw-account', 'user-info', 'edit-profile', 'menu-toggle', 'about', 'wporg', 'documentation', 'support-forum', 'feedback', 'site-name', 'view-site', 'view-store',
                        'updates','comments','new-content', 'new-post', 'new-media','new-page','new-elementor_library','new-product','new-shop_order','new-shop_coupon','new-ecwoo_csc','new-user','wp-logo-external'],
        'customer' => ['mw-account', 'user-info', 'edit-profile', 'menu-toggle', 'about', 'wporg', 'documentation', 'support-forum', 'feedback', 'site-name', 'view-site', 'view-store',
                      'updates','comments','new-content', 'new-post', 'new-media','new-page','new-elementor_library','new-product','new-shop_order','new-shop_coupon','new-ecwoo_csc','new-user','wp-logo-external'],
        'shop_manager' => ['wp-logo','updates','edit-profile'],
        'vip' => [],
        'seoeditor' => []
    );
    if(isset($user_role) && !empty($user_role)) {
        remove_admin_bar_option($includes[$user_role],$user_role);  
    }
}

add_action('wp_before_admin_bar_render', 'admin_bar_backend_option');

// Admin Bar Front End 

function admin_bar_front_end_option(WP_Admin_Bar $admin_bar) {
    
    $user_id = get_current_user_id();
    $user_meta = get_userdata($user_id);
    $user_role = $user_meta->roles[0];

    $includes = array(
        'administrator' => ['about', 'wporg', 'documentation', 'support-forums', 'feedback', 'themes', 'widgets','updates','comments','new-content','elementor_edit_page','elementor-license','user-info','edit-profile' ],
        'editor' => ['about', 'wporg', 'documentation', 'support-forums', 'feedback', 'themes', 'widgets','updates','comments','new-content','elementor_edit_page' ],
        'author' => ['mw-account', 'user-info', 'edit-profile', 'search', 'about', 'wporg', 'documentation', 'support-forum', 'feedback', 'site-name',
                    'dashboard','appearance','themes','widgets','menus','customize','updates','comments','new-content','new-post','new-media','new-page','new-elementor_library','new-product','new-shop_order',
                    'new-shop_coupon','new-ecwoo_csc','new-user','wp-logo-external','elementor_edit_page','elementor_edit_doc_58','ecwoo_csc','comments'],
        'contributor' => ['mw-account', 'user-info', 'edit-profile', 'search', 'about', 'wporg', 'documentation', 'support-forum', 'feedback', 'site-name',
                        'dashboard','appearance','themes','widgets','menus','customize','updates','comments','new-content','new-post','new-media','new-page','new-elementor_library','new-product','new-shop_order',
                        'new-shop_coupon','new-ecwoo_csc','new-user','wp-logo-external','elementor_edit_page','elementor_edit_doc_58','ecwoo_csc'],
        'subscriber' => ['mw-account', 'user-info', 'edit-profile', 'search', 'about', 'wporg', 'documentation', 'support-forum', 'feedback', 'site-name',
                        'dashboard','appearance','themes','widgets','menus','customize','updates','comments','new-content','new-post','new-media','new-page','new-elementor_library','new-product','new-shop_order',
                        'new-shop_coupon','new-ecwoo_csc','new-user','wp-logo-external','elementor_edit_page','elementor_edit_doc_58','ecwoo_csc'],
        'customer' => ['mw-account', 'user-info', 'edit-profile', 'search', 'about', 'wporg', 'documentation', 'support-forum', 'feedback', 'site-name',
                    'dashboard','appearance','themes','widgets','menus','customize','updates','comments','new-content','new-post','new-media','new-page','new-elementor_library','new-product','new-shop_order',
                    'new-shop_coupon','new-ecwoo_csc','new-user','wp-logo-external','elementor_edit_page','elementor_edit_doc_58'],
        'shop_manager' => ['wp-logo', 'themes','widgets','customize','updates','elementor_edit_page','ecwoo_csc'],
        'vip' => []
    );

    if(isset($user_role) && !empty($user_role)) {
        remove_admin_bar_option($includes[$user_role],$user_role);  
    }
}

add_action('admin_bar_menu', 'admin_bar_front_end_option');

// Global Option

function admin_global_option_style($ids) {
    if(!empty($ids)) {
        echo '<style>'.
        $ids.' {
            display: none !important;
        }</style>';
    }

}

add_action('admin_head', 'admin_global_option');

function admin_global_option() {

    $user_id = get_current_user_id();
    $user_meta = get_userdata($user_id);
    $user_role = $user_meta->roles[0];

    $includes = array(
        'administrator' => '#favorite-actions, #contextual-help-link-wrap, #your-profile .form-table fieldset' ,
        'editor' => '#favorite-actions, #contextual-help-link-wrap, #your-profile .form-table fieldset, #menu-posts-ecwoo_csc, #menu-comments',
        'author' => '#favorite-actions, #contextual-help-link-wrap, #your-profile .form-table fieldset, #menu-posts-ecwoo_csc, #menu-comments, #menu-tools',
        'contributor' => '#favorite-actions, #contextual-help-link-wrap, #your-profile .form-table fieldset, #menu-tools, #menu-posts-ecwoo_csc, #menu-comments',
        'subscriber' => '#favorite-actions, #contextual-help-link-wrap, #your-profile .form-table fieldset, #menu-tools, #menu-posts-ecwoo_csc',
        'customer' => '#favorite-actions, #contextual-help-link-wrap, #your-profile .form-table fieldset, #menu-tools, #menu-posts-ecwoo_csc' ,
        'shop_manager' => '#menu-appearance .wp-first-item,#menu-appearance  .hide-if-no-customize, #menu-posts-ecwoo_csc, #menu-comments, #menu-tools, #menu-posts-yith-wcbm-badge',
        'vip' => '',
        'seoeditor' => ''
    );
    admin_global_option_style($includes[$user_role]);

}

// Dashboard Options
add_action('wp_dashboard_setup', 'remove_dashboard_widgetss');
function remove_dashboard_widgets_by_role($includes) {
    if(count($includes) > 0) {
        foreach($includes as $include) {
            remove_meta_box($include, 'dashboard', 'side');
        }
    }
}

function remove_dashboard_widgetss() {

    $user_id = get_current_user_id();
    $user_meta = get_userdata($user_id);
    $user_role = $user_meta->roles[0];
    
    $includes = array(
        'administrator' => ['e-dashboard-overview'] ,
        'editor' => ['e-dashboard-overview','woocommerce_dashboard_recent_reviews','searchwp_statistics','woocommerce_dashboard_status','wpgenie_dashboard_products_news'],
        'author' => ['e-dashboard-overview','woocommerce_dashboard_recent_reviews','woocommerce_dashboard_status'],
        'contributor' => ['e-dashboard-overview','woocommerce_dashboard_recent_reviews','woocommerce_dashboard_status'],
        'subscriber' => ['e-dashboard-overview','woocommerce_dashboard_recent_reviews','woocommerce_dashboard_status'],
        'customer' => ['e-dashboard-overview','woocommerce_dashboard_recent_reviews','woocommerce_dashboard_status'] ,
        'shop_manager' => ['e-dashboard-overview','woocommerce_dashboard_recent_reviews','woocommerce_dashboard_status'],
        'vip' => '',
        'seoeditor' => ''
    );

    remove_dashboard_widgets_by_role($includes[$user_role]);
}

// Admin Dashboard MEnu Items

add_action('admin_init', 'admin_dashboard_menu_items');

function admin_dashboard_menu_items_by_role($includes) {

    if(isset($includes) && is_array($includes) && count($includes) > 0) {
        global $submenu;  
        if (is_array($submenu) && count($submenu) > 0)     :
        foreach($includes as $item) {
            foreach($submenu as $key_1 => $submenu_item) {
                if($key_1 == $item) {
                    remove_menu_page($item);
                    unset($submenu[$key_1]);
                } else {
                    foreach($submenu_item as $key_2 => $a) {

                        if($item == $a[2]) {
                            unset($submenu[$key_1][$key_2]);
                        }
                    }
                }

            }

        }
    endif;
    }

}

function admin_dashboard_menu_items() {

    $user_id = get_current_user_id();
    $user_meta = get_userdata($user_id);
    $user_role = $user_meta->roles[0]; 

    $includes = array(
        'administrator' => ['edit.php','elementor-license','yith_system_info'],
        'editor' => ['edit.php','ecwoo_csc','themes.php','customize.php','widgets.php','astra','theme-editor.php','email-log','woocommerce','wp-hide','customtaxorder'],
        'author' => ['index.php','edit.php','ecwoo_csc','upload.php','product','elementor_library','themes.php','plugins.php','users.php',
                    'options-general.php','acf-field-group','separator1','email-log','separator-woocommerce','woocommerce','separator-elementor','elementor','separator','separator-last','wp-hide','customtaxorder',
                    'edit-comments','edit-comments.php','edit.php?post_type=elementor_library','tools.php','woocommerce','jet-dashboard','options-general.php','theme-settings','customtaxorder'],
        'contributor' => ['index.php','edit.php','ecwoo_csc','upload.php','product','elementor_library','themes.php','plugins.php','users.php',
                        'options-general.php','acf-field-group','separator1','email-log','separator-woocommerce','woocommerce','separator-elementor','elementor','separator','separator-last','wp-hide',
                    'edit-comments','edit-comments.php','edit.php?post_type=elementor_library','tools.php','woocommerce','jet-dashboard','options-general.php','theme-settings','customtaxorder'],
        'subscriber' => ['index.php','edit.php','ecwoo_csc','upload.php','product','elementor_library','themes.php','plugins.php','users.php',
                        'options-general.php','acf-field-group','separator1','email-log','separator-woocommerce','woocommerce','separator-elementor','elementor','separator','separator-last','wp-hide',
                    'edit-comments','edit-comments.php','edit.php?post_type=elementor_library','tools.php','woocommerce','jet-dashboard','options-general.php','theme-settings','customtaxorder'],
        'customer' => ['index.php','edit.php','ecwoo_csc','upload.php','product','elementor_library','themes.php','plugins.php','users.php',
                        'options-general.php','acf-field-group','separator1','email-log','separator-woocommerce','woocommerce','separator-elementor','elementor','separator','separator-last','wp-hide',
                    'edit-comments','edit-comments.php','edit.php?post_type=elementor_library','tools.php','woocommerce','jet-dashboard','options-general.php','theme-settings','customtaxorder'],
        'shop_manager' => ['index.php','wp-hide','customize.php','widgets.php','wpo_wcpdf_options_page','email-log','customtaxorder','wc-addons','wc-status','elementor','astra','jet-dashboard','options-general.php','edit.php?post_type=acf-field-group',
                        'yith_wcbm_panel','yith_woocompare_panel','yith_wcwl_panel','yith_system_info','yith_plugins_activation','email-customizer-for-woocommerce-with-drag-drop-builder','coupons-moved',
                        'imagify-bulk-optimization','imagify-files','order-post-types-attachment','order-post-types-elementor_library'],
        'vip' => [],
        'seoeditor' => []
    );


    admin_dashboard_menu_items_by_role($includes[$user_role]);
    $role = get_role( 'shop_manager' );
    $role->add_cap( 'manage_options' ); 
}

// Change CP Menu Label
add_action('admin_init','cp_menu_label');

function cp_menu_label() {
    global $menu;
    if (is_array($menu)):

    foreach($menu as $key => $item) {
        if($item[0] == 'Elementor DB') {
            $menu[$key][6] = "dashicons-email";
            $menu[$key][0] = 'Forms and Enquiries';
        }
    }
endif;

    // rename_admin_menu_section('Elementor DB','Forms and Enquiries');
}

// Pots Type: Post Remove By Role

class customAdminimize {
    public $_role = '';

    public function __construct($_role) {
        
        $this->_role = $_role;
        
        add_action('admin_head',array($this, 'remove_post_dashboard'));
        add_filter( 'gettext', array($this, 'change_woocommerce_label') );

    }

    public function remove_post_dashboard() {

        $post_type = $_GET['post_type'] ?? '' ?: 'post';

        $post_acsc = '#contextual-help-link-wrap, #screen-options-link-wrap, .page-title-action,#title, #titlediv, th.column-title, td.title, #pageslugdiv,#tags, #tagsdiv,#tagsdivsb,#tagsdiv-post_tag, th.column-tags, td.tags,
        #categories, #categorydiv, #categorydivsb, th.column-categories, td.categories,#category-add-toggle,#date, #datediv, th.column-date, td.date, div.curtime,#passworddiv,.side-info,#notice,
        #post-body h2,#media-buttons, #wp-content-media-buttons,#wp-word-count,#slugdiv,#edit-slug-box,#misc-publishing-actions,#commentstatusdiv,#editor-toolbar #edButtonHTML, #quicktags, #content-html, .wp-switch-editor.switch-html,
        #title, #titlediv, th.column-title, td.title,#postdivrich, #postdivrichdiv, th.column-postdivrich, td.postdivrich,#author, #authordiv, th.column-author, td.author,#thumbnail, #thumbnaildiv, th.column-thumbnail, td.thumbnail,
        #postexcerpt, #postexcerptdiv, th.column-postexcerpt, td.postexcerpt,#postcustom, #postcustomdiv, th.column-postcustom, td.postcustom,#revisions, #revisionsdiv, th.column-revisions, td.revisions,
        #format, #formatdiv, th.column-format, td.format,#postimagediv,div.row-actions, div.row-actions .inline,fieldset.inline-edit-col-left, fieldset.inline-edit-col-left label,fieldset.inline-edit-col-left label.inline-edit-author,
        fieldset.inline-edit-col-left .inline-edit-group,fieldset.inline-edit-col-center,fieldset.inline-edit-col-center .inline-edit-categories-label,fieldset.inline-edit-col-center .category-checklist,fieldset.inline-edit-col-right,
        fieldset.inline-edit-col-right .inline-edit-tags,fieldset.inline-edit-col-right .inline-edit-group,tr.inline-edit-post p.inline-edit-save';

        $page_acsc = '#contextual-help-link-wrap, #screen-options-link-wrap,.page-title-action,#title, #titlediv, th.column-title, td.title,#pageslugdiv,#pagepostcustom, #pagecustomdiv, #postcustom,#pagecommentstatusdiv, #commentsdiv, #comments, th.column-comments, td.comments,
        #date, #datediv, th.column-date, td.date, div.curtime,#pagepassworddiv,#pageparentdiv,#pagetemplatediv,#pageorderdiv,#pageauthordiv, #author, #authordiv, th.column-author, td.author,#revisionsdiv,.side-info,
        #notice,#post-body h2,#media-buttons, #wp-content-media-buttons,#wp-word-count,#slugdiv,#edit-slug-box,#misc-publishing-actions,#commentstatusdiv,#editor-toolbar #edButtonHTML, #quicktags, #content-html,
        #postimagediv,div.row-actions, div.row-actions .inline,fieldset.inline-edit-col-left,fieldset.inline-edit-col-left label,fieldset.inline-edit-col-left div.inline-edit-date,fieldset.inline-edit-col-left label.inline-edit-author,
        fieldset.inline-edit-col-left .inline-edit-group,fieldset.inline-edit-col-right,fieldset.inline-edit-col-right .inline-edit-col,fieldset.inline-edit-col-right .inline-edit-group,tr.inline-edit-page p.inline-edit-save';

        $post_includes = array(
            'administrator' => 'fieldset.inline-edit-col-left .inline-edit-group' ,
            'editor' => 'fieldset.inline-edit-col-left .inline-edit-group',
            'author' => $post_acsc,
            'contributor' => $post_acsc,
            'subscriber' => $post_acsc,
            'customer' => $post_acsc ,
            'shop_manager' => '',
            'vip' => '',
            'seoeditor' => '' 
        );
        
        $page_includes = array(
            'administrator' => '' ,
            'editor' => '',
            'author' => $page_acsc,
            'contributor' => $page_acsc,
            'subscriber' => $page_acsc,
            'customer' => $page_acsc ,
            'shop_manager' => '',
            'vip' => '',
            'seoeditor' => ''
        );

        if($post_type == 'post' && !empty($this->_role) && isset($post_includes[$this->_role])) {
                admin_global_option_style($post_includes[$this->_role]);    
        }

        if($post_type == 'page' && !empty($this->_role) && isset($page_includes[$this->_role])) {
            admin_global_option_style($page_includes[$this->_role]);
        }
    }

    public function change_woocommerce_label($label) {
        $label = str_replace( 'WooCommerce', 'Shop', $label );
        return $label;
    }
}

if(is_user_logged_in()) {
    $user_id = get_current_user_id();
    $user_meta = get_userdata($user_id);
    $user_role = $user_meta->roles[0];
    
    new customAdminimize($user_role);
}

