<?php
/**
 * About Us — two-column stories section (reused on About Us + single product pages).
 *
 * @package Live_Life_Prizes
 *
 * @var array $args {
 *     @type string $story_left_title
 *     @type string $story_left_content
 *     @type string $story_right_title
 *     @type string $story_right_content
 *     @type bool   $is_product_context When true, adds llp-product-stories-band modifier class.
 * }
 */

if (!defined('ABSPATH')) {
  exit();
}

$acf_post_id = function_exists('live_life_prizes_about_stories_acf_post_id')
  ? live_life_prizes_about_stories_acf_post_id()
  : false;

$story_left_title = $args['story_left_title'] ?? null;
if ($story_left_title === null) {
  $story_left_title = function_exists('get_field')
    ? get_field('about_story_left_title', $acf_post_id)
    : null;
}
$story_left_title = $story_left_title ?: __('Our story', 'nera-competitions');

$story_left_content = $args['story_left_content'] ?? null;
if ($story_left_content === null) {
  $story_left_content = function_exists('get_field')
    ? get_field('about_story_left_content', $acf_post_id)
    : null;
}

$story_right_title = $args['story_right_title'] ?? null;
if ($story_right_title === null) {
  $story_right_title = function_exists('get_field')
    ? get_field('about_story_right_title', $acf_post_id)
    : null;
}
$story_right_title = $story_right_title ?: __('What drives us', 'nera-competitions');

$story_right_content = $args['story_right_content'] ?? null;
if ($story_right_content === null) {
  $story_right_content = function_exists('get_field')
    ? get_field('about_story_right_content', $acf_post_id)
    : null;
}

if (empty($story_left_content) && empty($story_right_content)) {
  return;
}

$is_product_context = !empty($args['is_product_context']);
if ($is_product_context) {
  // Body already carries terracotta gradient on single product — top spacing via CSS.
  $section_classes = 'pb-16 lg:pb-24 relative overflow-hidden llp-product-stories-band';
  $inner_classes = 'max-w-7xl mx-auto';
} else {
  $section_classes = 'py-16 lg:py-24 relative overflow-hidden bg-llp-hero-terracotta';
  $inner_classes = 'max-w-7xl mx-auto px-4 lg:px-8';
}
?>

<section class="<?php echo esc_attr($section_classes); ?>" aria-labelledby="about-us-stories">
  <div class="<?php echo esc_attr($inner_classes); ?>">
    <div class="grid md:grid-cols-2 gap-10 lg:gap-12">
      <div
        class="bg-surface p-8 lg:p-12 rounded-3xl border border-on-primary/15 shadow-lg transition-all duration-300 hover:border-primary/40 hover:shadow-xl hover:-translate-y-0.5 group"
        data-aos="fade-right">
        <div class="flex items-center gap-4 mb-6">
          <div
            class="w-12 h-12 shrink-0 rounded-full bg-primary/10 flex items-center justify-center text-primary transition-all duration-300 group-hover:bg-primary group-hover:text-on-primary">
            <?php echo llp_about_story_icon_markup($story_left_title); ?>
          </div>
          <h2 class="font-heading text-2xl lg:text-3xl text-text-primary">
            <?php echo esc_html($story_left_title); ?>
          </h2>
        </div>
        <div class="text-text-secondary leading-relaxed max-w-none [&_a]:text-accent [&_a]:underline">
          <?php if ($story_left_content) : ?>
            <?php echo wp_kses_post($story_left_content); ?>
          <?php else : ?>
            <p><?php esc_html_e('We will share more about our journey here.', 'nera-competitions'); ?></p>
          <?php endif; ?>
        </div>
      </div>

      <div
        class="bg-surface p-8 lg:p-12 rounded-3xl border border-on-primary/15 shadow-lg transition-all duration-300 hover:border-primary/40 hover:shadow-xl hover:-translate-y-0.5 group"
        data-aos="fade-left">
        <div class="flex items-center gap-4 mb-6">
          <div
            class="w-12 h-12 shrink-0 rounded-full bg-primary/10 flex items-center justify-center text-primary transition-all duration-300 group-hover:bg-primary group-hover:text-on-primary">
            <?php echo llp_about_story_icon_markup($story_right_title); ?>
          </div>
          <h2 class="font-heading text-2xl lg:text-3xl text-text-primary">
            <?php echo esc_html($story_right_title); ?>
          </h2>
        </div>
        <div class="text-text-secondary leading-relaxed max-w-none [&_a]:text-accent [&_a]:underline">
          <?php if ($story_right_content) : ?>
            <?php echo wp_kses_post($story_right_content); ?>
          <?php else : ?>
            <p><?php esc_html_e('Insights and values will appear here.', 'nera-competitions'); ?></p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
