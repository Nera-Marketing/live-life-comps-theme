<?php
/**
 * Homepage winners anchor + CTA (testimonials links to #winners).
 *
 * Full winners grid lives on the Winners page template; this block provides
 * a visible section and stable anchor when the former file was empty.
 *
 * @package Nera_Competitions
 */

if (!defined('ABSPATH')) {
  exit();
}

$winners_url = home_url('/winners/');
if (function_exists('get_pages')) {
  $winners_pages = get_pages([
    'meta_key' => '_wp_page_template',
    'meta_value' => 'page-templates/winners-template.php',
    'number' => 1,
  ]);
  if (!empty($winners_pages[0])) {
    $winners_url = get_permalink($winners_pages[0]->ID);
  }
}
?>

<section
  id="winners"
  class="winners-home-section py-14 lg:py-16 px-6 lg:px-20 bg-[#0c0b09] border-t border-[rgba(216,181,130,0.08)]"
  data-aos="fade-up"
  role="region"
  aria-label="<?php esc_attr_e('Winners', 'nera-competitions'); ?>">

  <div class="max-w-4xl mx-auto text-center">
    <p class="text-[11px] uppercase tracking-[2px] text-[#c4704e] mb-3 font-medium">
      <?php esc_html_e('Real winners', 'nera-competitions'); ?>
    </p>
    <h2 class="font-heading text-2xl lg:text-3xl text-[#d8b582] mb-4">
      <?php esc_html_e('See who has won', 'nera-competitions'); ?>
    </h2>
    <p class="text-base text-[rgba(216,181,130,0.85)] mb-8 max-w-2xl mx-auto leading-relaxed">
      <?php esc_html_e('Browse verified winners and prize stories on our dedicated winners page.', 'nera-competitions'); ?>
    </p>
    <a
      href="<?php echo esc_url($winners_url); ?>"
      class="inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-xl font-semibold text-sm tracking-wide uppercase bg-gradient-to-r from-[#9b5039] to-[#c4704e] text-[#d8b582 shadow-[0_10px_20px_-10px_rgba(155,80,57,0.35)] transition-all duration-300 hover:-translate-y-0.5">
      <?php esc_html_e('View all winners', 'nera-competitions'); ?>
      <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
      </svg>
    </a>
  </div>
</section>
