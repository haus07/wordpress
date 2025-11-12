<?php get_header(); ?>

<div class="doAnCMS-page-container">

    <?php if (function_exists('woocommerce_content') && is_woocommerce()) : ?>
        <div class="doAnCMS-woocommerce-wrapper">
            <?php woocommerce_content(); ?>
        </div>
    <?php else : ?>
        <div class="doAnCMS-regular-page">
            <?php while (have_posts()) : the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>

</div>

<?php get_footer(); ?>