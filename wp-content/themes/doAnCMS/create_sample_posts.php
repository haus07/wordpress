<?php
// if (!function_exists('doAnCMS_create_sample_posts')) {

//     function doAnCMS_create_sample_posts()
//     {
//         $existing_posts = get_posts(array(
//             'post_type' => 'post',
//             'numberposts' => 1
//         ));
//         if ($existing_posts) return; // tránh tạo nhiều lần

//         // Danh sách tiêu đề liên quan đến Organic Food
//         $titles = array(
//             "Lợi ích tuyệt vời của Organic Food cho sức khỏe",
//             "5 món ăn Organic dễ làm tại nhà",
//             "Tại sao nên chọn thực phẩm Organic hàng ngày",
//             "Organic Food và tác động đến môi trường",
//             "Top 10 sản phẩm Organic bạn nên thử",
//             "Hướng dẫn nhận biết thực phẩm Organic thật",
//             "Organic Food cho trẻ em: An toàn và bổ dưỡng",
//             "Cách bảo quản thực phẩm Organic lâu dài",
//             "Xu hướng Organic Food năm 2025",
//             "Organic Food: Bí quyết sống khỏe mỗi ngày"
//         );

//         for ($i = 0; $i < 10; $i++) {

//             $post_id = wp_insert_post(array(
//                 'post_title'   => $titles[$i],
//                 'post_content' => 'Đây là nội dung mẫu cho bài viết: "' . $titles[$i] . '". Lorem ipsum dolor sit amet, consectetur adipiscing elit. Thực phẩm Organic giúp bạn sống khỏe mạnh hơn.',
//                 'post_status'  => 'publish',
//                 'post_author'  => 1,
//             ));

//             // Gán ảnh đại diện
//             $img_path = get_template_directory() . '/assets/images/blog' . ($i + 1) . '.jpg';
//             if (file_exists($img_path)) {
//                 $upload = wp_upload_bits('blog' . ($i + 1) . '.jpg', null, file_get_contents($img_path));
//                 $wp_filetype = wp_check_filetype($upload['file'], null);
//                 $attachment = array(
//                     'post_mime_type' => $wp_filetype['type'],
//                     'post_title'     => 'Blog ' . ($i + 1),
//                     'post_content'   => '',
//                     'post_status'    => 'inherit'
//                 );
//                 $attach_id = wp_insert_attachment($attachment, $upload['file'], $post_id);
//                 require_once(ABSPATH . 'wp-admin/includes/image.php');
//                 $attach_data = wp_generate_attachment_metadata($attach_id, $upload['file']);
//                 wp_update_attachment_metadata($attach_id, $attach_data);
//                 set_post_thumbnail($post_id, $attach_id);
//             }
//         }
//     }
