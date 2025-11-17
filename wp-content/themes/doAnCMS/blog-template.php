<?php

/**
 * Template Name: Blog Page
 * Description: Display latest blog posts with thumbnails, excerpts, and pagination
 */

if (!defined('ABSPATH')) exit;

get_header(); ?>

<div class="doAnCMS-blog-container" style="padding:50px; max-width:1000px; margin:0 auto;">
    <h1 style="text-align:center; margin-bottom:50px; font-size:36px;">Our Blog</h1>

    <?php
    // Query 10 latest posts
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 10,
        'paged' => $paged,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo '<p>Found posts: ' . $query->found_posts . '</p>';
    }


    if ($query->have_posts()) : ?>
        <div class="doAnCMS-blog-list" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap:40px;">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <div class="doAnCMS-blog-item" style="border:1px solid #eee; border-radius:10px; overflow:hidden; box-shadow:0 4px 8px rgba(0,0,0,0.05); transition:transform 0.3s;">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium', ['style' => 'width:100%; height:200px; object-fit:cover; display:block;']); ?>
                        </a>
                    <?php endif; ?>
                    <div style="padding:20px;">
                        <h2 style="font-size:24px; margin-bottom:10px;"><a href="<?php the_permalink(); ?>" style="text-decoration:none; color:#333;"><?php the_title(); ?></a></h2>
                        <p style="color:#666; font-size:16px;"><?php echo wp_trim_words(get_the_content(), 25); ?></p>
                        <a href="<?php the_permalink(); ?>" style="display:inline-block; margin-top:10px; color:#0073aa; text-decoration:none;">Read More &rarr;</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <div class="doAnCMS-pagination" style="text-align:center; margin-top:50px;">
            <?php
            echo paginate_links(array(
                'total' => $query->max_num_pages,
                'prev_text' => '&laquo; Previous',
                'next_text' => 'Next &raquo;',
            ));
            ?>
        </div>

        <?php wp_reset_postdata(); ?>
    <?php else : ?>
        <p style="text-align:center; font-size:18px;">No blog posts found.</p>
    <?php endif; ?>
</div>

<style>
    .doAnCMS-blog-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }
</style>

<?php get_footer(); ?>