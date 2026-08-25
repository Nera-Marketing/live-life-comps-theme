<?php
/**
 * Related Competitions Template Part (child override)
 *
 * Upsells from WooCommerce Linked Products are hoisted to the front and badged.
 *
 * @package Live_Life_Prizes
 */

if (!defined('ABSPATH')) {
  exit();
}

$product = isset($args['product']) ? $args['product'] : null;
$related_ids = isset($args['related_ids']) ? $args['related_ids'] : [];
$upsell_ids = isset($args['upsell_ids']) ? array_map('intval', (array) $args['upsell_ids']) : [];

if (!$product || empty($related_ids)) {
  return;
}

$product_id = $product->get_id();

$section_title = get_field('related_section_title', $product_id);
if (empty($section_title)) {
  $section_title = __('More Competitions You Might Like', 'nera-competitions');
}
?>

<div class="related-competitions">
  <div class="text-center mb-8">
    <h2 class="text-2xl lg:text-3xl font-bold text-text-primary">
      <?php echo esc_html($section_title); ?>
    </h2>
    <p class="mt-2 text-text-secondary">
      <?php esc_html_e('Explore more chances to win amazing prizes', 'nera-competitions'); ?>
    </p>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <?php foreach ($related_ids as $related_id) {
      $related_product = wc_get_product($related_id);

      if (!$related_product) {
        continue;
      }

      get_template_part('template-parts/product-listing/product-card', null, [
        'product' => $related_product,
        'cta_mode' => 'link',
        'card_context' => 'related',
        'highlight_badge' => in_array((int) $related_id, $upsell_ids, true)
          ? __('Recommended', 'nera-competitions')
          : '',
      ]);
    } ?>
  </div>

  <div class="text-center mt-8">
    <a
      href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>"
      class="inline-flex items-center gap-2 px-8 py-4 border-2 border-gray-200 text-text-primary font-semibold rounded-xl hover:border-primary hover:text-primary transition-colors"
    >
      <?php esc_html_e('View All Competitions', 'nera-competitions'); ?>
      <span class="material-symbols-outlined">arrow_forward</span>
    </a>
  </div>
</div>
