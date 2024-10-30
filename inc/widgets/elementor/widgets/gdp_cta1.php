<?php
namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

if (!defined('ABSPATH')) exit;

class GDP_cta1 extends Widget_Base {
    public function get_name() { return 'gdp-cta1'; }
    public function get_title() { return 'GDP CTA 1'; }
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
            'pre_title',
            [
                'label' => 'Pre Title',
                'type' => Controls_Manager::TEXT,
                'default' => 'Start Today',
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => 'Title',
                'type' => Controls_Manager::TEXT,
                'default' => 'Ready to Transform Your Business?',
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => 'Description',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Join thousands of satisfied customers who have taken their business to the next level.',
            ]
        );

        $this->add_control(
            'primary_button_text',
            [
                'label' => 'Primary Button Text',
                'type' => Controls_Manager::TEXT,
                'default' => 'Get Started',
            ]
        );

        $this->add_control(
            'primary_button_link',
            [
                'label' => 'Primary Button Link',
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://your-link.com',
                'default' => [
                    'url' => '#',
                    'is_external' => false,
                    'nofollow' => false,
                ],
            ]
        );

        $this->add_control(
            'secondary_button_text',
            [
                'label' => 'Secondary Button Text',
                'type' => Controls_Manager::TEXT,
                'default' => 'Learn More',
            ]
        );

        $this->add_control(
            'secondary_button_link',
            [
                'label' => 'Secondary Button Link',
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
                'default' => '#1a1a1a',
            ]
        );

        $this->add_control(
            'accent_color',
            [
                'label' => 'Accent Color',
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
        <section class="gdp-cta1 relative overflow-hidden py-16 lg:py-24" 
                style="background-color: <?php echo $settings['background_color']; ?>"
                role="complementary"
                aria-label="Call to Action">
            
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0 bg-grid-pattern transform rotate-45"></div>
            </div>

            <!-- Main Content Container -->
            <div class="relative container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto text-center">
                    <?php if (!empty($settings['pre_title'])) : ?>
                        <!-- Pre-title -->
                        <span class="inline-block px-4 py-1 rounded-full text-sm font-semibold tracking-wide text-white bg-opacity-20 bg-white mb-4 animate__animated animate__fadeIn">
                            <?php echo esc_html($settings['pre_title']); ?>
                        </span>
                    <?php endif; ?>

                    <?php if (!empty($settings['title'])) : ?>
                        <!-- Main Title -->
                        <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6 leading-tight animate__animated animate__fadeInUp animate__delay-1s">
                            <?php echo esc_html($settings['title']); ?>
                        </h2>
                    <?php endif; ?>

                    <?php if (!empty($settings['description'])) : ?>
                        <!-- Description -->
                        <p class="text-lg md:text-xl text-gray-300 mb-8 leading-relaxed animate__animated animate__fadeIn animate__delay-2s">
                            <?php echo esc_html($settings['description']); ?>
                        </p>
                    <?php endif; ?>

                    <!-- Buttons Container -->
                    <div class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-4 animate__animated animate__fadeInUp animate__delay-3s">
                        <?php if (!empty($settings['primary_button_text']) && !empty($settings['primary_button_link']['url'])) : ?>
                            <!-- Primary Button -->
                            <a href="<?php echo esc_url($settings['primary_button_link']['url']); ?>"
                               class="inline-flex items-center px-8 py-3 rounded-lg text-lg font-semibold text-white transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
                               style="background-color: <?php echo $settings['accent_color']; ?>"
                               role="button"
                               <?php echo $settings['primary_button_link']['is_external'] ? 'target="_blank"' : ''; ?>
                               <?php echo $settings['primary_button_link']['nofollow'] ? 'rel="nofollow"' : ''; ?>>
                                <?php echo esc_html($settings['primary_button_text']); ?>
                                <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293- 4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($settings['secondary_button_text']) && !empty($settings['secondary_button_link']['url'])) : ?>
                            <!-- Secondary Button -->
                            <a href="<?php echo esc_url($settings['secondary_button_link']['url']); ?>"
                               class="inline-flex items-center px-8 py-3 rounded-lg text-lg font-semibold text-white border-2 border-white transition-all duration-300 hover:bg-white hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
                               role="button"
                               <?php echo $settings['secondary_button_link']['is_external'] ? 'target="_blank"' : ''; ?>
                               <?php echo $settings['secondary_button_link']['nofollow'] ? 'rel="nofollow"' : ''; ?>>
                                <?php echo esc_html($settings['secondary_button_text']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
        <style>
            .gdp-cta1 {
                background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5));
            }

            .bg-grid-pattern {
                background-image: url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"%3E%3Crect x="0" y="0" width="20" height="20" fill="%23fff" rx="2"/%3E%3C/svg%3E');
                background-size: 20px 20px;
            }
        </style>
        <?php
    }
}