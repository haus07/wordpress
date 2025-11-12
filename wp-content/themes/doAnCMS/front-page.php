<?php get_header(); ?>

<!-- ===================== BANNER KHUYẾN MÃI ===================== -->
<div class="banner">
    <div class="banner-container">
        <!-- Sidebar danh mục sản phẩm -->
        <div class="sidebar">
            <?php
            wp_list_categories([
                'title_li'     => '',
                'taxonomy'     => 'product_cat',
                'show_count'   => 1,
                'hierarchical' => 1
            ]);
            ?>
        </div>

        <!-- Slider banner chính -->
        <div class="banner-slider">
            <?php echo do_shortcode('[smartslider3 slider="3"]'); ?>
        </div>
    </div>
</div>

<!-- ===================== DANH MỤC CHA ===================== -->
<div class="container">
    <div class="category-grid">
        <?php
        $args = [
            'taxonomy'   => 'product_cat',
            'orderby'    => 'name',
            'parent'     => 0,
            'hide_empty' => false
        ];

        $product_categories = get_terms($args);

        if (!empty($product_categories) && !is_wp_error($product_categories)) :
            foreach ($product_categories as $category) :
                $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                $image_url = wp_get_attachment_url($thumbnail_id);
                if (!$image_url) $image_url = wc_placeholder_img_src();

                $category_link = get_term_link($category);
        ?>
        <a href="<?php echo esc_url($category_link); ?>" class="category-card">
            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($category->name); ?>"
                class="category-image">
            <h3 class="category-name"><?php echo esc_html($category->name); ?></h3>
        </a>
        <?php
            endforeach;
        endif;
        ?>
    </div>
</div>

<!-- ===================== SẢN PHẨM NỔI BẬT ===================== -->
<div class="container">
    <h2 class="section-title">Sản phẩm nổi bật</h2>
    <div class="product-scroll-wrapper">
        <div class="product-grid product-grid-scroll">
            <?php
            // Lấy sản phẩm nổi bật có giảm giá
            $featured_products = wc_get_products([
                'status'         => 'publish',
                'limit'          => 8,
                'orderby'        => 'date',
                'order'          => 'DESC',
                'featured'       => true,
                'meta_query'     => [
                    [
                        'key'     => '_sale_price',
                        'value'   => 0,
                        'compare' => '>',
                        'type'    => 'NUMERIC'
                    ]
                ]
            ]);

            if (!empty($featured_products)) :
                foreach ($featured_products as $product) :
                    $product_id = $product->get_id();
                    $image_url = get_the_post_thumbnail_url($product_id, 'medium') ?: wc_placeholder_img_src();
                    $regular_price = (float) $product->get_regular_price();
                    $sale_price = (float) $product->get_sale_price();
                    $discount = 0;
                    if ($regular_price > 0 && $sale_price > 0) {
                        $discount = round((($regular_price - $sale_price) / $regular_price) * 100);
                    }
            ?>
            <div class="product-card">
                <div class="product-thumb">
                    <a href="<?php echo esc_url(get_permalink($product_id)); ?>">
                        <img src="<?php echo esc_url($image_url); ?>"
                            alt="<?php echo esc_attr($product->get_name()); ?>" class="product-image">
                        <?php if ($discount > 0): ?>
                        <span class="custom-sale-badge">-<?php echo esc_html($discount); ?>%</span>
                        <?php endif; ?>
                    </a>
                </div>
                <div class="product-info">
                    <h3 class="product-name">
                        <a href="<?php echo esc_url(get_permalink($product_id)); ?>">
                            <?php echo esc_html($product->get_name()); ?>
                        </a>
                    </h3>
                    <div class="product-price">
                        <?php echo $product->get_price_html(); ?>
                    </div>
                </div>
            </div>
            <?php
                endforeach;
            else :
                echo '<p>Chưa có sản phẩm nổi bật đang giảm giá.</p>';
            endif;
            ?>
        </div>
    </div>
</div>


<!-- ===================== CÁC NHÓM SẢN PHẨM KHÁC ===================== -->
<?php
$product_sections = [
    [
        'title' => 'Sản phẩm hữu cơ',
        'slug'  => 'san-pham-huu-co'
    ],
    [
        'title' => 'Ngũ cốc dinh dưỡng hữu cơ',
        'slug'  => 'ngu-coc-dinh-duong-huu-co'
    ],
    [
        'title' => 'Các loại hạt và đậu hữu cơ',
        'slug'  => 'dau-va-hat-huu-co'
    ],
    [
        'title' => 'Nui và mì hữu cơ',
        'slug'  => 'nui-mi-huu-co'
    ],
    [
        'title' => 'Các loại thực phẩm hữu cơ',
        'slug'  => 'thuc-pham-huu-co'
    ]
];

// Gọi template part cho từng nhóm
foreach ($product_sections as $section) {
    get_template_part('template-parts/product-row', null, $section);
}
?>

<?php get_footer(); ?>