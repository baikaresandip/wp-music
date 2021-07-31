<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP-OOP-Settings-API Initializer
 *
 * Initializes the WP-OOP-Settings-API.
 *
 * @since   1.0.0
 */


/**
 * Class `WP_OOP_Settings_API`.
 *
 * @since 1.0.0
 */
require_once dirname(__FILE__) . '/class-wp-music-setting.php';


/**
 * Actions/Filters
 *
 * Related to all settings API.
 *
 * @since  1.0.0
 */
if ( class_exists( 'WP_OSA' ) ) {
	/**
	 * Object Instantiation.
	 *
	 * Object for the class `WP_OSA`.
	 */
	$wposa_obj = new WP_OSA();


	// Section: Basic Settings.
	$wposa_obj->add_section(
		array(
			'id'    => 'wpm_wpmusic_basic_setting',
			'title' => __( 'Basic Settings', 'wp-music' ),
		)
	);

	// Field: Select.
	$wposa_obj->add_field(
		'wpm_wpmusic_basic_setting',
		array(
			'id'      => 'currency',
			'type'    => 'select',
			'name'    => __( 'Currenty', 'wp-music' ),
			'desc'    => __( 'Select your Music Currenty', 'wp-music' ),
			'default' => "INR",
			'options' => wpm_get_currencies(),
		)
	);

	// Field: Number.
	$wposa_obj->add_field(
		'wpm_wpmusic_basic_setting',
		array(
			'id'                => 'per_page',
			'type'              => 'number',
			'name'              => __( 'Musics per page', 'wp-music' ),
			'desc'              => __( 'Show number of musics per page.', 'wp-music' ),
			'default'           => 9,
			'sanitize_callback' => 'intval',
		)
	);

	// Field: Select.
	$wposa_obj->add_field(
		'wpm_wpmusic_basic_setting',
		array(
			'id'      => 'music_view',
			'type'    => 'select',
			'name'    => __( 'Music Listing view', 'wp-music' ),
			'desc'    => __( 'Select your Music Listing view', 'wp-music' ),
			'default' => 'list-view',
			'options' => array(
				'list-view' => __('List View', 'wp-music'),
				'grid-view' => __('Grid View', 'wp-music'),
			)
		)
	);

	

	
	
}