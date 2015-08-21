<?php

namespace GFXI\GalleryfX\Display;

require_once(GFXI_PLUGIN_DIR . 'lib/jssor.helper.php');

class Display {


    public $params = array(); 

    public $options = array();

    // holds gallery scripts, outputted in the footer
	public static $scripts = array();

    public static $fx_plugins = array();

    static $defaults;

    static $caption_transition;

    static $slide_transition;

    private static $current_gallery_id;


    function __construct() {

        self::get_defaults();
        self::init_transitions();

    }

    static function init_transitions() {

    	if ( isset(self::$caption_transition) )
    		return;

    	include(GFXI_PLUGIN_DIR . 'lib/jssor.data.php');

    	self::$caption_transition = array_flip($Caption_Transition);
    	
    	//self::$slide_transitions = $Slide_Transitions;
    	
    	return;

    }

    static function get_defaults() {
        
        if ( isset(self::$defaults) )
            return self::$defaults;
        
        self::$defaults = array(  
            
            'fxgallery_id' => null,
            'fxsetting_id' => null, 
            'fxgallery' => null,
            'fxsetting' => null, 
            'fxplugin' => 'jssor',         
      
       /* jssor */     
            'AutoPlay' => true,
            'Transition' => array(),            
            'StartIndex' => 0,            
            'Loop' => 1,
            'AutoPlaySteps' => 1,
            'AutoPlayInterval' => 3000,                        
            'SlideDuration' =>  500,
            'PauseOnHover' => 1,
            
            'FillMode' => 2,                                    
            'PlayOrientation' =>  1,
            'DragOrientation' =>  0,   
            'ArrowKeyNavigation' => false,

            'Responsive' => true,
            'SlideSpacing' =>  0,
            'SlideWidth' => '600',
            'SlideHeight' => '300',                                       
                                                                     
            'ShowBullets' =>  2,
            'BulletsSkin' => 1,
            'ShowArrows' =>  1,
            'ArrowsSkin' => 1,
            'ShowThumbnails' => 0,
            'ThumbnailsSkin' => 1,
        /* end jssor */   

            'ExcludeFeatured' => false,
            'Shuffle'   => false,
            'MoreButtonTitle' => __('Learn More', GFXI_TEXTDOMAIN),
            
            'Styles' => 0,

            'order'       => 'ASC',
            'orderby'     => 'menu_order ID',
            'id'          => get_the_ID(),
            'mime_type'   => 'image',
            'link'        => '',
            'size'        => has_image_size( 'post-thumbnail' ) ? 'post-thumbnail' : 'thumbnail',
            'slide_size'    => 'full',
            'ids'         => '',
            'include'     => '',
            'exclude'     => '',
            'numberposts' => -1,
            'offset'      => '',

            'attach_tag'     => null,
            'attach_cat'     => null
        );
          
        return self::$defaults;
    }
    
    private function get_attachments() {

        global $post;
  
        $args = array(
            'post_status'      => 'inherit',
            'post_type'        => 'attachment',
            'post_mime_type'   => $this->params['mime_type'],
            'order'            => $this->params['order'],
            'orderby'          => $this->params['orderby'],
            'exclude'          => $this->params['exclude'],
            'include'          => $this->params['include'],
            'numberposts'      => $this->params['numberposts'],
            'offset'           => $this->params['offset'],
            'suppress_filters' => true
        );

            
        if ( $this->params['fxgallery_id'] > 0 )
        {
            $args['post_parent'] = $this->params['fxgallery_id'];
            $args['orderby'] = 'menu_order ID';
        }
        elseif ( strlen($this->get_option('attach_cat')) > 0 ){
             $args['tax_query'] = array(
                    array(
                    'taxonomy' => 'attachment_category',
                    'field' => 'term_id',
                    'terms' => $this->get_option('attach_cat')
                    )
                );           
        }
        elseif ( strlen($this->get_option('attach_tag')) > 0 ){
            $args['tax_query'] = array(
                    array(
                    'taxonomy' => 'attachment_tag',
                    'field' => 'term_id',
                    'terms' => $this->params['attach_tag']
                    )
                );
        }
        elseif ( ! empty($this->params['ids']) )    
        {
            $ids = explode(',', $this->params['ids']);
            $args['post__in'] = $ids;
            $args['orderby'] = 'post__in';
        }
        else
        {
            $args['post_parent'] = $this->params['id'];
            $args['orderby'] = 'menu_order ID';
        }

        if ($this->get_option('ExcludeFeatured') == true || $this->get_option('ExcludeFeatured') == 1)
        {
            $featured_id = get_post_thumbnail_id();
            if ($featured_id)
            {
                $args['exclude'] = $featured_id;
            }
        }

        $attachments = get_posts($args);

        return $attachments;
    }

     /**
     * Method for setting up, parsing, and providing filter hooks for the parameters.
     *
     * @since  0.0.1
     * @access public
     * @return void
     */
    public function load_gallery( $attr ) {
            global  $wpdb;

        $fxsetting_id = '';
        if ( isset($attr['fxsetting_id']) && intval($attr['fxsetting_id']) > 0) {
           $fxsetting_id = intval($attr['fxsetting_id']);
        }
        elseif ( isset($attr['fxsetting']) && strlen($attr['fxsetting']) > 1 ) {
            $fxsetting_ids = $wpdb->get_col($wpdb->prepare("
                    SELECT      ID
                    FROM        $wpdb->posts
                    WHERE       post_type = 'gfxi_fxsetting' AND post_status = 'publish' AND post_name = %s",
                    $attr['fxsetting']));
            if ($fxsetting_ids) {
                $fxsetting_id = $fxsetting_ids[0];
                $attr['fxsetting_id'] = $fxsetting_id;
            }
        }

         if (! isset($attr['fxgallery_id']) && ! $attr['fxgallery_id'] > 0 && isset($attr['fxgallery']) ) {
            $fxgallery_ids = $wpdb->get_col($wpdb->prepare("
                    SELECT      ID
                    FROM        $wpdb->posts
                    WHERE       post_type = 'gfxi_fxgallery' AND post_status = 'publish' AND post_name = %s",
                    $attr['fxgallery']));
            if ($fxgallery_ids) 
                $attr['fxgallery_id'] = $fxgallery_ids[0];
        }
    
        if (intval($fxsetting_id) > 0) $this->options = get_post_meta( intval($fxsetting_id), '_gfxi-jssor_', true );         

    
        /* Orderby. */
        if ( isset( $attr['orderby'] ) ) {
            $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
            if ( !$attr['orderby'] )
                unset( $attr['orderby'] );
        }

       
        /* Apply filters to the default parameters. */
        $defaults = apply_filters( 'galleryfX_defaults', self::$defaults );

        /* Merge the defaults with user input.  */
        $this->params = shortcode_atts( $defaults, $attr );

        /* Apply filters to the parameters. */
        $this->params = apply_filters( 'galleryfX_params', $this->params );
        /* Make sure the post IDs are valid integers. */
        $this->params['fxgallery_id'] = intval( $this->params['fxgallery_id'] );
        $this->params['fxsetting_id'] = intval( $this->params['fxsetting_id'] );
   
            
        /* Enque fX plugin scripts and styles */
        $fxplugin = $this->get_option('fxplugin');
        if ( isset($fxplugin) ) {
            if ( empty( self::$fx_plugins) || ! in_array($fxplugin, self::$fx_plugins) ) {
                self::$fx_plugins[] = $fxplugin;

                if ( $fxplugin == 'jssor' ) {
                    wp_enqueue_script(
                        'jssor-slider',
                        GFXI_PLUGIN_URL . 'components/jssor/js/jssor.slider.mini.js',
                        array('jquery'),false,true);

                    wp_enqueue_style(
                        'jssor-slider',
                        GFXI_PLUGIN_URL . 'assets/css/jssor-slider.css');
                }

            }
        } 
 
    }

    function get_display() {

    	// iterate gallery id
    	self::$current_gallery_id ++;

    	/* get the media */
        $attachments = $this->get_attachments();

        /* If there are no attachments, return an empty string. */
        if ( empty( $attachments ) )
            return '';

        /* Count the number of attachments returned. */
        $attachments_count = count( $attachments );

        if ($this->get_option('Shuffle') == 1)
        {
            shuffle($attachments);
        }

        //  gather the attachement metadata
        $att_fXs = array();
        foreach ($attachments as $attachment)
            $att_fXs[$attachment->ID] = get_post_meta($attachment->ID,'_gfxi-att-jssor_',true); 

        // Compute an ID for this particular gallery
        $gallery_id = 'fxgallery_' . self::$current_gallery_id;
	       
        // Build the markup output
        ob_start();                                                                      
        include(GFXI_PLUGIN_DIR . 'lib/views/gallery-shortcode.markup.php');
        $out = ob_get_contents();
        ob_end_clean();

        // Build the script and store for footer output
        ob_start();                                                                      
        include(GFXI_PLUGIN_DIR . 'lib/views/gallery-shortcode.script.php');
        self::$scripts[] = ob_get_contents();
        ob_end_clean();  

        return $out;
    }

    function get_option( $name, $group = null ) {

        if ( isset($group ) ) 
            return ( isset($this->options[$group][0][$name]) ? $this->options[$group][0][$name] : null );

        if ( isset($this->options[$name]) )
            return $this->options[$name];
                   
        return ( isset($this->params[ $name ]) ? $this->params[ $name ] : null );
    
    }

    function get_string( $val ) {
                
        if ($val === true) 
            return "true";
        elseif ($val === false) 
            return "false";
        else
            return $val;
    }
    
    function get_js_option( $name, $group = null, $separator = ",\n" ) {

        if ( isset($group ) ) {

            if ( isset($this->options[$group][0][$name]) )
                $val = $this->options[$group][0][$name];

        } elseif ( isset($this->options[$name]) ) { 
            $val = $this->options[$name];

        } else
             $val = $this->params[ $name ];
        
        $val = $this->get_string( $val );
        
        if ( $val != '' )
            return "$" . $name . ":" . $val . $separator;
        else
            return "";

    }

}

