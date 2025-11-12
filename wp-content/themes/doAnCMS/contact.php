<?php
get_header();
?>

<style>
    /* ====== Contact Page Container ====== */
    .contact-page {
        max-width: 1200px;
        margin: 50px auto;
        padding: 20px;
        display: flex;
        gap: 40px;
        flex-wrap: wrap;
    }

    /* ====== Contact Form & Info Boxes ====== */
    .contact-form,
    .contact-info {
        flex: 1 1 400px;
        background-color: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .contact-form h2,
    .contact-info h2 {
        font-size: 24px;
        color: #6b9d3e;
        margin-bottom: 20px;
    }

    /* ====== Form Inputs ====== */
    .contact-form form input,
    .contact-form form textarea,
    .contact-form form button,
    .contact-info form input,
    .contact-info form button {
        width: 100%;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .contact-form form input,
    .contact-form form textarea,
    .contact-info form input {
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .contact-form form textarea {
        min-height: 120px;
    }

    .contact-form form button,
    .contact-info form button {
        background: linear-gradient(135deg, #6b9d3e, #a0c05a);
        color: #fff;
        padding: 12px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .contact-form form button:hover,
    .contact-info form button:hover {
        background: linear-gradient(135deg, #557c2a, #8bb135);
        transform: translateY(-2px);
    }

    /* ====== Newsletter Form Flex ====== */
    .contact-info form {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .contact-info form input[type="email"] {
        flex: 1 1 200px;
    }

    /* ====== Contact Info Text ====== */
    .contact-info div {
        margin-bottom: 15px;
        font-size: 16px;
    }

    .contact-info div span {
        font-weight: 600;
        color: #6b9d3e;
    }

    /* ====== Chat Box ====== */
    #chat-box {
        display: none;
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 300px;
        height: 400px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        padding: 10px;
        flex-direction: column;
        z-index: 9999;
    }

    #chat-box header {
        font-weight: bold;
        color: #6b9d3e;
        margin-bottom: 10px;
    }

    #chat-messages {
        flex: 1;
        overflow-y: auto;
        margin-bottom: 10px;
        font-size: 14px;
    }

    #chat-input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 6px;
    }

    /* ====== Responsive ====== */
    @media(max-width: 768px) {
        .contact-page {
            flex-direction: column;
        }

        .contact-info form {
            flex-direction: column;
        }

        .contact-info form input[type="email"] {
            flex: 1 1 100%;
        }
    }
</style>

<div class="contact-page">

    <!-- Contact Form -->
    <div class="contact-form">
        <h2>Liên hệ với chúng tôi</h2>

        <?php if (isset($_GET['status']) && $_GET['status'] === 'success') : ?>
            <p style="color:green;">✅ Cảm ơn bạn! Chúng tôi đã nhận được liên hệ.</p>
        <?php elseif (isset($_GET['status']) && $_GET['status'] === 'error') : ?>
            <p style="color:red;">❌ Vui lòng điền đầy đủ thông tin.</p>
        <?php endif; ?>

        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <?php wp_nonce_field('contact_form_action', 'contact_form_nonce'); ?>
            <input type="text" name="contact_name" placeholder="Họ và tên" required>
            <input type="email" name="contact_email" placeholder="Email" required>
            <textarea name="contact_message" placeholder="Tin nhắn" required></textarea>
            <button type="submit">Gửi liên hệ</button>
            <input type="hidden" name="action" value="submit_contact_form">
        </form>
    </div>

    <!-- Contact Info + Newsletter + Chat -->
    <div class="contact-info">
        <h2>Thông tin liên hệ</h2>
        <div><span>📞 Phone:</span> 0934 919 897</div>
        <div><span>📧 Email:</span> thanhdo062305@gmail.com</div>
        <div><span>🏠 Địa chỉ:</span> 53 Võ Văn Ngân, Linh Chiểu, Thủ Đức, TP.HCM</div>

        <!-- Newsletter Form -->
        <h2>Đăng ký nhận tin sản phẩm mới</h2>

        <?php if (isset($_GET['newsletter']) && $_GET['newsletter'] === 'success') : ?>
            <p style="color:green;">✅ Cảm ơn bạn đã đăng ký!</p>
        <?php elseif (isset($_GET['newsletter']) && $_GET['newsletter'] === 'invalid') : ?>
            <p style="color:red;">❌ Email không hợp lệ!</p>
        <?php endif; ?>

        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <?php wp_nonce_field('newsletter_form_action', 'newsletter_form_nonce'); ?>
            <input type="email" name="newsletter_email" placeholder="Email của bạn" required>
            <button type="submit">Đăng ký</button>
            <input type="hidden" name="action" value="submit_newsletter_email">
        </form>

        <!-- Chat Support -->
        <h2>Chat hỗ trợ</h2>
        <button id="open-chat"
            style="padding:10px 15px;background:#6b9d3e;color:#fff;border:none;border-radius:6px;cursor:pointer;">
            Mở chat
        </button>

        <div id="chat-box">
            <header>Chat Support</header>
            <div id="chat-messages">Chào bạn! Hãy gửi tin nhắn.</div>
            <input type="text" id="chat-input" placeholder="Gõ tin nhắn...">
        </div>
    </div>
</div>

<script>
    const chatBtn = document.getElementById('open-chat');
    const chatBox = document.getElementById('chat-box');
    const chatInput = document.getElementById('chat-input');
    const chatMessages = document.getElementById('chat-messages');

    chatBtn.addEventListener('click', () => {
        chatBox.style.display = chatBox.style.display === 'flex' ? 'none' : 'flex';
        chatBox.style.flexDirection = 'column';
    });

    chatInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            const msg = chatInput.value.trim();
            if (msg) {
                const p = document.createElement('p');
                p.textContent = 'Bạn: ' + msg;
                chatMessages.appendChild(p);
                chatInput.value = '';
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        }
    });
</script>

<?php get_footer(); ?>