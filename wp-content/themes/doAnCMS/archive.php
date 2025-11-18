<?php

/**
 * Template for Blog Category Page
 * Description: Display posts belonging to the clicked category with nice UI.
 */

if (!defined('ABSPATH')) exit;

get_header(); ?>

<div class="doAnCMS-blog-container" style="padding:50px; max-width:1000px; margin:0 auto;">

    <?php
    // Lấy category hiện tại
    $category = get_queried_object();
    $category_id = $category->term_id;
    ?>

    <!-- Title -->
    <h1 style="text-align:center; margin-bottom:40px; font-size:36px; font-weight:700;">
        Category: <?php echo esc_html($category->name); ?>
    </h1>

    <!-- List Categories -->
    <div class="doAnCMS-blog-categories" style="margin-bottom:40px;">
        <h3 style="font-size:22px; font-weight:600; margin-bottom:15px;">Browse Categories</h3>
        <ul style="display:flex; flex-wrap:wrap; gap:15px; list-style:none; padding:0; margin:0;">
            <?php
            $categories = get_categories();
            $colors = ['#f39c12', '#27ae60', '#8e44ad', '#e74c3c', '#2980b9', '#16a085', '#d35400'];
            $icons = ['🍏', '🥦', '🥕', '🍇', '🥑', '🍓', '🌽'];
            $i = 0;

            foreach ($categories as $cat) {
                $color = $colors[$i % count($colors)];
                $icon = $icons[$i % count($icons)];
                $category_link = get_category_link($cat->term_id);

                echo '<li>
                        <a href="' . esc_url($category_link) . '" 
                           style="
                              display:inline-flex; 
                              align-items:center; 
                              gap:8px;
                              padding:10px 18px; 
                              background:' . $color . '; 
                              color:#fff; 
                              text-decoration:none; 
                              border-radius:25px; 
                              font-weight:500;
                              transition: all 0.3s;
                           ">
                           <span>' . $icon . '</span> 
                           ' . esc_html($cat->name) . '
                        </a>
                      </li>';
                $i++;
            }
            ?>
        </ul>
    </div>

    <style>
        .doAnCMS-blog-categories a:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
            filter: brightness(1.1);
        }
    </style>

    <?php
    /* Query theo category */
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    $args = [
        'post_type' => 'post',
        'cat' => $category_id,
        'posts_per_page' => 10,
        'paged' => $paged,
    ];

    $query = new WP_Query($args);
    ?>

    <?php if ($query->have_posts()) : ?>

        <div class="doAnCMS-blog-list" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap:40px;">
            <?php while ($query->have_posts()) : $query->the_post(); ?>

                <div class="doAnCMS-blog-item" style="border:1px solid #eee; border-radius:10px; overflow:hidden; box-shadow:0 4px 8px rgba(0,0,0,0.05); transition: all 0.3s;">

                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium', [
                                'style' => 'width:100%; height:200px; object-fit:cover; display:block;',
                                'loading' => 'lazy'
                            ]); ?>
                        </a>
                    <?php endif; ?>

                    <div style="padding:20px;">
                        <h2 style="font-size:24px; margin-bottom:10px;">
                            <a href="<?php the_permalink(); ?>" style="text-decoration:none; color:#333;">
                                <?php the_title(); ?>
                            </a>
                        </h2>

                        <p style="font-size:14px; color:#999; margin-bottom:10px;">
                            Posted on <?php the_time('F j, Y'); ?> |
                            <?php comments_number('0 Comments', '1 Comment', '% Comments'); ?>
                        </p>

                        <p style="color:#666; font-size:16px;">
                            <?php
                            $excerpt = wp_trim_words(wp_strip_all_tags(get_the_content()), 40, '...');
                            echo $excerpt;
                            ?>
                        </p>

                        <a href="<?php the_permalink(); ?>" style="display:inline-block; margin-top:10px; color:#0073aa; text-decoration:none; font-weight:bold;">
                            Read More →
                        </a>
                    </div>
                </div>

            <?php endwhile; ?>
        </div>

        <div class="doAnCMS-pagination" style="text-align:center; margin-top:50px;">
            <?php
            echo paginate_links([
                'total' => $query->max_num_pages,
                'current' => $paged,
                'prev_text' => '&laquo; Previous',
                'next_text' => 'Next &raquo;',
                'mid_size' => 1,
                'type' => 'list',
            ]);
            ?>
        </div>

        <?php wp_reset_postdata(); ?>

    <?php else : ?>
        <p style="text-align:center; font-size:18px;">No posts found in this category.</p>
    <?php endif; ?>
</div>

<style>
    .doAnCMS-blog-item:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
    }

    .doAnCMS-pagination ul {
        list-style: none;
        padding: 0;
        display: inline-flex;
        gap: 8px;
    }

    .doAnCMS-pagination ul li a,
    .doAnCMS-pagination ul li span {
        display: block;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        text-decoration: none;
        color: #0073aa;
        transition: all 0.3s;
    }

    .doAnCMS-pagination ul li .current,
    .doAnCMS-pagination ul li a:hover {
        background-color: #0073aa;
        color: #fff;
        border-color: #0073aa;
    }
</style>

<?php get_footer(); ?>