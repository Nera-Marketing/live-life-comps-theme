<?php
/**
 * Cart Empty State Template Part — Live Life Prizes override
 *
 * @package Live_Life_Prizes
 */

if (!defined('ABSPATH')) {
  exit();
} ?>

<div
  class="nera-cart-empty-state w-full max-w-2xl mx-auto border-0 shadow-2xl shadow-primary/5 bg-surface/80 backdrop-blur-sm rounded-3xl p-12 overflow-hidden relative">

  <!-- Decorative Background Elements -->
  <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-transparent via-primary/30 to-transparent"></div>
  <div class="absolute -top-24 -right-24 w-64 h-64 bg-primary/5 rounded-full blur-3xl"></div>
  <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-primary/5 rounded-full blur-3xl"></div>

  <div class="relative z-10 flex flex-col items-center justify-center">

    <!-- Icon with Gradient Glow -->
    <div class="relative mb-8 group">
      <div
        class="absolute inset-0 bg-gradient-to-tr from-primary to-primary rounded-full blur-xl opacity-20 group-hover:opacity-30 transition-opacity duration-500 animate-pulse-slow">
      </div>
      <div
        class="relative w-20 h-20 bg-gradient-to-br from-surface to-gray-50 rounded-full flex items-center justify-center border border-gray-100 shadow-xl shadow-primary/10 animate-float">
        <span
          class="material-symbols-outlined !text-2xl text-transparent bg-clip-text bg-gradient-to-br from-primary to-primary">shopping_cart_off</span>
      </div>
    </div>

    <!-- Main Heading -->
    <h2 class="text-3xl font-bold text-text-primary mb-10 text-center tracking-tight">
      <?php _e('Your cart is currently empty', 'nera-competitions'); ?>
    </h2>

    <!-- Call to Action -->
    <a href="<?php echo esc_url(
      apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop')),
    ); ?>"
      class="group relative inline-flex items-center justify-center px-8 py-4 rounded-xl bg-gradient-to-r from-primary to-primary text-white font-bold text-base md:text-lg shadow-lg shadow-primary/30 overflow-hidden transition-all duration-300 hover:shadow-xl hover:shadow-primary/40 hover:-translate-y-1">

      <!-- Shine Effect -->
      <span
        class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-shimmer"></span>

      <span class="relative z-10"><?php _e(
        'Browse our current prizes',
        'nera-competitions',
      ); ?></span>
    </a>
  </div>

  <!-- Trust Badges (Refined) -->
  <div class="mt-12 pt-10 border-t border-gray-100/80 relative z-10 w-full">
    <div class="flex flex-row justify-center items-center gap-6 w-full text-center">

      <div class="flex flex-col items-center gap-2 group cursor-default">
        <div
          class="llp-cart-trust-icon llp-cart-trust-icon--secure p-2 bg-info-bg rounded-full text-primary mb-1 transition-transform group-hover:scale-110 duration-300">
          <span class="material-symbols-outlined text-xl">lock</span>
        </div>
        <div>
          <h4 class="font-bold text-sm text-text-primary"><?php _e(
            'Secure Payment',
            'nera-competitions',
          ); ?></h4>
          <p class="text-xs text-text-secondary mt-0.5"><?php _e(
            '256-bit SSL Encrypted',
            'nera-competitions',
          ); ?></p>
        </div>
      </div>

      <div class="flex flex-col items-center gap-2 group cursor-default">
        <div
          class="llp-cart-trust-icon llp-cart-trust-icon--winners p-2 bg-secondary rounded-full text-accent mb-1 transition-transform group-hover:scale-110 duration-300">
          <span class="material-symbols-outlined text-xl">emoji_events</span>
        </div>
        <div>
          <h4 class="font-bold text-sm text-text-primary"><?php _e(
            'Real Winners',
            'nera-competitions',
          ); ?></h4>
          <p class="text-xs text-text-secondary mt-0.5"><?php _e(
            'Verified prize draws',
            'nera-competitions',
          ); ?>
          </p>
        </div>
      </div>

    </div>
  </div>
</div>
