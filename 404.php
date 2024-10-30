<?php get_header(); ?>

<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8" style="background: <?php echo GDP_Theme_Support::gdp_option('404_background')['background-color']; ?>">
    <div class="max-w-3xl w-full space-y-8">
        <div class="text-center">
            <?php
            // Get 404 image
            $error_image = GDP_Theme_Support::gdp_option('404_image');
            if (!empty($error_image['url'])) :
            ?>
                <div class="mx-auto w-full max-w-md mb-8">
                    <img class="mx-auto h-auto w-auto" src="<?php echo esc_url($error_image['url']); ?>" alt="404 Error">
                </div>
            <?php endif; ?>

            <h1 class="mt-6 text-4xl font-extrabold text-gray-900 tracking-tight">
                <?php echo esc_html(GDP_Theme_Support::gdp_option('404_page_title')); ?>
            </h1>
            
            <div class="mt-4 text-lg text-gray-600">
                <?php echo wp_kses_post(GDP_Theme_Support::gdp_option('404_message')); ?>
            </div>

            <?php if (GDP_Theme_Support::gdp_option('show_home_button')) : ?>
                <div class="mt-8">
                    <a href="<?php echo esc_url(home_url('/')); ?>" 
                       class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <?php echo esc_html(GDP_Theme_Support::gdp_option('home_button_text')); ?>
                    </a>
                </div>
            <?php endif; ?>

            <?php if (GDP_Theme_Support::gdp_option('show_search')) : ?>
                <div class="mt-8">
                    <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" 
                          class="mt-2 flex rounded-md shadow-sm">
                        <input type="search" name="s" 
                               class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-l-md sm:text-sm border-gray-300" 
                               placeholder="<?php echo esc_attr(GDP_Theme_Support::gdp_option('search_placeholder')); ?>">
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-r-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <?php _e('Search', 'gusviradigital'); ?>
                        </button>
                    </form>
                </div>
            <?php endif; ?>

            <?php if (GDP_Theme_Support::gdp_option('show_suggestions')) : ?>
                <div class="mt-12">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">
                        <?php _e('Suggested Posts', 'gusviradigital'); ?>
                    </h3>
                    <ul class="divide-y divide-gray-200">
                        <?php
                        $suggested_posts = GDP_Theme_Support::get_404_suggested_posts();
                        foreach ($suggested_posts as $post) :
                            setup_postdata($post);
                        ?>
                            <li class="py-4">
                                <a href="<?php echo get_permalink($post); ?>" 
                                   class="text-indigo-600 hover:text-indigo-900 text-lg font-medium">
                                    <?php echo get_the_title($post); ?>
                                </a>
                            </li>
                        <?php
                        endforeach;
                        wp_reset_postdata();
                        ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
// Log 404 error if enabled
GDP_Theme_Support::log_404_error();

get_footer();
?>