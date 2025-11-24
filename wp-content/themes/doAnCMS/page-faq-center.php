<?php

/**
 * Template Name: FAQ Center
 */
get_header();
?>

<div class="faq-center container">

    <h1 class="faq-title">FAQ Center</h1>
    <p class="faq-sub">Giải đáp mọi thắc mắc về cửa hàng Organic Food Shop</p>

    <?php
    // Lấy category filter nếu có
    $faq_cat = isset($_GET['faq_cat']) ? sanitize_text_field($_GET['faq_cat']) : '';
    // Lấy search nếu có
    $faq_search = isset($_GET['faq_search']) ? sanitize_text_field($_GET['faq_search']) : '';

    $args = [
        'post_type' => 'faq',
        'posts_per_page' => -1
    ];

    if ($faq_search) {
        $args['s'] = $faq_search;
    }

    if ($faq_cat) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'faq_category',
                'field'    => 'slug',
                'terms'    => $faq_cat
            ]
        ];
    }

    $faq_query = new WP_Query($args);
    ?>

    <!-- Search Form -->
    <form method="get" class="faq-search">
        <input type="text" name="faq_search" placeholder="Bạn cần hỗ trợ gì?" value="<?php echo esc_attr($faq_search); ?>" class="faq-search-input">
        <input type="hidden" name="faq_cat" value="<?php echo esc_attr($faq_cat); ?>">
        <button type="submit" class="faq-search-btn">Tìm kiếm</button>
    </form>



    <!-- Category List -->
    <div class="faq-categories">
        <?php
        $terms = get_terms('faq_category');
        foreach ($terms as $term) {
            $active_class = ($faq_cat === $term->slug) ? ' active' : '';
            echo '<a href="' . add_query_arg(['faq_cat' => $term->slug, 'faq_search' => $faq_search]) . '" class="faq-cat' . $active_class . '">' . esc_html($term->name) . '</a>';
        }
        ?>
    </div>

    <div class="faq-reset-container" style="text-align:center; margin-bottom:20px;">
        <a href="<?php echo esc_url(home_url('/faq-category')); ?>" class="faq-reset-btn">🔄 Reset Filters</a>
    </div>



    <!-- FAQ List -->
    <div class="faq-list">
        <?php
        if ($faq_query->have_posts()):
            while ($faq_query->have_posts()): $faq_query->the_post(); ?>
                <div class="faq-item">
                    <div class="faq-question">
                        <i class="fa fa-question-circle faq-icon"></i>
                        <?php the_title(); ?>
                        <span class="faq-toggle-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        <?php the_content(); ?>
                    </div>
                </div>
            <?php endwhile;
        else: ?>
            <p>Không tìm thấy FAQ phù hợp.</p>
        <?php endif;
        wp_reset_postdata(); ?>
    </div>
</div>

<?php get_footer(); ?>

<style>
    /* Container */
    .faq-center {
        max-width: 850px;
        margin: auto;
        padding: 40px 20px;
    }

    /* Title */
    .faq-title {
        text-align: center;
        font-size: 40px;
        font-weight: 700;
        color: #4CAF50;
    }

    .faq-sub {
        text-align: center;
        color: #666;
        margin-bottom: 30px;
    }

    /* Search Bar */
    .faq-search {
        display: flex;
        justify-content: center;
        margin-bottom: 25px;
    }

    .faq-search-input {
        width: 70%;
        padding: 12px 15px;
        border: 2px solid #6FBF4A;
        border-radius: 25px 0 0 25px;
        outline: none;
        font-size: 16px;
    }

    .faq-search-btn {
        border: none;
        padding: 12px 18px;
        background: #6FBF4A;
        color: white;
        border-radius: 0 25px 25px 0;
        cursor: pointer;
        font-size: 18px;
        transition: 0.3s;
    }

    .faq-search-btn:hover {
        background: #4CAF50;
    }

    /* Categories */
    .faq-categories {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
        margin-bottom: 35px;
    }

    .faq-cat {
        background: #f0f9f0;
        padding: 8px 16px;
        border-radius: 20px;
        border: 1px solid #6FBF4A;
        color: #4CAF50;
        text-decoration: none;
        font-size: 15px;
        transition: 0.25s;
    }

    .faq-cat:hover,
    .faq-cat.active {
        background: #6FBF4A;
        color: white;
    }

    /* FAQ Item */
    .faq-item {
        background: #fff;
        border-radius: 10px;
        margin-bottom: 15px;
        padding: 0;
        border: 1px solid #e2e2e2;
        box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.05);
    }

    .faq-question {
        padding: 15px;
        font-size: 18px;
        font-weight: 600;
        color: #333;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .faq-icon {
        margin-right: 10px;
        color: #6FBF4A;
        font-size: 20px;
    }

    .faq-toggle-icon {
        font-size: 22px;
        color: #6FBF4A;
        transition: transform 0.3s;
    }

    .faq-item.active .faq-toggle-icon {
        transform: rotate(45deg);
    }

    .faq-answer {
        display: none;
        padding: 15px;
        border-top: 1px solid #e2e2e2;
        color: #555;
        background: #fafafa;
        line-height: 1.6;
    }

    .faq-item.active .faq-answer {
        display: block;
    }

    .faq-reset-btn {
        display: inline-block;
        padding: 5px 10px;
        background: #fff;
        color: #4CAF50;
        border: 2px solid #4CAF50;
        border-radius: 25px;
        font-weight: 600;
        text-decoration: none;
        transition: 0.3s;
    }

    .faq-reset-btn:hover {
        background: #4CAF50;
        color: #fff;
    }
</style>

<script>
    document.querySelectorAll(".faq-item").forEach(item => {
        item.addEventListener("click", () => {
            item.classList.toggle("active");
        });
    });

    jQuery(document).ready(function($) {
        var $input = $('#faq-search-input');
        var $suggestions = $('#faq-suggestions');
        var $cat = $('#faq-cat');

        $input.on('input', function() {
            var keyword = $(this).val();
            if (keyword.length < 2) {
                $suggestions.hide();
                return;
            }

            $.ajax({
                url: '<?php echo admin_url("admin-ajax.php"); ?>',
                data: {
                    action: 'faq_search',
                    keyword: keyword,
                    faq_cat: $cat.val()
                },
                success: function(res) {
                    var html = '';
                    if (res.length) {
                        res.forEach(function(item) {
                            html += '<a href="' + item.link + '" style="display:block;padding:8px 12px;border-bottom:1px solid #eee;text-decoration:none;color:#333;">' + item.title + '</a>';
                        });
                    } else {
                        html = '<div style="padding:8px 12px;color:#666;">Không tìm thấy</div>';
                    }
                    $suggestions.html(html).show();
                }
            });
        });

        $(document).click(function(e) {
            if (!$(e.target).closest('#faq-search-input,#faq-suggestions').length) {
                $suggestions.hide();
            }
        });
    });
</script>