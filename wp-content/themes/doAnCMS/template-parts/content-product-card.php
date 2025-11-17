<?php
/**
 * Template Part: Product Card
 * Dùng trong file taxonomy-product_cat.php
 */

// Lấy đối tượng product. Phải có global $post
global $post;
$product = wc_get_product($post);
if (!($product instanceof WC_Product)) {
    return;
}
?>

<div class="product-card">
    <a href="<?php the_permalink(); ?>">
        <?php
        // Sử dụng hàm của Woo, nó tự xử lý placeholder luôn
        echo woocommerce_get_product_thumbnail('medium', ['class' => 'product-image']);
        ?>
    </a>

    <div class="product-info">
        <h3 class="product-name">
            <a href="<?php the_permalink(); ?>" style="color:#000; text-decoration:none;">
                <?php the_title(); ?>
            </a>
        </h3>

        <div class="product-price">
            <?php echo wp_kses_post($product->get_price_html() ?: 'Liên hệ để biết giá'); ?>
        </div>
        <?php
        /**
         * Thêm nút "Add to cart"
         * Nó sẽ tự động là nút AJAX (nếu bro bật trong setting của Woo)
         * Nó cũng tự xử lý cho sản phẩm có biến thể (variable products)
         */
        woocommerce_template_loop_add_to_cart();
        ?>
    </div>
</div>