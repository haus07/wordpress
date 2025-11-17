<?php
/*
Plugin Name: DoAnCMS Sample Posts
Description: Tạo 10 bài viết mẫu khi click nút trong admin, debug đầy đủ.
Version: 1.1
Author: Hoài
*/

if (!defined('ABSPATH')) exit;

// =================== Hàm tạo posts ===================
function doAnCMS_create_sample_blog_posts()
{
    $current_user = get_current_user_id();
    error_log('🔹 Current User ID: ' . $current_user);

    if ($current_user == 0) return;

    // Tạo category
    $category_name = 'Blog Mẫu';
    $category_id = get_cat_ID($category_name);
    if ($category_id == 0) $category_id = wp_create_category($category_name);

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

    // Folder ảnh
    $theme_path = get_stylesheet_directory(); // đường dẫn theme
    $image_folder = $theme_path . '/assets/images/blog/';

    foreach ($titles as $index => $title) {
        $image_file = $image_folder . 'blog' . ($index + 1) . '.jpg';

        // Content dài ví dụ (placeholder)
        $content = "Đây là nội dung mẫu dài cho bài viết: $title.\n\n";
        $content .= str_repeat("Lorem ipsum dolor sit amet, consectetur adipiscing elit. ", 30);

        // Tạo post
        $post_id = wp_insert_post([
            'post_title'    => $title,
            'post_content'  => $content,
            'post_status'   => 'publish',
            'post_author'   => $current_user,
            'post_category' => [$category_id],
        ]);

        if (is_wp_error($post_id) || $post_id == 0) {
            error_log('❌ Lỗi tạo post: ' . ($post_id instanceof WP_Error ? $post_id->get_error_message() : '0'));
            continue;
        }

        // Gán featured image nếu file tồn tại
        if (file_exists($image_file)) {
            $upload_dir = wp_upload_dir();
            $image_data = file_get_contents($image_file);
            $filename = basename($image_file);

            if ($image_data) {
                $file_path = $upload_dir['path'] . '/' . $filename;
                file_put_contents($file_path, $image_data);

                $wp_filetype = wp_check_filetype($filename, null);
                $attachment = [
                    'post_mime_type' => $wp_filetype['type'],
                    'post_title'     => sanitize_file_name($filename),
                    'post_content'   => '',
                    'post_status'    => 'inherit'
                ];
                $attach_id = wp_insert_attachment($attachment, $file_path, $post_id);
                require_once(ABSPATH . 'wp-admin/includes/image.php');
                $attach_data = wp_generate_attachment_metadata($attach_id, $file_path);
                wp_update_attachment_metadata($attach_id, $attach_data);
                set_post_thumbnail($post_id, $attach_id);
            }
        }

        error_log('✅ Post "' . $title . '" được tạo với ID: ' . $post_id);
    }

    error_log('✅ Hoàn tất tạo 10 bài viết mẫu với ảnh và content dài.');
}


// =================== Menu Admin ===================
add_action('admin_menu', function () {
    add_menu_page(
        'Tạo Sample Posts',
        'Tạo Sample Posts',
        'administrator',
        'create-sample-posts',
        'doAnCMS_create_sample_posts_page',
        'dashicons-admin-post',
        20
    );
});

function doAnCMS_create_sample_posts_page()
{
?>
    <div class="wrap">
        <h1>Tạo Sample Posts</h1>
        <form method="post">
            <?php wp_nonce_field('create_sample_posts_action', 'create_sample_posts_nonce'); ?>
            <p>
                <input type="submit" name="create_posts" class="button button-primary" value="Tạo 10 bài viết mẫu">
            </p>
        </form>
        <?php
        if (isset($_POST['create_posts']) && check_admin_referer('create_sample_posts_action', 'create_sample_posts_nonce')) {
            doAnCMS_create_sample_blog_posts();
            echo '<div class="notice notice-success is-dismissible"><p>✅ 10 bài viết mẫu đã được tạo! Kiểm tra bài viết và debug.log.</p></div>';
        }
        ?>
    </div>
<?php
}
