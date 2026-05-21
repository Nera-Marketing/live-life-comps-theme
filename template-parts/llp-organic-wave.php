<?php
/**
 * Organic wave divider — canvas (#0c0b09) transition.
 *
 * @package Live_Life_Prizes
 *
 * Args:
 *   position (string) top|bottom — default bottom.
 *   context  (string) header|footer|hero — placement and positioning.
 */

if (!defined('ABSPATH')) {
  exit();
}

$args = isset($args) && is_array($args) ? $args : [];

$position = isset($args['position']) && $args['position'] === 'top' ? 'top' : 'bottom';
$context = isset($args['context']) ? (string) $args['context'] : 'hero';

if (in_array($context, ['header', 'footer'], true) && !apply_filters('llp_show_site_waves', true)) {
  return;
}

$is_top = $position === 'top';

$wrapper_classes = 'llp-organic-wave pointer-events-none leading-none';

if ($context === 'header') {
  $wrapper_classes .= ' llp-organic-wave--header absolute left-0 right-0 bottom-0 translate-y-full z-10';
} elseif ($context === 'footer') {
  $wrapper_classes .= ' llp-organic-wave--footer absolute left-0 right-0 top-0 -translate-y-full z-10';
} else {
  $wrapper_classes .= ' absolute bottom-0 left-0 right-0 z-10';
}

$svg_classes = 'block w-full ';
$svg_classes .= $context === 'hero' ? 'h-12' : 'h-16';

$wave_path = $is_top
  ? 'M0,0 L1440,0 L1440,24 C1200,0 960,48 720,24 C480,0 240,48 0,24 Z'
  : 'M0,24 C240,48 480,0 720,24 C960,48 1200,0 1440,24 L1440,48 L0,48 Z';

$wave_fill = '#0c0b09';

?>
<div class="<?php echo esc_attr($wrapper_classes); ?>" aria-hidden="true">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 48" preserveAspectRatio="none" class="<?php echo esc_attr($svg_classes); ?>">
    <path d="<?php echo esc_attr($wave_path); ?>" fill="<?php echo esc_attr($wave_fill); ?>"/>
  </svg>
</div>
