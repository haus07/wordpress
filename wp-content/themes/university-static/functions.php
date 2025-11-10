<?php
function university_files()
{
  wp_enqueue_style('university_main_styles', get_theme_file_uri('/assets/build/index.css'));
  wp_enqueue_style('university_extra_styles', get_theme_file_uri('/assets/build/style-index.css'));
  wp_enqueue_script('university_main_script', get_theme_file_uri('/assets/build/index.js'), NULL, '1.0', true);
}

add_action('wp_enqueue_scripts', 'university_files');

function university_features()
{
  add_theme_support('title-tag');

  register_nav_menus(array(
    'headermenu' => 'Header Menu',
    'footerExploreLocation' => 'Footer Explore Menu',
    'footerLearnLocation' => 'Footer Learn Menu'
  ));
}
add_action('after_setup_theme', 'university_features');

