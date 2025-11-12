<?php
if (!defined('ABSPATH')) exit;

// =======================
// Load CSS cho theme
// =======================
function doAnCMS_enqueue_styles() {
    // Base CSS: luôn load cho toàn site
    wp_enqueue_style('doAnCMS-base-style', get_stylesheet_uri(), array(), '1.0.1');

    // WooCommerce CSS
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

        // Product category page
        if (is_tax('product_cat')) {
            wp_enqueue_style(
                'taxonomy-product-cat',
                get_template_directory_uri() . '/taxonomy-product_cat.css',
                array('doAnCMS-woocommerce-style'),
                '1.0.1'
            );
        }
    }

    // Front page
    if (is_front_page()) {
        wp_enqueue_style(
            'doAnCMS-front-page-style',
            get_template_directory_uri() . '/front-page.css',
            array('doAnCMS-base-style'),
            '1.0.1'
        );
    }
}
add_action('wp_enqueue_scripts', 'doAnCMS_enqueue_styles', 99);

// =======================
// Theme setup
// =======================
function doAnCMS_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('woocommerce');

    register_nav_menus(array(
        'primary' => __('Main Menu', 'doAnCMS'),
    ));
}
add_action('after_setup_theme', 'doAnCMS_setup');

// =======================
// Related products args
// =======================
function doAnCMS_change_related_products_args($args) {
    $args['posts_per_page'] = 5;
    $args['columns'] = 5;
    return $args;
}
add_filter('woocommerce_output_related_products_args', 'doAnCMS_change_related_products_args', 20);

// =======================
// Sale badge CSS + functions
// =======================
add_action('wp_head', function () { ?>
<style>
.woocommerce ul.products li.product,
.product-card,
.product-thumb { position: relative; }
.custom-sale-badge {
    position: absolute;
    top: 10px; left: 10px;
    background: #e74c3c;
    color: #fff;
    padding: 5px 10px;
    border-radius: 5px;
    font-weight: bold;
    z-index: 10;
    box-shadow: 0 2px 5px rgba(0,0,0,.15);
}
.custom-sale-single {
    font-size: 16px;
    color: #e74c3c;
    margin-bottom: 10px;
}
</style>
<?php });

add_action('woocommerce_before_shop_loop_item_title', 'doAnCMS_show_sale_badge', 9);
function doAnCMS_show_sale_badge() {
    global $product;
    if (!$product || !$product->is_on_sale()) return;
    $regular_price = (float)$product->get_regular_price();
    $sale_price = (float)$product->get_sale_price();
    if ($regular_price > 0 && $sale_price > 0) {
        $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
        echo '<span class="custom-sale-badge">-' . esc_html($percentage) . '%</span>';
    }
}

add_action('woocommerce_single_product_summary', 'doAnCMS_show_sale_percentage_single', 6);
function doAnCMS_show_sale_percentage_single() {
    global $product;
    if (!$product || !$product->is_on_sale()) return;
    $regular_price = (float)$product->get_regular_price();
    $sale_price = (float)$product->get_sale_price();
    if ($regular_price > 0 && $sale_price > 0) {
        $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
        echo '<p class="custom-sale-single">Giảm <strong>-' . esc_html($percentage) . '%</strong></p>';
    }
}

// ===============================
// FORM LIÊN HỆ
// ===============================
add_action('admin_post_nopriv_submit_contact_form', 'handle_contact_form');
add_action('admin_post_submit_contact_form', 'handle_contact_form');
function handle_contact_form() {
    if (!isset($_POST['contact_form_nonce']) || !wp_verify_nonce($_POST['contact_form_nonce'], 'contact_form_action')) {
        wp_redirect(home_url('/contact/?status=error'));
        exit;
    }
    $name = sanitize_text_field($_POST['contact_name'] ?? '');
    $email = sanitize_email($_POST['contact_email'] ?? '');
    $message = sanitize_textarea_field($_POST['contact_message'] ?? '');
    if (empty($name) || empty($email) || empty($message)) {
        wp_redirect(home_url('/contact/?status=error'));
        exit;
    }
    $from_email = 'thanhdo062305@gmail.com';
    $to = $email;
    $subject = "Cảm ơn bạn đã liên hệ - Organic Food Shop";
    $body = "Xin chào {$name},\n\nCảm ơn bạn đã liên hệ với chúng tôi. Nội dung bạn gửi:\n\n{$message}\n\nTrân trọng,\nĐội ngũ Đô Web.";
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: Admin Organic Food Shop <' . $from_email . '>',
        'Reply-To: ' . $from_email,
    );
    wp_mail($to, $subject, $body, $headers);

    $admin_email = get_option('admin_email');
    $admin_subject = "Liên hệ mới từ {$name}";
    $admin_body = "Tên: {$name}\nEmail: {$email}\nNội dung:\n{$message}";
    $admin_headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: Employee Organic Food Shop <' . $from_email . '>',
        'Reply-To: ' . $email,
    );
    wp_mail($admin_email, $admin_subject, $admin_body, $admin_headers);

    wp_redirect(home_url('/contact/?status=success'));
    exit;
}

// ===============================
// Newsletter handlers
// ===============================
add_action('admin_post_nopriv_submit_newsletter_email', 'handle_newsletter_form');
add_action('admin_post_submit_newsletter_email', 'handle_newsletter_form');
function handle_newsletter_form() {
    if (!isset($_POST['newsletter_form_nonce']) || !wp_verify_nonce($_POST['newsletter_form_nonce'], 'newsletter_form_action')) {
        wp_redirect(home_url('/contact/?newsletter=invalid'));
        exit;
    }
    $email = sanitize_email($_POST['newsletter_email'] ?? '');
    if (!is_email($email)) {
        wp_redirect(home_url('/contact/?newsletter=invalid'));
        exit;
    }
    $emails = get_option('newsletter_subscribers', array());
    if (!in_array($email, $emails)) {
        $emails[] = $email;
        update_option('newsletter_subscribers', $emails);
    }
    wp_mail(get_option('admin_email'), 'Đăng ký nhận tin mới', "Email mới đăng ký: {$email}");
    wp_redirect(home_url('/contact/?newsletter=success'));
    exit;
}

// ===============================
// Gửi mail khi có sản phẩm mới
// ===============================
add_action('woocommerce_new_product', 'send_newsletter_on_new_product', 10, 1);
function send_newsletter_on_new_product($post_id) {
    $emails = get_option('newsletter_subscribers', array());
    if (empty($emails)) return;
    $product = wc_get_product($post_id);
    if (!$product) return;
    $product_name = $product->get_name();
    $product_link = get_permalink($post_id);
    $price = $product->get_sale_price() ?: $product->get_regular_price();
    $product_price = wc_price($price);
    $thumbnail = get_the_post_thumbnail_url($post_id, 'medium') ?: wc_placeholder_img_src('medium');
    $subject = "🛒 Sản phẩm mới: {$product_name}";
    $body = "
        <h2>Chào bạn,</h2>
        <p>Chúng tôi vừa thêm sản phẩm mới trong cửa hàng:</p>
        <div style='text-align:center;'>
            <img src='{$thumbnail}' alt='{$product_name}' style='max-width:250px;border-radius:8px;'>
        </div>
        <h3>{$product_name}</h3>
        <p>Giá: {$product_price}</p>
        <p><a href='{$product_link}' style='color:#6b9d3e;font-weight:bold;'>Xem chi tiết sản phẩm tại đây</a></p>
        <br>
        <p>Trân trọng,<br><strong>Đội ngũ Organic Food Shop</strong></p>
    ";
    $headers = array('Content-Type: text/html; charset=UTF-8');
    foreach ($emails as $email) {
        wp_mail($email, $subject, $body, $headers);
    }
}

// =======================
// Optional: Session start
// =======================
function doAnCMS_start_session() {
    if (!session_id()) session_start();
}
add_action('init', 'doAnCMS_start_session');

// =======================
// Thêm sản phẩm vào giỏ hàng qua URL
// =======================
function doAnCMS_add_to_cart_woo() {
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
