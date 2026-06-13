<?php
/**
 * Uniform payment-method logo row (cart, checkout, product trust).
 *
 * @package Live_Life_Prizes
 */

if (!defined('ABSPATH')) {
    exit;
}

$logos = function_exists('llp_get_payment_logos') ? llp_get_payment_logos() : [];
if (empty($logos)) {
    return;
}
?>

<div class="llp-payment-logos" role="list" aria-label="<?php esc_attr_e('Accepted payment methods', 'nera-competitions'); ?>">
  <?php foreach ($logos as $logo) : ?>
    <div
      class="llp-payment-logos__item llp-payment-logos__item--<?php echo esc_attr($logo['slug']); ?>"
      role="listitem"
      title="<?php echo esc_attr($logo['name']); ?>"
    >
      <?php echo $logo['markup']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- trusted theme markup ?>
    </div>
  <?php endforeach; ?>
</div>
