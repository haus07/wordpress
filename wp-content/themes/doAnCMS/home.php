<?php get_header(); ?>

<div class="doAnCMS-blog-list">
    <?php
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $query = new WP_Query(array(
        'post_type' => 'post',
        'posts_per_page' => 10,
        'paged' => $paged,
    ));

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post(); ?>
            <div class="doAnCMS-blog-item">
                <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('medium'); ?>
                    </a>
                <?php endif; ?>
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <p><?php echo wp_trim_words(get_the_content(), 30); ?></p>
            </div>
    <?php }
        // Pagination
        echo '<div class="doAnCMS-pagination">' . paginate_links(array(
            'total' => $query->max_num_pages
        )) . '</div>';
    } else {
        echo '<p>Chưa có bài viết nào.</p>';
    }
    wp_reset_postdata();
    ?>
</div>

<?php get_footer(); ?>