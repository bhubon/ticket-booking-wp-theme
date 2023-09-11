<?php get_header();
if (have_posts()) :
    while (have_posts()) :
        the_post();
?>

<section class="emp-page-wrapper container mx-auto">
    <h2><?php the_title(); ?></h2>
    <?php the_content(); ?>

    <h2 class="font-bold text-2xl mb-2">Comments</h2>
    <?php comments_template(); ?>
</section>

<?php
    endwhile;
endif;
get_footer(); ?>
