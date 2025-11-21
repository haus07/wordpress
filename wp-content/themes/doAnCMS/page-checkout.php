<?php
/**
 * Template Name: Trang Thanh Toán Custom (Green Theme)
 * Description: Giao diện thanh toán tùy chỉnh màu Xanh Lá + Trắng
 */

defined( 'ABSPATH' ) || exit;

get_header(); 
?>

<div id="custom-green-checkout" class="custom-checkout-wrapper">
    <div class="container">

        <h1 class="checkout-title">Thanh Toán</h1>

        <?php
        // 1. Kiểm tra xem có sản phẩm trong giỏ không
        if ( WC()->cart->is_empty() ) {
            ?>
            <div class="checkout-empty-message">
                <p>Giỏ hàng của bạn đang trống.</p>
                <a class="button green-btn" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
                    Quay lại cửa hàng
                </a>
            </div>
            <?php
        } else {
            // 2. XÓA ĐOẠN do_action VÀ woo-notices-wrapper THỦ CÔNG ĐI
            // Shortcode [woocommerce_checkout] sẽ tự động render phần Login/Coupon và Notices
            
            // Hiển thị Form Checkout chính
            echo do_shortcode('[woocommerce_checkout]');
        }
        ?>

    </div>
</div>

<?php get_footer(); ?>