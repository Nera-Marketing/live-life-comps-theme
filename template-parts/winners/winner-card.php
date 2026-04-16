<?php
/**
 * Winner card — horizontal thumbnail + content (Live Life child override).
 *
 * @package Live_Life_Prizes
 */

if (!defined('ABSPATH')) {
    exit;
}

$winner = $args['winner'] ?? [];
$show_quotes = !empty($args['show_quotes']);

$name = $winner['name'] ?? '';
$prize = $winner['prize'] ?? '';
$date = $winner['date'] ?? '';
$quote = $winner['quote'] ?? '';
$image_url = $winner['image'] ?? '';
$category = $winner['category'] ?? 'live-draw';
$category_label = $winner['category_label'] ?? __('Live Draw', 'nera-competitions');
$badge_class = $category === 'instant-win' ? 'bg-accent' : 'bg-primary';
$left_border_class = $category === 'instant-win' ? 'border-l-accent' : 'border-l-primary';
$ring_class = $category === 'instant-win' ? 'ring-accent/40' : 'ring-primary/40';
$placeholder_gradient_class = $category === 'instant-win'
    ? 'from-accent/15 to-accent/5'
    : 'from-primary/15 to-primary/5';
$placeholder_icon_class = $category === 'instant-win' ? 'text-accent/50' : 'text-primary/50';
?>

<article
    class="llp-winner-card group relative h-full flex items-stretch gap-3 p-3 rounded-xl border border-gray-200/60 border-l-2 <?php echo esc_attr($left_border_class); ?>
           hover:-translate-y-1 hover:border-primary/50 hover:shadow-lg hover:shadow-primary/25
           transition-all duration-300 ease-out overflow-hidden"
    style="background: linear-gradient(135deg, #1e1c18 0%, #261f19 100%);"
>
    <div class="relative shrink-0 w-20 h-20 rounded-lg overflow-hidden bg-gray-100 ring-1 ring-inset <?php echo esc_attr($ring_class); ?>">
        <?php if ($image_url) : ?>
            <div
                class="w-full h-full bg-center bg-no-repeat bg-cover origin-center
                       group-hover:scale-110 group-hover:brightness-110 transition-transform duration-500 ease-out"
                style="background-image: url('<?php echo esc_url($image_url); ?>');"
                role="img"
                aria-hidden="true"
            ></div>
            <div
                class="pointer-events-none absolute inset-0 opacity-0 group-hover:opacity-100 bg-linear-to-tr from-white/10 to-transparent transition-opacity duration-500 ease-out"
                aria-hidden="true"
            ></div>
        <?php else : ?>
            <div class="w-full h-full flex items-center justify-center bg-linear-to-br <?php echo esc_attr($placeholder_gradient_class); ?>">
                <svg class="w-9 h-9 <?php echo esc_attr($placeholder_icon_class); ?>" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                    <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" />
                </svg>
            </div>
        <?php endif; ?>
    </div>

    <div class="flex flex-col min-w-0 flex-1 gap-1 justify-center py-0.5">
        <span class="inline-flex items-center gap-1 self-start <?php echo esc_attr($badge_class); ?> text-on-primary text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-widest shadow-sm">
            <span class="opacity-90" aria-hidden="true">&#9679;</span>
            <?php echo esc_html($category_label); ?>
        </span>

        <h3 class="text-sm font-bold text-text-primary truncate font-heading leading-snug transition-colors duration-200 group-hover:text-on-primary">
            <?php echo esc_html($name); ?>
        </h3>

        <p class="flex items-center gap-1.5 min-w-0 text-xs text-accent font-semibold truncate transition-colors duration-200 group-hover:text-on-primary">
            <svg class="w-3 h-3 shrink-0 text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.952.317-2.91.531A1.25 1.25 0 0 0 2.25 6v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM12 4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v17.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.875z" />
            </svg>
            <span class="truncate"><?php echo esc_html($prize); ?></span>
        </p>

        <?php if ($date) : ?>
            <div class="flex items-center gap-1.5 text-xs text-text-secondary">
                <span class="material-symbols-outlined text-[12px] shrink-0 text-primary" aria-hidden="true">calendar_today</span>
                <span><?php echo esc_html($date); ?></span>
            </div>
        <?php endif; ?>

        <?php if ($show_quotes && !empty($quote)) : ?>
            <div class="hidden sm:block pt-2 mt-1 border-t border-gray-200">
                <p class="text-xs text-text-secondary italic line-clamp-2">
                    <?php echo esc_html($quote); ?>
                </p>
            </div>
        <?php endif; ?>
    </div>
</article>
