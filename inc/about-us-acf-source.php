<?php
/**
 * Resolve the page ID used for About Us ACF fields (story columns, etc.).
 *
 * @package Live_Life_Prizes
 */

if (!defined('ABSPATH')) {
    exit();
}

/**
 * Post ID of a published page using the About Us template, or null.
 */
function live_life_prizes_get_about_us_post_id(): ?int
{
    static $resolved = null;

    if ($resolved !== null) {
        return $resolved > 0 ? $resolved : null;
    }

    $pages = get_posts([
        'post_type' => 'page',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'orderby' => 'ID',
        'order' => 'ASC',
        'meta_key' => '_wp_page_template',
        'meta_value' => 'page-templates/about-us-template.php',
        'fields' => 'ids',
        'no_found_rows' => true,
    ]);

    if (!empty($pages) && is_array($pages)) {
        $resolved = (int) $pages[0];

        return $resolved > 0 ? $resolved : null;
    }

    $resolved = 0;

    return null;
}

/**
 * ACF post ID for About Us story fields: current page when on About Us, else About Us page ID.
 *
 * @return int|false Post ID for get_field(), or false for current post in loop.
 */
function live_life_prizes_about_stories_acf_post_id()
{
    $about_us_id = live_life_prizes_get_about_us_post_id();
    if (!$about_us_id) {
        return false;
    }

    $on_about_us =
        is_page_template('page-templates/about-us-template.php')
        && (int) get_queried_object_id() === $about_us_id;

    if ($on_about_us) {
        return false;
    }

    return $about_us_id;
}
