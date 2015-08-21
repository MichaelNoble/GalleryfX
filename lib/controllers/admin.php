<?php
namespace GFXI\GalleryfX\Admin;
use \VP_ShortcodeGenerator;
use \VP_Metabox;
use \VP_Option;
use \is_plugin_active;


//  add_action( 'admin_enqueue_scripts', array( __CLASS__,  'load_admin_scripts_styles') );

if ( is_admin() ) {

   // add_action('vp_option_save_and_reinit', __NAMESPACE__ . '\option_actions'  , 2, 20);
    add_action('vp_option_after_ajax_save', __NAMESPACE__ . '\option_actions'  , 2, 20);

    init_shortcodeGen(); 

} 

// check settings for reccomended plugins 
add_action('theme_setup', __NAMESPACE__ . '\option_actions');
  
  //initialize ValPress framework dependent metaboxes and shortcode generator 
init_fxsetting_meta_boxes();
init_attachment_meta_boxes();
     
function gfxiOption($name){
     static $gfxi_options = null;

     if (! is_object($gfxi_options) )
          $gfxi_options = new VP_Option(array(
                'is_dev_mode'           => false,                                  // dev mode, default to false
                'option_key'            => 'gfxi_option',                           // options key in db, required
                'page_slug'             => 'gfxi_option',                           // options page slug, required
                'template'              => GFXI_PLUGIN_DIR . 'lib/views/gfxi-options.php',                              // template file path or array, required
                'menu_page'             => 'edit.php?post_type=gfxi_fxsetting',                           // parent menu slug or supply `array` (can contains 'icon_url' & 'position') for top level menu
                'use_auto_group_naming' => true,                                   // default to true
                'use_util_menu'         => true,                                   // default to true, shows utility menu
                'minimum_role'          => 'edit_theme_options',                   // default to 'edit_theme_options'
                'layout'                => 'fixed',                                // fluid or fixed, default to fixed
                'page_title'            => __( 'Gallery fX Options', GFXI_TEXTDOMAIN ), // page title
                'menu_label'            => __( 'Setup Options', GFXI_TEXTDOMAIN ), // menu label
            ));

     if ( isset($gfxi_options->get_options()[$name]) )
        return $gfxi_options->get_options()[$name];
     else 
        return null;

}

function init_attachment_meta_boxes() {

    $mb_attach = array(
        'id'          => '_gfxi-att-jssor_',
        'types'       => array('attachment'),
        'title'       => __('Slide Effects', GFXI_TEXTDOMAIN),
        'priority'    => 'high',
        'context'      => 'side',
        'template'    =>  GFXI_PLUGIN_DIR . 'lib/attachment.template.php'
    );

    $mb = new VP_Metabox($mb_attach);

}           

function init_fxsetting_meta_boxes() {

   // if ( 'add' !== get_current_screen()->action )
   //     return;

    $mb_fxsetting = array(
        'id'          => '_gfxi-jssor_',
        'types'       => array('gfxi_fxsetting'),
        'title'       => __('Jssor Slider Settings', GFXI_TEXTDOMAIN),
        'priority'    => 'high',
        'template'    =>  GFXI_PLUGIN_DIR . 'lib/fxsetting.template.php'
    );

    $mb = new VP_Metabox($mb_fxsetting);

}  


 /* setup shortcode genaerator for post editor  */
function init_shortcodeGen() {
   
    $tmpl_sg1 = array(
        'name'           => 'gfXi_sc1',                                        // unique name, required
        'modal_title'    => __( 'Gallery fX Shortcode', GFXI_TEXTDOMAIN), // modal title, default to empty string
        'button_title'   => __( 'Gallery fX', GFXI_TEXTDOMAIN),              // button title, default to empty string
        'types'          => array( 'post', 'page' ),                       // at what post types the generator should works, default to post and page
       // 'included_pages' => array( 'appearance_page_vpt_option' ),         // or to what other admin pages it should appears
        'main_image'     => GFXI_PLUGIN_URL . 'assets/img/galleryfX-icon.png',
        'sprite_image'   => GFXI_PLUGIN_URL . 'assets/img/galleryfX-icon-sprite.png',
        'template'       =>  array(
            'Shortcode' => array(
                'elements'=> array(
                    'fX_galleries' => array(
                        'title'   => 'fX Galleries',
                        'code'    => '[galleryfx]',
                        'attributes' => array(  
                            array(
                                'name'  => 'fxsetting',
                                'type'  => 'select',
                                'label' => __('fX Setting', GFXI_TEXTDOMAIN),
                                'items' => array(
                                    'data' => array(
                                        array(
                                            'source' => 'function',
                                            'value' => __NAMESPACE__ . '\get_cptSlugs',
                                            'params' => 'gfxi_fxsetting',
                                        ),
                                    ),
                                ),
                                'validation'    => 'required',
                                'default'   => array('{{first}}'),
                            ),
                            array(
                                'type' => 'notebox',
                                'name' => 'nb_createsc',
                                'label' => __('Create shortcode', GFXI_TEXTDOMAIN),
                                'description' => __('Please select an effects setting and one of the media attachment source options below.  If no media attachment source is select the post attachments will be used', GFXI_TEXTDOMAIN),
                                'status' => 'info',
                            ),                  
                        )
                    ),
                ),
            )
        ),                                     
    );
   // $temp = $gfxi_options->get_options();
   if ( gfxiOption('wp_better_att_enabled') == '1' ) {

        $tmpl_sg1['template']['Shortcode']['elements']['fX_galleries']['attributes'][] = 
                array(
                    'name'  => 'fxgallery',
                    'type'  => 'select',
                    'label' => __('fX Gallery', GFXI_TEXTDOMAIN),
                    'items' => array(
                        'data' => array(
                            array(
                                'source' => 'function',
                                'value' => __NAMESPACE__ . '\get_cptSlugs',
                                'params' => 'gfxi_fxgallery',
                            ),
                        ),
                    ),
                );
    }else {
        $tmpl_sg1['template']['Shortcode']['elements']['fX_galleries']['attributes'][] = 
                array(
                        'type' => 'notebox',
                        'name' => 'nb_wpba',
                        'label' => __('WP Better Attachments', GFXI_TEXTDOMAIN),
                        'description' => __('The recommended plugin WP Better Attachments provides a simple way to manage media library attachments, it is required to use the fX galleries feature', GFXI_TEXTDOMAIN),
                        'status' => 'normal',
                    );     
    } 
    if ( gfxiOption('media_lib_asst_enabled') == '1' ) {

        $tmpl_sg1['template']['Shortcode']['elements']['fX_galleries']['attributes'][] = 
                array(
                    'name'  => 'attach_cat',
                    'type'  => 'select',
                    'label' => __('Attachment Category', GFXI_TEXTDOMAIN),
                    'items' => array(
                        'data' => array(
                            array(
                                'source' => 'function',
                                'value' => __NAMESPACE__ . '\get_term_opts',
                                'params' => 'attachment_category',
                            ),
                        ),
                    ),
                );

        $tmpl_sg1['template']['Shortcode']['elements']['fX_galleries']['attributes'][] = 
                array(
                    'name'  => 'attach_tag',
                    'type'  => 'select',
                    'label' => __('Attachment Tag', GFXI_TEXTDOMAIN),
                    'items' => array(
                        'data' => array(
                            array(
                                'source' => 'function',
                                'value' => __NAMESPACE__ . '\get_term_opts',
                                'params' => 'attachment_tag',
                            ),
                        ),
                    ),
                );
    }else {
        $tmpl_sg1['template']['Shortcode']['elements']['fX_galleries']['attributes'][] = 
                array(
                        'type' => 'notebox',
                        'name' => 'nb_mla',
                        'label' => __('Media Library Assistant', GFXI_TEXTDOMAIN),
                        'description' => __('The recommended plugin Media Library Assistant provides categories and tags along with a view to organize your library', GFXI_TEXTDOMAIN),
                        'status' => 'normal',
                    );    
    }

    $sg1 = new VP_ShortcodeGenerator($tmpl_sg1);

}

function option_actions($opts = null, $results = null) {
    global $wpdb;

   
    if ( null !== gfxiOption('setbetrattchopts') && intval(gfxiOption('setbetrattchopts')) == 1 ) {
        // write_log($opts);
        
        $wpba_options = $wpdb->get_col( "SELECT option_value FROM $wpdb->options WHERE option_name = 'wpba_settings'" ); 
//write_log(' opts: ');
//write_log(unserialize($wpba_options[0]));
        $override_opts = array(
                'wpba-disable-post-types' => array ( 'gfxi_fxsetting' => 'gfxi_fxsetting' ),
                'wpba-post-meta-box-title' => 'Media Attachments',
                'wpba-page-meta-box-title' => 'Media Attachments',
                'wpba-gfxi_fxsetting-meta-box-title' => 'Media Attachments',
                'wpba-gfxi_fxgallery-meta-box-title' => 'Media Attachments',
            );
        $updated = array_replace_recursive(unserialize($wpba_options[0]), $override_opts );
 //write_log(' update: ');
 //write_log($updated);
        $wpdb->update( $wpdb->options, 
                array( 'option_value' => serialize($updated) ),
                array('option_name' => 'wpba_settings')
             );

    } 

     // check attachment method/ recommended plugin
    $override_opts = array();
    $override_opts['wp_better_att_enabled'] = '0';
   if ( \is_plugin_active( 'wp-better-attachments/wp-better-attachments.php' ) ) {
          $override_opts['wp_better_att_enabled'] = '1';
    }
    $override_opts['media_lib_asst_enabled'] = '0';
    if ( \is_plugin_active( 'media-library-assistant/index.php' ) ) {
        $override_opts['media_lib_asst_enabled'] = '1';
    }

    $gfxi_options = $wpdb->get_col( "SELECT option_value FROM $wpdb->options WHERE option_name = 'gfxi_option'" ); 
  //     write_log(' opts: ');
  //      write_log( unserialize($gfxi_options[0]) );
    $updated = array_replace_recursive(unserialize($gfxi_options[0]), $override_opts );
   // write_log($updated);
    $wpdb->update( $wpdb->options, 
       array( 'option_value' => serialize($updated) ),
       array('option_name' => 'gfxi_option')
    );

}

function get_cptSlugs($cpt)
{
    $wp_posts = get_posts(array(
        'posts_per_page' => -1,
        'post_type' => $cpt,
    ));

    $result = array();
    foreach ($wp_posts as $post)
    {
        $result[] = array('value' => $post->post_name, 'label' => $post->post_title);
    }
    return $result;
}

function get_term_opts($tax) {
    $result = array();
    $args = array();
   
    $terms = get_terms(array($tax));
//write_log($tax);
//write_log($terms); 
    foreach ($terms as $term){
        $result[] = array('value' => $term->term_id, 'label' => $term->name );
    }
    return $result;
}


