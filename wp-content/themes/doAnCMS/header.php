<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php bloginfo('name'); ?> - <?php bloginfo('description'); ?></title>
  <?php wp_head(); ?>
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
    }

    /* HEADER */
    .header {
      background-color: #fff;
      padding: 15px 20px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      position: sticky;
      top: 0;
      z-index: 999;
    }

    .header-container {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
    }

    .logo a {
      display: flex;
      align-items: center;
      text-decoration: none;
    }

    .logo img {
      width: 150px;
      /* chiều rộng cố định hoặc % nếu muốn co theo container */
      height: auto;
      /* chiều cao tự động theo tỉ lệ */
      margin-right: 10px;
      object-fit: contain;
      /* giữ tỉ lệ hình, không bị méo */
    }

    .logo span {
      font-weight: bold;
      color: #6b9d3e;
      font-size: 20px;
    }

    .search-bar input {
      padding: 8px 12px;
      width: 250px;
      border-radius: 8px;
      border: 1px solid #ddd;
      transition: all 0.3s;
    }

    .header-right {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .header-right .phone {
      font-weight: 500;
      color: #333;
    }

    .header-right .cart a {
      font-size: 22px;
      color: #333;
      text-decoration: none;
    }

    .nav-toggle {
      display: none;
      font-size: 24px;
      cursor: pointer;
    }

    /* NAVIGATION */
    .nav {
      background-color: #6b9d3e;
    }

    .nav-container {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      transition: max-height 0.3s ease;
    }

    .nav-container a {
      color: #fff;
      padding: 12px 18px;
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s;
    }

    .nav-container a:hover {
      background-color: #557c2a;
      border-radius: 6px;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
      .header-container {
        flex-direction: column;
        align-items: flex-start;
      }

      .search-bar input {
        width: 100%;
        margin-top: 10px;
      }

      .nav-toggle {
        display: block;
        color: #fff;
        background: #6b9d3e;
        padding: 10px 15px;
        border-radius: 6px;
        margin-top: 10px;
      }

      .nav-container {
        flex-direction: column;
        align-items: flex-start;
        display: none;
        /* hidden by default */
        width: 100%;
      }

      .nav-container.active {
        display: flex;
      }

      .nav-container a {
        padding: 12px 20px;
        width: 100%;
        text-align: left;
      }
    }
  </style>
</head>



<body <?php body_class(); ?>>

  <!-- Header -->
  <div class="header">
    <div class="header-container">

      <!-- Logo -->
      <div class="logo">
        <a href="<?php echo esc_url(home_url('/')); ?>">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/of.png" alt="Organic Shop Logo">
          <span>Organic Foods Shop</span>
        </a>
      </div>

      <!-- Search Bar -->
      <div class="search-bar">
        <form role="search" method="get" class="searchform" action="<?php echo home_url('/'); ?>">
          <input type="text" value="<?php echo get_search_query(); ?>" name="s"
            placeholder="Tìm sản phẩm bạn mong muốn...">
        </form>
      </div>

      <!-- Header Right -->
      <div class="header-right">
        <div class="phone">
          📞 0934 919 897
        </div>
        <div class="cart">
          <a href="<?php echo wc_get_cart_url(); ?>">🛒</a>
        </div>
        <div class="nav-toggle" id="nav-toggle">☰ Menu</div>
        <div class="login-btn">

          <?php if (is_user_logged_in()) : ?>

            <?php
            $user = wp_get_current_user();
            $username = $user->display_name ?: $user->user_login;
            ?>

            <div class="user-menu">
              <span class="username">Xin chào, <?php echo esc_html($username); ?> 👋</span>
              <div class="menu-toggle" id="userMenuToggle">⋮</div>

              <div class="user-dropdown" id="userDropdown">
                <a href="<?php echo wc_get_cart_url(); ?>">🛒 Giỏ hàng</a>
                <a href="<?php echo wp_logout_url(home_url()); ?>">🚪 Đăng xuất</a>
              </div>
            </div>

          <?php else : ?>

            <a href="<?php echo esc_url(home_url('/tai-khoan/')); ?>"
              style="border:1px solid #6b9d3e; padding:8px 14px; border-radius:6px;
                  color:#6b9d3e; font-weight:600; text-decoration:none; background:#fff;">
              Đăng nhập
            </a>

          <?php endif; ?>

        </div>

      </div>

    </div>
  </div>

  <!-- Navigation -->
  <div class="nav">
    <div class="nav-container" id="nav-container">
      <a href="<?php echo home_url('/'); ?>">HOME</a>
      <a href="<?php echo home_url('/#organic'); ?>">VỀ ORGANIC SHOP</a>
      <a href="<?php echo home_url('/blog-page'); ?>">BLOGS ORGANIC</a>
      <a href="<?php echo home_url('/contact'); ?>">LIÊN HỆ</a>
    </div>
  </div>

  <script>
    const navToggle = document.getElementById('nav-toggle');
    const navContainer = document.getElementById('nav-container');

    navToggle.addEventListener('click', () => {
      navContainer.classList.toggle('active');
    });
  </script>

  <?php wp_footer(); ?>


  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const toggle = document.getElementById("userMenuToggle");
      const dropdown = document.getElementById("userDropdown");

      if (toggle && dropdown) {
        toggle.addEventListener("click", () => {
          dropdown.style.display =
            dropdown.style.display === "block" ? "none" : "block";
        });

        document.addEventListener("click", function(e) {
          if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.style.display = "none";
          }
        });
      }
    });
  </script>

</body>

</html>