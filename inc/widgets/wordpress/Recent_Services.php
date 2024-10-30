<?php
class GDP_Recent_Services_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'gdp_recent_services_widget', // Base ID
            __('Recent Services', 'text_domain'), // Name
            array('description' => __('A widget to display recent services', 'text_domain'))
        );
    }

    public function widget($args, $instance) {
        // Output the content of the widget
    }

    public function form($instance) {
        // Output admin widget options form
    }

    public function update($new_instance, $old_instance) {
        // Handle updating the widget
    }
}
