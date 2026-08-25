<?php
/**
 * Product Listing Card Template Part (child override)
 *
 * Adds optional `card_context` => `related` for single-product related grid: NEW badge
 * priority + secondary status when applicable. Default behavior matches parent theme.
 *
 * @package Live_Life_Prizes
 */

if (!defined('ABSPATH')) {
  exit();
}

$product = isset($args['product']) ? $args['product'] : null;

if (!$product) {
  global $product;
}

if (!$product || !is_a($product, 'WC_Product')) {
  return;
}

$cta_mode = isset($args['cta_mode']) && $args['cta_mode'] === 'link' ? 'link' : 'ajax';
$card_context = isset($args['card_context']) ? (string) $args['card_context'] : '';
$highlight_badge = isset($args['highlight_badge']) && is_string($args['highlight_badge'])
  ? trim($args['highlight_badge'])
  : '';
$is_related = $card_context === 'related';

$product_id = $product->get_id();
$image_id = $product->get_image_id();
$price = $product->get_price();
$permalink = get_permalink($product_id);
$title = get_the_title($product_id);

$max_tickets = get_post_meta($product_id, '_lty_maximum_tickets', true);
$sold_tickets = method_exists($product, 'get_purchased_ticket_count')
  ? $product->get_purchased_ticket_count()
  : 0;

$progress = $max_tickets ? min(100, round(($sold_tickets / $max_tickets) * 100)) : 0;
$remaining = $max_tickets ? max(0, $max_tickets - $sold_tickets) : 0;

$show_progress = function_exists('nera_show_tickets_progress')
  ? nera_show_tickets_progress($product_id)
  : true;

$end_date_gmt = get_post_meta($product_id, '_lty_end_date_gmt', true);
$countdown_timestamp = $end_date_gmt ? strtotime($end_date_gmt) * 1000 : 0;

$days_left = 0;
$hours_left = 0;
$mins_left = 0;
$secs_left = 0;
$is_new = false;
$is_ending_soon = false;
$is_last_tickets = false;
$is_sold_out = false;

if ($end_date_gmt) {
  $end_timestamp = strtotime($end_date_gmt);
  $now = time();
  $diff = $end_timestamp - $now;

  if ($diff > 0) {
    $days_left = floor($diff / 86400);
    $hours_left = floor(($diff % 86400) / 3600);
    $mins_left = floor(($diff % 3600) / 60);
    $secs_left = floor($diff % 60);

    if ($days_left < 1) {
      $is_ending_soon = true;
    }
  }
}

$post_date = get_the_date('U', $product_id);
if (time() - $post_date < 7 * 24 * 60 * 60) {
  $is_new = true;
}

$is_featured = $product->is_featured();

if ($remaining > 0 && $remaining <= 50) {
  $is_last_tickets = true;
}

if ($max_tickets && $remaining <= 0) {
  $is_sold_out = true;
}

$badge_text = '';
$badge_class = 'llp-prize-badge';

$primary_badge_text = '';
$primary_badge_class = 'llp-prize-badge';
$secondary_badge_text = '';
$secondary_badge_class = 'llp-prize-badge';

if ($is_related) {
  if ($is_sold_out) {
    $primary_badge_text = __('Sold Out', 'nera-competitions');
  } elseif ($is_last_tickets) {
    $primary_badge_text = sprintf(__('Last %d Tickets', 'nera-competitions'), $remaining);
  } elseif ($is_new) {
    $primary_badge_text = __('New', 'nera-competitions');
    if ($is_ending_soon) {
      $secondary_badge_text = __('Ending Soon', 'nera-competitions');
    } elseif ($progress >= 90) {
      $secondary_badge_text = __('Almost Gone', 'nera-competitions');
    }
  } elseif ($is_featured) {
    $primary_badge_text = __('Featured', 'nera-competitions');
    if ($is_ending_soon) {
      $secondary_badge_text = __('Ending Soon', 'nera-competitions');
    }
  } elseif ($is_ending_soon) {
    $primary_badge_text = __('Ending Soon', 'nera-competitions');
  } elseif ($progress >= 90) {
    $primary_badge_text = __('Almost Gone', 'nera-competitions');
  }
} else {
  if ($is_sold_out) {
    $badge_text = __('Sold Out', 'nera-competitions');
  } elseif ($is_last_tickets) {
    $badge_text = sprintf(__('Last %d Tickets', 'nera-competitions'), $remaining);
  } elseif ($is_ending_soon) {
    $badge_text = __('Ending Soon', 'nera-competitions');
  } elseif ($progress >= 90) {
    $badge_text = __('Almost Gone', 'nera-competitions');
  } elseif ($is_new) {
    $badge_text = __('New', 'nera-competitions');
  } elseif ($is_featured) {
    $badge_text = __('Featured', 'nera-competitions');
  }
}
?>

<article
  class="group bg-surface rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100"
  data-product-id="<?php echo esc_attr($product_id); ?>"
  data-category="<?php echo esc_attr(
    implode(' ', wp_get_post_terms($product_id, 'product_cat', ['fields' => 'slugs'])),
  ); ?>"
  data-price="<?php echo esc_attr($price); ?>" data-ending-soon="<?php echo $is_ending_soon
  ? 'true'
  : 'false'; ?>"
  data-last-tickets="<?php echo $is_last_tickets ? 'true' : 'false'; ?>"
  data-is-new="<?php echo $is_new ? 'true' : 'false'; ?>">

  <div class="relative aspect-[4/3] overflow-hidden">
    <?php if ($highlight_badge !== ''): ?>
      <div
        class="absolute top-4 right-4 z-20 inline-flex items-center gap-1 llp-prize-badge rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-widest shadow-lg">
        <span class="material-symbols-outlined text-sm leading-none" aria-hidden="true">star</span>
        <span><?php echo esc_html($highlight_badge); ?></span>
      </div>
    <?php endif; ?>

    <?php if ($is_related && ($primary_badge_text !== '' || $secondary_badge_text !== '')): ?>
      <div class="absolute top-4 left-4 z-10 flex max-w-[85%] flex-col items-start gap-1.5">
        <?php if ($primary_badge_text !== ''): ?>
          <div
            class="<?php echo esc_attr(
              $primary_badge_class,
            ); ?> rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-widest">
            <?php echo esc_html($primary_badge_text); ?>
          </div>
        <?php endif; ?>
        <?php if ($secondary_badge_text !== ''): ?>
          <div
            class="<?php echo esc_attr(
              $secondary_badge_class,
            ); ?> rounded-full px-2.5 py-0.5 text-[9px] font-bold uppercase tracking-wider">
            <?php echo esc_html($secondary_badge_text); ?>
          </div>
        <?php endif; ?>
      </div>
    <?php elseif (!$is_related && $badge_text): ?>
      <div
        class="absolute top-4 left-4 z-10 <?php echo esc_attr(
          $badge_class,
        ); ?> text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">
        <?php echo esc_html($badge_text); ?>
      </div>
    <?php endif; ?>

    <a href="<?php echo esc_url($permalink); ?>" class="block h-full w-full">
      <?php if ($image_id): ?>
        <?php $image_url = wp_get_attachment_image_url($image_id, 'large'); ?>
        <div
          class="h-full w-full transform bg-cover bg-center bg-no-repeat transition-transform duration-700 group-hover:scale-110"
          style="background-image: url('<?php echo esc_url($image_url); ?>');">
        </div>
      <?php else: ?>
        <div class="flex h-full w-full items-center justify-center bg-gray-100">
          <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
            class="text-gray-300">
            <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
            <circle cx="8.5" cy="8.5" r="1.5" />
            <polyline points="21 15 16 10 5 21" />
          </svg>
        </div>
      <?php endif; ?>
    </a>
  </div>

  <div class="p-6">
    <h3 class="text-lg font-bold text-text-primary mb-4 line-clamp-2 min-h-[2lh]">
      <a href="<?php echo esc_url($permalink); ?>" class="hover:text-primary transition-colors">
        <?php echo esc_html($title); ?>
      </a>
    </h3>

    <div class="space-y-4">
      <?php if ($end_date_gmt && $countdown_timestamp > 0): ?>
        <div class="flex items-center gap-1.5 text-text-secondary"
          x-data="countdown('<?php echo esc_attr($countdown_timestamp); ?>')">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" class="opacity-60 flex-shrink-0">
            <circle cx="12" cy="12" r="10"></circle>
            <polyline points="12 6 12 12 16 14"></polyline>
          </svg>
          <span class="text-xs font-bold uppercase tabular-nums">
            <span x-text="days">00</span>d : <span x-text="hours">00</span>h : <span x-text="minutes">00</span>m : <span x-text="seconds">00</span>s
          </span>
        </div>
      <?php endif; ?>

      <?php if ($max_tickets && $show_progress): ?>
        <div class="space-y-2">
          <div class="flex justify-between items-center text-xs font-bold">
            <span class="text-text-secondary"><?php echo esc_html(
              $sold_tickets,
            ); ?>/<?php echo esc_html($max_tickets); ?>
              <?php esc_html_e('sold', 'nera-competitions'); ?></span>
            <span class="text-primary"><?php echo esc_html($progress); ?>%</span>
          </div>
          <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
            <div class="h-full bg-gradient-primary rounded-full transition-all duration-500"
              style="width: <?php echo esc_attr($progress); ?>%">
            </div>
          </div>
        </div>
      <?php endif; ?>

      <div class="flex items-center justify-between pt-2">
        <div class="text-sm">
          <span class="text-text-secondary"><?php esc_html_e('Entry:', 'nera-competitions'); ?></span>
          <span class="font-bold text-primary ml-1"><?php echo wc_price($price); ?></span>
        </div>

        <?php
        $cta_classes =
          'inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white text-sm font-bold px-5 py-2.5 rounded-xl shadow-primary hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300';
        if ($cta_mode === 'link'): ?>
          <a
            href="<?php echo esc_url($permalink); ?>"
            class="<?php echo esc_attr($cta_classes); ?> no-underline"
          >
            <?php esc_html_e('Buy Tickets', 'nera-competitions'); ?>
          </a>
        <?php else: ?>
          <button type="button"
            class="add-to-cart-btn <?php echo esc_attr($cta_classes); ?>"
            data-product-id="<?php echo esc_attr($product_id); ?>" data-quantity="1">
            <?php esc_html_e('Buy Tickets', 'nera-competitions'); ?>
          </button>
        <?php endif; ?>
      </div>
    </div>
  </div>
</article>
