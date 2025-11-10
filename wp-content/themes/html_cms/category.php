<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Mục Sản Phẩm - Organic Shop</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f5f5f5;
        }

        .header {
            background-color: white;
            padding: 15px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo img {
            width: 40px;
            height: 40px;
        }

        .search-container {
            flex: 1;
            max-width: 600px;
            margin: 0 30px;
            display: flex;
            gap: 10px;
        }

        .search-select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: white;
        }

        .search-input {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .search-btn {
            background-color: #6b9d3e;
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .phone {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .phone-label {
            font-size: 12px;
            color: #999;
        }

        .phone-number {
            font-weight: bold;
            color: #333;
        }

        .cart {
            position: relative;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #6b9d3e;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        .nav {
            background-color: #6b9d3e;
            padding: 12px 0;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            gap: 30px;
        }

        .nav a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 14px;
        }

        .main-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
            display: flex;
            gap: 30px;
        }

        .sidebar {
            width: 250px;
            flex-shrink: 0;
        }

        .sidebar-section {
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .sidebar-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li {
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .sidebar-menu li:last-child {
            border-bottom: none;
        }

        .sidebar-menu a {
            text-decoration: none;
            color: #333;
            font-size: 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sidebar-menu a:hover {
            color: #6b9d3e;
        }

        .sidebar-menu .active {
            color: #6b9d3e;
            font-weight: bold;
        }

        .brand-list {
            list-style: none;
        }

        .brand-list li {
            padding: 5px 0;
        }

        .brand-list label {
            font-size: 14px;
            cursor: pointer;
        }

        .brand-count {
            color: #999;
            font-size: 12px;
        }

        .search-box {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .price-slider {
            margin: 20px 0;
        }

        .price-range {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            font-size: 14px;
            color: #666;
        }

        .slider {
            width: 100%;
            height: 5px;
            background: #ddd;
            border-radius: 5px;
            position: relative;
        }

        .slider-track {
            height: 100%;
            background: #6b9d3e;
            border-radius: 5px;
        }

        .content {
            flex: 1;
        }

        .content-header {
            background-color: white;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-count {
            font-size: 14px;
            color: #666;
        }

        .view-options {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .sort-select {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: white;
        }

        .view-toggle {
            display: flex;
            gap: 5px;
        }

        .view-btn {
            width: 35px;
            height: 35px;
            border: 1px solid #ddd;
            background-color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
        }

        .view-btn.active {
            background-color: #6b9d3e;
            color: white;
            border-color: #6b9d3e;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .product-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            position: relative;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #000;
            color: white;
            padding: 5px 10px;
            font-size: 11px;
            border-radius: 3px;
            font-weight: bold;
        }

        .product-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            cursor: pointer;
        }

        .product-info {
            padding: 15px;
        }

        .product-name {
            font-size: 14px;
            margin-bottom: 10px;
            height: 40px;
            overflow: hidden;
            cursor: pointer;
        }

        .product-name:hover {
            color: #6b9d3e;
        }

        .product-price {
            color: #6b9d3e;
            font-weight: bold;
            font-size: 16px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 40px;
            padding: 20px 0;
        }

        .page-btn {
            width: 40px;
            height: 40px;
            border: 1px solid #ddd;
            background-color: white;
            cursor: pointer;
            border-radius: 4px;
            font-weight: 500;
        }

        .page-btn:hover {
            background-color: #f5f5f5;
        }

        .page-btn.active {
            background-color: #6b9d3e;
            color: white;
            border-color: #6b9d3e;
        }

        .recently-viewed {
            background-color: white;
            padding: 30px 20px;
            margin-top: 40px;
            border-radius: 8px;
        }

        .section-title {
            font-size: 20px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .view-all {
            color: #6b9d3e;
            text-decoration: none;
            font-size: 14px;
        }

        .recently-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 20px;
        }

        .footer {
            background-color: white;
            padding: 40px 20px;
            margin-top: 60px;
            border-top: 1px solid #e0e0e0;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
        }

        .footer-section h3 {
            margin-bottom: 15px;
            font-size: 16px;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section li {
            margin-bottom: 10px;
        }

        .footer-section a {
            color: #666;
            text-decoration: none;
            font-size: 14px;
        }

        .footer-section a:hover {
            color: #6b9d3e;
        }

        .footer-text {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
        }

        .payment-icons {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .payment-icons img {
            height: 30px;
        }

        .marketplace-logos {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 15px;
        }

        .marketplace-logos img {
            height: 40px;
        }

        .footer-bottom {
            text-align: center;
            padding: 20px;
            border-top: 1px solid #e0e0e0;
            margin-top: 30px;
            color: #666;
            font-size: 14px;
        }

        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background-color: #000;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        @media (max-width: 1024px) {
            .product-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .recently-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .product-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .recently-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .footer-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-container">
            <div class="logo">
                <img src="https://via.placeholder.com/40" alt="Organic Shop">
                <span style="font-weight: bold; color: #6b9d3e;">Organic</span>
            </div>
            <div class="search-container">
                <select class="search-select">
                    <option>All</option>
                    <option>Ăn dặm</option>
                    <option>Các loại hạt</option>
                    <option>Sữa thực vật</option>
                </select>
                <input type="text" class="search-input" placeholder="Gõ vào tên sản phẩm bạn muốn tìm">
                <button class="search-btn">Tìm</button>
            </div>
            <div class="header-right">
                <div class="phone">
                    <span class="phone-label">Hotline</span>
                    <span class="phone-number">0906 913 227</span>
                </div>
                <div class="cart">
                    🛒
                    <span class="cart-badge">0</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="nav">
        <div class="nav-container">
            <a href="#home">HOME</a>
            <a href="#shop">VỀ ORGANIC SHOP</a>
            <a href="#blog">BLOG'S ORGANIC</a>
            <a href="#contact">LIÊN HỆ</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-section">
                <h3 class="sidebar-title">Danh mục sản phẩm</h3>
                <ul class="sidebar-menu">
                    <li><a href="#">Khuyến mãi <span>▼</span></a></li>
                    <li><a href="#">Sản phẩm Tết</a></li>
                    <li><a href="#">Bánh kẹo hữu cơ</a></li>
                    <li><a href="#">Bột làm bánh hữu cơ</a></li>
                    <li><a href="#">Các loại dầu ăn hạt</a></li>
                    <li><a href="#" class="active">Đồ uống hữu cơ <span>▼</span></a></li>
                    <li><a href="#">Gia vị hữu cơ <span>▼</span></a></li>
                    <li><a href="#">Mỹ phẩm hữu cơ</a></li>
                    <li><a href="#">Ngũ cốc dinh dưỡng</a></li>
                    <li><a href="#">Nui mì hữu cơ</a></li>
                    <li><a href="#">Pate chay</a></li>
                    <li><a href="#">Sản phẩm mới</a></li>
                    <li><a href="#">Siêu thực phẩm - Superfood</a></li>
                    <li><a href="#">Ngũ cốc ăn sáng</a></li>
                    <li><a href="#">Thực phẩm - Mỹ phẩm Ý & hạt</a></li>
                    <li><a href="#">Thực phẩm hữu cơ</a></li>
                    <li><a href="#">Sản phẩm khác</a></li>
                </ul>
            </div>

            <div class="sidebar-section">
                <h3 class="sidebar-title">Lọc kiểu thương hiệu</h3>
                <input type="text" class="search-box" placeholder="🔍">
                <ul class="brand-list">
                    <li>
                        <label>
                            <input type="checkbox"> Dalla Costa <span class="brand-count">(13)</span>
                        </label>
                    </li>
                    <li>
                        <label>
                            <input type="checkbox"> Golden Noodle <span class="brand-count">(4)</span>
                        </label>
                    </li>
                    <li>
                        <label>
                            <input type="checkbox"> Mẹ Nấu Sato <span class="brand-count">(11)</span>
                        </label>
                    </li>
                    <li>
                        <label>
                            <input type="checkbox"> ProBios <span class="brand-count">(4)</span>
                        </label>
                    </li>
                    <li>
                        <label>
                            <input type="checkbox"> Sottolestelle <span class="brand-count">(17)</span>
                        </label>
                    </li>
                </ul>
            </div>

            <div class="sidebar-section">
                <h3 class="sidebar-title">Lọc kiểu chọn giá</h3>
                <div class="price-slider">
                    <div class="slider">
                        <div class="slider-track"></div>
                    </div>
                    <div class="price-range">
                        <span>Giá: 75,000đ</span>
                        <span>— 178,000đ</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="content-header">
                <span class="product-count">50 Sản phẩm được tìm thấy</span>
                <div class="view-options">
                    <select class="sort-select">
                        <option>Mới nhất</option>
                        <option>Giá thấp đến cao</option>
                        <option>Giá cao đến thấp</option>
                        <option>Tên A-Z</option>
                    </select>
                    <span>Xem</span>
                    <div class="view-toggle">
                        <button class="view-btn active">▦</button>
                        <button class="view-btn">☰</button>
                    </div>
                </div>
            </div>

            <div class="product-grid">
                <div class="product-card">
                    <span class="badge">Hết hàng</span>
                    <img src="https://via.placeholder.com/250x250" alt="Product" class="product-image">
                    <div class="product-info">
                        <div class="product-name">Nui ống Spirulina hữu cơ Sottolestelle 500g (Sold Out)</div>
                        <div class="product-price">155,000đ</div>
                    </div>
                </div>

                <div class="product-card">
                    <span class="badge">Hết hàng</span>
                    <img src="https://via.placeholder.com/250x250" alt="Product" class="product-image">
                    <div class="product-info">
                        <div class="product-name">Mì Spaghetti hữu cơ 500g ProBios</div>
                        <div class="product-price">95,000đ</div>
                    </div>
                </div>

                <div class="product-card">
                    <span class="badge">Hết hàng</span>
                    <img src="https://via.placeholder.com/250x250" alt="Product" class="product-image">
                    <div class="product-info">
                        <div class="product-name">Nui ống hữu cơ cho bé 300g Dalla Costa</div>
                        <div class="product-price">95,000đ</div>
                    </div>
                </div>

                <div class="product-card">
                    <span class="badge">Hết hàng</span>
                    <img src="https://via.placeholder.com/250x250" alt="Product" class="product-image">
                    <div class="product-info">
                        <div class="product-name">Nui xoắn nguyên cám hữu cơ 500g ProBios</div>
                        <div class="product-price">85,000đ</div>
                    </div>
                </div>

                <div class="product-card">
                    <span class="badge">Hết hàng</span>
                    <img src="https://via.placeholder.com/250x250" alt="Product" class="product-image">
                    <div class="product-info">
                        <div class="product-name">Nui ống nguyên cám hữu cơ 500g ProBios</div>
                        <div class="product-price">85,000đ</div>
                    </div>
                </div>

                <div class="product-card">
                    <span class="badge">Hết hàng</span>
                    <img src="https://via.placeholder.com/250x250" alt="Product" class="product-image">
                    <div class="product-info">
                        <div class="product-name">Nui hữu cơ hạch chữ 400g ProBios</div>
                        <div class="product-price">125,000đ</div>
                    </div>
                </div>

                <div class="product-card">
                    <span class="badge">Hết hàng</span>
                    <img src="https://via.placeholder.com/250x250" alt="Product" class="product-image">
                    <div class="product-info">
                        <div class="product-name">Nui sao hữu cơ Sottolestelle 500g</div>
                        <div class="product-price">105,000đ</div>
                    </div>
                </div>

                <div class="product-card">
                    <span class="badge">Hết hàng</span>
                    <img src="https://via.placeholder.com/250x250" alt="Product" class="product-image">
                    <div class="product-info">
                        <div class="product-name">Nui ống hoa mạch đen nguyên cám hữu cơ Sottolestelle 500g</div>
                        <div class="product-price">100,000đ</div>
                    </div>
                </div>

                <div class="product-card">
                    <span class="badge">Hết hàng</span>
                    <img src="https://via.placeholder.com/250x250" alt="Product" class="product-image">
                    <div class="product-info">
                        <div class="product-name">Mì Spaghetti lúa mạch đen nguyên cám hữu cơ Sottolestelle 500g</div>
                        <div class="product-price">100,000đ</div>
                    </div>
                </div>

                <div class="product-card">
                    <span class="badge">Hết hàng</span>
                    <img src="https://via.placeholder.com/250x250" alt="Product" class="product-image">
                    <div class="product-info">
                        <div class="product-name">Nui ống Spirulina hữu cơ Sottolestelle 500g</div>
                        <div class="product-price">155,000đ</div>
                    </div>
                </div>

                <div class="product-card">
                    <span class="badge">Hết hàng</span>
                    <img src="https://via.placeholder.com/250x250" alt="Product" class="product-image">
                    <div class="product-info">
                        <div class="product-name">Nui ống gạo đỏ nguyên cám hữu cơ Sottolestelle 500g</div>
                        <div class="product-price">155,000đ</div>
                    </div>
                </div>

                <div class="product-card">
                    <span class="badge">Hết hàng</span>
                    <img src="https://via.placeholder.com/250x250" alt="Product" class="product-image">
                    <div class="product-info">
                        <div class="product-name">Nui ống gạo nguyên cám hữu cơ Sottolestelle 500g</div>
                        <div class="product-price">145,000đ</div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">3</button>
                <button class="page-btn">4</button>
                <button class="page-btn">5</button>
                <button class="page-btn">Trang sau ›</button>
            </div>
        </div>
    </div>

    <!-- Recently Viewed -->
    <div class="main-container">
        <div class="recently-viewed" style="width: 100%;">
            <div class="section-title">
                <span>Các sản phẩm bạn đã xem</span>
                <a href="#" class="view-all">Xem</a>
            </div>
            <div class="recently-grid">
                <div class="product-card">
                    <img src="https://via.placeholder.com/150" alt="Product" class="product-image">
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3>Organic Shop</h3>
                <p class="footer-text">Bán lẻ online các mặt hàng thực phẩm Organic, non-GMO của Đức, Mỹ, Úc. Sản phẩm được các tổ chứng nhận USDA, EU Organic, Nasaa, JAS.</p>
                <p class="footer-text"><strong>Địa chỉ:</strong> 167B Đống Đắc, Khu phố 7, Phường Tân Chánh Hiệp, Quận 12, Tp Hồ Chí Minh, Việt Nam</p>
                <p class="footer-text"><strong>Hotline:</strong> 0906 913 227</p>
                <p class="footer-text"><strong>Email:</strong> online@organicshop.com.vn</p>
                <p class="footer-text"><strong>Website:</strong> Organicshop.com.vn</p>
            </div>

            <div class="footer-section">
                <h3>Chính sách bán hàng</h3>
                <ul>
                    <li><a href="#">Hướng dẫn mua hàng</a></li>
                    <li><a href="#">Chính sách giao hàng</a></li>
                    <li><a href="#">Cam kết chất lượng</a></li>
                    <li><a href="#">Chính sách đổi trả</a></li>
                    <li><a href="#">Bảo mật thông tin</a></li>
                    <li><a href="#">Liên hệ mua sỉ</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Kết nối nhanh</h3>
                <ul>
                    <li><a href="#">Trang chủ</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Ngũ cốc</a></li>
                    <li><a href="#">Mỹ phẩm hữu cơ</a></li>
                    <li><a href="#">Gia vị hữu cơ</a></li>
                    <li><a href="#">Siêu thực phẩm</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Thanh toán thuận tiện</h3>
                <div class="payment-icons">
                    <img src="https://via.placeholder.com/50x30" alt="Cash">
                    <img src="https://via.placeholder.com/50x30" alt="ATM">
                    <img src="https://via.placeholder.com/50x30" alt="Visa">
                    <img src="https://via.placeholder.com/50x30" alt="Mastercard">
                </div>
                <p style="margin-top: 20px; font-weight: bold;">Ngoài ra, bạn cũng có thể đặt hàng qua:</p>
                <div class="marketplace-logos">
                    <img src="https://via.placeholder.com/100x40" alt=""/>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>     
