<?php
/**
 * Template Name: Trang tài khoản tùy chỉnh
 * Description: Template login/register màu trắng + xanh lá cây.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$status_message = '';

// XỬ LÝ ĐĂNG NHẬP
if ( isset($_POST['custom_login']) && check_admin_referer('custom_login_action','custom_login_nonce') ) {
    $creds = array();
    $creds['user_login'] = sanitize_user( wp_unslash($_POST['log']) );
    $creds['user_password'] = $_POST['pwd'];
    $creds['remember'] = ! empty( $_POST['rememberme'] );

    $user = wp_signon( $creds, is_ssl() );

    if ( is_wp_error( $user ) ) {
        $status_message = '<div class="ca-error">Lỗi: ' . esc_html( $user->get_error_message() ) . '</div>';
    } else {
        wp_safe_redirect( isset($_POST['redirect_to']) && ! empty($_POST['redirect_to']) ? esc_url_raw($_POST['redirect_to']) : home_url() );
        exit;
    }
}

// XỬ LÝ ĐĂNG KÝ
if ( isset($_POST['custom_register']) && check_admin_referer('custom_register_action','custom_register_nonce') ) {
    if ( ! get_option('users_can_register') ) {
        $status_message = '<div class="ca-error">Đăng ký hiện bị tắt. Bật "Anyone can register" trong Settings → General.</div>';
    } else {
        $user_login = sanitize_user( wp_unslash( $_POST['user_login'] ) );
        $user_email = sanitize_email( wp_unslash( $_POST['user_email'] ) );
        $user_pass  = $_POST['user_pass'];
        $user_pass2 = $_POST['user_pass2'];

        if ( empty($user_login) || empty($user_email) || empty($user_pass) ) {
            $status_message = '<div class="ca-error">Vui lòng điền đầy đủ.</div>';
        } elseif ( ! is_email($user_email) ) {
            $status_message = '<div class="ca-error">Email không hợp lệ.</div>';
        } elseif ( username_exists( $user_login ) ) {
            $status_message = '<div class="ca-error">Username đã tồn tại.</div>';
        } elseif ( email_exists( $user_email ) ) {
            $status_message = '<div class="ca-error">Email đã được dùng.</div>';
        } elseif ( $user_pass !== $user_pass2 ) {
            $status_message = '<div class="ca-error">Mật khẩu không khớp.</div>';
        } else {
            $user_id = wp_create_user( $user_login, $user_pass, $user_email );
            if ( is_wp_error($user_id) ) {
                $status_message = '<div class="ca-error">Lỗi khi tạo user: ' . esc_html( $user_id->get_error_message() ) . '</div>';
            } else {
                // Optionally send new user notification
                wp_new_user_notification( $user_id, null, 'user' );

                // Auto-login after register (optional)
                $creds = array(
                    'user_login'    => $user_login,
                    'user_password' => $user_pass,
                    'remember'      => true,
                );
                wp_signon( $creds, is_ssl() );

                wp_safe_redirect( home_url('/') );
                exit;
            }
        }
    }
}

get_header();
?>

<style>
/* --- phong cách trắng + xanh lá --- */
.ca-wrapper{
  max-width:960px;
  margin:40px auto;
  background: #ffffff;
  border-radius:12px;
  box-shadow: 0 6px 30px rgba(0,0,0,0.08);
  overflow: hidden;
  display:flex;
  min-height:480px;
}

.ca-left{
  flex:1 1 400px;
  background: linear-gradient(180deg,#e9f7ee 0%, #d6f0da 100%);
  padding:40px;
  display:flex;
  flex-direction:column;
  justify-content:center;
  align-items:flex-start;
  gap:12px;
  color:#034d20;
}

.ca-left h2{
  margin:0;
  font-size:28px;
  letter-spacing:0.2px;
}

.ca-left p{ margin:0; opacity:.95; }

.ca-right{
  flex:1 1 520px;
  padding:40px;
}

.ca-tabs{ display:flex; gap:8px; margin-bottom:18px; }
.ca-tab{
  padding:8px 14px;
  border-radius:8px;
  cursor:pointer;
  border:1px solid #e6e6e6;
  background:#fff;
}
.ca-tab.active{
  background:#e6fbe6;
  border-color:#bfe9bf;
  color:#00581a;
  font-weight:600;
}

.ca-form{ max-width:420px; }
.ca-form label{ display:block; font-size:14px; margin-bottom:6px; }
.ca-form input[type="text"],
.ca-form input[type="email"],
.ca-form input[type="password"]{
  width:100%;
  padding:10px 12px;
  border:1px solid #ddd;
  border-radius:8px;
  margin-bottom:12px;
  box-sizing:border-box;
}

.ca-btn{
  display:inline-block;
  padding:10px 16px;
  border-radius:10px;
  background:#2aa64f;
  color:white;
  border:0;
  cursor:pointer;
  font-weight:600;
}

.ca-link{ color:#2aa64f; text-decoration:none; }

.ca-error{ padding:10px; background:#ffe6e6; color:#8d1111; border-radius:8px; margin-bottom:12px; }
.ca-success{ padding:10px; background:#eaffea; color:#0a6e1a; border-radius:8px; margin-bottom:12px; }

@media (max-width:880px){
  .ca-wrapper{ flex-direction:column; margin:20px; }
  .ca-left{ text-align:center; align-items:center; padding:30px; }
  .ca-right{ padding:24px; }
}
</style>

<div class="ca-wrapper" role="main">
  <div class="ca-left" aria-hidden="false">
    <h2>Chào mừng trở lại</h2>
    <p>Nhanh chóng đăng nhập hoặc tạo tài khoản mới để quản lý đặt phòng, đơn hàng và hồ sơ của bạn.</p>
    <p style="margin-top:16px; font-size:13px; opacity:.9">An toàn • Nhanh • Giao diện đơn giản</p>
  </div>

  <div class="ca-right">
    <?php
      // Hiện thông báo lỗi / success
      echo $status_message;
    ?>

    <div class="ca-tabs" id="caTabs">
      <div class="ca-tab active" data-tab="login">Đăng nhập</div>
      <div class="ca-tab" data-tab="register">Đăng ký</div>
    </div>

    <!-- LOGIN -->
    <div class="ca-form" id="tab-login">
      <form method="post" novalidate>
        <?php wp_nonce_field('custom_login_action','custom_login_nonce'); ?>
        <input type="hidden" name="custom_login" value="1" />
        <input type="hidden" name="redirect_to" value="<?php echo esc_attr( wp_get_referer() ?: home_url() ); ?>" />
        <label for="log">Username hoặc Email</label>
        <input name="log" id="log" type="text" autocomplete="username" required />

        <label for="pwd">Mật khẩu</label>
        <input name="pwd" id="pwd" type="password" autocomplete="current-password" required />

        <p>
          <label><input name="rememberme" type="checkbox" value="forever" /> Ghi nhớ tôi</label>
        </p>

        <button class="ca-btn" type="submit">Đăng nhập</button>
        <p style="margin-top:10px; font-size:13px;">
          <a class="ca-link" href="<?php echo wp_lostpassword_url(); ?>">Quên mật khẩu?</a>
        </p>
      </form>
    </div>

    <!-- REGISTER -->
    <div class="ca-form" id="tab-register" style="display:none;">
      <form method="post" novalidate>
        <?php wp_nonce_field('custom_register_action','custom_register_nonce'); ?>
        <input type="hidden" name="custom_register" value="1" />
        <label for="user_login">Username</label>
        <input name="user_login" id="user_login" type="text" required />

        <label for="user_email">Email</label>
        <input name="user_email" id="user_email" type="email" required />

        <label for="user_pass">Mật khẩu</label>
        <input name="user_pass" id="user_pass" type="password" required />

        <label for="user_pass2">Nhập lại mật khẩu</label>
        <input name="user_pass2" id="user_pass2" type="password" required />

        <button class="ca-btn" type="submit">Đăng ký</button>
      </form>
    </div>

  </div>
</div>

<script>
(function(){
  const tabs = document.querySelectorAll('.ca-tab');
  const tabLogin = document.getElementById('tab-login');
  const tabRegister = document.getElementById('tab-register');

  tabs.forEach(t=>{
    t.addEventListener('click', function(){
      tabs.forEach(x=>x.classList.remove('active'));
      this.classList.add('active');
      if (this.dataset.tab === 'login') {
        tabLogin.style.display = '';
        tabRegister.style.display = 'none';
      } else {
        tabLogin.style.display = 'none';
        tabRegister.style.display = '';
      }
    });
  });
})();
</script>

<?php
get_footer();
