<?php
namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

if (!defined('ABSPATH')) exit;

class Gdp_hero1 extends Widget_Base {

    public function get_name() {
        return 'gdp_hero1';
    }

    public function get_title() {
        return __('GDP Hero 1', 'gdp');
    }

    public function get_icon() {
        return 'eicon-banner';
    }

    public function get_categories() {
        return ['gdp_widget'];
    }

    protected function register_controls() {
        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'gdp'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'gdp'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Unleash Your Creativity', 'gdp'),
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __('Description', 'gdp'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('We turn your ideas into captivating digital experiences', 'gdp'),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __('Button Text', 'gdp'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Start Your Project', 'gdp'),
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label' => __('Button Link', 'gdp'),
                'type' => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'gdp'),
            ]
        );

        $this->add_control(
            'background_image',
            [
                'label' => __('Background Image', 'gdp'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Style', 'gdp'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __('Title Typography', 'gdp'),
                'selector' => '{{WRAPPER}} .gdp-hero-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => __('Description Typography', 'gdp'),
                'selector' => '{{WRAPPER}} .gdp-hero-description',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Title Color', 'gdp'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gdp-hero-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => __('Description Color', 'gdp'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gdp-hero-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => __('Button Color', 'gdp'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gdp-hero-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="gdp-creative-hero relative min-h-screen flex items-center overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img src="<?php echo esc_url($settings['background_image']['url']); ?>" alt="Background" class="object-cover w-full h-full bg-no-repeat">
                <div class="absolute inset-0 bg-black opacity-50"></div>
            </div>
            <div class="container mx-auto px-4 z-10">
                <div class="max-w-3xl relative">
                    <h1 class="gdp-hero-title text-5xl font-bold mb-6 transform transition-all duration-700 translate-y-20 opacity-0">
                        <?php echo esc_html($settings['title']); ?>
                    </h1>
                    <p class="gdp-hero-description text-xl mb-8 transform transition-all duration-700 delay-200 translate-y-20 opacity-0">
                        <?php echo esc_html($settings['description']); ?>
                    </p>
                    <?php if ($settings['button_text']) : ?>
                        <a href="<?php echo esc_url($settings['button_link']['url']); ?>" 
                           class="gdp-hero-button inline-block font-semibold px-8 py-3 rounded-lg transition duration-300 transform hover:scale-105 opacity-0"
                           <?php echo $settings['button_link']['is_external'] ? 'target="_blank"' : ''; ?>>
                            <?php echo esc_html($settings['button_text']); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const title = document.querySelector('.gdp-hero-title');
            const description = document.querySelector('.gdp-hero-description');
            const button = document.querySelector('.gdp-hero-button');

            setTimeout(() => {
                title.style.transform = 'translateY(0)';
                title.style.opacity = '1';
            }, 300);

            setTimeout(() => {
                description.style.transform = 'translateY(0)';
                description.style.opacity = '1';
            }, 600);

            setTimeout(() => {
                button.style.opacity = '1';
            }, 900);
        });
        </script>
        <?php
    }
}