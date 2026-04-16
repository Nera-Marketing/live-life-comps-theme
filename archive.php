<?php
/**
 * Archive pages — Live Life Prizes override
 *
 * Terracotta hero + blog loop.
 *
 * @package Nera_Competitions
 */

if (!defined('ABSPATH')) {
  exit();
}

$archive_title = get_the_archive_title();
$archive_description = get_the_archive_description();

get_header();
?>

<main id="primary" class="site-main bg-gradient-to-b from-[#fffdfb] to-[#faf7f2] text-stone-900 min-h-screen">

  <section
    class="blog-archive-hero relative overflow-hidden py-16 md:py-20 bg-llp-hero-terracotta"
    aria-labelledby="blog-archive-hero-heading">
    <div class="absolute inset-0 z-0 pointer-events-none opacity-30" aria-hidden="true">
      <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-on-primary/10 blur-[120px]"></div>
      <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] rounded-full bg-indigo-400/20 blur-[120px]"></div>
    </div>
    <div
      class="absolute inset-0 pointer-events-none bg-[radial-gradient(ellipse_at_top_right,rgba(216,181,130,0.12)_0%,transparent_55%)]"
      aria-hidden="true"></div>

    <div class="container mx-auto px-4 lg:px-8 relative z-10">
      <header class="max-w-3xl mx-auto text-center">
        <h1
          id="blog-archive-hero-heading"
          class="font-heading text-3xl font-bold text-on-primary md:text-4xl lg:text-5xl">
          <?php echo wp_kses_post($archive_title); ?>
        </h1>
        <?php if ($archive_description !== '') : ?>
          <div class="mt-3 max-w-2xl mx-auto text-base text-on-primary/80 md:text-lg [&_p]:mt-2 [&_p:first-child]:mt-0">
            <?php echo wp_kses_post($archive_description); ?>
          </div>
        <?php endif; ?>
      </header>
    </div>

    <!-- Organic wave transition to canvas background -->
    <div class="absolute bottom-0 left-0 right-0 z-10 pointer-events-none leading-none" aria-hidden="true">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 48" preserveAspectRatio="none" class="block w-full h-12">
        <path d="M0,24 C240,48 480,0 720,24 C960,48 1200,0 1440,24 L1440,48 L0,48 Z" fill="#0c0b09"/>
      </svg>
    </div>
  </section>

  <div class="container mx-auto px-4 py-10 md:py-12">
    <?php
    get_template_part('template-parts/blog/loop', null, [
      'empty_description' => __('No content matches this archive.', 'nera-competitions'),
    ]);
    ?>
  </div>
</main>

<?php get_footer();
