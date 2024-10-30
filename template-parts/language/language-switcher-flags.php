<?php
/**
 * Template part for displaying language switcher with flags
 */
?>
<div class="inline-flex space-x-2">
    <?php foreach ($enabled_languages as $lang => $enabled): ?>
        <?php if ($enabled): ?>
            <a href="<?php echo esc_url($this->get_translation_url($lang)); ?>" 
               class="<?php echo ($lang === $current_lang)
                   ? 'bg-gray-100 border-gray-300'
                   : 'bg-white border-gray-300 hover:bg-gray-50'; ?> 
                   inline-flex items-center px-3 py-2 border rounded-md transition-colors duration-150">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/flags/' . $lang . '.png'); ?>" 
                     alt="<?php echo esc_attr($lang); ?>"
                     class="w-5 h-auto mr-2 border border-gray-200 rounded-sm">
                <span class="text-sm font-medium text-gray-700">
                    <?php echo GDP_Translations::get_instance()->get_language_name($lang, true); ?>
                </span>
            </a>
        <?php endif; ?>
    <?php endforeach; ?>
</div>