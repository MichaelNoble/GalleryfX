<?php
namespace GFXI\GalleryfX\View\Script;
use GFXI\JssorHelper;
/*  generate gallery script */
?>
    if ( typeof sliders==="undefined" ) {
    var sliders = new Array();
    }
<?php if ( $this->params['fxplugin'] == 'bxSlider' ) { ?>
    sliders['<?php echo $gallery_id; ?>'] = $( '#<?php echo $gallery_id; ?> .galleryfX' ).bxSlider({

<?php if ( !$hide_carousel) : ?>
    pagerCustom:    '#<?php echo $gallery_id; ?> .bxpager',
<?php endif; // !$hide_carousel ?>

    adaptiveHeight:    <?php echo($adaptive_height ? 'true' : 'false'); ?>,
    auto:    <?php echo($auto_start ? 'true' : 'false'); ?>,
    mode:    '<?php echo $transition; ?>',
    speed:    <?php echo $speed; ?>,
    pause:    <?php echo $duration; ?>,
<?php echo $extra_options; ?>
    });



<?php if ( !$hide_carousel) : ?>

    if ( typeof pagers==="undefined" ) {
    var pagers = new Array();
    }
    pagers['<?php echo $gallery_id; ?>'] = $('#<?php echo $gallery_id; ?> .bxpager').bxSlider({
    minSlides: <?php echo $this->plugin->get_option(GFXI_Settings::$OPTION_GS_CAROUSEL_MIN_THUMBS); ?>,
    maxSlides: <?php echo $this->plugin->get_option(GFXI_Settings::$OPTION_GS_CAROUSEL_MAX_THUMBS); ?>,
    slideWidth: <?php echo $this->plugin->get_option(GFXI_Settings::$OPTION_GS_CAROUSEL_THUMB_WIDTH); ?>,
    slideMargin: <?php echo $this->plugin->get_option(GFXI_Settings::$OPTION_GS_CAROUSEL_THUMB_MARGIN); ?>,
    slideMove: <?php echo $this->plugin->get_option(GFXI_Settings::$OPTION_GS_CAROUSEL_THUMBS_MOVE); ?>
    });

<?php endif; // !$hide_carousel 

} elseif (  $this->params['fxplugin'] == 'jssor' ) { 

   
    $slide_trans = JssorHelper\getslide_trans( $att_fXs, $this->get_option('slide-trans' ,'default-trans') );

    $captionIn_trans = JssorHelper\getcaption_trans( $att_fXs, self::$caption_transition, 'cap-in', $this->get_option('cap-in' ,'default-trans') );
    $captionOut_trans = JssorHelper\getcaption_trans( $att_fXs, self::$caption_transition, 'cap-out', $this->get_option('cap-out' ,'default-trans') );
    $decriptionIn_trans = JssorHelper\getcaption_trans( $att_fXs, self::$caption_transition, 'desc-in', $this->get_option('desc-in' ,'default-trans') );
    $decriptionOut_trans = JssorHelper\getcaption_trans( $att_fXs, self::$caption_transition, 'desc-out', $this->get_option('desc-out' ,'default-trans') );

    $caption_trans = $captionIn_trans.$captionOut_trans.$decriptionIn_trans.$decriptionOut_trans;

    ?>

    var _SlideshowTransitions = [<?php echo $slide_trans; ?>];
    var _CaptionTransitions = [];<?php echo $caption_trans; ?>
    var options = {
        <?= $this->get_js_option("AutoPlay") ?>                
        <?= $this->get_js_option("StartIndex") ?>
        <?= $this->get_js_option("Loop") ?>
        <?= $this->get_js_option("AutoPlaySteps") ?>
        <?= $this->get_js_option("AutoPlayInterval") ?>                
        <?= $this->get_js_option("SlideDuration") ?>
        <?= $this->get_js_option("PauseOnHover") ?>
        <?= $this->get_js_option("FillMode") ?>
        <?= $this->get_js_option("PlayOrientation") ?>
        <?= $this->get_js_option("SlideSpacing") ?> 
        <?= $this->get_js_option("DragOrientation") ?>   
        $HWA: true,
        $ArrowKeyNavigation: true,                                                              
        $MinDragOffsetToSlide: 20,                                                  
        $SlideSpacing: 0,                                                   
        $DisplayPieces: 1,                                                                  
        $ParkingPosition: 0,                                                                
        $UISearchMode: 1,          
        $SlideshowOptions: {                                                                
            $Class: $JssorSlideshowRunner$,                             
            $Transitions: _SlideshowTransitions,
            $TransitionsOrder: 1,                                                    
            $ShowLink: true                                                                     
        },
        $CaptionSliderOptions: {                                                        
            $Class: $JssorCaptionSlider$,                                    
            $CaptionTransitions: _CaptionTransitions,            
            $PlayInMode: 1,                                                              
            $PlayOutMode: 3                                                              
        },
        $ThumbnailNavigatorOptions: {
            $Class: $JssorThumbnailNavigator$,                       
            $ChanceToShow: 2,                                                            
            $ActionMode: 0,                                                              
            $DisableDrag: true,                                                      
            $Orientation: 2                                                              
        }
        <?php if ( $this->get_option("ShowBullets") > 0 )  { ?>
        ,$BulletNavigatorOptions: {                          //[Optional] Options to specify and enable navigator or not
            $Class: $JssorBulletNavigator$,                 //[Required] Class to create navigator instance
            <?= $this->get_js_option("ChanceToShow","BulletNavigatorOptions") ?>
            <?= $this->get_js_option("ActionMode","BulletNavigatorOptions") ?>   
            $AutoCenter: 1,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
            $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
            $Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
            <?= $this->get_js_option("SpacingX","BulletNavigatorOptions") ?>                                   //[Optional] Horizontal space between each item in pixel, default value is 0
            $SpacingY: 8,                                   //[Optional] Vertical space between each item in pixel, default value is 0
            $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
        }
        <?php } 
        if ( $this->get_option("ShowArrows") > 0 )  { ?>
        ,$ArrowNavigatorOptions: {                           //[Optional] Options to specify and enable arrow navigator or not
            $Class: $JssorArrowNavigator$,                  //[Requried] Class to create arrow navigator instance
            <?= $this->get_js_option("ChanceToShow","ArrowNavigatorOptions") ?>
            $AutoCenter: 2,                                 //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
            $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
        }
        <?php } ?>
    };
    sliders['<?php echo $gallery_id; ?>'] = new $JssorSlider$("slider_container_<?php echo $gallery_id; ?>", options);
    <?php if ( $this->get_option("responsive") > 0 ) : ?>
         function ScaleSlider<?php echo $gallery_id; ?>() {
            var bodyWidth = $('#slider_container_<?php echo $gallery_id; ?>').parent().width();
            if (bodyWidth)
                sliders['<?php echo $gallery_id; ?>'].$ScaleWidth(Math.min(bodyWidth, 1920));
            else
                window.setTimeout(ScaleSlider<?php echo $gallery_id; ?>, 30);
        }
        ScaleSlider<?php echo $gallery_id; ?>();

        $(window).bind("load", ScaleSlider<?php echo $gallery_id; ?>);
        $(window).bind("resize", ScaleSlider<?php echo $gallery_id; ?>);
        $(window).bind("orientationchange", ScaleSlider<?php echo $gallery_id; ?>);     
    <?php endif; ?>

<?php }  // endif $this->params['fxplugin'] ?> 
