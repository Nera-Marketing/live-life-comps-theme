<?php
/**
 * ACF WooCommerce Filter Settings (Theme Settings > WooCommerce)
 *
 * Adds a "Show Filter Bar" toggle to the WooCommerce settings page,
 * controlling visibility of the #advanced-filter-competitions bar on the shop page.
 *
 * @package Live_Life_Prizes
 */

if (!defined('ABSPATH')) {
    exit();
}

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group([
        'key'   => 'group_llp_woocommerce_filter',
        'title' => 'Shop Filter',
        'fields' => [
            [
                'key'           => 'field_llp_show_shop_filter_bar',
                'label'         => 'Show Filter Bar',
                'name'          => 'show_shop_filter_bar',
                'type'          => 'true_false',
                'instructions'  => 'Show or hide the filter bar above the competitions listing. When hidden, the price and sort filters are removed but all competitions remain visible.',
                'required'      => 0,
                'conditional_logic' => 0,
                'wrapper'       => ['width' => '', 'class' => '', 'id' => ''],
                'default_value' => 1,
                'ui'            => 1,
                'ui_on_text'    => 'Visible',
                'ui_off_text'   => 'Hidden',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'options_page',
                    'operator' => '==',
                    'value'    => 'acf-options-woocommerce',
                ],
            ],
        ],
        'menu_order'          => 10,
        'position'            => 'normal',
        'style'               => 'default',
        'label_placement'     => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen'      => '',
        'active'              => true,
        'description'         => '',
    ]);
}
