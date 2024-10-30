<?php
/**
 * The template for displaying all pages
 *
 * @package YourThemeName
 */

get_header();
?>

<main id="primary" class="site-main container mx-auto px-4 py-8">

    <?php
    while ( have_posts() ) :
        the_post();
    ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white shadow-md rounded-lg overflow-hidden'); ?>>
        <header class="entry-header p-6 bg-gray-100">
            <?php the_title( '<h1 class="entry-title text-3xl font-bold text-gray-800">', '</h1>' ); ?>
        </header>

        <div class="entry-content p-6">
            <?php
            the_content();

            wp_link_pages(
                array(
                    'before' => '<div class="page-links mt-4">' . esc_html__( 'Pages:', 'yourthemename' ),
                    'after'  => '</div>',
                )
            );
            ?>
        </div>

        <?php if ( get_edit_post_link() ) : ?>
            <footer class="entry-footer p-6 bg-gray-100">
                <?php
                edit_post_link(
                    sprintf(
                        wp_kses(
                            /* translators: %s: Name of current post. Only visible to screen readers */
                            __( 'Edit <span class="sr-only">%s</span>', 'yourthemename' ),
                            array(
                                'span' => array(
                                    'class' => array(),
                                ),
                            )
                        ),
                        wp_kses_post( get_the_title() )
                    ),
                    '<span class="edit-link text-blue-600 hover:text-blue-800">',
                    '</span>'
                );
                ?>
            </footer>
        <?php endif; ?>
    </article>

    <?php
    endwhile; // End of the loop.
    ?>

</main>

<?php
get_sidebar();
get_footer();