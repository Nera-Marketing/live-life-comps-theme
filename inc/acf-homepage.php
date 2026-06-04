<?php
/**
 * ACF — Live Life Homepage template
 *
 * Field group for pages using the "Live Life Homepage" template
 * (page-templates/live-life-homepage.php). Matches get_field() usage in
 * template-parts/homepage/*.
 *
 * @package Live_Life_Prizes
 */

if (!defined('ABSPATH')) {
    exit();
}

if (!function_exists('acf_add_local_field_group')) {
    return;
}

acf_add_local_field_group([
    'key' => 'group_live_life_homepage',
    'title' => 'Live Life Homepage',
    'fields' => [
        // Tab: Hero
        [
            'key' => 'field_llp_home_tab_hero',
            'label' => 'Hero Section',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
        ],
        [
            'key' => 'field_llp_home_hero_show_badge',
            'label' => 'Show Badge',
            'name' => 'hero_show_badge',
            'type' => 'true_false',
            'instructions' => 'Display the small badge above the hero media.',
            'default_value' => 1,
            'ui' => 1,
            'ui_on_text' => 'Show',
            'ui_off_text' => 'Hide',
        ],
        [
            'key' => 'field_llp_home_hero_badge_text',
            'label' => 'Badge Text',
            'name' => 'hero_badge_text',
            'type' => 'text',
            'instructions' => 'e.g. Live Now',
            'default_value' => '',
        ],
        [
            'key' => 'field_llp_home_hero_cta_text',
            'label' => 'Primary CTA Text',
            'name' => 'hero_cta_text',
            'type' => 'text',
            'default_value' => '',
        ],
        [
            'key' => 'field_llp_home_hero_cta_url',
            'label' => 'Primary CTA URL',
            'name' => 'hero_cta_url',
            'type' => 'text',
            'instructions' => 'Leave empty to use the Shop page URL.',
            'default_value' => '',
        ],
        [
            'key' => 'field_llp_home_hero_media_type',
            'label' => 'Hero Media Type',
            'name' => 'hero_media_type',
            'type' => 'select',
            'choices' => [
                'image' => 'Image',
                'video' => 'Video file',
                'video_iframe' => 'Embedded video (YouTube / Vimeo)',
            ],
            'default_value' => 'image',
            'allow_null' => 0,
            'return_format' => 'value',
        ],
        [
            'key' => 'field_llp_home_hero_image',
            'label' => 'Hero Image',
            'name' => 'hero_image',
            'type' => 'image',
            'return_format' => 'url',
            'preview_size' => 'medium',
            'library' => 'all',
            'conditional_logic' => [
                [
                    [
                        'field' => 'field_llp_home_hero_media_type',
                        'operator' => '==',
                        'value' => 'image',
                    ],
                ],
            ],
        ],
        [
            'key' => 'field_llp_home_hero_video',
            'label' => 'Hero Video File',
            'name' => 'hero_video',
            'type' => 'file',
            'return_format' => 'url',
            'library' => 'all',
            'mime_types' => 'mp4,webm',
            'instructions' => 'Direct video file URL.',
            'conditional_logic' => [
                [
                    [
                        'field' => 'field_llp_home_hero_media_type',
                        'operator' => '==',
                        'value' => 'video',
                    ],
                ],
            ],
        ],
        [
            'key' => 'field_llp_home_hero_video_iframe',
            'label' => 'Video URL (embed)',
            'name' => 'hero_video_iframe',
            'type' => 'text',
            'instructions' => 'Paste a YouTube or Vimeo page URL.',
            'conditional_logic' => [
                [
                    [
                        'field' => 'field_llp_home_hero_media_type',
                        'operator' => '==',
                        'value' => 'video_iframe',
                    ],
                ],
            ],
        ],

        // Tab: Credibility
        [
            'key' => 'field_llp_home_tab_credibility',
            'label' => 'Credibility Bar',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
        ],
        [
            'key' => 'field_llp_home_credibility_items',
            'label' => 'Trust Items',
            'name' => 'credibility_items',
            'type' => 'repeater',
            'instructions' => 'Material Symbols icon names (e.g. lock, verified). Leave empty for defaults.',
            'layout' => 'table',
            'button_label' => 'Add Item',
            'max' => 6,
            'sub_fields' => [
                [
                    'key' => 'field_llp_home_cred_icon',
                    'label' => 'Icon',
                    'name' => 'icon',
                    'type' => 'text',
                    'default_value' => 'check_circle',
                ],
                [
                    'key' => 'field_llp_home_cred_label',
                    'label' => 'Label',
                    'name' => 'label',
                    'type' => 'text',
                ],
            ],
        ],

        // Tab: Account prompt
        [
            'key' => 'field_llp_home_tab_account',
            'label' => 'Account Prompt',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
        ],
        [
            'key' => 'field_llp_home_account_prompt_enabled',
            'label' => 'Show Account Prompt',
            'name' => 'account_prompt_enabled',
            'type' => 'true_false',
            'instructions' => 'Shown to logged-out visitors only.',
            'default_value' => 1,
            'ui' => 1,
            'ui_on_text' => 'Show',
            'ui_off_text' => 'Hide',
        ],
        [
            'key' => 'field_llp_home_account_prompt_badge',
            'label' => 'Badge',
            'name' => 'account_prompt_badge',
            'type' => 'text',
        ],
        [
            'key' => 'field_llp_home_account_prompt_copy',
            'label' => 'Copy',
            'name' => 'account_prompt_copy',
            'type' => 'textarea',
            'rows' => 3,
        ],
        [
            'key' => 'field_llp_home_account_prompt_cta_text',
            'label' => 'CTA Text',
            'name' => 'account_prompt_cta_text',
            'type' => 'text',
        ],
        [
            'key' => 'field_llp_home_account_prompt_cta_url',
            'label' => 'CTA URL',
            'name' => 'account_prompt_cta_url',
            'type' => 'text',
            'instructions' => 'Relative (e.g. /my-account/) or absolute URL.',
        ],
        [
            'key' => 'field_llp_home_account_prompt_icon',
            'label' => 'Icon (Material Symbol)',
            'name' => 'account_prompt_icon',
            'type' => 'text',
            'instructions' => 'e.g. person_add',
            'default_value' => 'person_add',
        ],

        // Tab: Welcome
        [
            'key' => 'field_llp_home_tab_welcome',
            'label' => 'Welcome Section',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
        ],
        [
            'key' => 'field_llp_home_welcome_badge',
            'label' => 'Badge',
            'name' => 'welcome_badge',
            'type' => 'text',
            'default_value' => 'From the Founders',
        ],
        [
            'key' => 'field_llp_home_welcome_title',
            'label' => 'Title',
            'name' => 'welcome_title',
            'type' => 'text',
        ],
        [
            'key' => 'field_llp_home_welcome_intro',
            'label' => 'Intro',
            'name' => 'welcome_intro',
            'type' => 'wysiwyg',
            'toolbar' => 'basic',
            'media_upload' => 0,
            'tabs' => 'all',
        ],
        [
            'key' => 'field_llp_home_welcome_image',
            'label' => 'Image',
            'name' => 'welcome_image',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ],

        // Tab: Featured
        [
            'key' => 'field_llp_home_tab_featured',
            'label' => 'Current Prizes',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
        ],
        [
            'key' => 'field_llp_home_featured_title',
            'label' => 'Section Title',
            'name' => 'featured_title',
            'type' => 'text',
            'instructions' => 'Heading above the competition grid.',
        ],

        // Tab: Quick guide
        [
            'key' => 'field_llp_home_tab_guide',
            'label' => 'Quick Guide',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
        ],
        [
            'key' => 'field_llp_home_guide_tag',
            'label' => 'Tag',
            'name' => 'guide_tag',
            'type' => 'text',
        ],
        [
            'key' => 'field_llp_home_guide_title',
            'label' => 'Title',
            'name' => 'guide_title',
            'type' => 'text',
        ],
        [
            'key' => 'field_llp_home_guide_subtitle',
            'label' => 'Subtitle',
            'name' => 'guide_subtitle',
            'type' => 'text',
        ],
        [
            'key' => 'field_llp_home_guide_steps',
            'label' => 'Steps',
            'name' => 'guide_steps',
            'type' => 'repeater',
            'layout' => 'block',
            'max' => 3,
            'button_label' => 'Add Step',
            'sub_fields' => [
                [
                    'key' => 'field_llp_home_guide_step_number',
                    'label' => 'Number',
                    'name' => 'number',
                    'type' => 'text',
                    'default_value' => '01',
                ],
                [
                    'key' => 'field_llp_home_guide_step_title',
                    'label' => 'Title',
                    'name' => 'title',
                    'type' => 'text',
                ],
                [
                    'key' => 'field_llp_home_guide_step_description',
                    'label' => 'Description',
                    'name' => 'description',
                    'type' => 'wysiwyg',
                    'instructions' => 'Use the link button to add inline links in the step text.',
                    'toolbar' => 'basic',
                    'media_upload' => 0,
                    'tabs' => 'all',
                ],
                [
                    'key' => 'field_llp_home_guide_step_link',
                    'label' => 'Link',
                    'name' => 'step_link',
                    'type' => 'link',
                    'return_format' => 'array',
                ],
            ],
        ],
    ],
    'location' => [
        [
            [
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'page-templates/live-life-homepage.php',
            ],
        ],
    ],
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => [
        'the_content',
    ],
    'active' => true,
    'description' => '',
]);
