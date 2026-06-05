<?php
/**
 * Lottery for WooCommerce — winners dataset for the Winners page grid (replaces manual ACF repeater).
 *
 * @package Live_Life_Prizes
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Format a GMT datetime string from LFW entities for display (matches ACF date style on cards).
 *
 * @param string $gmt_string Post GMT datetime string.
 * @return string
 */
function live_life_prizes_lfw_format_winner_date(string $gmt_string): string
{
    if ($gmt_string === '') {
        return '';
    }

    $ts = strtotime($gmt_string . ' UTC');

    return $ts ? (string) wp_date('F j, Y', $ts) : '';
}

/**
 * Featured image URL for a WC product (large size).
 *
 * @param WC_Product|null $product Product object.
 * @return string Escaped-ready URL or empty.
 */
function live_life_prizes_wc_product_image_url($product): string
{
    if (!is_object($product) || !method_exists($product, 'get_image_id')) {
        return '';
    }

    $image_id = (int) $product->get_image_id();
    if ($image_id < 1) {
        return '';
    }

    $url = wp_get_attachment_image_url($image_id, 'large');

    return is_string($url) ? $url : '';
}

/**
 * Prize line for a main lottery winner (product title or gift / details fallback).
 *
 * @param object $winner LTY_Lottery_Product_Winner instance.
 * @return string
 */
function live_life_prizes_lfw_live_draw_prize_line($winner): string
{
    if (!is_object($winner) || !method_exists($winner, 'get_product')) {
        return '';
    }

    $product = $winner->get_product();
    if (is_object($product) && method_exists($product, 'get_name')) {
        $name = sanitize_text_field($product->get_name());
        if ($name !== '') {
            return $name;
        }
    }

    if (method_exists($winner, 'get_winning_details')) {
        $details = $winner->get_winning_details();
        if (is_string($details) && $details !== '') {
            return sanitize_text_field(wp_strip_tags($details));
        }
    }

    return '';
}

/**
 * Build winners + filter_items in the same shape as {@see nera_winners_get_page_dataset()}.
 *
 * @param int|null $page_id Current winners page ID (for {@see nera_get_win_categories()} labels).
 * @return array{winners: array<int, array<string, mixed>>, filter_items: array<int, array{value:string,label:string,count:int}>}
 */
function live_life_prizes_lfw_winners_dataset(?int $page_id = null): array
{
    $page_id = $page_id ? (int) $page_id : get_the_ID();

    $categories = function_exists('nera_get_win_categories')
        ? nera_get_win_categories($page_id)
        : [
            'live-draw' => __('Live Draw', 'live-life-prizes'),
        ];

    unset($categories['instant-win']);

    if (!function_exists('lty_get_lottery_winner') || !function_exists('lty_get_lottery_winning_dates')) {
        return [
            'winners' => [],
            'filter_items' => live_life_prizes_lfw_empty_filter_items($categories),
        ];
    }

    $rows = [];

    // Main lottery winners (live draw).
    if (function_exists('lty_get_lottery_winning_dates') && function_exists('lty_get_lottery_winner_ids_by_date')) {
        $live_dates = lty_get_lottery_winning_dates('DESC', false);
        if (is_array($live_dates)) {
            foreach ($live_dates as $date) {
                $ids = lty_get_lottery_winner_ids_by_date($date);
                if (!is_array($ids)) {
                    continue;
                }
                foreach ($ids as $winner_id) {
                    $w = lty_get_lottery_winner($winner_id);
                    if (!is_object($w) || !method_exists($w, 'exists') || !$w->exists()) {
                        continue;
                    }

                    $name = method_exists($w, 'display_user_name') ? $w->display_user_name() : '';
                    $name = is_string($name) ? sanitize_text_field($name) : '';
                    $prize = live_life_prizes_lfw_live_draw_prize_line($w);
                    if ($name === '' || $prize === '') {
                        continue;
                    }

                    $gmt = method_exists($w, 'get_created_date') ? (string) $w->get_created_date() : '';
                    $sort_ts = $gmt !== '' ? (int) strtotime($gmt . ' UTC') : 0;
                    $date_display = live_life_prizes_lfw_format_winner_date($gmt);

                    $product = method_exists($w, 'get_product') ? $w->get_product() : null;
                    $image_url = live_life_prizes_wc_product_image_url($product);

                    $cat = 'live-draw';
                    $rows[] = [
                        'id' => md5('lfw-live|' . (string) $winner_id . '|' . $gmt),
                        'name' => $name,
                        'prize' => $prize,
                        'date' => $date_display,
                        'quote' => '',
                        'category' => $cat,
                        'category_label' => sanitize_text_field($categories[$cat] ?? __('Live Draw', 'live-life-prizes')),
                        'image' => esc_url($image_url),
                        'sort_ts' => $sort_ts,
                    ];
                }
            }
        }
    }

    usort(
        $rows,
        static function (array $a, array $b): int {
            return ($b['sort_ts'] ?? 0) <=> ($a['sort_ts'] ?? 0);
        }
    );

    $winners = [];
    foreach ($rows as $row) {
        unset($row['sort_ts']);
        $winners[] = $row;
    }

    $counts = array_fill_keys(array_keys($categories), 0);
    foreach ($winners as $w) {
        $c = sanitize_key($w['category'] ?? '');
        if (isset($counts[$c])) {
            ++$counts[$c];
        }
    }

    $filter_items = [
        [
            'value' => 'all',
            'label' => __('All Winners', 'live-life-prizes'),
            'count' => count($winners),
        ],
    ];

    foreach ($categories as $value => $label) {
        $value = sanitize_key($value);
        $filter_items[] = [
            'value' => $value,
            'label' => sanitize_text_field($label),
            'count' => (int) ($counts[$value] ?? 0),
        ];
    }

    return [
        'winners' => $winners,
        'filter_items' => $filter_items,
    ];
}

/**
 * Empty-state filter row when LFW is unavailable.
 *
 * @param array<string, string> $categories Value => label.
 * @return array<int, array{value:string,label:string,count:int}>
 */
function live_life_prizes_lfw_empty_filter_items(array $categories): array
{
    $filter_items = [
        [
            'value' => 'all',
            'label' => __('All Winners', 'live-life-prizes'),
            'count' => 0,
        ],
    ];

    foreach ($categories as $value => $label) {
        $filter_items[] = [
            'value' => sanitize_key($value),
            'label' => sanitize_text_field($label),
            'count' => 0,
        ];
    }

    return $filter_items;
}
