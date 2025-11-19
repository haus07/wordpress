<?php
/**
 * Template Name: Trang Thanh Toán Custom (Green Theme)
 * Description: Giao diện thanh toán tùy chỉnh màu Xanh Lá + Trắng
 */

defined( 'ABSPATH' ) || exit;

get_header(); // Gọi Header
?>

<!-- Bắt đầu vùng chứa Custom Checkout -->
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
            // 2. Hiển thị thông báo Login / Coupon nếu chưa đăng nhập
            // WooCommerce dùng hook để hiển thị các notice này
            echo '<div class="woo-notices-wrapper">';
            do_action( 'woocommerce_before_checkout_form', WC()->checkout() );
            echo '</div>';

            // 3. Hiển thị Form Checkout chính
            // Sử dụng shortcode là cách an toàn nhất để đảm bảo AJAX và Payment Gateways hoạt động đúng
            echo do_shortcode('[woocommerce_checkout]');
        }
        ?>

    </div>
</div>

<?php get_footer(); // Gọi Footer ?>