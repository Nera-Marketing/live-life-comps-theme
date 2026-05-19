<?php
/**
 * Template Name: Nera About Us
 * Template Post Type: page
 *
 * About page with hero, narrative, two story columns, and CTA. Content via ACF.
 *
 * @package Nera_Competitions
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
  exit(); // Exit if accessed directly
}

get_header();

$hero_eyebrow = get_field('about_hero_eyebrow') ?: __('About us', 'nera-competitions');
$title = get_field('about_title') ?: get_the_title();
$hero_tagline = get_field('about_hero_tagline') ?: __(
  'Building a community rooted in transparency, trust, and exciting opportunities for everyone.',
  'nera-competitions',
);
$hero_image = get_field('about_hero_image');
$narrative = get_field('about_narrative');

$story_left_title = get_field('about_story_left_title') ?: __('Our story', 'nera-competitions');
$story_left_content = get_field('about_story_left_content');
$story_right_title = get_field('about_story_right_title') ?: __('What drives us', 'nera-competitions');
$story_right_content = get_field('about_story_right_content');

$cta_heading = get_field('about_cta_heading') ?: __('Join the community', 'nera-competitions');
$cta_description = get_field('about_cta_description') ?: __(
  'Be part of a transparent, supportive journey where everyone has a chance to win.',
  'nera-competitions',
);
$cta_primary_text = get_field('about_cta_primary_btn_text') ?: __('Explore competitions', 'nera-competitions');
$cta_primary_url = get_field('about_cta_primary_btn_url') ?: home_url('/shop/');
$cta_secondary_text = get_field('about_cta_secondary_btn_text') ?: __('Get in touch', 'nera-competitions');
$cta_secondary_url = get_field('about_cta_secondary_btn_url') ?: home_url('/contact/');
?>

<main id="main" class="nera-about-us-page bg-background-light text-text-primary" role="main">

  <section
    class="relative min-h-[70vh] flex items-center justify-center overflow-hidden py-16 lg:py-24 bg-llp-hero-terracotta"
    aria-labelledby="about-us-hero-heading">
    <div class="absolute inset-0 z-0 pointer-events-none opacity-30">
      <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-on-primary/10 blur-[120px]"></div>
      <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] rounded-full bg-indigo-400/20 blur-[120px]"></div>
    </div>
    <div class="absolute inset-0 pointer-events-none bg-[radial-gradient(ellipse_at_top_right,rgba(216,181,130,0.12)_0%,transparent_55%)]"></div>

    <!-- Decorative sun motif — echoes the hand-drawn brand logo -->
    <div class="absolute top-1/2 right-[8%] -translate-y-1/2 w-64 h-64 lg:w-80 lg:h-80 opacity-[0.07] pointer-events-none z-0" aria-hidden="true">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 240 240" fill="none">
        <circle cx="120" cy="120" r="22" fill="#d8b582"/>
        <path d="M120 97 L119 18" stroke="#d8b582" stroke-width="3" stroke-linecap="round"/>
        <path d="M120 143 L121 222" stroke="#d8b582" stroke-width="3" stroke-linecap="round"/>
        <path d="M143 120 L222 121" stroke="#d8b582" stroke-width="3" stroke-linecap="round"/>
        <path d="M97 120 L18 119" stroke="#d8b582" stroke-width="3" stroke-linecap="round"/>
        <path d="M136 104 L199 41" stroke="#d8b582" stroke-width="2.5" stroke-linecap="round"/>
        <path d="M104 136 L41 199" stroke="#d8b582" stroke-width="2.5" stroke-linecap="round"/>
        <path d="M104 104 L41 41" stroke="#d8b582" stroke-width="2.5" stroke-linecap="round"/>
        <path d="M136 136 L199 199" stroke="#d8b582" stroke-width="2.5" stroke-linecap="round"/>
        <path d="M129 99 L152 48" stroke="#d8b582" stroke-width="1.5" stroke-linecap="round"/>
        <path d="M141 111 L192 88" stroke="#d8b582" stroke-width="1.5" stroke-linecap="round"/>
        <path d="M141 129 L192 152" stroke="#d8b582" stroke-width="1.5" stroke-linecap="round"/>
        <path d="M129 141 L152 192" stroke="#d8b582" stroke-width="1.5" stroke-linecap="round"/>
        <path d="M111 141 L88 192" stroke="#d8b582" stroke-width="1.5" stroke-linecap="round"/>
        <path d="M99 129 L48 152" stroke="#d8b582" stroke-width="1.5" stroke-linecap="round"/>
        <path d="M99 111 L48 88" stroke="#d8b582" stroke-width="1.5" stroke-linecap="round"/>
        <path d="M111 99 L88 48" stroke="#d8b582" stroke-width="1.5" stroke-linecap="round"/>
      </svg>
    </div>

    <div class="max-w-7xl mx-auto px-4 lg:px-8 relative z-10 w-full">
      <div class="grid lg:grid-cols-2 gap-10 lg:gap-12 items-center">
        <div data-aos="fade-up">
          <span
            class="inline-block text-on-primary/90 uppercase tracking-[0.2em] text-xs font-semibold mb-6 pb-1 border-b border-on-primary/25">
            <?php echo esc_html($hero_eyebrow); ?>
          </span>
          <h1 id="about-us-hero-heading" class="font-heading text-4xl sm:text-5xl lg:text-6xl leading-tight mb-6 text-on-primary">
            <?php echo esc_html($title); ?>
          </h1>
          <div class="w-20 h-1 bg-on-primary/80 mb-8 rounded-full" aria-hidden="true"></div>
          <p class="text-lg sm:text-xl leading-relaxed font-light italic max-w-xl text-on-primary/85">
            <?php echo esc_html($hero_tagline); ?>
          </p>
        </div>

        <div class="relative" data-aos="fade-left" data-aos-delay="150">
          <?php if ($hero_image) : ?>
            <?php
            $img_url = is_array($hero_image) ? ($hero_image['url'] ?? '') : $hero_image;
            $img_alt = is_array($hero_image) ? ($hero_image['alt'] ?? '') : '';
            ?>
            <div class="aspect-[4/5] rounded-2xl overflow-hidden shadow-[0_25px_50px_-12px_rgba(0,0,0,0.35)] relative ring-1 ring-inset ring-on-primary/10">
              <img
                src="<?php echo esc_url($img_url); ?>"
                alt="<?php echo esc_attr($img_alt); ?>"
                class="w-full !h-full object-cover"
                loading="eager"
                decoding="async" />
            </div>
          <?php else : ?>
            <div
              class="aspect-[4/5] rounded-2xl flex items-center justify-center relative overflow-hidden bg-on-primary/10 ring-1 ring-on-primary/15">
              <div class="absolute inset-0 bg-gradient-to-tr from-on-primary/5 to-transparent"></div>
              <span class="text-sm italic text-on-primary/40 relative z-[1]">
                <?php esc_html_e('Image placeholder', 'nera-competitions'); ?>
              </span>
            </div>
          <?php endif; ?>

          <div
            class="absolute -bottom-4 -right-4 w-full h-full rounded-2xl -z-10 hidden lg:block border border-on-primary/20"
            aria-hidden="true"></div>
        </div>
      </div>
    </div>

    <?php get_template_part('template-parts/llp-organic-wave', null, ['position' => 'bottom', 'context' => 'hero']); ?>
  </section>

  <section class="py-16 lg:py-24 bg-gradient-to-b from-[#fffdfb] to-[#faf7f2]" aria-labelledby="about-us-narrative">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
      <div id="about-us-narrative" class="sr-only"><?php esc_html_e('Our narrative', 'nera-competitions'); ?></div>
      <div data-aos="fade-up">
        <?php if ($narrative) : ?>
          <div
            class="prose prose-lg max-w-none prose-headings:font-heading prose-headings:text-text-primary prose-p:text-text-secondary prose-a:text-accent prose-strong:text-text-primary [&_blockquote]:border-on-primary/25 [&_blockquote]:text-text-secondary">
            <?php echo wp_kses_post($narrative); ?>
          </div>
        <?php else : ?>
          <p class="text-center italic text-text-secondary/70">
            <?php esc_html_e('More about us is coming soon…', 'nera-competitions'); ?>
          </p>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <section class="py-16 lg:py-24 bg-llp-hero-terracotta relative overflow-hidden" aria-labelledby="about-us-stories">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
      <div class="grid md:grid-cols-2 gap-10 lg:gap-12">
        <div
          class="bg-surface p-8 lg:p-12 rounded-3xl border border-on-primary/15 shadow-lg transition-all duration-300 hover:border-primary/40 hover:shadow-xl hover:-translate-y-0.5 group"
          data-aos="fade-right">
          <div class="flex items-center gap-4 mb-6">
            <div
              class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary transition-all duration-300 group-hover:bg-primary group-hover:text-on-primary">
              <span class="material-symbols-outlined text-2xl" aria-hidden="true">groups</span>
            </div>
            <h2 class="font-heading text-2xl lg:text-3xl text-text-primary">
              <?php echo esc_html($story_left_title); ?>
            </h2>
          </div>
          <div class="text-text-secondary leading-relaxed max-w-none [&_a]:text-accent [&_a]:underline">
            <?php if ($story_left_content) : ?>
              <?php echo wp_kses_post($story_left_content); ?>
            <?php else : ?>
              <p><?php esc_html_e('We will share more about our journey here.', 'nera-competitions'); ?></p>
            <?php endif; ?>
          </div>
        </div>

        <div
          class="bg-surface p-8 lg:p-12 rounded-3xl border border-on-primary/15 shadow-lg transition-all duration-300 hover:border-primary/40 hover:shadow-xl hover:-translate-y-0.5 group"
          data-aos="fade-left">
          <div class="flex items-center gap-4 mb-6">
            <div
              class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary transition-all duration-300 group-hover:bg-primary group-hover:text-on-primary">
              <span class="material-symbols-outlined text-2xl" aria-hidden="true">lightbulb</span>
            </div>
            <h2 class="font-heading text-2xl lg:text-3xl text-text-primary">
              <?php echo esc_html($story_right_title); ?>
            </h2>
          </div>
          <div class="text-text-secondary leading-relaxed max-w-none [&_a]:text-accent [&_a]:underline">
            <?php if ($story_right_content) : ?>
              <?php echo wp_kses_post($story_right_content); ?>
            <?php else : ?>
              <p><?php esc_html_e('Insights and values will appear here.', 'nera-competitions'); ?></p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-16 lg:py-24 text-center relative overflow-hidden bg-gradient-to-b from-[#faf7f2] to-[#fffdfb]" aria-labelledby="about-us-cta-heading">
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-primary/[0.06] to-transparent pointer-events-none"></div>
    <div class="max-w-3xl mx-auto px-4 lg:px-8 relative z-10" data-aos="zoom-in">
      <h2 id="about-us-cta-heading" class="font-heading text-3xl lg:text-4xl mb-6 text-text-primary">
        <?php echo esc_html($cta_heading); ?>
      </h2>
      <p class="text-lg text-text-secondary mb-10 leading-relaxed">
        <?php echo esc_html($cta_description); ?>
      </p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a
          href="<?php echo esc_url($cta_primary_url); ?>"
          class="inline-flex items-center justify-center px-8 py-4 bg-primary text-on-primary font-semibold rounded-2xl shadow-[0_10px_25px_-5px_rgba(155,80,57,0.35)] hover:opacity-95 hover:-translate-y-0.5 transition-all duration-200">
          <?php echo esc_html($cta_primary_text); ?>
        </a>
        <a
          href="<?php echo esc_url($cta_secondary_url); ?>"
          class="inline-flex items-center justify-center px-8 py-4 border-2 border-on-primary/30 text-text-primary font-semibold rounded-2xl hover:border-primary/50 hover:bg-surface transition-all duration-200">
          <?php echo esc_html($cta_secondary_text); ?>
        </a>
      </div>
    </div>
  </section>

</main>

<?php
get_footer();
