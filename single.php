<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php
        while (have_posts()) :
            the_post();
        ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                    
                    <div class="entry-meta">
                        <?php
                        echo 'Posted on ' . get_the_date() . ' by ' . get_the_author();
                        ?>
                    </div>
                </header>

                <?php
                // Menampilkan gambar unggulan
                if (has_post_thumbnail()) :
                    echo '<div class="post-thumbnail">';
                    the_post_thumbnail('large');
                    echo '</div>';
                endif;
                ?>

                <div class="entry-content">
                    <?php
                    the_content();

                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('Pages:', 'your-theme-textdomain'),
                        'after'  => '</div>',
                    ));
                    ?>
                </div>

                <footer class="entry-footer">
                    <?php
                    // Tampilkan kategori dan tag
                    $categories_list = get_the_category_list(', ');
                    if ($categories_list) {
                        echo '<span class="cat-links">Categories: ' . $categories_list . '</span>';
                    }

                    $tags_list = get_the_tag_list('', ', ');
                    if ($tags_list) {
                        echo '<span class="tags-links">Tags: ' . $tags_list . '</span>';
                    }
                    ?>
                </footer>
            </article>

            <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
        endwhile;
        ?>
    </main>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>