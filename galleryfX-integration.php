<?php
/**
 * Plugin Name: Gallery fX Integration
 * Plugin URI:  http://bymichaelnoble.com/plugins/gallery-fx
 * Description: A WP plugin to integrate javscript/jQuery effects. The jssor slider plugin is built-in.
 * Version:     0.0.1
 * Author:      Michael Noble
 * Author URI:  http://bymichaelnoble.com
 * Text Domain: galleryfX
 * Domain Path: /languages
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License as published by the Free Software Foundation; either version 2 of the License, 
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write 
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package   GalleryfX-Integration
 * @version   0.0.1
 * @author    Michael Noble <michael@bymichaelnoble.com>
 * @copyright Copyright (c) 2008 - 2014, Michael Noble
 * @link      http://bymichaelnoble.com/plugins/galleryfX
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

define( 'GFXI_TEXTDOMAIN',		'galleryfX' );
define( 'GFXI_PLUGIN_DIR', 		plugin_dir_path( __FILE__ ) );
define( 'GFXI_PLUGIN_URL', 		plugin_dir_url( __FILE__ ) );

require_once(GFXI_PLUGIN_DIR . 'components/vafpress-framework/bootstrap.php');

require_once( GFXI_PLUGIN_DIR . 'components/tgm-plugin-activation/class-tgm-plugin-activation.php' );
add_action( 'tgmpa_register', 'gfxi_register_required_plugins' );

foreach ( glob( GFXI_PLUGIN_DIR . "lib/controllers/*.php" ) as $file ) {
    include_once $file;
}

function gallery_fx( $gallery_id, $fxsetting_id = null ) {
    if ( is_numeric($gallery_id) )
        return GFXI\GalleryfX\process_shortcode( array( 'fxgallery_id' => $gallery_id, 'fxsetting_id' => $fxsetting_id ) );
}

function gfxi_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		array(
			'name'      => 'WP Better Attachments',
			'slug'      => 'wp-better-attachments',
			'required'  => false,
		),
		array(
			'name'      => 'Media Library Assistant',
			'slug'      => 'media-library-assistant',
			'required'  => false,
		),
		array(
			'name'      => 'Responsify WP',
			'slug'      => 'responsify-wp',
			'required'  => false,
		),

	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'gfxi_tgmpa',            // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'gfxi-install-plugins', // Menu slug.
		'parent_slug'  => 'edit.php?post_type=gfxi_fxsetting',   // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                    // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
		'strings'      => array(
			'page_title'                      => __( 'Install Recommended Plugins', GFXI_TEXTDOMAIN ),
			'menu_title'                      => __( 'Recommended Plugins', GFXI_TEXTDOMAIN ),
			'notice_can_install_required'     => _n_noop(
				'Gallery fX requires the following plugin: %1$s.',
				'Gallery fX requires the following plugins: %1$s.',
				GFXI_TEXTDOMAIN
			), // %1$s = plugin name(s).
			'notice_can_install_recommended'  => _n_noop(
				'Gallery fX recommends the following plugin: %1$s.',
				'Gallery fX recommends the following plugins: %1$s.',
				GFXI_TEXTDOMAIN
			)
		),
	/*	
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', GFXI_TEXTDOMAIN ),
			'menu_title'                      => __( 'Install Plugins', GFXI_TEXTDOMAIN ),
			'installing'                      => __( 'Installing Plugin: %s', GFXI_TEXTDOMAIN ), // %s = plugin name.
			'oops'                            => __( 'Something went wrong with the plugin API.', GFXI_TEXTDOMAIN ),
			'notice_can_install_required'     => _n_noop(
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				GFXI_TEXTDOMAIN
			), // %1$s = plugin name(s).
			'notice_can_install_recommended'  => _n_noop(
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				GFXI_TEXTDOMAIN
			), // %1$s = plugin name(s).
			'notice_cannot_install'           => _n_noop(
				'Sorry, but you do not have the correct permissions to install the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to install the %1$s plugins.',
				GFXI_TEXTDOMAIN
			), // %1$s = plugin name(s).
			'notice_ask_to_update'            => _n_noop(
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				GFXI_TEXTDOMAIN
			), // %1$s = plugin name(s).
			'notice_ask_to_update_maybe'      => _n_noop(
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				GFXI_TEXTDOMAIN
			), // %1$s = plugin name(s).
			'notice_cannot_update'            => _n_noop(
				'Sorry, but you do not have the correct permissions to update the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to update the %1$s plugins.',
				GFXI_TEXTDOMAIN
			), // %1$s = plugin name(s).
			'notice_can_activate_required'    => _n_noop(
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				GFXI_TEXTDOMAIN
			), // %1$s = plugin name(s).
			'notice_can_activate_recommended' => _n_noop(
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				GFXI_TEXTDOMAIN
			), // %1$s = plugin name(s).
			'notice_cannot_activate'          => _n_noop(
				'Sorry, but you do not have the correct permissions to activate the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to activate the %1$s plugins.',
				GFXI_TEXTDOMAIN
			), // %1$s = plugin name(s).
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				GFXI_TEXTDOMAIN
			),
			'update_link' 					  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				GFXI_TEXTDOMAIN
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				GFXI_TEXTDOMAIN
			),
			'return'                          => __( 'Return to Required Plugins Installer', GFXI_TEXTDOMAIN ),
			'plugin_activated'                => __( 'Plugin activated successfully.', GFXI_TEXTDOMAIN ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', GFXI_TEXTDOMAIN ),
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', GFXI_TEXTDOMAIN ),  // %1$s = plugin name(s).
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', GFXI_TEXTDOMAIN ),  // %1$s = plugin name(s).
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', GFXI_TEXTDOMAIN ), // %s = dashboard link.
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'tgmpa' ),

			'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		),
		*/
	);

	tgmpa( $plugins, $config );
}

   
