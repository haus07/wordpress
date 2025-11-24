<?php
/**
 * Template Name: Trang lịch sử đơn hàng
 * Description: Template xem lịch sử đơn hàng (WooCommerce) với tông màu Trắng - Xanh lá.
 */

// --- 1. XỬ LÝ HỦY ĐƠN (Phần này giữ nguyên, logic chuẩn rồi) ---
if ( isset( $_GET['cancel_order'] ) && isset( $_GET['order_id'] ) && isset( $_GET['_wpnonce'] ) ) {
    
    $order_id         = absint( $_GET['order_id'] );
    $nonce_value      = $_GET['_wpnonce'];
    
    // Link hiện tại sạch sẽ để redirect về sau khi xử lý
    $redirect_to      = remove_query_arg( array( 'cancel_order', 'order_id', '_wpnonce' ) ); 

    // Kiểm tra bảo mật (Nonce)
    if ( wp_verify_nonce( $nonce_value, 'woocommerce-cancel_order' ) ) {
        
        $order = wc_get_order( $order_id );
        
        // Kiểm tra quyền: Phải là đơn của user hiện tại và trạng thái cho phép hủy
        if ( $order && $order->get_user_id() === get_current_user_id() && $order->has_status( array( 'pending', 'failed', 'on-hold' ) ) ) {
            
            // Thực hiện hủy đơn
            $order->update_status( 'cancelled', __( 'Đơn hàng bị hủy bởi khách hàng.', 'woocommerce' ) );
            
            // Thêm thông báo thành công vào hệ thống
            wc_add_notice( 'Đơn hàng #' . $order_id . ' đã được hủy thành công.', 'success' );
            
            // Reload lại trang
            wp_safe_redirect( $redirect_to );
            exit;
        } else {
            wc_add_notice( 'Không thể hủy đơn hàng này (Sai trạng thái hoặc không chính chủ).', 'error' );
            wp_safe_redirect( $redirect_to ); // Redirect về để tránh lỗi lặp
            exit;
        }
    }
}

get_header(); 
?>

<style>
    /* CSS Tùy chỉnh - Giữ nguyên như cũ */
    .my-order-history-page {
        background-color: #f8f9fa;
        padding: 40px 0;
        min-height: 80vh;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    .container-custom {
        max-width: 1000px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .order-card {
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        padding: 30px;
        margin-bottom: 30px;
        border-top: 4px solid #28a745;
    }

    .page-title {
        color: #28a745;
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 25px;
        text-transform: uppercase;
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
    }

    /* Table Styles */
    .custom-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .custom-table th {
        text-align: left;
        padding: 15px;
        background-color: #e8f5e9;
        color: #1b5e20;
        font-weight: 600;
        border-bottom: 2px solid #28a745;
    }

    .custom-table td {
        padding: 15px;
        border-bottom: 1px solid #eee;
        color: #555;
        vertical-align: middle;
    }

    .custom-table tr:hover {
        background-color: #fafafa;
    }

    /* Status Badges */
    .status-badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
        display: inline-block;
    }
    .status-completed { background-color: #d4edda; color: #155724; }
    .status-processing { background-color: #c3e6cb; color: #155724; }
    .status-pending { background-color: #fff3cd; color: #856404; }
    .status-cancelled { background-color: #f8d7da; color: #721c24; }
    .status-failed { background-color: #f8d7da; color: #721c24; }

    /* Buttons */
    .btn-action {
        text-decoration: none;
        padding: 8px 15px;
        border-radius: 5px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-block;
        margin-right: 5px;
        cursor: pointer;
    }

    .btn-view {
        background-color: #28a745;
        color: #fff;
        border: 1px solid #28a745;
    }
    .btn-view:hover {
        background-color: #218838;
        color: #fff;
    }

    .btn-cancel {
        background-color: #dc3545;
        color: #fff;
        border: 1px solid #dc3545;
    }
    .btn-cancel:hover {
        background-color: #c82333;
        color: #fff;
    }

    .empty-notice {
        text-align: center;
        padding: 40px;
        color: #666;
    }
    
    .login-notice {
        text-align: center;
        padding: 50px;
    }
    
    /* Style cho thông báo Woo */
    .woocommerce-message {
        background: #e8f5e9;
        color: #155724;
        padding: 15px;
        border-left: 5px solid #28a745;
        margin-bottom: 20px;
    }
    .woocommerce-error {
        background: #f8d7da;
        color: #721c24;
        padding: 15px;
        border-left: 5px solid #dc3545;
        margin-bottom: 20px;
        list-style: none;
    }

    /* Responsive Mobile */
    @media (max-width: 768px) {
        .custom-table thead { display: none; }
        .custom-table, .custom-table tbody, .custom-table tr, .custom-table td { display: block; width: 100%; }
        .custom-table tr { margin-bottom: 15px; border: 1px solid #eee; border-radius: 8px; padding: 10px; }
        .custom-table td { text-align: right; padding-left: 50%; position: relative; border-bottom: none; }
        .custom-table td::before { content: attr(data-label); position: absolute; left: 10px; width: 45%; text-align: left; font-weight: bold; color: #28a745; }
    }
</style>

<div class="my-order-history-page">
    <div class="container-custom">
        
        <?php wc_print_notices(); ?>
        
        <div class="order-card">
            <h1 class="page-title">Lịch sử đơn hàng</h1>

            <?php
            // 1. Kiểm tra WooCommerce
            if ( ! class_exists( 'WooCommerce' ) ) {
                echo '<p class="empty-notice">Vui lòng cài đặt và kích hoạt WooCommerce.</p>';
            } 
            // 2. Kiểm tra đăng nhập
            elseif ( ! is_user_logged_in() ) {
                echo '<div class="login-notice">';
                echo '<p>Vui lòng đăng nhập để xem đơn hàng của bạn.</p>';
                echo '<a href="' . get_permalink( get_option('woocommerce_myaccount_page_id') ) . '" class="btn-action btn-view">Đăng nhập ngay</a>';
                echo '</div>';
            } 
            else {
                // 3. Lấy đơn hàng
                $current_user_id = get_current_user_id();
                
                $args = array(
                    'customer_id' => $current_user_id,
                    'limit'       => -1,
                    'orderby'     => 'date',
                    'order'       => 'DESC',
                    'return'      => 'ids',
                );

                $customer_orders = wc_get_orders( $args );

                if ( ! empty( $customer_orders ) ) {
                    ?>
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Mã đơn</th>
                                <th>Ngày đặt</th>
                                <th>Trạng thái</th>
                                <th>Tổng tiền</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ( $customer_orders as $order_id ) {
                                $order = wc_get_order( $order_id );
                                if ( ! $order ) continue;
                                
                                $status_slug = $order->get_status();
                                $status_name = wc_get_order_status_name( $status_slug );
                                ?>
                                <tr>
                                    <td data-label="Mã đơn">#<?php echo $order->get_order_number(); ?></td>
                                    <td data-label="Ngày đặt"><?php echo wc_format_datetime( $order->get_date_created() ); ?></td>
                                    <td data-label="Trạng thái">
                                        <span class="status-badge status-<?php echo esc_attr($status_slug); ?>">
                                            <?php echo esc_html($status_name); ?>
                                        </span>
                                    </td>
                                    <td data-label="Tổng tiền">
                                        <?php echo $order->get_formatted_order_total(); ?>
                                    </td>
                                    <td data-label="Hành động">
                                        <a href="<?php echo esc_url( $order->get_view_order_url() ); ?>" class="btn-action btn-view">
                                            Xem
                                        </a>

                                        <?php 
                                        // --- LOGIC NÚT HỦY ĐƠN HÀNG (Đã sửa lại) ---
                                        $allow_cancel_statuses = array( 'pending', 'on-hold', 'failed' );

                                        if ( in_array( $status_slug, $allow_cancel_statuses ) ) {
                                            
                                            // TẠO URL HỦY BẰNG TAY (Để khớp với code xử lý ở trên)
                                            // Nó sẽ tạo ra link kiểu: ?cancel_order=true&order_id=123&_wpnonce=xyz
                                            $cancel_url = wp_nonce_url( 
                                                add_query_arg( array( 
                                                    'cancel_order' => 'true', 
                                                    'order_id'     => $order->get_id() 
                                                ), get_permalink() ), // get_permalink() để nó load lại đúng trang này
                                                'woocommerce-cancel_order' 
                                            );
                                            ?>
                                            <a href="<?php echo esc_url( $cancel_url ); ?>" 
                                               class="btn-action btn-cancel"
                                               onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng #<?php echo $order->get_order_number(); ?> không?');">
                                               Hủy đơn
                                            </a>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                } else {
                    echo '<p class="empty-notice">Bạn chưa có đơn hàng nào.</p>';
                    echo '<div style="text-align:center"><a href="'. get_permalink( wc_get_page_id( 'shop' ) ) .'" class="btn-action btn-view">Mua sắm ngay</a></div>';
                }
            }
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>