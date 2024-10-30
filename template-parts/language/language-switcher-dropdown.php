<?php
/**
 * Template part for displaying language switcher in dropdown style
 */
?>
<div class="relative inline-block text-left" x-data="{ open: false }">
    <button @click="open = !open" type="button" class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
        <?php 
        $current_lang = GDP_Translations::get_instance()->get_current_language();
        echo GDP_Translations::get_instance()->get_language_name($current_lang, true);
        ?>
        <svg class="w-5 h-5 ml-2 -mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
    </button>

    <div x-show="open" 
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 w-48 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
        <div class="py-1">
            <?php foreach ($enabled_languages as $lang => $enabled): ?>
                <?php if ($enabled): ?>
                    <a href="<?php echo esc_url($this->get_translation_url($lang)); ?>" 
                       class="<?php echo ($lang === $current_lang) 
                           ? 'bg-gray-100 text-gray-900' 
                           : 'text-gray-700 hover:bg-gray-50'; ?> block px-4 py-2 text-sm">
                        <?php echo GDP_Translations::get_instance()->get_language_name($lang, true); ?>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>