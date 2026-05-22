<?php
/**
 * The template for displaying all pages — Live Life Prizes override
 *
 * Renders the parent shared page-hero band + a Tailwind .prose content
 * container. Preserves the parent's account-page (logged-out) hero branch
 * and the cart/checkout !py-0 modifier so WooCommerce routes are untouched.
 *
 * @package Nera_Competitions
 */

if (!defined('ABSPATH')) {
  exit();
}

get_header();
?>

<main id="primary" class="site-main bg-background-secondary min-h-screen<?php echo (function_exists(
  'is_cart',
) &&
  is_cart()) ||
(function_exists('is_checkout') && is_checkout())
  ? ' !py-0'
  : ''; ?>">

    <?php while (have_posts()):
      the_post(); ?>

        <?php if (
          !is_front_page() &&
          !(function_exists('is_cart') && is_cart()) &&
          !(function_exists('is_checkout') && is_checkout()) &&
          !(function_exists('is_account_page') && is_account_page())
        ):
          get_template_part('template-parts/components/shared/page-hero', null, [
            'title' => get_the_title(),
            'variant' => 'default',
          ]);
        endif; ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <?php if (has_post_thumbnail() && !is_front_page()): ?>
                <div class="w-full aspect-[21/9] overflow-hidden">
                    <?php the_post_thumbnail('full', ['class' => 'w-full h-full object-cover']); ?>
                </div>
            <?php endif; ?>

            <?php if (
              !(function_exists('is_checkout') && is_checkout()) &&
              !(function_exists('is_cart') && is_cart()) &&
              !(function_exists('is_account_page') && is_account_page())
            ): ?>
                <div class="container mx-auto max-w-4xl px-4 py-10 md:py-14">
                    <div
                      class="prose prose-lg max-w-none text-text-secondary prose-p:text-text-secondary prose-headings:font-heading prose-headings:text-text-primary [&_h2]:text-text-primary [&_h3]:text-text-primary [&_h4]:text-text-primary prose-a:text-accent prose-a:no-underline hover:prose-a:underline prose-strong:text-text-primary [&_li]:text-text-secondary [&_blockquote]:border-on-primary/25 [&_blockquote]:text-text-secondary prose-ul:list-disc prose-ul:list-inside [&_ul>li::marker]:text-text-secondary">
                        <?php the_content(); ?>
                    </div>

                    <?php wp_link_pages([
                      'before' =>
                        '<div class="page-links mt-8 py-4 border-t border-on-primary/15"><span class="text-text-primary font-semibold mr-4">' .
                        esc_html__('Pages:', 'nera-competitions') .
                        '</span>',
                      'after' => '</div>',
                      'link_before' =>
                        '<span class="px-3 py-1 rounded border border-on-primary/20 bg-on-primary/5 text-text-primary hover:bg-on-primary/10 transition-colors">',
                      'link_after' => '</span>',
                    ]); ?>
                </div>
            <?php else: ?>
                <?php the_content(); ?>
                <?php wp_link_pages(); ?>
            <?php endif; ?>

        </article>

        <?php if (comments_open() || get_comments_number()) {
          echo '<div class="container mx-auto px-4 pb-12"><div class="max-w-4xl mx-auto bg-surface rounded-2xl p-8 shadow-sm">';
          comments_template();
          echo '</div></div>';
        } ?>

    <?php
    endwhile; ?>

</main>

<?php get_footer();
