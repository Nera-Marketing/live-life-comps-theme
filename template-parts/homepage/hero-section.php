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

  <div class="w-full max-w-6xl mx-auto px-6 lg:px-8 flex flex-col items-center relative z-[1]">

    <?php if ($hero_show_badge): ?>
    <span class="inline-block w-fit bg-[rgba(216,181,130,0.12)] text-[#d8b582] border border-[rgba(216,181,130,0.35)] rounded-[20px] py-1.5 px-4 text-[11px] tracking-[2px] uppercase mb-6 font-medium">
      <?php echo esc_html($hero_badge_text); ?>
    </span>
    <?php endif; ?>

    <!-- Video frame: outer = border + shadow; inner = true 16:9 (border on same box as aspect distorts embed ratio). -->
    <div class="w-full rounded-xl overflow-hidden" style="border: 6px solid #d8b582; box-shadow: 10px 12px 0 rgba(155,80,57,0.8), 0 0 50px rgba(216,181,130,0.25);">
      <div class="w-full aspect-[16/9] overflow-hidden relative rounded-md">
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
    </div>

    <!-- Primary CTA - Enter Now (most prominent on page) -->
    <a href="<?php echo esc_url($hero_cta_url); ?>"
      class="hero-primary mt-8 inline-flex items-center gap-2 px-14 py-5 bg-[#0c0b09] text-[#d8b582] rounded font-bold text-lg tracking-[0.2em] uppercase shadow-[0_12px_40px_-12px_rgba(0,0,0,0.45)] transition-all hover:bg-stone-900 hover:text-[#e8c896] hover:shadow-[0_16px_44px_-10px_rgba(0,0,0,0.5)] hover:-translate-y-0.5">
      <?php echo esc_html($hero_cta_text); ?>
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M5 12h14M12 5l7 7-7 7" />
      </svg>
    </a>

  </div>

</section>
