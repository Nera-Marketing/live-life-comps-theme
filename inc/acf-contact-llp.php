<?php
/**
 * ACF — Contact page sidebar image (replaces "Get in Touch" column when set).
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
  'key' => 'group_llp_contact_sidebar',
  'title' => 'Contact — Sidebar Image',
  'fields' => [
    [
      'key' => 'field_llp_contact_sidebar_image',
      'label' => 'Sidebar Image',
      'name' => 'contact_sidebar_image',
      'type' => 'image',
      'instructions' => __(
        'When set, the "Get in Touch" contact column is replaced by this image. Remove the image to show contact details again.',
        'live-life-prizes',
      ),
      'return_format' => 'array',
      'preview_size' => 'medium',
      'library' => 'all',
    ],
  ],
  'location' => [
    [
      [
        'param' => 'page_template',
        'operator' => '==',
        'value' => 'page-templates/contact-template.php',
      ],
    ],
  ],
  'menu_order' => 5,
  'position' => 'normal',
  'style' => 'default',
  'label_placement' => 'top',
  'instruction_placement' => 'label',
  'active' => true,
  'description' => '',
]);
