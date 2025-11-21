<?php
/**
 * Template Name: Trang Thanh Toán Custom (Green Theme)
 */

defined('ABSPATH') || exit;

get_header();
wc_clear_notices(); // Xóa notice rác
$checkout = WC()->checkout();
?>

<style>
/* CSS GIỮ NGUYÊN NHƯ CŨ CHO ĐẸP */
.custom-checkout-wrapper { padding: 40px 0; }
.custom-checkout-grid { display: flex; gap: 30px; flex-wrap: wrap; }
.checkout-left { flex: 1; min-width: 300px; }
.checkout-right { width: 400px; background: #f9f9f9; padding: 20px; border-radius: 8px; height: fit-content; }
.green-btn { background: #2ecc71 !important; color: #fff !important; width: 100%; }
.green-btn:hover { background: #27ae60 !important; }

/* Ẩn notice mặc định, hiện inline error */
.woocommerce-NoticeGroup, .woocommerce-error, .woocommerce-message { display: none !important; }
.woocommerce-invalid input { border-color: #e74c3c !important; background-color: #fff5f5; }
.woocommerce-invalid label { color: #e74c3c !important; }
.woocommerce-form-row .woocommerce-error-message { color: #e74c3c; font-size: 0.85em; margin-top: 5px; display: block; font-weight: 500; }

@media (max-width: 768px) {
    .custom-checkout-grid { flex-direction: column; }
    .checkout-right { width: 100%; }
}
</style>

<div id="custom-green-checkout" class="custom-checkout-wrapper">
    <div class="container">
        <h1 class="text-center mb-4">Thanh Toán</h1>

        <?php if ( WC()->cart->is_empty() ) : ?>
            <div class="text-center">
                <p>Giỏ hàng của bạn đang trống.</p>
                <a href="<?php echo esc_url( wc_get_page_permalink('shop') ); ?>" class="button green-btn">
                    Quay lại cửa hàng
                </a>
            </div>

        <?php else : ?>
            <form method="post" class="checkout woocommerce-checkout"
                  action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

                <div class="custom-checkout-grid">
                    <div class="checkout-left">
                        <h3>Thông tin giao hàng</h3>
                        <div class="woocommerce-billing-fields__field-wrapper">
                            <?php
                            foreach ( $checkout->get_checkout_fields('billing') as $key => $field ) {
                                woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
                            }
                            ?>
                        </div>
                        <div class="mt-4">
                            <?php if ( wc_ship_to_billing_address_only() && apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>
                                <?php foreach ( $checkout->get_checkout_fields('order') as $key => $field ) : ?>
                                    <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="checkout-right">
                        <h3>Đơn hàng</h3>
                        <div id="order_review" class="woocommerce-checkout-review-order">
                            <?php wc_get_template( 'checkout/review-order.php' ); ?>
                            <div id="payment" class="woocommerce-checkout-payment mt-4">
                                <?php wc_get_template( 'checkout/payment.php', array( 'checkout' => $checkout ) ); ?>
                                <div class="form-row place-order mt-3">
                                    <?php wc_get_template( 'checkout/terms.php' ); ?>
                                    <?php do_action( 'woocommerce_review_order_before_submit' ); ?>
                                    
                                    <button type="submit" class="button alt green-btn" name="woocommerce_checkout_place_order" id="place_order" value="Đặt hàng">Đặt hàng</button>
                                    
                                    <?php do_action( 'woocommerce_review_order_after_submit' ); ?>
                                    <?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<script>
jQuery(function($) {
    $('form.checkout').on('checkout_error', function() {
        const firstError = $('.woocommerce-invalid').first();
        if (firstError.length) {
            $('html,body').animate({ scrollTop: firstError.offset().top - 120 }, 500);
        }
    });
});
</script>

<?php get_footer(); ?>