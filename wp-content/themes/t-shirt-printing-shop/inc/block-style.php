<?php
/**
 * Block Styles
 *
 * @link https://developer.wordpress.org/reference/functions/register_block_style/
 *
 * @package WordPress
 * @subpackage t-shirt-printing-shop
 * @since t-shirt-printing-shop 1.0
 */

if ( function_exists( 'register_block_style' ) ) {
	/**
	 * Register block styles.
	 *
	 * @since t-shirt-printing-shop 1.0
	 *
	 * @return void
	 */
	function t_shirt_printing_shop_register_block_styles() {
		

		// Image: Borders.
		register_block_style(
			'core/image',
			array(
				'name'  => 't-shirt-printing-shop-border',
				'label' => esc_html__( 'Borders', 't-shirt-printing-shop' ),
			)
		);

		
	}
	add_action( 'init', 't_shirt_printing_shop_register_block_styles' );
}