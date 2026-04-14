<?php
/**
 * ACF Marquee Banner Settings
 *
 * Options for the global moving text banner at the top of all pages.
 *
 * @package Live_Life_Prizes
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit();
}

if (function_exists('acf_add_options_page')) {
    if (!function_exists('acf_get_options_page') || !acf_get_options_page('theme-settings')) {
        acf_add_options_page([
            'page_title' => 'Theme Settings',
            'menu_title' => 'Theme Settings',
            'menu_slug' => 'theme-settings',
            'capability' => 'edit_posts',
            'redirect' => false,
        ]);
    }

    acf_add_options_sub_page([
        'page_title' => 'Marquee Banner',
        'menu_title' => 'Marquee Banner',
        'parent_slug' => 'theme-settings',
    ]);
}

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group([
        'key' => 'group_live_life_prizes_marquee',
        'title' => 'Marquee Banner',
        'fields' => [
            [
                'key' => 'field_llp_marquee_enabled',
                'label' => 'Show Marquee Banner',
                'name' => 'marquee_enabled',
                'type' => 'true_false',
                'instructions' => 'Display the moving text banner at the top of all pages.',
                'required' => 0,
                'default_value' => 1,
                'ui' => 1,
                'ui_on_text' => 'Show',
                'ui_off_text' => 'Hide',
            ],
            [
                'key' => 'field_llp_marquee_items',
                'label' => 'Marquee Items',
                'name' => 'marquee_items',
                'type' => 'repeater',
                'instructions' => 'Add the text phrases that will scroll in the banner. Each row is one phrase. Leave empty to use default brand messaging.',
                'required' => 0,
                'layout' => 'table',
                'button_label' => 'Add Item',
                'sub_fields' => [
                    [
                        'key' => 'field_llp_marquee_item_text',
                        'label' => 'Text',
                        'name' => 'text',
                        'type' => 'text',
                        'required' => 1,
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options-marquee-banner',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ]);
}
