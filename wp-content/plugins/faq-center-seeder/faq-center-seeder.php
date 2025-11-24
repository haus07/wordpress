<?php

/**
 * Plugin Name: FAQ Center Seeder (Organic Food Shop)
 * Description: Tạo CPT FAQ + taxonomy + seeder 20 câu hỏi mẫu theo chủ đề Organic Food Shop. Kèm shortcode [faq_center] hiển thị accordion đẹp (icon + màu organic).
 * Version: 1.0.0
 * Author: Hoai
 * Text Domain: faq-center-seeder
 */

if (!defined('ABSPATH')) exit;

/**
 * Register CPT 'faq' and taxonomy 'faq_category'
 */
function fcs_register_faq_cpt()
{
    $labels = array(
        'name' => __('FAQs', 'faq-center-seeder'),
        'singular_name' => __('FAQ', 'faq-center-seeder'),
        'menu_name' => __('FAQ Center', 'faq-center-seeder'),
        'add_new' => __('Thêm câu hỏi', 'faq-center-seeder'),
        'add_new_item' => __('Thêm câu hỏi mới', 'faq-center-seeder'),
        'edit_item' => __('Sửa câu hỏi', 'faq-center-seeder'),
        'new_item' => __('Câu hỏi mới', 'faq-center-seeder'),
        'view_item' => __('Xem câu hỏi', 'faq-center-seeder'),
        'search_items' => __('Tìm câu hỏi', 'faq-center-seeder'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => false,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-editor-help',
        'supports' => array('title', 'editor', 'excerpt', 'revisions'),
        'rewrite' => array('slug' => 'faq'),
        'show_in_rest' => true,
    );

    register_post_type('faq', $args);

    // taxonomy
    $tlabels = array(
        'name' => __('FAQ Categories', 'faq-center-seeder'),
        'singular_name' => __('FAQ Category', 'faq-center-seeder'),
        'search_items' => __('Tìm category', 'faq-center-seeder'),
        'all_items' => __('Tất cả category', 'faq-center-seeder'),
        'edit_item' => __('Sửa category', 'faq-center-seeder'),
        'add_new_item' => __('Thêm category mới', 'faq-center-seeder'),
        'menu_name' => __('FAQ Category', 'faq-center-seeder')
    );

    $targs = array(
        'labels' => $tlabels,
        'hierarchical' => true,
        'rewrite' => array('slug' => 'faq-category'),
        'show_in_rest' => true,
    );

    register_taxonomy('faq_category', array('faq'), $targs);
}
add_action('init', 'fcs_register_faq_cpt');


/**
 * Enqueue frontend CSS & JS
 */
function fcs_enqueue_assets()
{
    if (!is_admin()) {
        wp_register_style('fcs-style', plugins_url('assets/fcs-style.css', __FILE__));
        wp_enqueue_style('fcs-style');

        wp_register_script('fcs-script', plugins_url('assets/fcs-script.js', __FILE__), array('jquery'), null, true);
        wp_enqueue_script('fcs-script');
    }
}
add_action('wp_enqueue_scripts', 'fcs_enqueue_assets');


/**
 * Create assets files content on the fly if not exist (simple approach)
 * This ensures plugin works after copying single file without separate asset files.
 * We'll spool minimal CSS/JS into wp_head and wp_footer fallback if files missing.
 */
function fcs_print_inline_assets_fallback()
{
    $css_file = plugin_dir_path(__FILE__) . 'assets/fcs-style.css';
    $js_file = plugin_dir_path(__FILE__) . 'assets/fcs-script.js';

    // If files don't exist physically, print inline
    if (!file_exists($css_file)) {
        echo '<style>';
        echo fcs_get_default_css();
        echo '</style>';
    }
    if (!file_exists($js_file)) {
        echo '<script>';
        echo fcs_get_default_js();
        echo '</script>';
    }
}
add_action('wp_head', 'fcs_print_inline_assets_fallback', 100);


/**
 * Shortcode [faq_center] - render FAQ center with search, categories, accordion
 */
function fcs_faq_center_shortcode($atts)
{
    ob_start();

    // Search query: allow 's' param filtered to faq posts
    $s = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';

    // Category filter if present via query var 'faq_cat'
    $faq_cat = isset($_GET['faq_cat']) ? sanitize_text_field($_GET['faq_cat']) : '';

    // fetch categories
    $terms = get_terms(array(
        'taxonomy' => 'faq_category',
        'hide_empty' => false
    ));

    // WP_Query args
    $args = array(
        'post_type' => 'faq',
        'posts_per_page' => -1,
        's' => $s
    );

    if ($faq_cat) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'faq_category',
                'field' => 'slug',
                'terms' => $faq_cat,
            ),
        );
    }

    $faq_query = new WP_Query($args);

    // Render HTML
?>
    <div class="fcs-faq-center">
        <div class="fcs-header">
            <h2 class="fcs-title">FAQ Center</h2>
            <p class="fcs-sub">Bạn cần hỗ trợ gì? Tìm câu hỏi nhanh hoặc chọn chủ đề bên dưới.</p>
        </div>

        <form class="fcs-search" method="get">
            <input type="text" name="s" placeholder="Bạn cần hỗ trợ gì?" value="<?php echo esc_attr($s); ?>">
            <input type="hidden" name="post_type" value="faq">
            <?php if ($faq_cat): ?>
                <input type="hidden" name="faq_cat" value="<?php echo esc_attr($faq_cat); ?>">
            <?php endif; ?>
            <button type="submit">Tìm</button>
        </form>

        <?php if (!empty($terms) && !is_wp_error($terms)): ?>
            <div class="fcs-cats">
                <a class="fcs-cat <?php echo $faq_cat == '' ? 'active' : ''; ?>" href="<?php echo esc_url(remove_query_arg('faq_cat')); ?>">Tất cả</a>
                <?php foreach ($terms as $t):
                    $link = add_query_arg('faq_cat', $t->slug);
                    $active = ($faq_cat === $t->slug) ? 'active' : '';
                ?>
                    <a class="fcs-cat <?php echo $active; ?>" href="<?php echo esc_url($link); ?>"><?php echo esc_html($t->name); ?></a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="fcs-list">
            <?php if ($faq_query->have_posts()):
                while ($faq_query->have_posts()): $faq_query->the_post();
                    $id = get_the_ID();
                    $title = get_the_title();
                    $content = apply_filters('the_content', get_the_content());
                    // Get categories for display
                    $cats = wp_get_post_terms($id, 'faq_category', array('fields' => 'names'));
            ?>
                    <div class="fcs-item" tabindex="0">
                        <button class="fcs-q">
                            <span class="fcs-icon"><?php echo fcs_leaf_svg(); ?></span>
                            <span class="fcs-q-text"><?php echo esc_html($title); ?></span>
                            <span class="fcs-toggle" aria-hidden="true">+</span>
                        </button>
                        <div class="fcs-a">
                            <div class="fcs-a-inner"><?php echo $content; ?></div>
                            <?php if (!empty($cats)) : ?>
                                <div class="fcs-meta">Chủ đề: <?php echo esc_html(implode(', ', $cats)); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile;
                wp_reset_postdata();
            else: ?>
                <div class="fcs-no">Không tìm thấy câu hỏi nào.</div>
            <?php endif; ?>
        </div>
    </div>
<?php

    return ob_get_clean();
}
add_shortcode('faq_center', 'fcs_faq_center_shortcode');


/**
 * Activation hook: seed sample FAQs (only once)
 */
function fcs_plugin_activate()
{
    // ensure CPT & taxonomy are registered before seeding
    fcs_register_faq_cpt();

    if (get_option('fcs_seeded') !== '1') {
        fcs_seed_sample_faqs();
        update_option('fcs_seeded', '1');
    }
}
register_activation_hook(__FILE__, 'fcs_plugin_activate');


/**
 * Seeder function: create categories and 20 sample FAQs
 */
function fcs_seed_sample_faqs()
{
    if (!current_user_can('activate_plugins')) return;

    // categories and sample Q&A (title -> content, category slug)
    $data = array(
        // Shipping
        array('q' => 'Ship bao lâu?', 'a' => 'Thời gian giao hàng trong vòng 2-5 ngày làm việc tùy vùng.', 'cat' => 'shipping'),
        array('q' => 'Có giao hàng trong ngày không?', 'a' => 'Tùy khu vực, có một số khu vực nội thành hỗ trợ giao trong ngày.', 'cat' => 'shipping'),

        // Payment
        array('q' => 'Thanh toán bằng phương thức nào?', 'a' => 'Chúng tôi chấp nhận thanh toán COD, chuyển khoản ngân hàng và thanh toán qua VNPay/OnePay.', 'cat' => 'payment'),
        array('q' => 'Có lưu thẻ để thanh toán lần sau không?', 'a' => 'Chúng tôi không lưu thông tin thẻ. Nếu sử dụng ví điện tử, hệ thống của nhà cung cấp có thể lưu token.', 'cat' => 'payment'),

        // Returns
        array('q' => 'Chính sách đổi trả như thế nào?', 'a' => 'Sản phẩm hỏng/không đúng mô tả sẽ được đổi trả trong vòng 7 ngày kèm hóa đơn.', 'cat' => 'returns'),
        array('q' => 'Tôi muốn trả hàng thì phí ai chịu?', 'a' => 'Nếu lỗi từ phía chúng tôi sẽ chịu phí trả hàng; trường hợp khách hàng đổi ý có thể mất phí.', 'cat' => 'returns'),

        // Products
        array('q' => 'Sản phẩm có chứng nhận organic không?', 'a' => 'Mô tả sản phẩm sẽ nêu rõ chứng nhận (USDA, EU Organic, hoặc giấy chứng nhận địa phương).', 'cat' => 'products'),
        array('q' => 'Sản phẩm có hết hạn sử dụng không?', 'a' => 'Tất cả sản phẩm đều có ngày sản xuất và hạn sử dụng; vui lòng xem chi tiết trên trang sản phẩm.', 'cat' => 'products'),

        // Storage
        array('q' => 'Bảo quản rau củ thế nào?', 'a' => 'Bảo quản trong ngăn mát, rửa trước khi dùng; với rau lá nên bọc giấy thấm.', 'cat' => 'storage'),
        array('q' => 'Có cách giữ trái cây tươi lâu hơn không?', 'a' => 'Bảo quản ở nhiệt độ phòng cho trái cây chín; vào tủ lạnh nếu muốn kéo dài thời gian.', 'cat' => 'storage'),

        // Account & Orders
        array('q' => 'Làm sao kiểm tra lịch sử đơn hàng?', 'a' => 'Vào My Account → Orders để theo dõi trạng thái đơn.', 'cat' => 'orders'),
        array('q' => 'Tôi quên mật khẩu thì làm sao?', 'a' => 'Dùng chức năng "Quên mật khẩu" trên trang đăng nhập để đặt lại.', 'cat' => 'orders'),

        // Subscription
        array('q' => 'Có gói đăng ký rau hàng tuần không?', 'a' => 'Có — bạn có thể đăng ký Subscription Box, thanh toán tự động theo chu kỳ.', 'cat' => 'subscription'),
        array('q' => 'Làm sao hủy gói đăng ký?', 'a' => 'Vào dashboard → Subscriptions → Hủy gói hoặc liên hệ support để được giúp.', 'cat' => 'subscription'),

        // Certifications & Traceability
        array('q' => 'Làm thế nào để kiểm tra nguồn gốc sản phẩm?', 'a' => 'Mỗi sản phẩm có mã trace. Quét QR code trên bao bì để xem thông tin nông trại.', 'cat' => 'traceability'),
        array('q' => 'Chứng nhận hữu cơ có kiểm chứng không?', 'a' => 'Chúng tôi chỉ hợp tác với nhà cung cấp có chứng nhận; ảnh chứng nhận được upload trên trang nhà cung cấp.', 'cat' => 'traceability'),

        // Promotions
        array('q' => 'Làm sao nhận thông tin khuyến mãi?', 'a' => 'Đăng ký email (footer) để nhận thông báo khi có sản phẩm mới & khuyến mãi.', 'cat' => 'promotions'),
        array('q' => 'Có voucher/buôn mã giảm giá cho đơn đầu không?', 'a' => 'Thường có mã giảm cho lần đầu, xem popup hoặc landing page khuyến mãi.', 'cat' => 'promotions'),
    );

    // create categories first (slug -> name mapping)
    $cat_map = array(
        'shipping' => 'Giao hàng',
        'payment' => 'Thanh toán',
        'returns' => 'Đổi trả',
        'products' => 'Sản phẩm',
        'storage' => 'Bảo quản',
        'orders' => 'Tài khoản & Đơn hàng',
        'subscription' => 'Gói đăng ký',
        'traceability' => 'Nguồn gốc & Chứng nhận',
        'promotions' => 'Khuyến mãi',
    );

    foreach ($cat_map as $slug => $name) {
        if (!term_exists($slug, 'faq_category')) {
            wp_insert_term($name, 'faq_category', array('slug' => $slug));
        }
    }

    // insert FAQ posts
    foreach ($data as $item) {
        $title = $item['q'];
        $content = $item['a'];
        // prevent duplicate by checking same title exist
        $existing = get_page_by_title($title, OBJECT, 'faq');
        if ($existing) continue;

        $post_id = wp_insert_post(array(
            'post_title' => wp_strip_all_tags($title),
            'post_content' => $content,
            'post_status' => 'publish',
            'post_type' => 'faq',
        ));

        if ($post_id && !is_wp_error($post_id)) {
            // set category
            if (!empty($item['cat'])) {
                $term = get_term_by('slug', $item['cat'], 'faq_category');
                if ($term) {
                    wp_set_post_terms($post_id, array($term->term_id), 'faq_category', false);
                }
            }
        }
    }

    // done
}
 // end seeder


/**
 * Helper: inline SVG leaf icon
 */
function fcs_leaf_svg()
{
    return '<svg class="fcs-leaf" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M20 4c0 5-4 9-9 9S2 9 2 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M20 20c0-5-4-9-9-9S2 15 2 20" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>';
}


/**
 * Default CSS (returned as string) — used if assets file missing
 */
function fcs_get_default_css()
{
    return '
    /* Simple Organic FAQ Center Styles */
    .fcs-faq-center{ max-width:1100px; margin:40px auto; font-family:system-ui, -apple-system, "Helvetica Neue", Arial; color:#2b2b2b; padding:20px;}
    .fcs-header .fcs-title{ font-size:28px; margin:0 0 6px; color:#184d47;}
    .fcs-header .fcs-sub{ margin:0 0 18px; color:#546b63;}
    .fcs-search{ display:flex; gap:8px; margin-bottom:16px; }
    .fcs-search input[type="text"]{ flex:1; padding:10px 12px; border-radius:10px; border:1px solid #e6e6e6; box-shadow:0 1px 3px rgba(0,0,0,0.03);}
    .fcs-search button{ padding:10px 16px; border-radius:10px; background:#7bc043; color:#fff; border:0; cursor:pointer;}
    .fcs-cats{ display:flex; flex-wrap:wrap; gap:8px; margin-bottom:18px;}
    .fcs-cat{ padding:6px 10px; border-radius:18px; background:#f1f7f3; color:#1f4b45; text-decoration:none; font-size:14px; border:1px solid transparent;}
    .fcs-cat.active{ background:#7bc043; color:#fff; border-color: rgba(0,0,0,0.06);}
    .fcs-list{ display:flex; flex-direction:column; gap:10px;}
    .fcs-item{ border-radius:12px; overflow:hidden; border:1px solid #e6efe9; background:#ffffff; box-shadow:0 6px 18px rgba(24,77,71,0.03);}
    .fcs-q{ width:100%; display:flex; align-items:center; gap:12px; padding:14px 18px; background:linear-gradient(90deg, rgba(123,192,67,0.04), rgba(0,0,0,0)); border:0; cursor:pointer; text-align:left; font-size:16px;}
    .fcs-icon{ display:inline-flex; width:24px; height:24px; align-items:center; justify-content:center; color:#7bc043; }
    .fcs-q-text{ flex:1; font-weight:600; color:#173f3a;}
    .fcs-toggle{ font-weight:700; color:#2f6a5f;}
    .fcs-a{ display:none; padding:14px 18px 18px; border-top:1px solid #eef6f0; color:#3b5650; line-height:1.6;}
    .fcs-item.active .fcs-a{ display:block;}
    .fcs-meta{ margin-top:12px; font-size:13px; color:#6b7f79;}
    .fcs-no{ padding:20px; text-align:center; color:#6b6b6b;}
    /* animation */
    .fcs-q .fcs-toggle{ transition: transform .25s ease; }
    .fcs-item.active .fcs-q .fcs-toggle{ transform: rotate(45deg); }
    @media (max-width:680px){ .fcs-faq-center{ padding:12px;} .fcs-q-text{ font-size:15px;} .fcs-search button{ padding:9px 12px;} }
    ';
}

/**
 * Default JS (returned as string) — used if assets file missing
 * Simple accessible accordion behavior
 */
function fcs_get_default_js()
{
    return '
    (function(){
        document.addEventListener("DOMContentLoaded", function(){
            function toggleItem(el){
                el.classList.toggle("active");
            }
            var items = document.querySelectorAll(".fcs-item");
            items.forEach(function(item){
                var btn = item.querySelector(".fcs-q");
                btn.addEventListener("click", function(){
                    // optional: close others (accordion single-open)
                    items.forEach(function(i){ if(i!==item) i.classList.remove("active"); });
                    toggleItem(item);
                });
                // allow keyboard enter/space
                item.addEventListener("keydown", function(e){
                    if(e.key === "Enter" || e.key === " "){
                        e.preventDefault();
                        btn.click();
                    }
                });
            });
        });
    })();
    ';
}

/**
 * Optional: add tiny admin notice if seeded for dev awareness (non-intrusive)
 */
function fcs_admin_seed_notice()
{
    if (get_option('fcs_seeded') === '1') {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-success is-dismissible"><p>FAQ Center Seeder: dữ liệu mẫu đã được tạo (20 câu hỏi).</p></div>';
        });
    }
}
add_action('admin_init', 'fcs_admin_seed_notice');
