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

class GDP_Faq1 extends Widget_Base {

    public function get_name() {
        return 'gdp-faq1';
    }

    public function get_title() {
        return 'GDP FAQ 1';
    }

    public function get_icon() {
        return 'eicon-help-o';
    }

    public function get_categories() {
        return ['gdp-widgets'];
    }

    public function get_script_depends() {
        return ['imagesloaded', 'aos'];
    }

    public function get_style_depends() {
        return ['animate-css', 'aos'];
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
                'default' => 'Frequently Asked Questions',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => 'Description',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Find answers to common questions about our services',
                'label_block' => true,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'question',
            [
                'label' => 'Question',
                'type' => Controls_Manager::TEXT,
                'default' => 'What services do you offer?',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'answer',
            [
                'label' => 'Answer',
                'type' => Controls_Manager::WYSIWYG,
                'default' => 'We offer a wide range of services including...',
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

        $repeater->add_control(
            'custom_icon',
            [
                'label' => 'Custom Icon',
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-plus',
                    'library' => 'solid',
                ],
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
                        'question' => 'What services do you offer?',
                        'answer' => 'We offer a comprehensive range of services including web design, development, and digital marketing solutions.',
                        'is_active' => 'no',
                    ],
                    [
                        'question' => 'How long does it take to complete a project?',
                        'answer' => 'Project timelines vary depending on complexity and scope. We\'/ll provide a  detailed timeline during our initial consultation.',
                        'is_active' => 'no',
                    ],
                    [
                        'question' => 'What is your pricing structure?',
                        'answer' => 'Our pricing is project-based and depends on your specific needs. Contact us for a custom quote.',
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
                'default' => 'cards',
                'options' => [
                    'cards' => 'Cards Style',
                    'minimal' => 'Minimal Style',
                    'bordered' => 'Bordered Style',
                ],
            ]
        );

        $this->add_control(
            'animation_effect',
            [
                'label' => 'Animation Effect',
                'type' => Controls_Manager::SELECT,
                'default' => 'fade-up',
                'options' => [
                    'fade-up' => 'Fade Up',
                    'fade-down' => 'Fade Down',
                    'fade-left' => 'Fade Left',
                    'fade-right' => 'Fade Right',
                    'zoom-in' => 'Zoom In',
                    'zoom-out' => 'Zoom Out',
                ],
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

        $this->add_control(
            'question_color',
            [
                'label' => 'Question Color',
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .gdp-faq-question' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'answer_color',
            [
                'label' => 'Answer Color',
                'type' => Controls_Manager::COLOR,
                'default' => '#666666',
                'selectors' => [
                    '{{WRAPPER}} .gdp-faq-answer' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_box_shadow',
                'label' => 'Box Shadow',
                'selector' => '{{WRAPPER}} .gdp-faq-item',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'label' => 'Border',
                'selector' => '{{WRAPPER}} .gdp-faq-item',
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => 'Border Radius',
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .gdp-faq-item' => ' border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $layout_style = $settings['layout_style'];
        ?>
        <div class="gdp-faq1 container mx-auto px-4 py-16">
            <!-- Header Section -->
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-4xl font-bold mb-4"><?php echo $settings['title']; ?></h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto"><?php echo $settings['description']; ?></p>
            </div>

            <!-- FAQ Items -->
            <div class="max-w-4xl mx-auto">
                <?php foreach ($settings['faq_items'] as $index => $item) : 
                    $isActive = $item['is_active'] === 'yes';
                    $itemClass = $layout_style === 'cards' ? 'bg-white shadow-lg' : 
                                ($layout_style === 'bordered' ? 'border border-gray-200' : 'border-b border-gray-200');
                ?>
                    <div class="gdp-faq-item mb-4 rounded-lg overflow-hidden <?php echo $itemClass; ?>" 
                        data-aos="<?php echo $settings['animation_effect']; ?>" 
                        data-aos-delay="<?php echo $index * 100; ?>">
                        
                        <!-- Question -->
                        <button class="gdp-faq-question w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition-all duration-300 <?php echo $isActive ? 'bg-gray-50' : ''; ?>">
                            <span class="text-lg font-semibold pr-8"><?php echo $item['question']; ?></span>
                            <span class="gdp-faq-icon transform transition-transform duration-300 <?php echo $isActive ? 'rotate-45' : ''; ?>">
                                <?php \Elementor\Icons_Manager::render_icon($item['custom_icon'], ['aria-hidden' => 'true', 'class' => 'text-xl']); ?>
                            </span>
                        </button>

                        <!-- Answer -->
                        <div class="gdp-faq-answer px-6 pt-2 pb-12 text-gray-600 <?php echo $isActive ? 'block' : 'hidden'; ?>">
                            <?php echo $item['answer']; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <style>
            /* Custom Styles */
            .gdp-faq1 .gdp-faq-item {
                transition: all 0.3s ease;
            }

            .gdp-faq1 .gdp-faq-item:hover {
                transform: translateY(-2px);
            }

            .gdp-faq1 .gdp-faq-answer {
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease-out;
            }

            .gdp-faq1 .gdp-faq-answer.active {
                max-height: 500px;
                transition: max-height 0.5s ease-in;
            }

            /* Layout Specific Styles */
            .gdp-faq1 .cards-style {
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }

            .gdp-faq1 .minimal-style {
                background: transparent;
            }

            .gdp-faq1 .bordered-style {
                border-width: 1px;
            }

            @media (max-width: 768px) {
                .gdp-faq1 .gdp-faq-question {
                    font-size: 1rem;
                }
            }
        </style>

        <script>
            jQuery(document).ready(function($) {
                // Initialize AOS
                AOS.init({
                    duration: 1000,
                    once: true
                });

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
                    if ($(this).find('.gdp-faq-answer').hasClass('block')) {
                        $(this).find('.gdp-faq-answer').show();
                    }
                });
            });
        </script>
        <?php
    }

}