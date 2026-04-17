<?php
/**
 * Quick Guide - How To Enter Section
 *
 * Editorial-style 3-step guide matching LiveLifePrizes Concept B: Earthy & Editorial.
 * Left-aligned layout with tag, large faded step numbers, and per-step CTA links.
 *
 * @package Nera_Competitions
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit();
}

// Quick guide steps
$steps = get_field('guide_steps');

if (empty($steps)) {
  $steps = [
    [
      'number' => '01',
      'title' => __('Create a Free Account', 'nera-competitions'),
      'description' => __(
        "Sign up in seconds — you'll need an account to enter any of our prize draws.",
        'nera-competitions',
      ),
      'step_link' => [
        'url' => home_url('/my-account/'),
        'title' => __('Create account', 'nera-competitions'),
        'target' => '',
      ],
    ],
    [
      'number' => '02',
      'title' => __('Pick Your Prizes', 'nera-competitions'),
      'description' => __(
        'Browse live competitions, pick your prizes, and secure your tickets.',
        'nera-competitions',
      ),
      'step_link' => [
        'url' => home_url('/shop/'),
        'title' => __('Browse prizes', 'nera-competitions'),
        'target' => '',
      ],
    ],
    [
      'number' => '03',
      'title' => __('Watch the Live Draw', 'nera-competitions'),
      'description' => __(
        'Secure your tickets and join us on socials for the fully transparent live draw.',
        'nera-competitions',
      ),
      'step_link' => [
        'url' => '#',
        'title' => __('More info', 'nera-competitions'),
        'target' => '',
      ],
    ],
  ];
}

$guide_tag = get_field('guide_tag') ?: __('Simple & Fair', 'nera-competitions');
$guide_title = get_field('guide_title') ?: __('How To Enter', 'nera-competitions');
$guide_subtitle =
  get_field('guide_subtitle') ?:
  __('Win your dream prizes in just three simple steps', 'nera-competitions');
$guide_live_draw_social_links = get_field('guide_live_draw_social_links');
?>

<section class="how-to-enter-section py-16 lg:py-24 bg-gradient-to-b from-[#faf7f2] to-[#fffdfb] relative border-t border-stone-200/70" id="quick-guide"
  data-aos="fade-up">
  <!-- Subtle terracotta wash on cream (rest band after Current Prizes) -->
  <div class="absolute inset-0 pointer-events-none overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_75%_15%,rgba(155,80,57,0.05),transparent_50%)]"></div>
  </div>

  <div class="how-to-enter-inner max-w-[1200px] mx-auto px-6 lg:px-8 relative z-10">

    <!-- Section Header (left-aligned) -->
    <div class="text-left mb-12 lg:mb-16">
      <?php if ($guide_tag): ?>
        <span class="how-to-enter-tag inline-block px-4 py-1.5 mb-4 text-[11px] font-medium uppercase tracking-[2px] rounded-[20px] bg-[rgba(155,80,57,0.12)] text-[#c4704e] border border-[rgba(216,181,130,0.35)]">
          <?php echo esc_html($guide_tag); ?>
        </span>
      <?php endif; ?>
      <h2 class="font-heading text-3xl lg:text-4xl xl:text-[44px] font-normal text-[#9b5039] mb-2">
        <?php echo esc_html($guide_title); ?>
      </h2>
      <p class="text-lg text-stone-600">
        <?php echo esc_html($guide_subtitle); ?>
      </p>
    </div>

    <!-- Steps Grid (flat columns with dividers) -->
    <div class="how-to-enter-steps grid grid-cols-1 md:grid-cols-3">
      <?php foreach ($steps as $index => $step): ?>
        <div class="how-step how-step-<?php echo (int) $index +
          1; ?> py-8 px-0 lg:px-10 border-b border-stone-200/70 last:border-b-0 md:border-b-0 md:border-r md:border-r-stone-200/70 md:last:border-r-0">
          <div class="how-step-num font-heading text-[72px] font-normal leading-none mb-5 text-[#d8b582]/35">
            <?php echo esc_html($step['number']); ?>
          </div>
          <h3 class="text-lg font-medium text-stone-900 mb-3 tracking-[0.3px]">
            <?php echo esc_html($step['title']); ?>
          </h3>
          <p class="text-sm text-stone-600 leading-relaxed">
            <?php echo esc_html($step['description']); ?>
          </p>
          <?php
          if ((int) $index === 2) {
            $live_draw_socials = is_array($guide_live_draw_social_links)
              ? $guide_live_draw_social_links
              : [];
            if (empty($live_draw_socials)) {
              $live_draw_socials = [
                ['platform' => 'facebook', 'url' => '#'],
                ['platform' => 'instagram', 'url' => '#'],
              ];
            }
            $has_social = false;
            foreach ($live_draw_socials as $soc) {
              $fa_icon = $soc['social_icon'] ?? null;
              if (is_array($fa_icon)) {
                $fa_icon = (object) $fa_icon;
              }
              if (is_object($fa_icon) && !empty($fa_icon->element)) {
                $has_social = true;
                break;
              }
              if (!empty($soc['platform'] ?? null)) {
                $has_social = true;
                break;
              }
            }
            if ($has_social) {
              ?>
            <ul class="how-step-social flex flex-wrap gap-2 mt-4 list-none p-0 m-0" role="list">
              <?php
              foreach ($live_draw_socials as $soc) {
                $soc_url = isset($soc['url']) && $soc['url'] !== '' ? $soc['url'] : '#';
                $fa_icon = $soc['social_icon'] ?? null;
                if (is_array($fa_icon)) {
                  $fa_icon = (object) $fa_icon;
                }
                $platform = $soc['platform'] ?? '';
                $icon_markup = '';
                $aria_piece = '';

                if (is_object($fa_icon) && !empty($fa_icon->element)) {
                  $icon_markup = wp_kses_post($fa_icon->element);
                  if (!empty($fa_icon->id)) {
                    $aria_piece = ucwords(
                      str_replace(['-', '_'], ' ', (string) $fa_icon->id),
                    );
                  }
                } elseif ($platform !== '') {
                  $icon_markup = nera_get_social_icon($platform, 'w-5 h-5');
                  if ($icon_markup !== '') {
                    $aria_piece = nera_get_social_label($platform);
                  }
                }

                if ($icon_markup === '') {
                  continue;
                }

                $aria_label =
                  $aria_piece !== ''
                    ? sprintf(
                      __('Follow us on %s', 'nera-competitions'),
                      $aria_piece,
                    )
                    : __('Social media link', 'nera-competitions');
                $open_external = (bool) preg_match('#^https?://#i', (string) $soc_url);
                ?>
              <li>
                <a href="<?php echo esc_url($soc_url); ?>"
                  class="how-step-social-link inline-flex items-center justify-center w-9 h-9 rounded-full border border-stone-200/90 bg-white/80 text-[#9b5039] shadow-sm transition-colors hover:border-[#c4704e]/50 hover:text-[#c4704e] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#c4704e]"
                  <?php
                  if ($open_external) {
                    echo ' target="_blank" rel="noopener noreferrer"';
                  }
                  ?>
                  aria-label="<?php echo esc_attr($aria_label); ?>">
                  <?php echo $icon_markup; ?>
                </a>
              </li>
                <?php
              }
              ?>
            </ul>
              <?php
            }
          }
          $link = $step['step_link'] ?? [];
          $link_url = $link['url'] ?? '';
          $link_title = $link['title'] ?? '';
          $link_target = !empty($link['target']) ? $link['target'] : '';
          if ($link_url): ?>
            <a href="<?php echo esc_url($link_url); ?>"
              class="how-step-link inline-block mt-3 text-[13px] font-normal !text-[#c4704e] hover:!text-[#9b5039] transition-colors"
              <?php echo $link_target
                ? ' target="' . esc_attr($link_target) . '" rel="noopener"'
                : ''; ?>>
              <?php echo esc_html($link_title ?: $link_url); ?> &rarr;
            </a>
          <?php endif;
          ?>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>
