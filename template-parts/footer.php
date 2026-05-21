<?php
/**
 * Live Life Prizes footer — UK site parity (4 columns, dark bar, legal strip + badge).
 *
 * @package Live_Life_Prizes
 */

if (!defined('ABSPATH')) {
    exit;
}

$nav_args_base = [
    'container' => false,
    'menu_class' => 'menu',
    'fallback_cb' => false,
    'depth' => 3,
    'link_before' => '',
    'link_after' => '',
];

$nav_discover = array_merge($nav_args_base, [
    'theme_location' => 'primary-menu',
    'container' => 'div',
    'container_class' => 'menu-primary-container',
]);

// Theme Settings → Footer (ACF options; parent `nera-competitions-standard` registers fields).
$footer_legal_disclaimer = '';
$footer_copyright_html = '';
$footer_bottom_right_html = '';
if (function_exists('get_field')) {
    $footer_legal_disclaimer = get_field('footer_legal_disclaimer', 'option');
    $footer_copyright_html = get_field('footer_copyright', 'option');
    $footer_bottom_right_html = get_field('footer_bottom_right', 'option');
}
$footer_legal_disclaimer = is_string($footer_legal_disclaimer) ? $footer_legal_disclaimer : '';
$footer_copyright_html = is_string($footer_copyright_html) ? $footer_copyright_html : '';
$footer_bottom_right_html = is_string($footer_bottom_right_html) ? $footer_bottom_right_html : '';

?>
<footer class="llp-site-footer" id="site-footer">

    <?php get_template_part('template-parts/llp-organic-wave', null, ['position' => 'bottom', 'context' => 'footer']); ?>

    <div class="llp-footer-grid">
        <div class="llp-footer-col llp-footer-col--brand footer-col footer-brand">
            <?php
            if (is_active_sidebar('footer-1')) {
                dynamic_sidebar('footer-1');
            } else {
                live_life_prizes_footer_fallback_brand();
            }
            ?>
        </div>

        <div class="llp-footer-col footer-col">
            <?php
            if (is_active_sidebar('footer-2')) {
                dynamic_sidebar('footer-2');
            } elseif (has_nav_menu('primary-menu')) {
                echo '<div class="footer-widget widget_block"><h4 class="wp-block-heading llp-footer-heading">' . esc_html__('Discover', 'live-life-prizes') . '</h4></div>';
                echo '<div class="footer-widget widget_block" aria-hidden="true"><div class="wp-block-spacer" style="height:15px"></div></div>';
                echo '<div class="footer-widget widget_nav_menu">';
                wp_nav_menu($nav_discover);
                echo '</div>';
            } else {
                live_life_prizes_footer_fallback_discover();
            }
            ?>
        </div>

        <div class="llp-footer-col footer-col">
            <?php
            if (is_active_sidebar('footer-3')) {
                dynamic_sidebar('footer-3');
            } else {
                $menu_obj = wp_get_nav_menu_object('footer-menu-3');
                if ($menu_obj && !is_wp_error($menu_obj)) {
                    echo '<div class="footer-widget widget_block"><h4 class="wp-block-heading llp-footer-heading">' . esc_html__('Good To Know', 'live-life-prizes') . '</h4></div>';
                    echo '<div class="footer-widget widget_block" aria-hidden="true"><div class="wp-block-spacer" style="height:15px"></div></div>';
                    echo '<div class="footer-widget widget_nav_menu">';
                    wp_nav_menu(array_merge($nav_args_base, [
                        'menu' => (int) $menu_obj->term_id,
                        'container' => 'div',
                        'container_class' => 'menu-footer-menu-3-container',
                    ]));
                    echo '</div>';
                } else {
                    live_life_prizes_footer_fallback_good_to_know();
                }
            }
            ?>
        </div>

        <div class="llp-footer-col footer-col">
            <?php
            if (is_active_sidebar('footer-4')) {
                dynamic_sidebar('footer-4');
            } else {
                $menu_obj = wp_get_nav_menu_object('footer-menu-4');
                if ($menu_obj && !is_wp_error($menu_obj)) {
                    $items = wp_get_nav_menu_items((int) $menu_obj->term_id);
                    if (!empty($items)) {
                        echo '<div class="footer-widget widget_block"><h4 class="wp-block-heading llp-footer-heading">' . esc_html__('Legal', 'live-life-prizes') . '</h4></div>';
                        echo '<div class="footer-widget widget_nav_menu">';
                        wp_nav_menu(array_merge($nav_args_base, [
                            'menu' => (int) $menu_obj->term_id,
                            'container' => 'div',
                            'container_class' => 'menu-footer-menu-4-container',
                        ]));
                        echo '</div>';
                    } else {
                        live_life_prizes_footer_fallback_legal();
                    }
                } else {
                    live_life_prizes_footer_fallback_legal();
                }
            }
            ?>
        </div>
    </div>

    <div class="llp-footer-bottom">
        <div class="llp-footer-legal">
            <p class="m-0"><?php
                if (trim($footer_legal_disclaimer) !== '') {
                    echo nl2br(esc_html(str_replace('{year}', (string) gmdate('Y'), $footer_legal_disclaimer)), false);
                } else {
                    esc_html_e('UK residents only 18+. Live Life Prizes operates as a prize draw. No purchase necessary. Free postal route available. T&Cs apply. All entrants have an equal chance to win regardless of how they enter.', 'live-life-prizes');
                }
            ?></p>
            <?php if (trim($footer_copyright_html) !== '') : ?>
                <div class="m-0 llp-footer-copyright-acf">
                    <?php
                    echo wp_kses_post(
                        str_replace('{year}', (string) gmdate('Y'), $footer_copyright_html)
                    );
                    ?>
                </div>
            <?php else : ?>
                <p class="m-0"><?php
                    echo esc_html(sprintf(
                        /* translators: %s: year */
                        __('© %s All Rights Reserved. Van Life Builds Ltd trading as Live Life Prizes. Company Registration Number: 14663089', 'live-life-prizes'),
                        (string) gmdate('Y')
                    ));
                ?></p>
            <?php endif; ?>
        </div>
        <div class="llp-footer-bottom-right">
            <?php if (trim($footer_bottom_right_html) !== '') : ?>
                <div class="llp-footer-bottom-right-acf">
                    <?php echo wp_kses_post(str_replace('{year}', (string) gmdate('Y'), $footer_bottom_right_html)); ?>
                </div>
            <?php else : ?>
                <span class="llp-footer-vlb-badge"><?php esc_html_e('Part of Van Life Builds', 'live-life-prizes'); ?></span>
            <?php endif; ?>
            <span class="llp-footer-age-badge" role="img" aria-label="<?php esc_attr_e('18+ only', 'live-life-prizes'); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 56 56" aria-hidden="true" focusable="false">
                    <circle cx="28" cy="28" r="26" fill="none" stroke="currentColor" stroke-width="2.5"/>
                    <text x="28" y="36" font-family="inherit" font-size="20" font-weight="700" fill="currentColor" text-anchor="middle">18+</text>
                </svg>
            </span>
        </div>
    </div>

    <button id="nera-scroll-top"
        class="llp-scroll-top fixed bottom-8 cursor-pointer right-8 z-[100] p-3 rounded-full shadow-xl hover:scale-110 hover:-translate-y-1 transform transition-all duration-300 translate-y-20 opacity-0 invisible border"
        type="button"
        aria-label="<?php esc_attr_e('Scroll to top', 'live-life-prizes'); ?>">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button>

</footer>
