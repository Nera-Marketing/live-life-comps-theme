<?php
/**
 * ACF — FAQ Page template (faq_list / faq_title for accordion).
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
  'key' => 'group_llp_faq_page',
  'title' => 'FAQ Page',
  'fields' => [
    [
      'key' => 'field_llp_faq_page_title',
      'label' => 'Section Title',
      'name' => 'faq_title',
      'type' => 'text',
      'default_value' => 'Frequently Asked Questions',
    ],
    [
      'key' => 'field_llp_faq_page_list',
      'label' => 'FAQs',
      'name' => 'faq_list',
      'type' => 'repeater',
      'layout' => 'row',
      'button_label' => 'Add Question',
      'sub_fields' => [
        [
          'key' => 'field_llp_faq_page_q',
          'label' => 'Question',
          'name' => 'question',
          'type' => 'text',
        ],
        [
          'key' => 'field_llp_faq_page_a',
          'label' => 'Answer',
          'name' => 'answer',
          'type' => 'wysiwyg',
          'tabs' => 'all',
          'toolbar' => 'basic',
          'media_upload' => 0,
          'delay' => 0,
        ],
      ],
    ],
  ],
  'location' => [
    [
      [
        'param' => 'page_template',
        'operator' => '==',
        'value' => 'page-templates/faq-template.php',
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
