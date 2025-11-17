<?php

/**
 * Template hiển thị 1 hàng sản phẩm theo danh mục – phiên bản SLIDE (Swiper)
 */

$section_title = $args['title'] ?? 'Sản phẩm';
$category_slug = $args['slug']  ?? '';

if (empty($category_slug)) return;

// Query sản phẩm theo slug
$query_args = [
    'post_type'      => 'product',
    'posts_per_page' => 12,
    'tax_query'      => [
        [
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => $category_slug,
        ],
    ],
];

$products_query = new WP_Query($query_args);
?>

<div class="container product-section">
    <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>

    <!-- Swiper container -->
    <div class="swiper product-swiper-<?php echo esc_attr($category_slug); ?>">
        <div class="swiper-wrapper">

            <?php if ($products_query->have_posts()) : ?>
                <?php while ($products_query->have_posts()) : $products_query->the_post(); ?>

                    <?php
                    global $product;
                    if (!is_a($product, 'WC_Product')) continue;

                    $regular_price = (float) $product->get_regular_price();
                    $sale_price    = (float) $product->get_sale_price();
                    $discount      = 0;

                    if ($regular_price > 0 && $sale_price > 0) {
                        $discount = round((($regular_price - $sale_price) / $regular_price) * 100);
                    }
                    ?>

                    <div class="swiper-slide">
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
                    </div>

                <?php endwhile;
                wp_reset_postdata(); ?>
            <?php endif; ?>

        </div>

        <!-- Navigation -->
        <div class="swiper-button-next swiper-button-next-<?php echo esc_attr($category_slug); ?>"></div>
        <div class="swiper-button-prev swiper-button-prev-<?php echo esc_attr($category_slug); ?>"></div>
    </div>
</div>