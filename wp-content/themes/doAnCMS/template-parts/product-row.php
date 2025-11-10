<?php
/**
 * Template part để hiển thị một hàng sản phẩm theo danh mục.
 *
 * Bro truyền vào một mảng $args khi gọi get_template_part():
 * $args = [
 * 'title' => 'Tiêu đề mục',
 * 'slug'  => 'slug-danh-muc'
 * ];
 */

// Lấy biến title và slug từ $args
$section_title = $args['title'] ?? 'Sản phẩm'; // Dùng 'Sản phẩm' làm mặc định
$category_slug = $args['slug']  ?? '';

// Không chạy gì cả nếu không có slug
if ( empty($category_slug) ) {
    return;
}

// 1. Tạo WP_Query
$args_query = [
    'post_type'      => 'product',
    'posts_per_page' => 5,
    'tax_query'      => [
        [
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => $category_slug,
        ],
    ],
];

$products_query = new WP_Query($args_query);

// 2. Bắt đầu hiển thị HTML
?>
<div class="container">
    <h2 class="section-title"><?php echo esc_html($section_title); ?></h2> 
    
    <div class="product-grid">
        <?php
        if ($products_query->have_posts()) :
            while ($products_query->have_posts()) : $products_query->the_post();
                
                global $product;
                
                if ( ! is_a( $product, 'WC_Product' ) ) {
                    continue; 
                }
        ?>

                <div class="product-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('medium', ['class' => 'product-image']); ?>
                    <?php endif; ?>
                    <div class="product-info">
                        <div class="product-name"><?php the_title(); ?></div>
                        <div class="product-price">
                            <?php echo $product->get_price_html(); ?>
                        </div>
                    </div>
                </div>

        <?php
            endwhile;
            wp_reset_postdata();
        else :
            // (Tùy chọn) Hiển thị thông báo nếu không có sản phẩm
            // echo '<p>Chưa có sản phẩm nào trong mục này.</p>';
        endif;
        ?>
    </div>
</div>