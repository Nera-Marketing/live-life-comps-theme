<?php
/**
 * How It Works — merge ACF hero repeater with Live Life Prizes card presets.
 *
 * @package Nera_Competitions
 */

if (!defined('ABSPATH')) {
  exit();
}

/**
 * Metadata for each hero step index (0–3). Matches ACF max of 4 rows.
 *
 * @return array<int, array{icon: string, title: string, description: string, badge_gradient: string, icon_bg: string}>
 */
function live_life_prizes_get_hiw_hero_presets_metadata(): array
{
  return [
    [
      'icon' => 'campfire',
      'title' => __('Create a Free Account', 'nera-competitions'),
      'description' => __(
        'Sign up in seconds — you will need an account to enter our free prize draws.',
        'nera-competitions',
      ),
      'badge_gradient' => 'linear-gradient(to bottom right, #9b5039, #c4704e)',
      'icon_bg' => 'rgba(155, 80, 57, 0.12)',
    ],
    [
      'icon' => 'compass',
      'title' => __('Pick Your Prizes & Secure Your Tickets', 'nera-competitions'),
      'description' => __(
        'Browse live competitions, choose your favourites, and secure your entries.',
        'nera-competitions',
      ),
      'badge_gradient' => 'linear-gradient(to bottom right, #9b5039, #c4704e)',
      'icon_bg' => 'rgba(216, 181, 130, 0.12)',
    ],
    [
      'icon' => 'sun-horizon',
      'title' => __('Watch the Live Draw', 'nera-competitions'),
      'description' => __(
        'Join us on socials for a fully transparent live draw. Winners are chosen fairly and prizes are delivered to you.',
        'nera-competitions',
      ),
      'badge_gradient' => 'linear-gradient(to bottom right, #9b5039, #c4704e)',
      'icon_bg' => 'rgba(196, 112, 78, 0.12)',
    ],
    [
      'icon' => 'trophy',
      'title' => __('Win Your Prize', 'nera-competitions'),
      'description' => __(
        'Watch the live draw and celebrate with our community — prizes are delivered to verified winners.',
        'nera-competitions',
      ),
      'badge_gradient' => 'linear-gradient(to bottom right, #9b5039, #c4704e)',
      'icon_bg' => 'rgba(184, 154, 106, 0.12)',
    ],
  ];
}

/**
 * Build one step row for the LLP How It Works partial.
 *
 * @param array{icon: string, title: string, description: string, badge_gradient: string, icon_bg: string} $preset
 * @param mixed                                                                                            $acf_icon Optional ACF image field (same as step_icon subfield).
 * @return array{icon: string, title: string, description: string, badge_gradient: string, icon_bg: string}
 */
function live_life_prizes_hiw_build_step(array $preset, $acf_icon = null): array
{
  $fallback = llp_icon($preset['icon']);
  $icon_html = function_exists('nera_hiw_step_icon_html')
    ? nera_hiw_step_icon_html($acf_icon, $fallback)
    : $fallback;

  return [
    'icon' => $icon_html,
    'title' => $preset['title'],
    'description' => $preset['description'],
    'badge_gradient' => $preset['badge_gradient'],
    'icon_bg' => $preset['icon_bg'],
  ];
}

/**
 * Default hero steps when the repeater is empty (first three presets).
 *
 * @return array<int, array{icon: string, title: string, description: string, badge_gradient: string, icon_bg: string}>
 */
function live_life_prizes_get_hiw_default_hero_steps(): array
{
  $meta = live_life_prizes_get_hiw_hero_presets_metadata();
  $out = [];
  for ($i = 0; $i < 3; $i++) {
    $out[] = live_life_prizes_hiw_build_step($meta[$i]);
  }
  return $out;
}

/**
 * Merge ACF repeater rows with LLP presets; empty input returns three default steps.
 *
 * @param mixed $acf_rows Repeater value from get_field('hiw_hero_steps').
 * @return array<int, array{icon: string, title: string, description: string, badge_gradient: string, icon_bg: string}>
 */
function live_life_prizes_get_hiw_merged_hero_steps($acf_rows): array
{
  $presets = live_life_prizes_get_hiw_hero_presets_metadata();

  if (empty($acf_rows) || !is_array($acf_rows)) {
    return live_life_prizes_get_hiw_default_hero_steps();
  }

  $merged = [];
  foreach ($acf_rows as $i => $row) {
    if (!is_array($row)) {
      continue;
    }
    $title = isset($row['title']) ? trim((string) $row['title']) : '';
    $description = isset($row['description']) ? trim((string) $row['description']) : '';
    if ($title === '' && $description === '') {
      continue;
    }

    $preset = isset($presets[$i]) ? $presets[$i] : $presets[0];
    $acf_icon = isset($row['step_icon']) ? $row['step_icon'] : null;
    $step = live_life_prizes_hiw_build_step($preset, $acf_icon);
    $step['title'] = $title !== '' ? $title : $preset['title'];
    $step['description'] = $description !== '' ? $description : $preset['description'];
    $merged[] = $step;
  }

  if (empty($merged)) {
    return live_life_prizes_get_hiw_default_hero_steps();
  }

  return $merged;
}

/**
 * Promote the How It Works step title/description sub-fields to WYSIWYG editors
 * so authors can embed links and basic inline formatting. Parent ACF registration
 * stays untouched; we override the field shape at load time from the child.
 */
add_filter('acf/load_field/key=field_hiw_hero_step_title', function ($field) {
  $field['type']         = 'wysiwyg';
  $field['tabs']         = 'visual';
  $field['toolbar']      = 'basic';
  $field['media_upload'] = 0;
  $field['delay']        = 1;
  return $field;
});

add_filter('acf/load_field/key=field_hiw_hero_step_description', function ($field) {
  $field['type']         = 'wysiwyg';
  $field['tabs']         = 'visual';
  $field['toolbar']      = 'basic';
  $field['media_upload'] = 0;
  $field['delay']        = 1;
  return $field;
});

/**
 * Default URL/label for the postal footnote “see more” link.
 *
 * @return array{url: string, title: string, target: string}
 */
function live_life_prizes_get_hiw_postal_note_link_defaults(): array
{
  $page = get_page_by_path('free-postal-entry');

  return [
    'url' => $page ? (string) get_permalink($page) : (string) home_url('/free-postal-entry/'),
    'title' => __('see more info here', 'nera-competitions'),
    'target' => '',
  ];
}

/**
 * Resolve postal footnote link from ACF hiw_postal_note_link on the current page.
 *
 * @param array<string, mixed>|null $acf_link Optional pre-loaded link array.
 * @return array{url: string, title: string, target: string}
 */
function live_life_prizes_resolve_hiw_postal_note_link($acf_link = null): array
{
  if ($acf_link === null && function_exists('get_field')) {
    $acf_link = get_field('hiw_postal_note_link');
  }

  if (is_array($acf_link) && !empty($acf_link['url'])) {
    $url = esc_url_raw((string) $acf_link['url']);
    if ($url !== '') {
      return [
        'url' => $url,
        'title' => !empty($acf_link['title'])
          ? (string) $acf_link['title']
          : __('see more info here', 'nera-competitions'),
        'target' => (!empty($acf_link['target']) && $acf_link['target'] === '_blank') ? '_blank' : '',
      ];
    }
  }

  return live_life_prizes_get_hiw_postal_note_link_defaults();
}
