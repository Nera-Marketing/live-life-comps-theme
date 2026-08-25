<?php
/**
 * Fill empty related / cart-cross-sell slots with other active competitions.
 *
 * @package Live_Life_Prizes
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Pad a list of product IDs up to $limit with other eligible lottery competitions.
 *
 * Existing IDs keep their order. New IDs follow catalog order (menu_order → date).
 *
 * @param int[] $ids     IDs already chosen (upsells, category related, WC cross-sells).
 * @param int[] $exclude IDs that must not appear (current product, items in cart).
 * @param int   $limit   Maximum IDs to return.
 * @return int[]
 */
function live_life_prizes_fill_competition_slots(array $ids, array $exclude, int $limit = 4): array
{
    $ids = array_values(array_unique(array_filter(array_map('intval', $ids))));
    $exclude = array_values(array_unique(array_filter(array_map('intval', $exclude))));

    if (count($ids) >= $limit) {
        return array_slice($ids, 0, $limit);
    }

    $sold_out_ids = function_exists('nera_sold_out_lottery_ids') ? nera_sold_out_lottery_ids() : [];
    $active_meta = function_exists('nera_active_lottery_meta_query') ? nera_active_lottery_meta_query() : [];

    $needed = $limit - count($ids);
    $args = [
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => $needed + count($ids) + count($exclude),
        'post__not_in' => array_values(array_unique(array_merge($exclude, $sold_out_ids))),
        'fields' => 'ids',
        'no_found_rows' => true,
        'tax_query' => [
            [
                'taxonomy' => 'product_type',
                'field' => 'slug',
                'terms' => 'lottery',
            ],
        ],
        'meta_query' => $active_meta,
    ];

    $args = function_exists('nera_wp_query_args_with_catalog_order')
        ? nera_wp_query_args_with_catalog_order($args)
        : array_merge($args, ['orderby' => 'date', 'order' => 'DESC']);

    $query = new WP_Query($args);

    foreach ($query->posts as $candidate_id) {
        $candidate_id = (int) $candidate_id;
        if ($candidate_id && !in_array($candidate_id, $ids, true) && !in_array($candidate_id, $exclude, true)) {
            $ids[] = $candidate_id;
        }
        if (count($ids) >= $limit) {
            break;
        }
    }

    return array_slice($ids, 0, $limit);
}

/**
 * Pad WooCommerce cart cross-sells so the cart strip can fill empty slots.
 *
 * Empty cart: leave IDs unchanged so the empty-cart template is not followed by a 4-up grid.
 *
 * @param int[]   $ids
 * @param WC_Cart $cart
 * @return int[]
 */
function live_life_prizes_pad_cart_crosssell_ids($ids, $cart): array
{
    $ids = is_array($ids) ? $ids : [];

    if (!is_object($cart) || !method_exists($cart, 'is_empty') || $cart->is_empty()) {
        return $ids;
    }

    $in_cart = [];
    foreach ($cart->get_cart() as $item) {
        $in_cart[] = (int) ($item['product_id'] ?? 0);
        if (!empty($item['variation_id'])) {
            $in_cart[] = (int) $item['variation_id'];
        }
    }

    return live_life_prizes_fill_competition_slots($ids, $in_cart, 4);
}
add_filter('woocommerce_cart_crosssell_ids', 'live_life_prizes_pad_cart_crosssell_ids', 20, 2);
