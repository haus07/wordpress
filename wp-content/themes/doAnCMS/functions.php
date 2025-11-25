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

// AJAX cập nhật số lượng
// function update_cart_item_ajax()
// {
//     $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
//     $qty = intval($_POST['qty']);

//     $cart = WC()->cart;

//     if (isset($cart->get_cart()[$cart_item_key])) {
//         if ($qty > 0) {
//             $cart->set_quantity($cart_item_key, $qty, true); // true = recalc totals
//         } else {
//             $cart->remove_cart_item($cart_item_key);
//         }
//     }

//     // Tính lại totals (tự động tính cả coupon nếu có)
//     $cart->calculate_totals();

//     $subtotal_html = $cart->get_cart_subtotal();
//     $total_html    = $cart->get_total();
//     $discount_total = $cart->get_cart_discount_total();
//     $discount_html = wc_price($discount_total);

//     wp_send_json_success([
//         'removed'       => $qty === 0,
//         'subtotal_html' => $subtotal_html,
//         'total_html'    => $total_html,
//         'discount_html' => $discount_html,
//         'message'       => 'Cập nhật giỏ hàng thành công'
//     ]);

//     wp_die();
// }
// add_action('wp_ajax_update_cart_item', 'update_cart_item_ajax');
// add_action('wp_ajax_nopriv_update_cart_item', 'update_cart_item_ajax');


// add_action('wp_ajax_apply_coupon_ajax', 'apply_coupon_ajax');
// add_action('wp_ajax_nopriv_apply_coupon_ajax', 'apply_coupon_ajax');

// function apply_coupon_ajax()
// {
//     if (empty($_POST['coupon_code'])) {
//         wp_send_json_error(['message' => 'Vui lòng nhập mã giảm giá']);
//     }

//     $coupon_code = sanitize_text_field($_POST['coupon_code']);

//     // Áp mã
//     $applied = WC()->cart->apply_coupon($coupon_code);

//     // Lấy lỗi sau khi apply
//     if (!$applied) {
//         $errors = wc_get_notices('error');
//         $err_msg = !empty($errors) ? $errors[0]['notice'] : 'Mã giảm giá không hợp lệ';
//         wc_clear_notices();

//         wp_send_json_error(['message' => $err_msg]);
//     }

//     // Tính lại tiền
//     WC()->cart->calculate_totals();

//     wp_send_json_success([
//         'coupon_code'   => $coupon_code,
//         'subtotal_html' => WC()->cart->get_cart_subtotal(),
//         'discount_html' => wc_price(WC()->cart->get_cart_discount_total()),
//         'total_html'    => WC()->cart->get_total(),
//         'message'       => sprintf('Áp dụng mã "%s" thành công!', esc_html($coupon_code))
//     ]);

//     wp_die();
// }

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
 * Customizer: Contact Page Style Options
 */
function theme_customize_contact($wp_customize)
{
    // === SECTION ===
    $wp_customize->add_section('contact_style_section', array(
        'title'       => 'Contact Page Style',
        'priority'    => 30,
        'description' => 'Tùy chỉnh giao diện trang Contact.',
    ));

    // === BACKGROUND COLOR ===
    $wp_customize->add_setting('contact_bg_color', array(
        'default'   => '#f9f9f9',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'contact_bg_color_control',
        array(
            'label'    => 'Màu nền trang',
            'section'  => 'contact_style_section',
            'settings' => 'contact_bg_color',
        )
    ));

    // === BOX BACKGROUND ===
    $wp_customize->add_setting('contact_box_bg', array(
        'default'   => '#ffffff',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'contact_box_bg_control',
        array(
            'label'    => 'Màu nền khung',
            'section'  => 'contact_style_section',
            'settings' => 'contact_box_bg',
        )
    ));

    // === FONT SIZE ===
    $wp_customize->add_setting('contact_font_size', array(
        'default'   => 14,
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('contact_font_size_control', array(
        'label'       => 'Cỡ chữ (px)',
        'section'     => 'contact_style_section',
        'settings'    => 'contact_font_size',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 10,
            'max'  => 24,
            'step' => 1,
        ),
    ));

    // === PRIMARY COLOR ===
    $wp_customize->add_setting('contact_primary_color', array(
        'default'   => '#6b9d3e',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'contact_primary_color_control',
        array(
            'label'    => 'Màu chủ đạo (tiêu đề)',
            'section'  => 'contact_style_section',
            'settings' => 'contact_primary_color',
        )
    ));

    // === BUTTON BACKGROUND ===
    $wp_customize->add_setting('contact_button_bg', array(
        'default'   => '#6b9d3e',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'contact_button_bg_control',
        array(
            'label'    => 'Màu nút Button',
            'section'  => 'contact_style_section',
            'settings' => 'contact_button_bg',
        )
    ));

    // === BUTTON HOVER ===
    $wp_customize->add_setting('contact_button_hover', array(
        'default'   => '#557c2a',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'contact_button_hover_control',
        array(
            'label'    => 'Màu hover Button',
            'section'  => 'contact_style_section',
            'settings' => 'contact_button_hover',
        )
    ));

    // === BUTTON PADDING ===
    $wp_customize->add_setting('contact_button_padding', array(
        'default'   => 12,
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('contact_button_padding_control', array(
        'label'       => 'Kích thước nút (padding)',
        'section'     => 'contact_style_section',
        'settings'    => 'contact_button_padding',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 8,
            'max'  => 20,
            'step' => 1,
        ),
    ));

    // === BORDER RADIUS ===
    $wp_customize->add_setting('contact_border_radius', array(
        'default'   => 12,
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('contact_border_radius_control', array(
        'label'       => 'Bo góc (px)',
        'section'     => 'contact_style_section',
        'settings'    => 'contact_border_radius',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 30,
            'step' => 1,
        ),
    ));
}
add_action('customize_register', 'theme_customize_contact');

/**
 * In CSS áp dụng cho trang Contact
 */
function theme_contact_custom_style()
{
    $bg_color        = get_theme_mod('contact_bg_color', '#f9f9f9');
    $box_bg          = get_theme_mod('contact_box_bg', '#ffffff');
    $font_size       = get_theme_mod('contact_font_size', 14);
    $primary_color   = get_theme_mod('contact_primary_color', '#6b9d3e');
    $button_bg       = get_theme_mod('contact_button_bg', '#6b9d3e');
    $button_hover    = get_theme_mod('contact_button_hover', '#557c2a');
    $button_padding  = get_theme_mod('contact_button_padding', 12);
    $border_radius   = get_theme_mod('contact_border_radius', 12);

    echo "<style>
        /* Background trang - GHI ĐÈ CSS TRONG TEMPLATE */
        body.page-template-contact {
            background-color: {$bg_color} !important;
        }

        /* Container chính */
        .contact-page {
            background-color: transparent !important;
        }

        /* Khung form và info */
        .contact-form,
        .contact-info {
            background-color: {$box_bg} !important;
            border-radius: {$border_radius}px !important;
            font-size: {$font_size}px !important;
        }

        /* Tiêu đề */
        .contact-form h2,
        .contact-info h2 {
            color: {$primary_color} !important;
        }

        /* Input và textarea */
        .contact-form form input,
        .contact-form form textarea,
        .contact-info form input {
            border-radius: {$border_radius}px !important;
        }

        /* Button */
        .contact-form form button,
        .contact-info form button,
        #open-chat {
            background: {$button_bg} !important;
            padding: {$button_padding}px !important;
            border-radius: {$border_radius}px !important;
        }

        .contact-form form button:hover,
        .contact-info form button:hover,
        #open-chat:hover {
            background: {$button_hover} !important;
        }

        /* Info span color */
        .contact-info div span {
            color: {$primary_color} !important;
        }
    </style>";
}
add_action('wp_head', 'theme_contact_custom_style', 999); // Priority 999 để load sau cùng

/**
 * Load JS Customizer
 */
function theme_enqueue_contact_customizer_script()
{
    if (is_customize_preview()) {
        wp_enqueue_script('jquery-ui-draggable');
        wp_enqueue_script(
            'contact-customizer-js',
            get_template_directory_uri() . '/assets/js/contact-customizer.js',
            array('jquery', 'customize-preview', 'jquery-ui-draggable'),
            '1.0.1', // Tăng version để force reload
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'theme_enqueue_contact_customizer_script');

/**
 * ============================================================================
 * CUSTOMIZER CHO SINGLE PRODUCT PAGE
 * ============================================================================
 */

function theme_customize_single_product($wp_customize)
{
    // ===== SECTION =====
    $wp_customize->add_section('single_product_style', array(
        'title'       => '🛍️ Single Product Style',
        'priority'    => 35,
        'description' => 'Tùy chỉnh giao diện trang chi tiết sản phẩm',
    ));

    // 1. BACKGROUND COLOR
    $wp_customize->add_setting('sp_bg_color', array(
        'default'   => '#f4f6f8',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'sp_bg_color_ctrl', array(
        'label'    => 'Màu nền trang',
        'section'  => 'single_product_style',
        'settings' => 'sp_bg_color',
    )));

    // 2. BOX BACKGROUND
    $wp_customize->add_setting('sp_box_bg', array(
        'default'   => '#ffffff',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'sp_box_bg_ctrl', array(
        'label'    => 'Màu nền khung sản phẩm',
        'section'  => 'single_product_style',
        'settings' => 'sp_box_bg',
    )));

    // 3. PRIMARY COLOR (Button, price, hover)
    $wp_customize->add_setting('sp_primary_color', array(
        'default'   => '#6b9d3e',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'sp_primary_color_ctrl', array(
        'label'    => 'Màu chủ đạo (Giá, nút)',
        'section'  => 'single_product_style',
        'settings' => 'sp_primary_color',
    )));

    // 4. TITLE FONT SIZE
    $wp_customize->add_setting('sp_title_size', array(
        'default'   => 32,
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('sp_title_size_ctrl', array(
        'label'       => 'Cỡ chữ tiêu đề (px)',
        'section'     => 'single_product_style',
        'settings'    => 'sp_title_size',
        'type'        => 'range',
        'input_attrs' => array('min' => 20, 'max' => 50, 'step' => 1),
    ));

    // 5. PRICE FONT SIZE
    $wp_customize->add_setting('sp_price_size', array(
        'default'   => 36,
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('sp_price_size_ctrl', array(
        'label'       => 'Cỡ chữ giá (px)',
        'section'     => 'single_product_style',
        'settings'    => 'sp_price_size',
        'type'        => 'range',
        'input_attrs' => array('min' => 20, 'max' => 60, 'step' => 1),
    ));

    // 6. BUTTON BG COLOR
    $wp_customize->add_setting('sp_button_bg', array(
        'default'   => '#6b9d3e',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'sp_button_bg_ctrl', array(
        'label'    => 'Màu nút Add to Cart',
        'section'  => 'single_product_style',
        'settings' => 'sp_button_bg',
    )));

    // 7. BUTTON HOVER COLOR
    $wp_customize->add_setting('sp_button_hover', array(
        'default'   => '#557c2a',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'sp_button_hover_ctrl', array(
        'label'    => 'Màu hover nút',
        'section'  => 'single_product_style',
        'settings' => 'sp_button_hover',
    )));

    // 8. BUTTON SIZE
    $wp_customize->add_setting('sp_button_padding', array(
        'default'   => 14,
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('sp_button_padding_ctrl', array(
        'label'       => 'Kích thước nút (padding)',
        'section'     => 'single_product_style',
        'settings'    => 'sp_button_padding',
        'type'        => 'range',
        'input_attrs' => array('min' => 8, 'max' => 25, 'step' => 1),
    ));

    // 9. BORDER RADIUS
    $wp_customize->add_setting('sp_border_radius', array(
        'default'   => 12,
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('sp_border_radius_ctrl', array(
        'label'       => 'Bo góc (px)',
        'section'     => 'single_product_style',
        'settings'    => 'sp_border_radius',
        'type'        => 'range',
        'input_attrs' => array('min' => 0, 'max' => 30, 'step' => 1),
    ));

    // 10. RELATED PRODUCTS TITLE SIZE
    $wp_customize->add_setting('sp_related_title_size', array(
        'default'   => 26,
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('sp_related_title_size_ctrl', array(
        'label'       => 'Cỡ chữ "Sản phẩm liên quan"',
        'section'     => 'single_product_style',
        'settings'    => 'sp_related_title_size',
        'type'        => 'range',
        'input_attrs' => array('min' => 16, 'max' => 40, 'step' => 1),
    ));

    // 11. RELATED CARD BG
    $wp_customize->add_setting('sp_related_card_bg', array(
        'default'   => '#ffffff',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'sp_related_card_bg_ctrl', array(
        'label'    => 'Màu nền card SP liên quan',
        'section'  => 'single_product_style',
        'settings' => 'sp_related_card_bg',
    )));
}
add_action('customize_register', 'theme_customize_single_product');

/**
 * In CSS động cho Single Product
 */
function theme_single_product_custom_style()
{
    // Chỉ chạy trên trang single product
    if (!is_product()) return;

    // Lấy giá trị từ Customizer
    $bg_color          = get_theme_mod('sp_bg_color', '#f4f6f8');
    $box_bg            = get_theme_mod('sp_box_bg', '#ffffff');
    $primary_color     = get_theme_mod('sp_primary_color', '#6b9d3e');
    $title_size        = get_theme_mod('sp_title_size', 32);
    $price_size        = get_theme_mod('sp_price_size', 36);
    $button_bg         = get_theme_mod('sp_button_bg', '#6b9d3e');
    $button_hover      = get_theme_mod('sp_button_hover', '#557c2a');
    $button_padding    = get_theme_mod('sp_button_padding', 14);
    $border_radius     = get_theme_mod('sp_border_radius', 12);
    $related_title_size = get_theme_mod('sp_related_title_size', 26);
    $related_card_bg   = get_theme_mod('sp_related_card_bg', '#ffffff');

    echo "<style>
        /* Background trang */
        body.single-product {
            background-color: {$bg_color};
        }

        /* Khung sản phẩm chính */
        .product-section {
            background-color: {$box_bg};
            border-radius: {$border_radius}px;
        }

        /* Tiêu đề sản phẩm */
        body.single-product h1.product_title {
            font-size: {$title_size}px;
            color: #333;
        }

        /* Giá */
        body.single-product p.price .woocommerce-Price-amount {
            font-size: {$price_size}px;
            color: {$primary_color};
        }

        /* Nút Add to Cart */
        body.single-product form.cart .single_add_to_cart_button {
            background: {$button_bg};
            padding: {$button_padding}px 30px;
            border-radius: {$border_radius}px;
        }

        body.single-product form.cart .single_add_to_cart_button:hover {
            background: {$button_hover};
        }

        /* Gallery images */
        body.single-product .woocommerce-product-gallery img {
            border-radius: {$border_radius}px;
        }

        /* Meta links */
        body.single-product .product_meta a {
            color: {$primary_color};
        }

        /* Tabs active */
        body.single-product .woocommerce-tabs ul.tabs li.active a {
            color: {$primary_color};
            border-bottom-color: {$primary_color};
        }

        /* Related Products Title */
        body.single-product .related.products > h2 {
            font-size: {$related_title_size}px;
        }

        body.single-product .related.products > h2::after {
            background-color: {$primary_color};
        }

        /* Related Product Cards */
        body.single-product .related.products ul.products li.product {
            background-color: {$related_card_bg};
            border-radius: {$border_radius}px;
        }

        body.single-product .related.products ul.products li.product .button {
            background: {$primary_color};
            border-color: {$primary_color};
            border-radius: {$border_radius}px;
        }

        body.single-product .related.products ul.products li.product .button:hover {
            color: {$primary_color};
        }

        body.single-product .related.products ul.products li.product .price {
            color: {$primary_color};
        }

        body.single-product .related.products ul.products li.product:hover .woocommerce-loop-product__title {
            color: {$primary_color};
        }

        /* Stock in-stock color */
        .product-stock .in-stock {
            color: {$primary_color};
        }
    </style>";
}
add_action('wp_head', 'theme_single_product_custom_style');

/**
 * Load JS Customizer cho live preview
 */
function theme_enqueue_single_product_customizer_script()
{
    if (is_customize_preview()) {
        wp_enqueue_script(
            'single-product-customizer-js',
            get_template_directory_uri() . '/assets/js/single-product-customizer.js',
            array('jquery', 'customize-preview'),
            '1.0.0',
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'theme_enqueue_single_product_customizer_script');

// =====================
// Customizer Wishlist
// =====================
function doAnCMS_customize_wishlist($wp_customize)
{
    $wp_customize->add_section('wishlist_section', [
        'title' => __('Wishlist Page', 'doAnCMS'),
        'priority' => 30,
    ]);

    // Tiêu đề
    $wp_customize->add_setting('wishlist_title', [
        'default' => '❤️ Danh sách yêu thích của bạn',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('wishlist_title', [
        'label' => __('Tiêu đề trang', 'doAnCMS'),
        'section' => 'wishlist_section',
        'type' => 'text',
    ]);

    // Text trống
    $wp_customize->add_setting('wishlist_empty_text', [
        'default' => 'Chưa có sản phẩm nào trong wishlist.',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('wishlist_empty_text', [
        'label' => __('Text khi wishlist trống', 'doAnCMS'),
        'section' => 'wishlist_section',
        'type' => 'text',
    ]);

    // Background
    $wp_customize->add_setting('wishlist_bg_color', [
        'default' => '#fff',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'wishlist_bg_color_control', [
        'label' => __('Background Color', 'doAnCMS'),
        'section' => 'wishlist_section',
        'settings' => 'wishlist_bg_color',
    ]));

    // Title color
    $wp_customize->add_setting('wishlist_title_color', [
        'default' => '#333',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'wishlist_title_color_control', [
        'label' => __('Title Color', 'doAnCMS'),
        'section' => 'wishlist_section',
        'settings' => 'wishlist_title_color',
    ]));

    // Button color
    $wp_customize->add_setting('wishlist_button_color', [
        'default' => '#27ae60',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'wishlist_button_color_control', [
        'label' => __('Button Color', 'doAnCMS'),
        'section' => 'wishlist_section',
        'settings' => 'wishlist_button_color',
    ]));
}
add_action('customize_register', 'doAnCMS_customize_wishlist');
function doAnCMS_customize_wishlist_preview()
{
    wp_enqueue_script(
        'wishlist-customizer-preview',
        get_stylesheet_directory_uri() . '/assets/js/wishlist-customizer-preview.js',
        ['customize-preview', 'jquery'],
        '1.0',
        true
    );
}
add_action('customize_preview_init', 'doAnCMS_customize_wishlist_preview');
