<?php
namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

class GDP_cta2 extends Widget_Base {
    public function get_name() { return 'gdp-cta2'; }
    public function get_title() { return 'GDP CTA 2'; }
    public function get_icon() { return 'eicon-call-to-action'; }
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
            'title',
            [
                'label' => 'Title',
                'type' => Controls_Manager::TEXT,
                'default' => 'Join Our Community!',
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => 'Description',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Subscribe now and stay updated with the latest news and offers.',
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => 'Button Text',
                'type' => Controls_Manager::TEXT,
                'default' => 'Subscribe Now',
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label' => 'Button Link',
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://your-link.com',
                'default' => [
                    'url' => '#',
                    'is_external' => false,
                    'nofollow' => false,
                ],
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
                'default' => '#4F46E5',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <!-- CTA Section with modern design and animations -->
        <section class="gdp-cta2 relative overflow-hidden py-16 lg:py-24" 
                style="background-color: <?php echo esc_attr($settings['background_color']); ?>"
                role="complementary"
                aria-label="Call to Action">
            
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <?php if (!empty($settings['title'])) : ?>
                        <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 animate__animated animate__fadeIn">
                            <?php echo esc_html($settings['title']); ?>
                        </h2>
                    <?php endif; ?>

                    <?php if (!empty($settings['description'])) : ?>
                        <p class="text-lg md:text-xl text-gray-200 mb-8 animate__animated animate__fadeIn animate__delay-1s">
                            <?php echo esc_html($settings['description']); ?>
                        </p>
                    <?php endif; ?>

                    <?php if (!empty($settings['button_text']) && !empty($settings['button_link']['url'])) : ?>
                        <a href="<?php echo esc_url($settings['button_link']['url']); ?>"
                           class="inline-flex items-center px-8 py-3 rounded-lg text-lg font-semibold text-white bg-gray-800 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white animate__animated animate__fadeIn animate__delay-2s"
                           role="button"
                           <?php echo $settings['button_link']['is_external'] ? 'target="_blank"' : ''; ?>
                           <?php echo $settings['button_link']['nofollow'] ? 'rel="nofollow"' : ''; ?>>
                            <?php echo esc_html($settings['button_text']); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php
    }
}