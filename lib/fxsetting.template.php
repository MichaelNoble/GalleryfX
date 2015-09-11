<?php
return array(
            array(
                'type' => 'slider',
                'name' => 'width',
                'label' => __('Width (px)', GFXI_TEXTDOMAIN),
               // 'description' => __('This slider has minimum value of -10, maximum value of 17.5, sliding step of 0.1 and default value 15.9, everything can be customized.', GFXI_TEXTDOMAIN),
                'min' => '0',
                'max' => '2000',
                'step' => '1',
                'default' => '600',
            ),
            array(
                'type' => 'slider',
                'name' => 'height',
                'label' => __('Height (px)', GFXI_TEXTDOMAIN),
               // 'description' => __('This slider has minimum value of -10, maximum value of 17.5, sliding step of 0.1 and default value 15.9, everything can be customized.', GFXI_TEXTDOMAIN),
                'min' => '0',
                'max' => '1000',
                'step' => '1',
                'default' => '300',
            ),   
            array(
                'type' => 'toggle',
                'name' => 'link_caption',
                'label' => __('Link Captions', GFXI_TEXTDOMAIN),
                'default' => '0',
               // 'description' => __('Checking this will show filtering option group.', GFXI_TEXTDOMAIN),
            ),
            array(
                'type' => 'select',
                'name' => 'FillMode',
                'label' => __('Fillmode', GFXI_TEXTDOMAIN),
                'items' => array(
                    array(
                        'value' => '0',
                        'label' => __('Stretch', GFXI_TEXTDOMAIN),
                    ),
                    array(
                        'value' => '1',
                        'label' => __('Contain', GFXI_TEXTDOMAIN),
                    ),
                    array(
                        'value' => '2',
                        'label' => __('Cover', GFXI_TEXTDOMAIN),
                    ),
                    array(
                        'value' => '4',
                        'label' => __('Actual Size', GFXI_TEXTDOMAIN),
                    ),
                    array(
                        'value' => '5',
                        'label' => __('contain for large image', GFXI_TEXTDOMAIN),
                    ),
                ),
                'default' => array(
                    '1',
                ),
            ),
            array(
                'type' => 'slider',
                'name' => 'SlideDuration',
                'label' => __('Duration (ms)', GFXI_TEXTDOMAIN),
               // 'description' => __('This slider has minimum value of -10, maximum value of 17.5, sliding step of 0.1 and default value 15.9, everything can be customized.', GFXI_TEXTDOMAIN),
                'min' => '0',
                'max' => '10000',
                'step' => '1',
                'default' => '500',
            ),
            array(
                'type' => 'toggle',
                'name' => 'AutoPlay',
                'label' => __('AutoPlay', GFXI_TEXTDOMAIN),
              //  'description' => __('Suits the need to ask user a yes or no option.', GFXI_TEXTDOMAIN),
                'default' => '0',
            ),
             array(
                'type' => 'slider',
                'name' => 'AutoPlayInterval',
                'label' => __('Autoplay Interval (ms)', GFXI_TEXTDOMAIN),
               // 'description' => __('This slider has minimum value of -10, maximum value of 17.5, sliding step of 0.1 and default value 15.9, everything can be customized.', GFXI_TEXTDOMAIN),
                'min' => '0',
                'max' => '10000',
                'step' => '1',
                'default' => '3000',
            ),
            array(
                'type' => 'slider',
                'name' => 'AutoPlaySteps',
                'label' => __('Autoplay Steps (ms)', GFXI_TEXTDOMAIN),
               // 'description' => __('This slider has minimum value of -10, maximum value of 17.5, sliding step of 0.1 and default value 15.9, everything can be customized.', GFXI_TEXTDOMAIN),
                'min' => '0',
                'max' => '100',
                'step' => '1',
                'default' => '1',
            ), 
            array(
                'type' => 'select',
                'name' => 'PlayOrientation',
                'label' => __('Play Orientation', GFXI_TEXTDOMAIN),
                'items' => array(
                    array(
                        'value' => '1',
                        'label' => __('Horizontal', GFXI_TEXTDOMAIN),
                    ),
                    array(
                        'value' => '2',
                        'label' => __('Vertical', GFXI_TEXTDOMAIN),
                    ),
                    array(
                        'value' => '5',
                        'label' => __('Horizontal Reverse', GFXI_TEXTDOMAIN),
                    ),
                    array(
                        'value' => '6',
                        'label' => __('Vertical Reverse', GFXI_TEXTDOMAIN),
                    ),
                ),
                'default' => array(
                    '1',
                ),
            ),
            array(
                'type' => 'toggle',
                'name' => 'PauseOnHover',
                'label' => __('Pause on Hover', GFXI_TEXTDOMAIN),
              //  'description' => __('Suits the need to ask user a yes or no option.', GFXI_TEXTDOMAIN),
                'default' => '1',
            ),
            array(
                'type' => 'toggle',
                'name' => 'ShowArrows',
                'label' => __('Show Arrows', GFXI_TEXTDOMAIN),
               // 'description' => __('Checking this will show filtering option group.', GFXI_TEXTDOMAIN),
            ),
            array(
                'type'      => 'group',
                'repeating' => false,
                'length'    => 1,
                'name'      => 'ArrowNavigatorOptions',
                'title'     => __('Arrow Settings', GFXI_TEXTDOMAIN),
                'dependency' => array(
                    'field'    => 'ShowArrows',
                    'function' => 'vp_dep_boolean',
                ),
                'fields'    => array(
                    array(
                        'type' => 'select',
                        'name' => 'ChanceToShow',
                        'label' => __('Show Arrows', GFXI_TEXTDOMAIN),
                        'items' => array(
                            array(
                                'value' => '1',
                                'label' => __('On Mouseover', GFXI_TEXTDOMAIN),
                            ),
                            array(
                                'value' => '2',
                                'label' => __('Always', GFXI_TEXTDOMAIN),
                            ),
                        ),
                        'default' => array(
                            '1',
                        ),   
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'arrows-skin',
                        'label' => __('Arrows Skin', GFXI_TEXTDOMAIN),
                        'items' => array(
                            'data' => array(
                                array(
                                    'source' => 'function',
                                    'value' => 'GFXI\JssorHelper\getOptionsData',
                                    'params' => 'ArrowSkin',
                                ),
                            ),
                        ),
                        'default' => array(
                            '{{first}}',
                        ),
                    ),
                ),
            ),    
            array(
                'type' => 'toggle',
                'name' => 'ShowBullets',
                'label' => __('Show Bullets', GFXI_TEXTDOMAIN),
               // 'description' => __('Checking this will show filtering option group.', GFXI_TEXTDOMAIN),
            ),
            array(
                'type'      => 'group',
                'repeating' => false,
                'length'    => 1,
                'name'      => 'BulletNavigatorOptions',
                'title'     => __('Bullet Settings', GFXI_TEXTDOMAIN),
                'dependency' => array(
                    'field'    => 'ShowBullets',
                    'function' => 'vp_dep_boolean',
                ),
                'fields'    => array(
                    array(
                        'type' => 'select',
                        'name' => 'ChanceToShow',
                        'label' => __('Show Bullets', GFXI_TEXTDOMAIN),
                        'items' => array(
                            array(
                                'value' => '1',
                                'label' => __('On Mouseover', GFXI_TEXTDOMAIN),
                            ),
                            array(
                                'value' => '2',
                                'label' => __('Always', GFXI_TEXTDOMAIN),
                            ),
                        ),
                        'default' => array(
                            '1',
                        ),  
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'bullets-skin',
                        'label' => __('Bullets Skin', GFXI_TEXTDOMAIN),
                        'items' => array(
                            'data' => array(
                                array(
                                    'source' => 'function',
                                    'value' => 'GFXI\JssorHelper\getOptionsData',
                                    'params' => 'BulletSkin',
                                ),
                            ),
                        ),
                        'default' => array(
                            '{{first}}',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'ActionMode',
                        'label' => __('Bullet Action', GFXI_TEXTDOMAIN),
                        'items' => array(
                            'data' => array(
                                array(
                                    'source' => 'function',
                                    'value' => 'GFXI\JssorHelper\getOptionsData',
                                    'params' => 'BulletAction',
                                ),
                            ),
                        ),
                        'default' => array(
                            '{{first}}',
                        ),
                    ), 
                    array(
                        'type' => 'slider',
                        'name' => 'SpacingX',
                        'label' => __('Bullet Spacing (px)', GFXI_TEXTDOMAIN),
                       // 'description' => __('This slider has minimum value of -10, maximum value of 17.5, sliding step of 0.1 and default value 15.9, everything can be customized.', GFXI_TEXTDOMAIN),
                        'min' => '0',
                        'max' => '60',
                        'step' => '1',
                        'default' => '10',
                    ),              
                ),
            ),             
            array(
                'type' => 'select',
                'name' => 'responsive',
                'label' => __('Responsive', GFXI_TEXTDOMAIN),
              //  'description' => __('Suits the need to ask user a yes or no option.', GFXI_TEXTDOMAIN),
                'items' => array(
                    array(
                        'value' => '0',
                        'label' => __('No Scaling', GFXI_TEXTDOMAIN),
                    ),
                    array(
                        'value' => '1',
                        'label' => __('Scale Width', GFXI_TEXTDOMAIN),
                    ),

                    array(
                        'value' => '2',
                        'label' => __('Scale Height', GFXI_TEXTDOMAIN),
                    ),
                ),
                'default' => array('1'),
            ),
            array(
                'type' => 'select',
                'name' => 'DragOrientation',
                'label' => __('Swipe', GFXI_TEXTDOMAIN),
                'items' => array(
                    array(
                        'value' => '0',
                        'label' => __('No Swipe', GFXI_TEXTDOMAIN),
                    ),
                    array(
                        'value' => '1',
                        'label' => __('Swipe Horizontal', GFXI_TEXTDOMAIN),
                    ),
                    array(
                        'value' => '2',
                        'label' => __('Swipe Vertical', GFXI_TEXTDOMAIN),
                    ),
                    array(
                        'value' => '3',
                        'label' => __('Both', GFXI_TEXTDOMAIN),
                    ),
                ),
                'default' => array(
                    '1',
                ),
            ),
            array(
                'type'      => 'group',
                'repeating' => false,
                'length'    => 1,
                'name'      => 'default-trans',
                'title'     => __('Default Transitions', GFXI_TEXTDOMAIN),
                'fields'    => array(
                    array(
                        'type' => 'select',
                        'name' => 'cap-in',
                        'label' => __('Caption In', GFXI_TEXTDOMAIN),
                        'items' => array(
                            'data' => array(
                                array(
                                    'source' => 'function',
                                    'value' => 'GFXI\JssorHelper\getOptionsData',
                                    'params' => 'Caption_Transition',
                                ),
                            ),
                        ),
                        'default' => array(
                            '{{first}}',
                        ),
                    ),
                     array(
                        'type' => 'select',
                        'name' => 'cap-out',
                        'label' => __('Caption Out', GFXI_TEXTDOMAIN),
                        'items' => array(
                            'data' => array(
                                array(
                                    'source' => 'function',
                                    'value' => 'GFXI\JssorHelper\getOptionsData',
                                    'params' => 'Caption_Transition',
                                ),
                            ),
                        ),
                        'default' => array(
                            '{{first}}',
                        ),
                    ),                             
                    array(
                        'type' => 'select',
                        'name' => 'desc-in',
                        'label' => __('Description In', GFXI_TEXTDOMAIN),
                        'items' => array(
                            'data' => array(
                                array(
                                    'source' => 'function',
                                    'value' => 'GFXI\JssorHelper\getOptionsData',
                                    'params' => 'Caption_Transition',
                                ),
                            ),
                        ),
                        'default' => array(
                            '{{first}}',
                        ),
                    ),
                     array(
                        'type' => 'select',
                        'name' => 'desc-out',
                        'label' => __('Description Out', GFXI_TEXTDOMAIN),
                        'items' => array(
                            'data' => array(
                                array(
                                    'source' => 'function',
                                    'value' => 'GFXI\JssorHelper\getOptionsData',
                                    'params' => 'Caption_Transition',
                                ),
                            ),
                        ),
                        'default' => array(
                            '{{first}}',
                        ),
                    ),
                     array(
                        'type' => 'select',
                        'name' => 'slide-trans',
                        'label' => __('Slide Transition', GFXI_TEXTDOMAIN),
                        'items' => array(
                            'data' => array(
                                array(
                                    'source' => 'function',
                                    'value' => 'GFXI\JssorHelper\getOptionsData',
                                    'params' => 'Slide_Transition',
                                ),
                            ),
                        ),
                        'default' => array(
                            '{{first}}',
                        ),
                    ),
                ),
            ),             
        );