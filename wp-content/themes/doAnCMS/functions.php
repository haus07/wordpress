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
    // Tạo 10 bài viết mẫu (chỉ chạy 1 lần)
    // =======================
    function doAnCMS_create_sample_blog_posts()
    {
        if (get_option('doAnCMS_sample_blog_posts_created')) return; // chỉ chạy 1 lần

        $titles = [
            'Lợi ích của rau hữu cơ',
            'Cách chọn thực phẩm hữu cơ',
            'Thực phẩm hữu cơ cho bé',
            'Top 5 loại trái cây organic',
            'Organic vs Thực phẩm thông thường',
            'Cách trồng rau hữu cơ tại nhà',
            'Smoothie healthy từ organic',
            'Các loại hạt hữu cơ tốt cho sức khỏe',
            'Chế độ ăn organic giảm cân',
            'Organic food: Xu hướng 2025'
        ];

        foreach ($titles as $index => $title) {
            $content = "Đây là nội dung mẫu cho bài viết: $title. Thông tin về organic food, sức khỏe và cách chọn thực phẩm hữu cơ.";

            $post_id = wp_insert_post([
                'post_title'    => $title,
                'post_content'  => $content,
                'post_status'   => 'publish',
                'post_author'   => 1,
                'post_category' => [1], // category ID = 1 (Bạn có thể đổi)
            ]);

            if ($post_id) {
                // Gắn ảnh thumbnail
                $image_path = get_template_directory() . '/assets/images/blog/blog' . ($index + 1) . '.jpg';
                if (file_exists($image_path)) {
                    $upload_dir = wp_upload_dir();
                    $image_data = file_get_contents($image_path);
                    $filename = basename($image_path);

                    if (wp_mkdir_p($upload_dir['path'])) {
                        $file = $upload_dir['path'] . '/' . $filename;
                    } else {
                        $file = $upload_dir['basedir'] . '/' . $filename;
                    }

                    file_put_contents($file, $image_data);

                    $wp_filetype = wp_check_filetype($filename, null);
                    $attachment = [
                        'post_mime_type' => $wp_filetype['type'],
                        'post_title'     => sanitize_file_name($filename),
                        'post_content'   => '',
                        'post_status'    => 'inherit'
                    ];

                    $attach_id = wp_insert_attachment($attachment, $file, $post_id);
                    require_once(ABSPATH . 'wp-admin/includes/image.php');
                    $attach_data = wp_generate_attachment_metadata($attach_id, $file);
                    wp_update_attachment_metadata($attach_id, $attach_data);
                    set_post_thumbnail($post_id, $attach_id);
                }
            }
        }

        update_option('doAnCMS_sample_blog_posts_created', 1);
    }
    // add_action('after_setup_theme', 'doAnCMS_create_sample_blog_posts');
    add_action('init', 'doAnCMS_create_sample_blog_posts');


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
    // function doAnCMS_delete_all_posts()
    // {
    //     $paged = 1;
    //     $posts_per_page = 50; // xóa 50 bài một lần, tránh lỗi memory

    //     do {
    //         $query = new WP_Query([
    //             'post_type'      => 'post',
    //             'posts_per_page' => $posts_per_page,
    //             'paged'          => $paged,
    //             'post_status'    => 'any', // lấy tất cả trạng thái bài viết
    //         ]);

    //         if ($query->have_posts()) {
    //             foreach ($query->posts as $post) {
    //                 wp_delete_post($post->ID, true); // true = xóa vĩnh viễn
    //             }
    //         }

    //         $paged++;
    //         $max_pages = $query->max_num_pages;
    //         wp_reset_postdata();
    //     } while ($paged <= $max_pages);

    //     // Xóa tùy chọn blog mẫu nếu có
    //     delete_option('doAnCMS_sample_blog_posts_created');

    //     echo "Đã xóa tất cả bài viết!";
    // }

    // // Gọi hàm 1 lần duy nhất
    // doAnCMS_delete_all_posts();
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
}
