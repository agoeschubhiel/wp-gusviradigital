<?php
namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

class GDP_Testi1 extends Widget_Base {
    public function get_name() { return 'gdp-testimonials1'; }
    public function get_title() { return 'GDP Testimonials 1'; }
    public function get_icon() { return 'eicon-testimonial'; }
    public function get_categories() { return ['gdp-widgets']; }

    // Tambahkan dependency Animated.css
    public function get_style_depends() {
        return ['animate-css'];
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
                'default' => 'What Our Clients Say',
            ]
        );

        $this->add_control(
            'testimonials',
            [
                'label' => 'Testimonials',
                'type' => Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'client_name',
                        'label' => 'Client Name',
                        'type' => Controls_Manager::TEXT,
                        'default' => 'John Doe',
                    ],
                    [
                        'name' => 'client_feedback',
                        'label' => 'Feedback',
                        'type' => Controls_Manager::TEXTAREA,
                        'default' => 'This is a fantastic service! Highly recommend it.',
                    ],
                    [
                        'name' => 'client_image',
                        'label' => 'Client Image',
                        'type' => Controls_Manager::MEDIA,
                        'default' => [
                            'url' => 'https://example.com/client-image.jpg', // Ganti dengan URL gambar Anda
                        ],
                    ],
                ],
                'title_field' => '{{{ client_name }}}',
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
            'background_color',
            [
                'label' => 'Background Color',
                'type' => Controls_Manager::COLOR,
                'default' => '#f9f9f9',
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => 'Text Color',
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <!-- Testimonials Section -->
        <section class="gdp-testimonials1 py-16 lg:py-24" 
                 style="background-color: <?php echo esc_attr($settings['background_color']); ?>"
                 role="complementary"
                 aria-label="Testimonials">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <?php if (!empty($settings['section_title'])) : ?>
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-center mb-12 text-<?php echo esc_attr($settings['text_color']); ?> animate__animated animate__fadeIn">
                        <?php echo esc_html($settings['section_title']); ?>
                    </h2>
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($settings['testimonials'] as $testimonial) : ?>
                        <div class="bg-white p-6 rounded-lg shadow-lg transition-transform transform hover:scale-105 animate__animated animate__fadeInUp">
                            <?php if (!empty($testimonial['client_image']['url'])) : ?>
                                <div class="mb-4">
                                    <img src="<?php echo esc_url($testimonial['client_image']['url']); ?>" alt="<?php echo esc_attr($testimonial['client_name']); ?>" class="w-16 h-16 rounded-full mx-auto" />
                                </div>
                            <?php endif; ?>

                            <p class="text-lg text-<?php echo esc_attr($settings['text_color']); ?> mb-4">
                                "<?php echo esc_html($testimonial['client_feedback']); ?>"
                            </p>
                            <p class ="text-sm text-<?php echo esc_attr($settings['text_color']); ?> font-bold">
                                <?php echo esc_html($testimonial['client_name']); ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}