<?php get_header(); ?>

<div class="banner">
    <div class="banner-container">
      <div class="sidebar">
    <?php
    wp_list_categories([
        'title_li'   => '',
        'taxonomy'   => 'product_cat', // <-- Đây là mấu chốt
        'show_count' => 1,             // Tùy chọn: Hiển thị số lượng sản phẩm
        'hierarchical' => 1            // Tùy chọn: Hiển thị theo cấp bậc cha-con
    ]);
    ?>
</div>
<div class="banner-slider">
    <?php
echo do_shortcode('[smartslider3 slider="3"]');
?>
</div>
    </div>
</div>

<div class="container">

    <div class="category-grid"> <?php
        $args = [
            'taxonomy'   => 'product_cat',
            'orderby'    => 'name',
            'parent'     => 0, // Chỉ lấy danh mục cha
            'hide_empty' => false // Bro có thể đổi thành true nếu muốn ẩn danh mục trống
        ];

        // Lấy tất cả danh mục sản phẩm
        $product_categories = get_terms($args);

        if ( ! empty($product_categories) && ! is_wp_error($product_categories) ) {
            foreach ($product_categories as $category) {
                // Lấy ảnh thumbnail của danh mục
                $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                $image_url = wp_get_attachment_url($thumbnail_id);
                // Nếu không có ảnh, dùng placeholder
                if ( ! $image_url ) {
                    $image_url = wc_placeholder_img_src(); // Lấy ảnh placeholder của WC
                }

                // Lấy link của danh mục
                $category_link = get_term_link($category);
                ?>
                
                <a href="<?php echo esc_url($category_link); ?>" class="category-card">
                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($category->name); ?>" class="category-image">
                    <h3 class="category-name"><?php echo esc_html($category->name); ?></h3>
                </a>

                <?php
            }
        }
        ?>
    </div>
</div>  
    </div>


<div class="container">
    <h2 class="section-title">Sản phẩm nổi bật</h2>
    <div class="product-grid">
        <?php
$products = new WP_Query([
    'post_type' => 'product',
    'posts_per_page' => 5,
    'orderby' => 'rand'
]);

if ($products->have_posts()) :
    while ($products->have_posts()) : $products->the_post();
    
        // Cần phải lấy product object để dùng hàm của WC
        // Cách dễ nhất là dùng global $product
        global $product;
        
        // Hoặc dùng cách rõ ràng hơn:
        // $product = wc_get_product( get_the_ID() );

        // Đảm bảo rằng $product là một đối tượng hợp lệ
        if ( ! is_a( $product, 'WC_Product' ) ) {
            continue; // Bỏ qua nếu không phải sản phẩm
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
endif;
?>
    </div>
</div>

<?php
// Tạo một mảng chứa tất cả các mục mà bro muốn hiển thị
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
        'title' => 'Các loại thực phầm hữu cơ',
        'slug'  => 'thuc-pham-huu-co'
    ]
    // Thêm bao nhiêu mục tùy thích...
];

// Dùng vòng lặp để gọi template part cho mỗi mục
foreach ($product_sections as $section) {
    get_template_part('template-parts/product-row', null, $section);
}
?>


<?php get_footer(); ?>
