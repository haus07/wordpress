<?php

// =======================
// Load CSS cho theme (ĐÃ SỬA)
// =======================
function doAnCMS_enqueue_styles() {
    // Base CSS luôn load
    wp_enqueue_style(
        'doAnCMS-base-style',
        get_stylesheet_uri(),
        array(),
        '1.0.1'
    );

    // Category CSS
    if ( is_tax('product_cat') ) {
        wp_enqueue_style(
            'doAnCMS-category-style',
            get_template_directory_uri() . '/category.css',
            array('doAnCMS-base-style'),
            '1.0.1'
        );
    }

    // Front page CSS
    if ( is_front_page() ) {
        wp_enqueue_style(
            'doAnCMS-front-page-style',
            get_template_directory_uri() . '/front-page.css',
            array('doAnCMS-base-style'),
            '1.0.1'
        );
    }

    // Product detail page CSS (WooCommerce single product)
    if ( is_singular('product') ) {
        wp_enqueue_style(
            'doAnCMS-product-detail-style',
            get_stylesheet_directory_uri() . '/product-detail.css',
            array('doAnCMS-base-style'),
            '1.0.1'
        );
    }
}
add_action('wp_enqueue_scripts', 'doAnCMS_enqueue_styles');

function doAnCMS_change_related_products_args( $args ) {
    
    // 1. Yêu cầu lấy 5 sản phẩm
    $args['posts_per_page'] = 5;
    
    // 2. Báo cho WooCommerce biết là mình sẽ chia 5 cột
    // (Để nó thêm class 'last' cho sản phẩm thứ 5)
    $args['columns'] = 5;

    return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'doAnCMS_change_related_products_args', 20 );

// =======================
// Khai báo các hỗ trợ của theme (Giữ nguyên)
// =======================
function doAnCMS_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    
    // **Thêm WooCommerce support**
    add_theme_support('woocommerce');

    register_nav_menus(array(
        'primary' => __('Main Menu', 'doAnCMS'),
    ));
}
add_action('after_setup_theme', 'doAnCMS_setup');


?>