<?php
namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH')) exit;

class Gdp_hero5 extends Widget_Base {

    public function get_name() {
        return 'gdp_hero5';
    }

    public function get_title() {
        return __('GDP Creative Hero 5', 'gdp');
    }

    public function get_icon() {
        return 'eicon-header';
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
            'pre_title',
            [
                'label' => __('Pre Title', 'gdp'),
                'type' => Controls_Manager::TEXT,
                'default' => __('CREATIVE AGENCY', 'gdp'),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'gdp'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('Innovate. Create.<br>Inspire.', 'gdp'),
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __('Description', 'gdp'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('We blend creativity and technology to deliver exceptional digital experiences that drive results and inspire audiences.', 'gdp'),
            ]
        );

        $this->add_control(
            'stats_items',
            [
                'label' => __('Stats Items', 'gdp'),
                'type' => Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'number',
                        'label' => __('Number', 'gdp'),
                        'type' => Controls_Manager::TEXT,
                        'default' => '100+',
                    ],
                    [
                        'name' => 'label',
                        'label' => __('Label', 'gdp'),
                        'type' => Controls_Manager::TEXT,
                        'default' => 'Projects Completed',
                    ],
                ],
                'default' => [
                    [
                        'number' => '100+',
                        'label' => 'Projects Completed',
                    ],
                    [
                        'number' => '50+',
                        'label' => 'Happy Clients',
                    ],
                    [
                        'number' => '10+',
                        'label' => 'Years Experience',
                    ],
                ],
            ]
        );

        $this->add_control(
            'primary_button_text',
            [
                'label' => __('Primary Button Text', 'gdp'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Start Project', 'gdp'),
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
                'default' => __('Watch Showreel', 'gdp'),
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
            'hero_image',
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

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'title_text_shadow',
                'selector' => '{{WRAPPER}} .hero-title',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="relative min-h-screen flex flex-col lg:flex-row overflow-hidden">
            <!-- Left Content Section -->
            <div class="w-full lg:w-1/2 bg-gradient-to-br from-blue-900 to-purple-900 p-8 lg:p-16 flex items-center">
                <div class="max-w-2xl mx-auto">
                    <span class="inline-block px-4 py-2 bg-blue-500/20 text-blue-300 rounded-full text-sm font-semibold tracking-wider mb-6 animate__animated animate__fadeInDown">
                        <?php echo esc_html($settings['pre_title']); ?>
                    </span>

                    <h1 class="hero-title text-4xl lg:text-6xl font-bold text-white leading-tight mb-6 animate__animated animate__fadeInUp">
                        <?php echo wp_kses_post($settings['title']); ?>
                    </h1>

                    <p class="text-lg text-gray-300 mb-8 animate__animated animate__fadeInUp animate__delay-1s">
                        <?php echo esc_html($settings['description']); ?>
                    </p>

                    <!-- Stats Section -->
                    <div class="grid grid-cols-3 gap-8 mb-12 animate__animated animate__fadeInUp animate__delay-2s">
                        <?php foreach ($settings['stats_items'] as $item) : ?>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-white mb-2"><?php echo esc_html($item['number']); ?></div>
                                <div class="text-sm text-gray-300"><?php echo esc_html($item['label']); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-wrap gap-4 animate__animated animate__fadeInUp animate__delay-3s">
                        <?php if ($settings['primary_button_text']) : ?>
                            <a href="<?php echo esc_url($settings['primary_button_link']['url']); ?>" 
                               class="group relative inline-flex items-center px-8 py-4 bg- amber-500 text-white font-bold rounded-full shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110">
                                <?php echo esc_html($settings['primary_button_text']); ?>
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        <?php endif; ?>

                        <?php if ($settings['secondary_button_text']) : ?>
                            <a href="<?php echo esc_url($settings['secondary_button_link']['url']); ?>" 
                               class="group relative inline-flex items-center px-8 py-4 bg-gray-200 text-gray-600 font-bold rounded-full shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110">
                                <?php echo esc_html($settings['secondary_button_text']); ?>
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Right Image Section -->
            <div class="w-full lg:w-1/2 bg-gray-100 p-8 lg:p-16 flex items-center justify-center overflow-hidden">
                <img src="<?php echo esc_url($settings['hero_image']['url']); ?>" alt="Hero Image" class="max-w-full max-h-full object-cover rounded-lg shadow-2xl animate__animated animate__zoomIn">
            </div>
        </div>
        <style>
            @keyframes fadeInDown {
                from { opacity: 0; transform: translateY(-50px); }
                to { opacity: 1; transform: translateY(0); }
            }
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(50px); }
                to { opacity: 1; transform: translateY(0); }
            }
            @keyframes zoomIn {
                from { opacity: 0; transform: scale(0.8); }
                to { opacity: 1; transform: scale(1); }
            }
            .animate__animated {
                animation-duration: 1s;
                animation-fill-mode: both;
            }
            .animate__fadeInDown {
                animation-name: fadeInDown;
            }
            .animate__fadeInUp {
                animation-name: fadeInUp;
            }
            .animate__zoomIn {
                animation-name: zoomIn;
            }
            .animate__delay-1s {
                animation-delay: 1s;
            }
            .animate__delay-2s {
                animation-delay: 2s;
            }
            .animate__delay-3s {
                animation-delay: 3s;
            }
        </style>
        <?php
    }
}