jQuery(document).ready(function ($) {

    $('.doAnCMS-wishlist-btn').on('click', function () {
        const productId = $(this).data('product-id');

        $.ajax({
            url: wp_ajax.ajax_url,
            method: 'POST',
            data: {
                action: 'doAddToWishlist',
                product_id: productId
            },
            success: function (res) {
                alert(res.data.message);
            }
        });
    });

});
