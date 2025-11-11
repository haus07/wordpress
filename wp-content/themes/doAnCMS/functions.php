<?php

// =======================
// Load CSS cho theme (ĐÃ SỬA)
// =======================
function doAnCMS_enqueue_styles()
{
    // Base CSS luôn load
    wp_enqueue_style(
        'doAnCMS-base-style',
        get_stylesheet_uri(),
        array(),
        '1.0.1'
    );

    // Category CSS
    if (is_tax('product_cat')) {
        wp_enqueue_style(
            'doAnCMS-category-style',
            get_template_directory_uri() . '/category.css',
            array('doAnCMS-base-style'),
            '1.0.1'
        );
    }

    // Front page CSS
    if (is_front_page()) {
        wp_enqueue_style(
            'doAnCMS-front-page-style',
            get_template_directory_uri() . '/front-page.css',
            array('doAnCMS-base-style'),
            '1.0.1'
        );
    }

    // Product detail page CSS (WooCommerce single product)
    if (is_singular('product')) {
        wp_enqueue_style(
            'doAnCMS-product-detail-style',
            get_stylesheet_directory_uri() . '/product-detail.css',
            array('doAnCMS-base-style'),
            '1.0.1'
        );
    }
}
add_action('wp_enqueue_scripts', 'doAnCMS_enqueue_styles');

function doAnCMS_change_related_products_args($args)
{

    // 1. Yêu cầu lấy 5 sản phẩm
    $args['posts_per_page'] = 5;

    // 2. Báo cho WooCommerce biết là mình sẽ chia 5 cột
    // (Để nó thêm class 'last' cho sản phẩm thứ 5)
    $args['columns'] = 5;

    return $args;
}
add_filter('woocommerce_output_related_products_args', 'doAnCMS_change_related_products_args', 20);

// =======================
// Khai báo các hỗ trợ của theme (Giữ nguyên)
// =======================
function doAnCMS_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    // **Thêm WooCommerce support**
    add_theme_support('woocommerce');

    register_nav_menus(array(
        'primary' => __('Main Menu', 'doAnCMS'),
    ));
}
add_action('after_setup_theme', 'doAnCMS_setup');
// Giảm giá (sales)
// =======================
// Hiển thị phần trăm giảm giá trên sản phẩm WooCommerce
// =======================

// Hiển thị badge ở trang danh sách sản phẩm (shop, category)
add_action('woocommerce_before_shop_loop_item_title', 'doAnCMS_show_sale_badge', 9);
function doAnCMS_show_sale_badge()
{
    global $product;

    if (!$product || !$product->is_on_sale()) return;

    $regular_price = (float) $product->get_regular_price();
    $sale_price    = (float) $product->get_sale_price();

    if ($regular_price > 0 && $sale_price > 0) {
        $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
        echo '<span class="custom-sale-badge">-' . esc_html($percentage) . '%</span>';
    }
}

// Hiển thị badge ở trang chi tiết sản phẩm
add_action('woocommerce_single_product_summary', 'doAnCMS_show_sale_percentage_single', 6);
function doAnCMS_show_sale_percentage_single()
{
    global $product;

    if (!$product || !$product->is_on_sale()) return;

    $regular_price = (float) $product->get_regular_price();
    $sale_price    = (float) $product->get_sale_price();

    if ($regular_price > 0 && $sale_price > 0) {
        $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
        echo '<p class="custom-sale-single">Giảm <strong>-' . esc_html($percentage) . '%</strong></p>';
    }
}

// Thêm CSS badge hiển thị góc ảnh
add_action('wp_head', function () {
?>
    <style>
        .woocommerce ul.products li.product,
        .product-card,
        .product-thumb {
            position: relative;
        }

        .custom-sale-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #e74c3c;
            color: white;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
            z-index: 10;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        }

        .custom-sale-single {
            font-size: 16px;
            color: #e74c3c;
            margin-bottom: 10px;
        }
    </style>
<?php
    // ==========================
    // HANDLE CONTACT FORM
    // ==========================
    function handle_contact_form()
    {
        if (isset($_POST['contact_name'], $_POST['contact_email'], $_POST['contact_message'])) {
            $name    = sanitize_text_field($_POST['contact_name']);
            $email   = sanitize_email($_POST['contact_email']);
            $message = sanitize_textarea_field($_POST['contact_message']);

            $to      = get_option('admin_email'); // gửi về email admin
            $subject = "Liên hệ từ $name";
            $body    = "Tên: $name\nEmail: $email\n\nTin nhắn:\n$message";
            $headers = array('Content-Type: text/plain; charset=UTF-8', "From: $name <$email>");

            wp_mail($to, $subject, $body, $headers);

            // Redirect về lại trang trước với query param thankyou
            wp_redirect(add_query_arg('contact', 'success', wp_get_referer()));
            exit;
        }
    }
    add_action('admin_post_nopriv_submit_contact_form', 'handle_contact_form');
    add_action('admin_post_submit_contact_form', 'handle_contact_form');


    // ==========================
    // HANDLE NEWSLETTER FORM
    // ==========================
    function handle_newsletter_email()
    {
        if (isset($_POST['newsletter_email'])) {
            $email = sanitize_email($_POST['newsletter_email']);

            $to      = get_option('admin_email'); // gửi về email admin
            $subject = "Đăng ký nhận tin mới";
            $body    = "Email đăng ký nhận tin: $email";
            $headers = array('Content-Type: text/plain; charset=UTF-8');

            wp_mail($to, $subject, $body, $headers);

            // Redirect về lại trang trước với query param newsletter
            wp_redirect(add_query_arg('newsletter', 'success', wp_get_referer()));
            exit;
        }
    }
    add_action('admin_post_nopriv_submit_newsletter_email', 'handle_newsletter_email');
    add_action('admin_post_submit_newsletter_email', 'handle_newsletter_email');


    // ==========================
    // OPTIONAL: DISPLAY SUCCESS MESSAGE
    // ==========================
    function display_form_success_message()
    {
        if (isset($_GET['contact']) && $_GET['contact'] === 'success') {
            echo '<div class="form-success" style="max-width:1200px;margin:20px auto;padding:10px 15px;background:#d4edda;color:#155724;border:1px solid #c3e6cb;border-radius:8px;text-align:center;">Cảm ơn bạn! Chúng tôi đã nhận được liên hệ của bạn.</div>';
        }
        if (isset($_GET['newsletter']) && $_GET['newsletter'] === 'success') {
            echo '<div class="form-success" style="max-width:1200px;margin:20px auto;padding:10px 15px;background:#d1ecf1;color:#0c5460;border:1px solid #bee5eb;border-radius:8px;text-align:center;">Bạn đã đăng ký nhận tin thành công!</div>';
        }
    }
    add_action('wp_footer', 'display_form_success_message');
});
