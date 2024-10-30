<?php
namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

class GDP_cta3 extends Widget_Base {
    public function get_name() { return 'gdp-cta3'; }
    public function get_title() { return 'GDP CTA 3'; }
    public function get_icon() { return 'eicon-call-to-action'; }
    public function get_categories() { return ['gdp-widgets']; }

    // Tambahkan dependency Animated.css
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
            'headline',
            [
                'label' => 'Headline',
                'type' => Controls_Manager::TEXT,
                'default' => 'Unlock Your Potential!',
            ]
        );

        $this->add_control(
            'subheadline',
            [
                'label' => 'Subheadline',
                'type' => Controls_Manager::TEXT,
                'default' => 'Join us for exclusive insights and resources.',
            ]
        );

        $this->add_control(
            'cta_button_text',
            [
                'label' => 'Call to Action Button Text',
                'type' => Controls_Manager::TEXT,
                'default' => 'Get Access Now',
            ]
        );

        $this->add_control(
            'cta_button_link',
            [
                'label' => 'Call to Action Button Link',
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://your-link.com',
                'default' => [
                    'url' => '#',
                    'is_external' => false,
                    'nofollow' => false,
                ],
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
            'background_image',
            [
                'label' => 'Background Image',
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => 'https://example.com/your-image.jpg', // Ganti dengan URL gambar Anda
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => 'Text Color',
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <!-- CTA Section with modern design and animations -->
        <section class="gdp-cta3 relative overflow-hidden py-16 lg:py-24" 
                style="background-image: url('<?php echo esc_url($settings['background_image']['url']); ?>'); background-size: cover; background-position: center;"
                role="complementary"
                aria-label="Call to Action">
            
            <div class="bg-black bg-opacity-50 py-16">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center">
                        <?php if (!empty($settings['headline'])) : ?>
                            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4 text-<?php echo esc_attr($settings['text_color']); ?> animate__animated animate__fadeIn">
                                <?php echo esc_html($settings['headline']); ?>
                            </h2>
                        <?php endif; ?>

                        <?php if (!empty($settings['subheadline'])) : ?>
                            <p class="text-lg md:text-xl mb-8 text-gray-200 animate__animated animate__fadeIn animate__delay-1s">
                                <?php echo esc_html($settings['subheadline']); ?>
                            </p>
                        <?php endif; ?>

                        <?php if (!empty($settings['cta_button_text']) && !empty($settings['cta_button_link']['url'])) : ?>
                            <a href="<?php echo esc_url($settings['cta_button_link']['url']); ?>"
                               class="inline-flex items-center px-8 py-3 rounded-lg text-lg font-semibold transition-all duration-300 transform bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring -offset-2 focus:ring-offset-gray-800 focus:ring-white animate__animated animate__fadeIn animate__delay-2s"
                               role="button"
                               <?php echo $settings['cta_button_link']['is_external'] ? 'target="_blank"' : ''; ?>
                               <?php echo $settings['cta_button_link']['nofollow'] ? 'rel="nofollow"' : ''; ?>>
                                <?php echo esc_html($settings['cta_button_text']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}