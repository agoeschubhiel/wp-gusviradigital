<?php
namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Repeater;

if (!defined('ABSPATH')) exit;

class GDP_Faq3 extends Widget_Base {
    public function get_name() { return 'gdp-faq3'; }
    public function get_title() { return 'GDP FAQ 3'; }
    public function get_icon() { return 'eicon-toggle'; }
    public function get_categories() { return ['gdp-widgets']; }

    public function get_script_depends() {
        return ['gdp-faq3-scripts'];
    }

    public function get_style_depends() {
        return ['gdp-faq3-styles'];
    }

    protected function register_controls() {
        // Brand Settings Section
        $this->start_controls_section(
            'section_brand',
            [
                'label' => 'Brand Settings',
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'brand_color_primary',
            [
                'label' => 'Primary Brand Color',
                'type' => Controls_Manager::COLOR,
                'default' => '#4A90E2',
            ]
        );

        $this->add_control(
            'brand_color_secondary',
            [
                'label' => 'Secondary Brand Color',
                'type' => Controls_Manager::COLOR,
                'default' => '#34495E',
            ]
        );

        $this->end_controls_section();

        // Header Section
        $this->start_controls_section(
            'section_header',
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
                'default' => 'Frequently Asked Questions',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'subtitle',
            [
                'label' => 'Subtitle',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Find answers to common questions about our services',
            ]
        );

        $this->end_controls_section();

        // FAQ Items Section
        $this->start_controls_section(
            'section_faq_items',
            [
                'label' => 'FAQ Items',
                'tab' => Controls_Manager::TAB_CONTENT,
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
                'default' => 'We offer a comprehensive range of services...',
            ]
        );

        $repeater->add_control(
            'icon',
            [
                'label' => 'Icon',
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-question-circle',
                    'library' => 'fa-solid',
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
                        'answer' => 'We offer a comprehensive range of services...',
                    ],
                ],
                'title_field' => '{{{ question }}}',
            ]
        );

        $this->end_controls_section();

        // Layout Settings
        $this->start_controls_section(
            'section_layout',
            [
                'label' => 'Layout Settings',
                'tab' => Controls_Manager::TAB_CONTENT,
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

        $this->end_controls_section();

        // Advanced Settings
        $this->start_controls_section(
            'section_advanced',
            [
                'label' => 'Advanced Settings',
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'schema_markup',
            [
                'label' => 'Enable Schema Markup',
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $id_int = substr($this->get_id(), 0, 3);
        ?>
        <div class="gdp-faq3 container mx-auto px-4 py-16" data-layout="<?= $settings['layout_style']; ?>">
            <div class="text-center mb-12 animate-fade-in">
                <h2 class="text-4xl font-bold mb-4" style="color: <?= $settings['brand_color_primary']; ?>"><?= $settings['title']; ?></h2>
                <p class="text-xl text-gray-600"><?= $settings['subtitle']; ?></p>
            </div>

            <?php if ($settings['layout_style'] === 'accordion') : ?>
                <div class="gdp-faq-container accordion-layout">
                    <?php foreach ($settings['faq_items'] as $index => $item) : ?>
                        <div class="gdp-faq-item mb-4 animate-slide-up" data-index="<?= $index; ?>">
                            <div class="gdp-faq-question p-4 bg-white rounded-lg shadow-md cursor-pointer flex justify-between items-center">
                                <span class="font-semibold"><?= $item['question']; ?></span>
                                <span class="gdp-faq-icon transform transition-transform duration-300">
                                    <?= \Elementor\Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true']); ?>
                                </span>
                            </div>
                            <div class="gdp-faq-answer p-4 bg-gray-50 rounded-b-lg hidden">
                                <?= $item['answer']; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php elseif ($settings['layout_style'] === 'grid') : ?>
                <div class="gdp-faq-container grid-layout grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php foreach ($settings['faq_items'] as $index => $item) : ?>
                        <div class="gdp-faq-item animate-fade-in" data-index="<?= $index; ?>">
                            <div class="gdp-faq-question p-4 bg-white rounded-lg shadow-md">
                                <h3 class="font-semibold mb-2"><?= $item['question']; ?></h3>
                                <div class="gdp-faq-answer">
                                    <?= $item['answer']; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php elseif ($settings['layout_style'] === 'tabs') : ?>
                <div class="gdp-faq-container tabs-layout">
                    <div class="gdp-faq-tabs flex flex-wrap mb-4">
                        <?php foreach ($settings['faq_items'] as $index => $item) : ?>
                            <button class="gdp-faq-tab-button p-2 mr-2 mb-2 bg-gray-200 rounded-lg" data-index="<?= $index; ?>">
                                <?= $item['question']; ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                    <div class="gdp-faq-tab-content">
                        <?php foreach ($settings['faq_items'] as $index => $item) : ?>
                            <div class="gdp-faq-tab-pane p-4 bg-white rounded-lg shadow-md hidden" data-index="<?= $index; ?>">
                                <?= $item['answer']; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($settings['schema_markup'] === 'yes') : ?>
            <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "FAQPage",
                "mainEntity": [
                    <?php foreach ($settings['faq_items'] as $index => $item) : ?>
                    {
                        "@type": "Question",
                        "name": "<?= esc_html($item['question']); ?>",
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": "<?= esc_html(strip_tags($item['answer'])); ?>"
                        }
                    }<?= $index < count($settings['faq_items']) - 1 ? ',' : ''; ?>
                    <?php endforeach; ?>
                ]
            }
            </script>
        <?php endif; ?>

        <style>
            .gdp-faq3 .animate-fade-in {
                opacity: 0;
                animation: fadeIn 1s ease-out forwards;
            }
            .gdp-faq3 .animate-slide-up {
                opacity: 0;
                transform: translateY(20px);
                animation: slideUp 1s ease-out forwards;
            }
            @keyframes fadeIn {
                to {
                    opacity: 1;
                }
            }
            @keyframes slideUp {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>

        <script >
            document.addEventListener('DOMContentLoaded', function() {
                const faqItems = document.querySelectorAll('.gdp-faq-item');

                faqItems.forEach((item) => {
                    item.addEventListener('click', function() {
                        const answer = item.querySelector('.gdp-faq-answer');
                        answer.classList.toggle('hidden');
                    });
                });
            });
        </script>
        <?php
    }
}