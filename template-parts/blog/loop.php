<?php
/**
 * Blog listing loop — child override.
 *
 * Passes tone='cream' to post cards so they render as white cards
 * on the cream section background used on the archive and home pages.
 *
 * @package Nera_Competitions
 */

if (!defined('ABSPATH')) {
  exit();
}

$empty_title = isset($args['empty_title']) ? $args['empty_title'] : __('No posts found', 'nera-competitions');
$empty_description = isset($args['empty_description'])
  ? $args['empty_description']
  : __("It seems we can't find what you're looking for.", 'nera-competitions');
?>

<?php if (have_posts()): ?>

    <div class="mx-auto max-w-6xl space-y-8 md:space-y-10 lg:space-y-12">
        <?php
        $index = 0;
        $grid_open = false;

        while (have_posts()) {
          the_post();

          if ($index === 0) {
            get_template_part('template-parts/blog/post-card', null, [
              'variant' => 'featured',
              'tone'    => 'cream',
            ]);
          } else {
            $pos = $index - 1;
            if ($pos % 3 === 0) {
              echo '<div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">';
              $grid_open = true;
            }
            get_template_part('template-parts/blog/post-card', null, [
              'variant' => 'standard',
              'tone'    => 'cream',
            ]);
            if ($pos % 3 === 2) {
              echo '</div>';
              $grid_open = false;
            }
          }

          $index++;
        }

        if ($grid_open) {
          echo '</div>';
        }
        ?>
    </div>

    <?php get_template_part('template-parts/blog/posts-navigation'); ?>

<?php else: ?>

    <div class="text-center py-16">
        <div class="max-w-md mx-auto">
            <svg class="w-16 h-16 mx-auto mb-4 text-stone-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                <path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
            </svg>
            <h2 class="text-2xl font-bold text-stone-800 mb-2"><?php echo esc_html($empty_title); ?></h2>
            <p class="text-stone-500"><?php echo esc_html($empty_description); ?></p>
        </div>
    </div>

<?php endif; ?>
