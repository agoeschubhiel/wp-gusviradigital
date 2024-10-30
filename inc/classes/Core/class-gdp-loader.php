<?php
// inc/classes/core/class-gdp-loader.php

class GDP_Loader {
    protected static $actions = [];
    protected static $filters = [];

    public static function add_action($hook, $component, $callback, $priority = 10, $accepted_args = 1) {
        self::$actions = self::add($actions, $hook, $component, $callback, $priority, $accepted_args);
    }

    public static function add_filter($hook, $component, $callback, $priority = 10, $accepted_args = 1) {
        self::$filters = self::add($filters, $hook, $component, $callback, $priority, $accepted_args);
    }

    private static function add($hooks, $hook, $component, $callback, $priority, $accepted_args) {
        $hooks[] = [
            'hook'          => $hook,
            'component'     => $component,
            'callback'      => $callback,
            'priority'      => $priority,
            'accepted_args' => $accepted_args
        ];

        return $hooks;
    }

    public static function run() {
        foreach (self::$actions as $hook) {
            add_action($hook['hook'], array($hook['component'], $hook['callback']), $hook['priority'], $hook['accepted_args']);
        }

        foreach (self::$filters as $hook) {
            add_filter($hook['hook'], array($hook['component'], $hook['callback']), $hook['priority'], $hook['accepted_args']);
        }
    }
}