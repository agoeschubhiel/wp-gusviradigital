<?php
/**
 * Template part for displaying language switcher in inline style
 */
?>
<div class="inline-flex rounded-md shadow-sm">
    <?php foreach ($enabled_languages as $lang => $enabled): ?>
        <?php if ($enabled): ?>
            <a href="<?php echo esc_url($this->get_translation_url($lang)); ?>" 
               class="<?php echo ($lang === $current_lang)
                   ? 'bg-primary-50 border-primary-500 text-primary-700 z-10'
                   : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50'; ?> 
                   relative inline-flex items-center px-4 py-2 text-sm font-medium border focus:z-10 focus:outline-none focus:ring-1 focus:ring-primary-500
                   <?php echo ($lang === array_key_first($enabled_languages)) ? 'rounded-l-md' : ''; ?>
                   <?php echo ($lang === array_key_last($enabled_languages)) ? 'rounded-r-md' : ''; ?>">
                <?php echo GDP_Translations::get_instance()->get_language_name($lang, true); ?>
            </a>
        <?php endif; ?>
    <?php endforeach; ?>
</div>