<?php
/**
 * Hero Section Template Part
 *
 * Full-width centred video hero for the homepage.
 * Video showcases the current live competition; Enter Now is the primary CTA.
 *
 * @package Nera_Competitions
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit();
}

// Badge visibility and text
$hero_show_badge = (bool) get_field('hero_show_badge');
$hero_badge_text = get_field('hero_badge_text') ?: __('Live Now', 'nera-competitions');

// CTA (primary, most prominent on page)
$hero_cta_text = get_field('hero_cta_text') ?: __('Enter Now', 'nera-competitions');
$hero_cta_url = get_field('hero_cta_url') ?: get_permalink(wc_get_page_id('shop'));

// Hero media (video preferred; image kept for backwards compatibility)
$hero_media_type = get_field('hero_media_type') ?: 'image';
$hero_image = get_field('hero_image');
$hero_video = get_field('hero_video');
$hero_video_iframe_raw = get_field('hero_video_iframe', get_queried_object_id(), false);
$hero_video_iframe = '';
if ($hero_video_iframe_raw) {
  if (
    preg_match(
      '#(?:youtube\.com/(?:live|embed)/([a-zA-Z0-9_-]+)|youtube\.com/watch\?v=([a-zA-Z0-9_-]+)|youtu\.be/([a-zA-Z0-9_-]+))#i',
      $hero_video_iframe_raw,
      $m,
    )
  ) {
    $id = !empty($m[1]) ? $m[1] : (!empty($m[2]) ? $m[2] : $m[3]);
    $hero_video_iframe = sprintf(
      '<iframe width="560" height="315" src="%s" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>',
      esc_url('https://www.youtube.com/embed/' . $id . '?autoplay=1&mute=1'),
    );
  } elseif (
    preg_match(
      '#(?:vimeo\.com/(?:video/)?(\d+)|player\.vimeo\.com/video/(\d+))#i',
      $hero_video_iframe_raw,
      $m,
    )
  ) {
    $id = !empty($m[1]) ? $m[1] : $m[2];
    $hero_video_iframe = sprintf(
      '<iframe width="560" height="315" src="%s" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>',
      esc_url('https://player.vimeo.com/video/' . $id . '?autoplay=1&muted=1'),
    );
  } else {
    $hero_video_iframe = wp_oembed_get($hero_video_iframe_raw) ?: '';
  }
}
?>

<section
  class="hero-section relative flex flex-col items-center justify-center py-16 lg:py-24 bg-llp-hero-terracotta-b overflow-hidden"
  id="hero" data-aos="fade-up" data-aos-duration="600">

  <!-- Decorative sun motif — echoes the hand-drawn brand logo -->
  <div class="absolute -top-8 -right-8 lg:top-4 lg:right-4 w-60 h-60 lg:w-80 lg:h-80 opacity-[0.08] pointer-events-none z-0" aria-hidden="true">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 240 240" fill="none">
      <circle cx="120" cy="120" r="22" fill="#d8b582"/>
      <path d="M120 97 L119 18" stroke="#d8b582" stroke-width="3" stroke-linecap="round"/>
      <path d="M120 143 L121 222" stroke="#d8b582" stroke-width="3" stroke-linecap="round"/>
      <path d="M143 120 L222 121" stroke="#d8b582" stroke-width="3" stroke-linecap="round"/>
      <path d="M97 120 L18 119" stroke="#d8b582" stroke-width="3" stroke-linecap="round"/>
      <path d="M136 104 L199 41" stroke="#d8b582" stroke-width="2.5" stroke-linecap="round"/>
      <path d="M104 136 L41 199" stroke="#d8b582" stroke-width="2.5" stroke-linecap="round"/>
      <path d="M104 104 L41 41" stroke="#d8b582" stroke-width="2.5" stroke-linecap="round"/>
      <path d="M136 136 L199 199" stroke="#d8b582" stroke-width="2.5" stroke-linecap="round"/>
      <path d="M129 99 L152 48" stroke="#d8b582" stroke-width="1.5" stroke-linecap="round"/>
      <path d="M141 111 L192 88" stroke="#d8b582" stroke-width="1.5" stroke-linecap="round"/>
      <path d="M141 129 L192 152" stroke="#d8b582" stroke-width="1.5" stroke-linecap="round"/>
      <path d="M129 141 L152 192" stroke="#d8b582" stroke-width="1.5" stroke-linecap="round"/>
      <path d="M111 141 L88 192" stroke="#d8b582" stroke-width="1.5" stroke-linecap="round"/>
      <path d="M99 129 L48 152" stroke="#d8b582" stroke-width="1.5" stroke-linecap="round"/>
      <path d="M99 111 L48 88" stroke="#d8b582" stroke-width="1.5" stroke-linecap="round"/>
      <path d="M111 99 L88 48" stroke="#d8b582" stroke-width="1.5" stroke-linecap="round"/>
    </svg>
  </div>

  <!-- Organic wave transition to canvas background -->
  <div class="absolute bottom-0 left-0 right-0 z-10 pointer-events-none leading-none" aria-hidden="true">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 48" preserveAspectRatio="none" class="block w-full h-12">
      <path d="M0,24 C240,48 480,0 720,24 C960,48 1200,0 1440,24 L1440,48 L0,48 Z" fill="#0c0b09"/>
    </svg>
  </div>

  <div class="w-full max-w-6xl mx-auto px-6 lg:px-8 flex flex-col items-center relative z-[1]">

    <?php if ($hero_show_badge): ?>
    <span class="inline-block w-fit bg-[rgba(216,181,130,0.12)] text-[#d8b582] border border-[rgba(216,181,130,0.35)] rounded-[20px] py-1.5 px-4 text-[11px] tracking-[2px] uppercase mb-6 font-medium">
      <?php echo esc_html($hero_badge_text); ?>
    </span>
    <?php endif; ?>

    <!-- Video frame (gold border, glow) -->
    <div class="w-full aspect-[16/9] rounded-xl overflow-hidden border-2 border-[#d8b582] shadow-[0_0_40px_rgba(216,181,130,0.2)] relative">
      <?php if ($hero_media_type === 'image' && $hero_image): ?>
        <img src="<?php echo esc_url($hero_image); ?>" alt="" class="w-full h-full object-cover">
      <?php elseif ($hero_media_type === 'video' && $hero_video): ?>
        <video src="<?php echo esc_url($hero_video); ?>" controls playsinline preload="metadata" class="w-full h-full object-cover"></video>
      <?php elseif ($hero_media_type === 'video_iframe' && $hero_video_iframe): ?>
        <div class="relative size-full [&_iframe]:absolute [&_iframe]:inset-0 [&_iframe]:size-full">
          <?php echo $hero_video_iframe; ?>
        </div>
      <?php else: ?>
        <div class="hero-video-placeholder w-full h-full flex flex-col items-center justify-center gap-3 bg-[rgba(12,11,9,0.25)]">
          <div class="play-btn w-[60px] h-[60px] rounded-full border-[1.5px] border-[rgba(216,181,130,0.56)] flex items-center justify-center hover:bg-[#d8b582] hover:border-[#d8b582] transition-all cursor-pointer">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#d8b582" stroke-width="1.5"><polygon points="10 8 16 12 10 16 10 8"/></svg>
          </div>
          <span class="text-[12px] text-[rgba(216,181,130,0.85)] tracking-[2px] uppercase"><?php _e('Competition video coming soon', 'nera-competitions'); ?></span>
        </div>
      <?php endif; ?>
    </div>

    <!-- Primary CTA - Enter Now (most prominent on page) -->
    <a href="<?php echo esc_url($hero_cta_url); ?>"
      class="hero-primary mt-8 inline-flex items-center gap-2 px-14 py-5 bg-[#d8b582] text-[#1c1917] rounded font-bold text-lg tracking-[0.2em] uppercase shadow-[0_12px_40px_-12px_rgba(155,80,57,0.35)] transition-all hover:bg-[#9b5039] hover:text-[#d8b582] hover:shadow-[0_16px_44px_-10px_rgba(155,80,57,0.45)] hover:-translate-y-0.5">
      <?php echo esc_html($hero_cta_text); ?>
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M5 12h14M12 5l7 7-7 7" />
      </svg>
    </a>

  </div>

</section>
