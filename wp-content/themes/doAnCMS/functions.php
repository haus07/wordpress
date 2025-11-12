<?php
if (! defined('ABSPATH')) exit;

// =======================
// Load CSS cho theme
// =======================
function doAnCMS_enqueue_styles()
{
    // Base CSS: luôn load
    wp_enqueue_style(
        'doAnCMS-base-style',
        get_stylesheet_uri(),
        array(),
        '1.0.1'
    );

    // WooCommerce chung (cần thiết thôi)
    if (function_exists('is_woocommerce') && is_woocommerce()) {
        wp_enqueue_style(
            'doAnCMS-woocommerce-style',
            get_template_directory_uri() . '/woocommerce.css',
            array('doAnCMS-base-style'),
            '1.0.1'
        );
    }

    // Chỉ Cart page
    if (function_exists('is_cart') && is_cart()) {
        wp_enqueue_style(
            'doAnCMS-woocommerce-cart-style',
            get_template_directory_uri() . '/woocommerce-cart.css',
            array('doAnCMS-woocommerce-style'),
            '1.0.1'
        );
    }

    // Chỉ Checkout page
    if (function_exists('is_checkout') && is_checkout()) {
        wp_enqueue_style(
            'doAnCMS-woocommerce-checkout-style',
            get_template_directory_uri() . '/woocommerce-checkout.css',
            array('doAnCMS-woocommerce-style'),
            '1.0.1'
        );
    }

    // Product detail page
    if (is_singular('product')) {
        wp_enqueue_style(
            'doAnCMS-product-detail-style',
            get_stylesheet_directory_uri() . '/product-detail.css',
            array('doAnCMS-base-style'),
            '1.0.1'
        );
    }
}
add_action('wp_enqueue_scripts', 'doAnCMS_enqueue_styles', 20);

// =======================
// Custom related products
// =======================
function doAnCMS_change_related_products_args($args)
{
    $args['posts_per_page'] = 5; // 5 sản phẩm liên quan
    $args['columns'] = 5;        // 5 cột
    return $args;
}
add_filter('woocommerce_output_related_products_args', 'doAnCMS_change_related_products_args', 20);

// =======================
// Theme setup
// =======================
function doAnCMS_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    // WooCommerce support
    add_theme_support('woocommerce');

    // Menu
    register_nav_menus(array(
        'primary' => __('Main Menu', 'doAnCMS'),
    ));
}
add_action('after_setup_theme', 'doAnCMS_setup');

// =======================
// Optional: Session start
// =======================
function doAnCMS_start_session()
{
    if (! session_id()) {
        session_start();
    }
}
add_action('init', 'doAnCMS_start_session');

// =======================
// Thêm sản phẩm vào giỏ hàng WooCommerce
// =======================
function doAnCMS_add_to_cart_woo()
{
    if (isset($_GET['add_to_cart'])) {
        $product_id = intval($_GET['add_to_cart']);
        if ($product_id > 0) {
            WC()->cart->add_to_cart($product_id);
            wp_redirect(wc_get_cart_url()); // chuyển đến trang cart mặc định
            exit;
        }
    }
}
add_action('template_redirect', 'doAnCMS_add_to_cart_woo');

// =======================
// Optional: Custom WooCommerce hooks hoặc filter khác
// Ví dụ: thay đổi nút thêm vào giỏ hàng
// =======================
// add_filter('woocommerce_product_single_add_to_cart_text', function() {
//     return __('Thêm vào giỏ', 'doAnCMS');
// });
