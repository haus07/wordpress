<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php bloginfo('name'); ?> - <?php bloginfo('description'); ?></title>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <!-- Header -->
  <div class="header">
    <div class="header-container">
      <div class="logo">
        <img src="https://via.placeholder.com/40" alt="Organic Shop">
        <span style="font-weight: bold; color: #6b9d3e;">Organic Shop</span>
      </div>
      <div class="search-bar">
        <input type="text" placeholder="Tìm sản phẩm bạn mong muốn...">
      </div>
      <div class="header-right">
        <div class="phone">
          <span>📞 0934 919 897</span>
        </div>
        <div>🛒</div>
      </div>
    </div>
  </div>

  <!-- Navigation -->
  <div class="nav">
    <div class="nav-container">
      <a href="#home">HOME</a>
      <a href="#organic">VỀ ORGANIC SHOP</a>
      <a href="#blog">BLOGS ORGANIC</a>
      <a href="#contact">LIÊN HỆ</a>
    </div>
  </div>
