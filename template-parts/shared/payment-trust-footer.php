<?php
/**
 * SSL trust line + payment method logos (cart / checkout sidebar).
 *
 * @package Live_Life_Prizes
 */

if (!defined('ABSPATH')) {
    exit;
}

$logos = function_exists('llp_get_payment_logos') ? llp_get_payment_logos() : [];
?>

<div class="text-center llp-payment-trust">
  <p class="text-xs text-text-secondary mb-3 flex items-center justify-center gap-1">
    <span class="material-symbols-outlined text-sm text-text-primary">verified_user</span>
    <?php esc_html_e('SSL Encrypted Payment', 'nera-competitions'); ?>
  </p>

  <?php if (!empty($logos)) : ?>
    <?php get_template_part('template-parts/shared/payment-logos-row'); ?>
  <?php endif; ?>
</div>
