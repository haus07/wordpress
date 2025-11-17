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
    $categories = ['Healthy Living', 'Nutrition Tips', 'Organic Recipes'];

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
        $category_name = $categories[array_rand($categories)];
        $category_id = get_cat_ID($category_name);
        if ($category_id == 0) $category_id = wp_create_category($category_name);
        $image_file = $image_folder . 'blog' . ($index + 1) . '.jpg';

        // Content dài ví dụ (placeholder)
        $content = "Đây là nội dung mẫu dài cho bài viết: $title.\n\n";
        $content = '
<h2>Organic protein là gì?</h2>
<p>Organic protein là một dạng protein có nguồn gốc từ thực phẩm được nuôi trồng theo phương pháp hữu cơ, không dùng phân bón hóa học, không chứa hóa chất, không chứa chất phụ gia, không biến đổi gen,… Các sản phẩm protein hữu cơ thường được sản xuất từ các loại hạt dinh dưỡng, hạt giống, cây cỏ, các loại đậu và các nguồn thực phẩm chứa protein trong tự nhiên.</p>
<figure>
    <img src="' . get_stylesheet_directory_uri() . '/assets/images/blog/blog-detail1.jpg" alt="Lợi ích của rau hữu cơ" style="max-width:100%; height:auto;">
    <figcaption style="text-align:center; font-style:italic; margin-top:5px;">Organic protein có nguồn gốc từ thực vật</figcaption>
</figure>
<p>Đặc điểm của organic protein là:</p>
<ul>
    <li>Chế biến từ nguồn nguyên liệu hoàn toàn từ thực vật, không sử dụng nguồn nguyên liệu từ động vật.</li>
    <li>Thành phần dinh dưỡng phong phú, cung cấp đầy đủ protein, chất xơ, canxi, vitamin, khoáng chất, acid amin thiết yếu cho cơ thể.</li>
    <li>Ngoài công dụng bổ sung protein lành mạnh, organic protein còn giúp tăng cường thể lực và sức đề kháng cho cơ thể.</li>
</ul>
<h2>Dùng organic protein có giảm cân không?</h2>
<p>Không thể phủ nhận công dụng của organic protein, tuy nhiên, dùng organic protein có giảm cân không? Câu trả lời của các chuyên gia là hoàn toàn có thể. Cùng khám phá xem loại protein hữu cơ có nguồn gốc thực vật này sẽ giúp bạn giảm cân như thế nào nhé!</p>
<h2>Organic protein tạo cảm giác no lâu, hạn chế thèm ăn</h2>
<p>Giống như bất kỳ loại protein nào khác, organic protein nguồn gốc thực vật cũng giúp tạo cảm giác no lâu. Khi tiêu thụ organic protein, cơ thể bạn cần nhiều thời gian hơn để tiêu hóa, vì vậy sẽ hạn chế cảm giác đói bụng, thèm ăn và ham muốn ăn vặt.

Một kết quả nghiên cứu cho thấy sau các bữa ăn chứa 25 - 81% protein, cảm giác no sẽ tăng đáng kể. Nghiên cứu khác cũng chỉ ra rằng nếu tăng lượng protein trong bữa ăn lên 15 - 30%, bạn có thể giảm lượng calo tiêu thụ hàng ngày xuống 411 calo.</p>
<figure>
    <img src="' . get_stylesheet_directory_uri() . '/assets/images/blog/blog-detail2.jpg" alt="Lợi ích của rau hữu cơ" style="max-width:100%; height:auto;">
    <figcaption style="text-align:center; font-style:italic; margin-top:5px;">Đến đây bạn đã biết organic protein có giảm cân không rồi chứ?</figcaption>
</figure>
<h2>Organic protein giúp giảm cân nhưng không bị giảm cơ</h2>
<p>Protein là nhóm chất cực quan trọng đối với việc duy trì cơ bắp. Một số người trong quá trình giảm cân cũng bị giảm cơ, mất cơ.

Những người thừa cân, béo phì có thể bị mất đến 30% khối lượng cơ trong quá trình giảm cân nhanh. Điều này sẽ được hạn chế đáng kế nếu bạn bổ sung vào chế độ ăn uống đúng cách. Không những hạn chế mất cơ khi giảm cân, organic protein còn giúp xây dựng cơ bắp, giúp bạn giảm cân nhưng vẫn sở hữu được thân hình săn chắc lý tưởng.</p>
<h2>Organic protein giúp tăng cường trao đổi, chuyển hóa chất</h2>
<p>Một chế độ ăn giàu organic protein có thể kích thích quá trình trao đổi và chuyển hóa các chất trong cơ thể, giúp cơ thể đốt cháy nhiều calo hơn ngay cả khi cơ thể trong trạng thái nghỉ ngơi. Các kết quả nghiên cứu cho thấy chế độ ăn giàu protein giúp tiêu hao thêm 70 - 200 calo mỗi ngày.</p>
<h2>Dùng organic protein giảm cân thế nào tốt nhất?</h2>
<p>Organic protein có giảm cân không? Câu trả lời là có. Vậy sử dụng organic protein thế nào để đạt hiệu quả giảm cân tốt nhất?

Trên thị trường hiện nay có nhiều dòng sản phẩm organic protein với thành phần có nguồn gốc từ đậu nành hữu cơ, hạt chia hữu cơ, hạt lanh hữu cơ hay sản phẩm có thành phần tổng hợp các loại hạt hữu cơ,… Việc bạn nên sử dụng sản phẩm nào phụ thuộc vào khẩu vị, sở thích của bạn và mục tiêu sử dụng.

Thông thường, organic protein tổng hợp từ các loại hạt là một lựa chọn được cho là hoàn hảo nhất. Những sản phẩm này cung cấp protein đa dạng, mang đến lợi ích dinh dưỡng tổng hợp từ nhiều loại hạt khác nhau.

</p>
<figure>
    <img src="' . get_stylesheet_directory_uri() . '/assets/images/blog/blog-detail3.jpg" alt="Lợi ích của rau hữu cơ" style="max-width:100%; height:auto;">
    <figcaption style="text-align:center; font-style:italic; margin-top:5px;">Organic protein không những hỗ trợ giảm cân mà còn hạn chế tăng cân trở lại</figcaption>
</figure>
<p>Uống organic protein là một phần của chế độ ăn uống cân đối. Bạn có thể dùng organic protein như một phần thay thế bữa ăn. Thay vì ăn một bữa ăn đầy đủ như bình thường, bạn có thể kết hợp bột organic protein với nước, sữa không đường, nước trái cây, nước ép,...

Tuy nhiên, organic protein không thể thay thế hoàn toàn chế độ ăn thông thường. Để có thể giảm cân nhưng vẫn đảm bảo sức khỏe, bạn nên tăng cường ăn rau xanh, trái cây và uống đủ 2 - 2,5 lít nước mỗi ngày. Các chế độ ăn kiêng chuẩn khoa học sẽ rất hữu ích đối với những ai muốn giảm cân, siết dáng.

Cách giảm cân lành mạnh không chỉ phụ thuộc vào chế độ ăn uống. Ngoài dùng organic protein và các thực phẩm giúp giảm cân, bạn còn cần duy trì một chế độ vận động và tập luyện khoa học. Bằng cách tăng lượng calo được cơ thể đốt cháy trong quá trình tập luyện, bạn có thể giảm cân hiệu quả hơn.

Với những thông tin trên đây, hy vọng bạn đã giải đáp được thắc mắc organic protein có giảm cân không và dùng organic protein thế nào hiệu quả nhất. Hãy lựa chọn những sản phẩm an toàn, chất lượng và bắt đầu kế hoạch giảm cân ngay hôm nay bạn nhé!</p>
';



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
