  <!-- Footer -->
  <div class="footer">
      <div class="footer-container">
          <div class="footer-section">
              <h3>Organic Shop</h3>
              <p style="color: #ccc; font-size: 14px; line-height: 1.6;">
                  Cửa hàng thực phẩm hữu cơ 100% nhập khẩu từ Mỹ, Ý... Chất lượng cao cho mọi gia đình.
              </p>
          </div>
          <div class="footer-section">
              <h3>Chính sách bán hàng</h3>
              <ul>
                  <li><a href="#">Chính sách bán hàng</a></li>
                  <li><a href="#">Blog</a></li>
                  <li><a href="#">Chính sách bảo mật</a></li>
                  <li><a href="#">Liên hệ</a></li>
              </ul>
          </div>
          <div class="footer-section">
              <h3>Bài viết chính</h3>
              <ul>
                  <li><a href="#">Tin tức</a></li>
                  <li><a href="#">Blog hữu cơ</a></li>
                  <li><a href="#">Sản phẩm giảm giá</a></li>
                  <li><a href="#">Liên hệ</a></li>
              </ul>
          </div>
          <div class="footer-section">
              <h3>Thông tin liên lạc</h3>
              <ul>
                  <li><a href="#">Hotline: 0934 919 897</a></li>
                  <li><a href="#">Email: info@organicshop.vn</a></li>
              </ul>
          </div>
      </div>
      <div class="footer-bottom">
          <p>© <?php echo date('Y'); ?> Organic Shop</p>
      </div>
  </div>

  <?php wp_footer(); ?>
  <script>
      document.addEventListener("DOMContentLoaded", function() {
          new Swiper(".product-swiper-sale", {
              slidesPerView: 4,
              spaceBetween: 20,
              loop: true,
              autoplay: {
                  delay: 2500
              },
              navigation: {
                  nextEl: ".swiper-button-next-sale",
                  prevEl: ".swiper-button-prev-sale",
              },
              breakpoints: {
                  320: {
                      slidesPerView: 1
                  },
                  576: {
                      slidesPerView: 2
                  },
                  768: {
                      slidesPerView: 3
                  },
                  1200: {
                      slidesPerView: 4
                  }
              }
          });

          new Swiper(".product-swiper-featured", {
              slidesPerView: 4,
              spaceBetween: 20,
              loop: true,
              autoplay: {
                  delay: 2700
              },
              navigation: {
                  nextEl: ".swiper-button-next-featured",
                  prevEl: ".swiper-button-prev-featured",
              },
              breakpoints: {
                  320: {
                      slidesPerView: 1
                  },
                  576: {
                      slidesPerView: 2
                  },
                  768: {
                      slidesPerView: 3
                  },
                  1200: {
                      slidesPerView: 4
                  }
              }
          });
      });
  </script>
  <script>
      document.addEventListener("DOMContentLoaded", function() {

          const sections = [
              "san-pham-huu-co",
              "ngu-coc-dinh-duong-huu-co",
              "dau-va-hat-huu-co",
              "nui-mi-huu-co",
              "thuc-pham-huu-co"
          ];

          sections.forEach(slug => {
              new Swiper(`.product-swiper-${slug}`, {
                  slidesPerView: 4,
                  spaceBetween: 24,
                  loop: true,
                  navigation: {
                      nextEl: `.swiper-button-next-${slug}`,
                      prevEl: `.swiper-button-prev-${slug}`,
                  },
                  autoplay: {
                      delay: 3000,
                  },
                  breakpoints: {
                      320: {
                          slidesPerView: 2
                      },
                      768: {
                          slidesPerView: 3
                      },
                      1200: {
                          slidesPerView: 4
                      }
                  }
              });
          });

      });
  </script>


  </body>

  </html>