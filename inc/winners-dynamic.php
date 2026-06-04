<?php
/**
 * Winners Dynamic page — exclude instant win entries from public grid.
 *
 * @package Live_Life_Prizes
 */

if (!defined('ABSPATH')) {
    exit;
}

add_filter('nera_winners_dynamic_can_show_instant_log', '__return_false');
