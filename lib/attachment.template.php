<?php
return array(
	        array(
	            'type' => 'textbox',
	            'name' => 'linkURL',
	            'label' => __('Link URL', GFXI_TEXTDOMAIN),
	            'validation' => 'url',
	        ),
	        array(
	            'type'      => 'group',
	            'repeating' => false,
	            'length'    => 1,
	            'name'      => 'transits',
	            'title'     => __('Slide Transitions', GFXI_TEXTDOMAIN),
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
