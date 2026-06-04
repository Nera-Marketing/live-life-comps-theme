<?php
/**
 * How It Works — child-only ACF (parent field groups stay untouched).
 *
 * @package Live_Life_Prizes
 */

if (!defined('ABSPATH')) {
  exit();
}

/**
 * Register Footnote Link for the How It Works page.
 */
function live_life_prizes_register_hiw_postal_note_link_fields(): void
{
  if (!function_exists('acf_add_local_field_group')) {
    return;
  }

  acf_add_local_field_group([
    'key' => 'group_llp_hiw_postal_note_link',
    'title' => __('How It Works — Footnote link', 'nera-competitions'),
    'fields' => [
      [
        'key' => 'field_llp_hiw_postal_note_link_message',
        'label' => __('Postal entry info box', 'nera-competitions'),
        'name' => '',
        'type' => 'message',
        'message' => __(
          'This link appears right after the <strong>Footnote</strong> text in the Postal Entry section. Leave empty to use the default label “see more info here” and the Free Postal Entry page URL.',
          'nera-competitions',
        ),
        'new_lines' => 'wpautop',
        'esc_html' => 0,
      ],
      [
        'key' => 'field_llp_hiw_postal_note_link',
        'label' => __('Footnote Link', 'nera-competitions'),
        'name' => 'hiw_postal_note_link',
        'type' => 'link',
        'return_format' => 'array',
        'instructions' => __(
          'URL, link text, and optional “open in new tab”.',
          'nera-competitions',
        ),
      ],
    ],
    'location' => [
      [
        [
          'param' => 'page_template',
          'operator' => '==',
          'value' => 'page-templates/how-it-works-template.php',
        ],
      ],
    ],
    'menu_order' => 1,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'active' => true,
    'description' => '',
  ]);
}

add_action('acf/init', 'live_life_prizes_register_hiw_postal_note_link_fields', 20);
