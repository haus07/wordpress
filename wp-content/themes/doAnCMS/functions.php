<?php

if (!defined('ABSPATH')) exit;

// =======================
// Load CSS cho theme
// =======================
function doAnCMS_enqueue_styles()
{
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

add_action('wp_enqueue_scripts', 'doAnCMS_enqueue_wishlist');
function doAnCMS_enqueue_wishlist()
{
    wp_enqueue_script(
        'doAnCMS-wishlist',
        get_template_directory_uri() . '/assets/js/wishlist.js',
        ['jquery'],
        false,
        true
    );

    wp_localize_script('doAnCMS-wishlist', 'wp_ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
    ]);
}

// Load CSS riêng cho template blog
function doAnCMS_enqueue_blog_styles()
{
    if (is_page_template('blog-template.php')) {
        wp_enqueue_style(
            'doAnCMS-blog-style',
            get_stylesheet_directory_uri() . '/blog.css',
            array('doAnCMS-base-style'),
            '1.0.0'
        );
    }
}
add_action('wp_enqueue_scripts', 'doAnCMS_enqueue_blog_styles');

// =======================
// Theme setup
// =======================
function doAnCMS_setup()
{
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
function doAnCMS_change_related_products_args($args)
{
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
        .product-thumb {
            position: relative;
        }

        .custom-sale-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #e74c3c;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            z-index: 10;
            box-shadow: 0 2px 5px rgba(0, 0, 0, .15);
        }

        .custom-sale-single {
            font-size: 16px;
            color: #e74c3c;
            margin-bottom: 10px;
        }
    </style>
<?php });

add_action('woocommerce_before_shop_loop_item_title', 'doAnCMS_show_sale_badge', 9);
function doAnCMS_show_sale_badge()
{
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
function doAnCMS_show_sale_percentage_single()
{
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
function handle_contact_form()
{
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
function handle_newsletter_form()
{
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
function send_newsletter_on_new_product($post_id)
{
    $emails = get_option('newsletter_subscribers', array());
    if (empty($emails)) return;
    $product = wc_get_product($post_id);
    add_action('transition_post_status', 'send_newsletter_on_new_product', 10, 3);
    function send_newsletter_on_new_product($new_status, $old_status, $post)
    {
        // Chỉ xử lý với post type product
        if ($post->post_type !== 'product') return;

        // Chỉ gửi mail khi sản phẩm mới được publish (từ draft/pending → publish)
        if ($new_status !== 'publish' || $old_status === 'publish') return;

        // Delay 5 giây để đảm bảo metadata đã được lưu
        wp_schedule_single_event(time() + 5, 'send_newsletter_delayed', [$post->ID]);
    }

    add_action('send_newsletter_delayed', 'send_newsletter_on_new_product_delayed');
    function send_newsletter_on_new_product_delayed($product_id)
    {
        $product = wc_get_product($product_id);
        if (!$product) return;

        $emails = get_option('newsletter_subscribers', []);
        if (empty($emails)) return;

        $product_name = $product->get_name();
        $product_link = get_permalink($product_id);

        $price = $product->get_sale_price();
        if (!$price) {
            $price = $product->get_regular_price();
        }
        $product_price = $price ? wc_price($price) : 'Liên hệ';

        // Lấy hình ảnh và tối ưu
        $image_tag = '';
        $image_id = $product->get_image_id();

        if ($image_id) {
            // Lấy thumbnail size thay vì medium để nhẹ hơn
            $image_data_array = wp_get_attachment_image_src($image_id, 'thumbnail'); // 150x150

            if (!$image_data_array) {
                // Fallback sang medium nếu không có thumbnail
                $image_data_array = wp_get_attachment_image_src($image_id, 'medium');
            }

            if ($image_data_array) {
                $image_url = $image_data_array[0];
                $upload_dir = wp_upload_dir();
                $image_path = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $image_url);

                // Đổi dấu / thành \ cho Windows
                $image_path = str_replace('/', DIRECTORY_SEPARATOR, $image_path);

                if (file_exists($image_path)) {
                    $image_data = file_get_contents($image_path);

                    // Nếu file vẫn lớn hơn 50KB, nén thêm bằng GD
                    if (strlen($image_data) > 51200) {
                        $image_data = optimize_image_for_email($image_path);
                    }

                    if ($image_data) {
                        $finfo = finfo_open(FILEINFO_MIME_TYPE);
                        $mime_type = finfo_file($finfo, $image_path);
                        finfo_close($finfo);

                        $base64_image = base64_encode($image_data);
                        $image_tag = "<img src='data:{$mime_type};base64,{$base64_image}' alt='{$product_name}' style='max-width:250px;height:auto;border-radius:8px;display:block;margin:0 auto;' />";

                        error_log('Base64 length: ' . strlen($base64_image) . ' characters');
                    }
                }
            }
        }

        // Fallback placeholder
        if (!$image_tag) {
            $image_tag = "<div style='background:#f0f0f0;padding:60px 20px;border-radius:8px;text-align:center;color:#999;'>📦 Không có hình ảnh</div>";
        }

        $subject = "🛒 Sản phẩm mới: {$product_name}";

        $body = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
        </head>
        <body style='font-family:Arial,sans-serif;background:#f5f5f5;padding:20px;'>
            <div style='max-width:600px;margin:0 auto;background:#fff;padding:30px;border-radius:10px;box-shadow:0 2px 4px rgba(0,0,0,0.1);'>
                <h2 style='color:#6b9d3e;margin-top:0;'>Chào bạn,</h2>
                <p style='color:#666;line-height:1.6;'>Sản phẩm mới đã được thêm vào cửa hàng:</p>
                <div style='text-align:center;margin:30px 0;'>
                    {$image_tag}
                </div>
                <h3 style='text-align:center;color:#333;margin:20px 0;'>{$product_name}</h3>
                <p style='text-align:center;font-size:24px;color:#6b9d3e;font-weight:bold;margin:15px 0;'>
                    {$product_price}
                </p>
                <p style='text-align:center;margin:30px 0;'>
                    <a href='{$product_link}' style='background:#6b9d3e;color:#fff;padding:15px 40px;text-decoration:none;border-radius:5px;display:inline-block;font-weight:bold;'>Xem chi tiết sản phẩm</a>
                </p>
                <hr style='border:none;border-top:1px solid #eee;margin:30px 0;'>
                <p style='color:#999;font-size:14px;text-align:center;margin:0;'>
                    Trân trọng,<br>
                    <strong style='color:#6b9d3e;'>Organic Food Shop</strong>
                </p>
            </div>
        </body>
        </html>
    ";

        $headers = ['Content-Type: text/html; charset=UTF-8'];

        foreach ($emails as $email) {
            wp_mail($email, $subject, $body, $headers);
        }
    }
}

// Hàm tối ưu hình ảnh
function optimize_image_for_email($image_path)
{
    $info = getimagesize($image_path);

    if (!$info) return false;

    $mime_type = $info['mime'];

    // Tạo image resource
    switch ($mime_type) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($image_path);
            break;
        case 'image/png':
            $image = imagecreatefrompng($image_path);
            break;
        case 'image/gif':
            $image = imagecreatefromgif($image_path);
            break;
        default;
    }
}

// =======================
// Optional: Session start
// =======================
function doAnCMS_start_session()
{
    if (!session_id()) session_start();
}
add_action('init', 'doAnCMS_start_session');

// =======================
// Thêm sản phẩm vào giỏ hàng qua URL
// =======================
function doAnCMS_add_to_cart_woo()
{
    // Chỉ thực hiện khi là trang WooCommerce (shop, single product) và có add_to_cart
    if (isset($_GET['add_to_cart']) && is_woocommerce()) {
        $product_id = intval($_GET['add_to_cart']);
        if ($product_id > 0) {
            WC()->cart->add_to_cart($product_id);
            // Chỉ redirect khi thêm thành công
            wp_safe_redirect(wc_get_cart_url());
            exit;
        }
    }
}
add_action('template_redirect', 'doAnCMS_add_to_cart_woo');

// =======================
// Shortcode hiển thị bài viết gần đây
// =======================
function doAnCMS_recent_posts_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'posts' => 6,
    ), $atts, 'recent-posts');

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    $query = new WP_Query(array(
        'post_type'      => 'post',
        'posts_per_page' => intval($atts['posts']),
        'paged'          => $paged,
    ));

    $output = '<div class="doAnCMS-blog-list" style="display:grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap:30px;">';

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $thumbnail = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'full') : 'https://via.placeholder.com/400x250?text=No+Image';
            $output .= '<div class="doAnCMS-blog-item" style="border:1px solid #eee; border-radius:10px; overflow:hidden; box-shadow:0 4px 8px rgba(0,0,0,0.1); transition: transform 0.3s;">';
            $output .= '<a href="' . get_permalink() . '"><img src="' . $thumbnail . '" alt="' . get_the_title() . '" style="width:100%; height:200px; object-fit:cover;"></a>';
            $output .= '<div style="padding:15px;">';
            $output .= '<h3 style="margin-bottom:10px;"><a href="' . get_permalink() . '" style="text-decoration:none; color:#333;">' . get_the_title() . '</a></h3>';
            $output .= '<p style="color:#666; font-size:14px;">' . wp_trim_words(get_the_content(), 25) . '</p>';
            $output .= '<a href="' . get_permalink() . '" style="display:inline-block; margin-top:10px; color:#6b9d3e; font-weight:bold;">Xem thêm →</a>';
            $output .= '</div></div>';
        }

        $output .= '<div class="doAnCMS-pagination" style="grid-column:1/-1; text-align:center;">';
        $output .= paginate_links(array(
            'total' => $query->max_num_pages,
        ));
        $output .= '</div>';

        wp_reset_postdata();
    } else {
        $output .= '<p>Chưa có bài viết nào.</p>';
    }

    $output .= '</div>';
    return $output;
}

add_shortcode('recent-posts', 'doAnCMS_recent_posts_shortcode');
// Slide
function theme_enqueue_swiper()
{
    // CSS
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');

    // JS
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], false, true);
}
add_action('wp_enqueue_scripts', 'theme_enqueue_swiper');
// Phân trang
add_action('pre_get_posts', function ($query) {
    if (!is_admin() && $query->is_main_query() && is_tax('product_cat')) {
        $query->set('posts_per_page', 5);
    }
});


add_action('wp_ajax_load_product_quick_view', 'doAnCMS_load_product_quick_view');
add_action('wp_ajax_nopriv_load_product_quick_view', 'doAnCMS_load_product_quick_view');

// 2. HÀM XỬ LÝ - THAY THẾ TOÀN BỘ HÀM NÀY
function doAnCMS_load_product_quick_view()
{
    // 1. Kiểm tra ID (An toàn)
    if (!isset($_POST['product_id']) || empty($_POST['product_id'])) {
        echo '<p>Sản phẩm không hợp lệ.</p>';
        wp_die();
    }

    $product_id = intval($_POST['product_id']);
    $product = wc_get_product($product_id); // Lấy object an toàn

    if (!$product) {
        echo '<p>Sản phẩm không hợp lệ hoặc không tìm thấy.</p>';
        wp_die();
    }

    // 2. TUI ĐÃ XÓA SẠCH:
    // - global $post
    // - setup_postdata($post)
    // -> Đây chính là 2 dòng gây lỗi "critical error".
    // -> Mình sẽ không đụng đến global state nữa.

    // 3. Bắt đầu "bắt" HTML
    ob_start();
?>

    <div class="product">

        <div class="woocommerce-product-gallery">
            <?php echo $product->get_image('woocommerce_single'); ?>
        </div>

        <div class="summary entry-summary">
            <?php
            // Hiển thị tên (An toàn)
            echo '<h1 class="product_title entry-title">' . esc_html($product->get_name()) . '</h1>';

            // Hiển thị giá (An toàn)
            echo '<p class="price">' . $product->get_price_html() . '</p>';

            // Hiển thị mô tả ngắn (An toàn)
            echo '<div class="woocommerce-product-details__short-description">';
            echo $product->get_short_description();
            echo '</div>';

            // =======================================================
            // === SỬA LỖI NÚT BẤM (Không dùng hàm phức tạp) ===
            // =======================================================

            // Kiểm tra loại sản phẩm (An toàn)
            if ($product->is_type('simple') && $product->is_in_stock() && $product->is_purchasable()) {

                // 1. NẾU LÀ SẢN PHẨM ĐƠN (SIMPLE)
                // Dùng link AJAX an toàn + Text tự gõ (hardcode)
            ?>
                <a href="<?php echo esc_url($product->add_to_cart_url()); ?>"
                    value="<?php echo esc_attr($product->get_id()); ?>" class="button alt ajax_add_to_cart add_to_cart_button"
                    data-product_id="<?php echo esc_attr($product->get_id()); ?>" data-quantity="1" rel="nofollow">
                    🛒 Thêm vào giỏ hàng </a>
            <?php

            } else {

                // 2. NẾU LÀ SẢN PHẨM CÓ BIẾN THỂ (VARIABLE) hoặc loại khác
                // Dùng link permalink (An toàn)
                $button_text = 'Xem chi tiết';
                if ($product->is_type('variable')) {
                    $button_text = 'Tuỳ chọn'; // Text cho SP biến thể
                }

            ?>
                <a href="<?php echo esc_url($product->get_permalink()); ?>" class="button alt">
                    <?php echo esc_html($button_text); ?>
                </a>
            <?php
            }
            ?>
        </div>
    </div>

    <?php
    // Lấy HTML đã "bắt" và dọn dẹp
    $html = ob_get_clean();

    // Trả HTML về cho AJAX
    echo $html;

    // 4. TUI ĐÃ XÓA: wp_reset_postdata() (Vì không setup nên không cần reset)
    wp_die(); // Luôn kết thúc bằng wp_die() trong AJAX
}

// 2. Ghi đè CSS của WooCommerce
// Khi load content-single-product.php, nó sẽ có layout 2 cột.
// Mình cần CSS lại để nó vừa trong modal.
add_action('wp_head', function () {
    // Chỉ load CSS này ở trang chủ (nơi có modal)
    if (is_front_page()) { ?>

        <!-- 
======================================================
=== CSS "TÚT LẠI" CHO QUICK VIEW (CHO ĐẸP HƠN) ===
=== Bro THAY THẾ TOÀN BỘ style cũ bằng cái này ===
====================================================== 
-->
        <style>
            /* 1. Layout 2 cột (Giữ nguyên) */
            #quick-view-content-wrapper .product {
                display: grid;
                grid-template-columns: 1fr;
                /* 1 cột mobile */
                gap: 20px;
                padding: 30px;
                /* Tăng padding cho "thở" */
            }

            @media (min-width: 600px) {
                #quick-view-content-wrapper .product {
                    grid-template-columns: 1fr 1fr;
                    /* 2 cột desktop */
                    gap: 30px;
                }
            }

            /* 2. Tút lại CỘT HÌNH ẢNH (Bo góc) */
            #quick-view-content-wrapper .woocommerce-product-gallery {
                border-radius: 10px;
                overflow: hidden;
                /* Bo góc cho ảnh */
                border: 1px solid #eee;
            }

            #quick-view-content-wrapper .woocommerce-product-gallery img {
                width: 100%;
                height: auto;
                display: block;
                /* Bỏ khoảng trống thừa */
            }

            /* 3. Tút lại CỘT NỘI DUNG */
            #quick-view-content-wrapper .product .summary {
                display: flex;
                flex-direction: column;
                /* Sắp xếp nội dung */
            }

            /* 4. Tút lại TÊN SẢN PHẨM */
            #quick-view-content-wrapper .product .summary .product_title {
                font-size: 24px;
                /* Giảm size cho hợp popup */
                line-height: 1.3;
                margin-bottom: 10px;
                color: #333;
            }

            /* 5. Tút lại GIÁ (nổi bật) */
            #quick-view-content-wrapper .product .summary .price {
                font-size: 22px;
                font-weight: bold;
                color: #6b9d3e;
                /* Màu xanh theme */
                margin-bottom: 15px;
            }

            /* 6. Tút lại MÔ TẢ NGẮN */
            #quick-view-content-wrapper .product .summary .woocommerce-product-details__short-description {
                font-size: 15px;
                line-height: 1.6;
                color: #555;
                margin-bottom: 20px;
                padding-bottom: 20px;
                border-bottom: 1px solid #f0f0f0;
                /* Thêm 1 đường kẻ mờ */
                flex-grow: 1;
                /* Đẩy nút bấm xuống dưới */
            }

            /* 7. Tút lại NÚT BẤM (Xịn hơn) */
            #quick-view-content-wrapper .product .summary .cart {
                margin-top: 0;
                /* Bỏ margin-top cũ vì đã có border */
            }

            #quick-view-content-wrapper .product .summary .button {
                width: 100%;
                padding: 14px !important;
                /* To hơn 1 chút */
                font-size: 16px !important;
                font-weight: bold !important;
                background-color: #6b9d3e !important;
                color: #fff !important;
                border: none !important;
                border-radius: 5px !important;
                /* Bo góc */
                cursor: pointer;
                transition: all 0.3s ease;
                text-align: center !important;
                /* 1. Căn giữa chữ */
                text-decoration: none !important;
            }

            #quick-view-content-wrapper .product .summary .button:hover {
                background-color: #557c2a !important;
                transform: translateY(-2px);
                /* Hiệu ứng 3D */
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            }
        </style>
    <?php }
});


function my_custom_add_to_cart_text($text, $product)
{
    if ($product->is_type('variable')) {
        return __('Tuỳ chọn', 'html_cms'); // Chữ cho sản phẩm có biến thể
    }

    if ($product->is_type('simple')) {
        return __('Thêm vào giỏ hàng', 'html_cms'); // Chữ cho sản phẩm đơn
    }

    return $text; // Giữ nguyên cho các loại khác
}
add_filter('woocommerce_product_add_to_cart_text', 'my_custom_add_to_cart_text', 10, 2);



function html_cms_widgets_init()
{
    register_sidebar(array(
        'name'          => esc_html__('Shop Sidebar', 'html_cms'),
        'id'            => 'shop-sidebar',
        'description'   => esc_html__('Thêm các widget lọc sản phẩm vào đây.', 'html_cms'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'html_cms_widgets_init');

// // =========================
// // AJAX LIVE SEARCH PRODUCT
// // =========================
add_action('wp_ajax_live_search', 'live_search_handler');
add_action('wp_ajax_nopriv_live_search', 'live_search_handler');

function live_search_handler()
{
    $keyword = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';

    if (empty($keyword)) {
        wp_send_json([]);
    }

    $args = [
        'post_type'      => 'product',
        'posts_per_page' => 8,
        's'              => $keyword,
        'post_status'    => 'publish'
    ];

    $query = new WP_Query($args);
    $results = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $product = wc_get_product(get_the_ID());

            $results[] = [
                'title' => get_the_title(),
                'url'   => get_permalink(),
                'price' => $product ? $product->get_price_html() : '',
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail')
            ];
        }
        wp_reset_postdata();
    }

    wp_send_json($results);
}

function doancms_enqueue_custom_cart_style()
{
    // QUAN TRỌNG: Kiểm tra xem user có đang ở đúng trang dùng template 'page-cart.php' không
    if (is_page_template('page-cart.php')) {

        // Đường dẫn đến file CSS bro vừa tạo
        // get_template_directory_uri() trỏ về thư mục theme hiện tại
        wp_enqueue_style(
            'doancms-cart-css', // Handle name (đặt tên gì cũng dc, miễn là duy nhất)
            get_template_directory_uri() . '/custom-cart.css', // Đường dẫn file
            array(), // Dependencies (không có thì để mảng rỗng)
            '1.0.0' // Version
        );
    }
}
add_action('wp_enqueue_scripts', 'doancms_enqueue_custom_cart_style');

function doancms_enqueue_custom_checkout_style()
{
    // QUAN TRỌNG: Kiểm tra xem user có đang ở đúng trang dùng template 'page-cart.php' không
    if (is_page_template('page-checkout.php')) {

        // Đường dẫn đến file CSS bro vừa tạo
        // get_template_directory_uri() trỏ về thư mục theme hiện tại
        wp_enqueue_style(
            'doancms-cart-css', // Handle name (đặt tên gì cũng dc, miễn là duy nhất)
            get_template_directory_uri() . '/custom-checkout.css', // Đường dẫn file
            array(), // Dependencies (không có thì để mảng rỗng)
            '1.0.0' // Version
        );
    }
}
add_action('wp_enqueue_scripts', 'doancms_enqueue_custom_checkout_style');


/* * DI CHUYỂN Ô COUPON TRONG TRANG CHECKOUT
 * Xóa ở trên đầu -> Chuyển xuống trước nút thanh toán
 */
// 1. Xóa coupon ở vị trí mặc định (trên cùng)
remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);

// 2. Thêm vào vị trí mới (Trước phần chọn phương thức thanh toán)
add_action('woocommerce_review_order_before_payment', 'woocommerce_checkout_coupon_form');


// HARD BLOCK: Chặn toàn bộ HTML notices của WooCommerce trước khi in ra
add_action('template_redirect', function () {
    ob_start(function ($buffer) {

        // Xóa các wrapper lỗi của WooCommerce
        $patterns = [
            '/<div class="woocommerce-error">(.*?)<\/div>/s',
            '/<ul class="woocommerce-error">(.*?)<\/ul>/s',
            '/<div class="woocommerce-message">(.*?)<\/div>/s',
            '/<div class="woocommerce-notices-wrapper">(.*?)<\/div>/s'
        ];

        return preg_replace($patterns, '', $buffer);
    });
});



/*
 * Redirect sang trang 'cam-on' sau khi thanh toán thành công
 */
/*
 * Redirect CHUẨN sang trang Cảm ơn tùy chỉnh + Kèm theo Order ID
 * Dán đè code cũ trong functions.php
 */
add_filter('woocommerce_payment_successful_result', 'custom_redirect_with_order_id', 10, 2);

function custom_redirect_with_order_id($result, $order_id)
{

    // 1. Lấy đối tượng đơn hàng để đảm bảo nó tồn tại và lấy key bảo mật
    $order = wc_get_order($order_id);

    if (! $order) {
        // Nếu lỗi không lấy được đơn thì về trang chủ cho an toàn
        $result['redirect'] = home_url();
        return $result;
    }

    // 2. Thay '/cam-on/' bằng đúng slug trang của bro
    // Chúng ta thêm tham số order_id và key vào URL để bảo mật
    $thankyou_url = home_url('/cam-on/');

    $final_url = add_query_arg(array(
        'order_id' => $order_id,
        'key'      => $order->get_order_key(), // Thêm key để người khác không đoán mò được ID đơn hàng
    ), $thankyou_url);

    $result['redirect'] = $final_url;

    return $result;
}


/**
 * Chỉnh sửa số lượng sản phẩm liên quan (Related Products)
 */
function my_custom_related_products_args($args)
{
    $args['posts_per_page'] = 4; // Số lượng sản phẩm hiển thị (để 4 cho đẹp 1 hàng)
    $args['columns']        = 4; // Số cột (khai báo cho Woo biết)
    return $args;
}
add_filter('woocommerce_output_related_products_args', 'my_custom_related_products_args', 20);

// =========================
// VIEW COUNT
// =========================

// Tăng view mỗi lần truy cập single
function deluxe_set_post_views($postID)
{
    $count_key = 'post_view_count';
    $count = get_post_meta($postID, $count_key, true);

    if ($count == '') {
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, 1);
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

// Lấy số view
function deluxe_get_post_views($postID)
{
    $count_key = 'post_view_count';
    $count = get_post_meta($postID, $count_key, true);

    if ($count == '') {
        return 0;
    }
    return $count;
}

// Auto tăng view khi vào bài viết
function deluxe_count_views_single()
{
    if (is_single()) {
        $post_id = get_the_ID();
        deluxe_set_post_views($post_id);
    }
}
add_action('wp_head', 'deluxe_count_views_single');

// ===== CUSTOM POST TYPE: FAQ =====
function create_faq_post_type()
{
    $labels = array(
        'name'               => 'FAQs',
        'singular_name'      => 'FAQ',
        'menu_name'          => 'FAQ Center',
        'name_admin_bar'     => 'FAQ',
        'add_new'            => 'Thêm câu hỏi',
        'add_new_item'       => 'Thêm câu hỏi mới',
        'edit_item'          => 'Sửa câu hỏi',
        'new_item'           => 'Câu hỏi mới',
        'view_item'          => 'Xem câu hỏi',
        'search_items'       => 'Tìm câu hỏi',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'menu_icon'          => 'dashicons-editor-help',
        'supports'           => array('title', 'editor'),
        'has_archive'        => false,
        'rewrite'            => array('slug' => 'faq'),
        'show_in_rest'       => true, // GutenBerg support
    );

    register_post_type('faq', $args);
}
add_action('init', 'create_faq_post_type');

// ===== TAXONOMY FOR FAQ =====
function faq_register_taxonomy()
{
    $labels = array(
        'name'              => 'FAQ Categories',
        'singular_name'     => 'FAQ Category',
        'search_items'      => 'Tìm category',
        'all_items'         => 'Tất cả category',
        'edit_item'         => 'Sửa category',
        'add_new_item'      => 'Thêm category mới',
        'menu_name'         => 'FAQ Category',
    );

    $args = array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'rewrite'           => array('slug' => 'faq-category'),
        'show_in_rest'      => true,
    );

    register_taxonomy('faq_category', array('faq'), $args);
}
add_action('init', 'faq_register_taxonomy');

add_action('wp_ajax_faq_search', 'faq_search_ajax');
add_action('wp_ajax_nopriv_faq_search', 'faq_search_ajax');

function faq_search_ajax()
{
    if (!isset($_GET['keyword'])) {
        wp_send_json([]);
        wp_die();
    }

    $keyword = sanitize_text_field($_GET['keyword']);
    $faq_cat = isset($_GET['faq_cat']) ? sanitize_text_field($_GET['faq_cat']) : '';

    $args = [
        'post_type' => 'faq',
        'posts_per_page' => 5, // hiển thị 5 gợi ý
        's' => $keyword
    ];

    if ($faq_cat) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'faq_category',
                'field'    => 'slug',
                'terms'    => $faq_cat
            ]
        ];
    }

    $query = new WP_Query($args);
    $results = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $results[] = [
                'title' => get_the_title(),
                'link'  => get_permalink()
            ];
        }
    }

    wp_reset_postdata();
    wp_send_json($results);
}
// Wishtlist
add_action('woocommerce_after_add_to_cart_button', 'doAnCMS_add_wishlist_button');

function doAnCMS_add_wishlist_button()
{
    echo '<button class="doAnCMS-wishlist-btn" data-product-id="' . get_the_ID() . '">
            ♥ Add to Wishlist
          </button>';
}
// AJAX thêm sản phẩm vào wishlist
add_action('wp_ajax_doAddToWishlist', 'doAddToWishlist');
add_action('wp_ajax_nopriv_doAddToWishlist', 'doAddToWishlist_guest');

function doAddToWishlist()
{
    $product_id = intval($_POST['product_id']);
    $user_id = get_current_user_id();

    if (!$user_id) {
        wp_send_json_error(['message' => 'Bạn cần đăng nhập để dùng wishlist.']);
    }

    $wishlist = get_user_meta($user_id, '_doAnCMS_wishlist', true);
    if (!is_array($wishlist)) $wishlist = [];

    if (!in_array($product_id, $wishlist)) {
        $wishlist[] = $product_id;
        update_user_meta($user_id, '_doAnCMS_wishlist', $wishlist);
    }

    wp_send_json_success(['message' => 'Đã thêm vào wishlist!']);
}
/**
 * Thêm nút Wishlist vào loop sản phẩm (shop/category/archive)
 */
add_action('woocommerce_after_shop_loop_item', 'doAnCMS_add_wishlist_button_archive', 15);

function doAnCMS_add_wishlist_button_archive()
{
    global $product;

    echo '<button class="doAnCMS-wishlist-btn-archive" 
                  data-product-id="' . esc_attr($product->get_id()) . '" 
                  style="
                      background: transparent;
                      border: 2px solid #e74c3c;
                      color: #e74c3c;
                      padding: 8px 15px;
                      cursor: pointer;
                      border-radius: 5px;
                      margin-top: 10px;
                      transition: all 0.3s;
                      font-size: 14px;
                      width: 100%;
                  "
                  onmouseover="this.style.background=\'#e74c3c\'; this.style.color=\'white\';"
                  onmouseout="this.style.background=\'transparent\'; this.style.color=\'#e74c3c\';">
        ♥ Add to Wishlist
    </button>';
}


// Guest user: Lưu tạm bằng cookie
function doAddToWishlist_guest()
{
    $product_id = intval($_POST['product_id']);

    $cookie = isset($_COOKIE['doAnCMS_wishlist']) ? explode(',', $_COOKIE['doAnCMS_wishlist']) : [];

    if (!in_array($product_id, $cookie)) {
        $cookie[] = $product_id;
    }

    setcookie('doAnCMS_wishlist', implode(',', $cookie), time() + 3600 * 24 * 30, '/');

    wp_send_json_success(['message' => 'Đã lưu tạm wishlist (khách).']);
}

// AJAX xóa sản phẩm khỏi wishlist
add_action('wp_ajax_doRemoveFromWishlist', 'doRemoveFromWishlist');
add_action('wp_ajax_nopriv_doRemoveFromWishlist', 'doRemoveFromWishlist_guest');

function doRemoveFromWishlist()
{
    $product_id = intval($_POST['product_id']);
    $user_id = get_current_user_id();

    if (!$user_id) {
        wp_send_json_error(['message' => 'Bạn cần đăng nhập.']);
    }

    $wishlist = get_user_meta($user_id, '_doAnCMS_wishlist', true);
    if (!is_array($wishlist)) $wishlist = [];

    $wishlist = array_diff($wishlist, [$product_id]);
    update_user_meta($user_id, '_doAnCMS_wishlist', $wishlist);

    wp_send_json_success(['message' => 'Đã xóa khỏi wishlist!']);
}

function doRemoveFromWishlist_guest()
{
    $product_id = intval($_POST['product_id']);
    $cookie = isset($_COOKIE['doAnCMS_wishlist']) ? explode(',', $_COOKIE['doAnCMS_wishlist']) : [];

    $cookie = array_diff($cookie, [$product_id]);
    setcookie('doAnCMS_wishlist', implode(',', $cookie), time() + 3600 * 24 * 30, '/');

    wp_send_json_success(['message' => 'Đã xóa (khách).']);
}

add_action('wp_footer', 'doAnCMS_wishlist_archive_script');

function doAnCMS_wishlist_archive_script()
{
    ?>
    <script>
        jQuery(document).ready(function($) {
            // Xử lý click nút wishlist trên trang shop/archive
            $(document).on('click', '.doAnCMS-wishlist-btn-archive', function(e) {
                e.preventDefault();

                var btn = $(this);
                var productId = btn.data('product-id');
                var originalText = btn.html();

                // Disable button tạm thời
                btn.prop('disabled', true).html('⏳ Đang thêm...');

                $.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'POST',
                    data: {
                        action: '<?php echo is_user_logged_in() ? 'doAddToWishlist' : 'doAddToWishlist_guest'; ?>',
                        product_id: productId
                    },
                    success: function(response) {
                        if (response.success) {
                            btn.html('✓ Đã thêm!').css({
                                'background': '#27ae60',
                                'color': 'white',
                                'border-color': '#27ae60'
                            });

                            // Reset sau 2 giây
                            setTimeout(function() {
                                btn.prop('disabled', false)
                                    .html(originalText)
                                    .css({
                                        'background': 'transparent',
                                        'color': '#e74c3c',
                                        'border-color': '#e74c3c'
                                    });
                            }, 2000);
                        } else {
                            alert(response.data.message);
                            btn.prop('disabled', false).html(originalText);
                        }
                    },
                    error: function() {
                        alert('Có lỗi xảy ra!');
                        btn.prop('disabled', false).html(originalText);
                    }
                });
            });
        });
    </script>
<?php
}


/**
 * Enqueue CSS riêng cho trang View Order (Chi tiết đơn hàng)
 */
function custom_enqueue_view_order_style()
{
    // Chỉ load khi đang ở trang My Account VÀ là endpoint view-order
    if (is_account_page() && is_wc_endpoint_url('view-order')) {

        wp_enqueue_style(
            'custom-view-order-css', // Handle name (đặt sao cũng dc)
            get_template_directory_uri() . '/view-order.css', // Đường dẫn tới file
            array(), // Dependencies
            '1.0.0', // Version
            'all' // Media
        );
    }
}
add_action('wp_enqueue_scripts', 'custom_enqueue_view_order_style');


function ha_enqueue_custom_my_account_style()
{
    // Kiểm tra nếu đang dùng Template "Trang cá nhân"
    if (is_page_template('page-my-account.php')) {
        wp_enqueue_style(
            'ha-modern-account',
            get_template_directory_uri() . '/my-account.css',
            array(),
            '1.0.0'
        );
    }
}
add_action('wp_enqueue_scripts', 'ha_enqueue_custom_my_account_style');



function ha_enqueue_edit_account_style()
{
    // Chỉ load CSS khi đang ở trang template "Chỉnh sửa thông tin"
    if (is_page_template('page-edit-account.php')) {
        wp_enqueue_style(
            'ha-edit-account-css',
            get_template_directory_uri() . '/edit-account.css',
            array(),
            '1.0.0'
        );
    }
}
add_action('wp_enqueue_scripts', 'ha_enqueue_edit_account_style');

/**
 * FORCE Redirect về lại trang Custom sau khi lưu thông tin
 */
/**
 * Redirect dựa trên link được gửi kèm trong Form
 */
function ha_force_hard_redirect_custom_account($location)
{
    // 1. Kiểm tra xem người dùng có đang bấm nút Lưu thông tin không
    if (isset($_POST['action']) && $_POST['action'] === 'save_account_details') {

        // 2. Kiểm tra xem trong form có gửi kèm cái Link "bảo bối" của mình không
        if (! empty($_POST['ha_redirect_url'])) {
            // 3. Nếu có -> Bẻ lái ngay lập tức về link đó!
            return esc_url_raw($_POST['ha_redirect_url']);
        }
    }

    // Nếu không phải trường hợp trên, cho đi bình thường
    return $location;
}
// Hook vào wp_redirect thay vì hook của WooCommerce
add_filter('wp_redirect', 'ha_force_hard_redirect_custom_account', 999999);


function n1_master_customizer_register($wp_customize) {

    // ------------------------------------------------------------------------
    // KHU VỰC 1: TÙY CHỈNH CƠ BẢN (Màu sắc, Font chữ)
    // ------------------------------------------------------------------------
    $wp_customize->add_section('n1_theme_options', array(
        'title'    => __('1. Tùy chỉnh Giao diện (Cơ bản)', 'doAnCMS'),
        'priority' => 30,
        'description' => 'Chỉnh màu sắc chủ đạo, font chữ và bố cục chung.',
    ));

    // A. CHỌN MÀU CHỦ ĐẠO
    $wp_customize->add_setting('main_theme_color', array(
        'default'   => '#6b9d3e',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'main_theme_color', array(
        'label'    => __('Màu chủ đạo (Menu, Nút, Giá...)', 'doAnCMS'),
        'section'  => 'n1_theme_options',
    )));

    // B. CHỌN MÀU HEADER
    $wp_customize->add_setting('header_bg_color', array(
        'default'   => '#ffffff',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'header_bg_color', array(
        'label'    => __('Màu nền Header', 'doAnCMS'),
        'section'  => 'n1_theme_options',
    )));

    // C. KÉO CỠ CHỮ TÊN SẢN PHẨM (Slider)
    $wp_customize->add_setting('product_name_size', array(
        'default'   => '14',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('product_name_size', array(
        'label'       => __('Cỡ chữ Tên Sản phẩm (px)', 'doAnCMS'),
        'section'     => 'n1_theme_options',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 10, 'max'  => 30, 'step' => 1,
        ),
    ));

    // D. KÉO KHOẢNG CÁCH SẢN PHẨM (Slider Gap)
    $wp_customize->add_setting('product_grid_gap', array(
        'default'   => '20',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('product_grid_gap', array(
        'label'       => __('Khoảng cách giữa các sản phẩm', 'doAnCMS'),
        'section'     => 'n1_theme_options',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 0, 'max'  => 50, 'step' => 5,
        ),
    ));

    // E. MÀU NỀN FOOTER
    $wp_customize->add_setting('footer_bg_color', array(
        'default'   => '#333333',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_bg_color', array(
        'label'    => __('Màu nền Footer', 'doAnCMS'),
        'section'  => 'n1_theme_options',
    )));


    // ------------------------------------------------------------------------
    // KHU VỰC 2: TÙY CHỈNH NÂNG CAO (Demo Chức năng cho Cô xem)
    // ------------------------------------------------------------------------
    $wp_customize->add_section('n1_advanced_options', array(
        'title'    => __('2. Tùy biến Nâng cao (Demo Chức năng)', 'doAnCMS'),
        'priority' => 31,
        'description' => 'Demo các loại input khác nhau: Checkbox, Radio, Select, Range...',
    ));

    // 1. LOẠI CHECKBOX: Ẩn/Hiện Search Bar
    $wp_customize->add_setting('show_search_bar', array(
        'default'   => true,
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('show_search_bar', array(
        'label'    => __('Hiển thị thanh tìm kiếm? (Checkbox)', 'doAnCMS'),
        'section'  => 'n1_advanced_options',
        'type'     => 'checkbox',
    ));

    // 2. LOẠI RANGE: Bo tròn góc Card
    $wp_customize->add_setting('card_border_radius', array(
        'default'   => '8',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('card_border_radius', array(
        'label'       => __('Độ bo góc sản phẩm (Range Slider)', 'doAnCMS'),
        'section'     => 'n1_advanced_options',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 0, 'max'  => 50, 'step' => 1,
        ),
    ));

    // 3. LOẠI RADIO: Căn lề Tiêu đề
    $wp_customize->add_setting('title_alignment', array(
        'default'   => 'left',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('title_alignment', array(
        'label'    => __('Vị trí tiêu đề Section (Radio)', 'doAnCMS'),
        'section'  => 'n1_advanced_options',
        'type'     => 'radio',
        'choices'  => array(
            'left'   => 'Căn trái',
            'center' => 'Căn giữa',
            'right'  => 'Căn phải',
        ),
    ));

    // 4. LOẠI SELECT: Kiểu chữ Menu
    $wp_customize->add_setting('menu_text_transform', array(
        'default'   => 'uppercase',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('menu_text_transform', array(
        'label'    => __('Kiểu chữ Menu (Select Dropdown)', 'doAnCMS'),
        'section'  => 'n1_advanced_options',
        'type'     => 'select',
        'choices'  => array(
            'uppercase'  => 'IN HOA',
            'capitalize' => 'Viết Hoa Chữ Đầu',
            'lowercase'  => 'chữ thường',
            'none'       => 'Bình thường',
        ),
    ));

    // 5. LOẠI COLOR: Màu nền Badge Sale
    $wp_customize->add_setting('sale_badge_color', array(
        'default'   => '#ff4d4d',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'sale_badge_color', array(
        'label'    => __('Màu nhãn Sale (Color Picker)', 'doAnCMS'),
        'section'  => 'n1_advanced_options',
    )));
}
add_action('customize_register', 'n1_master_customizer_register');


/**
 * ============================================================================
 * XUẤT TOÀN BỘ CSS RA HTML (HEAD)
 * ============================================================================
 */
function n1_master_customizer_css() {
    ?>
    <style type="text/css">
        /* ==================== PHẦN 1: CƠ BẢN ==================== */
        
        /* 1. Màu chủ đạo */
        .nav, .btn-primary, .flash-sale-section,
        .swiper-button-next-testimonial:hover,
        .swiper-button-prev-testimonial:hover,
        .btn-quick-view:hover {
            background-color: <?php echo get_theme_mod('main_theme_color', '#6b9d3e'); ?> !important;
        }
        
        .product-price, .view-all, .section-subtitle, .btn-secondary,
        .swiper-button-next-testimonial, .swiper-button-prev-testimonial,
        .btn-quick-view {
            color: <?php echo get_theme_mod('main_theme_color', '#6b9d3e'); ?> !important;
        }

        .btn-quick-view {
            border-color: <?php echo get_theme_mod('main_theme_color', '#6b9d3e'); ?> !important;
        }

        /* 2. Màu nền Header */
        .header {
            background-color: <?php echo get_theme_mod('header_bg_color', '#ffffff'); ?> !important;
        }

        /* 3. Cỡ chữ tên sản phẩm */
        .product-name, .product-name a {
            font-size: <?php echo get_theme_mod('product_name_size', '14'); ?>px !important;
        }

        /* 4. Khoảng cách lưới */
        .product-grid {
            gap: <?php echo get_theme_mod('product_grid_gap', '20'); ?>px !important;
        }

        /* 5. Màu nền Footer */
        .footer {
            background-color: <?php echo get_theme_mod('footer_bg_color', '#333333'); ?> !important;
        }

        /* ==================== PHẦN 2: NÂNG CAO ==================== */

        /* 1. Ẩn/Hiện Search Bar */
        <?php if ( get_theme_mod('show_search_bar', true) == false ) : ?>
            .search-bar { display: none !important; }
        <?php endif; ?>

        /* 2. Bo tròn góc */
        .product-card, .category-card, .banner-image, .blog-card img {
            border-radius: <?php echo get_theme_mod('card_border_radius', '8'); ?>px !important;
        }

        /* 3. Căn lề tiêu đề */
        .section-title, .section-header {
            text-align: <?php echo get_theme_mod('title_alignment', 'left'); ?> !important;
            justify-content: <?php echo (get_theme_mod('title_alignment', 'left') == 'center') ? 'center' : 'space-between'; ?>;
        }

        /* 4. Kiểu chữ Menu */
        .nav a {
            text-transform: <?php echo get_theme_mod('menu_text_transform', 'uppercase'); ?> !important;
        }

        /* 5. Màu Badge Sale */
        .onsale, .sale-badge {
            background-color: <?php echo get_theme_mod('sale_badge_color', '#ff4d4d'); ?> !important;
        }
    </style>
    <?php
}
add_action('wp_head', 'n1_master_customizer_css');

function n1_checkout_customizer_register($wp_customize) {

    // 1. TẠO SECTION DUY NHẤT
    $wp_customize->add_section('n1_checkout_options', array(
        'title'       => __('Cấu hình Trang Checkout (Nhom1)', 'doAnCMS'),
        'priority'    => 35, // Xếp sau mấy cái cũ
        'description' => 'Chỉnh sửa toàn diện giao diện trang thanh toán.',
    ));

    // ================= GROUP A: MÀU SẮC CHỦ ĐẠO =================

    // 1. Màu Chính (Màu xanh #4CAF50 - Dùng cho nút, viền, tiêu đề bảng...)
    $wp_customize->add_setting('checkout_primary_color', array(
        'default'   => '#4CAF50',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'checkout_primary_color', array(
        'label'    => __('Màu chủ đạo (Nút, Viền, Icon)', 'doAnCMS'),
        'section'  => 'n1_checkout_options',
    )));

    // 2. Màu Nền Tổng Thể (Background trang)
    $wp_customize->add_setting('checkout_page_bg', array(
        'default'   => '#f0f7f4',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'checkout_page_bg', array(
        'label'    => __('Màu nền toàn trang', 'doAnCMS'),
        'section'  => 'n1_checkout_options',
    )));

    // ================= GROUP B: TYPOGRAPHY (CHỮ) =================

    // 3. Màu Tiêu Đề Chính (Checkout Title)
    $wp_customize->add_setting('checkout_title_color', array(
        'default'   => '#2e7d32',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'checkout_title_color', array(
        'label'    => __('Màu Tiêu đề chính & H3', 'doAnCMS'),
        'section'  => 'n1_checkout_options',
    )));

    // 4. Cỡ chữ Tiêu Đề Chính (Slider)
    $wp_customize->add_setting('checkout_title_size', array(
        'default'   => '36',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('checkout_title_size', array(
        'label'       => __('Kích thước Tiêu đề chính (px)', 'doAnCMS'),
        'section'     => 'n1_checkout_options',
        'type'        => 'range',
        'input_attrs' => array('min' => 20, 'max' => 60, 'step' => 1),
    ));

    // ================= GROUP C: CARDS & INPUTS (HỘP & Ô NHẬP) =================

    // 5. Độ bo góc của các Khung (Card Radius)
    $wp_customize->add_setting('checkout_card_radius', array(
        'default'   => '12',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('checkout_card_radius', array(
        'label'       => __('Độ bo tròn khung chứa (px)', 'doAnCMS'),
        'section'     => 'n1_checkout_options',
        'type'        => 'range',
        'input_attrs' => array('min' => 0, 'max' => 30, 'step' => 1),
    ));

    // 6. Màu nền Ô nhập liệu (Input Background)
    $wp_customize->add_setting('checkout_input_bg', array(
        'default'   => '#f9fbf9',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'checkout_input_bg', array(
        'label'    => __('Màu nền ô nhập liệu', 'doAnCMS'),
        'section'  => 'n1_checkout_options',
    )));

    // 7. Độ bo góc Ô nhập liệu (Input Radius)
    $wp_customize->add_setting('checkout_input_radius', array(
        'default'   => '6',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('checkout_input_radius', array(
        'label'       => __('Độ bo tròn ô nhập liệu (px)', 'doAnCMS'),
        'section'     => 'n1_checkout_options',
        'type'        => 'range',
        'input_attrs' => array('min' => 0, 'max' => 25, 'step' => 1),
    ));

    // ================= GROUP D: NÚT ĐẶT HÀNG (BUTTON) =================

    // 8. Màu Chữ Nút Đặt Hàng
    $wp_customize->add_setting('checkout_btn_text_color', array(
        'default'   => '#ffffff',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'checkout_btn_text_color', array(
        'label'    => __('Màu chữ Nút Đặt Hàng', 'doAnCMS'),
        'section'  => 'n1_checkout_options',
    )));

    // 9. Độ bo góc Nút Đặt Hàng
    $wp_customize->add_setting('checkout_btn_radius', array(
        'default'   => '8',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('checkout_btn_radius', array(
        'label'       => __('Độ bo tròn Nút Đặt Hàng (px)', 'doAnCMS'),
        'section'     => 'n1_checkout_options',
        'type'        => 'range',
        'input_attrs' => array('min' => 0, 'max' => 50, 'step' => 1),
    ));

    // 10. Màu giá Tổng tiền (Đỏ) - Thêm cái này cho phong phú
    $wp_customize->add_setting('checkout_total_price_color', array(
        'default'   => '#d32f2f',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'checkout_total_price_color', array(
        'label'    => __('Màu số tiền "Tổng cộng"', 'doAnCMS'),
        'section'  => 'n1_checkout_options',
    )));
}
add_action('customize_register', 'n1_checkout_customizer_register');


/**
 * XUẤT CSS RA HEADER
 */
function n1_checkout_customizer_css() {
    
    // Lấy các giá trị (kèm mặc định)
    $primary_color = get_theme_mod('checkout_primary_color', '#4CAF50');
    $page_bg       = get_theme_mod('checkout_page_bg', '#f0f7f4');
    $title_color   = get_theme_mod('checkout_title_color', '#2e7d32');
    $title_size    = get_theme_mod('checkout_title_size', '36');
    $card_radius   = get_theme_mod('checkout_card_radius', '12');
    $input_bg      = get_theme_mod('checkout_input_bg', '#f9fbf9');
    $input_radius  = get_theme_mod('checkout_input_radius', '6');
    $btn_text      = get_theme_mod('checkout_btn_text_color', '#ffffff');
    $btn_radius    = get_theme_mod('checkout_btn_radius', '8');
    $total_color   = get_theme_mod('checkout_total_price_color', '#d32f2f');

    ?>
    <style type="text/css">
        /* 1. MÀU NỀN TOÀN TRANG */
        #custom-green-checkout {
            background-color: <?php echo $page_bg; ?> !important;
        }

        /* 2. CÁC YẾU TỐ ĂN THEO MÀU CHỦ ĐẠO (GREEN) */
        /* Gạch chân tiêu đề */
        #custom-green-checkout .checkout-title::after {
            background: <?php echo $primary_color; ?> !important;
        }
        /* Viền trên của bảng đơn hàng */
        #custom-green-checkout .woocommerce-checkout-review-order {
            border-top-color: <?php echo $primary_color; ?> !important;
        }
        /* Viền khi focus vào ô input */
        #custom-green-checkout .input-text:focus,
        #custom-green-checkout select:focus {
            border-color: <?php echo $primary_color; ?> !important;
            box-shadow: 0 0 0 4px <?php echo $primary_color; ?>26 !important; /* Thêm độ trong suốt 15% */
        }
        /* Header bảng đơn hàng */
        #custom-green-checkout table.shop_table thead th {
            color: <?php echo $primary_color; ?> !important;
        }
        /* Viền trái payment box */
        #custom-green-checkout #payment div.payment_box {
            border-left-color: <?php echo $primary_color; ?> !important;
        }
        /* NỀN NÚT ĐẶT HÀNG */
        #custom-green-checkout #place_order,
        #custom-green-checkout #payment #place_order {
            background: <?php echo $primary_color; ?> !important;
            background-color: <?php echo $primary_color; ?> !important;
        }
        /* Các thông báo coupon/login */
        #custom-green-checkout .woocommerce-form-coupon-toggle .woocommerce-info,
        #custom-green-checkout .woocommerce-form-login-toggle .woocommerce-info {
            border-top-color: <?php echo $primary_color; ?> !important;
        }
        #custom-green-checkout .woocommerce-form-coupon-toggle .woocommerce-info a:hover {
            color: <?php echo $primary_color; ?> !important;
        }

        /* 3. TIÊU ĐỀ (MÀU & SIZE) */
        #custom-green-checkout .checkout-title {
            color: <?php echo $title_color; ?> !important;
            font-size: <?php echo $title_size; ?>px !important;
        }
        #custom-green-checkout h3,
        #custom-green-checkout .woocommerce-checkout-review-order::before {
            color: <?php echo $title_color; ?> !important;
        }

        /* 4. CARDS (ĐỘ BO GÓC) */
        #custom-green-checkout #customer_details .col2-set,
        #custom-green-checkout .woocommerce-checkout-review-order,
        #custom-green-checkout #payment,
        #custom-green-checkout form.checkout_coupon {
            border-radius: <?php echo $card_radius; ?>px !important;
        }

        /* 5. INPUTS (MÀU NỀN & BO GÓC) */
        #custom-green-checkout .input-text,
        #custom-green-checkout select,
        #custom-green-checkout textarea {
            background-color: <?php echo $input_bg; ?> !important;
            border-radius: <?php echo $input_radius; ?>px !important;
        }

        /* 6. NÚT ĐẶT HÀNG (TEXT & RADIUS) */
        #custom-green-checkout #place_order,
        #custom-green-checkout #payment #place_order {
            color: <?php echo $btn_text; ?> !important;
            border-radius: <?php echo $btn_radius; ?>px !important;
        }

        /* 7. MÀU TỔNG TIỀN */
        #custom-green-checkout table.shop_table .order-total td strong {
            color: <?php echo $total_color; ?> !important;
        }

    </style>
    <?php
}
add_action('wp_head', 'n1_checkout_customizer_css');


function n1_login_customizer_register($wp_customize) {

    // 1. TẠO SECTION MỚI
    $wp_customize->add_section('n1_login_options', array(
        'title'       => __('Cấu hình Trang Đăng nhập (Nhom1)', 'doAnCMS'),
        'priority'    => 40,
        'description' => 'Chỉnh sửa màu sắc và bố cục form đăng nhập.',
    ));

    // --- A. MÀU CHỦ ĐẠO (Nút bấm, Link, Tab Active) ---
    $wp_customize->add_setting('login_primary_color', array(
        'default'   => '#2aa64f', // Màu xanh lá gốc
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'login_primary_color', array(
        'label'    => __('Màu chủ đạo (Nút, Link)', 'doAnCMS'),
        'section'  => 'n1_login_options',
    )));

    // --- B. MÀU NỀN CỘT TRÁI (GRADIENT) ---
    // Màu bắt đầu (Top)
    $wp_customize->add_setting('login_grad_top', array(
        'default'   => '#e9f7ee',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'login_grad_top', array(
        'label'    => __('Màu nền trái - Trên (Gradient Start)', 'doAnCMS'),
        'section'  => 'n1_login_options',
    )));

    // Màu kết thúc (Bottom)
    $wp_customize->add_setting('login_grad_bottom', array(
        'default'   => '#d6f0da',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'login_grad_bottom', array(
        'label'    => __('Màu nền trái - Dưới (Gradient End)', 'doAnCMS'),
        'section'  => 'n1_login_options',
    )));

    // --- C. BO GÓC KHUNG CHÍNH ---
    $wp_customize->add_setting('login_container_radius', array(
        'default'   => '12',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('login_container_radius', array(
        'label'       => __('Độ bo góc khung Login (px)', 'doAnCMS'),
        'section'     => 'n1_login_options',
        'type'        => 'range',
        'input_attrs' => array('min' => 0, 'max' => 50, 'step' => 1),
    ));

    // --- D. MÀU NỀN INPUT ---
    $wp_customize->add_setting('login_input_bg', array(
        'default'   => '#ffffff',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'login_input_bg', array(
        'label'    => __('Màu nền ô nhập liệu', 'doAnCMS'),
        'section'  => 'n1_login_options',
    )));
}
add_action('customize_register', 'n1_login_customizer_register');


/**
 * XUẤT CSS RA HEADER (DÙNG !IMPORTANT ĐỂ ĐÈ CODE CŨ)
 */
function n1_login_customizer_css() {
    
    // Lấy giá trị từ Customizer
    $primary_color = get_theme_mod('login_primary_color', '#2aa64f');
    $grad_top      = get_theme_mod('login_grad_top', '#e9f7ee');
    $grad_bottom   = get_theme_mod('login_grad_bottom', '#d6f0da');
    $radius        = get_theme_mod('login_container_radius', '12');
    $input_bg      = get_theme_mod('login_input_bg', '#ffffff');

    ?>
    <style type="text/css">
        
        /* 1. MÀU CHỦ ĐẠO (Nút, Link, Tab Active, Chữ bên trái) */
        .ca-btn {
            background: <?php echo $primary_color; ?> !important;
        }
        .ca-link {
            color: <?php echo $primary_color; ?> !important;
        }
        .ca-tab.active {
            color: <?php echo $primary_color; ?> !important;
            background-color: <?php echo $primary_color; ?>1A !important; /* Thêm độ trong suốt 10% */
            border-color: <?php echo $primary_color; ?>4D !important; /* Thêm độ trong suốt 30% */
        }
        /* Đổi luôn màu chữ bên trái cho tông xuyệt tông */
        .ca-left {
            color: <?php echo $primary_color; ?> !important;
            /* Chỉnh gradient nền cột trái */
            background: linear-gradient(180deg, <?php echo $grad_top; ?> 0%, <?php echo $grad_bottom; ?> 100%) !important;
        }

        /* 2. BO GÓC KHUNG */
        .ca-wrapper {
            border-radius: <?php echo $radius; ?>px !important;
        }

        /* 3. INPUT FORM */
        .ca-form input[type="text"],
        .ca-form input[type="email"],
        .ca-form input[type="password"] {
            background-color: <?php echo $input_bg; ?> !important;
        }

        /* BONUS: Hiệu ứng focus input ăn theo màu chủ đạo */
        .ca-form input:focus {
            border-color: <?php echo $primary_color; ?> !important;
            outline: none !important;
            box-shadow: 0 0 0 3px <?php echo $primary_color; ?>33 !important; /* Glow nhẹ */
        }

    </style>
    <?php
}
add_action('wp_head', 'n1_login_customizer_css');



function n1_thankyou_customizer_register($wp_customize) {

    // 1. TẠO SECTION "TRANG CẢM ƠN"
    $wp_customize->add_section('n1_thankyou_options', array(
        'title'       => __('Cấu hình Trang Cảm ơn (Nhom1)', 'doAnCMS'),
        'priority'    => 45, // Xếp cuối cùng
        'description' => 'Chỉnh sửa màu sắc trạng thái và giao diện trang Thank You.',
    ));

    // --- A. MÀU CHỦ ĐẠO (Magic Color) ---
    // Cái này sẽ thay đổi biến --green-theme (Nút, Icon tích xanh, Viền bảng...)
    $wp_customize->add_setting('ty_main_theme_color', array(
        'default'   => '#2ecc71',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ty_main_theme_color', array(
        'label'    => __('Màu chủ đạo (Icon tích, Nút, Viền)', 'doAnCMS'),
        'section'  => 'n1_thankyou_options',
    )));

    // --- B. MÀU NỀN TRANG ---
    $wp_customize->add_setting('ty_page_bg', array(
        'default'   => '#f4f7f6',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ty_page_bg', array(
        'label'    => __('Màu nền toàn trang', 'doAnCMS'),
        'section'  => 'n1_thankyou_options',
    )));

    // --- C. BO GÓC CARD (HỘP GIỮA) ---
    $wp_customize->add_setting('ty_card_radius', array(
        'default'   => '12',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('ty_card_radius', array(
        'label'       => __('Độ bo góc khung nội dung (px)', 'doAnCMS'),
        'section'     => 'n1_thankyou_options',
        'type'        => 'range',
        'input_attrs' => array('min' => 0, 'max' => 50, 'step' => 1),
    ));

    // --- D. TRẠNG THÁI CHỜ (PENDING - VÀNG) ---
    // Cho phép đổi màu cái khung vàng "Pending" thành màu khác
    $wp_customize->add_setting('ty_pending_bg', array(
        'default'   => '#fff3cd',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ty_pending_bg', array(
        'label'    => __('Màu nền trạng thái "Chờ xử lý"', 'doAnCMS'),
        'section'  => 'n1_thankyou_options',
    )));

    $wp_customize->add_setting('ty_pending_text', array(
        'default'   => '#856404',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ty_pending_text', array(
        'label'    => __('Màu chữ trạng thái "Chờ xử lý"', 'doAnCMS'),
        'section'  => 'n1_thankyou_options',
    )));

    // --- E. TIÊU ĐỀ CHÍNH ---
    $wp_customize->add_setting('ty_title_color', array(
        'default'   => '#333333',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ty_title_color', array(
        'label'    => __('Màu Tiêu đề "Cảm ơn"', 'doAnCMS'),
        'section'  => 'n1_thankyou_options',
    )));
}
add_action('customize_register', 'n1_thankyou_customizer_register');


/**
 * XUẤT CSS RA HEADER
 */
function n1_thankyou_customizer_css() {
    
    // Lấy giá trị
    $main_color   = get_theme_mod('ty_main_theme_color', '#2ecc71');
    $page_bg      = get_theme_mod('ty_page_bg', '#f4f7f6');
    $card_radius  = get_theme_mod('ty_card_radius', '12');
    $pending_bg   = get_theme_mod('ty_pending_bg', '#fff3cd');
    $pending_text = get_theme_mod('ty_pending_text', '#856404');
    $title_color  = get_theme_mod('ty_title_color', '#333333');

    ?>
    <style type="text/css">
        /* 1. THAY ĐỔI BIẾN CSS GỐC (CHIÊU MỚI) */
        /* Việc này sẽ đổi màu đồng loạt cho: .check-icon, .icon-line, .btn-green, .custom-table tr:last-child */
        :root {
            --green-theme: <?php echo $main_color; ?> !important;
            --green-dark:  <?php echo $main_color; ?> !important; /* Dùng tạm màu chính cho dark luôn hoặc để mặc định */
        }

        /* 2. MÀU NỀN TRANG */
        .thankyou-page-wrapper {
            background-color: <?php echo $page_bg; ?> !important;
        }

        /* 3. BO GÓC CARD */
        .thankyou-card {
            border-radius: <?php echo $card_radius; ?>px !important;
        }

        /* 4. TRẠNG THÁI PENDING (CHỜ) */
        .pending-header {
            background: <?php echo $pending_bg; ?> !important;
            color: <?php echo $pending_text; ?> !important;
        }

        /* 5. TIÊU ĐỀ */
        .main-title {
            color: <?php echo $title_color; ?> !important;
        }
        
        /* Fix màu nút Hover cho đẹp (làm tối đi 10% bằng filter) */
        .btn-green:hover {
            filter: brightness(0.9);
        }

    </style>
    <?php
}
add_action('wp_head', 'n1_thankyou_customizer_css');


function n1_edit_account_customizer_register($wp_customize) {

    // 1. TẠO SECTION MỚI
    $wp_customize->add_section('n1_edit_account_options', array(
        'title'       => __('Cấu hình Trang Sửa Tài khoản (Nhom1)', 'doAnCMS'),
        'priority'    => 50, // Xếp sau trang Thankyou
        'description' => 'Tùy chỉnh giao diện form chỉnh sửa thông tin cá nhân.',
    ));

    // --- A. MÀU CHỦ ĐẠO (Thay cho màu xanh lá #28a745) ---
    $wp_customize->add_setting('ea_primary_color', array(
        'default'   => '#28a745',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ea_primary_color', array(
        'label'    => __('Màu chủ đạo (Tiêu đề, Nút, Viền)', 'doAnCMS'),
        'section'  => 'n1_edit_account_options',
    )));

    // --- B. MÀU NỀN TRANG ---
    $wp_customize->add_setting('ea_page_bg', array(
        'default'   => '#f8f9fa',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ea_page_bg', array(
        'label'    => __('Màu nền toàn trang', 'doAnCMS'),
        'section'  => 'n1_edit_account_options',
    )));

    // --- C. BO GÓC KHUNG CHÍNH (CONTAINER) ---
    $wp_customize->add_setting('ea_container_radius', array(
        'default'   => '16',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('ea_container_radius', array(
        'label'       => __('Độ bo góc Khung chứa (px)', 'doAnCMS'),
        'section'     => 'n1_edit_account_options',
        'type'        => 'range',
        'input_attrs' => array('min' => 0, 'max' => 50, 'step' => 1),
    ));

    // --- D. BO GÓC NÚT BẤM ---
    $wp_customize->add_setting('ea_btn_radius', array(
        'default'   => '50',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('ea_btn_radius', array(
        'label'       => __('Độ bo góc Nút Lưu (px)', 'doAnCMS'),
        'section'     => 'n1_edit_account_options',
        'type'        => 'range',
        'input_attrs' => array('min' => 0, 'max' => 50, 'step' => 1),
    ));

    // --- E. MÀU NỀN INPUT ---
    $wp_customize->add_setting('ea_input_bg', array(
        'default'   => '#ffffff',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ea_input_bg', array(
        'label'    => __('Màu nền ô nhập liệu', 'doAnCMS'),
        'section'  => 'n1_edit_account_options',
    )));
}
add_action('customize_register', 'n1_edit_account_customizer_register');


/**
 * XUẤT CSS RA HEADER
 */
function n1_edit_account_customizer_css() {
    
    // Lấy giá trị
    $primary_color    = get_theme_mod('ea_primary_color', '#28a745');
    $page_bg          = get_theme_mod('ea_page_bg', '#f8f9fa');
    $container_radius = get_theme_mod('ea_container_radius', '16');
    $btn_radius       = get_theme_mod('ea_btn_radius', '50');
    $input_bg         = get_theme_mod('ea_input_bg', '#ffffff');

    ?>
    <style type="text/css">
        
        /* 1. MÀU NỀN TRANG */
        .edit-account-page-wrapper {
            background-color: <?php echo $page_bg; ?> !important;
        }

        /* 2. CÁC PHẦN TỬ ĂN THEO MÀU CHỦ ĐẠO */
        /* Viền trên của hộp */
        .edit-account-container {
            border-top-color: <?php echo $primary_color; ?> !important;
            border-radius: <?php echo $container_radius; ?>px !important; /* Bo góc hộp */
        }

        /* Tiêu đề */
        .edit-account-title, 
        .woocommerce-EditAccountForm fieldset legend {
            color: <?php echo $primary_color; ?> !important;
        }

        /* Input khi focus (viền và shadow) */
        .woocommerce-form-row .input-text:focus {
            border-color: <?php echo $primary_color; ?> !important;
            box-shadow: 0 0 0 4px <?php echo $primary_color; ?>1A !important; /* Thêm độ trong suốt */
        }

        /* Nút bấm (Ghi đè Gradient bằng màu đơn sắc cho dễ chỉnh) */
        .woocommerce-Button.button {
            background: <?php echo $primary_color; ?> !important;
            border-radius: <?php echo $btn_radius; ?>px !important; /* Bo góc nút */
            box-shadow: 0 5px 15px <?php echo $primary_color; ?>4D !important; /* Bóng đổ cùng màu */
        }
        
        .woocommerce-Button.button:hover {
            /* Làm tối đi 1 chút khi hover bằng filter */
            filter: brightness(0.9);
            transform: translateY(-2px);
        }

        /* Thông báo thành công */
        .woocommerce-message {
            border-left-color: <?php echo $primary_color; ?> !important;
            color: <?php echo $primary_color; ?> !important;
        }

        /* 3. MÀU NỀN INPUT */
        .woocommerce-form-row .input-text {
            background: <?php echo $input_bg; ?> !important;
        }

    </style>
    <?php
}
add_action('wp_head', 'n1_edit_account_customizer_css');


function n1_history_customizer_register($wp_customize) {

    // 1. TẠO SECTION MỚI
    $wp_customize->add_section('n1_history_options', array(
        'title'       => __('Cấu hình Lịch sử Đơn hàng (Nhom1)', 'doAnCMS'),
        'priority'    => 55, // Xếp sau trang Edit Account
        'description' => 'Tùy chỉnh giao diện danh sách đơn hàng đã mua.',
    ));

    // --- A. MÀU CHỦ ĐẠO (Thay cho màu xanh #28a745) ---
    $wp_customize->add_setting('hist_primary_color', array(
        'default'   => '#28a745',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hist_primary_color', array(
        'label'    => __('Màu chủ đạo (Tiêu đề, Nút, Viền)', 'doAnCMS'),
        'section'  => 'n1_history_options',
    )));

    // --- B. MÀU NỀN TIÊU ĐỀ BẢNG (Table Header BG) ---
    $wp_customize->add_setting('hist_table_head_bg', array(
        'default'   => '#e8f5e9',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hist_table_head_bg', array(
        'label'    => __('Màu nền Tiêu đề bảng', 'doAnCMS'),
        'section'  => 'n1_history_options',
    )));

    // --- C. MÀU NỀN TRANG ---
    $wp_customize->add_setting('hist_page_bg', array(
        'default'   => '#f8f9fa',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hist_page_bg', array(
        'label'    => __('Màu nền toàn trang', 'doAnCMS'),
        'section'  => 'n1_history_options',
    )));

    // --- D. BO GÓC KHUNG ĐƠN HÀNG ---
    $wp_customize->add_setting('hist_card_radius', array(
        'default'   => '10',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('hist_card_radius', array(
        'label'       => __('Độ bo góc Khung đơn hàng (px)', 'doAnCMS'),
        'section'     => 'n1_history_options',
        'type'        => 'range',
        'input_attrs' => array('min' => 0, 'max' => 30, 'step' => 1),
    ));
}
add_action('customize_register', 'n1_history_customizer_register');


/**
 * XUẤT CSS RA HEADER
 */
function n1_history_customizer_css() {
    
    // Lấy giá trị
    $primary_color = get_theme_mod('hist_primary_color', '#28a745');
    $head_bg       = get_theme_mod('hist_table_head_bg', '#e8f5e9');
    $page_bg       = get_theme_mod('hist_page_bg', '#f8f9fa');
    $radius        = get_theme_mod('hist_card_radius', '10');

    ?>
    <style type="text/css">
        
        /* 1. MÀU NỀN TRANG */
        .my-order-history-page {
            background-color: <?php echo $page_bg; ?> !important;
        }

        /* 2. CÁC PHẦN TỬ ĂN THEO MÀU CHỦ ĐẠO */
        /* Tiêu đề trang */
        .page-title {
            color: <?php echo $primary_color; ?> !important;
        }
        
        /* Viền trên của Card */
        .order-card {
            border-top-color: <?php echo $primary_color; ?> !important;
            border-radius: <?php echo $radius; ?>px !important;
        }

        /* Viền dưới của Table Header */
        .custom-table th {
            border-bottom-color: <?php echo $primary_color; ?> !important;
            color: <?php echo $primary_color; ?> !important; /* Đổi màu chữ header luôn cho đồng bộ */
            /* Màu nền header */
            background-color: <?php echo $head_bg; ?> !important;
        }

        /* Nút Xem (Btn View) */
        .btn-view {
            background-color: <?php echo $primary_color; ?> !important;
            border-color: <?php echo $primary_color; ?> !important;
        }
        .btn-view:hover {
            filter: brightness(0.9); /* Tối đi chút khi hover */
        }

        /* Responsive Mobile Label Color */
        @media (max-width: 768px) {
            .custom-table td::before {
                color: <?php echo $primary_color; ?> !important;
            }
        }
        
        /* Thông báo Woo */
        .woocommerce-message {
            border-left-color: <?php echo $primary_color; ?> !important;
            color: <?php echo $primary_color; ?> !important;
            background-color: <?php echo $head_bg; ?> !important; /* Dùng chung màu nền nhạt */
        }

    </style>
    <?php
}
add_action('wp_head', 'n1_history_customizer_css');


function n1_my_account_customizer_register($wp_customize) {

    // 1. TẠO SECTION
    $wp_customize->add_section('n1_my_account_options', array(
        'title'       => __('Cấu hình Dashboard Tài khoản (Nhom1)', 'doAnCMS'),
        'priority'    => 60, // Số lớn nhất để xếp cuối cùng
        'description' => 'Tùy chỉnh giao diện trang quản lý tài khoản chính.',
    ));

    // --- A. MÀU GRADIENT HERO (NỀN TRÊN CÙNG) ---
    // Màu bắt đầu
    $wp_customize->add_setting('ma_hero_start', array(
        'default'   => '#28a745',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ma_hero_start', array(
        'label'    => __('Màu nền Hero - Bắt đầu (Gradient)', 'doAnCMS'),
        'section'  => 'n1_my_account_options',
    )));

    // Màu kết thúc
    $wp_customize->add_setting('ma_hero_end', array(
        'default'   => '#218838',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ma_hero_end', array(
        'label'    => __('Màu nền Hero - Kết thúc (Gradient)', 'doAnCMS'),
        'section'  => 'n1_my_account_options',
    )));

    // --- B. MÀU ICON CHỦ ĐẠO ---
    $wp_customize->add_setting('ma_icon_color', array(
        'default'   => '#28a745',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ma_icon_color', array(
        'label'    => __('Màu Icon Menu & Viền Hover', 'doAnCMS'),
        'section'  => 'n1_my_account_options',
    )));

    // --- C. BO GÓC CARD MENU ---
    $wp_customize->add_setting('ma_card_radius', array(
        'default'   => '16',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('ma_card_radius', array(
        'label'       => __('Độ bo góc ô Menu (px)', 'doAnCMS'),
        'section'     => 'n1_my_account_options',
        'type'        => 'range',
        'input_attrs' => array('min' => 0, 'max' => 50, 'step' => 1),
    ));

    // --- D. KHOẢNG CÁCH GRID (GAP) ---
    $wp_customize->add_setting('ma_grid_gap', array(
        'default'   => '25',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('ma_grid_gap', array(
        'label'       => __('Khoảng cách giữa các ô (px)', 'doAnCMS'),
        'section'     => 'n1_my_account_options',
        'type'        => 'range',
        'input_attrs' => array('min' => 10, 'max' => 60, 'step' => 5),
    ));

    // --- E. HÌNH DÁNG AVATAR (VUÔNG/TRÒN) ---
    $wp_customize->add_setting('ma_avatar_radius', array(
        'default'   => '50', // 50% là tròn
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('ma_avatar_radius', array(
        'label'       => __('Bo góc Avatar (50% là tròn)', 'doAnCMS'),
        'section'     => 'n1_my_account_options',
        'type'        => 'range',
        'input_attrs' => array('min' => 0, 'max' => 50, 'step' => 10), // Đơn vị là %
    ));
}
add_action('customize_register', 'n1_my_account_customizer_register');


/**
 * XUẤT CSS RA HEADER
 */
function n1_my_account_customizer_css() {
    
    // Lấy giá trị
    $hero_start    = get_theme_mod('ma_hero_start', '#28a745');
    $hero_end      = get_theme_mod('ma_hero_end', '#218838');
    $icon_color    = get_theme_mod('ma_icon_color', '#28a745');
    $card_radius   = get_theme_mod('ma_card_radius', '16');
    $grid_gap      = get_theme_mod('ma_grid_gap', '25');
    $avatar_radius = get_theme_mod('ma_avatar_radius', '50');

    ?>
    <style type="text/css">
        
        /* 1. HERO SECTION GRADIENT */
        .ma-dashboard-hero {
            background: linear-gradient(135deg, <?php echo $hero_start; ?> 0%, <?php echo $hero_end; ?> 100%) !important;
            /* Đổ bóng cùng tông màu bắt đầu */
            box-shadow: 0 10px 30px <?php echo $hero_start; ?>4D !important;
        }

        /* 2. ICON & HOVER COLOR */
        .ma-card-icon {
            color: <?php echo $icon_color; ?> !important;
            /* Nền icon nhạt (lấy màu chính giảm độ đậm đi rất nhiều) */
            background: <?php echo $icon_color; ?>1A !important; 
        }

        /* Khi Hover vào Card */
        .ma-card:hover {
            border-color: <?php echo $icon_color; ?> !important;
        }
        .ma-card:hover .ma-card-icon {
            background: <?php echo $icon_color; ?> !important;
            /* Chữ chuyển sang trắng */
            color: #fff !important;
        }

        /* 3. BO GÓC CARD */
        .ma-card {
            border-radius: <?php echo $card_radius; ?>px !important;
        }

        /* 4. KHOẢNG CÁCH GRID */
        .ma-grid-menu {
            gap: <?php echo $grid_gap; ?>px !important;
        }

        /* 5. AVATAR SHAPE */
        .ma-avatar img {
            border-radius: <?php echo $avatar_radius; ?>% !important;
        }

    </style>
    <?php
}
add_action('wp_head', 'n1_my_account_customizer_css');