<?php
/**
 * MonoBase Theme Customizer
 *
 * @package Monobase
 */

function monobase_customize_register( $wp_customize ) {

	$wp_customize->add_panel( 'monobase_settings', array(
		'title'       => esc_attr__( 'Theme Options', 'monobase' ),
		'description' => esc_attr__( 'Main theme settings.', 'monobase' ),
		'priority'    => 10,
	) );

	$wp_customize->add_section( 'monobase_home', array(
		'title'    => esc_attr__( 'Home page', 'monobase' ),
		'priority' => 10,
		'panel'    => 'monobase_settings',
	) );

	$wp_customize->add_setting( 'monobase_home[title]', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'monobase_home[title]', array(
		'type'        => 'text',
		'label'       => __( 'Title', 'monobase' ),
		'section'     => 'monobase_home',
		'description' => __( 'Set Title for Home Page.', 'monobase' ),
	) );

	$wp_customize->add_setting( 'monobase_home[excerpt]', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'monobase_home[excerpt]', array(
		'type'    => 'textarea',
		'label'   => __( 'Short Description', 'monobase' ),
		'section' => 'monobase_home',
	) );

	$wp_customize->add_setting( 'monobase_home[content]', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'monobase_home[content]', array(
		'type'    => 'textarea',
		'label'   => __( 'Content', 'monobase' ),
		'section' => 'monobase_home',
	) );

	$wp_customize->add_section( 'monobase_appearance', array(
		'title'    => esc_attr__( 'Appearance', 'monobase' ),
		'priority' => 10,
		'panel'    => 'monobase_settings',
	) );

	$wp_customize->add_setting( 'monobase_appearance[post_date]', array(
		'default'           => false,
		'sanitize_callback' => 'wp_validate_boolean',
	) );

	$wp_customize->add_control( 'monobase_appearance[post_date]', array(
		'label'    => __( 'Enable Post date in list', 'monobase' ),
		'section'  => 'monobase_appearance',
		'settings' => 'monobase_appearance[post_date]',
		'type'     => 'checkbox',
	) );

	$wp_customize->add_setting( 'monobase_appearance[current_post_first]', array(
		'default'           => false,
		'sanitize_callback' => 'wp_validate_boolean',
	) );

	$wp_customize->add_control( 'monobase_appearance[current_post_first]', array(
		'label' => __( 'Keep current post in default order', 'monobase' ),
		'description' => __( 'When enabled, current post stays in chronological order instead of moving to the top', 'monobase' ),

		'section'  => 'monobase_appearance',
		'settings' => 'monobase_appearance[current_post_first]',
		'type'     => 'checkbox',
	) );

	$wp_customize->add_setting( 'monobase_appearance[post_publish]', array(
		'default'           => false,
		'sanitize_callback' => 'wp_validate_boolean',
	) );

	$wp_customize->add_control( 'monobase_appearance[post_publish]', array(
		'label' => __( 'Show only publication date', 'monobase' ),
		'description' => __( 'Always display publication date instead of modification date', 'monobase' ),

		'section'  => 'monobase_appearance',
		'settings' => 'monobase_appearance[post_publish]',
		'type'     => 'checkbox',
	) );

	$mono_theme_mode = array(
		'light' => 'Light',
		'dark'  => 'Dark',
	);


	$wp_customize->add_setting( 'monobase_appearance[theme_mode]', array(
		'default'           => 'light',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'monobase_appearance[theme_mode]', array(
		'label'   => __( 'Theme mode', 'monobase' ),
		'section' => 'monobase_appearance',
		'type'    => 'select',
		'choices' => $mono_theme_mode,
	) );

	$wp_customize->add_setting( 'monobase_appearance[dark_logo]', [
		'default'           => '',
		'sanitize_callback' => 'absint',
	] );

	$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'monobase_appearance[dark_logo]', [
		'label'     => __( 'Dark Logo', 'monobase' ),
		'section'   => 'monobase_appearance',
		'mime_type' => 'image',
	] ) );


}

add_action( 'customize_register', 'monobase_customize_register' );