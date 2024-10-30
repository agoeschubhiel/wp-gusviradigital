<?php
namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Gdp_service4 extends Widget_Base {

    public function get_name() {
        return 'gdp_service4';
    }

    public function get_title() {
        return 'GDP Clean Services';
    }

    public function get_icon() {
        return 'eicon-archive';
    }

    public function get_categories() {
        return ['gdp-category'];
    }

    protected function register_controls() {
        // Content Section
        $this->start_controls_section(
            'content_section',
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
                'default' => 'Our Exceptional Services',
            ]
        );

        $this->add_control(
            'section_subtitle',
            [
                'label' => 'Section Subtitle',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Explore the services we offer to enhance your business.',
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'service_image',
            [
                'label' => 'Service Image',
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'service_title',
            [
                'label' => 'Service Title',
                'type' => Controls_Manager::TEXT,
                'default' => 'Service Title',
            ]
        );

        $repeater->add_control(
            'service_description',
            [
                'label' => 'Service Description',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Service description goes here.',
            ]
        );

        $repeater->add_control(
            'service_icon',
            [
                'label' => 'Icon Class',
                'type' => Controls_Manager::TEXT,
                'default' => 'fas fa-star',
                'description' => 'Enter FontAwesome icon class',
            ]
        );

        $repeater->add_control(
            'button_text',
            [
                'label' => 'Button Text',
                'type' => Controls_Manager::TEXT,
                'default' => 'Learn More',
            ]
        );

        $repeater->add_control(
            'button_link',
            [
                'label' => 'Button Link',
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://your-link.com',
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $repeater->add_control(
            'animation_delay',
            [
                'label' => 'Animation Delay',
                'type' => Controls_Manager::NUMBER,
                'default' => 0,
                'min' => 0,
                'max' => 1000,
                'step' => 100,
            ]
        );

        $this->add_control(
            'services_list',
            [
                'label' => 'Services',
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'service_title' => 'Consulting',
                        'service_description' => 'Expert advice to help you achieve your business goals.',
                    ],
                    [
                        'service_title' => 'Design',
                        'service_description' => 'Creative designs that capture your brand essence.',
                    ],
                    [
                        'service_title' => 'Support',
                        'service_description' => 'Reliable support to ensure your success.',
                    ],
                ],
                'title_field' => '{{{ service_title }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="gdp-services-section py-24 relative overflow-hidden bg-gradient-to-br from-blue-50 to-indigo-100">
            <!-- Animated Background Elements -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-1/2 -left-1/4 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
                <div class="absolute -bottom-1/2 -right-1/4 w-96 h-96 bg-yellow-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
                <div class="absolute top-1/2 left-1/2 w-96 h-96 bg-pink-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
            </div>

            <div class="container mx-auto px-4 relative z-10">
                <!-- Section Header with Animation -->
                <div class="text-center mb-20" data-aos="fade-up">
                    <span class="text-indigo-600 font-semibold text-sm tracking-wider uppercase mb-4 block" data-aos="fade-up" data-aos-delay="100">
                        Our Services
                    </span>
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6" data-aos="fade-up" data-aos-delay="200">
                        <?php echo wp_kses_post($settings['section_title']); ?>
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="300">
                        <?php echo wp_kses_post($settings['section_subtitle']); ?>
                    </p>
                </div>

                <!-- Services Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($settings['services_list'] as $index => $service) : 
                        $link = $service['button_link'];
                        $target = $link['is_external'] ? ' target="_blank"' : '';
                        $nofollow = $link['nofollow'] ? ' rel="nofollow"' : '';
                    ?>
                        <div class="group" data-aos="fade-up" data-aos-delay="<?php echo esc_attr($service['animation_delay']); ?>">
                            <div class="relative overflow-hidden bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                                <!-- Service Image with Overlay -->
                                <div class="relative h-64 overflow-hidden">
                                    <img src="<?php echo esc_url($service['service_image']['url']); ?>" 
                                         alt="<?php echo esc_attr($service['service_title']); ?>"
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                </div>

                                <!-- Icon Badge -->
                                <div class="absolute top-4 right-4 w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg transform -translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                    <i class="<?php echo esc_attr($service['service_icon']); ?> text-indigo-600 text-xl"></i>
                                </div>

                                <!-- Content -->
                                <div class="p-8">
                                    <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-indigo-600 transition-colors duration-300">
                                        <?php echo wp_kses_post($service['service_title']); ?>
                                    </h3>
                                    <p class="text-gray-600 mb-6 line-clamp-3">
                                        <?php echo wp_kses_post($service['service_description']); ?>
                                    </p>
                                    
                                    <!-- Action Button -->
                                    <a href="<?php echo esc_url($link['url']); ?>" 
                                       class="inline-flex items-center text-indigo-600 font-semibold group-hover:text-indigo-800 transition-colors duration-300"
                                       <?php echo $target . $nofollow; ?>>
                                        <?php echo esc_html($service['button_text']); ?>
                                        <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <style>
            @keyframes blob {
                0% { transform: translate(0px, 0px) scale(1); }
                33% { transform: translate(30px, -50px) scale(1.1); }
                66% { transform: translate(-20px, 20px) scale(0.9); }
                100% { transform: translate(0px, 0px) scale(1); }
            }
            .animate-blob {
                animation: blob 7s infinite;
            }
            .animation-delay-2000 {
                 animation-delay: 2000ms;
            }
            .animation-delay-4000 {
                 animation-delay: 4000ms;
            }
        </style>
<?php
    }
}