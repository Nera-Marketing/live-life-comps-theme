<?php
/**
 * Product Listing Trust Features — Live Life Prizes override
 *
 * Terracotta gradient section with elevated cards; PHP/ACF matches parent.
 *
 * @package Nera_Competitions
 */

if (!defined('ABSPATH')) {
  exit();
}

$section_title = __('Why Choose Us', 'nera-competitions');
$section_subtitle = __(
  'Join thousands of happy winners who trust us for fair and exciting competitions.',
  'nera-competitions',
);

$trust_features = [
  [
    'icon' =>
      '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>',
    'title' => __('Secure Checkout', 'nera-competitions'),
    'description' => __(
      'Your payment details are protected with bank-level encryption.',
      'nera-competitions',
    ),
  ],
  [
    'icon' =>
      '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>',
    'title' => __('Certified Winners', 'nera-competitions'),
    'description' => __(
      'All draws are independently verified and transparent.',
      'nera-competitions',
    ),
  ],
  [
    'icon' =>
      '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>',
    'title' => __('24/7 Support', 'nera-competitions'),
    'description' => __('Our friendly team is here to help anytime you need.', 'nera-competitions'),
  ],
];

if (function_exists('get_field')) {
  $context_id = isset($args['post_id']) && $args['post_id'] ? $args['post_id'] : get_the_ID();

  $acf_title = get_field('trust_title', $context_id);
  if ($acf_title) {
    $section_title = $acf_title;
  }

  $acf_subtitle = get_field('trust_subtitle', $context_id);
  if ($acf_subtitle) {
    $section_subtitle = $acf_subtitle;
  }

  if (have_rows('trust_badges', $context_id)) {
    $acf_features = [];
    while (have_rows('trust_badges', $context_id)) {
      the_row();
      $icon = get_sub_field('icon');
      $title = get_sub_field('title');
      $desc = get_sub_field('description');

      if ($title) {
        $acf_features[] = [
          'icon' => $icon,
          'title' => $title,
          'description' => $desc,
        ];
      }
    }

    if (!empty($acf_features)) {
      $trust_features = $acf_features;
    }
  }
}
?>

<section
  class="trust-features-section relative overflow-hidden py-16 md:py-20 bg-gradient-to-br from-primary via-primary to-primary-dark"
  aria-labelledby="trust-features-heading">
  <div class="absolute inset-0 z-0 pointer-events-none opacity-30" aria-hidden="true">
    <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-white/10 blur-[120px]"></div>
    <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] rounded-full bg-indigo-400/20 blur-[120px]"></div>
  </div>
  <div
    class="absolute inset-0 pointer-events-none bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.15)_0%,transparent_55%)]"
    aria-hidden="true"></div>

  <div class="max-w-[1200px] mx-auto px-4 lg:px-8 relative z-10">

    <div class="text-center mb-12">
      <h2
        id="trust-features-heading"
        class="text-2xl md:text-3xl font-extrabold text-white tracking-tight font-heading"
        data-aos="fade-up">
        <?php echo esc_html($section_title); ?>
      </h2>
      <p class="text-white/80 font-medium mt-2 max-w-xl mx-auto" data-aos="fade-up" data-aos-delay="100">
        <?php echo esc_html($section_subtitle); ?>
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <?php foreach ($trust_features as $index => $feature): ?>
        <div
          class="text-center p-8 bg-surface/95 backdrop-blur-sm rounded-2xl border border-white/15 shadow-lg shadow-black/20 hover:border-white/25 hover:shadow-xl hover:shadow-black/30 hover:-translate-y-0.5 transition-all duration-300"
          data-aos="fade-up" data-aos-delay="<?php echo esc_attr(($index + 1) * 100); ?>">

          <div class="inline-flex items-center justify-center w-16 h-16 bg-white/15 text-on-primary rounded-2xl mb-5">
            <?php echo $feature['icon']; ?>
          </div>

          <h3 class="text-lg font-bold text-text-primary mb-2 font-heading">
            <?php echo esc_html($feature['title']); ?>
          </h3>

          <p class="text-text-secondary text-sm leading-relaxed">
            <?php echo esc_html($feature['description']); ?>
          </p>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>
