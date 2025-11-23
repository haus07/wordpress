<?php
/**
 * Template Name: Wishlist Page
 */
get_header();
?>

<div class="wishlist-page-container" style="max-width: 1200px; margin: 50px auto; padding: 20px;">
    <h1 style="text-align: center; margin-bottom: 30px;">❤️ Danh sách yêu thích của bạn</h1>

    <div id="wishlist-content">
        <?php
        // Lấy wishlist
        $user_id = get_current_user_id();
        $wishlist = [];
        
        if ($user_id) {
            // User đã đăng nhập
            $wishlist = get_user_meta($user_id, '_doAnCMS_wishlist', true);
        } else {
            // Guest user - Lấy từ cookie
            if (isset($_COOKIE['doAnCMS_wishlist'])) {
                $wishlist = explode(',', $_COOKIE['doAnCMS_wishlist']);
            }
        }
        
        if (!is_array($wishlist)) $wishlist = [];
        $wishlist = array_filter($wishlist); // Xóa phần tử rỗng
        
        if (empty($wishlist)) {
            echo '<p style="text-align: center; font-size: 18px; color: #999;">Chưa có sản phẩm nào trong wishlist.</p>';
        } else {
            echo '<div class="wishlist-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">';
            
            foreach ($wishlist as $product_id) {
                $product = wc_get_product($product_id);
                if (!$product) continue;
                
                $title = $product->get_name();
                $price = $product->get_price_html();
                $link = get_permalink($product_id);
                $image = $product->get_image('medium');
                ?>

        <div class="wishlist-item"
            style="border: 1px solid #ddd; padding: 15px; border-radius: 8px; text-align: center; position: relative;">
            <button class="remove-wishlist-btn" data-product-id="<?php echo esc_attr($product_id); ?>"
                style="position: absolute; top: 10px; right: 10px; background: #ff4444; color: white; border: none; border-radius: 50%; width: 30px; height: 30px; cursor: pointer; font-size: 16px;">
                ×
            </button>

            <a href="<?php echo esc_url($link); ?>">
                <?php echo $image; ?>
            </a>

            <h3 style="margin: 15px 0 10px; font-size: 16px;">
                <a href="<?php echo esc_url($link); ?>" style="color: #333; text-decoration: none;">
                    <?php echo esc_html($title); ?>
                </a>
            </h3>

            <div style="margin: 10px 0; font-weight: bold; color: #27ae60;">
                <?php echo $price; ?>
            </div>

            <a href="<?php echo esc_url($link); ?>" class="button"
                style="display: inline-block; padding: 10px 20px; background: #27ae60; color: white; text-decoration: none; border-radius: 5px;">
                Xem chi tiết
            </a>
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
    // Xóa sản phẩm khỏi wishlist
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

                        // Kiểm tra nếu hết sản phẩm
                        if ($('.wishlist-item').length === 0) {
                            $('#wishlist-content').html(
                                '<p style="text-align: center; font-size: 18px; color: #999;">Chưa có sản phẩm nào trong wishlist.</p>'
                            );
                        }
                    });
                }
            }
        });
    });
});
</script>

<?php get_footer(); ?>