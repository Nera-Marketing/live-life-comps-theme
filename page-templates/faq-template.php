<?php
/**
 * Template Name: FAQ Page
 * Template Post Type: page
 *
 * Standalone FAQ page reusing the homepage FAQ accordion (Alpine + fallbacks).
 *
 * @package Live_Life_Prizes
 */

if (!defined('ABSPATH')) {
  exit();
}

get_header();

$hero_title = get_the_title();
$hero_subtitle = __(
  'Everything you need to know about our draws, entries, and prizes.',
  'nera-competitions',
);
$hero_badge = __('Help centre', 'nera-competitions');
?>

<main id="main" class="faq-page bg-background-light" role="main">

  <section
    class="faq-page-hero relative py-16 lg:py-24 overflow-hidden bg-llp-hero-terracotta"
    aria-labelledby="faq-page-hero-heading">

    <div class="absolute inset-0 z-0 pointer-events-none opacity-30" aria-hidden="true">
      <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-white/10 blur-[120px]"></div>
      <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] rounded-full bg-indigo-400/20 blur-[120px]"></div>
    </div>
    <div
      class="absolute inset-0 pointer-events-none bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.15)_0%,transparent_55%)]"
      aria-hidden="true"></div>

    <div class="max-w-7xl mx-auto px-4 lg:px-8 relative z-10 text-center">

      <div
        class="inline-flex items-center gap-2 px-4 py-2 mb-6 rounded-full bg-white/10 border border-white/25">
        <span class="relative flex h-2 w-2">
          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
          <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
        </span>
        <span class="text-sm font-semibold text-white uppercase tracking-wider"><?php echo esc_html(
          $hero_badge,
        ); ?></span>
      </div>

      <h1 id="faq-page-hero-heading" class="font-heading text-4xl lg:text-5xl xl:text-6xl font-bold text-white mb-6 leading-tight">
        <?php echo esc_html($hero_title); ?>
      </h1>

      <div class="w-20 h-1 bg-white/80 mx-auto mb-6 rounded-full" aria-hidden="true"></div>

      <p class="text-lg lg:text-xl max-w-2xl mx-auto leading-relaxed font-light text-white/85">
        <?php echo esc_html($hero_subtitle); ?>
      </p>
    </div>
  </section>

  <?php get_template_part('template-parts/homepage/faq-section'); ?>
</main>

<?php
get_footer();
