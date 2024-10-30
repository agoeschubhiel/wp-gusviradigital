<?php
namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH')) exit;

class GDP_Pricing1 extends Widget_Base {
    public function get_name() { return 'gdp-pricing1'; }
    public function get_title() { return 'GDP Pricing 1'; }
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
                'default' => 'Choose your perfect plan',
            ]
        );

        $this->add_control(
            'section_description',
            [
                'label' => 'Section Description',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Start with our flexible pricing plans. No hidden fees, unlimited possibilities.',
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
                        'default' => 'Basic Plan',
                    ],
                    [
                        'name' => 'plan_subtitle',
                        'label' => 'Plan Subtitle',
                        'type' => Controls_Manager::TEXT,
                        'default' => 'Perfect for starters',
                    ],
                    [
                        'name' => 'plan_price',
                        'label' => 'Price',
                        'type' => Controls_Manager::TEXT,
                        'default' => '29',
                    ],
                    [
                        'name' => 'price_suffix',
                        'label' => 'Price Suffix',
                        'type' => Controls_Manager::TEXT,
                        'default' => '/month',
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
                                'default' => 'Feature item',
                            ],
                            [
                                'name' => 'is_included',
                                'label' => 'Included',
                                'type' => Controls_Manager::SWITCHER,
                                'default' => 'yes',
                            ],
                            [
                                'name' => 'is_highlighted',
                                'label' => 'Highlight',
                                'type' => Controls_Manager::SWITCHER,
                                'default' => 'no',
                            ],
                        ],
                    ],
                    [
                        'name' => 'button_text',
                        'label' => 'Button Text',
                        'type' => Controls_Manager::TEXT,
                        'default' => 'Get Started',
                    ],
                    [
                        'name' => 'button_link',
                        'label' => 'Button Link',
                        'type' => Controls_Manager::URL,
                        'placeholder' => 'https://your-link.com',
                        'default' => [
                            'url' => 'https://your-link.com',
                        ]
                    ],
                    [
                        'name' => 'recommended',
                        'label' => 'Recommended Plan',
                        'type' => Controls_Manager::SWITCHER,
                        'default' => 'no',
                    ],
                    [
                        'name' => 'highlight_text',
                        'label' => 'Highlight Text',
                        'type' => Controls_Manager::TEXT,
                        'default' => 'Most Popular',
                        'condition' => [
                            'recommended' => 'yes',
                        ],
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
                'default' => '#4F46E5',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>

        <div class="gdp-pricing1 py-24 bg-gradient-to-b from-gray-50 to-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl">
                        <?php echo esc_html($settings['section_title']); ?>
                    </h2>
                    <p class="mt-5 text-xl text-gray-500">
                        <?php echo esc_html($settings['section_description']); ?>
                    </p>
                </div>

                <!-- Pricing Grid -->
                <div class="grid gap-8 lg:grid-cols-3 lg:gap-x-8">
                    <?php foreach ($settings['pricing_plans'] as $index => $plan) : 
                        $isRecommended = $plan['recommended'] === 'yes';
                    ?>
                        <div class="relative flex flex-col p-8 bg-white border <?php echo $isRecommended ? 'border-primary ring-2 ring-primary' : 'border-gray-200'; ?> rounded-2xl shadow-sm transition-all hover:shadow-lg">
                            <?php if ($isRecommended) : ?>
                                <div class="absolute top-0 py-1.5 px-4 bg-primary transform -translate-y-1/2 rounded-full">
                                    <p class="text-xs font-semibold text-white uppercase tracking-wide">
                                        <?php echo esc_html($plan['highlight_text']); ?>
                                    </p>
                                </div>
                            <?php endif; ?>

                            <!-- Plan Header -->
                            <div class="mb-8">
                                <h3 class="text-2xl font-bold text-gray-900">
                                    <?php echo esc_html($plan['plan_name']); ?>
                                </h3>
                                <p class="mt-2 text-gray-500">
                                    <?php echo esc_html($plan['plan_subtitle']); ?>
                                </p>
                                <div class="mt-4 flex items-baseline">
                                    <span class="text-5xl font-extrabold tracking-tight text-gray-900">
                                        $<?php echo esc_html($plan['plan_price']); ?>
                                     </span>
                                    <span class="ml-1 text-xl font-semibold text-gray-500">
                                        <?php echo esc_html($plan['price_suffix']); ?>
                                    </span>
                                </div>
                            </div>

                            <!-- Features List -->
                            <ul class="space-y-4 flex-1">
                                <?php foreach ($plan['features'] as $feature) : 
                                    $isIncluded = $feature['is_included'] === 'yes';
                                    $isHighLighted = $feature['is_highlighted'] === 'yes';
                                ?>
                                    <li class="<?php echo $isHighLighted ? 'bg-orange-100 p-2 rounded' : ''; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                            <path fill="<?php echo $isIncluded ? 'currentColor' : 'none'; ?>" d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2Z"></path>
                                        </svg>
                                        <span class="<?php echo $isHighLighted ? 'text-orange-600' : 'text-gray-600'; ?>">
                                            <?php echo esc_html($feature['feature_text']); ?>
                                        </span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                            <!-- Call-to-Action Button -->
                            <a href="<?php echo esc_url($plan['button_link']['url']); ?>" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-<?php echo $isRecommended ? 'primary' : 'gray-800'; ?> hover:bg-<?php echo $isRecommended ? 'primary-dark' : 'gray-700'; ?> transition-all">
                                <?php echo esc_html($plan['button_text']); ?>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <?php
    }
}