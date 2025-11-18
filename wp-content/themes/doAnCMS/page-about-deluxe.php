<?php
/*
Template Name: About Us - Deluxe
*/
get_header();
?>

<!-- Nếu bạn không enqueue trong functions.php, giữ dòng <link> này -->
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/about-deluxe.css">

<div class="about-deluxe">

    <!-- HERO (parallax) -->
    <header class="ad-hero" data-parallax>
        <div class="ad-hero-inner">
            <h1 class="reveal">Organic Shop</h1>
            <p class="reveal delay-1">Thực phẩm hữu cơ - Sống sạch, sống khỏe.</p>
            <a href="<?php echo home_url('/shop'); ?>" class="btn btn-cta reveal delay-2">Khám phá sản phẩm</a>
        </div>
    </header>

    <!-- MISSION + QUICK STATS -->
    <section class="ad-section ad-mission container">
        <div class="ad-mission-left reveal">
            <h2>Sứ mệnh & Tầm nhìn</h2>
            <p>Chúng tôi cam kết mang đến thực phẩm hữu cơ chuẩn, an toàn và minh bạch. Mục tiêu: nâng tầm sức khỏe cộng đồng bằng sản phẩm sạch, quy trình minh bạch và dịch vụ tận tâm.</p>

            <ul class="ad-stats">
                <li><strong>+500</strong><span>sản phẩm hữu cơ</span></li>
                <li><strong>>98%</strong><span>khách hàng hài lòng</span></li>
                <li><strong>100%</strong><span>nguồn gốc truy xuất được</span></li>
            </ul>
        </div>
        <div class="ad-mission-right reveal delay-1">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/ofs/of3.jpg" alt="Sứ mệnh Organic Shop">
        </div>
    </section>

    <!-- VALUES -->
    <section class="ad-section ad-values">
        <div class="container">
            <h2 class="reveal">Giá trị cốt lõi</h2>
            <div class="values-grid">
                <article class="value-card reveal delay-1">
                    <div class="icon">🌱</div>
                    <h3>Thuần hữu cơ</h3>
                    <p>Sản phẩm đạt chuẩn hữu cơ, không chất bảo quản.</p>
                </article>
                <article class="value-card reveal delay-2">
                    <div class="icon">🔍</div>
                    <h3>Minh bạch</h3>
                    <p>Truy xuất nguồn gốc rõ ràng từ nông trại đến tay bạn.</p>
                </article>
                <article class="value-card reveal delay-3">
                    <div class="icon">🤝</div>
                    <h3>Cộng đồng</h3>
                    <p>Hợp tác với nông dân địa phương, phát triển bền vững.</p>
                </article>
                <article class="value-card reveal delay-4">
                    <div class="icon">💚</div>
                    <h3>Sức khỏe</h3>
                    <p>Đặt sức khỏe người dùng lên hàng đầu.</p>
                </article>
            </div>
        </div>
    </section>

    <!-- TIMELINE -->
    <section class="ad-section ad-timeline">
        <div class="container">
            <h2 class="reveal">Hành trình của chúng tôi</h2>
            <div class="timeline">
                <div class="timeline-item reveal delay-1">
                    <time>2015</time>
                    <div class="ti-content">
                        <h4>Bắt đầu</h4>
                        <p>Khởi nguồn từ một cửa hàng nhỏ với mong muốn cung cấp thực phẩm sạch cho gia đình.</p>
                    </div>
                </div>

                <div class="timeline-item reveal delay-2">
                    <time>2018</time>
                    <div class="ti-content">
                        <h4>Mở rộng</h4>
                        <p>Mở rộng danh mục sản phẩm, hợp tác với nhiều nông trại hữu cơ.</p>
                    </div>
                </div>

                <div class="timeline-item reveal delay-3">
                    <time>2021</time>
                    <div class="ti-content">
                        <h4>Chuẩn hoá</h4>
                        <p>Hoàn thiện quy trình kiểm soát chất lượng và truy xuất nguồn gốc.</p>
                    </div>
                </div>

                <div class="timeline-item reveal delay-4">
                    <time>2024</time>
                    <div class="ti-content">
                        <h4>Đạt chứng nhận</h4>
                        <p>Nhận chứng nhận hữu cơ & mở rộng kênh bán hàng online toàn quốc.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FARM & ORIGIN -->
    <section class="ad-section ad-farm">
        <div class="container ad-farm-inner">
            <div class="farm-media reveal">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/ofs/of4.jpg" alt="Nông trại hữu cơ">
            </div>
            <div class="farm-text reveal delay-1">
                <h2>Nguồn gốc & Nông trại</h2>
                <p>Mỗi sản phẩm đều có thể truy xuất về nông trại, phương pháp canh tác hữu cơ và ngày thu hoạch. Chúng tôi hợp tác trực tiếp với các nhà sản xuất tuân thủ tiêu chuẩn GAP/Organic.</p>

                <ul class="farm-list">
                    <li>Kiểm tra đất & nước định kỳ</li>
                    <li>Không sử dụng phân bón hoá học</li>
                    <li>Đóng gói thân thiện môi trường</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- CERTIFICATES -->
    <section class="ad-section ad-cert">
        <div class="container">
            <h2 class="reveal">Chứng nhận & Đảm bảo</h2>
            <div class="cert-grid">
                <div class="cert-card reveal delay-1">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/ofs/of5.jpg" alt="certificate 1">
                    <p>Chứng nhận hữu cơ quốc tế</p>
                </div>
                <div class="cert-card reveal delay-2">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/ofs/of6.jpg" alt="certificate 2">
                    <p>Kiểm nghiệm an toàn thực phẩm</p>
                </div>
                <div class="cert-card reveal delay-3">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/ofs/ofs1.jpg" alt="certificate 3">
                    <p>Đối tác nông trại bền vững</p>
                </div>
            </div>
        </div>
    </section>

    <!-- TEAM -->
    <section class="ad-section ad-team">
        <div class="container">
            <h2 class="reveal">Đội ngũ của chúng tôi</h2>
            <div class="team-grid">
                <div class="team-card reveal delay-1">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/avatar/batman.png" alt="Team 1">
                    <h4>Thanh Hoài</h4>
                    <p>Founder & CEO</p>
                </div>
                <div class="team-card reveal delay-2">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/avatar/joker.png" alt="Team 2">
                    <h4>Công Hậu</h4>
                    <p>Head of Sourcing</p>
                </div>
                <div class="team-card reveal delay-3">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/avatar/the-flash.png" alt="Team 3">
                    <h4>Thanh Đô</h4>
                    <p>Quality Manager</p>
                </div>
            </div>
        </div>
    </section>

    <!-- TESTIMONIALS -->
    <section class="ad-section ad-testimonials">
        <div class="container">
            <h2 class="reveal">Khách hàng nói gì</h2>
            <div class="testi-grid">
                <blockquote class="testi reveal delay-1">
                    “Sản phẩm tuyệt vời, giao hàng nhanh và đóng gói rất chắc chắn. Mình an tâm cho gia đình dùng hàng ngày.”
                    <cite>— Lan, Hà Nội</cite>
                </blockquote>
                <blockquote class="testi reveal delay-2">
                    “Thịt chay và ngũ cốc ở đây rất ngon. Mùi vị tự nhiên, hoàn toàn khác biệt.”
                    <cite>— Minh, Đà Nẵng</cite>
                </blockquote>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="ad-section ad-cta">
        <div class="container cta-box reveal">
            <h2>Bạn đã sẵn sàng trải nghiệm cuộc sống hữu cơ?</h2>
            <p>Khám phá bộ sưu tập sản phẩm sạch và nhận ưu đãi dành cho khách hàng mới.</p>
            <div class="cta-actions">
                <a href="<?php echo home_url('/shop'); ?>" class="btn btn-primary">Mua ngay</a>
                <a href="<?php echo home_url('/contact'); ?>" class="btn btn-outline">Liên hệ</a>
            </div>
        </div>
    </section>

</div>

<!-- Nếu bạn không enqueue, include file JS -->
<script src="<?php echo get_stylesheet_directory_uri(); ?>/about-deluxe.js"></script>

<?php get_footer(); ?>
<style>
    .ad-hero {
        background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/images/ofs/of2.jpg');
        background-size: cover;
        background-position: center;
        height: 620px;
    }
</style>