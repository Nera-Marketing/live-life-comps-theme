<?php
/**
 * Live Life Prizes — footer logo URL + nav fallbacks (UK footer parity).
 *
 * @package Live_Life_Prizes
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Footer logo: theme mod, then known upload filenames, then bundled child asset.
 *
 * @return string Escaped URL or empty string.
 */
function live_life_prizes_footer_logo_url(): string
{
    $mod = get_theme_mod('live_life_prizes_footer_logo_url', '');
    if (is_string($mod) && $mod !== '') {
        return esc_url($mod);
    }

    $uploads = wp_upload_dir();
    if (empty($uploads['error']) && !empty($uploads['basedir'])) {
        $candidates = [
            '/2026/03/rsz_live_life_prizes_sun_vlb-text_bronze-150x150.png',
            '/2026/03/rsz_live_life_prizes_sun_vlb-text_bronze.png',
        ];

        foreach ($candidates as $rel) {
            $path = $uploads['basedir'] . $rel;
            if (is_readable($path)) {
                return esc_url($uploads['baseurl'] . $rel);
            }
        }
    }

    $bundled = get_stylesheet_directory() . '/assets/live-life-prizes-footer-logo.png';
    if (is_readable($bundled)) {
        return esc_url(get_stylesheet_directory_uri() . '/assets/live-life-prizes-footer-logo.png');
    }

    return '';
}

/**
 * Default Discover column HTML (matches UK site structure).
 */
function live_life_prizes_footer_fallback_discover(): void
{
    $home = home_url('/');
    $all = home_url('/all-competitions/');
    $archive = home_url('/archive-prizes/');
    $how = home_url('/how-it-works/');
    $purpose = home_url('/my-purpose/');
    $blog = home_url('/blog');
    $faq = home_url('/faq/');
    ?>
    <div class="footer-widget widget_block">
        <h4 class="wp-block-heading llp-footer-heading"><?php esc_html_e('Discover', 'live-life-prizes'); ?></h4>
    </div>
    <div class="footer-widget widget_block" aria-hidden="true">
        <div class="wp-block-spacer" style="height:15px"></div>
    </div>
    <nav class="llp-footer-fallback-nav" aria-label="<?php esc_attr_e('Discover', 'live-life-prizes'); ?>">
        <ul class="menu">
            <li class="menu-item"><a href="<?php echo esc_url($home); ?>"><?php esc_html_e('Home', 'live-life-prizes'); ?></a></li>
            <li class="menu-item menu-item-has-children">
                <a href="<?php echo esc_url($all); ?>"><?php esc_html_e('Current Prizes', 'live-life-prizes'); ?></a>
                <ul class="sub-menu">
                    <li class="menu-item"><a href="<?php echo esc_url($archive); ?>"><?php esc_html_e('Closed Prizes', 'live-life-prizes'); ?></a></li>
                </ul>
            </li>
            <li class="menu-item"><a href="<?php echo esc_url($how); ?>"><?php esc_html_e('How It Works', 'live-life-prizes'); ?></a></li>
            <li class="menu-item"><a href="<?php echo esc_url($purpose); ?>"><?php esc_html_e('My Purpose', 'live-life-prizes'); ?></a></li>
            <li class="menu-item"><a href="<?php echo esc_url($blog); ?>"><?php esc_html_e('Blog', 'live-life-prizes'); ?></a></li>
            <li class="menu-item"><a href="<?php echo esc_url($faq); ?>"><?php esc_html_e('FAQ', 'live-life-prizes'); ?></a></li>
        </ul>
    </nav>
    <?php
}

/**
 * Default Good To Know column (placeholder # links — replace in menus when configured).
 */
function live_life_prizes_footer_fallback_good_to_know(): void
{
    $competitions = home_url('/all-competitions/');
    $winners = home_url('/winners/');
    $cart = function_exists('wc_get_cart_url') ? wc_get_cart_url() : '#';
    $dashboard = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : home_url('/my-account/');
    $privacy_id = (int) get_option('wp_page_for_privacy_policy');
    $privacy = $privacy_id > 0 ? get_permalink($privacy_id) : home_url('/privacy-policy/');
    $terms_id = function_exists('wc_get_page_id') ? wc_get_page_id('terms') : (int) get_option('woocommerce_terms_page_id');
    $terms = ($terms_id > 0) ? get_permalink($terms_id) : home_url('/terms-and-conditions/');
    ?>
    <div class="footer-widget widget_block">
        <h4 class="wp-block-heading llp-footer-heading"><?php esc_html_e('Good To Know', 'live-life-prizes'); ?></h4>
    </div>
    <div class="footer-widget widget_block" aria-hidden="true">
        <div class="wp-block-spacer" style="height:15px"></div>
    </div>
    <nav class="llp-footer-fallback-nav" aria-label="<?php esc_attr_e('Good To Know', 'live-life-prizes'); ?>">
        <ul class="menu">
            <li class="menu-item"><a href="<?php echo esc_url($competitions); ?>"><?php esc_html_e('Live Competitions', 'live-life-prizes'); ?></a></li>
            <li class="menu-item"><a href="<?php echo esc_url($winners); ?>"><?php esc_html_e('Winners', 'live-life-prizes'); ?></a></li>
            <li class="menu-item"><a href="<?php echo esc_url($cart); ?>"><?php esc_html_e('Cart', 'live-life-prizes'); ?></a></li>
            <li class="menu-item"><a href="<?php echo esc_url($dashboard); ?>"><?php esc_html_e('User Dashboard', 'live-life-prizes'); ?></a></li>
            <li class="menu-item"><a href="<?php echo esc_url($privacy); ?>"><?php esc_html_e('Privacy Policy', 'live-life-prizes'); ?></a></li>
            <li class="menu-item"><a href="<?php echo esc_url($terms); ?>"><?php esc_html_e('Terms and Conditions', 'live-life-prizes'); ?></a></li>
        </ul>
    </nav>
    <?php
}

/**
 * Default Legal column.
 */
function live_life_prizes_footer_fallback_legal(): void
{
    $terms_id = function_exists('wc_get_page_id') ? wc_get_page_id('terms') : (int) get_option('woocommerce_terms_page_id');
    $terms = ($terms_id > 0) ? get_permalink($terms_id) : home_url('/terms-and-conditions/');
    $privacy_id = (int) get_option('wp_page_for_privacy_policy');
    $privacy = $privacy_id > 0 ? get_permalink($privacy_id) : home_url('/privacy-policy/');
    ?>
    <div class="footer-widget widget_block">
        <h4 class="wp-block-heading llp-footer-heading"><?php esc_html_e('Legal', 'live-life-prizes'); ?></h4>
    </div>
    <nav class="llp-footer-fallback-nav" aria-label="<?php esc_attr_e('Legal', 'live-life-prizes'); ?>">
        <ul class="menu">
            <li class="menu-item"><a href="<?php echo esc_url($terms); ?>"><?php esc_html_e('Terms and Conditions', 'live-life-prizes'); ?></a></li>
            <li class="menu-item"><a href="<?php echo esc_url($privacy); ?>"><?php esc_html_e('Privacy Policy', 'live-life-prizes'); ?></a></li>
        </ul>
    </nav>
    <?php
}

/**
 * Brand column fallback: logo + blurb + social (UK copy).
 */
function live_life_prizes_footer_fallback_brand(): void
{
    $logo = live_life_prizes_footer_logo_url();
    $facebook = get_theme_mod('nera_facebook_url', 'https://xxxx');
    $instagram = get_theme_mod('nera_instagram_url', '#');
    ?>
    <div class="footer-widget widget_block widget_media_image">
        <?php if ($logo !== '') : ?>
            <figure class="wp-block-image llp-footer-logo">
                <img loading="lazy" decoding="async" width="457" height="85" src="<?php echo esc_url($logo); ?>"
                     alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="wp-image-llp-footer-logo"/>
            </figure>
        <?php else : ?>
            <span class="screen-reader-text"><?php echo esc_html(get_bloginfo('name')); ?></span>
        <?php endif; ?>
    </div>
    <div class="footer-widget widget_block widget_text">
        <p class="llp-footer-tagline"><?php esc_html_e(
            'Prize draws designed to enrich your life. Quality time, new experiences, and a renewed appreciation for the moments that truly matter.',
            'live-life-prizes'
        ); ?></p>
    </div>
    <div class="footer-widget widget_block llp-footer-social-wrap">
        <ul class="wp-block-social-links is-layout-flex wp-block-social-links-is-layout-flex llp-footer-social">
            <li class="wp-social-link wp-social-link-facebook wp-block-social-link">
                <a href="<?php echo esc_url($facebook); ?>" class="wp-block-social-link-anchor" rel="noopener noreferrer" target="_blank">
                    <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                        <path d="M12 2C6.5 2 2 6.5 2 12c0 5 3.7 9.1 8.4 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.3v7C18.3 21.1 22 17 22 12c0-5.5-4.5-10-10-10z"></path>
                    </svg>
                    <span class="wp-block-social-link-label screen-reader-text"><?php esc_html_e('Facebook', 'live-life-prizes'); ?></span>
                </a>
            </li>
            <li class="wp-social-link wp-social-link-instagram wp-block-social-link">
                <a href="<?php echo esc_url($instagram); ?>" class="wp-block-social-link-anchor" rel="noopener noreferrer" target="_blank">
                    <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                        <path d="M12,4.622c2.403,0,2.688,0.009,3.637,0.052c0.877,0.04,1.354,0.187,1.671,0.31c0.42,0.163,0.72,0.358,1.035,0.673 c0.315,0.315,0.51,0.615,0.673,1.035c0.123,0.317,0.27,0.794,0.31,1.671c0.043,0.949,0.052,1.234,0.052,3.637 s-0.009,2.688-0.052,3.637c-0.04,0.877-0.187,1.354-0.31,1.671c-0.163,0.42-0.358,0.72-0.673,1.035 c-0.315,0.315-0.615,0.51-1.035,0.673c-0.317,0.123-0.794,0.27-1.671,0.31c-0.949,0.043-1.233,0.052-3.637,0.052 s-2.688-0.009-3.637-0.052c-0.877-0.04-1.354-0.187-1.671-0.31c-0.42-0.163-0.72-0.358-1.035-0.673 c-0.315-0.315-0.51-0.615-0.673-1.035c-0.123-0.317-0.27-0.794-0.31-1.671C4.631,14.688,4.622,14.403,4.622,12 s0.009-2.688,0.052-3.637c0.04-0.877,0.187-1.354,0.31-1.671c0.163-0.42,0.358-0.72,0.673-1.035 c0.315-0.315,0.615-0.51,1.035-0.673c0.317-0.123,0.794-0.27,1.671-0.31C9.312,4.631,9.597,4.622,12,4.622 M12,3 C9.556,3,9.249,3.01,8.289,3.054C7.331,3.098,6.677,3.25,6.105,3.472C5.513,3.702,5.011,4.01,4.511,4.511 c-0.5,0.5-0.808,1.002-1.038,1.594C3.25,6.677,3.098,7.331,3.054,8.289C3.01,9.249,3,9.556,3,12c0,2.444,0.01,2.751,0.054,3.711 c0.044,0.958,0.196,1.612,0.418,2.185c0.23,0.592,0.538,1.094,1.038,1.594c0.5,0.5,1.002,0.808,1.594,1.038 c0.572,0.222,1.227,0.375,2.185,0.418C9.249,20.99,9.556,21,12,21s2.751-0.01,3.711-0.054c0.958-0.044,1.612-0.196,2.185-0.418 c0.592-0.23,1.094-0.538,1.594-1.038c0.5-0.5,0.808-1.002,1.038-1.594c0.222-0.572,0.375-1.227,0.418-2.185 C20.99,14.751,21,14.444,21,12s-0.01-2.751-0.054-3.711c-0.044-0.958-0.196-1.612-0.418-2.185c-0.23-0.592-0.538-1.094-1.038-1.594 c-0.5-0.5-1.002-0.808-1.594-1.038c-0.572-0.222-1.227-0.375-2.185-0.418C14.751,3.01,14.444,3,12,3L12,3z M12,7.378 c-2.552,0-4.622,2.069-4.622,4.622S9.448,16.622,12,16.622s4.622-2.069,4.622-4.622S14.552,7.378,12,7.378z M12,15 c-1.657,0-3-1.343-3-3s1.343-3,3-3s3,1.343,3,3S13.657,15,12,15z M16.804,6.116c-0.596,0-1.08,0.484-1.08,1.08 s0.484,1.08,1.08,1.08c0.596,0,1.08-0.484,1.08-1.08S17.401,6.116,16.804,6.116z"></path>
                    </svg>
                    <span class="wp-block-social-link-label screen-reader-text"><?php esc_html_e('Instagram', 'live-life-prizes'); ?></span>
                </a>
            </li>
        </ul>
    </div>
    <?php
}

/**
 * Brand column markup as HTML string (for Custom HTML widget seeding).
 */
function live_life_prizes_footer_brand_html_string(): string
{
    ob_start();
    live_life_prizes_footer_fallback_brand();

    return (string) ob_get_clean();
}
