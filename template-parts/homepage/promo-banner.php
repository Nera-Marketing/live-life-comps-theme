<?php
/**
 * Follow Us on Socials Section
 *
 * Social media follow banner for the homepage
 * Features dark blue gradient background with social platform links
 *
 * @package Nera_Competitions
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit();
}

// Section content from ACF
$banner = [
  'badge' => get_field('promo_badge') ?: __('Stay Connected', 'nera-competitions'),
  'title' => get_field('promo_title') ?: __('Follow us on socials', 'nera-competitions'),
  'description' =>
    get_field('promo_description') ?:
    __('Follow us for updates, new competitions and giveaways.', 'nera-competitions'),
  'background_image' =>
    get_field('promo_bg_image') ?:
    'https://images.unsplash.com/photo-1603584173870-7f23fdae1b7a?w=1200&h=400&fit=crop',
];

// Social links from ACF repeater
$social_links = get_field('promo_social_links');

// Fallback defaults if no social links configured
if (empty($social_links)) {
  $social_links = [
    ['platform' => 'facebook', 'url' => '#'],
    ['platform' => 'instagram', 'url' => '#'],
  ];
}
?>

<section class="promo-banner-section py-8 lg:py-12" id="social-follow" data-aos="fade-up">
  <div class="max-w-6xl mx-auto px-4 lg:px-8">

    <!-- Banner Container -->
    <div class="promo-banner relative overflow-hidden rounded-2xl lg:rounded-3xl bg-[#1a1815]">

      <!-- Background with Gradient Overlay -->
      <div class="absolute inset-0">
        <img src="<?php echo esc_url($banner['background_image']); ?>" alt=""
          class="w-full h-full object-cover object-center" aria-hidden="true">
        <!-- Earthy Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#1a1815]/95 via-[#1a1815]/90 to-[#1a1815]/80"></div>
      </div>

      <!-- Content -->
      <div class="relative z-10 px-8 py-12 lg:px-12 lg:py-16 flex flex-col items-center text-center">

        <!-- Badge -->
        <span
          class="inline-block px-4 py-1.5 mb-6 text-xs font-bold uppercase tracking-wider rounded-full bg-[rgba(155,80,57,0.2)] text-[#d8b582]">
          <?php echo esc_html($banner['badge']); ?>
        </span>

        <!-- Title -->
        <h2 class="font-heading text-3xl lg:text-4xl xl:text-5xl font-bold mb-4 leading-tight !text-on-primary">
          <?php echo esc_html($banner['title']); ?>
        </h2>

        <!-- Description -->
        <p class="text-base lg:text-lg text-on-primary/80 mb-10 leading-relaxed max-w-lg">
          <?php echo esc_html($banner['description']); ?>
        </p>

        <!-- Social Links -->
        <?php if (!empty($social_links)): ?>
          <div class="flex flex-wrap justify-center gap-5 sm:gap-8">
            <?php foreach ($social_links as $link):

              $platform = $link['platform'] ?? '';
              $url = $link['url'] ?? '#';
              $icon = nera_get_social_icon($platform);
              $label = nera_get_social_label($platform);

              if (empty($platform)) {
                continue;
              }
              ?>
              <a href="<?php echo esc_url($url); ?>"
                target="_blank"
                rel="noopener noreferrer"
                class="group flex flex-col items-center gap-3 transition-all duration-300 hover:-translate-y-1"
                aria-label="<?php echo esc_attr(
                  sprintf(__('Follow us on %s', 'nera-competitions'), $label),
                ); ?>">

                <!-- Icon Container -->
                <span
                  class="flex items-center justify-center w-14 h-14 rounded-full bg-on-primary/10 backdrop-blur-sm text-on-primary group-hover:bg-on-primary/20 group-hover:scale-110 transition-all duration-300">
                  <?php echo $icon; ?>
                </span>

                <!-- Label -->
                <span class="text-sm font-medium text-on-primary/80 group-hover:text-on-primary transition-colors duration-300">
                  <?php echo esc_html($label); ?>
                </span>

              </a>
            <?php
            endforeach; ?>
          </div>
        <?php endif; ?>

      </div>

    </div>

  </div>
</section>
