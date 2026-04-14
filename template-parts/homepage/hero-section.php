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
  class="hero-section flex flex-col items-center justify-center py-16 lg:py-24 bg-[#0c0b09] overflow-hidden"
  id="hero" data-aos="fade-up" data-aos-duration="600">

  <div class="w-full max-w-6xl mx-auto px-6 lg:px-8 flex flex-col items-center">

    <?php if ($hero_show_badge): ?>
    <span class="inline-block w-fit bg-[rgba(155,80,57,0.2)] text-[#c4704e] rounded-[20px] py-1.5 px-4 text-[11px] tracking-[2px] uppercase mb-6 font-medium">
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
        <div class="hero-video-placeholder w-full h-full flex flex-col items-center justify-center gap-3 bg-[rgba(216,181,130,0.05)]">
          <div class="play-btn w-[60px] h-[60px] rounded-full border-[1.5px] border-[rgba(216,181,130,0.56)] flex items-center justify-center hover:bg-[#d8b582] hover:border-[#d8b582] transition-all cursor-pointer">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#d8b582" stroke-width="1.5"><polygon points="10 8 16 12 10 16 10 8"/></svg>
          </div>
          <span class="text-[12px] text-[rgba(216,181,130,0.2)] tracking-[2px] uppercase"><?php _e('Competition video coming soon', 'nera-competitions'); ?></span>
        </div>
      <?php endif; ?>
    </div>

    <!-- Primary CTA - Enter Now (most prominent on page) -->
    <a href="<?php echo esc_url($hero_cta_url); ?>"
      class="hero-primary mt-8 inline-flex items-center gap-2 px-14 py-5 bg-[#d8b582] text-[#0c0b09] rounded font-bold text-lg tracking-[0.2em] uppercase transition-all hover:bg-[#c4704e] hover:text-[#d8b582]">
      <?php echo esc_html($hero_cta_text); ?>
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M5 12h14M12 5l7 7-7 7" />
      </svg>
    </a>

  </div>

</section>
