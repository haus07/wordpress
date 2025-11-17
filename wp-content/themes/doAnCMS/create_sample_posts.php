<?php
// require_once('../../../wp-load.php');

// $posts = [
//     [
//         'title' => 'Organic Apples – Fresh & Healthy',
//         'image' => 'blog1.jpg',
//         'content' => 'Organic apples are a perfect choice for a healthy lifestyle...'
//     ],
//     [
//         'title' => 'Why You Should Switch to Organic Vegetables',
//         'image' => 'blog2.jpg',
//         'content' => 'Organic vegetables help reduce exposure to harmful chemicals...'
//     ],
//     [
//         'title' => 'Top 5 Organic Foods You Should Try',
//         'image' => 'blog3.jpg',
//         'content' => 'Here are the most popular organic foods recommended by experts...'
//     ],
//     [
//         'title' => 'The Benefits of Organic Milk',
//         'image' => 'blog4.jpg',
//         'content' => 'Organic milk contains more nutrients and no antibiotics...'
//     ],
//     [
//         'title' => 'Healthy Organic Breakfast Ideas',
//         'image' => 'blog5.jpg',
//         'content' => 'Start your morning with these organic breakfast options...'
//     ],
//     [
//         'title' => 'Is Organic Food Really Better?',
//         'image' => 'blog6.jpg',
//         'content' => 'Let’s explore the science behind organic vs non-organic foods...'
//     ],
//     [
//         'title' => 'Organic Farming – What You Should Know',
//         'image' => 'blog7.jpg',
//         'content' => 'Organic farming protects the environment and supports biodiversity...'
//     ],
//     [
//         'title' => 'Best Organic Drinks for Daily Health',
//         'image' => 'blog8.jpg',
//         'content' => 'Here are the top benefits of drinking organic beverages...'
//     ],
//     [
//         'title' => 'How to Start Eating Organic on a Budget',
//         'image' => 'blog9.jpg',
//         'content' => 'You can eat organic without spending too much — here’s how...'
//     ],
//     [
//         'title' => 'Why Organic Snacks Are Taking Over the Market',
//         'image' => 'blog10.jpg',
//         'content' => 'Organic snacks are becoming more popular due to clean ingredients...'
//     ]
// ];

// foreach ($posts as $item) {

//     // 1. Tạo bài viết
//     $post_id = wp_insert_post([
//         'post_title'   => $item['title'],
//         'post_content' => $item['content'],
//         'post_status'  => 'publish',
//         'post_author'  => 1,
//         'post_type'    => 'post'
//     ]);

//     // 2. Nếu có ảnh thì gán ảnh đại diện
//     if ($post_id) {
//         $image_path = get_template_directory() . '/assets/images/blog/' . $item['image'];

//         if (file_exists($image_path)) {

//             // Upload vào thư viện WP
//             $upload = wp_upload_bits($item['image'], null, file_get_contents($image_path));

//             if (!$upload['error']) {
//                 $wp_filetype = wp_check_filetype($upload['file'], null);
//                 $attachment = [
//                     'post_mime_type' => $wp_filetype['type'],
//                     'post_title'     => sanitize_file_name($item['image']),
//                     'post_content'   => '',
//                     'post_status'    => 'inherit'
//                 ];

//                 $attach_id = wp_insert_attachment($attachment, $upload['file'], $post_id);

//                 require_once(ABSPATH . 'wp-admin/includes/image.php');
//                 $attach_data = wp_generate_attachment_metadata($attach_id, $upload['file']);
//                 wp_update_attachment_metadata($attach_id, $attach_data);

//                 // Gán featured image
//                 set_post_thumbnail($post_id, $attach_id);
//             }
//         }
//     }
// }

// echo "Tạo 10 bài blog thành công!";
