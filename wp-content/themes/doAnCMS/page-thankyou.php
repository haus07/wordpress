<?php
/**
 * Template Name: Trang Cảm Ơn Custom (Final Version)
 */

defined('ABSPATH') || exit;

// 1. LẤY THÔNG TIN ĐƠN HÀNG
$order_id  = isset( $_GET['order_id'] ) ? absint( $_GET['order_id'] ) : 0;
$order_key = isset( $_GET['key'] ) ? sanitize_text_field( $_GET['key'] ) : '';
$order     = wc_get_order( $order_id );

// Bảo mật
if ( ! $order || $order->get_order_key() !== $order_key ) {
    wp_safe_redirect( wc_get_page_permalink( 'shop' ) );
    exit;
}

$payment_method = $order->get_payment_method(); 

// 2. LOGIC XÁC NHẬN
// Nếu có đuôi '&confirmed=1' HOẶC không phải chuyển khoản (COD) -> Thì là DONE
$is_done = ( isset( $_GET['confirmed'] ) && $_GET['confirmed'] == '1' ) || ( $payment_method != 'bacs' );

get_header();
?>

<style>
    :root { --green-theme: #2ecc71; --green-dark: #27ae60; }
    .thankyou-page-wrapper { padding: 60px 20px; background-color: #f4f7f6; min-height: 80vh; }
    .thankyou-card { max-width: 900px; margin: 0 auto; background: #fff; border-radius: 12px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); overflow: hidden; padding-bottom: 40px;}
    
    /* === STYLE CHO TRẠNG THÁI CHỜ (MÀU VÀNG) === */
    .pending-header { background: #fff3cd; padding: 40px 20px; text-align: center; color: #856404; }
    .pending-icon { font-size: 60px; display: block; margin-bottom: 10px; }
    
    /* === STYLE CHO TRẠNG THÁI THÀNH CÔNG (ANIMATION TÍCH XANH) === */
    .success-header { padding: 40px 20px; text-align: center; background: #fff; }
    .success-checkmark { width: 80px; height: 80px; margin: 0 auto 20px; position: relative; }
    .check-icon { width: 80px; height: 80px; position: relative; border-radius: 50%; border: 4px solid var(--green-theme); box-sizing: content-box; }
    .check-icon::before, .check-icon::after { content: ''; position: absolute; background: #fff; transform: rotate(-45deg); }
    .check-icon::before { top: 3px; left: -2px; width: 30px; transform-origin: 100% 50%; border-radius: 100px 0 0 100px; height: 100px; }
    .check-icon::after { top: 0; left: 30px; width: 60px; transform-origin: 0 50%; border-radius: 0 100px 100px 0; animation: rotate-circle 4.25s ease-in; height: 100px; }
    .icon-line { height: 5px; background-color: var(--green-theme); display: block; border-radius: 2px; position: absolute; z-index: 10; }
    .icon-line.line-tip { top: 46px; left: 14px; width: 25px; transform: rotate(45deg); animation: icon-line-tip 0.75s; }
    .icon-line.line-long { top: 38px; right: 8px; width: 47px; transform: rotate(-45deg); animation: icon-line-long 0.75s; }
    @keyframes icon-line-tip { 0% { width: 0; left: 1px; top: 19px; } 54% { width: 0; left: 1px; top: 19px; } 70% { width: 50px; left: -8px; top: 37px; } 84% { width: 17px; left: 21px; top: 48px; } 100% { width: 25px; left: 14px; top: 46px; } }
    @keyframes icon-line-long { 0% { width: 0; right: 46px; top: 54px; } 65% { width: 0; right: 46px; top: 54px; } 84% { width: 55px; right: 0px; top: 35px; } 100% { width: 47px; right: 8px; top: 38px; } }

    .main-title { font-size: 2rem; font-weight: 700; margin: 0 0 10px; color: #333; }
    .sub-title { color: #666; font-size: 1.1rem; margin: 0; }

    /* === BODY CONTENT === */
    .card-body { padding: 0 40px; }

    /* KHUNG QR */
    .payment-instruction-box { border: 2px dashed var(--green-theme); background: #fff; border-radius: 12px; padding: 30px; text-align: center; margin-bottom: 40px; margin-top: 20px; }
    .qr-image { max-width: 250px; width: 100%; border-radius: 8px; border: 1px solid #ddd; padding: 10px; background: #fff; }
    .bank-details { margin-top: 20px; text-align: left; display: inline-block; background: #f9f9f9; padding: 20px; border-radius: 8px; width: 100%; max-width: 400px; }
    .bank-row { display: flex; justify-content: space-between; margin-bottom: 8px; border-bottom: 1px solid #eee; padding-bottom: 8px; }
    .bank-row:last-child { border-bottom: none; margin: 0; padding: 0; }
    .bank-label { color: #777; font-size: 0.9rem; }
    .bank-value { font-weight: bold; color: #333; font-size: 0.95rem; }

    /* BẢNG SẢN PHẨM */
    .order-section { border-top: 1px solid #eee; padding-top: 30px; margin-top: 30px; }
    .section-title { font-size: 1.3rem; color: #333; margin-bottom: 15px; font-weight: 600; }
    .custom-table { width: 100%; border-collapse: collapse; }
    .custom-table td { padding: 12px 0; border-bottom: 1px solid #f1f1f1; color: #555; }
    .custom-table tr:last-child td { border-bottom: none; font-weight: bold; color: var(--green-theme); font-size: 1.1rem; padding-top: 15px; border-top: 2px solid #eee; }

    /* THÔNG TIN KHÁCH HÀNG (ADD LẠI) */
    .customer-grid { display: flex; gap: 30px; margin-top: 30px; border-top: 1px solid #eee; padding-top: 30px; }
    .customer-col { flex: 1; }
    .customer-col h4 { font-size: 1.1rem; margin-bottom: 10px; color: #333; }
    .customer-col address { font-style: normal; line-height: 1.6; color: #666; background: #f9f9f9; padding: 15px; border-radius: 8px; font-size: 0.95rem; }

    /* BUTTONS */
    .thankyou-actions { margin-top: 40px; display: flex; justify-content: center; gap: 20px; }
    .btn-action { padding: 12px 35px; border-radius: 50px; font-weight: 600; text-decoration: none; cursor: pointer; display: inline-block; transition: 0.3s; }
    .btn-yellow { background: #f1c40f; color: #fff; box-shadow: 0 4px 15px rgba(241, 196, 15, 0.4); }
    .btn-yellow:hover { background: #d4ac0d; color: #fff; transform: translateY(-2px); }
    .btn-green { background: var(--green-theme); color: white; box-shadow: 0 4px 15px rgba(46, 204, 113, 0.4); }
    .btn-green:hover { background: var(--green-dark); color: white; transform: translateY(-2px); }

    @media (max-width: 768px) { .customer-grid { flex-direction: column; } }
</style>

<div class="thankyou-page-wrapper">
    <div class="container">
        <div class="thankyou-card">

            <?php if ( ! $is_done ) : ?>
                
                <div class="pending-header">
                    <span class="pending-icon">⚠️</span>
                    <h1 class="main-title" style="color: #856404;">Đơn hàng chưa hoàn tất!</h1>
                    <p class="sub-title" style="color: #856404;">Vui lòng quét mã bên dưới để thanh toán ngay.</p>
                </div>

            <?php else : ?>
                
                <div class="success-header">
                    <div class="success-checkmark">
                        <div class="check-icon">
                            <span class="icon-line line-tip"></span>
                            <span class="icon-line line-long"></span>
                        </div>
                    </div>
                    <h1 class="main-title" style="color: var(--green-theme);">Đặt hàng thành công!</h1>
                    <p class="sub-title">Cảm ơn bro, hệ thống đã xác nhận đơn hàng.</p>
                </div>

            <?php endif; ?>

            <div class="card-body">
                
                <?php if ( ! $is_done ) : ?>
                    <div class="payment-instruction-box">
                        <h3 style="color: var(--green-theme); margin-bottom: 20px;">Quét mã QR thanh toán</h3>
                        
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/qrcode.png" alt="QR Code" class="qr-image">
                        
                        <div style="margin-top: 20px;">
                            <p>Hoặc chuyển khoản thủ công:</p>
                            <div class="bank-details">
                                <div class="bank-row"><span class="bank-label">Ngân hàng:</span><span class="bank-value">MB Bank</span></div>
                                <div class="bank-row"><span class="bank-label">STK:</span><span class="bank-value">9999 8888 6666</span></div>
                                <div class="bank-row"><span class="bank-label">Chủ TK:</span><span class="bank-value">NGUYEN VAN A</span></div>
                                <div class="bank-row"><span class="bank-label">Nội dung:</span><span class="bank-value" style="color: #e74c3c;">DH<?php echo $order->get_order_number(); ?></span></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="order-section">
                    <h3 class="section-title">Chi tiết đơn hàng #<?php echo $order->get_order_number(); ?></h3>
                    <table class="custom-table">
                        <?php foreach ( $order->get_items() as $item ) : ?>
                            <tr>
                                <td>
                                    <?php echo $item->get_name(); ?> 
                                    <strong style="color: #999; font-size: 0.9em;">x <?php echo $item->get_quantity(); ?></strong>
                                </td>
                                <td style="text-align: right; font-weight: bold;">
                                    <?php echo $order->get_formatted_line_subtotal( $item ); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td>Tổng cộng</td>
                            <td style="text-align: right;">
                                <?php echo $order->get_formatted_order_total(); ?>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="customer-grid">
                    <div class="customer-col">
                        <h4>Thông tin thanh toán</h4>
                        <address>
                            <?php echo wp_kses_post( $order->get_formatted_billing_address() ); ?>
                            <?php if ( $order->get_billing_phone() ) : ?>
                                <br/><strong style="color:#333">SĐT:</strong> <?php echo esc_html( $order->get_billing_phone() ); ?>
                            <?php endif; ?>
                            <?php if ( $order->get_billing_email() ) : ?>
                                <br/><strong style="color:#333">Email:</strong> <?php echo esc_html( $order->get_billing_email() ); ?>
                            <?php endif; ?>
                        </address>
                    </div>
                    
                    <?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() ) : ?>
                        <div class="customer-col">
                            <h4>Địa chỉ giao hàng</h4>
                            <address>
                                <?php echo wp_kses_post( $order->get_formatted_shipping_address() ); ?>
                            </address>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="thankyou-actions">
                    <?php if ( ! $is_done ) : ?>
                        <a href="<?php echo esc_url( add_query_arg( 'confirmed', '1' ) ); ?>" class="btn-action btn-yellow">
                            Tôi đã chuyển khoản xong
                        </a>
                    <?php else : ?>
                        <a href="<?php echo esc_url( home_url() ); ?>" class="btn-action btn-green">
                            Tiếp tục mua sắm
                        </a>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>