<?php
/**
 * Template Name: Live Life Homepage
 * Template Post Type: page
 *
 * Premium competition/giveaway homepage template
 * Matches the Boutique Giveaways design
 *
 * @package Nera_Competitions
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit();
}

get_header();
?>

<main id="main" class="nera-homepage" role="main">

  <?php
    get_template_part('template-parts/homepage/logo-banner');
    get_template_part('template-parts/homepage/hero-section');
    get_template_part('template-parts/homepage/account-prompt');
    get_template_part('template-parts/homepage/welcome-section');
    get_template_part('template-parts/homepage/featured-competitions');
    get_template_part('template-parts/homepage/quick-guide');
  ?>

</main>

<?php get_footer();
?>
