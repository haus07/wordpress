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
        gap: 20px;
    }

    .logo a {
        display: flex;
        align-items: center;
        text-decoration: none;
    }

    .logo img {
        width: 150px;
        height: auto;
        margin-right: 10px;
        object-fit: contain;
    }

    .logo span {
        font-weight: bold;
        color: #6b9d3e;
        font-size: 20px;
    }

    /* SEARCH BAR - Improved Design */
    .search-bar {
        position: relative;
        flex: 1;
        max-width: 400px;
        min-width: 250px;
    }

    .search-bar form {
        position: relative;
        width: 100%;
    }

    .search-bar input[type="text"] {
        width: 100%;
        padding: 12px 50px 12px 20px;
        border-radius: 50px;
        border: 2px solid #e0e0e0;
        font-size: 14px;
        transition: all 0.3s ease;
        outline: none;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .search-bar input[type="text"]:focus {
        border-color: #6b9d3e;
        box-shadow: 0 4px 12px rgba(107, 157, 62, 0.15);
    }

    .search-bar input[type="text"]::placeholder {
        color: #999;
        font-size: 14px;
    }

    .search-bar button {
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        background: #6b9d3e;
        border: none;
        color: #fff;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .search-bar button:hover {
        background: #557c2a;
        transform: translateY(-50%) scale(1.05);
    }

    .search-bar button:active {
        transform: translateY(-50%) scale(0.95);
    }

    /* Search Results Dropdown (optional enhancement) */
    .search-results {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        margin-top: 8px;
        display: none;
        max-height: 400px;
        overflow-y: auto;
        z-index: 1000;
    }

    .search-results.active {
        display: block;
    }

    .search-result-item {
        padding: 12px 20px;
        border-bottom: 1px solid #f0f0f0;
        cursor: pointer;
        transition: background 0.2s;
    }

    .search-result-item:hover {
        background: #f8f8f8;
    }

    .search-result-item:last-child {
        border-bottom: none;
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .header-right .phone {
        font-weight: 500;
        color: #333;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .header-right .cart a {
        font-size: 24px;
        color: #333;
        text-decoration: none;
        position: relative;
        transition: transform 0.2s;
    }

    .header-right .cart a:hover {
        transform: scale(1.1);
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

        .search-bar {
            width: 100%;
            max-width: 100%;
            order: 3;
        }

        .header-right {
            width: 100%;
            justify-content: space-between;
        }

        .nav-toggle {
            display: block;
            color: #fff;
            background: #6b9d3e;
            padding: 10px 15px;
            border-radius: 6px;
        }

        .nav-container {
            flex-direction: column;
            align-items: flex-start;
            display: none;
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

    @media (max-width: 480px) {
        .logo span {
            font-size: 16px;
        }

        .logo img {
            width: 120px;
        }

        .header-right .phone {
            font-size: 14px;
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
                <form role="search" method="get" class="searchform" action="<?php echo esc_url(home_url('/')); ?>">
                    <input type="text" value="<?php echo esc_attr(get_search_query()); ?>" name="s"
                        placeholder="Tìm sản phẩm bạn mong muốn..." autocomplete="off" id="search-input">
                    <input type="hidden" name="post_type" value="product">
                    <button type="submit" aria-label="Tìm kiếm">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.35-4.35"></path>
                        </svg>
                    </button>
                </form>
                <!-- Optional: Search results dropdown -->
                <div class="search-results" id="search-results"></div>
            </div>

            <!-- Header Right -->
            <div class="header-right">
                <div class="phone">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path
                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                        </path>
                    </svg>
                    0934 919 897
                </div>
                <div class="cart">
                    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" aria-label="Giỏ hàng">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                    </a>
                </div>
                <div class="nav-toggle" id="nav-toggle">☰ Menu</div>
            </div>

        </div>
    </div>

    <!-- Navigation -->
    <div class="nav">
        <div class="nav-container" id="nav-container">
            <a href="<?php echo esc_url(home_url('/')); ?>">HOME</a>
            <a href="<?php echo esc_url(home_url('/#organic')); ?>">VỀ ORGANIC SHOP</a>
            <a href="<?php echo esc_url(home_url('/#blog')); ?>">BLOGS ORGANIC</a>
            <a href="<?php echo esc_url(home_url('/contact')); ?>">LIÊN HỆ</a>
        </div>
        <div class="nav-toggle" id="nav-toggle">☰ Menu</div>
        <div class="login-btn">

    <?php if ( is_user_logged_in() ) : ?>

        <?php 
            $user = wp_get_current_user();
            $username = $user->display_name ?: $user->user_login;
        ?>

        <div class="user-menu">
            <span class="username">Xin chào, <?php echo esc_html($username); ?> 👋</span>
            <div class="menu-toggle" id="userMenuToggle">⋮</div>

            <div class="user-dropdown" id="userDropdown">
                <a href="<?php echo wc_get_cart_url(); ?>">🛒 Giỏ hàng</a>
                <a href="<?php echo wp_logout_url( home_url() ); ?>">🚪 Đăng xuất</a>
            </div>
        </div>

    <?php else : ?>

        <a href="<?php echo esc_url( home_url('/tai-khoan/') ); ?>"
           style="border:1px solid #6b9d3e; padding:8px 14px; border-radius:6px;
                  color:#6b9d3e; font-weight:600; text-decoration:none; background:#fff;">
            Đăng nhập
        </a>

    <?php endif; ?>

</div>

      </div>

    </div>

    <script>
    // Mobile menu toggle
    const navToggle = document.getElementById('nav-toggle');
    const navContainer = document.getElementById('nav-container');

    navToggle.addEventListener('click', () => {
        navContainer.classList.toggle('active');
    });

    // Optional: Live search functionality (AJAX)
    const searchInput = document.getElementById('search-input');
    const searchResults = document.getElementById('search-results');
    let searchTimeout;

    searchInput.addEventListener('input', function() {
        const query = this.value.trim();

        clearTimeout(searchTimeout);

        if (query.length < 2) {
            searchResults.classList.remove('active');
            return;
        }

        searchTimeout = setTimeout(() => {
            // AJAX search call
            fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=live_search&s=' +
                    encodeURIComponent(query) + '&post_type=product')
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        searchResults.innerHTML = data.map(item =>
                            `<div class="search-result-item" onclick="window.location.href='${item.url}'">
                                <strong>${item.title}</strong>
                                ${item.price ? `<span style="color: #6b9d3e; margin-left: 10px;">${item.price}</span>` : ''}
                            </div>`
                        ).join('');
                        searchResults.classList.add('active');
                    } else {
                        searchResults.innerHTML =
                            '<div class="search-result-item">Không tìm thấy sản phẩm</div>';
                        searchResults.classList.add('active');
                    }
                })
                .catch(error => {
                    console.error('Search error:', error);
                });
        }, 300);
    });

    // Close search results when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.search-bar')) {
            searchResults.classList.remove('active');
        }
    });
    </script>

    <?php wp_footer(); ?>


  <script>
  document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById("userMenuToggle");
    const dropdown = document.getElementById("userDropdown");

    if (toggle && dropdown) {
      toggle.addEventListener("click", () => {
        dropdown.style.display =
          dropdown.style.display === "block" ? "none" : "block";
      });

      document.addEventListener("click", function (e) {
        if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
          dropdown.style.display = "none";
        }
      });
    }
  });
</script>
</body>

</html>