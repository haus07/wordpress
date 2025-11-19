<?php
/**
 * Template Name: Giỏ Hàng Custom (Green Theme)
 * Description: Giao diện giỏ hàng tùy chỉnh màu Xanh Lá + Trắng
 */

defined( 'ABSPATH' ) || exit;

get_header(); // Gọi Header của theme
?>

<div id="custom-green-cart" class="custom-cart-wrapper">
    <div class="container">
        
        <h1 class="cart-title">Giỏ hàng của bạn</h1>

        <?php
        // Hiển thị thông báo lỗi/thành công của Woo
        do_action( 'woocommerce_before_cart' ); 
        ?>

        <?php if ( WC()->cart->is_empty() ) : ?>
            
            <div class="cart-empty-message">
                <p class="cart-empty">Chưa có sản phẩm nào trong giỏ hàng.</p>
                <p class="return-to-shop">
                    <a class="button wc-backward" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
                        Quay trở lại cửa hàng
                    </a>
                </p>
            </div>

        <?php else : ?>

            <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
                
                <?php do_action( 'woocommerce_before_cart_table' ); ?>

                <div class="table-responsive">
                    <table class="shop_table cart-table" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="product-remove">&nbsp;</th>
                                <th class="product-thumbnail">Hình ảnh</th>
                                <th class="product-name">Sản phẩm</th>
                                <th class="product-price">Giá</th>
                                <th class="product-quantity">Số lượng</th>
                                <th class="product-subtotal">Tạm tính</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php do_action( 'woocommerce_before_cart_contents' ); ?>

                            <?php
                            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                                $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                                $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                                if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                                    $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                                    ?>
                                    <tr class="cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

                                        <td class="product-remove">
                                            <?php
                                                echo apply_filters( 
                                                    'woocommerce_cart_item_remove_link',
                                                    sprintf(
                                                        '<a href="%s" class="remove-btn" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                                                        esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                                        esc_html__( 'Xóa', 'woocommerce' ),
                                                        esc_attr( $product_id ),
                                                        esc_attr( $_product->get_sku() )
                                                    ),
                                                    $cart_item_key
                                                );
                                            ?>
                                        </td>

                                        <td class="product-thumbnail">
                                            <?php
                                            $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
                                            if ( ! $product_permalink ) {
                                                echo $thumbnail;
                                            } else {
                                                printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
                                            }
                                            ?>
                                        </td>

                                        <td class="product-name" data-title="Sản phẩm">
                                            <?php
                                            if ( ! $product_permalink ) {
                                                echo wp_kses_post( $_product->get_name() . '&nbsp;' );
                                            } else {
                                                echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s" class="p-name">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                                            }
                                            
                                            // Meta data (biến thể, v.v.)
                                            echo wc_get_formatted_cart_item_data( $cart_item );

                                            // Backorder info
                                            if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                                                echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
                                            }
                                            ?>
                                        </td>

                                        <td class="product-price" data-title="Giá">
                                            <?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); ?>
                                        </td>

                                        <td class="product-quantity" data-title="Số lượng">
                                            <?php
                                            if ( $_product->is_sold_individually() ) {
                                                $min_quantity = 1;
                                                $max_quantity = 1;
                                            } else {
                                                $min_quantity = 0;
                                                $max_quantity = $_product->get_max_purchase_quantity();
                                            }

                                            $product_quantity = woocommerce_quantity_input(
                                                array(
                                                    'input_name'   => "cart[{$cart_item_key}][qty]",
                                                    'input_value'  => $cart_item['quantity'],
                                                    'max_value'    => $max_quantity,
                                                    'min_value'    => $min_quantity,
                                                    'product_name' => $_product->get_name(),
                                                ),
                                                $_product,
                                                false
                                            );

                                            echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
                                            ?>
                                        </td>

                                        <td class="product-subtotal" data-title="Tạm tính">
                                            <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                            <?php do_action( 'woocommerce_cart_contents' ); ?>
                            
                            <tr class="cart-actions">
                                <td colspan="6" class="actions">
                                    <?php if ( wc_coupons_enabled() ) { ?>
                                        <div class="coupon-section">
                                            <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="Mã giảm giá" /> 
                                            <button type="submit" class="button coupon-btn" name="apply_coupon" value="Áp dụng">Áp dụng</button>
                                            <?php do_action( 'woocommerce_cart_coupon' ); ?>
                                        </div>
                                    <?php } ?>

                                    <button type="submit" class="button update-btn" name="update_cart" value="Cập nhật giỏ hàng">Cập nhật giỏ hàng</button>
                                    <?php do_action( 'woocommerce_cart_actions' ); ?>
                                    <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                                </td>
                            </tr>

                            <?php do_action( 'woocommerce_after_cart_contents' ); ?>
                        </tbody>
                    </table>
                </div>
                <?php do_action( 'woocommerce_after_cart_table' ); ?>
            </form>

            <div class="cart-collaterals-wrapper">
                <?php do_action( 'woocommerce_cart_collaterals' ); ?>
            </div>

        <?php endif; ?>

        <?php do_action( 'woocommerce_after_cart' ); ?>
        
    </div>
</div>

<?php get_footer(); // Gọi Footer của theme ?>