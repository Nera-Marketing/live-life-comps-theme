<?php
/**
 * One-time seed: create published page at /winners/ if missing (default child Winners template).
 *
 * Does not override `_wp_page_template` on an existing page so admins can switch to
 * Nera Winners (Dynamic) or any other template without it reverting on `init`.
 *
 * @package Live_Life_Prizes
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Create the Winners page if missing (slug `winners`).
 */
function live_life_prizes_maybe_seed_winners_page(): void
{
    if (!function_exists('wp_insert_post')) {
        return;
    }

    $existing = get_page_by_path('winners', OBJECT, 'page');
    if ($existing instanceof WP_Post) {
        if (!get_option('live_life_prizes_winners_page_seeded')) {
            update_option('live_life_prizes_winners_page_seeded', 1, true);
        }

        return;
    }

    if (get_option('live_life_prizes_winners_page_seeded')) {
        return;
    }

    $post_id = wp_insert_post(
        [
            'post_title' => __('Winners', 'live-life-prizes'),
            'post_name' => 'winners',
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_content' => '',
        ],
        true
    );

    if (is_wp_error($post_id) || !is_int($post_id) || $post_id < 1) {
        return;
    }

    update_post_meta($post_id, '_wp_page_template', 'page-templates/winners-template.php');
    update_option('live_life_prizes_winners_page_seeded', 1, true);
}

add_action('init', 'live_life_prizes_maybe_seed_winners_page', 20);
