<?php get_header();
if (have_posts()) :
    while (have_posts()) :
        the_post();
?>

<section class="emp-page-wrapper container mx-auto">
    <?php the_content(); ?>
</section>

<?php
    endwhile;
endif;
get_footer(); ?>
