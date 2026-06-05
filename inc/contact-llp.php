<?php
/**
 * Contact page — sidebar image data for Contact component.
 *
 * @package Live_Life_Prizes
 */

if (!defined('ABSPATH')) {
  exit();
}

/**
 * Resolve contact sidebar image from ACF.
 *
 * @return array{url: string, alt: string}
 */
function live_life_prizes_contact_sidebar_image(): array
{
  $empty = ['url' => '', 'alt' => ''];

  if (!function_exists('get_field')) {
    return $empty;
  }

  $image = get_field('contact_sidebar_image');
  if (is_array($image) && !empty($image['url'])) {
    return [
      'url' => (string) $image['url'],
      'alt' => isset($image['alt']) ? (string) $image['alt'] : '',
    ];
  }

  if (is_string($image) && $image !== '') {
    return [
      'url' => $image,
      'alt' => '',
    ];
  }

  if (is_numeric($image) && (int) $image > 0) {
    $url = wp_get_attachment_image_url((int) $image, 'large');
    if ($url) {
      return [
        'url' => $url,
        'alt' => (string) get_post_meta((int) $image, '_wp_attachment_image_alt', true),
      ];
    }
  }

  return $empty;
}

add_filter('nera_component_data_Contact', function (array $data): array {
  $img = live_life_prizes_contact_sidebar_image();
  $data['contact_sidebar_image_url'] = $img['url'];
  $data['contact_sidebar_image_alt'] = $img['alt'];

  return $data;
}, 10, 1);
