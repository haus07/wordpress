<?php

/**
 * Template Name: Deluxe Cart Page (AJAX & Hover)
 */
defined('ABSPATH') || exit;
get_header();
?>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/shop-deluxe.css">

<div class="cart-container">

    <!-- Cart Products -->
    <div class="cart-products">
        <?php if (WC()->cart->get_cart_contents_count() > 0): ?>
            <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item):
                $_product   = $cart_item['data'];
                if (!$_product->exists()) continue;
                $product_permalink = $_product->is_visible() ? $_product->get_permalink($cart_item) : '';
            ?>
                <div class="cart-item" data-cart-item-key="<?php echo esc_attr($cart_item_key); ?>">
                    <div class="cart-thumb">
                        <?php echo $_product->get_image('medium'); ?>
                    </div>
                    <div class="cart-info">
                        <h3 class="cart-title">
                            <?php if ($product_permalink): ?>
                                <a href="<?php echo esc_url($product_permalink); ?>"><?php echo $_product->get_name(); ?></a>
                            <?php else: ?>
                                <?php echo $_product->get_name(); ?>
                            <?php endif; ?>
                        </h3>
                        <span class="cart-price"><?php echo WC()->cart->get_product_price($_product); ?></span>
                        <div class="cart-qty">
                            <input type="number" class="cart-qty-input"
                                data-cart_item_key="<?php echo esc_attr($cart_item_key); ?>"
                                value="<?php echo esc_attr($cart_item['quantity']); ?>"
                                min="0">
                        </div>
                        <span class="cart-subtotal"><?php echo WC()->cart->get_product_subtotal($_product, $cart_item['quantity']); ?></span>
                        <a href="#" class="cart-remove">&times;</a>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Cart Actions -->
            <div class="cart-actions">
                <?php if (wc_coupons_enabled()) : ?>
                    <div class="cart-coupon">
                        <input type="text" name="coupon_code" placeholder="Mã giảm giá" id="coupon_code">
                        <button type="button" class="button apply-coupon" id="apply-coupon">Áp dụng</button>
                    </div>
                <?php endif; ?>
                <button type="button" class="button update-cart" id="update-cart">Cập nhật giỏ</button>
            </div>

        <?php else: ?>
            <p>Giỏ hàng trống.</p>
        <?php endif; ?>
    </div>

    <!-- Cart Summary -->
    <div class="cart-summary">
        <h3>Tổng đơn hàng</h3>
        <div class="cart-summary-details">
            <div class="subtotal-line">
                <span>Giá gốc:</span>
                <span class="subtotal" id="cart-subtotal"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
            </div>

            <div class="coupon-line" id="cart-coupon-line" style="display:none;">
                <span>Mã giảm giá (<span id="coupon-code"></span>):</span>
                <span class="discount" id="coupon-amount">-0₫</span>
            </div>

            <div class="total-line">
                <span>Thanh toán:</span>
                <span class="total" id="cart-total"><?php echo WC()->cart->get_cart_total(); ?></span>
            </div>
        </div>

        <a href="<?php echo wc_get_checkout_url(); ?>" class="checkout-btn">Thanh toán</a>
    </div>

</div>

<script>
    jQuery(document).ready(function($) {

        function updateCartItem(cart_item_key, qty, callback) {
            $.ajax({
                type: 'POST',
                url: '<?php echo admin_url("admin-ajax.php"); ?>',
                data: {
                    action: 'update_cart_item',
                    cart_item_key: cart_item_key,
                    qty: qty
                },
                success: function(response) {
                    if (response.success) {
                        if (response.data.removed) {
                            $('[data-cart-item-key="' + cart_item_key + '"]').fadeOut(300, function() {
                                $(this).remove();
                            });
                        } else {
                            $('[data-cart-item-key="' + cart_item_key + '"] .cart-subtotal').html(response.data.subtotal);
                        }
                        $('#cart-subtotal').html(response.data.subtotal_html);
                        $('#cart-total').html(response.data.total_html);
                        if (response.data.discount_html) {
                            $('#cart-coupon-line').show();
                            $('#coupon-amount').html(response.data.discount_html);
                            $('#coupon-code').text(response.data.coupon_code);
                        }
                        if (callback) callback();
                        $(document.body).trigger('wc_fragment_refresh');
                    } else {
                        alert(response.data?.message || 'Có lỗi xảy ra');
                    }
                },
                error: function() {
                    alert('Lỗi khi cập nhật giỏ hàng.');
                }
            });
        }

        // Cập nhật từng sản phẩm
        $('.cart-qty-input').on('change', function() {
            let key = $(this).data('cart_item_key');
            let qty = $(this).val();
            updateCartItem(key, qty);
        });

        // Cập nhật tất cả sản phẩm
        $('#update-cart').on('click', function() {
            $('.cart-qty-input').each(function() {
                let key = $(this).data('cart_item_key');
                let qty = $(this).val();
                updateCartItem(key, qty);
            });
        });

        // Xóa sản phẩm
        $('.cart-remove').on('click', function(e) {
            e.preventDefault();
            let key = $(this).closest('.cart-item').data('cart-item-key');
            updateCartItem(key, 0);
        });

        // Áp dụng coupon
        $('#apply-coupon').on('click', function() {
            let code = $('#coupon_code').val();
            if (!code) return;

            $.ajax({
                type: 'POST',
                url: '<?php echo admin_url("admin-ajax.php"); ?>',
                data: {
                    action: 'apply_coupon_ajax',
                    coupon_code: code
                },
                success: function(response) {
                    if (response.success) {
                        $('#cart-coupon-line').show();
                        $('#coupon-code').text(code);
                        $('#cart-total').html(response.data.total_html);
                        $('#cart-subtotal').html(response.data.subtotal_html);
                        $('#coupon-amount').html(response.data.discount_html);
                        alert(response.data.message);
                        $(document.body).trigger('wc_fragment_refresh');
                    } else {
                        alert(response.data?.message || 'Mã giảm giá không hợp lệ');
                    }
                }
            });
        });

    });
</script>

<style>
    .cart-container {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        margin: 40px auto;
    }

    .cart-products {
        flex: 2;
        min-width: 300px;
    }

    .cart-summary {
        flex: 1;
        min-width: 250px;
        background: #f5f5f5;
        padding: 20px;
        border-radius: 12px;
    }

    .cart-summary h3 {
        margin-bottom: 15px;
    }

    .cart-summary-details div {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .subtotal {
        font-weight: 600;
        color: #333;
    }

    .discount {
        font-weight: 600;
        color: #f44336;
    }

    .total {
        font-weight: 700;
        font-size: 20px;
        color: #4CAF50;
    }

    .checkout-btn {
        display: block;
        text-align: center;
        padding: 12px;
        background: #8BC34A;
        color: #fff;
        border-radius: 8px;
        margin-top: 15px;
        text-decoration: none;
        transition: .3s;
    }

    .checkout-btn:hover {
        background: #7cb342;
    }

    .cart-item {
        display: flex;
        gap: 20px;
        background: #fff;
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 15px;
        align-items: center;
        position: relative;
        transition: .3s;
    }

    .cart-thumb img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        transition: transform .3s;
    }

    .cart-thumb img:hover {
        transform: scale(1.1);
    }

    .cart-info {
        flex: 1;
        position: relative;
    }

    .cart-title {
        font-size: 16px;
        margin: 0 0 8px;
    }

    .cart-title a {
        color: #333;
        text-decoration: none;
    }

    .cart-title a:hover {
        text-decoration: underline;
    }

    .cart-price {
        font-weight: 600;
        color: #4CAF50;
        margin-bottom: 8px;
        display: block;
    }

    .cart-qty input {
        width: 60px;
        text-align: center;
        padding: 5px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .cart-subtotal {
        font-weight: 600;
        color: #333;
        display: block;
        margin-top: 5px;
    }

    .cart-remove {
        position: absolute;
        top: 0;
        right: 0;
        color: #f44336;
        font-weight: bold;
        font-size: 20px;
        cursor: pointer;
        text-decoration: none;
    }

    .cart-actions {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-top: 20px;
        flex-wrap: wrap;
    }

    .update-cart,
    .apply-coupon {
        background: #8BC34A;
        color: #fff;
        padding: 10px 18px;
        border-radius: 7px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all .2s;
    }

    .update-cart:hover,
    .apply-coupon:hover {
        background: #7cb342;
    }

    @media(max-width:768px) {
        .cart-container {
            flex-direction: column;
        }

        .cart-summary {
            order: -1;
            margin-bottom: 20px;
        }
    }
</style>