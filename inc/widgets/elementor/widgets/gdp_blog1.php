<?php
namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class GDP_Blog1 extends Widget_Base {
    public function get_name() { return 'gdp-blog1'; }
    public function get_title() { return 'GDP Blog 1'; }
    public function get_icon() { return 'eicon-posts-grid'; }
    public function get_categories() { return ['gdp-widgets']; }

    public function get_script_depends() {
        return ['isotope', 'gsap', 'scrolltrigger'];
    }

    protected function register_controls() {
        // Content Section
        $this->start_controls_section(
            'section_content',
            [
                'label' => 'Content',
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'section_title',
            [
                'label' => 'Section Title',
                'type' => Controls_Manager::TEXT,
                'default' => 'Latest Blog Posts',
            ]
        );

        $this->add_control(
            'section_description',
            [
                'label' => 'Section Description',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Discover our latest insights and updates',
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => 'Posts Per Page',
                'type' => Controls_Manager::NUMBER,
                'default' => 6,
            ]
        );

        $this->add_control(
            'order_by',
            [
                'label' => 'Order By',
                'type' => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date' => 'Date',
                    'title' => 'Title',
                    'modified' => 'Last Modified',
                    'comment_count' => 'Comment Count',
                    'rand' => 'Random',
                ],
            ]
        );

        $this->add_control(
            'categories',
            [
                'label' => 'Categories',
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->get_post_categories(),
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'section_style',
            [
                'label' => 'Style',
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_background_color',
            [
                'label' => 'Card Background Color',
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => 'Title Typography',
                'selector' => '{{WRAPPER}} .blog-post-title',
            ]
        );

        $this->end_controls_section();
    }

    private function get_post_categories() {
        $categories = get_categories();
        $options = [];
        foreach ($categories as $category) {
            $options[$category->term_id] = $category->name;
        }
        return $options;
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        // Query arguments
        $args = [
            'post_type' => 'post',
            'posts_per_page' => $settings['posts_per_page'],
            'orderby' => $settings['order_by'],
            'order' => 'DESC',
        ];

        if (!empty($settings['categories'])) {
            $args['category__in'] = $settings['categories'];
        }

        $posts_query = new \WP_Query($args);
        ?>

        <section class="gdp-blog1 py-16 lg:py-24 bg-gray-50" data-aos="fade-up">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4 animate__animated animate__fadeIn">
                        <?php echo esc_html($settings['section_title']); ?>
                    </h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        <?php echo esc_html($settings['section_description']); ?>
                    </p>
                </div>

                <!-- Blog Grid -->
                <div class="blog-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php
                    if ($posts_query->have_posts()) :
                        while ($posts_query->have_posts()) : $posts_query->the_post();
                            $categories = get_the_category();
                            $category_classes = '';
                            foreach ($categories as $category) {
                                $category_classes .= ' category-' . $category->slug;
                            }
                    ?>
                        <article class="blog-post bg-white rounded-lg overflow-hidden shadow-lg transition-all duration-300 hover:shadow-2xl<?php echo esc_attr($category_classes); ?>"
                                 data-aos="fade-up">
                            <!-- Featured Image -->
                            <div class="relative overflow-hidden aspect-video">
                                <?php if (has_post_thumbnail()) : ?>
                                    <img src="<?php the_post_thumbnail_url('large'); ?>"
                                         alt="<?php the_title_attribute(); ?>"
                                         class="w-full h-full object-cover transform transition-transform duration-500 hover:scale-110"
                                         loading="lazy">
                                <?php endif; ?>
                                
                                <!-- Categories -->
                                <div class="absolute top-4 left-4 flex flex-wrap gap-2">
                                    <?php foreach ($categories as $category) : ?>
                                        <span class="px-3 py-1 text-sm bg-primary text-white rounded-full">
                                            <?php echo esc_html($category->name); ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <header class="mb-4">
                                    <h3 class="blog-post-title text-xl font-bold mb-2 hover:text-primary transition-colors">
                                        <a href ="<?php the_permalink(); ?>" rel="bookmark">
                                            <?php the_title(); ?>
                                        </a>
                                    </h3>
                                    <p class="text-sm text-gray-600">
                                        <?php the_excerpt(); ?>
                                    </p>
                                </header>

                                <!-- Read More Button -->
                                <a href="<?php the_permalink(); ?>" class="btn btn-primary hover:bg-primary-dark transition-colors">
                                    Read More
                                </a>
                            </div>
                        </article>
                    <?php endwhile; endif; ?>
                </div>
            </div>
        </section>
        <?php
    }
}