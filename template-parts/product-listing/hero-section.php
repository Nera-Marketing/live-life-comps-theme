<?php
/**
 * Product Listing Hero Section — Live Life Prizes override
 *
 * Terracotta gradient hero ; PHP matches parent.
 *
 * @package Nera_Competitions
 */

if (!defined('ABSPATH')) {
  exit();
}

$post_id = isset($args['post_id']) && $args['post_id'] ? $args['post_id'] : get_the_ID();

$page_title = get_the_title($post_id);
$page_tagline = get_the_excerpt($post_id);

if (empty($page_tagline)) {
  $page_tagline = __(
    'Enter to win amazing prizes with our exclusive competitions.',
    'nera-competitions',
  );
}
?>

<section
  class="product-listing-hero relative overflow-hidden py-16 md:py-20 bg-llp-hero-terracotta"
  aria-labelledby="product-listing-hero-heading">
  <div class="absolute inset-0 z-0 pointer-events-none opacity-30" aria-hidden="true">
    <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-white/10 blur-[120px]"></div>
    <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] rounded-full bg-indigo-400/20 blur-[120px]"></div>
  </div>
  <div
    class="absolute inset-0 pointer-events-none bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.15)_0%,transparent_55%)]"
    aria-hidden="true"></div>

  <div class="max-w-[1200px] mx-auto px-4 lg:px-8 relative z-10">
    <div class="text-center max-w-2xl mx-auto">
      <h1
        id="product-listing-hero-heading"
        class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-tight mb-4 font-heading"
        data-aos="fade-up">
        <?php echo esc_html($page_title); ?>
      </h1>

      <p class="text-lg md:text-xl text-white/85 font-light italic" data-aos="fade-up" data-aos-delay="100">
        <?php echo esc_html($page_tagline); ?>
      </p>
    </div>
  </div>
</section>
