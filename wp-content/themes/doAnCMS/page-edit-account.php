<?php
/**
 * Template Name: Chỉnh sửa thông tin
 */

if ( ! is_user_logged_in() ) {
    wp_safe_redirect( get_permalink( get_option('woocommerce_myaccount_page_id') ) );
    exit;
}

get_header(); 
$user = wp_get_current_user();
?>

<div class="edit-account-page-wrapper">
    <div class="edit-account-container">
        
        <a href="<?php echo site_url('/page-my-account'); ?>" style="text-decoration: none; color: #666; font-size: 14px; display: inline-flex; align-items: center; margin-bottom: 20px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 5px;"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Quay lại Dashboard
        </a>

        <h1 class="edit-account-title">Cập nhật thông tin</h1>
        <p class="edit-account-subtitle">Thay đổi thông tin cá nhân và mật khẩu đăng nhập</p>

        <?php wc_print_notices(); ?>

        <form class="woocommerce-EditAccountForm edit-account" action="<?php echo esc_url( get_permalink() ); ?>" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

            <?php do_action( 'woocommerce_edit_account_form_start' ); ?>
            
            <input type="hidden" name="ha_redirect_url" value="<?php echo esc_url( get_permalink() ); ?>" />

            <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
                <label for="account_first_name"><?php esc_html_e( 'First name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" />
            </p>
            <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
                <label for="account_last_name"><?php esc_html_e( 'Last name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" />
            </p>
            <div class="clear"></div>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="account_display_name"><?php esc_html_e( 'Display name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" /> 
                <span style="font-size: 12px; color: #888;"><em>Tên này sẽ hiển thị trong trang tài khoản và phần đánh giá.</em></span>
            </p>
            <div class="clear"></div>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="account_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                <input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" />
            </p>

            <fieldset>
                <legend><?php esc_html_e( 'Password change', 'woocommerce' ); ?></legend>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="password_current"><?php esc_html_e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
                    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="current-password" />
                </p>
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="password_1"><?php esc_html_e( 'New password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
                    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="new-password" />
                </p>
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="password_2"><?php esc_html_e( 'Confirm new password', 'woocommerce' ); ?></label>
                    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="new-password" />
                </p>
            </fieldset>
            <div class="clear"></div>

            <?php do_action( 'woocommerce_edit_account_form' ); ?>

            <p>
                <?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
                <button type="submit" class="woocommerce-Button button" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></button>
                <input type="hidden" name="action" value="save_account_details" />
            </p>

            <?php do_action( 'woocommerce_edit_account_form_end' ); ?>
        </form>
        
    </div>
</div>

<?php get_footer(); ?>