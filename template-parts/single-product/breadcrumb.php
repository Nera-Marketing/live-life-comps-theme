<?php
/**
 * Breadcrumb template part for Single Competition (child override).
 *
 * Middle crumb label from WooCommerce shop page title (same source as listing hero).
 *
 * @package Live_Life_Prizes
 */

if (!defined('ABSPATH')) {
  exit();
}

global $product;

if (!$product) {
  return;
}

$shop_page_id = function_exists('wc_get_page_id') ? (int) wc_get_page_id('shop') : 0;
$shop_url = $shop_page_id > 0 ? get_permalink($shop_page_id) : home_url('/all-competitions/');
$shop_label = $shop_page_id > 0 ? get_the_title($shop_page_id) : __('Current Prizes', 'live-life-prizes');
?>

<!-- Breadcrumb Navigation -->
<nav class="bg-surface border-b border-gray-100 rounded-full">
  <div class="max-w-7xl mx-auto px-4 lg:px-8 py-4">
    <ol class="flex items-center gap-2 text-sm">
      <li>
        <a href="<?php echo esc_url(home_url('/')); ?>"
          class="text-text-secondary hover:text-primary transition-colors">
          <?php esc_html_e('Home', 'live-life-prizes'); ?>
        </a>
      </li>
      <li class="text-gray-300">/</li>
      <li>
        <a href="<?php echo esc_url($shop_url); ?>"
          class="text-primary hover:text-primary-dark transition-colors">
          <?php echo esc_html($shop_label); ?>
        </a>
      </li>
      <li class="text-gray-300">/</li>
      <li class="text-text-primary font-medium">
        <?php echo esc_html($product->get_name()); ?>
      </li>
    </ol>
  </div>
</nav>
