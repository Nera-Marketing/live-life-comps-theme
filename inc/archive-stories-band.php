<?php
/**
 * "Heart behind / More than prizes" story band on prizes archive pages.
 *
 * Mirrors the two-column story band already shown on single product pages,
 * rendering it at the bottom of the Current Prizes (WooCommerce shop) and
 * Closed Prizes archive pages.
 *
 * Hooked to `get_footer` so it appears in both ACF page-component mode and the
 * fallback-template mode, and without copying the parent Closed Prizes template
 * into the child. The band sits between </main> and the site footer.
 *
 * @package Live_Life_Prizes
 */

if (!defined('ABSPATH')) {
    exit();
}

/**
 * True on the Current Prizes (WooCommerce shop) or Closed Prizes archive page.
 */
function live_life_prizes_is_prizes_archive(): bool
{
    $is_shop = function_exists('is_shop') && is_shop() && !is_search();
    $is_closed = is_page('archive-prizes')
        || is_page_template('page-templates/closed-prizes-template.php');

    return $is_shop || $is_closed;
}

/**
 * Output the reusable story band just above the footer on prizes archives.
 *
 * Rendered without `is_product_context` so it uses the full terracotta band
 * (top + bottom padding, brand background) — self-contained on any page.
 */
function live_life_prizes_render_archive_stories_band(): void
{
    if (!live_life_prizes_is_prizes_archive()) {
        return;
    }

    get_template_part('template-parts/about-us/stories-section');
}
add_action('get_footer', 'live_life_prizes_render_archive_stories_band');
