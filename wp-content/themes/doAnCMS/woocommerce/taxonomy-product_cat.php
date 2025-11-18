<?php
/**
 * WooCommerce Product Category Template
 * File: wp-content/themes/html_cms/taxonomy-product_cat.php
 *
 * ĐÃ REFACTOR BỐ CỤC
 */

get_header();

// Lấy thông tin danh mục hiện tại
$term = get_queried_object();
$cat_title = $term->name ?? '';
$cat_description = term_description($term->term_id, 'product_cat');
?>



<main class="container">
    <div class="shop-header">
        <h2 class="section-title">
            Danh mục: <?php echo esc_html($cat_title); ?>
        </h2>

        <?php if ($cat_description) : ?>
            <div class="category-description">
                <?php echo wp_kses_post($cat_description); ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="shop-layout-container">

        <aside class="sidebar">
            <?php
            // Kiểm tra xem "Shop Sidebar" có widget nào không
            if ( is_active_sidebar( 'shop-sidebar' ) ) {
                dynamic_sidebar( 'shop-sidebar' );
            } else {
                // Hướng dẫn nếu sidebar trống
                echo '<div class="widget"><h4 class="widget-title">Bộ lọc</h4><p>Vui lòng vào Admin -> Giao diện -> Widgets và kéo các widget lọc (ví dụ: Lọc theo giá) vào "Shop Sidebar".</p></div>';
            }
            ?>
        </aside>

        <div class="shop-content">
            <?php if (have_posts()) : ?>
                <div class="shop-toolbar">
                    <?php
                    /**
                     * Hook: woocommerce_before_shop_loop.
                     */
                    do_action('woocommerce_before_shop_loop');
                    ?>
                </div>

                <div class="product-grid">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php
                        // Chỉ cần gọi template part
                        get_template_part('template-parts/content-product-card');
                        ?>
                    <?php endwhile; ?>
                </div>

                <div class="pagination">
                    <?php
                    the_posts_pagination([
                        'mid_size'  => 2,
                        'prev_text' => __('« Trước', 'html_cms'),
                        'next_text' => __('Sau »', 'html_cms'),
                    ]);
                    ?>
                </div>
            <?php else : ?>
                <?php // Vẫn hiển thị toolbar và sidebar ngay cả khi không có sản phẩm ?>
                <div class="shop-toolbar">
                     <?php do_action('woocommerce_before_shop_loop'); ?>
                </div>
                <p>Không có sản phẩm nào trong danh mục này.</p>
            <?php endif; ?>
        </div> </div> </main>

<?php get_footer(); ?>