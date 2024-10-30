<?php
namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Utils;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Gdp_service1 extends Widget_Base {

    public function get_name() {
        return 'gdp_service1';
    }

    public function get_title() {
        return 'GDP Creative Services';
    }

    public function get_icon() {
        return 'eicon-apps';
    }

    public function get_categories() {
        return ['gdp-category'];
    }

    public function get_script_depends() {
        return ['gsap', 'scrolltrigger'];
    }

    protected function register_controls() {
        // Header Section
        $this->start_controls_section(
            'header_section',
            [
                'label' => 'Header',
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => 'Title',
                'type' => Controls_Manager::TEXT,
                'default' => 'Our Creative Services',
            ]
        );

        $this->add_control(
            'subtitle',
            [
                'label' => 'Subtitle',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Transforming ideas into digital excellence with our comprehensive creative solutions',
            ]
        );

        $this->end_controls_section();

        // Services Section
        $this->start_controls_section(
            'services_section',
            [
                'label' => 'Services',
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'service_icon',
            [
                'label' => 'Service Icon',
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-pencil-alt',
                    'library' => 'solid',
                ],
            ]
        );

        $repeater->add_control(
            'service_title',
            [
                'label' => 'Service Title',
                'type' => Controls_Manager::TEXT,
                'default' => 'Creative Design',
            ]
        );

        $repeater->add_control(
            'service_description',
            [
                'label' => 'Service Description',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Crafting visually stunning designs that capture your brand essence and engage your audience.',
            ]
        );

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
            'service_features',
            [
                'label' => 'Service Features',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Feature 1|Feature 2|Feature 3',
                'description' => 'Enter features separated by |',
            ]
        );

        $repeater->add_control(
            'service_link',
            [
                'label' => 'Service Link',
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://your-link.com',
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
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
                        'service_title' => 'UI/UX Design',
                        'service_description' => 'Creating intuitive and engaging user experiences that delight your customers.',
                        'service_features' => 'User Research|Wireframing|Prototyping|User Testing',
                        'service_link' => ['url' => '#'],
                    ],
                    [
                        'service_title' => 'Brand Strategy',
                        'service_description' => 'Developing comprehensive brand strategies that set you apart from competitors.',
                        'service_features' => 'Brand Identity|Market Research|Positioning|Guidelines',
                        'service_link' => ['url' => '#'],
                    ],
                    [
                        'service_title' => 'Digital Marketing',
                        'service_description' => 'Driving growth through targeted digital marketing campaigns.',
                        'service_features' => 'SEO|Social Media|Content Marketing|Analytics',
                        'service_link' => ['url' => '#'],
                    ],
                ],
                'title_field' => '{{{ service_title }}}',
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => 'Style',
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => 'Title Typography',
                'selector' => '{{WRAPPER}} .gdp-service-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => 'Description Typography',
                'selector' => '{{WRAPPER}} .gdp-service-description',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="gdp-services-section bg-gradient-to-b from-gray-100 to-white py-20">
            <div class="container mx-auto px-4">
                <!-- Header -->
                <div class="text-center mb-16">
                    <h2 class="gdp-service-title text-4xl font-bold mb-6 animate__animated animate__fadeInDown">
                        <?php echo $settings['title']; ?>
                    </h2>
                    <p class="gdp-service-description text-xl text-gray-600 max-w-3xl mx-auto animate__animated animate__fadeInUp">
                        <?php echo $settings['subtitle']; ?>
                    </p>
                </div>

                <!-- Services Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($settings['services_list'] as $index => $service) : 
                        $features = explode('|', $service['service_features']);
                        $link_url = $service['service_link']['url'];
                        $link_target = $service['service_link']['is_external'] ? ' target="_blank"' : '';
                        $link_nofollow = $service['service_link']['nofollow'] ? ' rel="nofollow"' : '';
                    ?>
                        <a href="<?php echo esc_url($link_url); ?>"<?php echo $link_target . $link_nofollow ; ?>>
                            <div class="service-card bg-white rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl"
                                 data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                                
                                <!-- Service Image -->
                                <div class="relative h-48 overflow-hidden">
                                    <img src="<?php echo $service['service_image']['url']; ?>" 
                                         alt="<?php echo $service['service_title']; ?>"
                                         class="w-full h-full object-cover transform transition-transform duration-500 hover:scale-110">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                                </div>

                                <!-- Service Content -->
                                <div class="p-6">
                                    <div class="text-3xl text-blue-500 mb-4">
                                        <?php \Elementor\Icons_Manager::render_icon($service['service_icon'], ['aria-hidden' => 'true']); ?>
                                    </div>
                                     <h3 class="text-2xl font-bold mb-4">
                                        <?php echo $service['service_title']; ?>
                                    </h3>

                                    <p class="text-lg text-gray-600 mb-8">
                                        <?php echo $service['service_description']; ?>
                                    </p>

                                    <!-- Service Features -->
                                    <ul class="list-none mb-8">
                                        <?php foreach ($features as $feature) : ?>
                                            <li class="flex items-center mb-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                                    <path fill="none" d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2Z"></path>
                                                </svg>
                                                <span class="text-lg text-gray-600 ml-2">
                                                    <?php echo $feature; ?>
                                                </span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php
    }
}