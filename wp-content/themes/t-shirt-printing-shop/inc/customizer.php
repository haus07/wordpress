<?php
/**
 * Customizer
 * 
 * @package WordPress
 * @subpackage t-shirt-printing-shop
 * @since t-shirt-printing-shop 1.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function t_shirt_printing_shop_customize_register( $wp_customize ) {
	$wp_customize->add_section( new T_Shirt_Printing_Shop_Upsell_Section($wp_customize,'upsell_section',array(
		'title'            => __( 'T Shirt Printing Shop Pro', 't-shirt-printing-shop' ),
		'button_text'      => __( 'Upgrade Pro', 't-shirt-printing-shop' ),
		'url'              => 'https://www.wpradiant.net/products/t-shirt-printing-wordpress-theme',
		'priority'         => 0,
	)));
}
add_action( 'customize_register', 't_shirt_printing_shop_customize_register' );

/**
 * Enqueue script for custom customize control.
 */
function t_shirt_printing_shop_custom_control_scripts() {
	wp_enqueue_script( 't-shirt-printing-shop-custom-controls-js', get_template_directory_uri() . '/assets/js/custom-controls.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-sortable' ), '1.0', true );
	wp_enqueue_style( 't-shirt-printing-shop-customize-controls', trailingslashit( get_template_directory_uri() ) . '/assets/css/customize-controls.css' );
}
add_action( 'customize_controls_enqueue_scripts', 't_shirt_printing_shop_custom_control_scripts' );