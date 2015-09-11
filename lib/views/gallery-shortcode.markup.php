<?php
namespace GFXI\GalleryfX\View\Markup;
use GFXI\JssorHelper;
use \rwp_img;

 if ( $this->get_option('fxplugin') == 'bxSlider' ) { 
    $gallery_extra_classes = $adaptive_height ? 'adaptive-height-on ' : 'adaptive-height-off ';
?>

<div id="<?php echo $gallery_id; ?>" class="galleryfX-gallery <?php echo esc_attr($gallery_extra_classes); ?>">
    <div class="gallery-wrapper">
        <div class="galleryfX">
            <?php
            $size = $this->get_option('slide_size');
            foreach ($attachments as $attachment) :
                $img_attr = wp_get_attachment_image_src($attachment->ID, $size);
                $title = apply_filters('the_title', $attachment->post_title, $attachment->ID);
                $desc = $attachment->post_excerpt;
                ?>
                <div class="bxslide"><?php echo sprintf('<img src="%1$s" alt="%2$s" title="%3$s" />',
                        $img_attr[0], esc_attr($desc), esc_attr($title));
                    ?></div>
            <?php
            endforeach; ?>
        </div>
    </div>

    <?php if ( !$hide_carousel) : ?>

        <div class="pager-wrapper">
            <div class="bxpager">
                <?php
                $i = 0;
                foreach ($attachments as $attachment) :
                    $img_attr = wp_get_attachment_image_src($attachment->ID, $thumb_size);
                    $title = apply_filters('the_title', $attachment->post_title, $attachment->ID);
                    $desc = $attachment->post_excerpt;

                    echo sprintf('<a data-slide-index="%4$s" href="" title="%3$s"><img src="%1$s" alt="%2$s" title="%3$s" /></a>',
                        $img_attr[0], esc_attr($desc), esc_attr($title), $i);
                    ++$i;
                endforeach; ?>
            </div>
        </div>

    <?php endif; // !$hide_carousel ?>

</div>

<?php } elseif (  $this->get_option('fxplugin') == 'jssor' ) { 

    $sliderW = $this->get_option("width");
    $sliderH = $this->get_option("height"); 
    $cursor =  ( $this->get_option("DragOrientation") > 0 ) ? 'move' : 'default';
    $descH = $sliderH - 50;
    
    $arrow = $this->get_option('arrows-skin','ArrowNavigatorOptions');
    $arrowSkin = JssorHelper\arrowSkin( $arrow )[0];
    $arrowWidth = JssorHelper\arrowSkin( $arrow )[1];
    $arrowHeight = JssorHelper\arrowSkin( $arrow )[2];
    $arrowBorder = ( isset( JssorHelper\arrowSKin ( $arrow )[3] ) ) ? '0' : '8';
    $arrowL = 'jssor' . $arrow . 'l';
    $arrowR = 'jssor' . $arrow . 'r';

    $bullet = $this->get_option('bullets-skin','BulletNavigatorOptions');
    $bulletStyle1 = JssorHelper\bulletSkin( $bullet )[0];
    $bulletStyle2 = JssorHelper\bulletSkin( $bullet )[1];
    $bulletNT = JssorHelper\bulletSkin( $bullet )[2];
    $bulletCl = 'jssor' . $bullet;

    $result2 = JssorHelper\format_R( self::$caption_transition );

    $size = $this->get_option('slide_size');
?>
<div id="slider_container_<?php echo $gallery_id; ?>" class="jssor_slider_outer_container" style="width:<?php echo $sliderW; ?>px; height:<?php echo $sliderH; ?>px;">
    <!-- Slides Container -->
    <div u="slides" class="jssor_slider_slides" style="width:<?php echo $sliderW; ?>px; height:<?php echo $sliderH; ?>px ;cursor:<?php echo $cursor; ?>;">
        <!-- Slide -->
       <?php 
        $rwp = ( function_exists('rwp_img') ? true : false );  //  is Responsify WP installed?
        foreach ($attachments as $attachment) :
            if ( ! $rwp ) $img_attr = wp_get_attachment_image_src($attachment->ID, $size);
            $title = apply_filters('the_title', $attachment->post_title, $attachment->ID);
            $desc = $attachment->post_excerpt;

            $att_fX = ( ! empty($att_fXs) && isset($att_fXs[$attachment->ID]) ? $att_fXs[$attachment->ID] : array() ); 
             $link_url = ''; 
            if ( $this->get_option("link_caption") && isset($att_fX['linkURL']) ) :
                $link_url = $att_fX['linkURL']; 
            elseif ( $this->get_option("link_caption") ) :
                $link_url = get_attachment_link( $attachment->ID );
            endif;

            $cap_in = ( isset($att_fX['transits'][0]['cap-in']) ? $result2[$att_fX['transits'][0]['cap-in']] : $result2[$this->get_option('cap-in','default-trans')] );
            $cap_out = ( isset($att_fX['transits'][0]['cap-out']) ? $result2[$att_fX['transits'][0]['cap-out']] : $result2[$this->get_option('cap-out','default-trans')] );
            $desc_in = ( isset($att_fX['transits'][0]['desc-in']) ? $result2[$att_fX['transits'][0]['desc-in']] : $result2[$this->get_option('desc-in','default-trans')] );
            $desc_out = ( isset($att_fX['transits'][0]['desc-out']) ? $result2[$att_fX['transits'][0]['desc-out']] : $result2[$this->get_option('desc-out','default-trans')] );

        ?>   
        <div>
            <?php 

                $target = '_blank';
                if ( strlen($link_url) > 0 ) 
                    echo sprintf('<a target="%1$s" u="image" href="%2$s">',$target, $link_url);
                if (! $rwp ) {
                    echo sprintf('<img src="%1$s" alt="%2$s" title="%3$s" />', $img_attr[0], esc_attr($desc), esc_attr($title) );
                } else {
                    echo rwp_img( $attachment->ID, array('data-alt' => $desc, 'data-title' => $title,
                    //                                     'sizes' => array('thumbnail', 'medium', 'large'),
                    //                                        'media_queries' => array( 'medium' => 'min-width: 500px', 'large' => 'min-width: 1024px' )) 
                                ));
                }
                if ( strlen($link_url) > 0 ) echo '</a>';
               
               // if ( $this->get_option('FillMode') == '0' ) :
                    if ( $title ) : 
                        if ( strlen($link_url) > 0 ) :    
            
                             echo sprintf('<a target="%1$s" href="%2$s"><div u="caption" t="%3$s" t2="%4$s" class="jssor_slider_caption">%5$s</div></a>', 
                                $target, $link_url, $cap_in, $cap_out, $title);

                        else : 
                
                            echo sprintf('<div u="caption" t="%1$s" t2="%2$s" class="jssor_slider_caption">%3$s</div>', 
                                 $cap_in, $cap_out, $title);

                        endif;
                    endif;
                    if ( $desc ) :
            ?>
            <div u="caption" t="<?php echo $desc_in; ?>" t2="<?php echo $desc_out; ?>" class="jssor_slider_desc_outer_div" style="top: <?php echo $descH; ?>px;width:<?php echo $sliderW; ?>px;">
                <div class="jssor_slider_desc_inner_div" style="width: <?php echo $sliderW; ?>px;"></div>
                <div class="jssor_slider_desc_text_div" style="width: <?php echo $sliderW; ?>px;">
                    <?php if ( strlen($link_url) > 0 ) : ?>
                        <a target="<?php echo $target; ?>" href="<?php echo $link_url; ?>"><?php echo $desc; ?></a>
                    <?php else : ?>
                        <?php echo $desc; ?>
                    <?php endif; ?>     
                </div>
            </div>
            <?php   
                    endif; 
               // endif;
            ?>
        </div>
        <!-- Slide -->
        <?php endforeach; ?>
    </div>
    
    <!-- Bullet Navigator Skin Begin -->
    <?php if ( $this->get_option('ShowBullets') ) : ?>
    <style>
        <?php echo $bulletStyle1; ?>
    </style>
        
    <!-- bullet navigator container -->
    <div  u="navigator" class="<?php echo $bulletCl .' '; ?>jssor_slider_nav_div" >
        <!-- bullet navigator item prototype -->
        <div u="prototype" style="<?php echo $bulletStyle2; ?>"><?php echo $bulletNT; ?></div>
    </div>
    <?php endif; ?>
    <!-- Bullet Navigator Skin End -->
    
    <!-- Arrow Navigator Skin Begin -->
    <?php 
    //    if ( $this->get_option('FillMode') == '0' ) :   
            if ( $this->get_option('ShowArrows') ) : 
    ?>
    <style>
        <?php echo $arrowSkin; ?>
    </style>
    <!-- Arrow Left -->
    <span u="arrowleft" class="<?php echo $arrowL; ?>" style="width:<?php echo $arrowWidth; ?>px; height:<?php echo $arrowHeight; ?>px; top: 45%; left: <?php echo $arrowBorder ?>px;"></span>
    <!-- Arrow Right -->
    <span u="arrowright" class="<?php echo $arrowR; ?>" style="width:<?php echo $arrowWidth; ?>px; height:<?php echo $arrowHeight; ?>px; top: 45%; right: <?php echo $arrowBorder ?>px"></span>
    <?php   endif; 
    //    endif;
    ?>
    <!-- Arrow Navigator Skin End -->       
            
</div>

<?php } ?>  