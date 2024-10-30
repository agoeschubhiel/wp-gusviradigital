<?php
namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class GDP_Pricing2 extends Widget_Base {
    public function get_name() { return 'gdp-pricing2'; }
    public function get_title() { return 'GDP Pricing 2'; }
    public function get_icon() { return 'eicon-price-table'; }
    public function get_categories() { return ['gdp-widgets']; }

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
                'default' => 'Our <span class="text-primary">Pricing</span>',
            ]
        );

        $this->add_control(
            'section_description',
            [
                'label' => 'Section Description',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Unlock your potential with our cutting-edge equipment and professional guidance. Start your fitness journey today for a better tomorrow.',
            ]
        );

        $this->add_control(
            'pricing_plans',
            [
                'label' => 'Pricing Plans',
                'type' => Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'plan_name',
                        'label' => 'Plan Name',
                        'type' => Controls_Manager::TEXT,
                        'default' => 'Silver',
                    ],
                    [
                        'name' => 'plan_description',
                        'label' => 'Plan Description',
                        'type' => Controls_Manager::TEXTAREA,
                        'default' => 'Ideal for getting started with mobile funnels and achieving your first successes.',
                    ],
                    [
                        'name' => 'plan_price',
                        'label' => 'Price',
                        'type' => Controls_Manager::TEXT,
                        'default' => '19',
                    ],
                    [
                        'name' => 'price_suffix',
                        'label' => 'Price Suffix',
                        'type' => Controls_Manager::TEXT,
                        'default' => '/month',
                    ],
                    [
                        'name' => 'billing_period',
                        'label' => 'Billing Period',
                        'type' => Controls_Manager::TEXT,
                        'default' => 'Billed annually',
                    ],
                    [
                        'name' => 'features',
                        'label' => 'Features',
                        'type' => Controls_Manager::REPEATER,
                        'fields' => [
                            [
                                'name' => 'feature_text',
                                'label' => 'Feature',
                                'type' => Controls_Manager::TEXT,
                                'default' => 'Access to all basic features',
                            ],
                        ],
                    ],
                    [
                        'name' => 'button_text',
                        'label' => 'Button Text',
                        'type' => Controls_Manager::TEXT,
                        'default' => 'Buy Membership',
                    ],
                    [
                        'name' => 'button_link',
                        'label' => 'Button Link',
                        'type' => Controls_Manager::URL,
                        'placeholder' => 'https://your-link.com',
                    ],
                    [
                        'name' => 'recommended',
                        'label' => 'Recommended Plan',
                        'type' => Controls_Manager::SWITCHER,
                        'default' => 'no',
                    ],
                ],
                'title_field' => '{{{ plan_name }}}',
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
            'primary_color',
            [
                'label' => 'Primary Color',
                'type' => Controls_Manager::COLOR,
                'default' => '#EF4444',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>

        <div class="gdp-pricing2 bg-white py-24" data-aos="fade-up">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16" data-aos="fade-up" data-aos-delay="100">
                    <h2 class="text-3xl font-bold mb-4"><?php echo wp_kses_post($settings['section_title']); ?></h2>
                    <p class="text-gray-600 max-w-2xl mx-auto"><?php echo esc_html($settings['section_description']); ?></p>
                </div>

                <div class="flex flex-wrap justify-center gap-8">
                    <?php foreach ($settings['pricing_plans'] as $index => $plan) : 
                        $isRecommended = $plan['recommended'] === 'yes';
                    ?>
                        <div class="bg-white rounded-lg shadow-lg p-8 w-full md:w-80 transition-all duration-300 hover:shadow-xl <?php echo $isRecommended ? 'border-2 border-primary' : ''; ?>" data-aos="fade-up" data-aos-delay="<?php echo 200 + $index * 100; ?>">
                            <?php if ($isRecommended) : ?>
                                <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white text-primary border border-primary rounded-full px-4 py-1 text-sm font-bold">Recommended</div>
                            <?php endif; ?>

                            <h3 class="text-xl font-bold text-gray-800 mb-4"><?php echo esc_html($plan['plan_name']); ?></h3>
                            <p class="text-gray-600 mb-4"><?php echo esc_html($plan['plan_description']); ?></p>
                            <div class="text-3xl font-bold text-primary mb-2">
                                $<?php echo esc_html($plan['plan_price']); ?><span class="text-lg font-normal"><?php echo esc_html($plan['price_suffix']); ?></span>
                            </div>
                            <p class="text-gray-600 mb-4"><?php echo esc_html($plan['billing_period']); ?></p>
                            
                            <ul class="text-gray-600 mb-6 space-y-0.5">
                                <?php foreach ($plan['features'] as $feature) : ?>
                                    <li class="list-none">
                                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                        <?php echo esc_html($feature['feature_text']); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            
                            <a href="<?php echo esc_url($plan['button_link']['url']); ?>" class="block w-full text-center bg-<?php echo $isRecommended ? 'primary' : 'gray-800'; ?> hover:bg-<?php echo $isRecommended ? 'primary-dark' : 'gray-700'; ?> text-white font-bold py-2 rounded-lg transition-all duration-300" target="<?php echo esc_attr($plan['button_link']['is_external'] ? '_blank' : '_self'); ?>"><?php echo esc_html($plan['button_text']); ?></a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <?php
    }
}