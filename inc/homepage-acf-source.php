<?php
/**
 * Resolve the page ID used for Live Life Homepage ACF fields (quick guide, etc.).
 *
 * @package Live_Life_Prizes
 */

if (!defined('ABSPATH')) {
    exit();
}

/**
 * Post ID of a published page using the Live Life Homepage template, or null.
 */
function live_life_prizes_get_live_life_homepage_post_id(): ?int
{
    static $resolved = null;

    if ($resolved !== null) {
        return $resolved > 0 ? $resolved : null;
    }

    $front_id = (int) get_option('page_on_front');
    if ($front_id > 0) {
        $tpl = get_page_template_slug($front_id);
        if ($tpl === 'page-templates/live-life-homepage.php') {
            $resolved = $front_id;

            return $resolved;
        }
    }

    $pages = get_posts([
        'post_type' => 'page',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'orderby' => 'ID',
        'order' => 'ASC',
        'meta_key' => '_wp_page_template',
        'meta_value' => 'page-templates/live-life-homepage.php',
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
 * ACF post ID for Live Life Homepage field group: current page when on that template, else homepage ID.
 *
 * @return int|false Post ID for get_field(), or false for current post in loop.
 */
function live_life_prizes_quick_guide_acf_post_id()
{
    $llp_home_id = live_life_prizes_get_live_life_homepage_post_id();
    if (!$llp_home_id) {
        return false;
    }

    $on_llp_home =
        is_page_template('page-templates/live-life-homepage.php')
        && (int) get_queried_object_id() === $llp_home_id;

    if ($on_llp_home) {
        return false;
    }

    return $llp_home_id;
}

/**
 * Render Quick Guide on single product (above related competitions).
 *
 * @param WC_Product|null $product Current product.
 */
function live_life_prizes_output_quick_guide_before_related_competitions($product): void
{
    if (!is_object($product) || !is_a($product, 'WC_Product')) {
        return;
    }
    if (!function_exists('is_product') || !is_product()) {
        return;
    }

    echo '<div class="mb-8 lg:mb-12">';
    get_template_part('template-parts/homepage/quick-guide');
    echo '</div>';
}

add_action('nera_before_related_competitions', 'live_life_prizes_output_quick_guide_before_related_competitions', 10, 1);
