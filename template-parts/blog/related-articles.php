<?php
/**
 * Related articles — Live Life Prizes override
 *
 * Terracotta band; light post cards on gradient.
 *
 * @package Nera_Competitions
 */

if (!defined('ABSPATH')) {
  exit();
}

$current_id = (int) get_the_ID();
if ($current_id < 1) {
  return;
}

$cat_ids = wp_get_post_categories($current_id);
$post_ids = [];

if (!empty($cat_ids)) {
  $q_cat = new WP_Query([
    'post_type' => 'post',
    'posts_per_page' => 3,
    'post__not_in' => [$current_id],
    'category__in' => $cat_ids,
    'ignore_sticky_posts' => true,
    'fields' => 'ids',
    'no_found_rows' => true,
  ]);
  $post_ids = $q_cat->posts;
  wp_reset_postdata();
}

if (count($post_ids) < 3) {
  $exclude = array_merge([$current_id], $post_ids);
  $q_recent = new WP_Query([
    'post_type' => 'post',
    'posts_per_page' => 3 - count($post_ids),
    'post__not_in' => $exclude,
    'ignore_sticky_posts' => true,
    'orderby' => 'date',
    'order' => 'DESC',
    'fields' => 'ids',
    'no_found_rows' => true,
  ]);
  $post_ids = array_merge($post_ids, $q_recent->posts);
  wp_reset_postdata();
}

$post_ids = array_slice(array_unique(array_map('intval', $post_ids)), 0, 3);

if (empty($post_ids)) {
  return;
}

$related_query = new WP_Query([
  'post_type' => 'post',
  'post__in' => $post_ids,
  'posts_per_page' => 3,
  'orderby' => 'post__in',
]);

$page_for_posts = (int) get_option('page_for_posts');
$journal_url = $page_for_posts ? get_permalink($page_for_posts) : home_url('/');
?>

<section
    class="blog-related-articles relative overflow-hidden border-t border-on-primary/10 py-12 md:py-16 bg-llp-hero-terracotta"
    aria-label="<?php esc_attr_e('Related articles', 'nera-competitions'); ?>"
>
  <div class="absolute inset-0 z-0 pointer-events-none opacity-30" aria-hidden="true">
    <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-on-primary/10 blur-[120px]"></div>
    <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] rounded-full bg-indigo-400/20 blur-[120px]"></div>
  </div>
  <div
    class="absolute inset-0 pointer-events-none bg-[radial-gradient(ellipse_at_top_right,rgba(216,181,130,0.12)_0%,transparent_55%)]"
    aria-hidden="true"></div>

  <div class="container relative z-10 mx-auto max-w-7xl px-4">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-on-primary/80">
                    <?php esc_html_e('More to explore', 'nera-competitions'); ?>
                </p>
                <h2 class="font-heading mt-2 text-2xl font-bold text-on-primary md:text-3xl">
                    <?php esc_html_e('Related Articles', 'nera-competitions'); ?>
                </h2>
            </div>
            <a
                href="<?php echo esc_url($journal_url); ?>"
                class="inline-flex shrink-0 items-center text-sm font-semibold text-on-primary transition-colors hover:text-on-primary/70"
            >
                <?php esc_html_e('View More', 'nera-competitions'); ?>
                <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
            <?php
            while ($related_query->have_posts()) {
              $related_query->the_post();
              get_template_part('template-parts/blog/post-card', null, [
                'variant' => 'standard',
              ]);
            }
            wp_reset_postdata();
            ?>
        </div>
    </div>
</section>
