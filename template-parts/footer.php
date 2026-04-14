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

?>
<footer class="llp-site-footer" id="site-footer">

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
            <p class="m-0"><?php esc_html_e('UK residents only 18+. Live Life Prizes operates as a prize draw. No purchase necessary. Free postal route available. T&Cs apply. All entrants have an equal chance to win regardless of how they enter.', 'live-life-prizes'); ?></p>
            <p class="m-0"><?php
                echo esc_html(sprintf(
                    /* translators: %s: year */
                    __('© %s All Rights Reserved. Van Life Builds Ltd trading as Live Life Prizes. Company Registration Number: 14663089', 'live-life-prizes'),
                    (string) gmdate('Y')
                ));
            ?></p>
        </div>
        <div class="llp-footer-bottom-right">
            <span class="llp-footer-vlb-badge"><?php esc_html_e('Part of Van Life Builds', 'live-life-prizes'); ?></span>
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
