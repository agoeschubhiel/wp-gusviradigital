<?php
class GDP_SEO {
    private static $instance = null;

    private function __construct() {
        $this->init();
    }

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Update init method untuk menambahkan fitur baru
    private function init() {
        if ($this->is_seo_enabled()) {
            add_action('wp_head', array($this, 'add_meta_tags'), 1);
            add_action('wp_head', array($this, 'add_knowledge_graph'));
            
            if (is_single()) {
                add_action('wp_head', array($this, 'add_article_schema'));
            }

            // Add analytics
            add_action('wp_head', array($this, 'add_analytics'));

            if ($this->get_option('enable_schema', true)) {
                add_action('wp_footer', array($this, 'add_schema_markup'));
            }

            if ($this->get_option('enable_sitemap', true)) {
                $this->init_sitemap();
            }

            if ($this->get_option('enable_canonical', true)) {
                add_action('wp_head', array($this, 'add_canonical_url'));
            }

            if ($this->get_option('enable_noindex', true)) {
                $this->handle_noindex_pages();
            }

            if ($this->get_option('enable_performance_optimization', true)) {
                $this->optimize_seo_performance();
            }

            if ($this->get_option('enable_redirects', true)) {
                $this->handle_redirects();
            }

            // Add robots.txt rules
            if ($this->get_option('custom_robots', false)) {
                add_filter('robots_txt', array($this, 'custom_robots_txt'), 10, 2);
            }

            // Add breadcrumbs
            if ($this->get_option('enable_breadcrumbs', true)) {
                add_action('gdp_breadcrumbs', array($this, 'display_breadcrumbs'));
            }

            if ($this->get_option('enable_meta_robots', true)) {
                add_action('wp_head', array($this, 'add_meta_robots'));
            }
            
            if ($this->get_option('enable_focus_keyword', true)) {
                add_action('wp_head', array($this, 'analyze_focus_keyword'));
            }
            
            if ($this->get_option('enable_social_preview', true)) {
                add_action('wp_head', array($this, 'add_social_preview'));
            }
            
            if ($this->get_option('enable_breadcrumbs_schema', true)) {
                add_action('wp_footer', array($this, 'add_breadcrumbs_schema'));
            }
            
            if ($this->get_option('optimize_rss', true)) {
                $this->optimize_rss_feed();
            }
        }
    }

    private function is_seo_enabled() {
        return $this->get_option('enable_seo', true);
    }

    private function get_option($key, $default = '') {
        return GDP_Theme_Support::gdp_option($key, $default);
    }

    public function add_meta_tags() {
        // Basic meta tags
        $this->output_title_tag();
        $this->output_meta_description();
        
        // Social meta tags
        if ($this->get_option('og_tags', true)) {
            $this->add_open_graph_tags();
        }
        
        if ($this->get_option('twitter_cards', true)) {
            $this->add_twitter_cards();
        }

        // Canonical URL
        if ($this->get_option('enable_canonical', true)) {
            $this->add_canonical_url();
        }

        // Google Search Console verification
        $this->add_search_console_verification();
    }

    private function output_title_tag() {
        $separator = $this->get_option('seo_separator', '|');
        
        if (is_home() || is_front_page()) {
            $title = $this->get_option('homepage_title', get_bloginfo('name'));
        } else {
            $title = wp_title($separator, false, 'right') . get_bloginfo('name');
        }

        echo "<title>" . esc_html($title) . "</title>\n";
    }

    private function output_meta_description() {
        $description = '';
        
        if (is_home() || is_front_page()) {
            $description = $this->get_option('homepage_meta_description', get_bloginfo('description'));
        } elseif (is_singular()) {
            $description = get_the_excerpt();
        }

        if ($description) {
            echo '<meta name="description" content="' . esc_attr($description) . '" />' . "\n";
        }
    }

    public function add_schema_markup() {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => $this->get_option('organization_type', 'Organization'),
            'name' => $this->get_option('company_name', get_bloginfo('name')),
            'url' => home_url(),
        );

        // Add logo if set
        $logo = $this->get_option('company_logo');
        if ($logo) {
            $schema['logo'] = $logo['url'];
        }

        // Add local business info if available
        if ($this->get_option('business_address')) {
            $schema['address'] = array(
                '@type' => 'PostalAddress',
                'streetAddress' => $this->get_option('business_address')
            );
            
            if ($this->get_option('business_phone')) {
                $schema['telephone'] = $this->get_option('business_phone');
            }
            
            if ($this->get_option('business_hours')) {
                $schema['openingHours'] = $this->get_option('business_hours');
            }
        }

        echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>' . "\n";
    }

    public function custom_robots_txt($output, $public) {
        if ($public && $this ->get_option('custom_robots', false)) {
            return $this->get_option('robots_content');
        }
        return $output;
    }

    public function init_sitemap() {
        if (!$this->get_option('enable_sitemap', true)) {
            return;
        }

        // Register sitemap rewrite rules
        add_rewrite_rule('sitemap\.xml$', 'index.php?gdp_sitemap=main', 'top');
        add_rewrite_rule('sitemap-([^/]+)\.xml$', 'index.php?gdp_sitemap=$matches[1]', 'top');

        // Register query vars
        add_filter('query_vars', function($vars) {
            $vars[] = 'gdp_sitemap';
            return $vars;
        });

        // Handle sitemap requests
        add_action('template_redirect', array($this, 'generate_sitemap'));
    }

    public function generate_sitemap() {
        $sitemap_type = get_query_var('gdp_sitemap');
        
        if (!$sitemap_type) {
            return;
        }

        header('Content-Type: application/xml; charset=UTF-8');

        if ($sitemap_type === 'main') {
            $this->generate_main_sitemap();
        } else {
            $this->generate_specific_sitemap($sitemap_type);
        }
        exit;
    }

    private function generate_main_sitemap() {
        $priority = $this->get_option('sitemap_priority', '0.5');
        
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Homepage
        echo '<url>';
        echo '<loc>' . home_url('/') . '</loc>';
        echo '<lastmod>' . get_lastpostmodified('GMT') . '</lastmod>';
        echo '<changefreq>daily</changefreq>';
        echo '<priority>1.0</priority>';
        echo '</url>';

        // Posts
        $posts = get_posts(array(
            'post_type' => 'post',
            'posts_per_page' => -1,
        ));

        foreach ($posts as $post) {
            echo '<url>';
            echo '<loc>' . get_permalink($post) . '</loc>';
            echo '<lastmod>' . get_the_modified_date('Y-m-d\TH:i:s+00:00', $post) . '</lastmod>';
            echo '<changefreq>weekly</changefreq>';
            echo '<priority>' . $priority . '</priority>';
            echo '</url>';
        }

        // Pages
        $pages = get_pages();
        foreach ($pages as $page) {
            echo '<url>';
            echo '<loc>' . get_permalink($page) . '</loc>';
            echo '<lastmod>' . get_the_modified_date('Y-m-d\TH:i:s+00:00', $page) . '</lastmod>';
            echo '<changefreq>monthly</changefreq>';
            echo '<priority>0.8</priority>';
            echo '</url>';
        }

        echo '</urlset>';
    }

    private function generate_specific_sitemap($type) {
        switch ($type) {
            case 'categories':
                $this->generate_taxonomy_sitemap('category');
                break;
            case 'tags':
                $this->generate_taxonomy_sitemap('post_tag');
                break;
            case 'authors':
                $this->generate_authors_sitemap();
                break;
            default:
                wp_die('Invalid sitemap type');
        }
    }

    private function generate_taxonomy_sitemap($taxonomy) {
        $terms = get_terms(array(
            'taxonomy' => $taxonomy,
            'hide_empty' => true,
        ));

        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($terms as $term) {
            echo '<url>';
            echo '<loc>' . get_term_link($term) . '</loc>';
            echo '<changefreq>weekly</changefreq>';
            echo '<priority>0.6</priority>';
            echo '</url>';
        }

        echo '</urlset>';
    }

    private function generate_authors_sitemap() {
        $authors = get_users(array(
            'has_published_posts' => array('post'),
        ));

        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($authors as $author) {
            echo '<url>';
            echo '<loc>' . get_author_posts_url($author->ID) . '</loc>';
            echo '<changefreq>weekly</changefreq>';
            echo '<priority>0.5</priority>';
            echo '</url>';
        }

        echo '</urlset>';
    }

    // Method untuk menangani noindex pages
    public function handle_noindex_pages() {
        if (!is_admin()) {
            if (
                ($this->get_option('noindex_archives', false) && is_archive()) ||
                ($this->get_option('noindex_author', false) && is_author())
            ) {
                add_action('wp_head', array($this, 'add_noindex_meta'), 1);
            }
        }
    }

    public function add_noindex_meta() {
        echo '<meta name="robots" content="noindex,follow" />' . "\n";
    }

    public function display_breadcrumbs() {
        if (!is_front_page()) {
            $separator = $this->get_option('breadcrumb_separator', '›');
            echo '<div class="gdp-breadcrumbs">';
            echo '<a href="' . home_url() . '">Home</a> ' . $separator . ' ';
            
            if (is_category() || is_single()) {
                the_category(' ' . $separator . ' ');
                if (is_single()) {
                    echo ' ' . $separator . ' ';
                    the_title();
                }
            } elseif (is_page()) {
                the_title();
            }
            
            echo '</div>';
        }
    }

    public function add_analytics() {
        $ga_id = $this->get_option('google_analytics_id');
        if ($ga_id) {
            ?>
            <!-- Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr($ga_id); ?>"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());
                gtag('config', '<?php echo esc_attr($ga_id); ?>');
            </script>
            <?php
        }

        // Add Search Console verification
        $search_console = $this->get_option('google_search_console');
        if ($search_console) {
            echo '<meta name="google-site-verification" content="' . esc_attr($search_console) . '" />' . "\n";
        }
    }

    private function add_open_graph_tags() {
        echo '<meta property="og:locale" content="' . esc_attr(get_locale()) . '" />' . "\n";
        echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '" />' . "\n";

        // Set OG Type
        if (is_single() || is_page()) {
            echo '<meta property="og:type" content="article" />' . "\n";
        } else {
            echo '<meta property="og:type" content="website" />' . "\n";
        }

        // Set OG Title
        if (is_home() || is_front_page()) {
            $og_title = $this->get_option('homepage_title', get_bloginfo('name'));
        } else {
            $og_title = wp_title('', false) . ' - ' . get_bloginfo('name');
        }
        echo '<meta property="og:title" content="' . esc_attr($og_title) . '" />' . "\n";

        // Set OG URL
        echo '<meta property="og:url" content="' . esc_url(get_current_url()) . '" />' . "\n";

        // Set OG Description
        if (is_single() || is_page()) {
            $og_desc = get_the_excerpt();
        } else {
            $og_desc = $this->get_option('homepage_meta_description', get_bloginfo('description'));
        }
        if ($og_desc) {
            echo '<meta property="og:description" content="' . esc_attr($og_desc) . '" />' . "\n";
        }

        // Set OG Image
        if (is_singular() && has_post_thumbnail()) {
            $og_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
            echo '<meta property="og:image" content="' . esc_url($og_image) . '" />' . "\n";
        }
    }

    private function add_twitter_cards() {
        echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
        
        // Twitter Title
        if (is_home() || is_front_page()) {
            $twitter_title = $this->get_option('homepage_title', get_bloginfo('name'));
        } else {
            $twitter_title = wp_title('', false) . ' - ' . get_bloginfo('name');
        }
        echo '<meta name="twitter:title" content="' . esc_attr($twitter_title) . '" />' . "\n";

        // Twitter Description
        if (is_single() || is_page()) {
            $twitter_desc = get_the_excerpt();
        } else {
            $twitter_desc = $this->get_option('homepage_meta_description', get_bloginfo('description'));
        }
        if ($twitter_desc) {
            echo '<meta name="twitter:description" content="' . esc_attr($twitter_desc) . '" />' . "\n";
        }

        // Twitter Image
        if (is_singular() && has_post_thumbnail()) {
            $twitter_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
            echo '<meta name="twitter:image" content="' . esc_url($twitter_image) . '" />' . "\n";
        }
    }

    // Method untuk menangani Knowledge Graph
    private function add_knowledge_graph() {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => $this->get_option('organization_type', 'Organization'),
            'name' => $this->get_option('company_name', get_bloginfo('name')),
            'url' => home_url(),
        );

        // Add logo
        $logo = $this->get_option('company_logo');
        if (!empty($logo['url'])) {
            $schema['logo'] = $logo['url'];
            $schema['image'] = $logo['url'];
        }

        // Add local business info
        $business_address = $this->get_option('business_address');
        if (!empty($business_address)) {
            $schema['address'] = array(
                '@type' => 'PostalAddress',
                'streetAddress' => $business_address
            );
        }

        $business_phone = $this->get_option('business_phone');
        if (!empty($business_phone)) {
            $schema['telephone'] = $business_phone;
        }

        $business_hours = $this->get_option('business_hours');
        if (!empty($business_hours)) {
            $schema['openingHours'] = $business_hours;
        }

        echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>' . "\n";
    }

    // Method untuk menangani Schema Article pada single post
    private function add_article_schema() {
        if (!is_single()) {
            return;
        }

        global $post;
        
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => get_the_title(),
            'datePublished' => get_the_date('c'),
            'dateModified' => get_the_modified_date('c'),
            'author' => array(
                '@type' => 'Person',
                'name' => get_the_author(),
                'url' => get_author_posts_url(get_the_author_meta('ID'))
            ),
            'publisher' => array(
                '@type' => 'Organization',
                'name' => get_bloginfo('name'),
                'logo' => array(
                    '@type' => 'ImageObject',
                    'url' => $this->get_option('company_logo')['url'] ?? ''
                )
            )
        );

        // Add featured image
        if (has_post_thumbnail()) {
            $schema['image'] = array(
                '@type' => 'ImageObject',
                'url' => get_the_post_thumbnail_url($post->ID, 'full')
            );
        }

        echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>' . "\n";
    }

    // Method untuk menangani performance optimization
    private function optimize_seo_performance() {
        // Remove unnecessary meta tags
        remove_action('wp_head', 'wp_generator');
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wp_shortlink_wp_head');
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');

        // Add async/defer to analytics script
        add_filter('script_loader_tag', array($this, 'add_async_defer_to_analytics'), 10, 2);
    }

    public function add_async_defer_to_analytics($tag, $handle) {
        if ('google-analytics' === $handle) {
            return str_replace(' src', ' async defer src', $tag);
        }
        return $tag;
    }

    // Method untuk menangani redirects
    public function handle_redirects() {
        // Redirect HTTP to HTTPS if enabled
        if ($this->get_option('canonical_https', true) && !is_ssl()) {
            wp_redirect('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 301);
            exit;
        }

        // Remove trailing slashes from URLs if enabled
        if ($this->get_option('remove_trailing_slash', false)) {
            add_filter('user_trailingslashit', array($this, 'remove_trailing_slash'), 10, 2);
        }
    }

    public function remove_trailing_slash($url, $type) {
        if ($type != 'single' && $type != 'page' && $type != 'single_paged' && $type != 'page_paged') {
            return untrailingslashit($url);
        }
        return $url;
    }

    // Helper method untuk mendapatkan current URL
    private function get_current_url() {
        global $wp;
        return home_url(add_query_arg(array(), $wp->request));
    }

    private function add_canonical_url() {
        $canonical = '';

        if (is_home() || is_front_page()) {
            $canonical = home_url('/');
        } elseif (is_singular()) {
            $canonical = get_permalink();
        } elseif (is_category()) {
            $canonical = get_category_link(get_queried_object_id());
        } elseif (is_tag()) {
            $canonical = get_tag_link(get_queried_object_id());
        } elseif (is_author()) {
            $canonical = get_author_posts_url(get_queried_object_id());
        } elseif (is_year()) {
            $canonical = get_year_link(get_query_var('year'));
        } elseif (is_month()) {
            $canonical = get_month_link(get_query_var('year'), get_query_var('monthnum'));
        } elseif (is_day()) {
            $canonical = get_day_link(get_query_var('year'), get_query_var('monthnum'), get_query_var('day'));
        }

        if ($canonical && $this->get_option('canonical_https', true)) {
            $canonical = str_replace('http://', 'https://', $canonical);
        }

        if ($canonical) {
            echo '<link rel="canonical" href="' . esc_url($canonical) . '" />' . "\n";
        }
    }

    // Method untuk menangani meta robots per post/page
    private function add_meta_robots() {
        // Default robots setting
        $robots = array();
        
        // Global settings
        if ($this->get_option('noindex_search', true) && is_search()) {
            $robots[] = 'noindex';
        }
        
        if ($this->get_option('noindex_archive', true) && is_archive()) {
            $robots[] = 'noindex';
        }
        
        // Individual post/page settings
        if (is_singular()) {
            $post_robots = get_post_meta(get_the_ID(), '_gdp_robots', true);
            if (!empty($post_robots)) {
                $robots = array_merge($robots, $post_robots);
            }
        }
        
        if (!empty($robots)) {
            echo '<meta name="robots" content="' . esc_attr(implode(',', array_unique($robots))) . '" />' . "\n";
        }
    }

    // Method untuk menangani focus keyword
    private function analyze_focus_keyword() {
        if (!is_singular()) {
            return;
        }

        $focus_keyword = get_post_meta(get_the_ID(), '_gdp_focus_keyword', true);
        if (empty($focus_keyword)) {
            return;
        }

        $analysis = array();
        $content = get_post_field('post_content', get_the_ID());
        
        // Check keyword in title
        if (strpos(strtolower(get_the_title()), strtolower($focus_keyword)) !== false) {
            $analysis['title'] = 'good';
        }
        
        // Check keyword in content
        if (strpos(strtolower($content), strtolower($focus_keyword)) !== false) {
            $analysis['content'] = 'good';
        }
        
        // Check keyword in meta description
        $meta_desc = get_post_meta(get_the_ID(), '_gdp_meta_description', true);
        if (strpos(strtolower($meta_desc), strtolower($focus_keyword)) !== false) {
            $analysis['meta_desc'] = 'good';
        }

        return $analysis;
    }

    // Method untuk menangani social preview
    private function add_social_preview() {
        if (!is_singular()) {
            return;
        }

        $social_preview = get_post_meta(get_the_ID(), '_gdp_social_preview', true);
        if (empty($social_preview)) {
            return;
        }

        // Facebook preview
        if (!empty($social_preview['fb_title'])) {
            echo '<meta property="og:title" content="' . esc_attr($social_preview['fb_title']) . '" />' . "\n";
        }
        if (!empty($social_preview['fb_description'])) {
            echo '<meta property="og:description" content="' . esc_attr($social_preview['fb_description']) . '" />' . "\n";
        }
        if (!empty($social_preview['fb_image'])) {
            echo '<meta property="og:image" content="' . esc_url($social_preview['fb_image']) . '" />' . "\n";
        }

        // Twitter preview
        if (!empty($social_preview['twitter_title'])) {
            echo '<meta name="twitter:title" content="' . esc_attr($social_preview['twitter_title']) . '" />' . "\n";
        }
        if (!empty($social_preview['twitter_description'])) {
            echo '<meta name="twitter:description" content="' . esc_attr($social_preview['twitter_description']) . '" />' . "\n";
        }
        if (!empty($social_preview['twitter_image'])) {
            echo '<meta name="twitter:image" content="' . esc_url($social_preview['twitter_image']) . '" />' . "\n";
        }
    }

    // Method untuk menangani internal linking suggestions
    private function get_internal_linking_suggestions($post_id) {
        $focus_keyword = get_post_meta($post_id, '_gdp_focus_keyword', true);
        if (empty($focus_keyword)) {
            return array();
        }

        $suggestions = get_posts(array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 5,
            'post__not_in' => array($post_id),
            's' => $focus_keyword
        ));

        return $suggestions;
    }

    // Method untuk menangani schema breadcrumbs
    private function add_breadcrumbs_schema() {
        if (!$this->get_option('enable_breadcrumbs_schema', true)) {
            return;
        }

        $breadcrumbs = array();
        $position = 1;

        // Add home
        $breadcrumbs[] = array(
            '@type' => 'ListItem',
            'position' => $position,
            'item' => array(
                '@id' => home_url(),
                'name' => __('Home', 'gdp-seo')
            )
        );

        if (is_singular()) {
            // Add categories if post
            if (is_single()) {
                $categories = get_the_category();
                if (!empty($categories)) {
                    $position++;
                    $category = $categories[0];
                    $breadcrumbs[] = array(
                        '@type' => 'ListItem',
                        'position' => $position,
                        'item' => array(
                            '@id' => get_category_link($category->term_id),
                            'name' => $category->name
                        )
                    );
                }
            }

            // Add current post/page
            $position++;
            $breadcrumbs[] = array(
                '@type' => 'ListItem',
                'position' => $position,
                'item' => array(
                    '@id' => get_permalink(),
                    'name' => get_the_title()
                )
            );
        }

        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $breadcrumbs
        );

        echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>' . "\n";
    }

    // Method untuk menangani RSS feed optimization
    private function optimize_rss_feed() {
        if (!$this->get_option('optimize_rss', true)) {
            return;
        }

        // Add copyright notice to RSS feed
        add_filter('the_content_feed', array($this, 'add_rss_copyright'));
        
        // Add featured image to RSS feed
        add_filter('the_content_feed', array($this, 'add_featured_image_to_rss'));
    }

    public function add_rss_copyright($content) {
        $post_link = get_permalink();
        $site_link = get_bloginfo('url');
        $site_name = get_bloginfo('name');
        
        $copyright = sprintf(
            '<p>' . __('This article first appeared on %1$s. Read the original article %2$s.', 'gdp-seo') . '</p>',
            '<a href="' . $site_link . '">' . $site_name . '</a>',
            '<a href="' . $post_link . '">here</a>'
        );
        
        return $content . $copyright;
    }

    public function add_featured_image_to_rss($content) {
        global $post;
        
        if (has_post_thumbnail($post->ID)) {
            $content = '<p>' . get_the_post_thumbnail($post->ID, 'medium') . '</p>' . $content;
        }
        
        return $content;
    }

    private function add_search_console_verification() {
        // Implementation for Search Console verification
    }
}

// Initialize SEO
function gdp_seo() {
    return GDP_SEO::get_instance();
}

// Start the SEO functionality
add_action('after_setup_theme', 'gdp_seo');