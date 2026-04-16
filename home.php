<?php
/**
 * Blog posts index — Live Life Prizes override
 *
 * Terracotta hero + posts loop (matches product listing / About hero stack).
 *
 * @package Nera_Competitions
 */

if (!defined('ABSPATH')) {
  exit();
}

$page_for_posts = (int) get_option('page_for_posts');
$hero_title = $page_for_posts ? get_the_title($page_for_posts) : __('Blog', 'nera-competitions');
$hero_subtitle = $page_for_posts ? get_the_excerpt($page_for_posts) : '';

get_header();
?>

<main id="primary" class="site-main bg-gray-50 text-text-primary min-h-screen">

  <section
    class="blog-archive-hero relative overflow-hidden py-16 md:py-20 bg-llp-hero-terracotta"
    aria-labelledby="blog-home-hero-heading">
    <div class="absolute inset-0 z-0 pointer-events-none opacity-30" aria-hidden="true">
      <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-on-primary/10 blur-[120px]"></div>
      <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] rounded-full bg-indigo-400/20 blur-[120px]"></div>
    </div>
    <div
      class="absolute inset-0 pointer-events-none bg-[radial-gradient(ellipse_at_top_right,rgba(216,181,130,0.12)_0%,transparent_55%)]"
      aria-hidden="true"></div>

    <div class="container mx-auto px-4 lg:px-8 relative z-10">
      <div class="text-center max-w-2xl mx-auto">
        <h1
          id="blog-home-hero-heading"
          class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-on-primary tracking-tight mb-4 font-heading">
          <?php echo esc_html($hero_title); ?>
        </h1>
        <?php if ($hero_subtitle !== '') : ?>
          <p class="text-lg md:text-xl text-on-primary/85 font-light italic">
            <?php echo esc_html(wp_strip_all_tags($hero_subtitle)); ?>
          </p>
        <?php endif; ?>
      </div>
    </div>

    <!-- Organic wave transition to canvas background -->
    <div class="absolute bottom-0 left-0 right-0 z-10 pointer-events-none leading-none" aria-hidden="true">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 48" preserveAspectRatio="none" class="block w-full h-12">
        <path d="M0,24 C240,48 480,0 720,24 C960,48 1200,0 1440,24 L1440,48 L0,48 Z" fill="#0c0b09"/>
      </svg>
    </div>
  </section>

  <div class="container mx-auto px-4 py-10 md:py-12">
    <?php get_template_part('template-parts/blog/loop'); ?>
  </div>
</main>

<?php get_footer();
