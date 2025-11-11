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
                ?>

                <div class="product-stock">
                    <?php if (! $product->is_in_stock()) : ?>
                        <p class="stock out-of-stock">Hết hàng</p>
                    <?php endif; ?>
                </div>

                <div class="product-add-to-cart">
                    <?php woocommerce_template_single_add_to_cart(); ?>
                </div>

                <div class="product-meta">
                    <?php woocommerce_template_single_meta(); ?>
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