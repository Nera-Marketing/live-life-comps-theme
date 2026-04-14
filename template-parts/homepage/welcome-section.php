<?php
/**
 * Welcome Section - Personal Intro from JJ
 *
 * Personal welcome with JJ's photo and intro text.
 * Editable via Home Page Group > Welcome (JJ Intro) in WP admin.
 *
 * @package Nera_Competitions
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit();
}

// ACF fields (fallbacks used when empty)
$welcome_badge = get_field('welcome_badge') ?: __('From the Founder', 'nera-competitions');
$welcome_title =
  get_field('welcome_title') ?: __('A Personal Welcome from JJ', 'nera-competitions');
$welcome_intro =
  get_field('welcome_intro') ?:
  __(
    'Intro text from JJ will be placed here. This is a placeholder for the personal introduction.',
    'nera-competitions',
  );
$welcome_image = get_field('welcome_image');
?>

<section class="welcome-section py-16 lg:py-28 bg-gradient-to-b from-[#fffdfb] to-[#faf7f2] border-t border-[rgba(216,181,130,0.35)] relative overflow-hidden" id="welcome"
  data-aos="fade-up">

  <!-- Subtle warmth on cream (eye-rest band between terracotta blocks) -->
  <div class="absolute inset-0 pointer-events-none overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_30%_40%,rgba(155,80,57,0.06),transparent_55%)]"></div>
  </div>

  <div class="max-w-3xl mx-auto px-4 lg:px-8 relative z-10">

    <div class="space-y-6 welcome-text-content">

      <!-- Avatar + Badge row -->
      <div class="flex items-center gap-4">
        <!-- Passport-style circular avatar (thumbnail) -->
        <div class="w-24 h-24 rounded-full overflow-hidden shrink-0 border-2 border-[#d8b582]/45 bg-stone-100">
          <?php if ($welcome_image && isset($welcome_image['url'])): ?>
            <img src="<?php echo esc_url($welcome_image['url']); ?>"
              alt="<?php echo esc_attr(
                $welcome_image['alt'] ?: __('JJ', 'nera-competitions'),
              ); ?>"
              class="w-full h-full object-cover object-center"
              loading="lazy" />
          <?php else: ?>
            <!-- Placeholder circle for JJ's photo -->
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-stone-100 to-stone-200/80">
              <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"
                class="text-[#9b5039]/40">
                <circle cx="12" cy="8" r="3" />
                <path d="M6 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2" />
              </svg>
            </div>
          <?php endif; ?>
        </div>

        <!-- Badge -->
        <?php if ($welcome_badge): ?>
          <div
            class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-[rgba(155,80,57,0.12)] border border-[rgba(216,181,130,0.35)]">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" class="text-[#c4704e]">
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"
                fill="currentColor" />
            </svg>
            <span class="text-xs font-bold uppercase tracking-widest text-[#9b5039]"><?php echo esc_html(
              $welcome_badge,
            ); ?></span>
          </div>
        <?php endif; ?>
      </div>

      <!-- Title -->
      <h2 class="font-heading text-4xl lg:text-5xl font-black text-[#9b5039] leading-[1.1] tracking-tight">
        <?php echo esc_html($welcome_title); ?>
      </h2>

      <!-- Intro text -->
      <div class="text-lg text-stone-700 leading-relaxed rich-text max-w-none">
        <?php echo wp_kses_post($welcome_intro); ?>
      </div>

    </div>

  </div>
</section>
