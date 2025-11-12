<?php
/**
 * Template part để hiển thị một hàng sản phẩm theo danh mục.
 *
 * Bro truyền vào một mảng $args khi gọi get_template_part():
 * $args = [
 *     'title' => 'Tiêu đề mục',
 *     'slug'  => 'slug-danh-muc'
 * ];
 */

// Lấy biến title và slug từ $args
$section_title = $args['title'] ?? 'Sản phẩm'; // Dùng 'Sản phẩm' làm mặc định
$category_slug = $args['slug']  ?? '';

// Không chạy gì cả nếu không có slug
if (empty($category_slug)) {
    return;
}

// 1. Tạo WP_Query
$args_query = [
    'post_type'      => 'product',
    'posts_per_page' => 12, // Tăng lên 12 sản phẩm để cuộn ngang có ý nghĩa
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

    <!-- Wrapper cho thanh cuộn ngang -->
    <div class="product-scroll-wrapper">
        <div class="product-grid product-grid-scroll">
            <?php
            if ($products_query->have_posts()) :
                while ($products_query->have_posts()) : $products_query->the_post();

                    global $product;

                    if (!is_a($product, 'WC_Product')) {
                        continue;
                    }

                    // Tính phần trăm giảm giá
                    $regular_price = (float) $product->get_regular_price();
                    $sale_price = (float) $product->get_sale_price();
                    $discount = 0;

                    if ($regular_price > 0 && $sale_price > 0) {
                        $discount = round((($regular_price - $sale_price) / $regular_price) * 100);
                    }
            ?>

            <div class="product-card">
                <div class="product-thumb">
                    <a href="<?php echo esc_url(get_permalink()); ?>">
                        <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('medium', ['class' => 'product-image']); ?>
                        <?php else : ?>
                        <img src="<?php echo esc_url(wc_placeholder_img_src()); ?>"
                            alt="<?php echo esc_attr(get_the_title()); ?>" class="product-image">
                        <?php endif; ?>

                        <?php if ($discount > 0) : ?>
                        <span class="custom-sale-badge">-<?php echo esc_html($discount); ?>%</span>
                        <?php endif; ?>
                    </a>
                </div>

                <div class="product-info">
                    <h3 class="product-name">
                        <a href="<?php echo esc_url(get_permalink()); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h3>
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
</div>