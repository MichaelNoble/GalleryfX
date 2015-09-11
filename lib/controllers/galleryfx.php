<?php
namespace GFXI\GalleryfX;
use GFXI\GalleryfX\Display;

// localize
add_action( 'plugins_loaded', __NAMESPACE__ . '\load_textdomain' );

// add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\load_user_scripts_styles' );

// register custom post types and taxonomies
add_action('init', __NAMESPACE__ . '\register_cpt_tax', 1);

if ( ! is_admin() ) {

    add_shortcode( 'galleryfx', __NAMESPACE__ . '\process_shortcode' );
    add_action('wp_footer', __NAMESPACE__ . '\print_gallery_scripts', 10000);

}
  
/**
 * Load the translation file for current language. Checks in wp-content/languages first
 * and then the galleryfX-gallery/languages.
 *
 * Edits to translation files inside galleryfX-gallery/languages will be lost with an update
 * **If you're creating custom translation files, please use the global language folder.**
 */
function load_textdomain()
{
    $locale = apply_filters('plugin_locale', get_locale(), GFXI_TEXTDOMAIN);

    $mofile = GFXI_TEXTDOMAIN . '-' . $locale . '.mo';

    /* Check the global language folder */
    $files = array(WP_LANG_DIR . '/galleryfX-integration/' . $mofile, WP_LANG_DIR . '/' . $mofile);
    foreach ($files as $file)
    {
        if (file_exists($file))
        {
            return load_textdomain(GFXI_TEXTDOMAIN, $file);
        }
    }

    // If we got this far, fallback to the plug-in language folder.
    // We could use load_textdomain - but this avoids touching any more constants.
    load_plugin_textdomain( GFXI_TEXTDOMAIN, false, GFXI_PLUGIN_DIR . 'languages' );
}

function process_shortcode( $attr, $content = null ) {

    /* We're not worried about galleries/sliders in feeds */
    if ( is_feed() )
        return; 

    $out = '';
    if (isset($attr['fxsetting'])) {
                  
        $display = new Display\Display();        
        $display->load_gallery( $attr );
        $out = $display->get_display();    
            
    }                               

    return $out;

}   

 /**
 * Prints all the scripts that have been enqueued by shortcodes
 */
function print_gallery_scripts() {

    if (empty(Display\Display::$scripts))
    {
        return;
    }

    echo '<script type="text/javascript">' . "\n";
    echo '    jQuery(document).ready( function($) {' . "\n    ";
    echo implode("\n        ", Display\Display::$scripts) . "\n";
    echo '    });' . "\n";
    echo '</script>' . "\n";
} 

/**  Loads custom post type and taxonomy **/

// Register Custom Post Type
function register_cpt_tax() {

         $labels = array(
        'name'                => _x( 'Gallery fX Settings', GFXI_TEXTDOMAIN ),
        'singular_name'       => _x( 'Gallery fX Setting', GFXI_TEXTDOMAIN ),
        'menu_name'           => __( 'Gallery fX', GFXI_TEXTDOMAIN ),
        'name_admin_bar'      => __( 'Gallery fX', GFXI_TEXTDOMAIN ),
        'parent_item_colon'   => __( 'Parent Item:', GFXI_TEXTDOMAIN ),
        'all_items'           => __( 'fX Settings', GFXI_TEXTDOMAIN ),
        'add_new_item'        => __( 'Add New ', GFXI_TEXTDOMAIN ),
        'add_new'             => __( 'Add New fX setting', GFXI_TEXTDOMAIN ),
        'new_item'            => __( 'New Item', GFXI_TEXTDOMAIN ),
        'edit_item'           => __( 'Edit Item', GFXI_TEXTDOMAIN ),
        'update_item'         => __( 'Update Item', GFXI_TEXTDOMAIN ),
        'view_item'           => __( 'View Item', GFXI_TEXTDOMAIN ),
        'search_items'        => __( 'Search Item', GFXI_TEXTDOMAIN ),
        'not_found'           => __( 'Not found', GFXI_TEXTDOMAIN ),
        'not_found_in_trash'  => __( 'Not found in Trash', GFXI_TEXTDOMAIN ),
    );
    $args = array(
        'label'               => __( 'Gallery fX Setting', GFXI_TEXTDOMAIN ),
        'description'         => __( 'Gallery Effect Settings ', GFXI_TEXTDOMAIN ),
        'labels'              => $labels,
        'supports'            => array( 'title', ),
        'hierarchical'        => false,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 11,
        'menu_icon'           => 'dashicons-admin-generic',
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => false,      
        'exclude_from_search' => true,
        'publicly_queryable'  => false,
        'rewrite'             => false,
        'capability_type'     => 'page',
    );
    register_post_type( 'gfxi_fxsetting', $args );

/*
    ***  Enable fX Gallerys if WP Better Attachments is installed and active.
*/
    if ( function_exists('wpba_attachment_list') ) {  
        $labels = array(
            'name'                => _x( 'fX Galleries', GFXI_TEXTDOMAIN ),
            'singular_name'       => _x( 'fX Gallery', GFXI_TEXTDOMAIN ),
            'menu_name'           => __( 'fX Galleries', GFXI_TEXTDOMAIN ),
            'name_admin_bar'      => __( 'fX Galleries', GFXI_TEXTDOMAIN ),
            'parent_item_colon'   => __( 'Parent Item:', GFXI_TEXTDOMAIN ),
            'all_items'           => __( 'fX Galleries', GFXI_TEXTDOMAIN ),
            'add_new_item'        => __( 'Add New ', GFXI_TEXTDOMAIN ),
            'add_new'             => __( 'Add New', GFXI_TEXTDOMAIN ),
            'new_item'            => __( 'New Item', GFXI_TEXTDOMAIN ),
            'edit_item'           => __( 'Edit Item', GFXI_TEXTDOMAIN ),
            'update_item'         => __( 'Update Item', GFXI_TEXTDOMAIN ),
            'view_item'           => __( 'View Item', GFXI_TEXTDOMAIN ),
            'search_items'        => __( 'Search Item', GFXI_TEXTDOMAIN ),
            'not_found'           => __( 'Not found', GFXI_TEXTDOMAIN ),
            'not_found_in_trash'  => __( 'Not found in Trash', GFXI_TEXTDOMAIN ),
        );
        $args = array(
            'label'               => __( GFXI_TEXTDOMAIN, GFXI_TEXTDOMAIN ),
            'description'         => __( 'Gallery Effect Configurations ', GFXI_TEXTDOMAIN ),
            'labels'              => $labels,
            'supports'            => array( 'title', ),
            'hierarchical'        => false,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => 'edit.php?post_type=gfxi_fxsetting',
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-admin-plugins',
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => false,      
            'exclude_from_search' => true,
            'publicly_queryable'  => false,
            'rewrite'             => false,
            'capability_type'     => 'page',
        );
        register_post_type( 'gfxi_fxgallery', $args );
    }


    $labels = array(
        'name'                => _x( 'GalleryfX Plug-ins', 'Post Type General Name', GFXI_TEXTDOMAIN ),
        'singular_name'       => _x( 'GalleryfX Plug-in', 'Post Type Singular Name', GFXI_TEXTDOMAIN ),
        'menu_name'           => __( 'Gallery fX Plug-in', GFXI_TEXTDOMAIN ),
        'name_admin_bar'      => __( 'Gallery fX Plug-in', GFXI_TEXTDOMAIN ),
        'parent_item_colon'   => __( 'Parent Item:', GFXI_TEXTDOMAIN ),
        'all_items'           => __( 'All Items', GFXI_TEXTDOMAIN ),
        'add_new_item'        => __( 'Add New Item', GFXI_TEXTDOMAIN ),
        'add_new'             => __( 'Add New', GFXI_TEXTDOMAIN ),
        'new_item'            => __( 'New Item', GFXI_TEXTDOMAIN ),
        'edit_item'           => __( 'Edit Item', GFXI_TEXTDOMAIN ),
        'update_item'         => __( 'Update Item', GFXI_TEXTDOMAIN ),
        'view_item'           => __( 'View Item', GFXI_TEXTDOMAIN ),
        'search_items'        => __( 'Search Item', GFXI_TEXTDOMAIN ),
        'not_found'           => __( 'Not found', GFXI_TEXTDOMAIN ),
        'not_found_in_trash'  => __( 'Not found in Trash', GFXI_TEXTDOMAIN ),
    );
    $args = array(
        'label'               => __( 'gfxplugins', GFXI_TEXTDOMAIN ),
        'description'         => __( 'Gallery fX Plug-in Parameters ', GFXI_TEXTDOMAIN ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'custom-fields', 'page-attributes', ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-admin-plugins',
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => true,      
        'exclude_from_search' => true,
        'publicly_queryable'  => false,
        'rewrite'             => false,
        'capability_type'     => 'page',
    );
   // register_post_type( 'gfxplugins', $args );


}

if (!function_exists('write_log')) {
        function write_log ( $log )  {
            if ( true === WP_DEBUG ) {
                if ( is_array( $log ) || is_object( $log ) ) {
                    error_log( print_r( $log, true ) );
                } else {
                    error_log( $log );
                }
            }
        }
   }


