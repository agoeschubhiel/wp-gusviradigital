<?php
namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit;

class Gdp_hero2 extends Widget_Base {

    public function get_name() {
        return 'gdp_hero2';
    }

    public function get_title() {
        return __('GDP Creative Hero 2', 'gdp');
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
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('We Create Digital<br>Experiences', 'gdp'),
            ]
        );

        $this->add_control(
            'subtitle',
            [
                'label' => __('Subtitle', 'gdp'),
                'type' => Controls_Manager::TEXT,
                'default' => __('WELCOME TO OUR CREATIVE AGENCY', 'gdp'),
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __('Description', 'gdp'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('We are a full-service creative agency specializing in helping brands grow fast. Engage your clients through compelling visuals that do most of the marketing for you.', 'gdp'),
            ]
        );

        $this->add_control(
            'primary_button_text',
            [
                'label' => __('Primary Button Text', 'gdp'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Get Started', 'gdp'),
            ]
        );

        $this->add_control(
            'primary_button_link',
            [
                'label' => __('Primary Button Link', 'gdp'),
                'type' => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'gdp'),
            ]
        );

        $this->add_control(
            'secondary_button_text',
            [
                'label' => __('Secondary Button Text', 'gdp'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Learn More', 'gdp'),
            ]
        );

        $this->add_control(
            'secondary_button_link',
            [
                'label' => __('Secondary Button Link', 'gdp'),
                'type' => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'gdp'),
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => __('Hero Image', 'gdp'),
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
                'selector' => '{{WRAPPER}} .hero-title',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="relative min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
            <div class="container mx-auto px-4 py-20">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div class="space-y-8 animate__animated animate__fadeInLeft">
                        <div class="inline-block px-4 py-2 bg-blue-100 rounded-full animate__animated animate__bounceIn">
                            <span class="text-blue-600 font-medium tracking-wider text-sm">
                                <?php echo esc_html($settings['subtitle']); ?>
                            </span>
                        </div>
                        
                        <h1 class="hero-title text-5xl md:text-6xl font-bold leading-tight animate__animated animate__fadeIn Up">
                            <?php echo wp_kses_post($settings['title']); ?>
                        </h1>
                        
                        <p class="text-xl text-gray-600 leading-relaxed animate__animated animate__fadeInUp">
                            <?php echo esc_html($settings['description']); ?>
                        </p>
                        
                        <div class="flex flex-wrap gap-4">
                            <?php if ($settings['primary_button_text']) : ?>
                                <a href="<?php echo esc_url($settings['primary_button_link']['url']); ?>" 
                                   class="inline-block px-8 py-4 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-300 transform hover:scale-105 animate__animated animate__fadeInUp">
                                    <?php echo esc_html($settings['primary_button_text']); ?>
                                </a>
                            <?php endif; ?>

                            <?php if ($settings['secondary_button_text']) : ?>
                                <a href="<?php echo esc_url($settings['secondary_button_link']['url']); ?>" 
                                   class="inline-block px-8 py-4 bg-transparent border-2 border-gray-800 text-gray-800 font-semibold rounded-lg hover:bg-gray-800 hover:text-white transition duration-300 animate__animated animate__fadeInUp">
                                    <?php echo esc_html($settings['secondary_button_text']); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="relative animate__animated animate__fadeInRight">
                        <div class="absolute inset-0 bg-blue-200 rounded-full filter blur-3xl opacity-20 animate-pulse"></div>
                        <img src="<?php echo esc_url($settings['image']['url']); ?>" 
                             alt="<?php echo esc_attr($settings['title']); ?>"
                             class="relative rounded-2xl shadow-2xl w-full transform hover:scale-105 transition duration-500 animate__animated animate__fadeInUp">
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}