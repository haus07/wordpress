<?php
/**
 * Template Name: Wishlist Page
 */
get_header();
?>

<style>
.wishlist-page-container {
    max-width: 1200px;
    margin: 50px auto;
    padding: 20px;
    background-color: <?php echo get_theme_mod('wishlist_bg_color', '#fff');
    ?>;
}

.wishlist-page-container h1 {
    text-align: center;
    margin-bottom: 30px;
    color: <?php echo get_theme_mod('wishlist_title_color', '#333');
    ?>;
}

.wishlist-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
}

.wishlist-item {
    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 8px;
    text-align: center;
    position: relative;
}

.remove-wishlist-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #ff4444;
    color: white;
    border: none;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    cursor: pointer;
    font-size: 16px;
}

.wishlist-item h3 {
    margin: 15px 0 10px;
    font-size: 16px;
}

.wishlist-item h3 a {
    color: #333;
    text-decoration: none;
}

.wishlist-item .price {
    margin: 10px 0;
    font-weight: bold;
    color: #27ae60;
}

.wishlist-item .button {
    display: inline-block;
    padding: 10px 20px;
    background: <?php echo get_theme_mod('wishlist_button_color', '#27ae60');
    ?>;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

img {
    width: 250px;
}

.empty-wishlist {
    text-align: center;
    font-size: 18px;
    color: #999;
}
</style>

<div class="wishlist-page-container">
    <h1 id="wishlist-title"><?php echo esc_html(get_theme_mod('wishlist_title', '❤️ Danh sách yêu thích của bạn')); ?>
    </h1>

    <div id="wishlist-content">
        <?php
        $user_id = get_current_user_id();
        $wishlist = [];

        if ($user_id) {
            $wishlist = get_user_meta($user_id, '_doAnCMS_wishlist', true);
        } elseif (isset($_COOKIE['doAnCMS_wishlist'])) {
            $wishlist = explode(',', $_COOKIE['doAnCMS_wishlist']);
        }

        if (!is_array($wishlist)) $wishlist = [];
        $wishlist = array_filter($wishlist);

        if (empty($wishlist)) {
            $empty_text = get_theme_mod('wishlist_empty_text', 'Chưa có sản phẩm nào trong wishlist.');
            echo '<p class="empty-wishlist">' . esc_html($empty_text) . '</p>';
        } else {
            echo '<div class="wishlist-grid">';
            foreach ($wishlist as $product_id) {
                $product = wc_get_product($product_id);
                if (!$product) continue;

                $title = $product->get_name();
                $price = $product->get_price_html();
                $link = get_permalink($product_id);
                $image = $product->get_image('medium');
        ?>
        <div class="wishlist-item">
            <button class="remove-wishlist-btn" data-product-id="<?php echo esc_attr($product_id); ?>">×</button>

            <a href="<?php echo esc_url($link); ?>"><?php echo $image; ?></a>

            <h3><a href="<?php echo esc_url($link); ?>"><?php echo esc_html($title); ?></a></h3>

            <div class="price"><?php echo $price; ?></div>

            <a href="<?php echo esc_url($link); ?>" class="button">Xem chi tiết</a>
        </div>
        <?php
            }
            echo '</div>';
        }
        ?>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    var emptyText = window.wishlistEmptyText ||
        '<?php echo esc_js(get_theme_mod('wishlist_empty_text', 'Chưa có sản phẩm nào trong wishlist.')); ?>';

    $('.remove-wishlist-btn').on('click', function() {
        var btn = $(this);
        var productId = btn.data('product-id');

        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'doRemoveFromWishlist',
                product_id: productId
            },
            success: function(response) {
                if (response.success) {
                    btn.closest('.wishlist-item').fadeOut(300, function() {
                        $(this).remove();
                        if ($('.wishlist-item').length === 0) {
                            $('#wishlist-content').html(
                                '<p class="empty-wishlist">' + emptyText +
                                '</p>');
                        }
                    });
                }
            }
        });
    });
});
</script>

<?php get_footer(); ?>