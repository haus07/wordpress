<?php
get_header();
?>

<style>
    .single-post-container {
        max-width: 900px;
        margin: 50px auto;
        padding: 20px;
    }

    .single-post-container h1 {
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .single-post-featured img {
        width: 100%;
        height: auto;
        border-radius: 10px;
        margin-bottom: 25px;
    }

    .single-post-content {
        font-size: 18px;
        line-height: 1.7;
    }
</style>

<div class="single-post-container">

    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
    ?>

            <h1><?php the_title(); ?></h1>

            <?php if (has_post_thumbnail()) : ?>
                <div class="single-post-featured">
                    <?php the_post_thumbnail(); ?>
                </div>
            <?php endif; ?>

            <div class="single-post-content">
                <?php the_content(); ?>
            </div>

    <?php
        endwhile;
    endif;
    ?>

</div>

<?php
get_footer();
?>