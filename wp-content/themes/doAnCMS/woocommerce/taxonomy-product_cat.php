<?php
                                                                                                    /**
                                                                                                     * WooCommerce Product Category Template
                                                                                                     * File: wp-content/themes/html_cms/taxonomy-product_cat.php
                                                                                                     */

                                                                                                    get_header();

                                                                                                    // Lấy thông tin danh mục hiện tại
                                                                                                    $term = get_queried_object();
                                                                                                    $cat_title = $term->name ?? '';
                                                                                                    $cat_description = term_description($term->term_id, 'product_cat');
                                                                                                    ?>

<div class="banner">
    <div class="banner-container">
        <aside class="sidebar">
            <ul class="product-category-list">
                <?php
                    // Lấy danh mục gốc (level 1)
                    $product_categories = get_terms([
                        'taxonomy'   => 'product_cat',
                        'orderby'    => 'name',
                        'hide_empty' => false,
                        'parent'     => 0,
                    ]);

                    if (!empty($product_categories) && !is_wp_error($product_categories)) {
                        foreach ($product_categories as $prod_cat) {
                            $active_class = (isset($term->term_id) && $term->term_id === $prod_cat->term_id)
                                ? ' class="active"' : '';

                            printf(
                                '<li%s><a href="%s">%s</a></li>',
                                $active_class,
                                esc_url(get_term_link($prod_cat->term_id, 'product_cat')),
                                esc_html($prod_cat->name)
                            );
                        }
                    }
                    ?>
            </ul>
        </aside>

        <div class="banner-image">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/banners/banner3.png'); ?>"
                alt="Banner">
        </div>
    </div>
</div>

<main class="container">
    <h2 class="section-title">
        Danh mục: <?php echo esc_html($cat_title); ?>
    </h2>

    <?php if ($cat_description) : ?>
    <div class="category-description">
        <?php echo wp_kses_post(wpautop($cat_description)); ?>
    </div>
    <?php endif; ?>

    <?php if (have_posts()) : ?>
    <div class="product-grid">
        <?php while (have_posts()) : the_post(); ?>
        <?php
                    $product = wc_get_product(get_the_ID());
                    ?>
        <div class="product-card">
            <a href="<?php the_permalink(); ?>">
                <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('medium', ['class' => 'product-image']); ?>
                <?php else : ?>
                <img src="<?php echo esc_url(wc_placeholder_img_src()); ?>" class="product-image"
                    alt="<?php the_title_attribute(); ?>">
                <?php endif; ?>
            </a>

            <div class="product-info">
                <h3 class="product-name">
                    <a href="<?php the_permalink(); ?>" style="color:#000; text-decoration:none;">
                        <?php the_title(); ?>
                    </a>
                </h3>

                <?php if ($product instanceof WC_Product) : ?>
                <div class="product-price">
                    <?php echo wp_kses_post($product->get_price_html() ?: 'Liên hệ để biết giá'); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
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
    <p>Không có sản phẩm nào trong danh mục này.</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>