<?php
namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class GDP_Team1 extends Widget_Base {
    public function get_name() { return 'gdp-team1'; }
    public function get_title() { return 'GDP Team 1'; }
    public function get_icon() { return 'eicon-person'; }
    public function get_categories() { return ['gdp-widgets']; }

    public function get_script_depends() {
        return ['gsap', 'scrolltrigger', 'aos'];
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
            'section_title',
            [
                'label' => 'Section Title',
                'type' => Controls_Manager::TEXT,
                'default' => 'Meet Our Expert Team',
            ]
        );

        $this->add_control(
            'section_description',
            [
                'label' => 'Section Description',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Our talented team of professionals is dedicated to delivering exceptional results.',
            ]
        );

        $this->add_control(
            'team_members',
            [
                'label' => 'Team Members',
                'type' => Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'member_name',
                        'label' => 'Name',
                        'type' => Controls_Manager::TEXT,
                        'default' => 'John Doe',
                    ],
                    [
                        'name' => 'member_position',
                        'label' => 'Position',
                        'type' => Controls_Manager::TEXT,
                        'default' => 'CEO & Founder',
                    ],
                    [
                        'name' => 'member_bio',
                        'label' => 'Biography',
                        'type' => Controls_Manager::TEXTAREA,
                        'default' => 'Short biography about the team member.',
                    ],
                    [
                        'name' => 'member_image',
                        'label' => 'Photo',
                        'type' => Controls_Manager::MEDIA,
                        'default' => [
                            'url' => \Elementor\Utils::get_placeholder_image_src(),
                        ],
                    ],
                    [
                        'name' => 'linkedin_url',
                        'label' => 'LinkedIn URL',
                        'type' => Controls_Manager::URL,
                        'placeholder' => 'https://linkedin.com/',
                    ],
                    [
                        'name' => 'twitter_url',
                        'label' => 'Twitter URL',
                        'type' => Controls_Manager::URL,
                        'placeholder' => 'https://twitter.com/',
                    ],
                    [
                        'name' => 'expertise',
                        'label' => 'Areas of Expertise',
                        'type' => Controls_Manager::REPEATER,
                        'fields' => [
                            [
                                'name' => 'skill',
                                'label' => 'Skill',
                                'type' => Controls_Manager::TEXT,
                            ],
                            [
                                'name' => 'level',
                                'label' => 'Level (%)',
                                'type' => Controls_Manager::SLIDER,
                                'range' => [
                                    '%' => [
                                        'min' => 0,
                                        'max' => 100,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'title_field' => '{{{ member_name }}}',
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

        // Add style controls here...
        $this->add_control(
            'card_background_color',
            [
                'label' => 'Card Background Color',
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'name_typography',
                'label' => 'Name Typography',
                'selector' => '{{WRAPPER}} .team-member-name',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <section class="gdp-team1 py-16 lg:py-24" data-aos="fade-up">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4 animate__animated animate__fadeIn">
                        <?php echo esc_html($settings['section_title']); ?>
                    </h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        <?php echo esc_html($settings['section_description']); ?>
                    </p>
                </div>

                <!-- Team Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($settings['team_members'] as $index => $member) : ?>
                        <div class="team-member bg-white rounded-lg overflow-hidden shadow-lg transition-all duration-300 hover:shadow-2xl"
                             data-aos="fade-up" 
                             data-aos-delay="<?php echo $index * 100; ?>">
                            
                            <!-- Member Image with Overlay -->
                            <div class="relative overflow-hidden group">
                                <img src="<?php echo esc_url($member['member_image']['url']); ?>"
                                     alt="<?php echo esc_attr($member['member_name']); ?>"
                                     class="w-full h-80 object-cover transform transition-transform duration-500 group-hover:scale-110"
                                     loading="lazy">
                                
                                <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                    <div class="space-x-4">
                                        <?php if (!empty($member['linkedin_url']['url'])) : ?>
                                            <a href="<?php echo esc_url($member['linkedin_url']['url']); ?>"
                                               class="text-white hover:text-blue-400 transition-colors"
                                               target="_blank"
                                               rel="noopener noreferrer">
                                                <i class="fab fa-linkedin fa-2x"></i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($member['twitter_url']['url'])) : ?>
                                            <a href="<?php echo esc_url ($member['twitter_url']['url']); ?>"
                                               class="text-white hover:text-blue-400 transition-colors"
                                               target="_blank"
                                               rel="noopener noreferrer">
                                                <i class="fab fa-twitter fa-2x"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Member Info -->
                            <div class="px-6 py-8">
                                <h3 class="text-lg font-bold mb-2">
                                    <?php echo esc_html($member['member_name']); ?>
                                </h3>
                                <p class="text-sm text-gray-600 mb-4">
                                    <?php echo esc_html($member['member_position']); ?>
                                </p>
                                <p class="text-sm text-gray-600">
                                    <?php echo esc_html($member['member_bio']); ?>
                                </p>

                                <!-- Expertise -->
                                <div class="flex flex-wrap justify-center mb-4">
                                    <?php foreach ($member['expertise'] as $skill) : ?>
                                        <div class="mr-4 mb-2">
                                            <span class="text-sm text-gray-600">
                                                <?php echo esc_html($skill['skill']); ?>
                                            </span>
                                            <span class="text-sm text-gray-600">
                                                <?php echo esc_html($skill['level'] . '%'); ?>
                                            </span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <?php
    }
}