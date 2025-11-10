<?php get_header(); ?>

<?php 
while (have_posts()) {
  the_post(); 
  $theParent = wp_get_post_parent_id(get_the_ID());
?>
  <div class="page-banner">
    <div class="page-banner__bg-image"
      style="background-image: url('<?php echo get_theme_file_uri('/assets/images/ocean.jpg'); ?>')"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php the_title(); ?></h1>
      <div class="page-banner__intro">
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloremque a molestias iusto eveniet minus labore dolorem, nesciunt rem ducimus, officia optio expedita ab deserunt eius magni facere quis blanditiis natus!</p>
      </div>
    </div>
  </div>

  <div class="container container--narrow page-section">

    <?php if ($theParent) { ?>
      <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
          <a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent); ?>">
            <i class="fa fa-home" aria-hidden="true"></i> 
            Back to <?php echo get_the_title($theParent); ?>
          </a> 
          <span class="metabox__main"><?php the_title(); ?></span>
        </p>
      </div>
    <?php } ?>

    <?php 
      $testArray = get_pages(array(
        'child_of' => get_the_ID()
      ));

      if ($theParent or $testArray) { ?>
        <div class="page-links">
          <h2 class="page-links__title">
            <a href="<?php echo get_permalink($theParent ? $theParent : get_the_ID()); ?>">
              <?php echo get_the_title($theParent ? $theParent : get_the_ID()); ?>
            </a>
          </h2>
          <ul class="min-list">
            <?php 
              if ($theParent) {
                $findChildrenOf = $theParent;
              } else {
                $findChildrenOf = get_the_ID();
              }

              wp_list_pages(array(
                'title_li' => NULL,
                'child_of' => $findChildrenOf,
                'sort_column' => 'menu_order'
              ));
            ?>
          </ul>
        </div>
      <?php } ?>

    <div class="generic-content">
      <?php the_content(); ?>
    </div>

  </div>
<?php } ?>

<?php get_footer(); ?>
x