<?php
/**
 * Template Name: Trang cá nhân
 */

// Chặn truy cập nếu chưa đăng nhập (Redirect về trang login mặc định của Woo)
if ( ! is_user_logged_in() ) {
    wp_redirect( get_permalink( get_option('woocommerce_myaccount_page_id') ) );
    exit;
}

get_header(); 

$current_user = wp_get_current_user();
$user_id = $current_user->ID;

// Lấy thống kê đơn hàng
$order_count = wc_get_customer_order_count( $user_id );
// Lấy số lượng Wishlist (nếu bro dùng logic ở code cũ)
$wishlist = get_user_meta( $user_id, '_doAnCMS_wishlist', true ) ?: [];
$wishlist_count = count( $wishlist );
?>

<div class="container" style="max-width: 1200px; margin: 40px auto; padding: 0 15px;">
    
    <?php
    // LOGIC: Nếu đang ở trang gốc (/my-account/) thì hiện Dashboard Đẹp
    // Nếu đang ở trang con (/my-account/orders/...) thì hiện nội dung WooCommerce chuẩn
    
    // Kiểm tra xem có đang ở endpoint nào không
    $is_dashboard_home = true;
    $endpoints = array( 'orders', 'view-order', 'downloads', 'edit-account', 'edit-address', 'payment-methods', 'lost-password' );
    
    foreach ( $endpoints as $endpoint ) {
        if ( is_wc_endpoint_url( $endpoint ) ) {
            $is_dashboard_home = false;
            break;
        }
    }

    if ( $is_dashboard_home ) : 
    ?>
        <div class="ma-dashboard-hero">
            <div class="ma-user-info">
                <div class="ma-avatar">
                    <?php echo get_avatar( $user_id, 80 ); ?>
                </div>
                <div class="ma-welcome">
                    <h2>Xin chào, <?php echo esc_html( $current_user->display_name ); ?>! 👋</h2>
                    <p>Thành viên thân thiết</p>
                </div>
            </div>
            
            <div class="ma-stats">
                <div class="ma-stat-item">
                    <span class="ma-stat-number"><?php echo $order_count; ?></span>
                    <span class="ma-stat-label">Đơn hàng</span>
                </div>
                <div class="ma-stat-item">
                    <span class="ma-stat-number"><?php echo $wishlist_count; ?></span>
                    <span class="ma-stat-label">Yêu thích</span>
                </div>
            </div>
        </div>

        <div class="ma-grid-menu">
            <a href="<?php echo site_url('/page-history'); ?>" class="ma-card">
                <div class="ma-card-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                </div>
                <div class="ma-card-title">Đơn hàng của tôi</div>
                <div class="ma-card-desc">Xem và theo dõi đơn hàng</div>
            </a>
            <a href="<?php echo site_url('/page-edit-account'); ?>" class="ma-card">
                <div class="ma-card-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                </div>
                <div class="ma-card-title">Thông tin tài khoản</div>
                <div class="ma-card-desc">Đổi tên, mật khẩu</div>
            </a>
            
            <a href="<?php echo home_url('/page-wishlist'); ?>" class="ma-card">
                <div class="ma-card-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                </div>
                <div class="ma-card-title">Yêu thích</div>
                <div class="ma-card-desc">Sản phẩm đã lưu</div>
            </a>

            <a href="<?php echo wp_logout_url(home_url()); ?>" class="ma-card logout">
                <div class="ma-card-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                </div>
                <div class="ma-card-title">Đăng xuất</div>
                <div class="ma-card-desc">Thoát khỏi hệ thống</div>
            </a>
        </div>

    <?php else : ?>
        <div class="ma-inner-content">
            <a href="<?php echo get_permalink(); ?>" style="display:inline-flex; align-items:center; gap:5px; margin-bottom:20px; text-decoration:none; color:#28a745; font-weight:600;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Quay lại Dashboard
            </a>

            <div class="woocommerce-inner-wrapper" style="background:#fff; padding:30px; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.05);">
                <?php 
                    // Đây là hàm in ra nội dung của endpoint hiện tại
                    // Bro phải đảm bảo nội dung này được wrap trong shortcode my_account nếu page này chưa set
                    // Cách tốt nhất là gọi shortcode my_account, nhưng vì mình custom template nên dùng loop:
                    while ( have_posts() ) :
                        the_post();
                        the_content();
                    endwhile;
                ?>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php get_footer(); ?>