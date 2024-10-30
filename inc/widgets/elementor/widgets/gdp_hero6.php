<?php
namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Gdp_hero6 extends Widget_Base {

    public function get_name() {
        return 'gdp_hero6';
    }

    public function get_title() {
        return __('GDP Hero 6 - Creative Agency', 'gdp');
    }

    public function get_icon() {
        return 'eicon-header';
    }

    public function get_categories() {
        return ['gdp_widget'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'gdp'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'gdp'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Unleash Your Creative Potential', 'gdp'),
            ]
        );

        $this->add_control(
            'subtitle',
            [
                'label' => __('Subtitle', 'gdp'),
                'type' => Controls_Manager::TEXT,
                'default' => __('We turn ideas into extraordinary experiences', 'gdp'),
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __('Description', 'gdp'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('Our creative agency blends innovation, strategy, and artistry to deliver captivating solutions that elevate your brand.', 'gdp'),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __('Button Text', 'gdp'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Start Your Project', 'gdp'),
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label' => __('Button Link', 'gdp'),
                'type' => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'gdp'),
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'background_image',
            [
                'label' => __('Background Image', 'gdp'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="relative min-h-screen flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img src="<?php echo esc_url($settings['background_image']['url']); ?>" alt="Background" class="w-full h-full object-cover filter blur-sm">
                <div class="absolute inset-0 bg-black opacity-50"></div>
            </div>
            <div class="relative z-10 text-center text-white px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto">
                <h2 class="text-3xl sm:text-4xl font-extrabold mb-2 animate-fadeInDown"><?php echo esc_html($settings['subtitle']); ?></h2>
                <h1 class="text-5xl sm:text-7xl font-black mb-4 animate-fadeInUp animate-delay-300"><?php echo esc_html($settings['title']); ?></h1>
                <p class="text-xl sm:text-2xl mb-8 animate-fadeIn animate-delay-600"><?php echo esc_html($settings['description']); ?></p>
                <a href="<?php echo esc_url($settings['button_link']['url']); ?>" class="inline-block bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold text-lg py-4 px-8 rounded-full shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 animate-fadeIn animate-delay-900">
                    <?php echo esc_html($settings['button_text']); ?>
                </a>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-black to-transparent"></div>
        </div>
        <style>
            @keyframes fadeInDown {
                from { opacity: 0; transform: translateY(-20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            .animate-fadeInDown { animation: fadeInDown 1s ease-out forwards; }
            .animate-fadeInUp { animation: fadeInUp 1s ease-out forwards; }
            .animate-fadeIn { animation: fadeIn 1s ease-out forwards; }
            .animate-delay-300 { animation-delay: 300ms; }
            .animate-delay-600 { animation-delay: 600ms; }
            .animate-delay-900 { animation-delay: 900ms; }
        </style>
        <?php
    }

    protected function _content_template() {
        ?>
        <div class="relative min-h-screen flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img src="{{ settings.background_image.url }}" alt="Background" class="w-full h-full object-cover filter blur-sm">
                <div class="absolute inset-0 bg-black opacity-50"></div>
            </div>
            <div class="relative z-10 text-center text-white px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto">
                <h2 class="text-3xl sm:text-4xl font-extrabold mb-2 animate-fadeInDown">{{{ settings.subtitle }}}</h2>
                <h1 class="text-5xl sm:text-7xl font-black mb-4 animate-fadeInUp animate-delay-300">{{{ settings.title }}}</h1>
                <p class="text-xl sm:text-2xl mb-8 animate-fadeIn animate-delay-600">{{{ settings.description }}}</p>
                <a href="{{ settings.button_link.url }}" class="inline-block bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold text-lg py-4 px-8 rounded-full shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 animate-fadeIn animate-delay-900">
                    {{{ settings.button_text }}}
                </a>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-black to-transparent"></div>
        </div>
        <?php
    }
}