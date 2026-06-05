<?php
/**
 * Shop Page Template Bridge (child override)
 *
 * WooCommerce shop at /all-competitions/ — prizes listing only; no trust-features band.
 *
 * @package Live_Life_Prizes
 */

if (!defined('ABSPATH')) {
  exit();
}

get_header();

$shop_page_id = wc_get_page_id('shop');
?>

<main id="main" class="nera-product-listing nera-shop-page" role="main">

  <?php if (nera_render_page_components()): ?>
    <?php // page-components rendered via ACF Flexible Content ?>
  <?php else: ?>
  <?php
  get_template_part('template-parts/product-listing/hero-section', null, [
    'post_id' => $shop_page_id,
  ]);

  get_template_part('template-parts/homepage/categories-filter');
  ?>
  <?php endif; ?>

</main>

<?php get_footer();
