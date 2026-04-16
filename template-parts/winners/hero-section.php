<?php
/**
 * Winners Page — Hero Section (child override)
 *
 * Full-width terracotta hero aligned with product listing / blog archives.
 *
 * @package Live_Life_Prizes
 */

if (!defined('ABSPATH')) {
  exit();
}

$heading = function_exists('get_field') ? get_field('winners_heading') : __('Recent Winners', 'nera-competitions');
$subheading = function_exists('get_field') ? get_field('winners_subheading') : __('Our Lucky Winners', 'nera-competitions');
$description = function_exists('get_field') ? get_field('winners_description') : '';

$heading = $heading ?: __('Recent Winners', 'nera-competitions');
$subheading = $subheading ?: __('Our Lucky Winners', 'nera-competitions');
?>

<section
  class="winners-page-hero relative overflow-hidden py-16 md:py-20 bg-llp-hero-terracotta"
  aria-labelledby="winners-hero-heading">
  <div class="absolute inset-0 z-0 pointer-events-none opacity-30" aria-hidden="true">
    <div class="absolute -top-[10%] -left-[10%] h-[40%] w-[40%] rounded-full bg-on-primary/10 blur-[120px]"></div>
    <div class="absolute -bottom-[10%] -right-[10%] h-[40%] w-[40%] rounded-full bg-indigo-400/20 blur-[120px]"></div>
  </div>
  <div
    class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(216,181,130,0.12)_0%,transparent_55%)]"
    aria-hidden="true"></div>

  <div class="relative z-10 mx-auto max-w-4xl px-5 text-center sm:px-6 lg:px-8">
    <?php if ($subheading) : ?>
      <div class="mb-6 flex justify-center" data-aos="fade-up">
        <span
          class="inline-flex items-center rounded-full border border-on-primary/25 bg-on-primary/10 px-4 py-2 text-sm font-semibold text-on-primary">
          <svg class="mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path
              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
          </svg>
          <?php echo esc_html($subheading); ?>
        </span>
      </div>
    <?php endif; ?>

    <h1
      id="winners-hero-heading"
      class="mb-6 font-heading text-4xl font-bold text-on-primary lg:text-5xl xl:text-6xl"
      data-aos="fade-up"
      data-aos-delay="100">
      <?php echo esc_html($heading); ?>
    </h1>

    <?php if ($description) : ?>
      <p
        class="mx-auto max-w-2xl text-lg leading-relaxed text-on-primary/85 lg:text-xl"
        data-aos="fade-up"
        data-aos-delay="200">
        <?php echo esc_html($description); ?>
      </p>
    <?php endif; ?>
  </div>

  <!-- Organic wave transition to canvas background -->
  <div class="absolute bottom-0 left-0 right-0 z-10 pointer-events-none leading-none" aria-hidden="true">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 48" preserveAspectRatio="none" class="block w-full h-12">
      <path d="M0,24 C240,48 480,0 720,24 C960,48 1200,0 1440,24 L1440,48 L0,48 Z" fill="#0c0b09"/>
    </svg>
  </div>
</section>
