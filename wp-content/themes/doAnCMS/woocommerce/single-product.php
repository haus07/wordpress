<?php
if (! defined('ABSPATH')) exit;

get_header('shop');
?>

<div class="breadcrumb container">
    <?php woocommerce_breadcrumb(); ?>
</div>

<?php while (have_posts()) : the_post();
    global $product; ?>

    <div class="container product-wrapper">

        <!-- Product Main Section -->
        <div id="product-<?php the_ID(); ?>" <?php wc_product_class('product-section', $product); ?>>

            <!-- Product Gallery -->
            <div class="product-gallery">
                <?php woocommerce_show_product_images(); ?>
            </div>

            <!-- Product Info -->
            <div class="product-info">
                <?php
                woocommerce_template_single_title();
                woocommerce_template_single_price();

                // 1. THÊM MÔ TẢ NGẮN (QUAN TRỌNG)
                woocommerce_template_single_excerpt();
                ?>
                <p class="view-count">Lượt xem: <?php echo deluxe_get_post_views(get_the_ID()); ?></p>
                <div class="product-stock">
                    <?php if (! $product->is_in_stock()) : ?>
                        <p class="stock out-of-stock">Hết hàng</p>
                    <?php else: ?>
                        <p class="stock in-stock" style="color:#6b9d3e; font-weight:600;"><i class="fa fa-check-circle"></i> Còn hàng</p>
                    <?php endif; ?>
                </div>

                <div class="product-add-to-cart">
                    <?php woocommerce_template_single_add_to_cart(); ?>
                </div>

                <div class="product-trust-badges">
                    <div class="badge-item">
                        <img src="https://img.icons8.com/ios/50/6b9d3e/shipped.png" alt="Free Ship">
                        <div class="badge-text">
                            <strong>Miễn phí vận chuyển</strong>
                            <span>Cho đơn hàng từ 500k</span>
                        </div>
                    </div>
                    <div class="badge-item">
                        <img src="https://img.icons8.com/ios/50/6b9d3e/natural-food.png" alt="Organic">
                        <div class="badge-text">
                            <strong>100% Organic</strong>
                            <span>Chứng nhận hữu cơ quốc tế</span>
                        </div>
                    </div>
                    <div class="badge-item">
                        <img src="https://img.icons8.com/ios/50/6b9d3e/return-purchase.png" alt="Return">
                        <div class="badge-text">
                            <strong>Đổi trả 7 ngày</strong>
                            <span>Nếu có lỗi từ nhà sản xuất</span>
                        </div>
                    </div>
                </div>

                <div class="product-meta">
                    <?php woocommerce_template_single_meta(); ?>
                </div>

                <div class="product-share-box">
                    <span>Chia sẻ:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink(); ?>" target="_blank" class="share-btn fb">Facebook</a>
                    <a href="#" class="share-btn zalo">Zalo</a>
                    <a href="https://twitter.com/intent/tweet?url=<?php echo get_permalink(); ?>" target="_blank" class="share-btn tw">Twitter</a>
                </div>
            </div>

        </div>

        <!-- Tabs -->
        <div class="tabs">
            <?php woocommerce_output_product_data_tabs(); ?>
        </div>

        <!-- Related Products -->
        <?php woocommerce_output_related_products(); ?>

    </div>

<?php endwhile; ?>

<?php get_footer('shop'); ?>