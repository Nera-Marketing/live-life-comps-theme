<?php
/**
 * Logo Banner Section
 *
 * Full-width centred band featuring the primary (sun) logo.
 * Renders above the hero for strong brand visibility.
 *
 * @package Nera_Competitions
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit();
}

// Primary logo: ACF first, then Customizer custom_logo
$logo_url = null;
if (function_exists('get_field')) {
  $logo_url = get_field('logo_primary', 'option');
}
if (empty($logo_url) && has_custom_logo()) {
  $custom_logo_id = get_theme_mod('custom_logo');
  $logo_src = wp_get_attachment_image_src($custom_logo_id, 'full');
  if ($logo_src) {
    $logo_url = $logo_src[0];
  }
}

if (empty($logo_url)) {
  return;
}

$site_name = get_bloginfo('name');
?>
<section class="logo-banner relative overflow-hidden py-8 lg:py-10 bg-llp-hero-terracotta-b border-b border-[rgba(216,181,130,0.15)]" id="logo-banner" data-aos="fade-in" data-aos-duration="1000">

  <!-- Radial glow behind the logo (subtle VLB gold on dark canvas) -->
  <div class="absolute inset-0 flex items-center justify-center pointer-events-none" aria-hidden="true">
    <div class="w-[480px] h-[320px] rounded-full bg-[#d8b582] opacity-[0.06] blur-[72px]"></div>
  </div>

  <div class="relative w-full max-w-6xl mx-auto px-6 lg:px-8 flex items-center justify-center gap-6">

    <!-- Left flanking line -->
    <div class="hidden sm:flex flex-1 max-w-[180px] lg:max-w-xs items-center gap-2">
      <div class="flex-1 h-px bg-gradient-to-r from-transparent to-[rgba(216,181,130,0.35)]"></div>
      <span class="text-[rgba(216,181,130,0.4)] text-[8px] leading-none">◆</span>
    </div>

    <!-- Logo -->
    <a href="<?php echo esc_url(home_url('/')); ?>" class="block flex-shrink-0 focus:outline-none focus:ring-2 focus:ring-[#d8b582]/50 rounded">
      <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($site_name); ?>"
        class="max-h-[100px] lg:max-h-[250px] w-auto object-contain mx-auto">
    </a>

    <!-- Right flanking line -->
    <div class="hidden sm:flex flex-1 max-w-[180px] lg:max-w-xs items-center gap-2">
      <span class="text-[rgba(216,181,130,0.4)] text-[8px] leading-none">◆</span>
      <div class="flex-1 h-px bg-gradient-to-l from-transparent to-[rgba(216,181,130,0.35)]"></div>
    </div>

  </div>
</section>
