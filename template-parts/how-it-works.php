<?php
/**
 * How It Works — Live Life Prizes override
 *
 * Terracotta gradient hero (aligned with About Us) and warm connector accents.
 *
 * @package Nera_Competitions
 *
 * Available variables:
 * $args['steps']           - Array of steps (optional, uses default if not provided)
 * $args['title']           - Section title (optional)
 * $args['subtitle']        - Section subtitle (optional)
 * $args['badge']           - Badge label next to pulse dot (optional)
 * $args['cta_button_text'] - CTA button label (optional)
 * $args['cta_url']         - CTA button URL (optional)
 * $args['cta_target']      - Link target e.g. _blank (optional)
 * $args['cta_footer_text'] - Small line under CTA (optional)
 */

if (!defined('ABSPATH')) {
  exit();
}

$title = isset($args['title']) ? $args['title'] : __('How It Works', 'nera-competitions');
$subtitle = isset($args['subtitle'])
  ? $args['subtitle']
  : __('Win amazing prizes in just 3 simple steps', 'nera-competitions');
$badge = isset($args['badge'])
  ? $args['badge']
  : __('Simple Process', 'nera-competitions');

$default_steps = live_life_prizes_get_hiw_default_hero_steps();
$steps =
  isset($args['steps']) && is_array($args['steps']) && !empty($args['steps'])
    ? $args['steps']
    : $default_steps;

$cta_button_text = isset($args['cta_button_text'])
  ? $args['cta_button_text']
  : __('Start Winning Today', 'nera-competitions');
$cta_url = isset($args['cta_url']) ? $args['cta_url'] : '';
if ($cta_url === '' && function_exists('wc_get_page_id')) {
  $cta_url = (string) get_permalink(wc_get_page_id('shop'));
}
if ($cta_url === '') {
  $cta_url = home_url('/');
}
$cta_footer_text = isset($args['cta_footer_text'])
  ? $args['cta_footer_text']
  : __('Join thousands of winners • New competitions added daily', 'nera-competitions');
$cta_target = isset($args['cta_target']) ? (string) $args['cta_target'] : '';

$hiw_grid_cols = count($steps) >= 4 ? 'lg:grid-cols-4' : 'lg:grid-cols-3';
?>

<section
  class="how-it-works-section relative py-20 lg:py-32 overflow-hidden bg-llp-hero-terracotta"
  id="how-it-works">

  <div class="absolute inset-0 z-0 pointer-events-none opacity-30" aria-hidden="true">
    <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-on-primary/10 blur-[120px]"></div>
    <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] rounded-full bg-indigo-400/20 blur-[120px]"></div>
  </div>
  <div
    class="absolute inset-0 pointer-events-none bg-[radial-gradient(ellipse_at_top_right,rgba(216,181,130,0.12)_0%,transparent_55%)]"
    aria-hidden="true"></div>

  <div class="how-it-works-particles absolute inset-0 overflow-hidden pointer-events-none">
    <div class="particle particle-1"></div>
    <div class="particle particle-2"></div>
    <div class="particle particle-3"></div>
    <div class="particle particle-4"></div>
    <div class="particle particle-5"></div>
    <div class="particle particle-6"></div>
  </div>

  <div
    class="absolute inset-0 opacity-[0.06]"
    style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23d8b582&quot; fill-opacity=&quot;1&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"
    aria-hidden="true"></div>

  <div class="max-w-7xl mx-auto px-4 lg:px-8 relative z-10">

    <div class="text-center mb-16 lg:mb-24 how-it-works-header" data-animate="fade-in-up">

      <div
        class="inline-flex items-center gap-2 px-4 py-2 mb-6 rounded-full bg-on-primary/10 border border-on-primary/25">
        <span class="relative flex h-2 w-2">
          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-on-primary opacity-75"></span>
          <span class="relative inline-flex rounded-full h-2 w-2 bg-on-primary"></span>
        </span>
        <span class="text-sm font-semibold text-on-primary uppercase tracking-wider"><?php echo esc_html(
          $badge,
        ); ?></span>
      </div>

      <h2 class="font-heading text-4xl lg:text-5xl xl:text-6xl font-bold text-on-primary mb-6 leading-tight">
        <?php echo esc_html($title); ?>
      </h2>

      <div class="w-20 h-1 bg-on-primary/80 mx-auto mb-6 rounded-full" aria-hidden="true"></div>

      <p class="text-lg lg:text-xl text-center leading-relaxed font-light italic max-w-2xl mx-auto text-on-primary/85">
        <?php echo esc_html($subtitle); ?>
      </p>
    </div>

    <div class="relative">

      <div class="how-it-works-connector hidden lg:block absolute inset-x-0 top-1/2 -translate-y-1/2 z-0 pointer-events-none" aria-hidden="true">
        <svg class="w-full h-20" viewBox="0 0 1200 80" preserveAspectRatio="none" fill="none"
          xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <path class="how-it-works-path-bg"
            d="M 200 40 Q 500 40 600 40 Q 850 40 1000 40"
            stroke="rgba(216, 181, 130, 0.28)"
            stroke-width="3" stroke-linecap="round" stroke-dasharray="8 8" fill="none" />
          <path class="how-it-works-path-animated"
            d="M 200 40 Q 500 40 600 40 Q 850 40 1000 40" stroke="url(#pathGradientHiw)"
            stroke-width="3" stroke-linecap="round" fill="none" />
          <defs>
            <linearGradient id="pathGradientHiw" x1="0%" y1="0%" x2="100%" y2="0%">
              <stop offset="0%" stop-color="#9b5039" />
              <stop offset="35%" stop-color="#c4704e" />
              <stop offset="70%" stop-color="#b89a6a" />
              <stop offset="100%" stop-color="#d8b582" />
            </linearGradient>
          </defs>
          <circle class="flow-dot flow-dot-1" r="6" fill="#9b5039">
            <animateMotion dur="10s" repeatCount="indefinite"
              path="M 200 40 Q 500 40 600 40 Q 850 40 1000 40" />
          </circle>
          <circle class="flow-dot flow-dot-2" r="6" fill="#c4704e">
            <animateMotion dur="10s" repeatCount="indefinite" begin="2.5s"
              path="M 200 40 Q 500 40 600 40 Q 850 40 1000 40" />
          </circle>
          <circle class="flow-dot flow-dot-3" r="6" fill="#d8b582">
            <animateMotion dur="10s" repeatCount="indefinite" begin="5s"
              path="M 200 40 Q 500 40 600 40 Q 850 40 1000 40" />
          </circle>
        </svg>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 <?php echo esc_attr($hiw_grid_cols); ?> gap-6 lg:gap-8">
        <?php
        $step_number = 1;
        foreach ($steps as $step):

          $delay          = ($step_number - 1) * 150;
          $badge_gradient = isset($step['badge_gradient']) ? $step['badge_gradient'] : 'linear-gradient(to bottom right, #9b5039, #c4704e)';
          ?>
          <div class="how-it-works-step relative group" data-animate="fade-in-up" data-delay="<?php echo $delay; ?>">
            <div class="relative h-full pt-4 pr-4">

              <div
                class="absolute top-0 right-0 w-12 h-12 rounded-2xl flex items-center justify-center text-on-primary font-bold text-lg shadow-lg shadow-primary/25 rotate-12 group-hover:rotate-0 transition-transform duration-300 ease-[cubic-bezier(0.22,1,0.36,1)] z-20 will-change-transform"
                style="background: <?php echo esc_attr($badge_gradient); ?>">
                <?php echo esc_html($step_number); ?>
              </div>

              <div
                class="how-it-works-card relative h-full text-center bg-surface/95 backdrop-blur-sm rounded-3xl p-8 border border-on-primary/15 shadow-lg shadow-black/35 transition-[transform,box-shadow,border-color] duration-300 ease-[cubic-bezier(0.22,1,0.36,1)] group-hover:shadow-xl group-hover:shadow-black/40 group-hover:-translate-y-1 group-hover:border-on-primary/30 overflow-hidden [contain:layout_paint]">

                <div
                  class="pointer-events-none absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-[cubic-bezier(0.22,1,0.36,1)] overflow-hidden rounded-3xl">
                  <div
                    class="absolute inset-0 bg-gradient-to-r from-transparent via-on-primary/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700 ease-[cubic-bezier(0.22,1,0.36,1)] motion-reduce:transition-none motion-reduce:translate-x-0 motion-reduce:group-hover:translate-x-0">
                  </div>
                </div>

                <h3 class="llp-hiw-step__title text-xl font-bold text-text-primary mb-3 group-hover:text-accent transition-colors duration-300 ease-[cubic-bezier(0.22,1,0.36,1)]">
                  <?php echo wp_kses(
                    trim(preg_replace('#^<p>(.*)</p>\s*$#s', '$1', wpautop($step['title']))),
                    [
                      'a'      => ['href' => [], 'title' => [], 'target' => [], 'rel' => []],
                      'strong' => [],
                      'em'     => [],
                      'br'     => [],
                      'span'   => ['class' => []],
                    ]
                  ); ?>
                </h3>

                <div class="llp-hiw-step__desc text-text-secondary leading-relaxed text-sm">
                  <?php echo wp_kses_post(wpautop($step['description'])); ?>
                </div>

              </div>

            </div>

            <?php if ($step_number < count($steps)): ?>
              <div class="flex justify-center py-6 lg:hidden">
                <div class="flex flex-col items-center gap-1">
                  <div class="w-0.5 h-8 rounded-full" style="background: <?php echo esc_attr($badge_gradient); ?>"></div>
                  <svg class="w-5 h-5 text-on-primary/70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                  </svg>
                </div>
              </div>
            <?php endif; ?>

          </div>
          <?php $step_number++;
        endforeach;
        ?>
      </div>
    </div>

    <div class="text-center mt-16 lg:mt-24" data-animate="fade-in-up" data-delay="600">
      <a href="<?php echo esc_url($cta_url); ?>"
        class="how-it-works-cta inline-flex mb-5 items-center gap-3 px-8 py-4 bg-background-light font-semibold rounded-2xl shadow-lg shadow-black/40 hover:shadow-xl hover:shadow-black/50 hover:bg-secondary hover:-translate-y-1 transition-all duration-300 group text-on-primary hover:text-on-primary"<?php echo $cta_target === '_blank' ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>>
        <span><?php echo esc_html($cta_button_text); ?></span>
        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
        </svg>
      </a>
      <p class="text-sm text-on-primary/75">
        <?php echo esc_html($cta_footer_text); ?>
      </p>
    </div>

  </div>

  <?php get_template_part('template-parts/llp-organic-wave', null, ['position' => 'bottom', 'context' => 'hero']); ?>
</section>
