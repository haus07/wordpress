<?php
if ( ! defined( 'ABSPATH' ) ) exit;

get_header( 'shop' ); 
?>

<div class="breadcrumb">
    <?php woocommerce_breadcrumb(); ?>
</div>

<?php while ( have_posts() ) : the_post(); global $product; ?>

<div class="container">
    <div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'product-section', $product ); ?>>

        <div class="product-gallery">
            <?php woocommerce_show_product_images(); ?>
        </div>

        <div class="product-info">
            <?php 
            woocommerce_template_single_title(); 
            woocommerce_template_single_price(); 
            woocommerce_template_single_add_to_cart(); 
            ?>
            <div class="product-meta">
                <?php woocommerce_template_single_meta(); ?>
            </div>
        </div>

    </div>

    <div class="tabs">
        <?php woocommerce_output_product_data_tabs(); ?>
    </div>

    <?php woocommerce_output_related_products(); ?>

</div>

<?php endwhile; ?>

<?php get_footer( 'shop' ); ?>
