<?php
/**
 * One-time seed: published page at /winners/ using the child Winners template.
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

        $tpl = (string) get_post_meta($existing->ID, '_wp_page_template', true);
        if ($tpl !== 'page-templates/winners-template.php') {
            update_post_meta($existing->ID, '_wp_page_template', 'page-templates/winners-template.php');
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
