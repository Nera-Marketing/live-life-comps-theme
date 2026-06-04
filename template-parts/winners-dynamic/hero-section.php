<?php
/**
 * Dynamic Winners — Hero Section (child override)
 *
 * Same as parent but without the eyebrow pill (Winners + emoji_events).
 *
 * @package Live_Life_Prizes
 */

if (!defined('ABSPATH')) {
  exit();
}

$page_title = get_the_title();
$page_excerpt = get_the_excerpt();

$default_description = __(
  'From lucky wins to life-enriching experiences — meet our latest winners and explore the draw details below.',
  'live-life-prizes',
);
$legacy_description = __('Celebrate our latest winners from finished competitions.', 'nera-competitions');

if ($page_excerpt === '' || $page_excerpt === $legacy_description) {
  $page_excerpt = $default_description;
}

get_template_part('template-parts/components/shared/page-hero', null, [
  'title' => $page_title,
  'description' => $page_excerpt,
  'variant' => 'default',
]);
