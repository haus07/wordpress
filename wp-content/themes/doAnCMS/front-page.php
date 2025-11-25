<?php get_header(); ?>

<!-- ===================== BANNER KHUYẾN MÃI ===================== -->
<div class="container">

    <div class="top-banner-grid">

        <!-- CỘT TRÁI: SLIDER CHÍNH (Giữ nguyên) -->
        <div class="main-slider-wrapper">
            <?php echo do_shortcode('[smartslider3 slider="3"]'); ?>
        </div>

        <!-- CỘT PHẢI: 2 BANNER DỌC (ĐÃ THAY ẢNH THẬT) -->
        <div class="side-banner-stack">
            <a href="#" class="side-banner-item">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/banners/banner6.jpg" alt="Banner Phụ 1">
            </a>
            <a href="#" class="side-banner-item">
                <!-- 
                  Bro có cả banner7.png và banner7.jpg
                  Tui đang dùng banner7.jpg, bro đổi lại nếu muốn nhé
                -->
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/banners/banner7.jpg" alt="Banner Phụ 2">
            </a>
        </div>

    </div> <!-- Hết .top-banner-grid -->

    <!-- HÀNG 2: 4 BANNER NHỎ (ĐÃ THAY ẢNH THẬT) -->
    <div class="small-banner-grid">
        <a href="#" class="small-banner-item">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/banners/banner8.jpg" alt="Banner 8">
        </a>
        <a href="#" class="small-banner-item">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/banners/banner9.jpg" alt="Banner 9">
        </a>
        <a href="#" class="small-banner-item">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/banners/banner10.jpg" alt="Banner 10">
        </a>
        <a href="#" class="small-banner-item">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/banners/banner11.jpg" alt="Banner 11">
        </a>
    </div>

</div>



</div>

<div class="trust-badge-bar">
    <div class="container">
        <div class="trust-badge-grid">
            <div class="trust-item">
                <span class="trust-icon">🚚</span>
                <div class="trust-text">
                    <strong>Giao hàng miễn phí</strong>
                    <span>Cho đơn hàng trên 500k</span>
                </div>
            </div>
            <div class="trust-item">
                <span class="trust-icon">🌿</span>
                <div class="trust-text">
                    <strong>100% Organic</strong>
                    <span>Chứng nhận an toàn</span>
                </div>
            </div>
            <div class="trust-item">
                <span class="trust-icon">📞</span>
                <div class="trust-text">
                    <strong>Hỗ trợ 24/7</strong>
                    <span>Hotline: 0934 919 897</span>
                </div>
            </div>
            <div class="trust-item">
                <span class="trust-icon">💳</span>
                <div class="trust-text">
                    <strong>Thanh toán</strong>
                    <span>Bảo mật & Nhanh chóng</span>
                </div>
            </div>
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
            'hide_empty' => false,
            'exclude'    => [get_option('default_product_cat')]
        ];

        $product_categories = get_terms($args);

        if (!empty($product_categories) && !is_wp_error($product_categories)) :
            foreach ($product_categories as $category) :
                if ($category->slug === 'uncategorized') {
                    continue; // bỏ qua
                }
                $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                $image_url = wp_get_attachment_url($thumbnail_id);
                if (!$image_url) $image_url = wc_placeholder_img_src();

                $category_link = get_term_link($category);
        ?>
                <a href="<?php echo esc_url($category_link); ?>" class="category-card"
                    style="text-decoration: none; color: #000;">
                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($category->name); ?>"
                        class="category-image">

                    <h3 class="category-name" style="color: #000; text-decoration: none; margin: 10px 0 0;">
                        <?php echo esc_html($category->name); ?>
                    </h3>
                </a>
        <?php endforeach;
        endif; ?>
    </div>
</div>

<!-- ===================== HẾT THANH CAM KẾT ===================== -->
</div>


<!-- ===================== DEAL SỐC (Ý TƯỞNG 2) ===================== -->
<?php
// 1. Query để lấy 1 sản phẩm có tag 'flash-sale'
$flash_sale_args = [
    'post_type'      => 'product',
    'posts_per_page' => 1,
    'tax_query'      => [
        [
            'taxonomy' => 'product_tag', // Dùng tag sản phẩm
            'field'    => 'slug',
            'terms'    => 'flash-sale', // <-- Slug bro tạo ở Bước 1
        ],
    ],
    // Chỉ lấy sản phẩm đang "on sale" (có giá KM)
    'meta_query'     => [
        'relation' => 'AND',
        [ // Phải là sản phẩm đang sale
            'key'     => '_sale_price',
            'value'   => 0,
            'compare' => '>',
            'type'    => 'numeric'
        ],
        [ // Phải còn hàng
            'key'     => '_stock_status',
            'value'   => 'instock',
            'compare' => '='
        ]
    ]
];

$flash_sale_query = new WP_Query($flash_sale_args);

// 2. Chỉ hiển thị nếu query tìm thấy sản phẩm
if ($flash_sale_query->have_posts()) :
    while ($flash_sale_query->have_posts()) : $flash_sale_query->the_post();

        // 3. Lấy data thật
        global $product;

        $product_id    = $product->get_id();
        $product_name  = $product->get_name();
        $product_desc  = $product->get_short_description();
        $cart_url      = $product->add_to_cart_url(); // Link add-to-cart an toàn

        // Lấy ảnh
        if (has_post_thumbnail()) {
            $image_url = get_the_post_thumbnail_url($product_id, 'medium');
        } else {
            $image_url = wc_placeholder_img_src('medium');
        }

        // Tự tính % giảm giá (cho xịn)
        $regular_price = (float) $product->get_regular_price();
        $sale_price    = (float) $product->get_sale_price();
        $percentage    = 0;

        if ($regular_price > 0 && $sale_price > 0) {
            $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
        }
?>

        <div class="flash-sale-section">
            <div class="container">
                <div class="flash-sale-box">
                    <div class="flash-sale-content">

                        <h3>DEAL SỐC HÔM NAY</h3>

                        <h2>Giảm <?php echo esc_html($percentage); ?>% <?php echo esc_html($product_name); ?></h2>

                        <div class="flash-sale-desc">
                            <?php echo wp_kses_post($product_desc); // Dùng kses_post cho an toàn 
                            ?>
                        </div>

                        <a href="<?php echo esc_url($cart_url); ?>" class="btn-primary">
                            Mua ngay chỉ <?php echo wc_price($sale_price); // Tự format giá (ví dụ: 199.000₫) 
                                            ?>
                        </a>
                    </div>

                    <div class="flash-sale-timer">
                        <p>Kết thúc sau:</p>
                        <div id="countdown-timer">
                            <span id="countdown-hours">00</span>
                            <span class="colon">:</span>
                            <span id="countdown-mins">00</span>
                            <span class="colon">:</span>
                            <span id="countdown-secs">00</span>
                        </div>
                    </div>

                    <div class="flash-sale-image">
                        <img src="<?php echo esc_url($image_url); ?>" alt="Flash Sale: <?php echo esc_attr($product_name); ?>">
                    </div>
                </div>
            </div>
        </div>

<?php
    endwhile;
    wp_reset_postdata(); // Quan trọng: reset query
endif; // Hết if($flash_sale_query->have_posts())
?>

<!-- ===================== SẢN PHẨM GIẢM GIÁ ===================== -->
<div class="container">
    <h2 class="section-title">Sản phẩm đang giảm giá</h2>

    <div class="swiper product-swiper-sale">
        <div class="swiper-wrapper">

            <?php
            $sale_products = wc_get_products([
                'status'     => 'publish',
                'limit'      => 8,
                'orderby'    => 'date',
                'order'      => 'DESC',
                'meta_query' => [
                    [
                        'key'     => '_sale_price',
                        'value'   => 0,
                        'compare' => '>',
                        'type'    => 'NUMERIC'
                    ]
                ]
            ]);

            if (!empty($sale_products)) :
                foreach ($sale_products as $product) :
                    $product_id    = $product->get_id();
                    $image_url     = get_the_post_thumbnail_url($product_id, 'medium') ?: wc_placeholder_img_src();

                    $regular_price = (float) $product->get_regular_price();
                    $sale_price    = (float) $product->get_sale_price();

                    $discount = 0;
                    if ($regular_price > 0 && $sale_price > 0) {
                        $discount = round((($regular_price - $sale_price) / $regular_price) * 100);
                    }
            ?>
                    <div class="swiper-slide">
                        <div class="product-card">
                            <div class="product-thumb">
                                <a href="<?php echo esc_url(get_permalink($product_id)); ?>">
                                    <img src="<?php echo esc_url($image_url); ?>" class="product-image">

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
                    </div>
                <?php endforeach;
            else : ?>
                <p>Không có sản phẩm giảm giá.</p>
            <?php endif; ?>

        </div>

        <!-- navigation buttons -->
        <div class="swiper-button-next swiper-button-next-sale"></div>
        <div class="swiper-button-prev swiper-button-prev-sale"></div>
    </div>
</div>

<!-- ===================== SẢN PHẨM NỔI BẬT ===================== -->
<div class="container">
    <h2 class="section-title">Sản phẩm nổi bật</h2>

    <div class="swiper product-swiper-featured">
        <div class="swiper-wrapper">

            <?php
            $featured_products = wc_get_products([
                'status'   => 'publish',
                'limit'    => 8,
                'orderby'  => 'date',
                'order'    => 'DESC',
                'featured' => true
            ]);

            if (!empty($featured_products)) :
                foreach ($featured_products as $product) :
                    $product_id = $product->get_id();
                    $image_url  = get_the_post_thumbnail_url($product_id, 'medium') ?: wc_placeholder_img_src();
            ?>

                    <div class="swiper-slide">
                        <div class="product-card">
                            <div class="product-thumb">
                                <a href="<?php echo esc_url(get_permalink($product_id)); ?>">
                                    <img src="<?php echo esc_url($image_url); ?>" class="product-image">
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
                    </div>

                <?php endforeach;
            else : ?>
                <p>Không có sản phẩm nổi bật.</p>
            <?php endif; ?>

        </div>

        <!-- navigation -->
        <div class="swiper-button-next swiper-button-next-featured"></div>
        <div class="swiper-button-prev swiper-button-prev-featured"></div>
    </div>
</div>


<!-- ===================== CÁC NHÓM SẢN PHẨM KHÁC ===================== -->
<?php
$product_sections = [
    ['title' => 'Sản phẩm hữu cơ', 'slug' => 'san-pham-huu-co'],
    ['title' => 'Ngũ cốc dinh dưỡng hữu cơ', 'slug' => 'ngu-coc-dinh-duong-huu-co'],
    ['title' => 'Các loại hạt và đậu hữu cơ', 'slug' => 'dau-va-hat-huu-co'],
    ['title' => 'Nui và mì hữu cơ', 'slug' => 'nui-mi-huu-co'],
    ['title' => 'Các loại thực phẩm hữu cơ', 'slug' => 'thuc-pham-huu-co']
];

foreach ($product_sections as $section) {
    get_template_part('template-parts/product-row', null, $section);
}
?>

<!-- ===================== GÓC ẨM THỰC (Ý TƯỞNG 1) ===================== -->
<div class="recipe-section">
    <div class="container">
        <h3 class="section-subtitle" style="text-align: center;">BÍ KÍP NẤU NGON</h3>
        <h2 class="section-title" style="text-align: center;">Công thức từ Bếp Organic</h2>

        <div class="recipe-grid">

            <?php
            // 1. Setup Query: Lấy 3 bài viết từ category "cong-thuc"
            $recipe_args = [
                'post_type'      => 'post',
                'posts_per_page' => 6,
                'tax_query'      => [
                    [
                        'taxonomy' => 'category', // Standard post category
                        'field'    => 'slug',
                        'terms'    => 'cong-thuc', // <-- Slug đây bro
                    ],
                ],
                // Sắp xếp theo ngày mới nhất
                'orderby'        => 'date',
                'order'          => 'DESC',
            ];

            $recipe_query = new WP_Query($recipe_args);

            // 2. The Loop (Vòng lặp)
            if ($recipe_query->have_posts()) :
                while ($recipe_query->have_posts()) : $recipe_query->the_post();

                    // 3. Lấy data thật
                    $recipe_link = get_permalink();
                    $recipe_title = get_the_title();

                    // Lấy ảnh (Featured Image)
                    if (has_post_thumbnail()) {
                        $recipe_image = get_the_post_thumbnail_url(get_the_ID(), 'large'); // Dùng size 'large' cho đẹp
                    } else {
                        // Ảnh dự phòng nếu bro quên set
                        $recipe_image = 'https://placehold.co/400x300/e8f5e9/333?text=Kh%C3%B4ng+C%C3%B3+%E1%BA%A2nh';
                    }

                    // Lấy mô tả ngắn (Excerpt), rút gọn 15 chữ
                    $recipe_excerpt = wp_trim_words(get_the_excerpt(), 15, '...');

            ?>

                    <div class="recipe-card">
                        <a href="<?php echo esc_url($recipe_link); ?>" class="recipe-image-link">
                            <img src="<?php echo esc_url($recipe_image); ?>" alt="<?php echo esc_attr($recipe_title); ?>">
                        </a>
                        <div class="recipe-content">
                            <h4><a href="<?php echo esc_url($recipe_link); ?>"><?php echo esc_html($recipe_title); ?></a></h4>
                            <p><?php echo esc_html($recipe_excerpt); ?></p>
                            <a href="<?php echo esc_url($recipe_link); ?>" class="btn-secondary">Xem công thức →</a>
                        </div>
                    </div>

                <?php
                endwhile;
                wp_reset_postdata(); // Quan trọng: reset query
            else :
                // Nếu không có bài viết nào trong category "cong-thuc"
                ?>
                <p style="text-align: center; grid-column: 1 / -1; color: #777;">
                    Chưa có công thức nào. Bro vào WP Admin tạo category "Công Thức" (slug: `cong-thuc`) và thêm bài viết vào đó nhé!
                </p>
            <?php
            endif;
            ?>

        </div>
    </div>
</div>

<div class="instagram-section">
    <div class="container">
        <h3 class="section-subtitle" style="text-align: center;">CHIA SẺ KHOẢNH KHẮC</h3>
        <h2 class="section-title" style="text-align: center;">
            Theo dõi chúng tôi @OrganicFoodsShop
        </h2>
    </div>

    <div class="marquee-wrapper">
        <div class="marquee-content">
            <?php
            // 1. Query lấy 10 bài mới nhất
            $slider_query = new WP_Query(array(
                'post_type'      => 'post',
                'posts_per_page' => 10, // Lấy 10 bài
            ));

            if ($slider_query->have_posts()) {
                while ($slider_query->have_posts()) {
                    $slider_query->the_post();
                    $link = get_permalink();
                    $img_url = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'medium') : get_template_directory_uri() . '/assets/images/ofs/ofs1.jpg';
            ?>

                    <div class="marquee-item">
                        <a href="<?php echo esc_url($link); ?>" title="<?php the_title(); ?>">
                            <img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title(); ?>">
                        </a>
                    </div>

            <?php
                }
                wp_reset_postdata(); // Reset query sau khi chạy xong
            }
            ?>
        </div>
    </div>

    <div class="container" style="text-align: center; margin-top: 30px;">
        <a href="https://www.instagram.com/tu.farm.organic/" class="btn-primary" target="_blank" rel="noopener noreferrer">
            Theo dõi ngay trên Instagram
        </a>
    </div>
</div>

<!-- ===================== HẾT CÁC NHÓM SẢN PHẨM ===================== -->


<!-- ===================== KHÁCH HÀNG NÓI GÌ (Ý TƯỞNG 2) ===================== -->
<div class="testimonial-section">
    <div class="container">
        <h3 class="section-subtitle" style="text-align: center;">ĐÁNH GIÁ TỪ KHÁCH HÀNG</h3>
        <h2 class="section-title" style="text-align: center;">Khách hàng nói gì về chúng tôi</h2>

        <div class="swiper testimonial-swiper">
            <div class="swiper-wrapper">

                <!-- Testimonial 1 -->
                <div class="swiper-slide">
                    <div class="testimonial-card">
                        <div class="testimonial-stars">★★★★★</div>
                        <p class="testimonial-quote">
                            "Rau củ rất tươi và sạch. Giao hàng nhanh. Từ khi
                            biết shop mình đã không còn phải đi siêu thị nữa.
                            Rất tin tưởng!"
                        </p>

                        <!-- === SỬA LẠI KHỐI AUTHOR === -->
                        <div class="testimonial-author-wrapper">
                            <img class="testimonial-avatar"
                                src="<?php echo get_template_directory_uri(); ?>/assets/images/avatar/batman.png"
                                alt="Avatar Chị Thu Hoài">
                            <div class="testimonial-author">
                                <strong>Chị Thu Hoài</strong>
                                <span>- Nhân viên văn phòng, Q.1</span>
                            </div>
                        </div>
                        <!-- === HẾT SỬA ĐỔI === -->

                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="swiper-slide">
                    <div class="testimonial-card">
                        <div class="testimonial-stars">★★★★★</div>
                        <p class="testimonial-quote">
                            "Các loại hạt hữu cơ ở đây là ngon nhất mình từng thử.
                            Bé nhà mình rất thích sữa hạt do shop tư vấn công thức."
                        </p>

                        <!-- === SỬA LẠI KHỐI AUTHOR === -->
                        <div class="testimonial-author-wrapper">
                            <img class="testimonial-avatar"
                                src="<?php echo get_template_directory_uri(); ?>/assets/images/avatar/joker.png"
                                alt="Avatar Anh Minh Quân">
                            <div class="testimonial-author">
                                <strong>Anh Minh Quân</strong>
                                <span>- Freelancer, Gò Vấp</span>
                            </div>
                        </div>
                        <!-- === HẾT SỬA ĐỔI === -->

                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="swiper-slide">
                    <div class="testimonial-card">
                        <div class="testimonial-stars">★★★★★</div>
                        <p class="testimonial-quote">
                            "Đã mua hàng ở đây 3 năm. Chưa bao giờ thất vọng.
                            Giá cả hợp lý cho chất lượng organic 100%."
                        </p>

                        <!-- === SỬA LẠI KHỐI AUTHOR === -->
                        <div class="testimonial-author-wrapper">
                            <img class="testimonial-avatar"
                                src="<?php echo get_template_directory_uri(); ?>/assets/images/avatar/the-flash.png"
                                alt="Avatar Cô Lan Anh">
                            <div class="testimonial-author">
                                <strong>Cô Lan Anh</strong>
                                <span>- Nội trợ, Q.7</span>
                            </div>
                        </div>
                        <!-- === HẾT SỬA ĐỔI === -->

                    </div>
                </div>

            </div> <!-- Hết swiper-wrapper -->

            <div class="swiper-button-next swiper-button-next-testimonial"></div>
            <div class="swiper-button-prev swiper-button-prev-testimonial"></div>

        </div> <!-- Hết .testimonial-swiper -->
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // --- KHỞI TẠO SWIPER CHO CÁC SLIDER SẢN PHẨM ---
        const swiperContainers = document.querySelectorAll('[class*="product-swiper-"]');
        swiperContainers.forEach(function(swiperContainer) {

            let uniqueSuffix = '';
            swiperContainer.classList.forEach(function(className) {
                if (className.startsWith('product-swiper-')) {
                    uniqueSuffix = className.replace('product-swiper-', '');
                }
            });

            if (uniqueSuffix) {
                new Swiper(swiperContainer, {
                    slidesPerView: 2, // Mobile
                    spaceBetween: 20,
                    breakpoints: {
                        640: {
                            slidesPerView: 3
                        },
                        768: {
                            slidesPerView: 4
                        },
                        1024: {
                            slidesPerView: 5
                        },
                    },
                    navigation: {
                        nextEl: '.swiper-button-next-' + uniqueSuffix,
                        prevEl: '.swiper-button-prev-' + uniqueSuffix,
                    },
                });
            }
        });

        // --- THÊM MỚI: KHỞI TẠO SWIPER CHO TESTIMONIALS (Ý TƯỞNG 2) ---
        new Swiper('.testimonial-swiper', {
            slidesPerView: 1, // Mobile: 1 cột
            spaceBetween: 30,

            // Responsive breakpoints
            breakpoints: {
                768: { // Tablet
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
                1024: { // Desktop
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
            },

            // Kích hoạt 2 nút điều hướng
            navigation: {
                nextEl: '.swiper-button-next-testimonial',
                prevEl: '.swiper-button-prev-testimonial',
            },
        });

    });

    document.addEventListener('DOMContentLoaded', function() {

        // ... (code Swiper của bro) ...

        // --- THÊM MỚI: KÍCH HOẠT COUNTDOWN (Ý TƯỞNG 2) ---
        function startCountdown() {
            // Set thời gian kết thúc (ví dụ: nửa đêm hôm nay)
            const endTime = new Date();
            endTime.setHours(23, 59, 59, 999);

            const timer = setInterval(function() {
                const now = new Date().getTime();
                const distance = endTime - now;

                if (distance < 0) {
                    clearInterval(timer);
                    document.getElementById("countdown-timer").innerHTML = "HẾT HẠN";
                    return;
                }

                // Tính toán giờ, phút, giây
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Thêm số 0 đằng trước nếu < 10
                const f = (n) => (n < 10 ? '0' + n : n);

                // Hiển thị
                document.getElementById("countdown-hours").innerText = f(hours);
                document.getElementById("countdown-mins").innerText = f(minutes);
                document.getElementById("countdown-secs").innerText = f(seconds);

            }, 1000);
        }

        // Kiểm tra xem có element timer không
        if (document.getElementById('countdown-timer')) {
            startCountdown();
        }

    }); // Hết DOMContentLoaded

    // ... bên trong thẻ <script>
    document.addEventListener('DOMContentLoaded', function() {

        // ... (code Swiper & Countdown của bro) ...

        // --- THÊM MỚI: KÍCH HOẠT POPUP (Ý TƯỞNG 3) ---
        const modalOverlay = document.getElementById('newsletter-modal-overlay');
        const modalCloseBtn = document.getElementById('modal-close-btn');

        if (modalOverlay && modalCloseBtn) {

            // 1. Set 1 cái cookie (localStorage) để nó không hiện lại
            const hasSeenPopup = localStorage.getItem('seenNewsletterPopup');

            // Nếu chưa thấy popup, thì cho hiện sau 5 giây
            if (!hasSeenPopup) {
                setTimeout(function() {
                    modalOverlay.classList.add('active');
                }, 5000); // 5000ms = 5 giây
            }

            // 2. Hàm đóng popup
            const closeModal = function() {
                modalOverlay.classList.remove('active');
                // Đánh dấu là đã thấy, 2 tiếng sau mới hiện lại
                localStorage.setItem('seenNewsletterPopup', 'true', {
                    expires: 1 / 12
                });
            }

            // 3. Bấm nút X để đóng
            modalCloseBtn.addEventListener('click', closeModal);

            // 4. Bấm ra ngoài vùng mờ cũng đóng
            modalOverlay.addEventListener('click', function(e) {
                // Chỉ đóng khi bấm vào lớp mờ (overlay), 
                // không phải bấm vào cái popup
                if (e.target === modalOverlay) {
                    closeModal();
                }
            });
        }

    });

    // ... bên trong thẻ <script>
    document.addEventListener('DOMContentLoaded', function() {

        // ... (code Swiper, Countdown, Popup... của bro) ...

        // --- THÊM MỚI: KÍCH HOẠT QUICK VIEW (Ý TƯỞNG 2) ---
        const qvOverlay = document.getElementById('quick-view-modal-overlay');
        const qvCloseBtn = document.getElementById('quick-view-close-btn');
        const qvContent = document.getElementById('quick-view-content-wrapper');
        const allQuickViewBtns = document.querySelectorAll('.btn-quick-view');

        if (qvOverlay && qvCloseBtn && qvContent) {

            // 1. Mở modal khi bấm nút
            allQuickViewBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault(); // Ngăn link #
                    const productId = this.dataset.productId;

                    // Hiển thị modal với icon loading
                    qvContent.innerHTML = '<div class="loading-spinner"></div>';
                    qvOverlay.classList.add('active');

                    // Gọi AJAX để lấy nội dung
                    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `action=load_product_quick_view&product_id=${productId}`
                        })
                        .then(response => response.text())
                        .then(html => {
                            // Load nội dung HTML vào modal
                            qvContent.innerHTML = html;
                        })
                        .catch(err => {
                            qvContent.innerHTML = '<p>Lỗi! Không thể tải sản phẩm.</p>';
                        });
                });
            });

            // 2. Đóng modal
            const closeQuickView = function() {
                qvOverlay.classList.remove('active');
                qvContent.innerHTML = ''; // Xóa nội dung cũ
            }
            qvCloseBtn.addEventListener('click', closeQuickView);
            qvOverlay.addEventListener('click', function(e) {
                if (e.target === qvOverlay) {
                    closeQuickView();
                }
            });
        }

    }); // Hết DOMContentLoaded
</script>


<!-- ===================== POPUP ĐĂNG KÝ (Ý TƯỞNG 3) ===================== -->
<div id="newsletter-modal-overlay">
    <div id="newsletter-modal-popup">
        <div id="modal-close-btn">✖</div>

        <div class="modal-image">
            <img src="https://placehold.co/200x300/6b9d3e/fff?text=Get+10%25+OFF" alt="Đăng ký nhận tin">
        </div>

        <div class="modal-content">
            <h3>Nhận ngay Voucher 10%</h3>
            <p>
                Đăng ký nhận tin tức mới nhất và voucher <strong>giảm 10%</strong>
                cho đơn hàng đầu tiên của bạn!
            </p>

            <!-- Đây là form thật, dùng code của bro trong functions.php -->
            <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                <input type="hidden" name="action" value="submit_newsletter_email">
                <?php wp_nonce_field('newsletter_form_action', 'newsletter_form_nonce'); ?>

                <input type="email" name="newsletter_email" placeholder="Nhập email của bạn..." required>
                <button type="submit" class="btn-primary">ĐĂNG KÝ NGAY</button>
            </form>
        </div>
    </div>
</div>
<div id="quick-view-modal-overlay">
    <div id="quick-view-modal-popup">
        <div id="quick-view-close-btn">✖</div>
        <div id="quick-view-content-wrapper">
            <div class="loading-spinner"></div>
        </div>
    </div>
</div>

<?php get_footer(); ?>