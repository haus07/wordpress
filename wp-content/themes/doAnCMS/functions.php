<?php
if (!defined('ABSPATH')) exit;

// =======================
// Load CSS cho theme
// =======================
function doAnCMS_enqueue_styles()
{
    // Base CSS: luôn load cho toàn site
    wp_enqueue_style(
        'doAnCMS-base-style',
        get_stylesheet_uri(),
        array(),
        '1.0.1'
    );

    // Chỉ load CSS WooCommerce khi WooCommerce active và trang WooCommerce
    if (function_exists('is_woocommerce') && is_woocommerce()) {

        // WooCommerce chung
        wp_enqueue_style(
            'doAnCMS-woocommerce-style',
            get_stylesheet_directory_uri() . '/woocommerce.css',
            array('doAnCMS-base-style', 'woocommerce-general', 'woocommerce-layout', 'woocommerce-smallscreen'),
            '1.0.1'
        );

        // Cart page
        if (function_exists('is_cart') && is_cart()) {
            wp_enqueue_style(
                'doAnCMS-woocommerce-cart-style',
                get_stylesheet_directory_uri() . '/woocommerce-cart.css',
                array('doAnCMS-woocommerce-style'),
                '1.0.1'
            );
        }

        // Checkout page
        if (function_exists('is_checkout') && is_checkout()) {
            wp_enqueue_style(
                'doAnCMS-woocommerce-checkout-style',
                get_stylesheet_directory_uri() . '/woocommerce-checkout.css',
                array('doAnCMS-woocommerce-style'),
                '1.0.1'
            );
        }

        // Single product page
        if (is_singular('product')) {
            wp_enqueue_style(
                'doAnCMS-product-detail-style',
                get_stylesheet_directory_uri() . '/product-detail.css',
                array('doAnCMS-woocommerce-style'),
                '1.0.1'
            );
        }
    }
}
add_action('wp_enqueue_scripts', 'doAnCMS_enqueue_styles', 99); // ưu tiên load cuối cùng

// =======================
// Hiển thị tên sản phẩm trong Cart dưới dạng text thuần, không link
// =======================
add_filter('woocommerce_cart_item_name', function ($product_name, $cart_item, $cart_item_key) {
    $product = $cart_item['data'];
    return $product->get_name(); // trả về tên thuần
}, 10, 3);
// =======================
// Hiển thị Cart Totals thuần text
// =======================

// Subtotal
add_filter('woocommerce_cart_subtotal', function ($subtotal, $compound, $cart) {
    // Loại bỏ bất kỳ HTML nào, chỉ giữ text và giá
    $subtotal_text = strip_tags($subtotal);
    return $subtotal_text;
}, 10, 3);

// Shipping
add_filter('woocommerce_cart_totals_shipping_html', function ($html, $shipping_rate) {
    // Nếu có nhiều phương thức vận chuyển, hiển thị từng phương thức
    if (is_array($shipping_rate)) {
        $lines = [];
        foreach ($shipping_rate as $rate) {
            $label = isset($rate->label) ? $rate->label : 'Shipping';
            $cost  = isset($rate->cost) ? wc_price($rate->cost) : 'Free';
            $lines[] = $label . ': ' . $cost;
        }
        return implode("\n", $lines);
    } else {
        $label = isset($shipping_rate->label) ? $shipping_rate->label : 'Shipping';
        $cost  = isset($shipping_rate->cost) ? wc_price($shipping_rate->cost) : 'Free';
        return $label . ': ' . $cost;
    }
}, 10, 2);

// Total
add_filter('woocommerce_cart_total', function ($total) {
    // Chỉ giữ text và giá
    $total_text = strip_tags($total);
    return $total_text;
});

// Tắt link "Calculate shipping" và form điền postcode/city
add_filter('woocommerce_shipping_calculator_enable_city', '__return_false');
add_filter('woocommerce_shipping_calculator_enable_postcode', '__return_false');

// Tùy chọn vận chuyển (Shipping options) hiển thị text
add_filter('woocommerce_shipping_method_title', function ($title) {
    return strip_tags($title); // bỏ bất kỳ HTML nào
});


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
    if (!session_id()) {
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
            wp_safe_redirect(wc_get_cart_url());
            exit;
        }
    }
}
add_action('template_redirect', 'doAnCMS_add_to_cart_woo');
