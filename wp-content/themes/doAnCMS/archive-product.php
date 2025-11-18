<?php

/**
 * Template Name: Deluxe Shop Page (Centered + Green Buttons)
 */
if (!defined('ABSPATH')) exit;
get_header();
?>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/shop-deluxe.css">

<header class="shop-hero">
    <div class="shop-hero-inner">
        <h1 class="reveal">Organic Shop</h1>
        <p class="reveal delay-1">Thực phẩm hữu cơ - Sống sạch, sống khỏe.</p>
    </div>
</header>

<main class="container shop-container">
    <div class="shop-layout-container">
        <!-- Shop Content -->
        <div class="shop-content">
            <?php if (have_posts()) : ?>
                <!-- Toolbar -->
                <div class="shop-toolbar deluxe-toolbar reveal">
                    <div class="sort-by"><?php woocommerce_catalog_ordering(); ?></div>
                    <div class="show-count"><?php echo sprintf('Hiển thị %d sản phẩm', $wp_query->post_count); ?></div>
                </div>

                <!-- Product Grid (Centered) -->
                <div class="product-grid center-grid">
                    <?php while (have_posts()) : the_post();
                        global $product; ?>
                        <div <?php wc_product_class('product-card', $product); ?>>
                            <!-- Product Image -->
                            <a href="<?php the_permalink(); ?>" class="product-image">
                                <?php echo woocommerce_get_product_thumbnail('medium'); ?>
                            </a>

                            <!-- Product Info -->
                            <h3 class="product-title"><?php the_title(); ?></h3>
                            <span class="product-price"><?php echo $product->get_price_html(); ?></span>

                            <!-- Custom Add-to-Cart -->
                            <div class="product-add-to-cart custom-add-to-cart">
                                <?php
                                echo sprintf(
                                    '<a href="%s" data-quantity="1" class="custom-cart-button button" %s>Thêm vào giỏ</a>',
                                    esc_url($product->add_to_cart_url()),
                                    wc_implode_html_attributes(array(
                                        'data-product_id' => $product->get_id(),
                                        'data-product_sku' => $product->get_sku(),
                                        'aria-label' => sprintf(__('Thêm "%s" vào giỏ', 'woocommerce'), $product->get_name()),
                                        'rel' => 'nofollow'
                                    ))
                                );
                                ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- Pagination -->
                <div class="pagination reveal">
                    <?php
                    the_posts_pagination([
                        'mid_size'  => 2,
                        'prev_text' => __('« Trước', 'html_cms'),
                        'next_text' => __('Sau »', 'html_cms'),
                    ]);
                    ?>
                </div>

            <?php else : ?>
                <p>Không có sản phẩm nào.</p>
            <?php endif; ?>
        </div>

    </div>
</main>

<?php get_footer(); ?>

<style>
    /* ===== Banner Zoom ===== */
    .shop-hero {
        height: 400px;
        background: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/images/blog/blog2.jpg') center/cover no-repeat;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #fff;
        overflow: hidden;
        position: relative;
        animation: zoomBanner 20s infinite alternate ease-in-out;
    }

    @keyframes zoomBanner {
        0% {
            transform: scale(1);
        }

        100% {
            transform: scale(1.1);
        }
    }

    /* ===== Layout Sidebar + Content ===== */
    .shop-layout-container {
        display: flex;
        gap: 30px;
    }

    .sidebar {
        width: 250px;
    }

    .shop-content {
        flex: 1;
    }

    /* ===== Product Grid Center ===== */
    .product-grid.center-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
    }

    /* ===== Product Card ===== */
    .product-card {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        padding: 15px;
        width: 250px;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .product-add-to-cart.custom-add-to-cart {
        margin-top: auto;
        /* đẩy nút xuống cuối card */
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12);
    }

    .product-title {
        font-size: 16px;
        margin: 10px 0 6px;
        color: #333;
    }

    .product-price {
        font-weight: 600;
        color: #4CAF50;
    }

    /* ===== Custom Add-to-Cart Button ===== */
    .custom-cart-button {
        display: inline-block;
        background-color: #8BC34A !important;
        color: #fff !important;
        padding: 10px 18px;
        border-radius: 7px !important;
        text-decoration: none;
        font-weight: 600;
        transition: background 0.3s, transform 0.2s;
    }

    .custom-cart-button:hover {
        background-color: #7cb342;
        transform: scale(1.05);
    }

    /* ===== Pagination ===== */
    .pagination {
        margin-top: 20px;
        text-align: center;
    }
</style>