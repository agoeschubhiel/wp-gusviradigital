<?php
/**
 * Template Name: Blank Page
 * Description: A blank page template with no header or footer.
 */

get_header('blank'); // Optional: Load a custom header for the blank page

// The Loop for displaying the page content
while ( have_posts() ) :
    the_post();
    ?>
    <main class="min-h-screen bg-white">
        <article class="prose max-w-none">
            <?php the_content(); ?>
        </article>
    </main>
    <?php
endwhile;

get_footer('blank'); // Optional: Load a custom footer for the blank page
?>