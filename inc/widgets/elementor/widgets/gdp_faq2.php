<?php
namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Repeater;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class GDP_Faq2 extends Widget_Base {

    public function get_name() {
        return 'gdp-faq2';
    }

    public function get_title() {
        return 'GDP FAQ 2';
    }

    public function get_icon() {
        return 'eicon-accordion';
    }

    public function get_categories() {
        return ['gdp-widgets'];
    }

    public function get_script_depends() {
        return ['imagesloaded', 'gsap'];
    }

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
                'default' => 'FAQ',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'subtitle',
            [
                'label' => 'Subtitle',
                'type' => Controls_Manager::TEXT,
                'default' => 'Frequently Asked Questions',
                'label_block' => true,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'question',
            [
                'label' => 'Question',
                'type' => Controls_Manager::TEXT,
                'default' => 'What is your return policy?',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'answer',
            [
                'label' => 'Answer',
                'type' => Controls_Manager::WYSIWYG,
                'default' => 'Our return policy allows returns within 30 days of purchase...',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'is_active',
            [
                'label' => 'Initially Open',
                'type' => Controls_Manager::SWITCHER,
                'label_on' => 'Yes',
                'label_off' => 'No',
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'faq_items',
            [
                'label' => 'FAQ Items',
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'question' => 'What is your return policy?',
                        'answer' => 'Our return policy allows returns within 30 days of purchase...',
                        'is_active' => 'no',
                    ],
                    [
                        'question' => 'Do you offer international shipping?',
                        'answer' => 'Yes, we offer international shipping to most countries...',
                        'is_active' => 'no',
                    ],
                ],
                'title_field' => '{{{ question }}}',
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
            'layout_style',
            [
                'label' => 'Layout Style',
                'type' => Controls_Manager::SELECT,
                'default' => 'accordion',
                'options' => [
                    'accordion' => 'Accordion',
                    'grid' => 'Grid',
                    'tabs' => 'Tabs',
                ],
            ]
        );

        $this->add_control(
            'color_scheme',
            [
                'label' => 'Color Scheme',
                'type' => Controls_Manager::COLOR,
                'default' => '#4A90E2',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'question_typography',
                'label' => 'Question Typography',
                'selector' => '{{WRAPPER}} .gdp-faq-question',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'answer_typography',
                'label' => 'Answer Typography',
                'selector' => '{{WRAPPER}} .gdp-faq-answer',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $layout_style = $settings['layout_style'];
        $color_scheme = $settings['color_scheme'];
        ?>
        <div class="gdp-faq2 container mx-auto px-4 py-16">
            <div class="text-center mb-12">
                <h3 class="text-2xl font-bold text-gray-700 mb-2"><?php echo $settings['title']; ?></h3>
                <h2 class="text-4xl font-bold mb-4" style="color: <?php echo $color_scheme; ?>"><?php echo $settings['subtitle']; ?></h2>
            </div>

            <div class="gdp-faq-container <?php echo $layout_style; ?>-layout">
                <?php foreach ($settings['faq_items'] as $index => $item) : 
                    $isActive = $item['is_active'] === 'yes';
                ?>
                    <div class="gdp-faq-item mb-4" data-index="<?php echo $index; ?>">
                        <div class="gdp-faq-question p-4 bg-white rounded-lg shadow-md cursor-pointer flex justify-between items-center">
                            <span class="font-semibold"><?php echo $item['question']; ?></span>
                            <span class="gdp-faq-icon transform transition-transform duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </span>
                        </div>
                        <div class="gdp-faq-answer p-4 bg-gray-50 rounded-b-lg <?php echo $isActive ? 'active' : ''; ?>">
                            <?php echo $item['answer']; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <style>
            .gdp-faq2 .gdp-faq-question:hover {
                background-color: <?php echo $color_scheme; ?>;
                color: white;
            }
            .gdp-faq2  .gdp-faq-answer.active {
                max-height: 500px;
                transition: max-height 0.5s ease-in;
            }
        </style>

        <script>
            jQuery(document).ready(function($) {
                // FAQ Toggle functionality
                $('.gdp-faq-question').click(function() {
                    const $item = $(this).closest('.gdp-faq-item');
                    const $answer = $item.find('.gdp-faq-answer');
                    const $icon = $(this).find('.gdp-faq-icon');

                    // Toggle current item
                    $answer.slideToggle(300);
                    $icon.toggleClass('rotate-45');

                    // Optional: Close other items
                    $('.gdp-faq-item').not($item).find('.gdp-faq-answer').slideUp(300);
                    $('.gdp-faq-item').not($item).find('.gdp-faq-icon').removeClass('rotate-45');
                });

                // Set initial state for active items
                $('.gdp-faq-item').each(function() {
                    if ($(this).find('.gdp-faq-answer').hasClass('active')) {
                        $(this).find('.gdp-faq-answer').show();
                    }
                });
            });
        </script>
        <?php
    }
}