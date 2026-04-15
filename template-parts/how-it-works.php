<?php
/**
 * How It Works — Live Life Prizes override
 *
 * Terracotta gradient hero (aligned with About Us) and warm connector accents.
 *
 * @package Nera_Competitions
 *
 * Available variables:
 * $args['steps']     - Array of steps (optional, uses default if not provided)
 * $args['title']     - Section title (optional)
 * $args['subtitle']  - Section subtitle (optional)
 * $args['badge']     - Badge label next to pulse dot (optional)
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

$default_steps = [
  [
    'icon' =>
      '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
    'title' => __('Create a Free Account', 'nera-competitions'),
    'description' => __(
      'Sign up in seconds — you will need an account to enter our free prize draws.',
      'nera-competitions',
    ),
    'color' => 'from-violet-500 to-purple-600',
    'bg_color' => 'bg-violet-500/10',
  ],
  [
    'icon' =>
      '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>',
    'title' => __('Pick Your Prizes & Secure Your Tickets', 'nera-competitions'),
    'description' => __(
      'Browse live competitions, choose your favourites, and secure your entries.',
      'nera-competitions',
    ),
    'color' => 'from-blue-500 to-cyan-500',
    'bg_color' => 'bg-blue-500/10',
  ],
  [
    'icon' =>
      '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 7l-7 5 7 5V7z"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>',
    'title' => __('Watch the Live Draw', 'nera-competitions'),
    'description' => __(
      'Join us on socials for a fully transparent live draw. Winners are chosen fairly and prizes are delivered to you.',
      'nera-competitions',
    ),
    'color' => 'from-amber-500 to-orange-500',
    'bg_color' => 'bg-amber-500/10',
  ],
];

$steps = isset($args['steps']) && is_array($args['steps']) ? $args['steps'] : $default_steps;
?>

<section
  class="how-it-works-section relative py-20 lg:py-32 overflow-hidden bg-llp-hero-terracotta"
  id="how-it-works">

  <div class="absolute inset-0 z-0 pointer-events-none opacity-30" aria-hidden="true">
    <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-white/10 blur-[120px]"></div>
    <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] rounded-full bg-indigo-400/20 blur-[120px]"></div>
  </div>
  <div
    class="absolute inset-0 pointer-events-none bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.15)_0%,transparent_55%)]"
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
    style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;1&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"
    aria-hidden="true"></div>

  <div class="max-w-7xl mx-auto px-4 lg:px-8 relative z-10">

    <div class="text-center mb-16 lg:mb-24 how-it-works-header" data-animate="fade-in-up">

      <div
        class="inline-flex items-center gap-2 px-4 py-2 mb-6 rounded-full bg-white/10 border border-white/25">
        <span class="relative flex h-2 w-2">
          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
          <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
        </span>
        <span class="text-sm font-semibold text-white uppercase tracking-wider"><?php echo esc_html(
          $badge,
        ); ?></span>
      </div>

      <h2 class="font-heading text-4xl lg:text-5xl xl:text-6xl font-bold text-white mb-6 leading-tight">
        <?php echo esc_html($title); ?>
      </h2>

      <div class="w-20 h-1 bg-white/80 mx-auto mb-6 rounded-full" aria-hidden="true"></div>

      <p class="text-lg lg:text-xl text-center leading-relaxed font-light italic max-w-2xl mx-auto text-white/85">
        <?php echo esc_html($subtitle); ?>
      </p>
    </div>

    <div class="relative">

      <div class="hidden lg:block absolute top-[120px] left-0 right-0 z-0">
        <svg class="w-full h-20" viewBox="0 0 1200 80" preserveAspectRatio="none" fill="none"
          xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <path class="how-it-works-path-bg"
            d="M 200 40 Q 500 40 600 40 Q 850 40 1000 40"
            stroke="rgba(255, 255, 255, 0.28)"
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
            <animateMotion dur="4s" repeatCount="indefinite"
              path="M 200 40 Q 500 40 600 40 Q 850 40 1000 40" />
          </circle>
          <circle class="flow-dot flow-dot-2" r="6" fill="#c4704e">
            <animateMotion dur="4s" repeatCount="indefinite" begin="1s"
              path="M 200 40 Q 500 40 600 40 Q 850 40 1000 40" />
          </circle>
          <circle class="flow-dot flow-dot-3" r="6" fill="#d8b582">
            <animateMotion dur="4s" repeatCount="indefinite" begin="2s"
              path="M 200 40 Q 500 40 600 40 Q 850 40 1000 40" />
          </circle>
        </svg>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
        <?php
        $step_number = 1;
        foreach ($steps as $step):

          $delay = ($step_number - 1) * 150;
          $color = isset($step['color']) ? $step['color'] : 'from-primary to-primary-dark';
          $bg_color = isset($step['bg_color']) ? $step['bg_color'] : 'bg-primary/10';
          ?>
          <div class="how-it-works-step relative group" data-animate="fade-in-up" data-delay="<?php echo $delay; ?>">
            <div class="relative h-full pt-4 pr-4">

              <div
                class="absolute top-0 right-0 w-12 h-12 bg-gradient-to-br <?php echo esc_attr(
                  $color,
                ); ?> rounded-2xl flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-primary/25 rotate-12 group-hover:rotate-0 transition-transform duration-300 ease-[cubic-bezier(0.22,1,0.36,1)] z-20 will-change-transform">
                <?php echo esc_html($step_number); ?>
              </div>

              <div
                class="how-it-works-card relative h-full bg-surface/95 backdrop-blur-sm rounded-3xl p-8 border border-white/15 shadow-lg shadow-black/35 transition-[transform,box-shadow,border-color] duration-300 ease-[cubic-bezier(0.22,1,0.36,1)] group-hover:shadow-xl group-hover:shadow-black/40 group-hover:-translate-y-1 group-hover:border-white/25 overflow-hidden [contain:layout_paint]">

                <div
                  class="pointer-events-none absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-[cubic-bezier(0.22,1,0.36,1)] overflow-hidden rounded-3xl">
                  <div
                    class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700 ease-[cubic-bezier(0.22,1,0.36,1)] motion-reduce:transition-none motion-reduce:translate-x-0 motion-reduce:group-hover:translate-x-0">
                  </div>
                </div>

                <div class="relative mb-6">
                  <div
                    class="w-20 h-20 <?php echo esc_attr(
                      $bg_color,
                    ); ?> rounded-2xl flex items-center justify-center group-hover:scale-105 transition-transform duration-300 ease-[cubic-bezier(0.22,1,0.36,1)] will-change-transform">
                    <div class="text-text-secondary group-hover:text-primary transition-colors duration-250 ease-[cubic-bezier(0.22,1,0.36,1)]">
                      <?php echo $step['icon']; ?>
                    </div>
                  </div>
                  <div
                    class="pointer-events-none absolute inset-0 w-20 h-20 rounded-2xl ring-0 ring-primary/25 group-hover:ring-2 transition-[box-shadow] duration-300 ease-[cubic-bezier(0.22,1,0.36,1)]"
                    aria-hidden="true"></div>
                </div>

                <h3 class="text-xl font-bold text-text-primary mb-3 group-hover:text-accent transition-colors duration-300 ease-[cubic-bezier(0.22,1,0.36,1)]">
                  <?php echo esc_html($step['title']); ?>
                </h3>

                <p class="text-text-secondary leading-relaxed text-sm">
                  <?php echo esc_html($step['description']); ?>
                </p>

              </div>

            </div>

            <?php if ($step_number < count($steps)): ?>
              <div class="flex justify-center py-6 lg:hidden">
                <div class="flex flex-col items-center gap-1">
                  <div class="w-0.5 h-8 bg-gradient-to-b <?php echo esc_attr(
                    $color,
                  ); ?> rounded-full"></div>
                  <svg class="w-5 h-5 text-white/70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
      <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>"
        class="how-it-works-cta inline-flex mb-5 items-center gap-3 px-8 py-4 bg-gradient-to-r from-primary to-primary-dark font-semibold rounded-2xl shadow-lg shadow-primary/25 hover:shadow-xl hover:shadow-primary/30 hover:-translate-y-1 transition-all duration-300 group text-white hover:text-white">
        <span><?php esc_html_e('Start Winning Today', 'nera-competitions'); ?></span>
        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
        </svg>
      </a>
      <p class="text-sm text-white/75">
        <?php esc_html_e('Join thousands of winners • New competitions added daily', 'nera-competitions'); ?>
      </p>
    </div>

  </div>
</section>
