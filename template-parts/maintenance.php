<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo esc_html(GDP_Maintenance::get_settings('maintenance_title')); ?></title>
    <?php wp_head(); ?>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8"
         style="background: <?php echo GDP_Maintenance::get_settings('maintenance_background')['background-color']; ?>">
        <div class="max-w-3xl w-full space-y-8 text-center">
            <?php
            $logo = GDP_Maintenance::get_settings('maintenance_logo');
            if (!empty($logo['url'])) :
            ?>
                <div>
                    <img class="mx-auto h-24 w-auto" src="<?php echo esc_url($logo['url']); ?>" alt="<?php bloginfo('name'); ?>">
                </div>
            <?php endif; ?>

            <div class="space-y-4">
                <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl">
                    <?php echo esc_html(GDP_Maintenance::get_settings('maintenance_title')); ?>
                </h1>
                <div class="text-xl text-gray-600">
                    <?php echo wp_kses_post(GDP_Maintenance::get_settings('maintenance_message')); ?>
                </div>
            </div>

            <?php if (GDP_Maintenance::get_settings('show_timer')) : ?>
                <div class="mt-8" id="countdown">
                    <div class="grid grid-cols-4 gap-4 text-center">
                        <div class="bg-white p-4 rounded-lg shadow">
                            <span class="days text-3xl font-bold text-indigo-600">00</span>
                            <p class="text-gray-500">Days</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow">
                            <span class="hours text-3xl font-bold text-indigo-600">00</span>
                            <p class="text-gray-500">Hours</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow">
                            <span class="minutes text-3xl font-bold text-indigo-600">00</span>
                            <p class="text-gray-500">Minutes</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow">
                            <span class="seconds text-3xl font-bold text-indigo-600">00</span>
                            <p class="text-gray-500">Seconds</p>
                        </div>
                    </div>
                </div>

                <script>
                    // Countdown Timer
                    function updateCountdown() {
                        const endDate = new Date('<?php echo GDP_Theme_Support::gdp_option("maintenance_date"); ?>').getTime();
                        const now = new Date().getTime();
                        const distance = endDate - now;

                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        document.querySelector('.days').textContent = String(days).padStart(2, '0');
                        document.querySelector('.hours').textContent = String(hours).padStart(2, '0');
                        document.querySelector('.minutes').textContent = String(minutes).padStart(2, '0');
                        document.querySelector('.seconds').textContent = String(seconds).padStart(2, '0');

                        if (distance < 0) {
                            clearInterval(countdownTimer);
                            document.querySelector('#countdown').innerHTML = '<div class="text-xl text-gray-600">We\'re Back Online!</div>';
                        }
                    }

                    const countdownTimer = setInterval(updateCountdown, 1000);
                    updateCountdown();
                </script>
            <?php endif; ?>

            <?php if (GDP_Theme_Support::gdp_option('show_social', false)) : ?>
                <div class="mt-8"> 
                    <div class="flex justify-center space-x-6">
                        <?php
                        $social_links = GDP_Theme_Support::gdp_option('social_links', array());
                        if (!empty($social_links)) :
                            foreach ($social_links as $social) :
                                if (isset($social['platform']) && isset($social['url'])) :
                                    $platform = $social['platform'];
                                    $url = $social['url'];
                        ?>
                                <a href="<?php echo esc_url($url); ?>" 
                                   class="text-gray-400 hover:text-gray-600 transition-colors duration-300"
                                   target="_blank" 
                                   rel="noopener noreferrer">
                                    <?php echo GDP_Maintenance::get_instance()->get_social_icon($platform); ?>
                                </a>
                        <?php
                                endif;
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="mt-12">
                <p class="text-sm text-gray-500">
                    &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. 
                    <?php _e('All rights reserved.', 'gusviradigital'); ?>
                </p>
            </div>
        </div>
    </div>

    <?php wp_footer(); ?>
</body>
</html>