<?php
/**
 * Template Name: Nera Winners Page
 * Template Post Type: page
 *
 * Winners page: hero from ACF; grid from Lottery for WooCommerce (child override).
 *
 * @package Live_Life_Prizes
 */

if (!defined('ABSPATH')) {
    exit();
}

get_header();
?>

<main id="main" class="nera-winners-page bg-gray-50" role="main">
    <?php
    get_template_part('template-parts/winners/hero-section');
    get_template_part('template-parts/winners/winners-grid');
    ?>
</main>

<?php
get_footer();
