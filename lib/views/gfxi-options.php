<?php
return array(
	'title' => __('Gallery fX Option Panel', GFXI_TEXTDOMAIN),
	'logo' => 'http://wunjo.luv/app/uploads/2015/08/Muir_Wood10-150x150.jpg',
	'menus' => array(
		array(
			'title' => __('General Options', GFXI_TEXTDOMAIN),
			'name' => 'menu_1',
			'icon' => 'font-awesome:fa-magic',
			'menus' => array(
				array(
					'title' => __('Setup', GFXI_TEXTDOMAIN),
					'name' => 'submenu_1',
					'icon' => 'font-awesome:fa-th-large',
					'controls' => array(
						array(
							'type' => 'section',
							'title' => __('Reccommended Plugin Interactions', GFXI_TEXTDOMAIN),
							'name' => 'section_1',
							'description' => __('Reccommended Plugin Interactions', GFXI_TEXTDOMAIN),
							'fields' => array(
								array(
									'type' => 'toggle',
									'name' => 'setbetrattchopts',
									'label' => __('Setup WP Better Attach', GFXI_TEXTDOMAIN),
									'description' => __('Sets a few options in WP Better Attachmets.', GFXI_TEXTDOMAIN),
								//	'validation' => 'minselected[2]|maxselected[2]',
									'default' => '1',
									),
								),
							)
						),
					)
				)
			)
		)
	);

